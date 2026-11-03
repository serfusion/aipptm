#!/usr/bin/env bash
set -euo pipefail

DOMAIN="aipptm.org"
WWW_DOMAIN="www.${DOMAIN}"
JOURNAL_DOMAIN="journal.${DOMAIN}"
JOURNAL_WWW_DOMAIN="www.journal.${DOMAIN}"
OJS_VERSION="3.5.0-5"
OJS_URL="https://pkp.sfu.ca/ojs/download/ojs-${OJS_VERSION}.tar.gz"
PHP_VERSION="8.3"
WP_ROOT="/var/www/aipptm"
OJS_ROOT="/var/www/journal"
OJS_FILES="/var/www/ojs-files"
CRED_FILE="/root/aipptm-kredensial.txt"
BACKUP_DIR="/var/backups/aipptm"
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
THEME_ZIP="${SCRIPT_DIR}/aipptm-tema.zip"
OJS_THEME_TGZ="${SCRIPT_DIR}/aipptm-ojs-tema.tar.gz"
BOOTSTRAP3_VERSION="v3_5_0-1"
BOOTSTRAP3_URL="https://github.com/pkp/bootstrap3/releases/download/${BOOTSTRAP3_VERSION}/bootstrap3-${BOOTSTRAP3_VERSION}.tar.gz"

EMAIL=""
OJS_ADMIN=""
OJS_SANDI=""
OJS_TEMA=""
OJS_VARIAN=""
MODE="full"
SKIP_SSL=0

log() { printf '\n\033[1;31m==>\033[0m \033[1m%s\033[0m\n' "$*"; }
warn() { printf '\033[1;33mPERINGATAN:\033[0m %s\n' "$*" >&2; }
die() { printf '\033[1;31mGAGAL:\033[0m %s\n' "$*" >&2; exit 1; }

usage() {
	cat <<-EOF
	Pemakaian:
	  sudo bash setup-server.sh --email admin@${DOMAIN}
	  sudo bash setup-server.sh --email admin@${DOMAIN} --ssl-only
	  sudo bash setup-server.sh --skip-ssl
	  sudo bash setup-server.sh --ojs-finalize
	  sudo bash setup-server.sh --ojs-perbaiki
	  sudo bash setup-server.sh --ojs-perbaiki --admin NAMA_PENGGUNA_ATAU_EMAIL
	  sudo bash setup-server.sh --ojs-perbaiki --admin NAMA_PENGGUNA_ATAU_EMAIL --sandi 'SandiBaru123'
	  sudo bash setup-server.sh --ojs-perbaiki --tema bootstrap3 [--varian simplex]
	  sudo bash setup-server.sh --ojs-perbaiki --tema aipptm|default
	EOF
	exit "${1:-0}"
}

parse_args() {
	while [ $# -gt 0 ]; do
		case "$1" in
			--email) EMAIL="${2:-}"; shift 2 ;;
			--ssl-only) MODE="ssl"; shift ;;
			--ojs-finalize) MODE="ojs-finalize"; shift ;;
			--ojs-perbaiki) MODE="ojs-perbaiki"; shift ;;
			--admin) OJS_ADMIN="${2:-}"; shift 2 ;;
			--sandi) OJS_SANDI="${2:-}"; shift 2 ;;
			--tema) OJS_TEMA="${2:-}"; shift 2 ;;
			--varian) OJS_VARIAN="${2:-}"; shift 2 ;;
			--skip-ssl) SKIP_SSL=1; shift ;;
			-h|--help) usage 0 ;;
			*) warn "Opsi tidak dikenal: $1"; usage 1 ;;
		esac
	done
	if [ "$MODE" != "ojs-finalize" ] && [ "$MODE" != "ojs-perbaiki" ] && [ "$SKIP_SSL" -eq 0 ] && [ -z "$EMAIL" ]; then
		die "Isi email admin untuk notifikasi sertifikat HTTPS, contoh: --email admin@${DOMAIN}"
	fi
}

require_root_ubuntu() {
	[ "$(id -u)" -eq 0 ] || die "Jalankan dengan sudo: sudo bash $0 ..."
	# shellcheck disable=SC1091
	. /etc/os-release
	[ "${ID:-}" = "ubuntu" ] || die "Skrip ini dibuat untuk Ubuntu 24.04 LTS (terdeteksi: ${PRETTY_NAME:-tidak diketahui})."
	case "${VERSION_ID:-}" in 24.04|26.04) ;; *) warn "Diuji untuk Ubuntu 24.04; terdeteksi ${PRETTY_NAME}. Lanjut dengan risiko sendiri." ;; esac
}

random_password() {
	openssl rand -base64 48 | tr -dc 'A-Za-z0-9' | head -c 28
}

ensure_swap() {
	if [ -n "$(swapon --show --noheadings)" ]; then
		return
	fi
	local mem_kb
	mem_kb="$(awk '/MemTotal/ {print $2}' /proc/meminfo)"
	if [ "$mem_kb" -lt 4000000 ]; then
		log "Membuat swap 2 GB (RAM VM kecil)"
		fallocate -l 2G /swapfile
		chmod 600 /swapfile
		mkswap /swapfile >/dev/null
		swapon /swapfile
		grep -q '^/swapfile ' /etc/fstab || echo '/swapfile none swap sw 0 0' >> /etc/fstab
	fi
}

install_packages() {
	log "Memasang Apache, PHP ${PHP_VERSION}, MariaDB, Certbot"
	export DEBIAN_FRONTEND=noninteractive
	apt-get update -q
	apt-get install -y -q \
		apache2 mariadb-server libapache2-mod-php \
		php-cli php-mysql php-gd php-intl php-mbstring php-xml php-zip php-curl php-bcmath php-imagick \
		certbot python3-certbot-apache unattended-upgrades cron unzip curl openssl
	local installed
	installed="$(php -r 'echo PHP_MAJOR_VERSION.".".PHP_MINOR_VERSION;')"
	if [ "$installed" != "$PHP_VERSION" ]; then
		warn "PHP terpasang ${installed}, bukan ${PHP_VERSION}. Skrip memakai PHP ${installed}."
		PHP_VERSION="$installed"
	fi
	php -r 'exit(version_compare(PHP_VERSION, "8.2", ">=") ? 0 : 1);' || die "OJS 3.5 membutuhkan PHP 8.2 atau lebih baru."
}

configure_php() {
	log "Mengatur batas unggah & memori PHP"
	local ini
	for sapi in apache2 cli; do
		ini="/etc/php/${PHP_VERSION}/${sapi}/conf.d/99-aipptm.ini"
		cat > "$ini" <<-'EOF'
			; Diatur oleh setup-server.sh AIPPTM
			upload_max_filesize = 64M
			post_max_size = 64M
			memory_limit = 256M
			max_execution_time = 120
			max_input_vars = 3000
			date.timezone = Asia/Jakarta
			expose_php = Off
		EOF
	done
}

load_or_create_credentials() {
	if [ -f "$CRED_FILE" ]; then
		# shellcheck disable=SC1090
		. "$CRED_FILE"
		return
	fi
	log "Membuat kata sandi database baru (${CRED_FILE})"
	WP_DB_NAME="wp_aipptm"
	WP_DB_USER="wp_aipptm"
	WP_DB_PASS="$(random_password)"
	OJS_DB_NAME="ojs_aipptm"
	OJS_DB_USER="ojs_aipptm"
	OJS_DB_PASS="$(random_password)"
	(
		umask 077
		cat > "$CRED_FILE" <<-EOF
			# Kredensial database AIPPTM
			WP_DB_NAME="${WP_DB_NAME}"
			WP_DB_USER="${WP_DB_USER}"
			WP_DB_PASS="${WP_DB_PASS}"
			OJS_DB_NAME="${OJS_DB_NAME}"
			OJS_DB_USER="${OJS_DB_USER}"
			OJS_DB_PASS="${OJS_DB_PASS}"
		EOF
	)
}

setup_databases() {
	log "Menyiapkan database WordPress dan OJS"
	systemctl enable --now mariadb >/dev/null
	mysql <<-EOF
		CREATE DATABASE IF NOT EXISTS \`${WP_DB_NAME}\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
		CREATE DATABASE IF NOT EXISTS \`${OJS_DB_NAME}\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
		CREATE USER IF NOT EXISTS '${WP_DB_USER}'@'localhost' IDENTIFIED BY '${WP_DB_PASS}';
		CREATE USER IF NOT EXISTS '${OJS_DB_USER}'@'localhost' IDENTIFIED BY '${OJS_DB_PASS}';
		GRANT ALL PRIVILEGES ON \`${WP_DB_NAME}\`.* TO '${WP_DB_USER}'@'localhost';
		GRANT ALL PRIVILEGES ON \`${OJS_DB_NAME}\`.* TO '${OJS_DB_USER}'@'localhost';
		FLUSH PRIVILEGES;
	EOF
}

write_if_absent() {
	if [ -e "$1" ]; then
		cat > /dev/null
		echo "   (sudah ada, tidak diubah: $1)"
	else
		cat > "$1"
	fi
}

download() {
	curl -fsSL --retry 3 -o "$2" "$1" || die "Gagal mengunduh $1"
}

install_wordpress() {
	if [ -f "${WP_ROOT}/wp-settings.php" ]; then
		log "WordPress sudah ada di ${WP_ROOT} (dilewati)"
	else
		log "Mengunduh WordPress terbaru"
		local tmp
		tmp="$(mktemp -d)"
		download https://wordpress.org/latest.tar.gz "${tmp}/wordpress.tar.gz"
		download https://wordpress.org/latest.tar.gz.sha1 "${tmp}/wordpress.tar.gz.sha1"
		(cd "$tmp" && echo "$(cat wordpress.tar.gz.sha1)  wordpress.tar.gz" | sha1sum -c --quiet) \
			|| die "Checksum WordPress tidak cocok; unduhan mungkin rusak."
		mkdir -p "$WP_ROOT"
		tar -xzf "${tmp}/wordpress.tar.gz" -C "$WP_ROOT" --strip-components=1
		rm -rf "$tmp"
	fi

	if [ ! -f "${WP_ROOT}/wp-config.php" ]; then
		log "Membuat wp-config.php"
		local salts="" key
		for key in AUTH_KEY SECURE_AUTH_KEY LOGGED_IN_KEY NONCE_KEY AUTH_SALT SECURE_AUTH_SALT LOGGED_IN_SALT NONCE_SALT; do
			salts+="define( '${key}', '$(openssl rand -base64 48 | tr -d '\n')' );"$'\n'
		done
		cat > "${WP_ROOT}/wp-config.php" <<-EOF
			<?php
			// Dibuat oleh setup-server.sh AIPPTM.
			define( 'DB_NAME', '${WP_DB_NAME}' );
			define( 'DB_USER', '${WP_DB_USER}' );
			define( 'DB_PASSWORD', '${WP_DB_PASS}' );
			define( 'DB_HOST', 'localhost' );
			define( 'DB_CHARSET', 'utf8mb4' );
			define( 'DB_COLLATE', '' );

			${salts}
			\$table_prefix = 'wp_';

			define( 'WP_DEBUG', false );
			define( 'FS_METHOD', 'direct' );
			define( 'DISALLOW_FILE_EDIT', true );

			if ( ! defined( 'ABSPATH' ) ) {
				define( 'ABSPATH', __DIR__ . '/' );
			}
			require_once ABSPATH . 'wp-settings.php';
		EOF
	fi

	if [ -f "$THEME_ZIP" ] && [ ! -d "${WP_ROOT}/wp-content/themes/aipptm" ]; then
		log "Memasang tema AIPPTM dari $(basename "$THEME_ZIP")"
		unzip -q "$THEME_ZIP" -d "${WP_ROOT}/wp-content/themes/"
	fi

	chown -R www-data:www-data "$WP_ROOT"
	chmod 640 "${WP_ROOT}/wp-config.php"
}

install_ojs() {
	if [ -f "${OJS_ROOT}/index.php" ]; then
		log "OJS sudah ada di ${OJS_ROOT} (dilewati)"
	else
		log "Mengunduh OJS ${OJS_VERSION} (±120 MB)"
		local tmp
		tmp="$(mktemp -d)"
		download "$OJS_URL" "${tmp}/ojs.tar.gz"
		mkdir -p "$OJS_ROOT"
		tar -xzf "${tmp}/ojs.tar.gz" -C "$OJS_ROOT" --strip-components=1
		rm -rf "$tmp"
	fi
	if [ -f "$OJS_THEME_TGZ" ]; then
		log "Memasang/memperbarui tema OJS AIPPTM dari $(basename "$OJS_THEME_TGZ")"
		rm -rf "${OJS_ROOT}/plugins/themes/aipptm"
		tar -xzf "$OJS_THEME_TGZ" -C "${OJS_ROOT}/plugins/themes/"
		if grep -q '^installed = On' "${OJS_ROOT}/config.inc.php" 2>/dev/null; then
			(cd "$OJS_ROOT" && php lib/pkp/tools/installPluginVersion.php plugins/themes/aipptm/version.xml) || warn "Daftarkan tema lewat Website > Plugins > Upload A New Plugin."
			rm -rf "${OJS_ROOT}"/cache/*.css "${OJS_ROOT}"/cache/t_compile/*
		fi
	fi
	mkdir -p "$OJS_FILES"
	chown -R www-data:www-data "$OJS_ROOT" "$OJS_FILES"
	chmod 750 "$OJS_FILES"
}

configure_apache() {
	log "Mengatur Apache untuk ${WWW_DOMAIN} dan ${JOURNAL_DOMAIN}"
	write_if_absent /etc/apache2/sites-available/aipptm.conf <<-EOF
		<VirtualHost *:80>
		    ServerName ${WWW_DOMAIN}
		    ServerAlias ${DOMAIN}
		    DocumentRoot ${WP_ROOT}
		    <Directory ${WP_ROOT}>
		        AllowOverride All
		        Require all granted
		    </Directory>
		    ErrorLog \${APACHE_LOG_DIR}/aipptm-error.log
		    CustomLog \${APACHE_LOG_DIR}/aipptm-access.log combined
		</VirtualHost>
	EOF
	write_if_absent /etc/apache2/sites-available/journal.conf <<-EOF
		<VirtualHost *:80>
		    ServerName ${JOURNAL_DOMAIN}
		    DocumentRoot ${OJS_ROOT}
		    <Directory ${OJS_ROOT}>
		        AllowOverride All
		        Require all granted
		    </Directory>
		    <FilesMatch "^config\.(inc|TEMPLATE\.inc)\.php$">
		        Require all denied
		    </FilesMatch>
		    ErrorLog \${APACHE_LOG_DIR}/journal-error.log
		    CustomLog \${APACHE_LOG_DIR}/journal-access.log combined
		</VirtualHost>
	EOF
	write_if_absent /etc/apache2/sites-available/journal-www.conf <<-EOF
		<VirtualHost *:80>
		    ServerName ${JOURNAL_WWW_DOMAIN}
		    Redirect permanent / https://${JOURNAL_DOMAIN}/
		</VirtualHost>
	EOF
	sed -i 's/^ServerTokens .*/ServerTokens Prod/; s/^ServerSignature .*/ServerSignature Off/' /etc/apache2/conf-available/security.conf
	a2enmod -q rewrite headers expires ssl >/dev/null
	a2dissite -q 000-default >/dev/null 2>&1 || true
	a2ensite -q aipptm journal journal-www >/dev/null
	apache2ctl configtest
	systemctl reload apache2
}

configure_backups() {
	log "Menjadwalkan backup database harian (${BACKUP_DIR}, disimpan 14 hari)"
	mkdir -p "$BACKUP_DIR"
	chmod 700 "$BACKUP_DIR"
	cat > /usr/local/sbin/aipptm-backup <<-EOF
		#!/usr/bin/env bash
		set -euo pipefail
		umask 077
		stamp="\$(date +%Y%m%d-%H%M)"
		for db in ${WP_DB_NAME} ${OJS_DB_NAME}; do
		    mysqldump --single-transaction --quick "\$db" | gzip > "${BACKUP_DIR}/\${db}-\${stamp}.sql.gz"
		done
		find "${BACKUP_DIR}" -name '*.sql.gz' -mtime +14 -delete
	EOF
	chmod 700 /usr/local/sbin/aipptm-backup
	echo "30 2 * * * root /usr/local/sbin/aipptm-backup" > /etc/cron.d/aipptm-backup
}

configure_auto_updates() {
	log "Mengaktifkan update keamanan Ubuntu otomatis"
	write_if_absent /etc/apt/apt.conf.d/20auto-upgrades <<-'EOF'
		APT::Periodic::Update-Package-Lists "1";
		APT::Periodic::Unattended-Upgrade "1";
	EOF
}

external_ip() {
	curl -fsS -H 'Metadata-Flavor: Google' \
		http://metadata.google.internal/computeMetadata/v1/instance/network-interfaces/0/access-configs/0/external-ip 2>/dev/null || true
}

points_here() {
	[ -n "$2" ] && getent ahostsv4 "$1" | awk '{print $1}' | grep -qx "$2"
}

request_certificates() {
	log "Memasang sertifikat HTTPS (Let's Encrypt)"
	local ip
	ip="$(external_ip)"
	[ -n "$ip" ] || warn "IP eksternal VM tidak terbaca dari metadata Google; pemeriksaan DNS dilewati."

	local site domains d
	for site in "${WWW_DOMAIN} ${DOMAIN}" "${JOURNAL_DOMAIN} ${JOURNAL_WWW_DOMAIN}"; do
		domains=()
		for d in $site; do
			if [ -z "$ip" ] || points_here "$d" "$ip"; then
				domains+=(-d "$d")
			else
				warn "${d} belum mengarah ke IP ${ip}; domain ini dilewati. Cek DNS lalu jalankan ulang dengan --ssl-only."
			fi
		done
		if [ "${#domains[@]}" -gt 0 ]; then
			certbot --apache --non-interactive --agree-tos -m "$EMAIL" --redirect "${domains[@]}" \
				|| warn "Certbot gagal untuk: ${site}. Pastikan port 80/443 terbuka di firewall Google Cloud."
		fi
	done
}

ojs_finalize() {
	local cfg="${OJS_ROOT}/config.inc.php"
	[ -f "$cfg" ] || die "Tidak menemukan ${cfg}."
	grep -q '^installed = On' "$cfg" || die "OJS belum diinstal. Selesaikan dulu wizard di https://${JOURNAL_DOMAIN}"

	log "Merapikan konfigurasi OJS (cadangan: ${cfg}.bak-$(date +%Y%m%d))"
	cp -p "$cfg" "${cfg}.bak-$(date +%Y%m%d)"
	sed -i "s|^allowed_hosts = ''\$|allowed_hosts = '[\"${JOURNAL_DOMAIN}\"]'|" "$cfg"
	if [ -d "/etc/letsencrypt/live/${JOURNAL_DOMAIN}" ]; then
		sed -i "s|^base_url = \"http://${JOURNAL_DOMAIN}\"\$|base_url = \"https://${JOURNAL_DOMAIN}\"|" "$cfg"
		sed -i 's|^force_ssl = Off$|force_ssl = On|' "$cfg"
	else
		warn "Sertifikat HTTPS ${JOURNAL_DOMAIN} belum ada; force_ssl dibiarkan Off. Jalankan --ssl-only lalu --ojs-finalize lagi."
	fi
	sed -i 's|^task_runner = On$|task_runner = Off|' "$cfg"
	echo "* * * * * www-data cd ${OJS_ROOT} && php lib/pkp/tools/scheduler.php run >/dev/null 2>&1" > /etc/cron.d/ojs-aipptm
	chown www-data:www-data "$cfg"
	chmod 640 "$cfg"
	grep -E '^(allowed_hosts|force_ssl|task_runner|base_url) ' "$cfg" || true
	log "Selesai. Lanjutkan pengaturan email (SMTP) dan login Google OJS sesuai PANDUAN."
}

ojs_sql() {
	mysql --batch --skip-column-names "$OJS_DB" -e "$1"
}

sql_str() {
	printf "'%s'" "$(printf '%s' "$1" | sed "s/\\\\/\\\\\\\\/g; s/'/''/g")"
}

# Perbaikan OJS tanpa wizard: aktifkan tema (AIPPTM, Bootstrap3, atau Default) di semua jurnal dan beri hak
# Administrator Situs. Aman dijalankan berulang kali.
ojs_perbaiki() {
	local cfg="${OJS_ROOT}/config.inc.php"
	[ -f "$cfg" ] || die "Tidak menemukan ${cfg}."
	grep -q '^installed = On' "$cfg" || die "OJS belum diinstal. Selesaikan dulu wizard di https://${JOURNAL_DOMAIN}"
	OJS_DB="$(awk -F' *= *' '/^\[database\]/{d=1;next} /^\[/{d=0} d && $1=="name"{gsub(/["'"'"' ]/,"",$2); print $2; exit}' "$cfg")"
	[ -n "$OJS_DB" ] || die "Nama database OJS tidak terbaca dari ${cfg}."
	ojs_sql "SELECT 1" >/dev/null || die "Tidak bisa masuk ke database ${OJS_DB} sebagai root MariaDB."

	local tema="$OJS_TEMA" plugin varian="${OJS_VARIAN:-simplex}"
	if [ -z "$tema" ]; then
		# Tanpa --tema: pertahankan tema yang sedang dipakai jurnal
		tema="$(ojs_sql "SELECT setting_value FROM journal_settings WHERE setting_name='themePluginPath' ORDER BY journal_id LIMIT 1")"
		case "$tema" in aipptm|bootstrap3) ;; *) tema="aipptm" ;; esac
	fi
	case "$tema" in
		aipptm) plugin="aipptmthemeplugin" ;;
		bootstrap3) plugin="bootstrapthreethemeplugin" ;;
		default) plugin="defaultthemeplugin" ;;
		*) die "Tema '${tema}' tidak dikenal. Pilih: aipptm, bootstrap3, default." ;;
	esac

	log "1. Berkas tema ${tema}"
	if [ "$tema" = "aipptm" ] && [ -f "$OJS_THEME_TGZ" ]; then
		rm -rf "${OJS_ROOT}/plugins/themes/aipptm"
		tar -xzf "$OJS_THEME_TGZ" -C "${OJS_ROOT}/plugins/themes/"
		echo "   Disalin dari $(basename "$OJS_THEME_TGZ")"
	elif [ "$tema" = "bootstrap3" ]; then
		local tmp
		tmp="$(mktemp -d)"
		download "$BOOTSTRAP3_URL" "${tmp}/bootstrap3.tar.gz"
		tar -xzf "${tmp}/bootstrap3.tar.gz" -C "$tmp"
		[ -f "${tmp}/bootstrap3/BootstrapThreeThemePlugin.php" ] || die "Arsip Bootstrap3 tidak berisi tema yang dikenal."
		rm -rf "${OJS_ROOT}/plugins/themes/bootstrap3"
		mv "${tmp}/bootstrap3" "${OJS_ROOT}/plugins/themes/bootstrap3"
		rm -rf "$tmp"
		echo "   Bootstrap3 ${BOOTSTRAP3_VERSION} diunduh dari github.com/pkp/bootstrap3"
	fi
	[ -f "${OJS_ROOT}/plugins/themes/${tema}/version.xml" ] \
		|| die "Tema tidak ada di ${OJS_ROOT}/plugins/themes/${tema}. Untuk tema aipptm, taruh aipptm-ojs-tema.tar.gz di folder yang sama dengan skrip ini."
	chown -R www-data:www-data "${OJS_ROOT}/plugins/themes/${tema}"
	if [ "$tema" != "default" ]; then
		(cd "$OJS_ROOT" && sudo -u www-data php lib/pkp/tools/installPluginVersion.php "plugins/themes/${tema}/version.xml") \
			|| warn "Pendaftaran versi tema gagal; lanjut mengaktifkan tema."
	fi

	log "2. Mengaktifkan dan memilih tema ${tema}"
	local ids id
	ids="$(ojs_sql "SELECT journal_id FROM journals ORDER BY journal_id")"
	ojs_sql "DELETE FROM plugin_settings WHERE plugin_name='${plugin}' AND setting_name='enabled';
		INSERT INTO plugin_settings (plugin_name, context_id, setting_name, setting_value, setting_type)
			VALUES ('${plugin}', NULL, 'enabled', '1', 'bool');
		DELETE FROM site_settings WHERE setting_name='themePluginPath';
		INSERT INTO site_settings (setting_name, locale, setting_value) VALUES ('themePluginPath', '', '${tema}');"
	for id in $ids; do
		ojs_sql "INSERT INTO plugin_settings (plugin_name, context_id, setting_name, setting_value, setting_type)
				VALUES ('${plugin}', ${id}, 'enabled', '1', 'bool');
			DELETE FROM journal_settings WHERE journal_id=${id} AND setting_name='themePluginPath';
			INSERT INTO journal_settings (journal_id, locale, setting_name, setting_value) VALUES (${id}, '', 'themePluginPath', '${tema}');"
		if [ "$tema" = "bootstrap3" ] && { [ -n "$OJS_VARIAN" ] || [ "$(ojs_sql "SELECT COUNT(*) FROM plugin_settings WHERE plugin_name='${plugin}' AND context_id=${id} AND setting_name='bootstrapTheme'")" -eq 0 ]; }; then
			ojs_sql "DELETE FROM plugin_settings WHERE plugin_name='${plugin}' AND context_id=${id} AND setting_name='bootstrapTheme';
				INSERT INTO plugin_settings (plugin_name, context_id, setting_name, setting_value, setting_type)
					VALUES ('${plugin}', ${id}, 'bootstrapTheme', $(sql_str "$varian"), 'string');"
		fi
		echo "   Jurnal $(ojs_sql "SELECT path FROM journals WHERE journal_id=${id}") memakai tema ${tema}"
	done

	log "3. Administrator Situs"
	local admin_group
	admin_group="$(ojs_sql "SELECT user_group_id FROM user_groups WHERE role_id=1 ORDER BY user_group_id LIMIT 1")"
	[ -n "$admin_group" ] || die "Grup Site Admin (role_id 1) tidak ditemukan di database."
	if [ -n "$OJS_ADMIN" ]; then
		local q uid
		q="$(sql_str "$OJS_ADMIN")"
		uid="$(ojs_sql "SELECT user_id FROM users WHERE username=${q} OR email=${q} LIMIT 1")"
		if [ -z "$uid" ]; then
			warn "Pengguna '${OJS_ADMIN}' tidak ditemukan. Daftar pengguna yang ada:"
			ojs_sql "SELECT CONCAT('   ', username, '  <', email, '>') FROM users ORDER BY user_id"
		elif [ "$(ojs_sql "SELECT COUNT(*) FROM user_user_groups WHERE user_id=${uid} AND user_group_id=${admin_group} AND (date_end IS NULL OR date_end > NOW())")" -gt 0 ]; then
			echo "   ${OJS_ADMIN} sudah Administrator Situs."
		else
			ojs_sql "INSERT INTO user_user_groups (user_group_id, user_id, date_start) VALUES (${admin_group}, ${uid}, NOW())"
			echo "   ${OJS_ADMIN} sekarang Administrator Situs."
		fi
		if [ -n "$uid" ] && [ -n "$OJS_SANDI" ]; then
			local hash
			hash="$(OJS_SANDI="$OJS_SANDI" php -r 'echo password_hash(getenv("OJS_SANDI"), PASSWORD_BCRYPT);')"
			ojs_sql "UPDATE users SET password=$(sql_str "$hash"), disabled=0, must_change_password=0 WHERE user_id=${uid}"
			echo "   Kata sandi ${OJS_ADMIN} sudah diganti dan akunnya aktif."
		fi
	elif [ -n "$OJS_SANDI" ]; then
		warn "--sandi hanya dipakai bersama --admin NAMA_PENGGUNA."
	fi
	echo "   Akun Administrator Situs saat ini:"
	ojs_sql "SELECT DISTINCT CONCAT('   - ', u.username, '  <', u.email, '>', IF(u.disabled=1, '  (NONAKTIF)', ''))
		FROM users u JOIN user_user_groups uug ON uug.user_id=u.user_id
		WHERE uug.user_group_id=${admin_group} AND (uug.date_end IS NULL OR uug.date_end > NOW())"

	log "4. Membersihkan cache OJS"
	find "${OJS_ROOT}/cache" -mindepth 1 -maxdepth 1 ! -name 'index.html' ! -name '_db' ! -name 't_compile' ! -name 't_cache' ! -name 't_config' -exec rm -rf {} + 2>/dev/null || true
	rm -rf "${OJS_ROOT}"/cache/t_compile/* "${OJS_ROOT}"/cache/t_cache/* "${OJS_ROOT}"/cache/_db/* 2>/dev/null || true
	chown -R www-data:www-data "${OJS_ROOT}/cache"

	log "Selesai. Buka https://${JOURNAL_DOMAIN} (Ctrl+F5). Login admin: https://${JOURNAL_DOMAIN}/index.php/index/login"
}

summary() {
	cat <<-EOF

		==========================================================================
		 Pemasangan selesai.
		 1) WordPress : https://${WWW_DOMAIN}/wp-admin/install.php
		    -> pilih bahasa "Bahasa Indonesia", buat akun admin, lalu aktifkan tema AIPPTM
		       (Tampilan -> Tema). Halaman contoh dibuat otomatis.
		 2) OJS       : https://${JOURNAL_DOMAIN}
		    -> isi wizard instalasi dengan data berikut:
		         Database driver : MariaDB
		         Host            : localhost
		         Username        : ${OJS_DB_USER}
		         Database        : ${OJS_DB_NAME}
		         Password        : lihat ${CRED_FILE}  (perintah: sudo cat ${CRED_FILE})
		         Direktori berkas: ${OJS_FILES}
		    -> setelah wizard selesai, jalankan: sudo bash $0 --ojs-finalize
		 3) Backup database harian: ${BACKUP_DIR}
		    Aktifkan juga "Snapshot schedule" disk VM di Google Cloud (lihat PANDUAN).
		==========================================================================
	EOF
}

main() {
	parse_args "$@"
	require_root_ubuntu
	case "$MODE" in
		ojs-finalize) ojs_finalize; return ;;
		ojs-perbaiki) ojs_perbaiki; return ;;
		ssl) request_certificates; return ;;
	esac
	ensure_swap
	install_packages
	configure_php
	load_or_create_credentials
	setup_databases
	install_wordpress
	install_ojs
	configure_apache
	configure_backups
	configure_auto_updates
	if [ "$SKIP_SSL" -eq 1 ]; then
		warn "HTTPS dilewati (--skip-ssl). Setelah DNS aktif: sudo bash $0 --email ALAMAT --ssl-only"
	else
		request_certificates
	fi
	summary
}

main "$@"

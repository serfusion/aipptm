<?php
/**
 * Menu "Jurnal (OJS)" di admin WordPress: alamat jurnal bisa diatur, dan semua
 * pengaturan OJS yang sering dipakai bisa dibuka dari sini dengan satu klik.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function aipptm_ojs_opsi() {
	$bawaan = array(
		'url'  => 'https://journal.aipptm.org',
		'path' => '',
	);
	return wp_parse_args( (array) get_option( 'aipptm_ojs', array() ), $bawaan );
}

function aipptm_ojs_daftar_menu() {
	add_menu_page(
		__( 'Jurnal (OJS)', 'aipptm' ),
		__( 'Jurnal (OJS)', 'aipptm' ),
		'manage_options',
		'aipptm-ojs',
		'aipptm_ojs_halaman',
		'dashicons-book-alt',
		3
	);
}
add_action( 'admin_menu', 'aipptm_ojs_daftar_menu' );

function aipptm_ojs_daftar_setelan() {
	register_setting(
		'aipptm_ojs',
		'aipptm_ojs',
		array(
			'type'              => 'array',
			'sanitize_callback' => 'aipptm_ojs_bersihkan',
			'default'           => array(),
		)
	);
}
add_action( 'admin_init', 'aipptm_ojs_daftar_setelan' );

function aipptm_ojs_bersihkan( $nilai ) {
	$nilai = (array) $nilai;
	return array(
		'url'  => untrailingslashit( esc_url_raw( isset( $nilai['url'] ) ? trim( $nilai['url'] ) : '' ) ),
		'path' => sanitize_title( isset( $nilai['path'] ) ? $nilai['path'] : '' ),
	);
}

function aipptm_ojs_tautan( $bagian, $situs = false ) {
	$opsi = aipptm_ojs_opsi();
	$awal = $opsi['url'] . '/index.php/' . ( $situs || '' === $opsi['path'] ? 'index' : $opsi['path'] );
	return $awal . '/' . ltrim( $bagian, '/' );
}

function aipptm_ojs_halaman() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$opsi  = aipptm_ojs_opsi();
	$grup  = array(
		__( 'Tampilan jurnal', 'aipptm' )      => array(
			array( __( 'Tema & opsi tema AIPPTM (warna, bar atas, footer HTML, CSS tambahan)', 'aipptm' ), 'management/settings/website#appearance/theme' ),
			array( __( 'Logo, gambar beranda, Page Footer, sidebar', 'aipptm' ), 'management/settings/website#appearance/setup' ),
			array( __( 'Unggah style sheet jurnal (.css)', 'aipptm' ), 'management/settings/website#appearance/advanced' ),
			array( __( 'Menu navigasi, pengumuman, bahasa jurnal', 'aipptm' ), 'management/settings/website#setup' ),
			array( __( 'Plugin jurnal (pasang / unggah plugin & tema)', 'aipptm' ), 'management/settings/website#plugins' ),
		),
		__( 'Pengaturan jurnal', 'aipptm' )    => array(
			array( __( 'Identitas, ISSN, kontak, deskripsi jurnal', 'aipptm' ), 'management/settings/context' ),
			array( __( 'Alur kerja, panduan penulis, email', 'aipptm' ), 'management/settings/workflow' ),
			array( __( 'Lisensi, DOI, indeks, akses', 'aipptm' ), 'management/settings/distribution' ),
			array( __( 'Pengguna & peran', 'aipptm' ), 'management/settings/access' ),
			array( __( 'ORCID jurnal (Client ID & Secret)', 'aipptm' ), 'management/settings/access#orcidSettings' ),
			array( __( 'Terbitan (issues)', 'aipptm' ), 'manageIssues' ),
		),
		__( 'Administrasi situs OJS', 'aipptm' ) => array(
			array( __( 'Pengaturan situs (nama situs, bahasa, email massal)', 'aipptm' ), 'admin/settings', true ),
			array( __( 'ORCID untuk seluruh situs', 'aipptm' ), 'admin/settings#setup/orcidSiteSettings', true ),
			array( __( 'Daftar jurnal (buat jurnal baru)', 'aipptm' ), 'admin/contexts', true ),
			array( __( 'Informasi sistem & versi OJS', 'aipptm' ), 'admin/systemInfo', true ),
			array( __( 'Hapus cache data & template (bila tampilan tidak berubah)', 'aipptm' ), 'admin/index', true ),
		),
	);
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Jurnal (OJS)', 'aipptm' ); ?></h1>
		<p><?php esc_html_e( 'Semua tautan di bawah membuka halaman admin OJS di tab baru. Masuk ke OJS sekali, setelah itu tautan langsung terbuka.', 'aipptm' ); ?></p>

		<form method="post" action="options.php" style="max-width:720px">
			<?php settings_fields( 'aipptm_ojs' ); ?>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="aipptm-ojs-url"><?php esc_html_e( 'Alamat OJS', 'aipptm' ); ?></label></th>
					<td><input type="url" id="aipptm-ojs-url" class="regular-text" name="aipptm_ojs[url]" value="<?php echo esc_attr( $opsi['url'] ); ?>" placeholder="https://journal.aipptm.org"></td>
				</tr>
				<tr>
					<th scope="row"><label for="aipptm-ojs-path"><?php esc_html_e( 'Path jurnal', 'aipptm' ); ?></label></th>
					<td>
						<input type="text" id="aipptm-ojs-path" class="regular-text" name="aipptm_ojs[path]" value="<?php echo esc_attr( $opsi['path'] ); ?>" placeholder="jgs">
						<p class="description"><?php esc_html_e( 'Bagian alamat jurnal setelah /index.php/, terlihat di Administration › Hosted Journals. Contoh: https://journal.aipptm.org/index.php/jgs berarti path-nya jgs.', 'aipptm' ); ?></p>
					</td>
				</tr>
			</table>
			<?php submit_button( __( 'Simpan alamat', 'aipptm' ) ); ?>
		</form>

		<?php if ( '' === $opsi['path'] ) : ?>
			<div class="notice notice-warning inline"><p><?php esc_html_e( 'Isi path jurnal dulu agar tautan pengaturan jurnal mengarah ke jurnal yang benar.', 'aipptm' ); ?></p></div>
		<?php endif; ?>

		<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:16px;margin-top:16px">
			<?php foreach ( $grup as $judul => $tautan ) : ?>
				<div class="card" style="margin:0;max-width:none">
					<h2 class="title"><?php echo esc_html( $judul ); ?></h2>
					<ul style="margin:0">
						<?php foreach ( $tautan as $t ) : ?>
							<li style="margin-bottom:8px"><a href="<?php echo esc_url( aipptm_ojs_tautan( $t[1], ! empty( $t[2] ) ) ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $t[0] ); ?> ↗</a></li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endforeach; ?>
		</div>

		<div class="card" style="max-width:none;margin-top:16px">
			<h2 class="title"><?php esc_html_e( 'Mengapa menu Site Settings OJS AIPPTM lebih sedikit dari UMT?', 'aipptm' ); ?></h2>
			<p><?php esc_html_e( 'OJS sengaja menyembunyikan tab Settings, Appearance, Plugins, Information, Navigation, Highlights, dan Announcements di Administration › Site Settings bila situs hanya berisi SATU jurnal. Pengaturan itu tetap ada, pindah ke tingkat jurnal: Settings › Website (tautan "Tampilan jurnal" di atas). UMT menampilkan semuanya karena memuat banyak jurnal. Tab ORCID TIDAK ikut disembunyikan: di OJS 3.5 tab itu selalu ada di Site Settings › Site Setup › ORCID, dan juga di tingkat jurnal: Users & Roles › ORCID.', 'aipptm' ); ?></p>
		</div>
	</div>
	<?php
}

function aipptm_ojs_bar_admin( $wp_admin_bar ) {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$wp_admin_bar->add_node(
		array(
			'id'    => 'aipptm-ojs',
			'title' => __( 'Jurnal (OJS)', 'aipptm' ),
			'href'  => admin_url( 'admin.php?page=aipptm-ojs' ),
		)
	);
}
add_action( 'admin_bar_menu', 'aipptm_ojs_bar_admin', 80 );

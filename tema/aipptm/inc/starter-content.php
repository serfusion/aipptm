<?php
/**
 * Konten awal: saat tema pertama kali diaktifkan, buat laman-laman contoh
 * (Beranda, Profil, Direktori Anggota, dst.), jadikan Beranda sebagai halaman depan, isi slogan
 * bila kosong, dan pasang logo sementara. Hanya berjalan sekali dan tidak pernah menimpa halaman atau
 * pengaturan yang sudah ada.
 *
 * @package aipptm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Daftar halaman awal: slug => judul, pola isi, dan template.
 */
function aipptm_starter_pages() {
	return array(
		'beranda'           => array( 'title' => 'Beranda', 'pattern' => 'aipptm/beranda', 'template' => 'page-full' ),
		'profil'            => array( 'title' => 'Profil AIPPTM', 'pattern' => 'aipptm/halaman-profil' ),
		'pengurus'          => array( 'title' => 'Pengurus', 'pattern' => 'aipptm/halaman-pengurus' ),
		'direktori-anggota' => array( 'title' => 'Direktori Anggota PTM', 'pattern' => 'aipptm/halaman-direktori' ),
		'keanggotaan'       => array( 'title' => 'Cara Bergabung', 'pattern' => 'aipptm/halaman-keanggotaan' ),
		'divisi-program'    => array( 'title' => 'Divisi & Program Kerja', 'pattern' => 'aipptm/halaman-divisi' ),
		'publikasi'         => array( 'title' => 'Publikasi', 'pattern' => 'aipptm/halaman-publikasi' ),
		'agenda'            => array( 'title' => 'Agenda Kegiatan', 'pattern' => 'aipptm/halaman-agenda' ),
		'kontak'            => array( 'title' => 'Kontak', 'pattern' => 'aipptm/halaman-kontak' ),
		'kebijakan-privasi' => array( 'title' => 'Kebijakan Privasi', 'pattern' => 'aipptm/halaman-privasi' ),
		'berita'            => array( 'title' => 'Berita & Agenda', 'pattern' => '' ),
	);
}

function aipptm_pattern_content( $slug ) {
	if ( '' === $slug ) {
		return '';
	}
	$pattern = WP_Block_Patterns_Registry::get_instance()->get_registered( $slug );
	return $pattern ? $pattern['content'] : '';
}

function aipptm_create_starter_content() {
	if ( get_option( 'aipptm_starter_content' ) ) {
		return;
	}

	$ids = array();
	foreach ( aipptm_starter_pages() as $slug => $page ) {
		$existing = get_page_by_path( $slug );
		if ( $existing ) {
			$ids[ $slug ] = $existing->ID;
			continue;
		}
		$postarr = array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_name'    => $slug,
			'post_title'   => $page['title'],
			'post_content' => aipptm_pattern_content( $page['pattern'] ),
		);
		if ( ! empty( $page['template'] ) ) {
			$postarr['page_template'] = $page['template'];
		}
		$id = wp_insert_post( wp_slash( $postarr ), true );
		if ( ! is_wp_error( $id ) ) {
			$ids[ $slug ] = $id;
		}
	}

	// Menu tema memakai alamat seperti /profil/, yang butuh permalink "cantik".
	// set_permalink_structure() memperbarui opsi sekaligus objek $wp_rewrite. Hook ini berjalan
	// saat 'init', sebelum WordPress memuat fungsi admin penulis .htaccess, jadi dimuat di sini.
	global $wp_rewrite;
	if ( '' === get_option( 'permalink_structure' ) ) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/misc.php';
		$wp_rewrite->set_permalink_structure( '/%postname%/' );
		flush_rewrite_rules();
	}

	// Jadikan Beranda halaman depan hanya jika situs masih memakai pengaturan bawaan (daftar tulisan).
	if ( 'posts' === get_option( 'show_on_front' ) && isset( $ids['beranda'], $ids['berita'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $ids['beranda'] );
		update_option( 'page_for_posts', $ids['berita'] );
	}

	// Slogan tampil di bawah nama situs pada header; isi hanya bila masih kosong.
	if ( '' === get_option( 'blogdescription' ) ) {
		update_option( 'blogdescription', 'Asosiasi Ilmu Pemerintahan Perguruan Tinggi Muhammadiyah' );
	}

	aipptm_import_logo();

	update_option( 'aipptm_starter_content', 1 );
	set_transient( 'aipptm_starter_notice', 1, DAY_IN_SECONDS );
}
add_action( 'after_switch_theme', 'aipptm_create_starter_content' );

/**
 * Pasang logo sementara ke Media Library sebagai logo situs dan ikon situs (favicon),
 * kecuali sudah ada logo/ikon yang dipilih pengguna.
 */
function aipptm_import_logo() {
	if ( get_theme_mod( 'custom_logo' ) && get_option( 'site_icon' ) ) {
		return;
	}
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$source = get_theme_file_path( 'assets/images/logo-aipptm.png' );
	$upload = wp_upload_bits( 'logo-aipptm.png', null, file_get_contents( $source ) );
	if ( ! empty( $upload['error'] ) ) {
		return;
	}
	$id = wp_insert_attachment(
		array(
			'post_mime_type' => 'image/png',
			'post_title'     => 'Logo AIPPTM (sementara)',
			'post_status'    => 'inherit',
		),
		$upload['file']
	);
	if ( is_wp_error( $id ) || ! $id ) {
		return;
	}
	wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $upload['file'] ) );

	if ( ! get_theme_mod( 'custom_logo' ) ) {
		set_theme_mod( 'custom_logo', $id );
	}
	if ( ! get_option( 'site_icon' ) ) {
		update_option( 'site_icon', $id );
	}
}

function aipptm_starter_notice() {
	if ( ! get_transient( 'aipptm_starter_notice' ) || ! current_user_can( 'edit_pages' ) ) {
		return;
	}
	delete_transient( 'aipptm_starter_notice' );
	printf(
		'<div class="notice notice-success is-dismissible"><p>%s <a href="%s">%s</a></p></div>',
		esc_html__( 'Tema AIPPTM aktif. Laman contoh (Beranda, Profil, Direktori Anggota, Divisi & Program, Publikasi, Agenda, Kontak) sudah dibuat dan siap diedit.', 'aipptm' ),
		esc_url( admin_url( 'edit.php?post_type=page' ) ),
		esc_html__( 'Buka daftar laman', 'aipptm' )
	);
}
add_action( 'admin_notices', 'aipptm_starter_notice' );

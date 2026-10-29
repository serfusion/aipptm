<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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

	global $wp_rewrite;
	if ( '' === get_option( 'permalink_structure' ) ) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/misc.php';
		$wp_rewrite->set_permalink_structure( '/%postname%/' );
		flush_rewrite_rules();
	}

	if ( 'posts' === get_option( 'show_on_front' ) && isset( $ids['beranda'], $ids['berita'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $ids['beranda'] );
		update_option( 'page_for_posts', $ids['berita'] );
	}

	if ( '' === get_option( 'blogdescription' ) ) {
		update_option( 'blogdescription', 'Asosiasi Ilmu Pemerintahan Perguruan Tinggi Muhammadiyah' );
	}

	aipptm_import_logo();

	update_option( 'aipptm_starter_content', 1 );
}
add_action( 'after_switch_theme', 'aipptm_create_starter_content' );

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
			'post_title'     => 'Logo AIPPTM',
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

function aipptm_perbarui_konten() {
	if ( (int) get_option( 'aipptm_konten_versi', 1 ) >= 2 ) {
		return;
	}
	$pengurus = get_page_by_path( 'pengurus' );
	if ( $pengurus && false !== strpos( $pengurus->post_content, 'Nama Wakil Ketua' ) && false !== strpos( $pengurus->post_content, 'Nama Bendahara' ) ) {
		$isi = aipptm_pattern_content( 'aipptm/halaman-pengurus' );
		if ( '' !== $isi ) {
			wp_update_post( wp_slash( array( 'ID' => $pengurus->ID, 'post_content' => $isi ) ) );
		}
	}
	$beranda_id = (int) get_option( 'page_on_front' );
	$beranda    = $beranda_id ? get_post( $beranda_id ) : null;
	$lama       = '<strong>Dr. Phil. Aryo Prasetyo, M.A.</strong><br>Ketua Umum DPP AIPPTM Periode 2024 sampai 2028';
	if ( $beranda && false !== strpos( $beranda->post_content, $lama ) ) {
		$baru = '<strong>Dr. Dian Suluh Kusumadewi, M.P.A.</strong><br>Ketua Umum AIPPTM Masa Jabatan 2026 sampai 2028';
		wp_update_post( wp_slash( array( 'ID' => $beranda->ID, 'post_content' => str_replace( $lama, $baru, $beranda->post_content ) ) ) );
	}
	update_option( 'aipptm_konten_versi', 2 );
}
add_action( 'wp_loaded', 'aipptm_perbarui_konten' );

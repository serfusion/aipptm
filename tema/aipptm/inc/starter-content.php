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
		'divisi-program'    => array( 'title' => 'Bidang & Program Kerja', 'pattern' => 'aipptm/halaman-divisi' ),
		'publikasi'         => array( 'title' => 'Jurnal & Publikasi AIPPTM', 'pattern' => 'aipptm/halaman-publikasi' ),
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

function aipptm_perbarui_konten_3() {
	if ( (int) get_option( 'aipptm_konten_versi', 1 ) >= 3 ) {
		return;
	}
	$pengurus = get_page_by_path( 'pengurus' );
	if ( $pengurus && false !== strpos( $pengurus->post_content, 'aipptm-pengurus__dewan' ) ) {
		$isi = aipptm_pattern_content( 'aipptm/halaman-pengurus' );
		if ( '' !== $isi ) {
			wp_update_post( wp_slash( array( 'ID' => $pengurus->ID, 'post_content' => $isi ) ) );
		}
	}
	update_option( 'aipptm_konten_versi', 3 );
}
add_action( 'wp_loaded', 'aipptm_perbarui_konten_3', 11 );
add_action( 'wp_loaded', 'aipptm_perbarui_konten' );

/**
 * Versi laman di aipptm.org yang dirapikan ke tema ini (waktu ubah terakhir, GMT).
 * Laman hanya diganti bila belum diubah lagi sejak versi tersebut.
 */
function aipptm_laman_rapi() {
	return array(
		'beranda'           => array( 'aipptm/beranda', '2026-10-30 16:23:14' ),
		'profil'            => array( 'aipptm/halaman-profil', '2026-10-30 15:30:28' ),
		'pengurus'          => array( 'aipptm/halaman-pengurus', '2026-10-29 10:21:24' ),
		'direktori-anggota' => array( 'aipptm/halaman-direktori', '2026-10-31 00:14:39' ),
		'divisi-program'    => array( 'aipptm/halaman-divisi', '2026-10-29 10:45:26' ),
		'publikasi'         => array( 'aipptm/halaman-publikasi', '2026-10-31 12:18:11' ),
		'kontak'            => array( 'aipptm/halaman-kontak', '2026-10-31 11:14:08' ),
	);
}

function aipptm_simpan_konten( $post_id, $isi ) {
	$kses = false !== has_filter( 'content_save_pre', 'wp_filter_post_kses' );
	if ( $kses ) {
		kses_remove_filters();
	}
	$hasil = wp_update_post( wp_slash( array( 'ID' => $post_id, 'post_content' => $isi ) ), true );
	if ( $kses ) {
		kses_init_filters();
	}
	return ! is_wp_error( $hasil ) && $hasil;
}

function aipptm_perbarui_konten_4() {
	if ( (int) get_option( 'aipptm_konten_versi', 1 ) >= 4 ) {
		return;
	}
	update_option( 'aipptm_konten_versi', 4 );

	foreach ( aipptm_laman_rapi() as $slug => $data ) {
		$laman = get_page_by_path( $slug );
		if ( ! $laman || 'page' !== $laman->post_type || $data[1] !== $laman->post_modified_gmt ) {
			continue;
		}
		$isi = aipptm_pattern_content( $data[0] );
		if ( '' === trim( $isi ) || $isi === $laman->post_content ) {
			continue;
		}
		if ( '' === get_post_meta( $laman->ID, '_aipptm_cadangan_konten', true ) ) {
			add_post_meta( $laman->ID, '_aipptm_cadangan_konten', wp_slash( $laman->post_content ), true );
		}
		wp_save_post_revision( $laman->ID );
		aipptm_simpan_konten( $laman->ID, $isi );
	}

	$ganti = array(
		'/<!-- wp:navigation-link \{[^{}]*"label":"Jurnal Mitra (?:\\\\u0026|&amp;|&) Buku Elektronik"[^{}]*\} \/-->/' => '<!-- wp:navigation-link {"label":"Jurnal Afiliasi","url":"/publikasi/#jurnal-afiliasi","kind":"custom"} /-->' . "\n" . '<!-- wp:navigation-link {"label":"Buku & Book Chapter","url":"/publikasi/#ebook","kind":"custom"} /-->',
		'/>Divisi (&amp;|&) Program Kerja<\/a>/'                                                                               => '>Bidang $1 Program Kerja</a>',
	);
	$bagian = get_posts(
		array(
			'post_type'        => array( 'wp_template_part', 'wp_navigation' ),
			'post_status'      => array( 'publish', 'draft', 'private' ),
			'numberposts'      => 50,
			'suppress_filters' => false,
		)
	);
	foreach ( $bagian as $item ) {
		$isi = preg_replace( array_keys( $ganti ), array_values( $ganti ), $item->post_content );
		if ( is_string( $isi ) && $isi !== $item->post_content ) {
			aipptm_simpan_konten( $item->ID, $isi );
		}
	}
}
add_action( 'wp_loaded', 'aipptm_perbarui_konten_4', 12 );

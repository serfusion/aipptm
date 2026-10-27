<?php
/**
 * Fungsi tema AIPPTM.
 *
 * @package aipptm
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Memuat style.css di situs dan di editor agar tampilan keduanya sama.
 */
function aipptm_setup() {
	add_editor_style( 'style.css' );
}
add_action( 'after_setup_theme', 'aipptm_setup' );

function aipptm_enqueue_styles() {
	wp_enqueue_style( 'aipptm', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );
}
add_action( 'wp_enqueue_scripts', 'aipptm_enqueue_styles' );

/**
 * Kategori pola blok "AIPPTM" agar semua bagian beranda mudah ditemukan di editor.
 */
function aipptm_register_pattern_category() {
	register_block_pattern_category( 'aipptm', array( 'label' => __( 'AIPPTM', 'aipptm' ) ) );
}
add_action( 'init', 'aipptm_register_pattern_category' );

/**
 * Mencetak judul bagian bergaya "masthead": judul besar rata kiri dengan titik merah,
 * pengantar singkat di kanan, dan garis tipis di bawahnya. Dipakai oleh pola-pola beranda.
 *
 * @param string $judul     Judul bagian, tanpa titik di akhir.
 * @param string $pengantar Kalimat pengantar (boleh berisi <strong>).
 */
function aipptm_kepala( $judul, $pengantar ) {
	printf(
		'<!-- wp:group {"align":"wide","className":"aipptm-kepala","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
<div class="wp-block-group alignwide aipptm-kepala"><!-- wp:heading {"className":"aipptm-kepala__judul"} -->
<h2 class="wp-block-heading aipptm-kepala__judul">%1$s<mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-merah-color">.</mark></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"aipptm-kepala__pengantar"} -->
<p class="aipptm-kepala__pengantar">%2$s</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

',
		esc_html( $judul ),
		wp_kses( $pengantar, array( 'strong' => array() ) )
	);
}

/**
 * Tahun pada baris hak cipta footer (paragraf berkelas aipptm-hak-cipta) selalu tahun berjalan,
 * juga setelah Footer disimpan dari editor (isi yang disimpan tidak lagi berisi kode PHP).
 *
 * @param string $content HTML blok paragraf.
 * @param array  $block   Data blok.
 * @return string
 */
function aipptm_tahun_berjalan( $content, $block ) {
	$kelas = isset( $block['attrs']['className'] ) ? $block['attrs']['className'] : '';
	if ( false === strpos( $kelas, 'aipptm-hak-cipta' ) ) {
		return $content;
	}
	return preg_replace( '/\b(19|20)\d{2}\b/', wp_date( 'Y' ), $content, 1 );
}
add_filter( 'render_block_core/paragraph', 'aipptm_tahun_berjalan', 10, 2 );

require get_template_directory() . '/inc/starter-content.php';

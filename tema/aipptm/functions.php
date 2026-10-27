<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function aipptm_setup() {
	add_editor_style( 'style.css' );
}
add_action( 'after_setup_theme', 'aipptm_setup' );

function aipptm_enqueue_styles() {
	wp_enqueue_style( 'aipptm', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );
	wp_enqueue_script( 'aipptm-gerak', get_theme_file_uri( 'assets/js/gerak.js' ), array(), wp_get_theme()->get( 'Version' ), array( 'strategy' => 'defer', 'in_footer' => false ) );
}
add_action( 'wp_enqueue_scripts', 'aipptm_enqueue_styles' );

function aipptm_register_pattern_category() {
	register_block_pattern_category( 'aipptm', array( 'label' => __( 'AIPPTM', 'aipptm' ) ) );
}
add_action( 'init', 'aipptm_register_pattern_category' );

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

function aipptm_tahun_berjalan( $content, $block ) {
	$kelas = isset( $block['attrs']['className'] ) ? $block['attrs']['className'] : '';
	if ( false === strpos( $kelas, 'aipptm-hak-cipta' ) ) {
		return $content;
	}
	return preg_replace( '/\b(19|20)\d{2}\b/', wp_date( 'Y' ), $content, 1 );
}
add_filter( 'render_block_core/paragraph', 'aipptm_tahun_berjalan', 10, 2 );

require get_template_directory() . '/inc/starter-content.php';

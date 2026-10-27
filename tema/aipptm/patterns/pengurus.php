<?php
/**
 * Title: Pengurus (foto bulat)
 * Slug: aipptm/pengurus
 * Categories: aipptm, team
 * Description: Empat pengurus inti dengan foto bulat, nama, dan jabatan (2×2 di HP).
 *
 * Set $aipptm_tanpa_kepala = true sebelum memuat pola ini untuk menyembunyikan judul bagian.
 *
 * @package aipptm
 */

$aipptm_foto     = esc_url( get_theme_file_uri( 'assets/images/foto-pengurus.jpg' ) );
$aipptm_pengurus = array(
	array( 'Nama Ketua Umum', 'Ketua Umum' ),
	array( 'Nama Wakil Ketua', 'Wakil Ketua Umum' ),
	array( 'Nama Sekretaris', 'Sekretaris Jenderal' ),
	array( 'Nama Bendahara', 'Bendahara Umum' ),
);
?>
<!-- wp:group {"align":"full","className":"aipptm-pengurus","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull aipptm-pengurus" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><?php
if ( empty( $aipptm_tanpa_kepala ) ) {
	aipptm_kepala( 'Pengurus', 'Dewan Pimpinan Pusat AIPPTM periode 2024 sampai 2028.' );
}
?><!-- wp:columns {"align":"wide","className":"aipptm-pengurus__kolom"} -->
<div class="wp-block-columns alignwide aipptm-pengurus__kolom"><?php foreach ( $aipptm_pengurus as $aipptm_orang ) : ?><!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"align":"center","sizeSlug":"full","linkDestination":"none","className":"is-style-rounded"} -->
<figure class="wp-block-image aligncenter size-full is-style-rounded"><img src="<?php echo $aipptm_foto; ?>" alt="Foto <?php echo esc_attr( $aipptm_orang[1] ); ?>"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"textAlign":"center","level":3} -->
<h3 class="wp-block-heading has-text-align-center"><?php echo esc_html( $aipptm_orang[0] ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><?php echo esc_html( $aipptm_orang[1] ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --><?php endforeach; ?></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

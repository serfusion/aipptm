<?php
/**
 * Title: Angka Statistik
 * Slug: aipptm/angka
 * Categories: aipptm, about
 */

$aipptm_angka = array(
	array( '45+', 'Anggota PTM' ),
	array( '60+', 'Program Studi' ),
	array( '500+', 'Dosen & Peneliti' ),
	array( '20+', 'Jurnal Terindeks' ),
);
?>
<!-- wp:group {"align":"full","className":"aipptm-angka-pita","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull aipptm-angka-pita" style="padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50)"><!-- wp:group {"align":"wide","className":"aipptm-angka-grid","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide aipptm-angka-grid"><?php foreach ( $aipptm_angka as $aipptm_item ) : ?><!-- wp:group {"className":"aipptm-angka-item","layout":{"type":"default"}} -->
<div class="wp-block-group aipptm-angka-item"><!-- wp:paragraph {"className":"aipptm-angka-besar"} -->
<p class="aipptm-angka-besar"><?php echo esc_html( $aipptm_item[0] ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"aipptm-label"} -->
<p class="aipptm-label"><?php echo esc_html( $aipptm_item[1] ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --><?php endforeach; ?></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<?php
/**
 * Title: Mitra Kerja Sama
 * Slug: aipptm/anggota-institusi
 * Categories: aipptm, gallery
 */
?>
<!-- wp:group {"align":"full","backgroundColor":"merah-muda","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-merah-muda-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><?php aipptm_kepala( 'Mitra Kerja Sama', 'Instansi, perguruan tinggi, dan organisasi yang bermitra dengan AIPPTM.' ); ?><!-- wp:group {"align":"wide","className":"aipptm-logo-grid","style":{"spacing":{"blockGap":"1.25rem"}},"layout":{"type":"grid","columnCount":4,"minimumColumnWidth":"9rem"}} -->
<div class="wp-block-group alignwide aipptm-logo-grid"><?php for ( $aipptm_i = 1; $aipptm_i <= 8; $aipptm_i++ ) : ?><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"aipptm-logo-mitra"} -->
<figure class="wp-block-image size-full aipptm-logo-mitra"><img src="<?php echo esc_url( get_theme_file_uri( "assets/images/logo-institusi-{$aipptm_i}.png" ) ); ?>" alt="Logo Mitra <?php echo (int) $aipptm_i; ?>"/></figure>
<!-- /wp:image --><?php endfor; ?></div>
<!-- /wp:group -->

<!-- wp:spacer {"height":"var:preset|spacing|40"} -->
<div style="height:var(--wp--preset--spacing--40)" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/kontak/">Ajukan kerja sama</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

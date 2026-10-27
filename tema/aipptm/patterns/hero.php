<?php
/**
 * Title: Banner Utama
 * Slug: aipptm/hero
 * Categories: aipptm, banner
 */

$aipptm_hero = esc_url( get_theme_file_uri( 'assets/images/hero.jpg' ) );
?>
<!-- wp:cover {"url":"<?php echo $aipptm_hero; ?>","dimRatio":40,"overlayColor":"merah-tua","isUserOverlayColor":true,"minHeight":560,"align":"full","className":"aipptm-hero","layout":{"type":"constrained"}} -->
<div class="wp-block-cover alignfull aipptm-hero" style="min-height:560px"><span aria-hidden="true" class="wp-block-cover__background has-merah-tua-background-color has-background-dim-40 has-background-dim"></span><img class="wp-block-cover__image-background" alt="" src="<?php echo $aipptm_hero; ?>" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:group {"align":"wide","layout":{"type":"constrained","contentSize":"820px","justifyContent":"left"}} -->
<div class="wp-block-group alignwide"><!-- wp:paragraph {"className":"aipptm-lencana"} -->
<p class="aipptm-lencana">Asosiasi Resmi Prodi Ilmu Pemerintahan PTM Seluruh Indonesia</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Memperkuat Ilmu Pemerintahan untuk Mewujudkan <mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color">Good Governance</mark></h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"fontSize":"large"} -->
<p class="has-large-font-size">Pusat pengembangan, penguatan kurikulum, riset kolaboratif, dan penjaminan mutu program studi ilmu pemerintahan di bawah naungan Persyarikatan Muhammadiyah.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"putih","textColor":"merah"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-merah-color has-putih-background-color has-text-color has-background wp-element-button" href="/direktori-anggota/">Direktori Anggota PTM</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="/profil/">Tentang AIPPTM</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover -->

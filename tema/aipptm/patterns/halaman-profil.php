<?php
/**
 * Title: Laman Profil
 * Slug: aipptm/halaman-profil
 * Categories: aipptm
 * Inserter: no
 */
?>
<!-- wp:paragraph {"className":"aipptm-lead"} -->
<p class="aipptm-lead"><strong>AIPPTM (Asosiasi Ilmu Pemerintahan Perguruan Tinggi Muhammadiyah)</strong> adalah asosiasi resmi program studi ilmu pemerintahan di lingkungan Perguruan Tinggi Muhammadiyah di seluruh Indonesia. AIPPTM menjadi pusat pengembangan, penguatan kurikulum, riset bersama, dan penjaminan mutu prodi.</p>
<!-- /wp:paragraph -->

<?php
aipptm_pemisah();
require __DIR__ . '/sejarah.php';
echo "\n\n";
aipptm_pemisah();
$aipptm_tanpa_kepala = true;
require __DIR__ . '/profil.php';
?>

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/pengurus/">Lihat susunan pengurus</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

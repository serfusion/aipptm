<?php
/**
 * Title: Laman Publikasi
 * Slug: aipptm/halaman-publikasi
 * Categories: aipptm
 * Inserter: no
 */
?>
<?php
$aipptm_tanpa_kepala = true;
require __DIR__ . '/publikasi.php';
?>

<!-- wp:heading -->
<h2 class="wp-block-heading" id="ebook">Buku Elektronik Asosiasi</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Unggah berkas PDF buku elektronik di sini: ketik <em>/file</em> lalu pilih berkasnya dari komputer. Pengunjung dapat mengunduhnya langsung dari laman ini.</p>
<!-- /wp:paragraph -->

<?php require __DIR__ . '/jurnal.php'; ?>

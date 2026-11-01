<?php
/**
 * Title: Laman Publikasi
 * Slug: aipptm/halaman-publikasi
 * Categories: aipptm
 * Inserter: no
 */

require __DIR__ . '/fokus-publikasi.php';
echo "\n\n";
aipptm_pemisah();
require __DIR__ . '/jurnal-afiliasi.php';
echo "\n\n";
aipptm_pemisah();
?>
<!-- wp:heading -->
<h2 class="wp-block-heading" id="ebook">Buku Elektronik Asosiasi</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Kumpulan buku dan <em>book chapter</em> yang diterbitkan oleh anggota maupun mitra afiliasi AIPPTM. Berkas yang tersedia dapat dibaca dan diunduh langsung dari laman ini.</p>
<!-- /wp:paragraph -->

<!-- wp:spacer {"height":"var:preset|spacing|50"} -->
<div style="height:var(--wp--preset--spacing--50)" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<?php require __DIR__ . '/jurnal.php'; ?>

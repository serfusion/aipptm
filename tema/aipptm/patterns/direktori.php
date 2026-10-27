<?php
/**
 * Title: Direktori Anggota PTM
 * Slug: aipptm/direktori
 * Categories: aipptm, about
 * Description: Kartu program studi ilmu pemerintahan anggota (kampus, kota, status akreditasi, jenjang, Kaprodi).
 *
 * Set $aipptm_tanpa_kepala = true sebelum memuat pola ini untuk menyembunyikan judul bagian dan tombol.
 * Data awal berasal dari draf konten pengelola dan WAJIB dicek ulang sebelum situs tayang.
 *
 * @package aipptm
 */

$aipptm_ptm = array(
	array( 'Universitas Muhammadiyah Yogyakarta', 'Yogyakarta', 'Akreditasi Unggul', 'S1 & S2 Ilmu Pemerintahan' ),
	array( 'Universitas Muhammadiyah Malang', 'Malang, Jawa Timur', 'Akreditasi Unggul', 'S1 Ilmu Pemerintahan' ),
	array( 'Universitas Muhammadiyah Surakarta', 'Surakarta, Jawa Tengah', 'Akreditasi Unggul', 'S1 Ilmu Pemerintahan' ),
	array( 'Universitas Muhammadiyah Jakarta', 'Jakarta Selatan', 'Akreditasi A', 'S1 & S2 Ilmu Pemerintahan' ),
	array( 'Universitas Muhammadiyah Sumatera Utara', 'Medan, Sumatera Utara', 'Akreditasi Unggul', 'S1 Ilmu Pemerintahan' ),
	array( 'Universitas Muhammadiyah Makassar', 'Makassar, Sulawesi Selatan', 'Akreditasi Unggul', 'S1 Ilmu Pemerintahan' ),
);
?>
<!-- wp:group {"align":"full","className":"aipptm-direktori","backgroundColor":"abu","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull aipptm-direktori has-abu-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><?php
if ( empty( $aipptm_tanpa_kepala ) ) {
	aipptm_kepala( 'Direktori Anggota', 'Program studi ilmu pemerintahan di jaringan Perguruan Tinggi Muhammadiyah seluruh Indonesia.' );
}
?><!-- wp:group {"align":"wide","className":"aipptm-direktori__grid","layout":{"type":"grid","columnCount":3,"minimumColumnWidth":"17rem"}} -->
<div class="wp-block-group alignwide aipptm-direktori__grid"><?php foreach ( $aipptm_ptm as $aipptm_kampus ) : ?><!-- wp:group {"className":"aipptm-kartu-ptm","backgroundColor":"putih","layout":{"type":"default"}} -->
<div class="wp-block-group aipptm-kartu-ptm has-putih-background-color has-background"><!-- wp:group {"className":"aipptm-kartu-ptm__atas","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group aipptm-kartu-ptm__atas"><!-- wp:paragraph {"className":"aipptm-lencana aipptm-lencana--muda"} -->
<p class="aipptm-lencana aipptm-lencana--muda"><?php echo esc_html( $aipptm_kampus[2] ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"aipptm-kartu-ptm__kota"} -->
<p class="aipptm-kartu-ptm__kota"><?php echo esc_html( $aipptm_kampus[1] ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><?php echo esc_html( $aipptm_kampus[0] ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"aipptm-kartu-ptm__prodi"} -->
<p class="aipptm-kartu-ptm__prodi">Program Studi <?php echo esc_html( $aipptm_kampus[3] ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"aipptm-kartu-ptm__kaprodi"} -->
<p class="aipptm-kartu-ptm__kaprodi">Kaprodi: (isi nama Kaprodi)</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --><?php endforeach; ?></div>
<!-- /wp:group --><?php if ( empty( $aipptm_tanpa_kepala ) ) : ?>

<!-- wp:buttons {"align":"wide","className":"aipptm-aksi-bawah","layout":{"type":"flex","justifyContent":"left"}} -->
<div class="wp-block-buttons alignwide aipptm-aksi-bawah"><!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="/direktori-anggota/">Lihat semua anggota PTM</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --><?php endif; ?></div>
<!-- /wp:group -->

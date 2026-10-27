<?php
/**
 * Title: Publikasi Akademik (jurnal & e-book)
 * Slug: aipptm/publikasi
 * Categories: aipptm, call-to-action
 * Description: Jurnal AIPPTM (OJS) sebagai kartu utama berwarna merah, diikuti jurnal mitra PTM dan e-book asosiasi.
 *
 * Set $aipptm_tanpa_kepala = true sebelum memuat pola ini untuk menyembunyikan judul bagian.
 *
 * @package aipptm
 */

$aipptm_mitra = array(
	array(
		'Jurnal mitra · UMY',
		'Journal of Governance and Public Policy (JGPP)',
		'Jurnal peer-reviewed tentang tata kelola pemerintahan lokal, desentralisasi, dan kebijakan publik.',
		'https://journal.umy.ac.id/index.php/GPP',
		'Kunjungi jurnal',
	),
	array(
		'Jurnal mitra · Unismuh Makassar',
		'Otoritas: Jurnal Ilmu Pemerintahan',
		'Publikasi riset tentang birokrasi, pelayanan publik, dan tata kelola pemerintahan.',
		'https://journal.unismuh.ac.id/index.php/Otoritas',
		'Kunjungi jurnal',
	),
	array(
		'E-book asosiasi',
		'Good Governance di Era Digital',
		'Bunga rampai dosen ilmu pemerintahan PTM tentang tantangan transformasi digital birokrasi.',
		'/publikasi/#ebook',
		'Unduh e-book',
	),
);
?>
<!-- wp:group {"align":"full","className":"aipptm-publikasi","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull aipptm-publikasi" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><?php
if ( empty( $aipptm_tanpa_kepala ) ) {
	aipptm_kepala( 'Publikasi', 'Karya dan jurnal akademik dari jaringan ilmu pemerintahan PTM.' );
}
?><!-- wp:group {"align":"wide","className":"aipptm-publikasi__grid","layout":{"type":"grid","columnCount":4,"minimumColumnWidth":"15rem"}} -->
<div class="wp-block-group alignwide aipptm-publikasi__grid"><!-- wp:group {"className":"aipptm-kartu-pub aipptm-kartu-pub--utama","backgroundColor":"merah","textColor":"putih","layout":{"type":"default"}} -->
<div class="wp-block-group aipptm-kartu-pub aipptm-kartu-pub--utama has-putih-color has-merah-background-color has-text-color has-background"><!-- wp:paragraph {"className":"aipptm-label"} -->
<p class="aipptm-label">Jurnal resmi · OJS</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Jurnal AIPPTM</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Kirim naskah, pantau proses review, dan baca seluruh terbitan secara terbuka.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"aipptm-tautan-panah"} -->
<p class="aipptm-tautan-panah"><a href="https://journal.aipptm.org">journal.aipptm.org</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --><?php foreach ( $aipptm_mitra as $aipptm_m ) : ?>

<!-- wp:group {"className":"aipptm-kartu-pub","backgroundColor":"abu","layout":{"type":"default"}} -->
<div class="wp-block-group aipptm-kartu-pub has-abu-background-color has-background"><!-- wp:paragraph {"className":"aipptm-label"} -->
<p class="aipptm-label"><?php echo esc_html( $aipptm_m[0] ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><?php echo esc_html( $aipptm_m[1] ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php echo esc_html( $aipptm_m[2] ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"aipptm-tautan-panah"} -->
<p class="aipptm-tautan-panah"><a href="<?php echo esc_url( $aipptm_m[3] ); ?>"><?php echo esc_html( $aipptm_m[4] ); ?></a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --><?php endforeach; ?></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

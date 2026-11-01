<?php
/**
 * Title: Publikasi
 * Slug: aipptm/publikasi
 * Categories: aipptm, call-to-action
 */

$aipptm_kartu_pub = array(
	array(
		'Jurnal Afiliasi',
		'Jurnal Ilmu Pemerintahan PTM',
		'Kumpulan jurnal-jurnal dalam bidang kajian Ilmu Pemerintahan yang dikelola oleh Program Studi Ilmu Pemerintahan di bawah naungan Perguruan Tinggi Muhammadiyah (PTM).',
		'/publikasi/#jurnal-afiliasi',
		'Kunjungi daftar jurnal',
	),
	array(
		'Buku Elektronik Asosiasi',
		'Buku dan <em>Book Chapter</em>',
		'Kumpulan buku dan <em>book chapter</em> yang diterbitkan oleh anggota ataupun mitra afiliasi dari AIPPTM.',
		'/publikasi/#ebook',
		'Kunjungi daftar buku',
	),
);
$aipptm_teks = array( 'em' => array() );
?>
<!-- wp:group {"align":"full","className":"aipptm-publikasi","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull aipptm-publikasi" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><?php aipptm_kepala( 'Publikasi', 'Jurnal dan terbitan dari prodi ilmu pemerintahan PTM.' ); ?><!-- wp:group {"align":"wide","className":"aipptm-publikasi__grid","layout":{"type":"grid","columnCount":3,"minimumColumnWidth":"15rem"}} -->
<div class="wp-block-group alignwide aipptm-publikasi__grid"><!-- wp:group {"className":"aipptm-kartu-pub aipptm-kartu-pub--utama","backgroundColor":"merah","textColor":"putih","layout":{"type":"default"}} -->
<div class="wp-block-group aipptm-kartu-pub aipptm-kartu-pub--utama has-putih-color has-merah-background-color has-text-color has-background"><!-- wp:paragraph {"className":"aipptm-label"} -->
<p class="aipptm-label">Terbitan Resmi</p>
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
<!-- /wp:group --><?php foreach ( $aipptm_kartu_pub as $aipptm_m ) : ?>

<!-- wp:group {"className":"aipptm-kartu-pub","backgroundColor":"abu","layout":{"type":"default"}} -->
<div class="wp-block-group aipptm-kartu-pub has-abu-background-color has-background"><!-- wp:paragraph {"className":"aipptm-label"} -->
<p class="aipptm-label"><?php echo esc_html( $aipptm_m[0] ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><?php echo wp_kses( $aipptm_m[1], $aipptm_teks ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php echo wp_kses( $aipptm_m[2], $aipptm_teks ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"aipptm-tautan-panah"} -->
<p class="aipptm-tautan-panah"><a href="<?php echo esc_url( $aipptm_m[3] ); ?>"><?php echo esc_html( $aipptm_m[4] ); ?></a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --><?php endforeach; ?></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

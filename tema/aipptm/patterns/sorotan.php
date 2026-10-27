<?php
/**
 * Title: Sorotan (mosaik editorial)
 * Slug: aipptm/sorotan
 * Categories: aipptm, call-to-action
 * Description: Mosaik tujuh petak tak sama besar (agenda, publikasi, akreditasi, keanggotaan) yang saling mengunci seperti halaman majalah.
 *
 * Posisi tiap petak diatur oleh kelas aipptm-petak-a … aipptm-petak-g di style.css, jadi mosaik dikunci
 * "hanya konten": teks, tautan, dan gambar bisa diganti, tetapi petak tidak bisa dipindah, digandakan,
 * disembunyikan, atau dihapus.
 *
 * @package aipptm
 */

$aipptm_img = static function ( $name ) {
	return esc_url( get_theme_file_uri( 'assets/images/' . $name ) );
};
$aipptm_gradien = 'linear-gradient(180deg,rgba(12,1,3,0.55) 0%,rgba(12,1,3,0.05) 24%,rgba(12,1,3,0.05) 42%,rgba(12,1,3,0.86) 66%,rgb(12,1,3) 100%)';
?>
<!-- wp:group {"align":"full","className":"aipptm-sorotan","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull aipptm-sorotan" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><?php aipptm_kepala( 'Sorotan', 'Bertemu, menulis, berbenah, lalu <strong>bergabung</strong>: empat pintu masuk ke AIPPTM.' ); ?><!-- wp:group {"align":"wide","templateLock":"contentOnly","className":"aipptm-mosaik","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide aipptm-mosaik"><!-- wp:cover {"url":"<?php echo $aipptm_img( 'sorotan-konferensi.jpg' ); ?>","alt":"Aula konferensi: peserta menyimak pembicara di depan layar presentasi ACGS 2026","dimRatio":100,"customGradient":"<?php echo $aipptm_gradien; ?>","focalPoint":{"x":0.5,"y":0.44},"lock":{"move":true,"remove":true},"className":"aipptm-petak aipptm-petak-a aipptm-petak--sampul","layout":{"type":"default"}} -->
<div class="wp-block-cover aipptm-petak aipptm-petak-a aipptm-petak--sampul"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-100 has-background-dim wp-block-cover__gradient-background has-background-gradient" style="background:<?php echo $aipptm_gradien; ?>"></span><img class="wp-block-cover__image-background" alt="Aula konferensi: peserta menyimak pembicara di depan layar presentasi ACGS 2026" src="<?php echo $aipptm_img( 'sorotan-konferensi.jpg' ); ?>" style="object-position:50% 44%" data-object-fit="cover" data-object-position="50% 44%"/><div class="wp-block-cover__inner-container"><!-- wp:paragraph {"className":"aipptm-label"} -->
<p class="aipptm-label">01 — Agenda Mendatang</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"aipptm-angka"} -->
<p class="aipptm-angka">2026</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Annual Conference of Government Studies (ACGS)</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Konferensi internasional tahunan yang mempertemukan akademisi, praktisi, dan peneliti pemerintahan se-Asia Tenggara.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"putih","textColor":"merah"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-merah-color has-putih-background-color has-text-color has-background wp-element-button" href="/agenda/#acgs">Daftar &amp; submit paper</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div></div>
<!-- /wp:cover -->

<!-- wp:group {"lock":{"move":true,"remove":true},"className":"aipptm-petak aipptm-petak-b aipptm-petak--teks","backgroundColor":"merah","textColor":"putih","layout":{"type":"default"}} -->
<div class="wp-block-group aipptm-petak aipptm-petak-b aipptm-petak--teks has-putih-color has-merah-background-color has-text-color has-background"><!-- wp:paragraph {"className":"aipptm-label"} -->
<p class="aipptm-label">02 — Publikasi</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"className":"aipptm-raksasa"} -->
<h3 class="wp-block-heading aipptm-raksasa">Call <em>for</em> Papers</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Kirim naskah ke Jurnal AIPPTM melalui OJS.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"aipptm-tautan-panah"} -->
<p class="aipptm-tautan-panah"><a href="https://journal.aipptm.org">journal.aipptm.org</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:image {"sizeSlug":"full","linkDestination":"none","lock":{"move":true,"remove":true},"className":"aipptm-petak aipptm-petak-c"} -->
<figure class="wp-block-image size-full aipptm-petak aipptm-petak-c"><img src="<?php echo $aipptm_img( 'sorotan-jurnal.jpg' ); ?>" alt="Tumpukan jurnal AIPPTM bersampul merah dengan kacamata baca"/><figcaption class="wp-element-caption">Ruang Redaksi</figcaption></figure>
<!-- /wp:image -->

<!-- wp:image {"sizeSlug":"full","linkDestination":"none","lock":{"move":true,"remove":true},"className":"aipptm-petak aipptm-petak-d"} -->
<figure class="wp-block-image size-full aipptm-petak aipptm-petak-d"><img src="<?php echo $aipptm_img( 'sorotan-webinar.jpg' ); ?>" alt="Mikrofon studio untuk bimbingan teknis daring"/><figcaption class="wp-element-caption">Bimtek Daring</figcaption></figure>
<!-- /wp:image -->

<!-- wp:group {"lock":{"move":true,"remove":true},"className":"aipptm-petak aipptm-petak-e aipptm-petak--teks","backgroundColor":"abu","layout":{"type":"default"}} -->
<div class="wp-block-group aipptm-petak aipptm-petak-e aipptm-petak--teks has-abu-background-color has-background"><!-- wp:paragraph {"className":"aipptm-label"} -->
<p class="aipptm-label">03 — Akreditasi &amp; Kurikulum</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"aipptm-status"} -->
<p class="aipptm-status">Pendampingan dibuka</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"className":"aipptm-pernyataan"} -->
<h3 class="wp-block-heading aipptm-pernyataan">Menuju prodi berakreditasi unggul.</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"aipptm-tautan-panah"} -->
<p class="aipptm-tautan-panah"><a href="/divisi-program/#akreditasi">Program pendampingan</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"lock":{"move":true,"remove":true},"className":"aipptm-petak aipptm-petak-f aipptm-petak--teks","backgroundColor":"merah-muda","layout":{"type":"default"}} -->
<div class="wp-block-group aipptm-petak aipptm-petak-f aipptm-petak--teks has-merah-muda-background-color has-background"><!-- wp:paragraph {"className":"aipptm-label"} -->
<p class="aipptm-label">04 — Keanggotaan PTM</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"className":"aipptm-pernyataan"} -->
<h3 class="wp-block-heading aipptm-pernyataan">Prodi ilmu pemerintahan PTM, mari tumbuh bersama.</h3>
<!-- /wp:heading -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="/keanggotaan/">Cara bergabung</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:image {"sizeSlug":"full","linkDestination":"none","lock":{"move":true,"remove":true},"className":"aipptm-petak aipptm-petak-g"} -->
<figure class="wp-block-image size-full aipptm-petak aipptm-petak-g"><img src="<?php echo $aipptm_img( 'sorotan-keanggotaan.jpg' ); ?>" alt="Selasar kampus bertiang disinari matahari, seorang anggota berjaket merah"/><figcaption class="wp-element-caption">Kampus Anggota</figcaption></figure>
<!-- /wp:image --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

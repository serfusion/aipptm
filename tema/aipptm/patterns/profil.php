<?php
/**
 * Title: Profil: Sambutan Ketua, Visi & Misi
 * Slug: aipptm/profil
 * Categories: aipptm, about
 * Description: Kartu sambutan Ketua Umum di kiri, kartu Visi dan Misi di kanan.
 *
 * Set $aipptm_tanpa_kepala = true sebelum memuat pola ini untuk menyembunyikan judul bagian.
 *
 * @package aipptm
 */
?>
<!-- wp:group {"align":"full","className":"aipptm-profil","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<div id="sambutan" class="wp-block-group alignfull aipptm-profil" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><?php
if ( empty( $aipptm_tanpa_kepala ) ) {
	aipptm_kepala( 'Profil', 'Mengenal lebih dekat AIPPTM: sambutan pimpinan, visi, dan misi asosiasi.' );
}
?><!-- wp:columns {"align":"wide","className":"aipptm-profil__kolom"} -->
<div class="wp-block-columns alignwide aipptm-profil__kolom"><!-- wp:column {"width":"58%"} -->
<div class="wp-block-column" style="flex-basis:58%"><!-- wp:group {"className":"aipptm-kartu-profil aipptm-kartu-profil--sambutan","backgroundColor":"abu","layout":{"type":"default"}} -->
<div class="wp-block-group aipptm-kartu-profil aipptm-kartu-profil--sambutan has-abu-background-color has-background"><!-- wp:paragraph {"className":"aipptm-label"} -->
<p class="aipptm-label">Sambutan Ketua Umum</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Mewujudkan Tata Kelola Pemerintahan yang Berkemajuan dan Berintegritas</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"aipptm-kutipan"} -->
<p class="aipptm-kutipan">“AIPPTM hadir sebagai simpul strategis konsolidasi keilmuan Ilmu Pemerintahan di lingkungan Perguruan Tinggi Muhammadiyah. Melalui sinergi riset, penguatan kurikulum berbasis OBE, dan advokasi kebijakan publik, kita berkomitmen melahirkan kader bangsa yang menjunjung tinggi nilai-nilai <em>Good Governance</em> berlandaskan moral Islam berkemajuan.”</p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"aipptm-penanda","style":{"spacing":{"blockGap":"0.85rem"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group aipptm-penanda"><!-- wp:image {"width":"56px","height":"56px","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"is-style-rounded"} -->
<figure class="wp-block-image size-full is-resized is-style-rounded"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/foto-pengurus.jpg' ) ); ?>" alt="Foto Ketua Umum AIPPTM" style="object-fit:cover;width:56px;height:56px"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph -->
<p><strong>Dr. Phil. Aryo Prasetyo, M.A.</strong><br>Ketua Umum DPP AIPPTM Periode 2024–⁠2028</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"42%"} -->
<div class="wp-block-column" style="flex-basis:42%"><!-- wp:group {"className":"aipptm-kartu-profil","layout":{"type":"default"}} -->
<div id="visi-misi" class="wp-block-group aipptm-kartu-profil"><!-- wp:paragraph {"className":"aipptm-label"} -->
<p class="aipptm-label">Visi Utama</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Menjadi asosiasi keilmuan terdepan dalam pengembangan riset, pendidikan, dan pengabdian masyarakat di bidang Ilmu Pemerintahan yang berwawasan global demi terwujudnya <em>Good Governance</em>.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"aipptm-kartu-profil","layout":{"type":"default"}} -->
<div class="wp-block-group aipptm-kartu-profil"><!-- wp:paragraph {"className":"aipptm-label"} -->
<p class="aipptm-label">Misi Strategis</p>
<!-- /wp:paragraph -->

<!-- wp:list {"className":"aipptm-daftar-centang"} -->
<ul class="wp-block-list aipptm-daftar-centang"><!-- wp:list-item -->
<li>Standardisasi kurikulum prodi ilmu pemerintahan PTM.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Peningkatan akreditasi unggul institusi dan prodi anggota.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Kolaborasi riset nasional dan hilirisasi kebijakan publik.</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

<?php
/**
 * Title: Profil
 * Slug: aipptm/profil
 * Categories: aipptm, about
 */

$aipptm_misi = array(
	array( 'Memperkuat kualitas pendidikan Ilmu Pemerintahan', 'melalui pengembangan kurikulum, peningkatan kompetensi akademik, serta pendampingan mutu dan akreditasi Program Studi Ilmu Pemerintahan di lingkungan Perguruan Tinggi Muhammadiyah.' ),
	array( 'Mengembangkan penelitian dan publikasi ilmiah yang berkualitas', 'melalui kolaborasi antardosen, peneliti, dan mahasiswa guna memperkuat kontribusi keilmuan dalam menjawab berbagai persoalan pemerintahan dan kebijakan publik.' ),
	array( 'Meningkatkan pengabdian kepada masyarakat dan kontribusi terhadap kebijakan publik', 'melalui penerapan hasil penelitian, pemberdayaan masyarakat, serta kerja sama dengan pemerintah dan pemangku kepentingan dalam mewujudkan tata kelola pemerintahan yang baik.' ),
	array( 'Memperluas jejaring dan kemitraan strategis', 'antarperguruan tinggi, asosiasi keilmuan, lembaga pemerintah, organisasi masyarakat, dan mitra internasional guna mendukung pengembangan Ilmu Pemerintahan yang adaptif terhadap perkembangan global.' ),
	array( 'Mendorong inovasi dan transformasi keilmuan pemerintahan', 'melalui pengembangan kajian tata kelola digital, demokrasi, pelayanan publik, kebijakan publik, dan pembangunan berkelanjutan yang responsif terhadap kebutuhan masyarakat.' ),
	array( 'Memperkuat tata kelola organisasi yang profesional, inklusif, dan berkelanjutan', 'dengan mengedepankan prinsip kolaborasi, transparansi, akuntabilitas, serta nilai-nilai Al-Islam dan Kemuhammadiyahan sebagai landasan pengembangan organisasi dan keilmuan.' ),
);
?>
<?php if ( empty( $aipptm_tanpa_kepala ) ) : ?><!-- wp:group {"align":"full","className":"aipptm-profil","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<div id="sambutan" class="wp-block-group alignfull aipptm-profil" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><?php aipptm_kepala( 'Profil', 'Sambutan Ketua Umum serta visi dan misi AIPPTM.' ); ?><?php else : ?><!-- wp:group {"align":"wide","className":"aipptm-profil","layout":{"type":"default"}} -->
<div id="sambutan" class="wp-block-group alignwide aipptm-profil"><?php endif; ?><!-- wp:columns {"align":"wide","className":"aipptm-profil__kolom"} -->
<div class="wp-block-columns alignwide aipptm-profil__kolom"><!-- wp:column {"width":"58%"} -->
<div class="wp-block-column" style="flex-basis:58%"><!-- wp:group {"className":"aipptm-kartu-profil aipptm-kartu-profil--sambutan","backgroundColor":"abu","layout":{"type":"default"}} -->
<div class="wp-block-group aipptm-kartu-profil aipptm-kartu-profil--sambutan has-abu-background-color has-background"><!-- wp:paragraph {"className":"aipptm-label","fontSize":"medium"} -->
<p class="aipptm-label has-medium-font-size">Sambutan Ketua Umum</p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"aipptm-penanda","style":{"spacing":{"blockGap":"1.1rem"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group aipptm-penanda"><!-- wp:image {"width":"150px","height":"150px","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"is-style-rounded aipptm-penanda__foto"} -->
<figure class="wp-block-image size-full is-resized is-style-rounded aipptm-penanda__foto"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/pengurus/ketua-umum.jpg' ) ); ?>" alt="Foto Dr. Dian Suluh Kusumadewi, M.P.A., Ketua Umum AIPPTM" style="object-fit:cover;width:150px;height:150px"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"aipptm-penanda__nama","fontSize":"large"} -->
<p class="aipptm-penanda__nama has-large-font-size"><strong>Dr. Dian Suluh Kusumadewi, M.P.A.</strong><br>Ketua Umum AIPPTM</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Mewujudkan Tata Kelola Pemerintahan yang Berkemajuan dan Berintegritas</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"aipptm-kutipan"} -->
<p class="aipptm-kutipan">“AIPPTM hadir sebagai simpul strategis konsolidasi keilmuan Ilmu Pemerintahan di lingkungan Perguruan Tinggi Muhammadiyah. Melalui sinergi riset, penguatan kurikulum berbasis OBE, dan advokasi kebijakan publik, kita berkomitmen melahirkan kader bangsa yang menjunjung tinggi nilai <em>Good Governance</em> berlandaskan moral Islam berkemajuan.”</p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"aipptm-kartu-profil aipptm-kartu-profil--visi","backgroundColor":"putih","layout":{"type":"default"}} -->
<div id="visi-misi" class="wp-block-group aipptm-kartu-profil aipptm-kartu-profil--visi has-putih-background-color has-background"><!-- wp:paragraph {"className":"aipptm-label","fontSize":"x-large"} -->
<p class="aipptm-label has-x-large-font-size">Visi Utama</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Menjadi asosiasi keilmuan yang unggul, kolaboratif, dan berkemajuan dalam pengembangan pendidikan, penelitian, serta pengabdian kepada masyarakat di bidang Ilmu Pemerintahan, berlandaskan nilai-nilai Al-Islam dan Kemuhammadiyahan untuk mewujudkan tata kelola pemerintahan yang demokratis, inovatif, dan berkeadilan.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"42%"} -->
<div class="wp-block-column" style="flex-basis:42%"><!-- wp:group {"className":"aipptm-kartu-profil aipptm-kartu-profil--misi","fontSize":"medium","layout":{"type":"default"}} -->
<div class="wp-block-group aipptm-kartu-profil aipptm-kartu-profil--misi has-medium-font-size"><!-- wp:paragraph {"className":"aipptm-label","fontSize":"medium"} -->
<p class="aipptm-label has-medium-font-size">Misi Strategis</p>
<!-- /wp:paragraph -->

<!-- wp:list {"className":"aipptm-daftar-centang"} -->
<ul class="wp-block-list aipptm-daftar-centang"><?php foreach ( $aipptm_misi as $aipptm_m ) : ?><!-- wp:list-item {"fontSize":"small"} -->
<li class="has-small-font-size"><strong><?php echo esc_html( $aipptm_m[0] ); ?></strong> <?php echo esc_html( $aipptm_m[1] ); ?></li>
<!-- /wp:list-item --><?php endforeach; ?></ul>
<!-- /wp:list --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

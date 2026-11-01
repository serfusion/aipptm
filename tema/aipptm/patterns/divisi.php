<?php
/**
 * Title: Bidang & Program Kerja
 * Slug: aipptm/divisi
 * Categories: aipptm, about
 */

$aipptm_divisi = array(
	array(
		'kelembagaan',
		'Bidang Kelembagaan & Kerjasama',
		'Memperkuat tata kelola organisasi, memperluas jejaring kemitraan strategis dengan instansi pemerintah, swasta, serta perguruan tinggi nasional maupun internasional guna meningkatkan reputasi serta daya saing institusi secara berkelanjutan.',
		array(
			'Penandatanganan MoU kolaborasi tridarma nasional &amp; internasional',
			'Penguatan forum komunikasi pimpinan prodi secara berkala',
			'Penyusunan &amp; evaluasi AD/ART',
			'Digitalisasi administrasi organisasi',
		),
	),
	array(
		'akreditasi',
		'Bidang Sistem Penjaminan Mutu Internal (SPMI) &amp; Akreditasi',
		'Mengawal peningkatan standar mutu akademik, pendampingan siklus SPMI, serta akselerasi akreditasi unggul nasional dan internasional prodi anggota.',
		array(
			'Pendampingan intensif penyusunan dokumen akreditasi unggul',
			'Pelatihan auditor mutu internal khusus rumpun ilmu pemerintahan',
			'Workshop simulasi <em>Ledger</em> dan <em>Field Assessment</em> mandiri',
			'Sinkronisasi standar SPMI dengan kebijakan akreditasi LAMSPAK',
		),
	),
	array(
		'kurikulum',
		'Bidang Pengembangan Kurikulum',
		'Mengembangkan kurikulum program studi ilmu pemerintahan berbasis capaian pembelajaran (OBE) yang terintegrasi dengan nilai Al-Islam dan Kemuhammadiyahan serta selaras dengan kebutuhan tata kelola pemerintahan digital.',
		array(
			'Review kurikulum prodi berbasis <em>Outcome-Based Education</em> (OBE)',
			'Integrasi nilai-nilai Al-Islam Kemuhammadiyahan dalam mata kuliah',
			'Pengembangan modul digital kolaboratif antar-perguruan tinggi',
			'Penyelarasan kurikulum dengan kebutuhan <em>smart government</em>',
		),
	),
	array(
		'penelitian',
		'Bidang Penelitian &amp; Publikasi',
		'Mendorong kolaborasi riset hibah dosen lintas PTM, klinik jurnal ilmiah menuju indeksasi SINTA dan Scopus, serta penerbitan policy brief sebagai masukan bagi kebijakan tata kelola pemerintahan.',
		array(
			'Kolaborasi riset konsorsium dosen ilmu pemerintahan Muhammadiyah',
			'Pendampingan penulisan artikel jurnal bereputasi Scopus/SINTA',
			'Pembuatan jurnal ilmiah di bawah AIPPTM',
			'Penyusunan &amp; pembuatan <em>Book Chapter</em> internasional',
		),
	),
	array(
		'prestasi-mahasiswa',
		'Bidang Prestasi Mahasiswa',
		'Menumbuhkan prestasi, kreativitas, dan budaya ilmiah mahasiswa ilmu pemerintahan melalui forum riset, pendampingan kompetisi, serta apresiasi karya.',
		array(
			'Konferensi ilmiah tahunan riset mahasiswa ilmu pemerintahan',
			'Pendampingan proposal Program Kreativitas Mahasiswa (PKM)',
			'Apresiasi dan festival inovasi karya tulis mahasiswa',
			'<em>Call Poster</em> mahasiswa ilmu pemerintahan',
		),
	),
);
$aipptm_teks = array( 'em' => array() );
?>
<!-- wp:group {"align":"full","className":"aipptm-divisi","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull aipptm-divisi" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><?php
if ( empty( $aipptm_tanpa_kepala ) ) {
	aipptm_kepala( 'Bidang & Program', 'Program kerja AIPPTM meliputi lima bidang strategis.' );
}
?><!-- wp:group {"align":"wide","className":"aipptm-divisi__grid","layout":{"type":"grid","columnCount":2,"minimumColumnWidth":"22rem"}} -->
<div class="wp-block-group alignwide aipptm-divisi__grid"><?php foreach ( $aipptm_divisi as $aipptm_i => $aipptm_d ) : ?><!-- wp:group {"className":"aipptm-panel-divisi","layout":{"type":"default"}} -->
<div id="<?php echo esc_attr( $aipptm_d[0] ); ?>" class="wp-block-group aipptm-panel-divisi"><!-- wp:paragraph {"className":"aipptm-panel-divisi__nomor"} -->
<p class="aipptm-panel-divisi__nomor"><?php echo esc_html( sprintf( '%02d', $aipptm_i + 1 ) ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><?php echo wp_kses( $aipptm_d[1], $aipptm_teks ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php echo wp_kses( $aipptm_d[2], $aipptm_teks ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:list {"className":"aipptm-daftar-centang"} -->
<ul class="wp-block-list aipptm-daftar-centang"><?php foreach ( $aipptm_d[3] as $aipptm_program ) : ?><!-- wp:list-item -->
<li><?php echo wp_kses( $aipptm_program, $aipptm_teks ); ?></li>
<!-- /wp:list-item --><?php endforeach; ?></ul>
<!-- /wp:list --></div>
<!-- /wp:group --><?php endforeach; ?></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

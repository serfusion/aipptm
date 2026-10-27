<?php
/**
 * Title: Divisi & Program Kerja (4 divisi)
 * Slug: aipptm/divisi
 * Categories: aipptm, about
 * Description: Empat divisi strategis AIPPTM, masing-masing dengan nomor, uraian, dan daftar program.
 *
 * Set $aipptm_tanpa_kepala = true sebelum memuat pola ini untuk menyembunyikan judul bagian.
 *
 * @package aipptm
 */

$aipptm_divisi = array(
	array(
		'organisasi',
		'Organisasi & Tata Kelola',
		'Konsolidasi internal pengurus pusat dan wilayah, penguatan jaringan komunikasi antara program studi ilmu pemerintahan PTM, serta pengelolaan database keanggotaan terpadu berbasis digital.',
		array( 'Rapat Koordinasi Nasional (Rakernas)', 'Konsolidasi forum asosiasi wilayah', 'Penyusunan & evaluasi AD/ART', 'Digitalisasi administrasi organisasi' ),
	),
	array(
		'kerjasama',
		'Kerja Sama Nasional & Internasional',
		'Memperluas jejaring kemitraan dengan instansi pemerintah pusat dan daerah, lembaga legislatif, organisasi masyarakat sipil, serta universitas mitra luar negeri untuk pertukaran dosen dan mahasiswa.',
		array( 'Kemitraan dengan kementerian & pemerintah daerah', 'Jejaring asosiasi ilmu pemerintahan ASEAN', 'Program magang mahasiswa bersertifikat', 'Kuliah tamu pakar pemerintahan' ),
	),
	array(
		'riset',
		'Riset & Publikasi Ilmiah',
		'Mendorong kolaborasi riset hibah dosen lintas PTM, klinik jurnal ilmiah menuju indeksasi SINTA dan Scopus, serta penerbitan policy brief sebagai masukan bagi kebijakan tata kelola pemerintahan.',
		array( 'Kolaborasi riset lintas PTM', 'Pendampingan akreditasi jurnal SINTA', 'Publikasi buku ajar ilmu pemerintahan', 'Penyusunan policy brief nasional' ),
	),
	array(
		'akreditasi',
		'Akreditasi & Kurikulum OBE',
		'Pendampingan penyiapan dokumen akreditasi LAM bagi prodi ilmu pemerintahan PTM, serta standardisasi kurikulum berbasis capaian pembelajaran (OBE) yang sejalan dengan Merdeka Belajar Kampus Merdeka.',
		array( 'Bimbingan teknis dokumen akreditasi', 'Workshop penyusunan kurikulum OBE', 'Mentoring asesor internal prodi', 'Evaluasi capaian pembelajaran lulusan' ),
	),
);
?>
<!-- wp:group {"align":"full","className":"aipptm-divisi","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull aipptm-divisi" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><?php
if ( empty( $aipptm_tanpa_kepala ) ) {
	aipptm_kepala( 'Divisi & Program', 'Program kerja AIPPTM dijalankan oleh empat divisi.' );
}
?><!-- wp:group {"align":"wide","className":"aipptm-divisi__grid","layout":{"type":"grid","columnCount":2,"minimumColumnWidth":"22rem"}} -->
<div class="wp-block-group alignwide aipptm-divisi__grid"><?php foreach ( $aipptm_divisi as $aipptm_i => $aipptm_d ) : ?><!-- wp:group {"className":"aipptm-panel-divisi","layout":{"type":"default"}} -->
<div id="<?php echo esc_attr( $aipptm_d[0] ); ?>" class="wp-block-group aipptm-panel-divisi"><!-- wp:paragraph {"className":"aipptm-panel-divisi__nomor"} -->
<p class="aipptm-panel-divisi__nomor"><?php echo esc_html( sprintf( '%02d', $aipptm_i + 1 ) ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><?php echo esc_html( $aipptm_d[1] ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php echo esc_html( $aipptm_d[2] ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:list {"className":"aipptm-daftar-centang"} -->
<ul class="wp-block-list aipptm-daftar-centang"><?php foreach ( $aipptm_d[3] as $aipptm_program ) : ?><!-- wp:list-item -->
<li><?php echo esc_html( $aipptm_program ); ?></li>
<!-- /wp:list-item --><?php endforeach; ?></ul>
<!-- /wp:list --></div>
<!-- /wp:group --><?php endforeach; ?></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<?php
/**
 * Title: Pengurus
 * Slug: aipptm/pengurus
 * Categories: aipptm, team
 */

$aipptm_foto = esc_url( get_theme_file_uri( 'assets/images/foto-pengurus.jpg' ) );
$aipptm_inti = array(
	array( 'Dr. Dian Suluh Kusumadewi, M.P.A.', 'Ketua Umum', 'UM Ponorogo' ),
	array( 'Muhammad Eko Atmojo, S.IP., M.IP.', 'Sekretaris Umum', 'UM Yogyakarta' ),
	array( 'Dr. Toddy Aditya, M.Si.', 'Wakil Sekretaris', 'UM Tangerang' ),
	array( 'Muhammad Kamil, S.IP., M.A.', 'Bendahara Umum', 'UM Malang' ),
);
$aipptm_dewan = array(
	'Dewan Penasihat' => array(
		array( 'Prof. Dr. Achmad Nurmandi, M.Sc.', 'UM Yogyakarta' ),
		array( 'Prof. Dr. Tri Sulistyaningsih, M.Si.', 'UM Malang' ),
	),
	'Dewan Pakar'     => array(
		array( 'Prof. Eko Priyo Purnomo, S.IP., M.Si., M.Res., Ph.D.', 'UM Yogyakarta' ),
		array( 'Prof. Dr. Dyah Mutiarin, M.Si.', 'UM Yogyakarta' ),
		array( 'Prof. Dr. Titin Purwaningsih, M.Si.', 'UM Yogyakarta' ),
	),
);
$aipptm_bidang = array(
	'Kelembagaan dan Kerja Sama'      => array(
		array( 'Dr. Salahudin, M.Si.', 'UM Malang' ),
		array( 'Nursaleh Hartaman, S.IP., M.IP.', 'UM Makassar' ),
		array( 'Sastra Abijaya, M.Si.', 'UM Cirebon' ),
		array( 'Masni Banggu, S.IP., M.Si.', 'UM Sorong' ),
		array( 'La Ode Muhammad Azhar Sa\'ban, S.H., M.IP.', 'UM Buton' ),
	),
	'SPMI dan Akreditasi'             => array(
		array( 'Dr. Awang Darumurti, M.Si.', 'UM Yogyakarta' ),
		array( 'Rasid Pora, S.IP., M.IP.', 'UM Maluku Utara' ),
		array( 'Yusuf Fadli, S.IP., M.Soc.Sc.', 'UM Tangerang' ),
		array( 'Nur Khaerah, S.IP., M.IP.', 'UM Makassar' ),
		array( 'Dr. Iffan Gallant El Muhammady, S.Sos., M.Si.', 'UM Jember' ),
	),
	'Pengembangan Kurikulum'          => array(
		array( 'Dr. Tunjung Sulaksono, M.Si.', 'UM Yogyakarta' ),
		array( 'Eny Inti Suryani, S.I.P., M.I.P.', 'UM Lampung' ),
		array( 'Sofyan, S.IP., M.IP.', 'UNIMUDA Sorong' ),
		array( 'Abd. Wahid, S.Sos., M.AP.', 'UM Sinjai' ),
		array( 'Muhammad Nurul Huda, S.IP., M.IP.', 'UM Karanganyar' ),
	),
	'Pengembangan Kompetensi SDM'     => array(
		array( 'Dr. Muhammad Lutfi, S.IP., M.Si.', 'UM Sinjai' ),
		array( 'Yudi Lestananta, S.IP., M.IP.', 'UM Mataram' ),
		array( 'Dr. La Ode Wahiyudin, M.Si.', 'UM Kendari' ),
		array( 'Hamrun, S.IP., M.IP.', 'UM Makassar' ),
		array( 'Irfan Nur Ridho, M.Si.', 'UM Ponorogo' ),
	),
	'Penelitian dan Publikasi'        => array(
		array( 'Ali Roziqin, S.IP., M.AP.', 'UM Malang' ),
		array( 'Adie Dwiyanto Nurlukman, M.A.', 'UM Tangerang' ),
		array( 'Haminun, M.Si.', 'UM Luwuk' ),
		array( 'Sandi Lubis, S.IP., M.Si.', 'UM Sidenreng Rappang' ),
		array( 'Yusuf Adam Hilman, S.Sos., M.Si.', 'UM Ponorogo' ),
	),
	'Prestasi Mahasiswa'              => array(
		array( 'Helen Dian Fridayani, S.IP., M.IP., Ph.D.', 'UM Yogyakarta' ),
		array( 'Iradhat Taqwa, S.IP., M.A.', 'UM Malang' ),
		array( 'Binaridha Kusuma Ningtyas, S.IP., M.IP.', 'UM Jember' ),
		array( 'Aqmal Reza Amril, S.IP., M.Phil.', 'UM Makassar' ),
		array( 'Hidayatullah, S.IP., M.IP.', 'UM Mataram' ),
	),
);
$aipptm_daftar = static function ( $orang ) {
	$out = '<!-- wp:list {"ordered":true,"className":"aipptm-daftar-pengurus"} -->' . "\n" . '<ol class="wp-block-list aipptm-daftar-pengurus">';
	foreach ( $orang as $o ) {
		$out .= '<!-- wp:list-item -->' . "\n" . '<li>' . esc_html( $o[0] ) . ' <span class="aipptm-asal">' . esc_html( $o[1] ) . '</span></li>' . "\n" . '<!-- /wp:list-item -->';
	}
	return $out . '</ol>' . "\n" . '<!-- /wp:list -->';
};
$aipptm_kartu = static function ( $judul, $orang ) use ( $aipptm_daftar ) {
	return '<!-- wp:group {"className":"aipptm-kartu-bidang","layout":{"type":"default"}} -->' . "\n"
		. '<div class="wp-block-group aipptm-kartu-bidang"><!-- wp:heading {"level":3} -->' . "\n"
		. '<h3 class="wp-block-heading">' . esc_html( $judul ) . '</h3>' . "\n"
		. '<!-- /wp:heading -->' . "\n\n"
		. $aipptm_daftar( $orang ) . '</div>' . "\n"
		. '<!-- /wp:group -->';
};
?>
<!-- wp:group {"align":"full","className":"aipptm-pengurus","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull aipptm-pengurus" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><?php
if ( empty( $aipptm_tanpa_kepala ) ) {
	aipptm_kepala( 'Pengurus', 'Pengurus AIPPTM masa jabatan 2026 sampai 2028.' );
}
?><!-- wp:group {"align":"wide","className":"aipptm-pengurus__judul","layout":{"type":"constrained","contentSize":"860px"}} -->
<div class="wp-block-group alignwide aipptm-pengurus__judul"><!-- wp:paragraph {"align":"center","className":"aipptm-label"} -->
<p class="has-text-align-center aipptm-label">Pengangkatan Pengurus</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textAlign":"center","level":2} -->
<h2 class="wp-block-heading has-text-align-center">Pengurus Asosiasi Ilmu Pemerintahan Perguruan Tinggi Muhammadiyah Seluruh Indonesia</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Masa Jabatan 2026 sampai 2028</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:columns {"align":"wide","className":"aipptm-pengurus__kolom"} -->
<div class="wp-block-columns alignwide aipptm-pengurus__kolom"><?php foreach ( $aipptm_inti as $aipptm_orang ) : ?><!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"align":"center","sizeSlug":"full","linkDestination":"none","className":"is-style-rounded"} -->
<figure class="wp-block-image aligncenter size-full is-style-rounded"><img src="<?php echo $aipptm_foto; ?>" alt="Foto <?php echo esc_attr( $aipptm_orang[0] ); ?>"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"align":"center","className":"aipptm-label"} -->
<p class="has-text-align-center aipptm-label"><?php echo esc_html( $aipptm_orang[1] ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textAlign":"center","level":3} -->
<h3 class="wp-block-heading has-text-align-center"><?php echo esc_html( $aipptm_orang[0] ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><?php echo esc_html( $aipptm_orang[2] ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --><?php endforeach; ?></div>
<!-- /wp:columns -->

<!-- wp:group {"align":"wide","className":"aipptm-pengurus__dewan","layout":{"type":"grid","columnCount":2,"minimumColumnWidth":"20rem"}} -->
<div class="wp-block-group alignwide aipptm-pengurus__dewan"><?php foreach ( $aipptm_dewan as $aipptm_j => $aipptm_o ) { echo $aipptm_kartu( $aipptm_j, $aipptm_o ) . "\n\n"; } ?></div>
<!-- /wp:group -->

<!-- wp:heading {"align":"wide","className":"aipptm-pengurus__sub"} -->
<h2 class="wp-block-heading alignwide aipptm-pengurus__sub">Bidang</h2>
<!-- /wp:heading -->

<!-- wp:group {"align":"wide","className":"aipptm-pengurus__bidang","layout":{"type":"grid","columnCount":3,"minimumColumnWidth":"19rem"}} -->
<div class="wp-block-group alignwide aipptm-pengurus__bidang"><?php foreach ( $aipptm_bidang as $aipptm_j => $aipptm_o ) { echo $aipptm_kartu( 'Bidang ' . $aipptm_j, $aipptm_o ) . "\n\n"; } ?></div>
<!-- /wp:group -->

<!-- wp:paragraph {"align":"center","className":"aipptm-pengurus__sk"} -->
<p class="has-text-align-center aipptm-pengurus__sk">Lampiran Keputusan Majelis Pendidikan Tinggi Penelitian dan Pengembangan (Diktilitbang) Pimpinan Pusat Muhammadiyah Nomor 0045/KEP/I.3/B/2026</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<?php
/**
 * Title: Direktori Anggota PTM
 * Slug: aipptm/direktori
 * Categories: aipptm, about
 */

$aipptm_ptm = array(
	array( 'Universitas Muhammadiyah Makassar', '4572/SK/BAN-PT/Ak.KP/S/VI/2024', '2024', 'Unggul', '4 Juni 2029' ),
	array( 'Universitas Muhammadiyah Malang', '10016/SK/BAN-PT/Ak.Ppj/S/II/2023', '2023', 'Unggul', '8 Februari 2028' ),
	array( 'Universitas Muhammadiyah Tangerang', '3003/SK/BAN-PT/Ak-PPJ/S/V/2021', '2026', 'Unggul', '21 April 2031' ),
	array( 'Universitas Muhammadiyah Yogyakarta', '4580/SK/BAN-PT/Ak.Ppj/S/VI/2024', '2024', 'Unggul', '19 Juni 2029' ),
	array( 'Universitas Muhammadiyah Mataram', '2982/SK/BAN-PT/Ak-PPJ/S/V/2020', '2025', 'Unggul', '16 Desember 2030' ),
	array( 'Universitas Muhammadiyah Jember', '7856/SK/BAN-PT/Akred/S/XII/2020', '2026', 'Unggul', '2 Desember 2030' ),
	array( 'Universitas Muhammadiyah Ponorogo', '2502/SK/BAN-PT/Ak-PPJ/S/IV/2022', '2022', 'Baik Sekali', '19 April 2027' ),
	array( 'Universitas Muhammadiyah Luwuk Banggai', '6250/SK/BAN-PT/Ak.KP/S/IX/2022', '2022', 'Baik', '20 Desember 2023' ),
	array( 'Universitas Muhammadiyah Sinjai', '6544/SK/BAN-PT/Ak.PEPS/S/IX/2022', '2022', 'Baik Sekali', '11 Oktober 2023' ),
	array( 'Universitas Muhammadiyah Sidenreng Rappang', '12322/SK/BAN-PT/Akred/S/XI/2021', '2021', 'Baik Sekali', '10 November 2026' ),
	array( 'Universitas Muhammadiyah Buton', '12829/SK/BAN-PT/Ak-PPJ/S/XII/2021', '2021', 'B', '2 Desember 2026' ),
	array( 'Universitas Muhammadiyah Cirebon', '1750/SK/BAN-PT/Ak-PPJ/S/III/2020', '2025', 'Terakreditasi', '18 Juni 2030' ),
	array( 'Universitas Muhammadiyah Maluku Utara', '1978/SK/BAN-PT/Ak-PPJ/S/III/2020', '2020', 'Baik Sekali', '29 Maret 2025' ),
	array( 'Universitas Muhammadiyah Sorong', '4447/SK/BAN-PT/Ak-PPJ/S/VIII/2020', '2020', 'B', '4 Agustus 2025' ),
	array( 'Universitas Muhammadiyah Lampung', '4921/SK/BAN-PT/Ak-PPJ/S/VIII/2020', '2025', 'Terakreditasi', '23 Desember 2030' ),
	array( 'Universitas Muhammadiyah Kendari', '1366/SK/BAN-PT/Akred/S/V/2019', '2019', 'B', '7 Mei 2024' ),
	array( 'Universitas Muhammadiyah Pendidikan Sorong', '', '2019', 'Baik', '' ),
	array( 'Universitas Muhammadiyah Karanganyar', '', '', '', '' ),
	array( 'Universitas Muhammadiyah Indonesia', '', '', '', '' ),
);
$aipptm_semua = ! empty( $aipptm_tanpa_kepala );
if ( ! $aipptm_semua ) {
	$aipptm_ptm = array_slice( $aipptm_ptm, 0, 6 );
}
?>
<!-- wp:group {"align":"full","className":"aipptm-direktori","backgroundColor":"abu","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull aipptm-direktori has-abu-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><?php if ( ! $aipptm_semua ) : ?><?php aipptm_kepala( 'Direktori Anggota', 'Program studi ilmu pemerintahan di jaringan Perguruan Tinggi Muhammadiyah seluruh Indonesia.' ); ?><?php else : ?><!-- wp:group {"align":"wide","className":"aipptm-pengantar","layout":{"type":"constrained","contentSize":"760px"}} -->
<div class="wp-block-group alignwide aipptm-pengantar"><!-- wp:paragraph {"align":"center","className":"aipptm-lencana aipptm-lencana--tua"} -->
<p class="has-text-align-center aipptm-lencana aipptm-lencana--tua">Asosiasi Ilmu Pemerintahan Perguruan Tinggi Muhammadiyah</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">Direktori Anggota AIPPTM</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Direktori resmi yang menampung 19 perguruan tinggi anggota pengelola Program Studi Ilmu Pemerintahan di lingkungan Perguruan Tinggi Muhammadiyah di seluruh Indonesia.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<?php endif; ?><!-- wp:group {"align":"wide","className":"aipptm-direktori__grid<?php echo $aipptm_semua ? ' aipptm-saring' : ''; ?>","layout":{"type":"grid","columnCount":3,"minimumColumnWidth":"17rem"}} -->
<div class="wp-block-group alignwide aipptm-direktori__grid<?php echo $aipptm_semua ? ' aipptm-saring' : ''; ?>"><?php foreach ( $aipptm_ptm as $aipptm_kampus ) : ?><!-- wp:group {"className":"aipptm-kartu-ptm","backgroundColor":"putih","layout":{"type":"default"}} -->
<div class="wp-block-group aipptm-kartu-ptm has-putih-background-color has-background"><!-- wp:group {"className":"aipptm-kartu-ptm__atas","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group aipptm-kartu-ptm__atas"><!-- wp:paragraph {"className":"aipptm-akreditasi"} -->
<p class="aipptm-akreditasi"><?php echo esc_html( '' !== $aipptm_kampus[3] ? $aipptm_kampus[3] : 'Dalam Proses' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"aipptm-kartu-ptm__prodi"} -->
<p class="aipptm-kartu-ptm__prodi">S1 Ilmu Pemerintahan</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><?php echo esc_html( $aipptm_kampus[0] ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"aipptm-kartu-ptm__sk"} -->
<p class="aipptm-kartu-ptm__sk"><strong>No. SK:</strong> <?php echo esc_html( '' !== $aipptm_kampus[1] ? $aipptm_kampus[1] : 'Dalam pengajuan' ); ?><br><strong>Tahun SK:</strong> <?php echo esc_html( '' !== $aipptm_kampus[2] ? $aipptm_kampus[2] : '–' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"aipptm-kartu-ptm__masa"} -->
<p class="aipptm-kartu-ptm__masa">Masa berlaku <strong><?php echo esc_html( '' !== $aipptm_kampus[4] ? $aipptm_kampus[4] : '–' ); ?></strong></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --><?php endforeach; ?></div>
<!-- /wp:group --><?php if ( ! $aipptm_semua ) : ?>

<!-- wp:buttons {"align":"wide","className":"aipptm-aksi-bawah","layout":{"type":"flex","justifyContent":"left"}} -->
<div class="wp-block-buttons alignwide aipptm-aksi-bawah"><!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="/direktori-anggota/">Lihat semua anggota PTM</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --><?php endif; ?></div>
<!-- /wp:group -->

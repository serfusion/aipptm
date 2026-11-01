<?php
/**
 * Title: Jurnal Afiliasi
 * Slug: aipptm/jurnal-afiliasi
 * Categories: aipptm, call-to-action
 * Description: Daftar jurnal ilmu pemerintahan terafiliasi AIPPTM lengkap dengan sampul, peringkat SINTA, ISSN, penerbit, dan tautan.
 */

$aipptm_jurnal = array(
	array( 'jsp', 'Jurnal Studi Pemerintahan (JSP)', 'Universitas Muhammadiyah Yogyakarta', '2', '1907-8374', '2337-8220', 'https://jsp.umy.ac.id/index.php/jsp' ),
	array( 'politico', 'Politico', 'Universitas Muhammadiyah Jember', '4', '1829-6696', '2549-4716', 'http://jurnal.unmuhjember.ac.id/index.php/POLITICO' ),
	array( 'logos', 'Journal of Local Government Issues (LOGOS)', 'Universitas Muhammadiyah Malang', '1', '2620-8091', '2620-3812', 'https://ejournal.umm.ac.id/index.php/LOGOS/' ),
	array( 'jgpp', 'Journal of Governance and Public Policy (JGPP)', 'Magister Ilmu Pemerintahan Universitas Muhammadiyah Yogyakarta', '1', '2355-8695', '2549-7669', 'https://journal.umy.ac.id/index.php/GPP/about' ),
	array( 'otoritas', 'Otoritas: Jurnal Ilmu Pemerintahan', 'Universitas Muhammadiyah Makassar', '1', '2088-3706', '2502-9320', 'https://journal.unismuh.ac.id/index.php/otoritas' ),
	array( 'jgcs', 'Journal of Government and Civil Society', 'Universitas Muhammadiyah Tangerang', '2', '2579-4396', '2579-440X', 'https://jurnal.umt.ac.id/index.php/jgs' ),
	array( 'jgop', 'Journal of Government and Politics (JGOP)', 'Universitas Muhammadiyah Mataram', '3', '2774-728X', '2686-3391', 'https://journal.ummat.ac.id/index.php/JSIP' ),
	array( 'jsip', 'JSIP: Jurnal Studi Ilmu Pemerintahan', 'Universitas Muhammadiyah Buton', '5', '', '2722-7405', 'https://jurnal-umbuton.ac.id/jsip/about' ),
	array( 'kybernan', 'Kybernan: Jurnal Studi Kepemerintahan', 'Universitas Muhammadiyah Buton', '4', '2502-2539', '2684-9836', 'https://jurnal-umbuton.ac.id/index.php/Kybernan/index' ),
	array( 'jgi', 'Journal of Government Insight (JGI)', 'Universitas Muhammadiyah Sinjai', '5', '', '2798-7418', 'https://jurnal-umsi.ac.id/index.php/jgi' ),
);
?>
<!-- wp:group {"align":"wide","className":"aipptm-jurnal-afiliasi","layout":{"type":"default"}} -->
<div id="jurnal-afiliasi" class="wp-block-group alignwide aipptm-jurnal-afiliasi"><!-- wp:group {"className":"aipptm-pengantar","layout":{"type":"constrained","contentSize":"760px"}} -->
<div class="wp-block-group aipptm-pengantar"><!-- wp:paragraph {"align":"center","className":"aipptm-lencana aipptm-lencana--muda"} -->
<p class="has-text-align-center aipptm-lencana aipptm-lencana--muda">Publikasi Ilmiah Akademik</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">Jurnal Afiliasi</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Jurnal-jurnal dalam bidang kajian Ilmu Pemerintahan yang dikelola dan dipublikasikan oleh Perguruan Tinggi Muhammadiyah.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"aipptm-jurnal__grid aipptm-saring","layout":{"type":"grid","columnCount":5,"minimumColumnWidth":"12.5rem"}} -->
<div class="wp-block-group aipptm-jurnal__grid aipptm-saring"><?php foreach ( $aipptm_jurnal as $aipptm_j ) : ?><!-- wp:group {"className":"aipptm-kartu-jurnal","layout":{"type":"default"}} -->
<div class="wp-block-group aipptm-kartu-jurnal"><!-- wp:image {"sizeSlug":"full","linkDestination":"custom","className":"aipptm-kartu-jurnal__sampul"} -->
<figure class="wp-block-image size-full aipptm-kartu-jurnal__sampul"><a href="<?php echo esc_url( $aipptm_j[6] ); ?>" target="_blank" rel="noreferrer noopener"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/jurnal/' . $aipptm_j[0] . '.jpg' ) ); ?>" alt="Sampul <?php echo esc_attr( $aipptm_j[1] ); ?>"/></a></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"aipptm-sinta"} -->
<p class="aipptm-sinta">SINTA <?php echo esc_html( $aipptm_j[3] ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><?php echo esc_html( $aipptm_j[1] ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"aipptm-kartu-jurnal__penerbit"} -->
<p class="aipptm-kartu-jurnal__penerbit"><?php echo esc_html( $aipptm_j[2] ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"aipptm-kartu-jurnal__issn"} -->
<p class="aipptm-kartu-jurnal__issn"><?php
	$aipptm_issn = array();
	if ( '' !== $aipptm_j[4] ) {
		$aipptm_issn[] = 'p-ISSN ' . esc_html( $aipptm_j[4] );
	}
	if ( '' !== $aipptm_j[5] ) {
		$aipptm_issn[] = 'e-ISSN ' . esc_html( $aipptm_j[5] );
	}
	echo implode( '<br>', $aipptm_issn );
?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"aipptm-tautan-panah"} -->
<p class="aipptm-tautan-panah"><a href="<?php echo esc_url( $aipptm_j[6] ); ?>" target="_blank" rel="noreferrer noopener">Kunjungi jurnal</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --><?php endforeach; ?></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

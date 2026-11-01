<?php
/**
 * Title: Sejarah Perkembangan (Linimasa)
 * Slug: aipptm/sejarah
 * Categories: aipptm, about
 */

$aipptm_linimasa = array(
	array(
		'Desember 2012 – 2013',
		'Konsorsium Awal &amp; Pendirian Resmi',
		'Bermula dari konsorsium Program Studi Ilmu Pemerintahan pada Desember 2012, dilanjutkan Simposium di Kota Malang (2013) yang melibatkan 8 perguruan tinggi. Di bawah kepemimpinan <strong>Dr. Achmad Nurmandi, M.Sc.</strong>, organisasi dikonsolidasikan untuk memperkuat jejaring akademik, kurikulum, dan publikasi ilmiah.',
		'Fase Inisiasi &amp; Konsolidasi Kelembagaan',
	),
	array(
		'Tahun 2019',
		'Kepemimpinan Prof. Dr. Tri Sulistyaningsih, M.Si.',
		'Kepemimpinan dilanjutkan oleh <strong>Prof. Dr. Tri Sulistyaningsih, M.Si.</strong> Melalui simposium nasional, seminar, dan lokakarya yang digelar bergantian antarkampus, AIPPTM memperkuat perannya merespons dinamika reformasi birokrasi, pelayanan publik, dan transformasi digital.',
		'Perluasan Peran &amp; Transformasi Digital',
	),
	array(
		'Tahun 2023',
		'Munas Universitas Muhammadiyah Yogyakarta',
		'Musyawarah Nasional di UMY kembali mempercayai <strong>Prof. Dr. Tri Sulistyaningsih, M.Si.</strong> untuk memimpin, didampingi <strong>Muhammad Eko Atmojo, S.IP., M.IP.</strong> sebagai Wakil Ketua Umum. Fokus diarahkan pada peningkatan mutu pendidikan, pendampingan akreditasi, dan kolaborasi riset.',
		'Penguatan Akreditasi &amp; Mutu Akademik',
	),
	array(
		'Februari 2026',
		'Munas UM Kendari &amp; Era Kepemimpinan Baru',
		'Jejaring keanggotaan berkembang menjadi 18 perguruan tinggi. Munas di Universitas Muhammadiyah Kendari menetapkan <strong>Dr. Dian Suluh Kusumadewi, M.P.A.</strong> sebagai Ketua Umum periode 2026–2028, membawa semangat kolaborasi yang inklusif, responsif, dan berorientasi publik.',
		'Era Baru &amp; Ekspansi Jejaring 18 PTM',
	),
);
$aipptm_teks = array( 'strong' => array() );
?>
<!-- wp:group {"align":"wide","className":"aipptm-sejarah","layout":{"type":"constrained","contentSize":"980px"}} -->
<div id="sejarah" class="wp-block-group alignwide aipptm-sejarah"><!-- wp:group {"className":"aipptm-sejarah__kepala","layout":{"type":"constrained","contentSize":"720px"}} -->
<div class="wp-block-group aipptm-sejarah__kepala"><!-- wp:paragraph {"align":"center","className":"aipptm-lencana aipptm-lencana--tua"} -->
<p class="has-text-align-center aipptm-lencana aipptm-lencana--tua">Linimasa Berkemajuan</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">Sejarah Perkembangan AIPPTM</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Jejak langkah Asosiasi Ilmu Pemerintahan Perguruan Tinggi Muhammadiyah sebagai wadah kolaborasi akademik yang inklusif, inovatif, dan berorientasi pada kepentingan publik.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"aipptm-linimasa","layout":{"type":"default"}} -->
<div class="wp-block-group aipptm-linimasa"><?php foreach ( $aipptm_linimasa as $aipptm_i => $aipptm_l ) : ?><!-- wp:group {"className":"aipptm-linimasa__item","layout":{"type":"default"}} -->
<div class="wp-block-group aipptm-linimasa__item"><!-- wp:paragraph {"className":"aipptm-linimasa__nomor"} -->
<p class="aipptm-linimasa__nomor"><?php echo esc_html( sprintf( '%02d', $aipptm_i + 1 ) ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"aipptm-linimasa__kartu","layout":{"type":"default"}} -->
<div class="wp-block-group aipptm-linimasa__kartu"><!-- wp:paragraph {"className":"aipptm-linimasa__waktu"} -->
<p class="aipptm-linimasa__waktu"><?php echo esc_html( $aipptm_l[0] ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><?php echo wp_kses( $aipptm_l[1], $aipptm_teks ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php echo wp_kses( $aipptm_l[2], $aipptm_teks ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"aipptm-linimasa__fase"} -->
<p class="aipptm-linimasa__fase"><?php echo wp_kses( $aipptm_l[3], $aipptm_teks ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --><?php endforeach; ?></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<?php
/**
 * Title: Beranda AIPPTM
 * Slug: aipptm/beranda
 * Categories: aipptm
 * Block Types: core/post-content
 * Post Types: page
 */

foreach ( array( 'hero', 'angka', 'sorotan', 'profil', 'direktori', 'divisi', 'publikasi', 'berita' ) as $aipptm_bagian ) {
	require __DIR__ . '/' . $aipptm_bagian . '.php';
	echo "\n\n";
}

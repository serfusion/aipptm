<?php
/**
 * Title: Beranda AIPPTM (halaman lengkap)
 * Slug: aipptm/beranda
 * Categories: aipptm
 * Block Types: core/post-content
 * Post Types: page
 * Description: Seluruh bagian beranda: banner, angka, mosaik sorotan, profil, direktori anggota, divisi, publikasi, dan berita.
 *
 * @package aipptm
 */

foreach ( array( 'hero', 'angka', 'sorotan', 'profil', 'direktori', 'divisi', 'publikasi', 'berita' ) as $aipptm_bagian ) {
	require __DIR__ . '/' . $aipptm_bagian . '.php';
	echo "\n\n";
}

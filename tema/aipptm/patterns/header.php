<?php
/**
 * Title: Header AIPPTM
 * Slug: aipptm/header
 * Categories: header
 * Block Types: core/template-part/header
 * Inserter: no
 *
 * Ikon media sosial tanpa alamat tidak tampil di website (hanya tampak pudar di editor).
 * Isi alamatnya lewat Tampilan › Editor › Pola › Header (lihat tutorial-media-sosial.html).
 *
 * @package aipptm
 */
?>
<!-- wp:group {"align":"full","className":"aipptm-topbar","backgroundColor":"merah","textColor":"putih","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull aipptm-topbar has-putih-color has-merah-background-color has-text-color has-background"><!-- wp:group {"align":"wide","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group alignwide"><!-- wp:paragraph -->
<p><a href="mailto:sekretariat@aipptm.org">sekretariat@aipptm.org</a>  ·  Yogyakarta &amp; Jakarta, Indonesia</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><a href="https://journal.aipptm.org">Jurnal AIPPTM</a>  ·  <a href="/wp-login.php">Masuk Anggota</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"aipptm-header","backgroundColor":"putih","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull aipptm-header has-putih-background-color has-background"><!-- wp:group {"align":"wide","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group alignwide"><!-- wp:group {"style":{"spacing":{"blockGap":"0.75rem"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:site-logo {"width":52,"shouldSyncIcon":false} /-->

<!-- wp:group {"className":"aipptm-brand","style":{"spacing":{"blockGap":"0.1rem"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group aipptm-brand"><!-- wp:site-title {"level":0} /-->

<!-- wp:site-tagline /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:navigation {"overlayMenu":"mobile","className":"aipptm-nav","layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"blockGap":"1.35rem"}}} -->
<!-- wp:navigation-submenu {"label":"Profil","url":"/profil/","kind":"custom"} -->
<!-- wp:navigation-link {"label":"Tentang AIPPTM","url":"/profil/","kind":"custom"} /-->
<!-- wp:navigation-link {"label":"Sambutan, Visi & Misi","url":"/profil/#sambutan","kind":"custom"} /-->
<!-- wp:navigation-link {"label":"Pengurus","url":"/pengurus/","kind":"custom"} /-->
<!-- /wp:navigation-submenu -->

<!-- wp:navigation-submenu {"label":"Keanggotaan PTM","url":"/direktori-anggota/","kind":"custom"} -->
<!-- wp:navigation-link {"label":"Direktori Anggota PTM","url":"/direktori-anggota/","kind":"custom"} /-->
<!-- wp:navigation-link {"label":"Cara Bergabung","url":"/keanggotaan/","kind":"custom"} /-->
<!-- /wp:navigation-submenu -->

<!-- wp:navigation-link {"label":"Divisi & Program","url":"/divisi-program/","kind":"custom"} /-->

<!-- wp:navigation-submenu {"label":"Publikasi","url":"/publikasi/","kind":"custom"} -->
<!-- wp:navigation-link {"label":"Jurnal AIPPTM (OJS)","url":"https://journal.aipptm.org","kind":"custom"} /-->
<!-- wp:navigation-link {"label":"Jurnal Mitra & E-Book","url":"/publikasi/","kind":"custom"} /-->
<!-- /wp:navigation-submenu -->

<!-- wp:navigation-submenu {"label":"Berita & Agenda","url":"/berita/","kind":"custom"} -->
<!-- wp:navigation-link {"label":"Berita","url":"/berita/","kind":"custom"} /-->
<!-- wp:navigation-link {"label":"Agenda Kegiatan","url":"/agenda/","kind":"custom"} /-->
<!-- /wp:navigation-submenu -->

<!-- wp:navigation-link {"label":"Kontak","url":"/kontak/","kind":"custom"} /-->
<!-- /wp:navigation -->

<!-- wp:group {"className":"aipptm-header-aksi","style":{"spacing":{"blockGap":"1rem"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group aipptm-header-aksi"><!-- wp:social-links {"iconColor":"teks","iconColorValue":"#1F2328","className":"is-style-logos-only aipptm-sosial-header","style":{"spacing":{"blockGap":{"left":"0.9rem"}}}} -->
<ul class="wp-block-social-links has-icon-color is-style-logos-only aipptm-sosial-header"><!-- wp:social-link {"service":"linkedin","label":"LinkedIn AIPPTM"} /-->

<!-- wp:social-link {"service":"instagram","label":"Instagram AIPPTM"} /-->

<!-- wp:social-link {"service":"facebook","label":"Facebook AIPPTM"} /-->

<!-- wp:social-link {"url":"mailto:sekretariat@aipptm.org","service":"mail","label":"Email AIPPTM"} /-->

<!-- wp:social-link {"service":"youtube","label":"YouTube AIPPTM"} /--></ul>
<!-- /wp:social-links -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/keanggotaan/">Gabung</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

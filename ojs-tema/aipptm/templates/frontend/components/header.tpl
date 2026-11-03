{**
 * plugins/themes/aipptm/templates/frontend/components/header.tpl
 *
 * Distributed under the GNU GPL v3.
 *
 * @brief Header tema AIPPTM: bar atas hitam, lalu logo dan judul jurnal di header putih.
 *  Struktur bawaan OJS (menu, menu pengguna, tombol menu ponsel) dipertahankan.
 *}
{strip}
	{assign var="showingLogo" value=true}
	{if !$displayPageHeaderLogo}
		{assign var="showingLogo" value=false}
	{/if}
{/strip}
<!DOCTYPE html>
<html lang="{$currentLocale|replace:"_":"-"}" xml:lang="{$currentLocale|replace:"_":"-"}">
{if !$pageTitleTranslated}{capture assign="pageTitleTranslated"}{translate key=$pageTitle}{/capture}{/if}
{include file="frontend/components/headerHead.tpl"}
<body class="pkp_page_{$requestedPage|escape|default:"index"} pkp_op_{$requestedOp|escape|default:"index"}{if $showingLogo} has_site_logo{/if} aipptm{if $aipptmBarAtas} aipptm-ada-bar{/if}" dir="{$currentLocaleLangDir|escape|default:"ltr"}">

	<div class="pkp_structure_page">

		{if $aipptmBarAtas}
			<div class="aipptm-bar">
				<div class="aipptm-bar__isi">
					<div class="aipptm-bar__kiri">
						{if $aipptmEmail}
							<a class="aipptm-bar__surel" href="mailto:{$aipptmEmail|escape}">
								<span class="fa fa-envelope" aria-hidden="true"></span>
								{$aipptmEmail|escape}
							</a>
						{/if}
						{if $aipptmLokasi}
							<span class="aipptm-bar__lokasi">
								<span class="fa fa-map-marker" aria-hidden="true"></span>
								{$aipptmLokasi|escape}
							</span>
						{/if}
					</div>
					<div class="aipptm-bar__kanan">
						{if $aipptmUrlWebsite}
							<a class="aipptm-bar__website" href="{$aipptmUrlWebsite|escape}">
								<span class="fa fa-globe" aria-hidden="true"></span>
								{$aipptmLabelWebsite|default:$aipptmUrlWebsite|escape}
							</a>
						{/if}
					</div>
				</div>
			</div>
		{/if}

		<header class="pkp_structure_head" id="headerNavigationContainer" role="banner">
			{include file="frontend/components/skipLinks.tpl"}

			<div class="pkp_head_wrapper">

				<div class="pkp_site_name_wrapper">
					<button class="pkp_site_nav_toggle">
						<span>Open Menu</span>
					</button>
					{if !$requestedPage || $requestedPage === 'index'}
						<h1 class="pkp_screen_reader">
							{if $currentContext}
								{$displayPageHeaderTitle|escape}
							{else}
								{$siteTitle|escape}
							{/if}
						</h1>
					{/if}
					<div class="pkp_site_name">
					{capture assign="homeUrl"}
						{url page="index" router=PKP\core\PKPApplication::ROUTE_PAGE}
					{/capture}
					{if $displayPageHeaderLogo}
						<a href="{$homeUrl}" class="is_img">
							<img src="{$publicFilesDir}/{$displayPageHeaderLogo.uploadName|escape:"url"}" width="{$displayPageHeaderLogo.width|escape}" height="{$displayPageHeaderLogo.height|escape}" {if $displayPageHeaderLogo.altText != ''}alt="{$displayPageHeaderLogo.altText|escape}"{/if} />
						</a>
					{else}
						<a href="{$homeUrl}" class="is_text aipptm-merek">
							{if $aipptmLogoAipptm}
								<img class="aipptm-merek__logo" src="{$aipptmLogoUrl|escape}" width="56" height="56" alt="" />
							{/if}
							<span class="aipptm-merek__teks">
								<span class="aipptm-merek__judul">{$displayPageHeaderTitle|default:$siteTitle|default:$applicationName|escape}</span>
								<span class="aipptm-merek__sub">Asosiasi Ilmu Pemerintahan Perguruan Tinggi Muhammadiyah</span>
							</span>
						</a>
					{/if}
					</div>
				</div>

				{capture assign="primaryMenu"}
					{load_menu name="primary" id="navigationPrimary" ulClass="pkp_navigation_primary"}
				{/capture}

				<nav class="pkp_site_nav_menu" aria-label="{translate|escape key="common.navigation.site"}">
					<a id="siteNav"></a>
					<div class="pkp_navigation_primary_row">
						<div class="pkp_navigation_primary_wrapper">
							{$primaryMenu}

							{if $currentContext && $requestedPage !== 'search'}
								<div class="pkp_navigation_search_wrapper">
									<a href="{url page="search"}" class="pkp_search pkp_search_desktop">
										<span class="fa fa-search" aria-hidden="true"></span>
										{translate key="common.search"}
									</a>
								</div>
							{/if}
						</div>
					</div>
					<div class="pkp_navigation_user_wrapper" id="navigationUserWrapper">
						{load_menu name="user" id="navigationUser" ulClass="pkp_navigation_user" liClass="profile"}
					</div>
				</nav>
			</div>
		</header>

		{if $isFullWidth}
			{assign var=hasSidebar value=0}
		{/if}
		<div class="pkp_structure_content{if $hasSidebar} has_sidebar{/if}">
			<div class="pkp_structure_main" role="main">
				<a id="pkp_content_main"></a>

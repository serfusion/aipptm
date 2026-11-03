{**
 * plugins/themes/aipptm/templates/frontend/components/footer.tpl
 *
 * Distributed under the GNU GPL v3.
 *
 * @brief Footer tema AIPPTM: hitam dengan garis merah, tiga kolom, lalu baris hak cipta.
 *  "Page footer" dari Pengaturan > Website > Tampilan tetap ditampilkan, ditambah
 *  "Footer HTML" dari opsi tema yang tidak disaring (boleh berisi <script> dan <iframe>).
 *
 * @hook Templates::Common::Sidebar []
 * @hook Templates::Common::Footer::PageFooter []
 *}

	</div><!-- pkp_structure_main -->

	{if empty($isFullWidth)}
		{capture assign="sidebarCode"}{call_hook name="Templates::Common::Sidebar"}{/capture}
		{if $sidebarCode}
			<div class="pkp_structure_sidebar left" role="complementary">
				{$sidebarCode}
			</div>
		{/if}
	{/if}
</div><!-- pkp_structure_content -->

<div class="pkp_structure_footer_wrapper aipptm-footer" role="contentinfo">
	<a id="pkp_content_footer"></a>

	<div class="pkp_structure_footer">

		<div class="aipptm-footer__kolom">
			<div class="aipptm-footer__merek">
				{if $aipptmLogoAipptm}
					<img src="{$aipptmLogoUrl|escape}" width="48" height="48" alt="" />
				{/if}
				<strong>{if $currentContext}{$currentContext->getLocalizedName()|escape}{else}{$siteTitle|escape}{/if}</strong>
			</div>
			{if $aipptmFooterTentang}
				<p>{$aipptmFooterTentang|escape|nl2br}</p>
			{/if}
			{if $currentContext && ($currentContext->getData('onlineIssn') || $currentContext->getData('printIssn'))}
				<p class="aipptm-footer__issn">
					{if $currentContext->getData('printIssn')}<span>p-ISSN {$currentContext->getData('printIssn')|escape}</span>{/if}
					{if $currentContext->getData('onlineIssn')}<span>e-ISSN {$currentContext->getData('onlineIssn')|escape}</span>{/if}
				</p>
			{/if}
		</div>

		{if $currentContext}
			<div class="aipptm-footer__kolom">
				<h2>{translate key="plugins.themes.aipptm.footer.tautan"}</h2>
				<ul>
					<li><a href="{url page="about"}">{translate key="about.aboutContext"}</a></li>
					<li><a href="{url page="about" op="editorialMasthead"}">{translate key="common.editorialMasthead"}</a></li>
					<li><a href="{url page="about" op="submissions"}">{translate key="about.submissions"}</a></li>
					<li><a href="{url page="issue" op="current"}">{translate key="navigation.current"}</a></li>
					<li><a href="{url page="issue" op="archive"}">{translate key="navigation.archives"}</a></li>
					{if $aipptmUrlWebsite}
						<li><a href="{$aipptmUrlWebsite|escape}">{$aipptmLabelWebsite|default:$aipptmUrlWebsite|escape}</a></li>
					{/if}
				</ul>
			</div>
		{/if}

		<div class="aipptm-footer__kolom">
			<h2>{translate key="plugins.themes.aipptm.footer.kontak"}</h2>
			{if $aipptmFooterAlamat}
				<p>{$aipptmFooterAlamat|escape|nl2br}</p>
			{/if}
			{if $aipptmEmail}
				<p><a href="mailto:{$aipptmEmail|escape}"><span class="fa fa-envelope" aria-hidden="true"></span> {$aipptmEmail|escape}</a></p>
			{/if}
		</div>

		{if $pageFooter || $aipptmFooterHtml}
			<div class="aipptm-footer__tambahan">
				{if $pageFooter}
					<div class="pkp_footer_content">{$pageFooter}</div>
				{/if}
				{if $aipptmFooterHtml}
					<div class="aipptm-footer__html">{$aipptmFooterHtml}</div>
				{/if}
			</div>
		{/if}

		<div class="aipptm-footer__bawah">
			<p>&copy; {$aipptmTahun} {if $currentContext}{$currentContext->getLocalizedName()|escape}{else}{$siteTitle|escape}{/if} &middot; AIPPTM</p>
			{if $aipptmPkp}
				<a class="aipptm-footer__pkp" href="{url page="about" op="aboutThisPublishingSystem"}">{translate key="plugins.themes.aipptm.footer.pkp"}</a>
			{/if}
		</div>
	</div>
</div><!-- pkp_structure_footer_wrapper -->

</div><!-- pkp_structure_page -->

{load_script context="frontend"}

{call_hook name="Templates::Common::Footer::PageFooter"}
</body>
</html>

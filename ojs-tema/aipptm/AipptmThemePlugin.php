<?php

/**
 * @file plugins/themes/aipptm/AipptmThemePlugin.php
 *
 * Distributed under the GNU GPL v3.
 *
 * @class AipptmThemePlugin
 *
 * @brief Tema OJS AIPPTM. Turunan (child) dari Default Theme bawaan OJS sehingga
 *  semua fitur OJS tetap jalan, dengan tampilan yang disamakan dengan www.aipptm.org:
 *  bar atas hitam, header putih, aksen merah, huruf Plus Jakarta Sans, footer hitam.
 *  Semua pengaturan tampil di Pengaturan > Website > Tampilan > Tema.
 */

namespace APP\plugins\themes\aipptm;

use APP\core\Application;
use APP\template\TemplateManager;
use PKP\plugins\Hook;
use PKP\plugins\ThemePlugin;

class AipptmThemePlugin extends ThemePlugin
{
    public const WARNA_UTAMA = '#C1121F';
    public const WARNA_GELAP = '#141416';

    /**
     * Tema harus tetap terdaftar meski tidak aktif agar muncul di daftar tema.
     */
    public function init()
    {
        $this->setParent('defaultthemeplugin');

        // Opsi bawaan Default Theme yang diganti oleh opsi AIPPTM
        $this->removeOption('typography');
        $this->removeOption('baseColour');

        $this->addOption('aipptmWarnaUtama', 'FieldColor', [
            'label' => __('plugins.themes.aipptm.option.warnaUtama.label'),
            'description' => __('plugins.themes.aipptm.option.warnaUtama.description'),
            'default' => self::WARNA_UTAMA,
        ]);

        $this->addOption('aipptmWarnaGelap', 'FieldColor', [
            'label' => __('plugins.themes.aipptm.option.warnaGelap.label'),
            'description' => __('plugins.themes.aipptm.option.warnaGelap.description'),
            'default' => self::WARNA_GELAP,
        ]);

        $this->addOption('aipptmBarAtas', 'FieldOptions', [
            'label' => __('plugins.themes.aipptm.option.barAtas.label'),
            'options' => [
                ['value' => true, 'label' => __('plugins.themes.aipptm.option.barAtas.option')],
            ],
            'default' => true,
        ]);

        $this->addOption('aipptmEmail', 'FieldText', [
            'label' => __('plugins.themes.aipptm.option.email.label'),
            'description' => __('plugins.themes.aipptm.option.email.description'),
            'default' => 'info@aipptm.org',
        ]);

        $this->addOption('aipptmLokasi', 'FieldText', [
            'label' => __('plugins.themes.aipptm.option.lokasi.label'),
            'default' => 'Yogyakarta, Indonesia',
        ]);

        $this->addOption('aipptmUrlWebsite', 'FieldText', [
            'label' => __('plugins.themes.aipptm.option.urlWebsite.label'),
            'description' => __('plugins.themes.aipptm.option.urlWebsite.description'),
            'default' => 'https://www.aipptm.org',
        ]);

        $this->addOption('aipptmLabelWebsite', 'FieldText', [
            'label' => __('plugins.themes.aipptm.option.labelWebsite.label'),
            'default' => 'Website AIPPTM',
        ]);

        $this->addOption('aipptmLogoAipptm', 'FieldOptions', [
            'label' => __('plugins.themes.aipptm.option.logoAipptm.label'),
            'description' => __('plugins.themes.aipptm.option.logoAipptm.description'),
            'options' => [
                ['value' => true, 'label' => __('plugins.themes.aipptm.option.logoAipptm.option')],
            ],
            'default' => true,
        ]);

        $this->addOption('aipptmFooterTentang', 'FieldTextarea', [
            'label' => __('plugins.themes.aipptm.option.footerTentang.label'),
            'description' => __('plugins.themes.aipptm.option.footerTentang.description'),
            'default' => 'Jurnal ilmiah yang dikelola Asosiasi Ilmu Pemerintahan Perguruan Tinggi Muhammadiyah (AIPPTM).',
        ]);

        $this->addOption('aipptmFooterAlamat', 'FieldTextarea', [
            'label' => __('plugins.themes.aipptm.option.footerAlamat.label'),
            'default' => "Sekretariat AIPPTM\nYogyakarta, Indonesia",
        ]);

        $this->addOption('aipptmFooterHtml', 'FieldTextarea', [
            'label' => __('plugins.themes.aipptm.option.footerHtml.label'),
            'description' => __('plugins.themes.aipptm.option.footerHtml.description'),
            'default' => '',
        ]);

        $this->addOption('aipptmHeadHtml', 'FieldTextarea', [
            'label' => __('plugins.themes.aipptm.option.headHtml.label'),
            'description' => __('plugins.themes.aipptm.option.headHtml.description'),
            'default' => '',
        ]);

        $this->addOption('aipptmCss', 'FieldTextarea', [
            'label' => __('plugins.themes.aipptm.option.css.label'),
            'description' => __('plugins.themes.aipptm.option.css.description'),
            'default' => '',
        ]);

        $this->addOption('aipptmPkp', 'FieldOptions', [
            'label' => __('plugins.themes.aipptm.option.pkp.label'),
            'options' => [
                ['value' => true, 'label' => __('plugins.themes.aipptm.option.pkp.option')],
            ],
            'default' => true,
        ]);

        // Gaya AIPPTM digabung ke stylesheet Default Theme agar variabel LESS bisa dipakai
        $this->modifyStyle('stylesheet', [
            'addLess' => ['styles/aipptm.less'],
            'addLessVariables' => $this->variabelLess(),
        ]);

        $css = trim((string) $this->getOption('aipptmCss'));
        if ($css !== '') {
            $this->addStyle('aipptmCssTambahan', str_ireplace('</style', '<\/style', $css), [
                'inline' => true,
                'priority' => TemplateManager::STYLE_SEQUENCE_LAST,
            ]);
        }

        $headHtml = trim((string) $this->getOption('aipptmHeadHtml'));
        if ($headHtml !== '') {
            $templateMgr = TemplateManager::getManager(Application::get()->getRequest());
            $templateMgr->addHeader('aipptmHeadHtml', $headHtml);
        }

        Hook::add('TemplateManager::display', $this->kirimVariabel(...));
    }

    /**
     * Variabel LESS dari opsi warna.
     */
    private function variabelLess(): string
    {
        $utama = $this->warna('aipptmWarnaUtama', self::WARNA_UTAMA);
        $gelap = $this->warna('aipptmWarnaGelap', self::WARNA_GELAP);

        return implode("\n", [
            '@aipptm-merah: ' . $utama . ';',
            '@aipptm-gelap: ' . $gelap . ';',
            '@bg-base: #fff;',
            '@text-bg-base: #1F2328;',
            '@bg-base-border-color: #E3E4E8;',
            '@primary: ' . $utama . ';',
            '@primary-lift: darken(' . $utama . ', 12%);',
            '@bg-shade: #F5F5F7;',
            '@bg-border-color: #E3E4E8;',
            '@text: #1F2328;',
            '@text-light: #5B6168;',
            '@radius: 10px;',
            '@font: "Plus Jakarta Sans", system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;',
            '@font-heading: @font;',
            '@font-site-title: @font;',
        ]);
    }

    private function warna(string $opsi, string $bawaan): string
    {
        $nilai = (string) $this->getOption($opsi);
        return preg_match('/^#[0-9a-fA-F]{3}([0-9a-fA-F]{3})?$/', $nilai) ? $nilai : $bawaan;
    }

    /**
     * Kirim nilai opsi ke template header dan footer.
     */
    public function kirimVariabel(string $hookName, array $args): bool
    {
        /** @var TemplateManager $templateMgr */
        $templateMgr = $args[0];
        $template = $args[1] ?? '';
        if (!is_string($template) || !str_starts_with($template, 'frontend/')) {
            return Hook::CONTINUE;
        }

        $urlWebsite = trim((string) $this->getOption('aipptmUrlWebsite'));
        if ($urlWebsite !== '' && !preg_match('#^https?://#i', $urlWebsite)) {
            $urlWebsite = 'https://' . $urlWebsite;
        }

        $request = Application::get()->getRequest();
        $templateMgr->assign([
            'aipptmBarAtas' => (bool) $this->getOption('aipptmBarAtas'),
            'aipptmEmail' => trim((string) $this->getOption('aipptmEmail')),
            'aipptmLokasi' => trim((string) $this->getOption('aipptmLokasi')),
            'aipptmUrlWebsite' => $urlWebsite,
            'aipptmLabelWebsite' => trim((string) $this->getOption('aipptmLabelWebsite')),
            'aipptmLogoAipptm' => (bool) $this->getOption('aipptmLogoAipptm'),
            'aipptmLogoUrl' => $request->getBaseUrl() . '/' . $this->getPluginPath() . '/images/logo-aipptm.png',
            'aipptmFooterTentang' => trim((string) $this->getOption('aipptmFooterTentang')),
            'aipptmFooterAlamat' => trim((string) $this->getOption('aipptmFooterAlamat')),
            'aipptmFooterHtml' => trim((string) $this->getOption('aipptmFooterHtml')),
            'aipptmPkp' => (bool) $this->getOption('aipptmPkp'),
            'aipptmTahun' => date('Y'),
        ]);

        return Hook::CONTINUE;
    }

    public function getDisplayName()
    {
        return __('plugins.themes.aipptm.name');
    }

    public function getDescription()
    {
        return __('plugins.themes.aipptm.description');
    }

    public function getContextSpecificPluginSettingsFile()
    {
        return $this->getPluginPath() . '/settings.xml';
    }

    public function getInstallSitePluginSettingsFile()
    {
        return $this->getPluginPath() . '/settings.xml';
    }

    public function saveOption($name, $value, $contextId = null)
    {
        if (in_array($name, ['aipptmWarnaUtama', 'aipptmWarnaGelap'], true)
            && !preg_match('/^#[0-9a-fA-F]{3}([0-9a-fA-F]{3})?$/', (string) $value)) {
            $value = null;
        }
        parent::saveOption($name, $value, $contextId);
    }
}

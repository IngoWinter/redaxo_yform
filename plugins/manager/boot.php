<?php

/**
 * yform
 * @author jan.kristinus[at]redaxo[dot]org Jan Kristinus
 * @author <a href="http://www.yakamara.de">www.yakamara.de</a>
 *
 * @var rex_plugin $this
 */

rex_yform::addTemplatePath(rex_path::plugin('yform','manager','ytemplates'));

if (rex::isBackend() && rex::getUser()) {

    $tables = rex_yform_manager_table::getAll();
    $pages = [];

    foreach ($tables as $table) {
        $table_perm = 'yform[table:' . $table['table_name'] . ']';

        if ($table['status'] == 1 && $table['hidden'] != 1) {
            $be_page = new rex_be_page_main('yform_tables', $table['table_name'], $table['name']);
            $be_page->setHref('index.php?page=yform/manager/data_edit&table_name=' . $table['table_name']);
            $be_page->setIcon('rex-icon rex-icon-module');
            $be_page->setRequiredPermissions([$table_perm]);
            if (rex_request('page','string') == 'yform/manager/data_edit' && rex_request('table_name', 'string') == $table['table_name']) {
                $be_page->setIsActive();

                $main_page = $this->getAddon()->getProperty('page');
                $main_page['isActive'] = false;
                $this->getAddon()->setProperty('page', $main_page);

            }

            $pages[] = $be_page;

            // TODO rechte noch verfügbar machen

        }
    }

    $this->setProperty('pages', $pages);

}


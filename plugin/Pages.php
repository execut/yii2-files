<?php
/**
 */

namespace execut\files\plugin;

use execut\files\Plugin;

class Pages implements Plugin
{
    public function getFileFieldsPlugins() {
        return [
            'pages_page_id' => [
                'class' => \execut\pages\crudFields\Plugin::class,
            ]
        ];
    }

    public function getDataColumns()
    {
        return [];
    }
    public function getFormats($file = null) {
        return [];
    }
}
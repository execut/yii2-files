<?php
/**
 */

namespace execut\files\plugin;
class Alias implements \execut\files\Plugin
{
    public function getFileFieldsPlugins() {
        return [
            [
                'class' => \execut\alias\crudFields\Plugin::class,
            ],
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
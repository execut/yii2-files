<?php
/**
 */

namespace execut\files\plugin;


use execut\files\Plugin;

class Images implements Plugin
{
    public function getFileFieldsPlugins() {
        return [
            [
                'class' => \execut\images\crudFields\Plugin::class,
                'previewDataAttribute' => 'size_s',
            ],
        ];
    }

    public function getDataColumns()
    {
        return array_keys(\yii::$app->getModule('images')->getSizes());
    }

    public function getFormats($file = null) {
        return [];
    }
}
<?php
/**
 */

namespace execut\files\plugin;


use execut\files\Plugin;
use execut\goods\models\Article;

class Goods implements Plugin {
    public function getFileFieldsPlugins() {
        return [];
    }

    public function getDataColumns() {
        return [];
    }

    public function getFormats($file = null) {
        return FormatConverter::STANDARD_FORMATS;
    }
}
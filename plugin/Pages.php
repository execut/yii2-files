<?php
/**
 */

namespace execut\files\plugin;

use execut\files\Plugin;

class Pages implements Plugin
{
    public function getFileFieldsPlugins() {
        return [];
    }

    public function getDataColumns()
    {
        return [];
    }
    public function getFormats($file = null) {
        return [];
    }
}
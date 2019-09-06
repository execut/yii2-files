<?php
/**
 */

namespace execut\files;


interface Plugin
{
    public function getFileFieldsPlugins();
    public function getDataColumns();
    public function getFormats($file = null);
}
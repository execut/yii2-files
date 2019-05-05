<?php
/**
 */

namespace execut\files\plugin;


use execut\files\Plugin;
use execut\files\plugin\seo\models\KeywordVsFile;

class Seo implements Plugin
{
    public function getFileFieldsPlugins()
    {
        return [
            [
                'class' => \execut\seo\crudFields\Keywords::class,
                'linkAttribute' => 'files_file_id',
                'vsModelClass' => KeywordVsFile::class,
            ],
        ];
    }

    public function getDataColumns()
    {
        return [];
    }
}
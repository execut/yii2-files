<?php
/**
 */

namespace execut\files;


use execut\dependencies\PluginBehavior;
use yii\helpers\ArrayHelper;

class Module extends \yii\base\Module implements Plugin
{
    public $tableName = 'files_files';
    public $columns = [];
    public $adminRole = '@';
    public $modelClass = models\File::class;
    const DEFAULT_COLUMNS = [
        'extension' => 'extension',
        'name' => 'name',
        'data' => 'data',
        'mime_type' => 'mime_type',
        'file_md5' => 'file_md5',
    ];
    public function behaviors()
    {
        return [
            [
                'class' => PluginBehavior::class,
                'pluginInterface' => Plugin::class,
            ],
        ];
    }

    public function getFileFieldsPlugins() {

        $pluginsResults = $this->getPluginsResults(__FUNCTION__);
        if (!$pluginsResults) {
            return [];
        }

        return $pluginsResults;
    }

    public function getDataColumns() {
        $columns = $this->getPluginsResults(__FUNCTION__);
        if (empty($columns)) {
            return [];
        }

        return $columns;
    }

    public function getColumnName($column) {
        return $this->getColumnsNames()[$column];
    }

    /**
     * @return array
     */
    public function getColumnsNames(): array
    {
        return ArrayHelper::merge(self::DEFAULT_COLUMNS, $this->columns);
    }
}
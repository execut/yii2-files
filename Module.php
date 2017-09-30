<?php
/**
 */

namespace execut\files;


use execut\dependencies\PluginBehavior;

class Module extends \yii\base\Module implements Plugin
{
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
        return $this->getPluginsResults(__FUNCTION__);
    }

    public function getAttachedModels() {
        return $this->getPluginsResults(__FUNCTION__);
    }

    public function getDataColumns() {
        return $this->getPluginsResults(__FUNCTION__);
    }
}
<?php
/**
 */

namespace execut\files\plugin;


use execut\files\Plugin;

class Images implements Plugin
{
    protected $isMigrate = true;
    public function getFileFieldsPlugins() {
        return [
            [
                'class' => \execut\images\crudFields\Plugin::class,
                'isMigrate' => $this->isMigrate,
                'previewDataAttribute' => $this->getImagePreviewAttribute(),
                'moduleId' => $this->getImagesModuleId(),
            ],
        ];
    }

    public function getDataColumns()
    {
        return array_keys(\yii::$app->getModule($this->getImagesModuleId())->getSizes());
    }

    public function getFormats($file = null) {
        return [];
    }

    /**
     * getImagePreviewAttribute
     * @return string
     */
    protected function getImagePreviewAttribute(): string
    {
        return 'size_s';
    }

    /**
     * getImagesModuleId
     * @return string
     */
    protected function getImagesModuleId(): string
    {
        return 'images';
    }
}
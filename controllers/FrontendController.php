<?php
/**
 */

namespace execut\files\controllers;


use execut\actions\Action;
use execut\actions\action\adapter\File;
use yii\web\Controller;

class FrontendController extends Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => Action::class,
                'adapter' => [
                    'class' => File::class,
                    'dataAttribute' => $this->module->getColumnName('data'),
                    'mimeType' => function ($file, $dataAttribute) {
                        if ($dataAttribute !== $this->module->getColumnName('data')) {
                            return $file->getMimeTypeOfDataAttribute($dataAttribute);
                        }
                    },
                    'mimeTypeAttribute' => $this->module->getColumnName('mime_type'),
                    'extensionAttribute' => $this->module->getColumnName('extension'),
                    'extensionIsRequired' => false,
                    'modelClass' => $this->module->modelClass,
                ],
            ],
        ];
    }
}
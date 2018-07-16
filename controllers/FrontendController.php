<?php
/**
 */

namespace execut\files\controllers;


use execut\actions\Action;
use execut\actions\action\adapter\File;
use execut\crud\params\Crud;
use execut\files\models\Files;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class FrontendController extends Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => Action::class,
                'adapter' => [
                    'class' => File::className(),
                    'dataAttribute' => $this->module->getColumnName('data'),
                    'mimeTypeAttribute' => $this->module->getColumnName('mime_type'),
                    'extensionAttribute' => $this->module->getColumnName('extension'),
                    'modelClass' => $this->module->modelClass,
                ],
            ],
        ];
    }
}
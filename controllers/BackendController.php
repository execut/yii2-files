<?php
/**
 */

namespace execut\files\controllers;


use execut\crud\params\Crud;
use execut\files\models\File;
use execut\files\models\FileBackend;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class BackendController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [\yii::$app->getModule('files')->adminRole],
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        $crud = new Crud([
            'modelClass' => FileBackend::class,
            'module' => 'files',
            'moduleName' => 'Files',
            'modelName' => FileBackend::MODEL_NAME,
        ]);
        return ArrayHelper::merge($crud->actions(), [
            'update' => [
                'adapter' => [
                    'filesAttributes' => [
                        \yii::$app->getModule('files')->getColumnName('data') => 'dataFile'
                    ],
                ]
            ],
        ]);
    }
}
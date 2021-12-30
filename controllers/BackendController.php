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
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [$this->module->adminRole],
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        $modelClass = $this->module->modelClass;
        $crud = new Crud([
            'modelClass' => $modelClass,
            'module' => $this->module->id,
            'moduleName' => 'Files',
            'modelName' => $modelClass::MODEL_NAME,
        ]);
        ini_set('max_execution_time', 600);
        return ArrayHelper::merge($crud->actions(), [
            'update' => [
                'adapter' => [
                    'filesAttributes' => [
                        $this->module->getColumnName('data') => 'dataFile'
                    ],
                ]
            ],
        ]);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 6/27/18
 * Time: 3:32 PM
 */

namespace execut\files\crudFields;


use execut\actions\widgets\GridView;
use execut\crudFields\fields\HasManyMultipleInput;
use execut\files\models\File;

class HasManyPlugin extends \execut\crudFields\Plugin
{
    public $modelClass = File::class;
    public $attribute = null;
    public function getFields()
    {
        return [
            'filesFiles' => [
                'class' => HasManyMultipleInput::class,
                'module' => 'files',
                'order' => 115,
                'attribute' => 'filesFiles',
                'relation' => 'filesFiles',
                'isGridForOldRecords' => true,
                'url' => [
                    '/files/backend'
                ],
                'column' => [
                    'filter' => false,
                ],
                'fieldGrid' => new HasManyMultipleInput\Grid\Field\DynaGrid([
                    'class' => GridView::class,
                    'id' => 'files',
//                    'isAjaxCrud' => true,
                    'toolbar' => '',
                    'pjax' => true,
                    'addButtonUrl' => ['/files/backend/update', 'File[' . $this->attribute . ']' => $this->owner->id],
                    'updateUrl' => ['/files/backend/update'],
                    'uniqueId' => '/files/backend',
                    'formModel' => function () {
                        $class = $this->modelClass;
                        $formModel = new $class();
                        $attribute = $this->attribute;
                        $formModel->$attribute = $this->owner->owner->id;

                        return $formModel;
                    },
                ])
            ],
        ];
    }

    public function getRelations()
    {
        return [
            'filesFiles' => [
                'class' => $this->modelClass,
                'name' => 'filesFiles',
                'link' => [
                    $this->attribute => 'id',
                ],
                'multiple' => true
            ],
        ];
    }
}
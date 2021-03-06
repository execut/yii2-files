<?php
/**
 */

namespace execut\files\crudFields;
use execut\crudFields\fields\HasManyMultipleInput;
use execut\crudFields\fields\HasManySelect2;
use execut\files\models\File;
use yii\helpers\Inflector;

class FilesPlugin extends \execut\crudFields\Plugin
{
    public $linkAttribute = null;
    public $vsModelClass = null;
    public function getFields() {

        return [
            [
                'class' => HasManySelect2::class,
                'attribute' => 'filesFiles',
                'relation' => 'filesFiles',
                'module' => 'files',
                'url' => [
                    '/files/backend'
                ],
            ],
        ];
    }
    
    public function getRelations()
    {
        return [
            'filesFiles' => [
               'class' => File::class,
               'name' => 'filesFiles',
               'link' => [
                   'id' => 'files_file_id',
               ],
                'via' => 'vsFilesFiles',
                'multiple' => true
            ],
            'vsFilesFiles' => [
                'class' => $this->vsModelClass,
                'name' => 'vsFilesFiles',
                'link' => [
                    $this->linkAttribute => 'id',
                ],
                'multiple' => true
            ],
        ];
    }

    protected function getOwnerTableName() {
        return $this->owner->tableName();
    }

    protected function getOwnerForeignKey() {
        $tableName = $this->getOwnerTableName();

        return Inflector::singularize($tableName) . '_id';
    }

    public function attach()
    {
    }
}
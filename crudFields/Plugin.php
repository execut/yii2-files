<?php
/**
 */

namespace execut\files\crudFields;

use execut\crudFields\fields\HasOneSelect2;
use execut\files\models\File;

class Plugin extends \execut\crudFields\Plugin
{
    public function getFields() {
        return [
            [
                'class' => HasOneSelect2::class,
                'attribute' => 'files_file_id',
                'relation' => 'filesFile',
                'nameParam' => 'name',
                'nameAttribute' => 'fullName',
                'url' => [
                    '/files/backend'
                ],
            ],
        ];
    }

    public function getRelations()
    {
        return [
            'filesFile' => [
                'class' => File::class,
                'link' => [
                    'id' => 'files_file_id',
                ],
                'multiple' => false
            ],
        ];
    }
}
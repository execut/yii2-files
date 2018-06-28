<?php
/**
 */

namespace execut\files\models;


use execut\crudFields\Behavior;
use execut\crudFields\BehaviorStub;
use execut\crudFields\fields\File as FileField;
use execut\crudFields\ModelsHelperTrait;
use execut\files\models\queries\FileQuery;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

class File extends ActiveRecord
{
    const MODEL_NAME = '{n,plural,=0{Files} =1{File} other{Files}}';
    use BehaviorStub, ModelsHelperTrait;
    public $dataFile = null;

    public static function find()
    {
        $names = self::getDb()->getTableSchema(self::tableName())->getColumnNames();
        $dataColums = self::getDataColumns();
        foreach ($names as $key => $column) {
            if (in_array($column, $dataColums)) {
                unset($names[$key]);
            }
        }

        $names = array_filter($names);

        return (new FileQuery(self::class))->select($names);
    }

    public static function getDataColumns() {
        $columns = ArrayHelper::merge(['data'], \yii::$app->getModule('files')->getDataColumns());
        return $columns;
    }

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                'seoKeywords' => [
                    'class' => SaveRelationsBehavior::class,
                    'relations' => [
                        'seoKeywords'
                    ],
                ],
                'fields' => [
                    'class' => Behavior::class,
                    'plugins' => \yii::$app->getModule('files')->getFileFieldsPlugins(),
                    'module' => 'files',
                    'fields' => $this->getStandardFields(['visible'], [
                        \yii::$app->getModule('files')->getColumnName('name') => [
                            'displayOnly' => true,
                            'required' => false,
                        ],
                        \yii::$app->getModule('files')->getColumnName('data') => [
                            'class' => FileField::class,
                            'required' => true,
                            'fileNameAttribute' => \yii::$app->getModule('files')->getColumnName('name'),
                            'fileExtensionAttribute' => \yii::$app->getModule('files')->getColumnName('extension'),
                            'fileMimeTypeAttribute' => \yii::$app->getModule('files')->getColumnName('mime_type'),
                            'dataAttribute' => \yii::$app->getModule('files')->getColumnName('data'),
                            'md5Attribute' => \yii::$app->getModule('files')->getColumnName('file_md5'),
                        ],
//                        [
//                            'class' => HasOneSelect2::class,
//                            'attribute' => 'pages_page_id',
//                            'relation' => 'pagesPage',
//                            'url' => [
//                                '/pages/backend'
//                            ],
//                        ],
                        'actions' => [
                            'column' => [
                                'controller' => '/files/backend',
                            ]
                        ],
                    ])
                ],
                [
                    'class' => TimestampBehavior::className(),
                    'createdAtAttribute' => 'created',
                    'updatedAtAttribute' => 'updated',
                    'value' => new Expression('NOW()'),
                ],
                # custom behaviors
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge($this->getBehavior('fields')->rules(), [
            ['file_md5', 'unique'],
        ]);
    }

    public static function tableName() {
        return \yii::$app->getModule('files')->tableName;
    }

    public function __toString()
    {
        return '#' . $this->id;
    }

    public function getFullName() {
        return $this->alias . '.' . $this->extension . ' (' . $this->name . ')';
    }
}
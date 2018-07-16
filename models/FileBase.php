<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 7/16/18
 * Time: 4:21 PM
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
use yii\helpers\Url;

class FileBase extends ActiveRecord
{

    const MODEL_NAME = '{n,plural,=0{Files} =1{File} other{Files}}';
    use BehaviorStub, ModelsHelperTrait;
    public $dataFile = null;

    public static function getModuleId() {
        return 'files';
    }

    public static function find()
    {
        $names = self::getDb()->getTableSchema(static::tableName())->getColumnNames();
        $dataColums = static::getDataColumns();
        foreach ($names as $key => $column) {
            if (in_array($column, $dataColums)) {
                unset($names[$key]);
            }
        }

        $names = array_filter($names);

        return (new FileQuery(static::class))->select($names);
    }

    public static function getDataColumns() {
        $columns = ArrayHelper::merge(['data'], static::getModule()->getDataColumns());
        return $columns;
    }

    /**
     * @return null|\yii\base\Module
     */
    public static function getModule()
    {
        return \yii::$app->getModule(static::getModuleId());
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
                    'plugins' => static::getModule()->getFileFieldsPlugins(),
                    'module' => 'files',
                    'fields' => $this->getStandardFields(['visible'], [
                        static::getModule()->getColumnName('name') => [
                            'displayOnly' => true,
                            'required' => false,
                        ],
                        static::getModule()->getColumnName('data') => [
                            'class' => FileField::class,
                            'required' => true,
                            'fileNameAttribute' => static::getModule()->getColumnName('name'),
                            'fileExtensionAttribute' => static::getModule()->getColumnName('extension'),
                            'fileMimeTypeAttribute' => static::getModule()->getColumnName('mime_type'),
                            'dataAttribute' => static::getModule()->getColumnName('data'),
                            'md5Attribute' => static::getModule()->getColumnName('file_md5'),
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
            ['file_md5', 'unique', 'targetClass' => static::class],
        ]);
    }

    public static function tableName() {
        return static::getModule()->tableName;
    }

    public function __toString()
    {
        return '#' . $this->id;
    }

    public function getFullName() {
        return $this->alias . '.' . $this->extension . ' (' . $this->name . ')';
    }

    public function getUrl($dataAttribute) {
        $extensionAttribute = static::getModule()->getColumnName('extension');
        return Url::to([
            static::getModuleId() . '/frontend/index',
            'id' => $this->id,
            'extension' => strtolower($this->$extensionAttribute),
            'dataAttribute' => $dataAttribute,
        ]);
    }
}
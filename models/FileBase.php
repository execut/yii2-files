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
use execut\crudFields\fields\Field;
use execut\crudFields\fields\File as FileField;
use execut\crudFields\fields\NumberField;
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
        return (new FileQuery(static::class));
    }

    public function search()
    {
        $dp = $this->getBehavior('fields')->search();
        $dp->query->withoutData();
        return $dp;
    }

    public static function getDataColumns() {
        $dataColumnsSource = static::getModule()->getDataColumns();
        $dataColumns = $dataColumnsSource;
        $formats = static::getModule()->getFormats();
        foreach ($formats as $format => $params) {
            foreach ($dataColumnsSource as $column) {
                $dataColumns[] = self::getDataAttributeNameForFormat($column, $format);
            }
        }

        $columns = ArrayHelper::merge(['data'], $dataColumns);
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
        $module = static::getModule();
        $fileFieldsPlugins = $module->getFileFieldsPlugins();
        return ArrayHelper::merge(
            parent::behaviors(),
            [
//                Behavior::RELATIONS_SAVER_KEY => [
//                    'class' => SaveRelationsBehavior::class,
//                    'relations' => [
//                        'seoKeywords'
//                    ],
//                ],
                'fields' => [
                    'class' => Behavior::class,
                    'plugins' => $fileFieldsPlugins,
                    'module' => 'files',
                    'fields' => $this->getStandardFields(['visible'], [
                        $module->getColumnName('name') => [
                            'displayOnly' => true,
                            'required' => false,
                        ],
                        $module->getColumnName('data') => [
                            'class' => FileField::class,
                            'required' => true,
                            'fileNameAttribute' => $module->getColumnName('name'),
                            'fileExtensionAttribute' => $module->getColumnName('extension'),
                            'fileMimeTypeAttribute' => $module->getColumnName('mime_type'),
                            'dataAttribute' => $module->getColumnName('data'),
                            'md5Attribute' => $module->getColumnName('file_md5'),
                        ],
                        'ordering' => [
                            'class' => NumberField::class,
                            'attribute' => 'ordering',
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
                                'controller' => '/' . $module->id . '/backend',
                            ]
                        ],
                    ])
                ],
                [
                    'class' => TimestampBehavior::class,
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
            ['file_md5', 'unique', 'targetClass' => static::class, 'on' => [Field::SCENARIO_FORM,'default']],
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

    public function getUrl($dataAttribute, $format = null) {
        $extensionAttribute = static::getModule()->getColumnName('extension');
        return Url::to([
            '/' . static::getModuleId() . '/frontend/index',
            'id' => $this->id,
            'extension' => $format ? $format : strtolower($this->$extensionAttribute),
            'dataAttribute' => self::getDataAttributeNameForFormat($dataAttribute, $format),
        ]);
    }

    public function getTitle() {
        return $this->name;
    }

    public static function getDataAttributeNameForFormat($attribute, $format) {
        $formats = static::getModule()->getFormats();
        if (!isset($formats[$format])) {
            return $attribute;
        }
        return $attribute . '_' . $format;
    }


    public function getMimeTypeOfDataAttribute($dataAttribute) {
        $formats = static::getModule()->getFormats();
        $attributeParts = explode('_', $dataAttribute);
        $formatAttribute = $attributeParts[count($attributeParts) - 1];
        foreach ($formats as $format => $params) {
            if ($format === $formatAttribute) {
                return $params['mimeType'];
            }
        }
    }
}
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
        return new FileQuery(self::class);
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
                    'fields' => $this->getStandardFields(null, [
                        'name' => [
                            'displayOnly' => true,
                            'required' => false,
                        ],
                        'data' => [
                            'class' => FileField::class,
                        ],
//                        [
//                            'class' => HasOneSelect2::class,
//                            'attribute' => 'pages_page_id',
//                            'relation' => 'pagesPage',
//                            'url' => [
//                                '/pages/backend'
//                            ],
//                        ],
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
//            ['file_md5', 'default', 'value' => new Expression()],
        ]);
    }

    public static function tableName() {
        return 'files_files';
    }
}
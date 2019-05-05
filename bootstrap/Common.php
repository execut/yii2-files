<?php
/**
 */

namespace execut\files\bootstrap;


use execut\files\Attacher;
use execut\files\Module;
use execut\yii\Bootstrap;

class Common extends Bootstrap
{
    public $moduleId = 'files';

    public function getDefaultDepends()
    {
        return [
            'modules' => [
                $this->moduleId => [
                    'class' => Module::class,
                ],
            ],
        ];
    }

    public function bootstrap($app)
    {
        parent::bootstrap($app);
    }
}
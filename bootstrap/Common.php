<?php
/**
 */

namespace execut\files\bootstrap;


use execut\files\Attacher;
use execut\files\Module;
use execut\yii\Bootstrap;

class Common extends Bootstrap
{
    protected $isBootstrapI18n = true;
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
}
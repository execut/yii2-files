<?php
/**
 */

namespace execut\files\crudFields;


use execut\files\Attacher;

class AttachedPlugin extends \execut\crudFields\Plugin
{
    protected static $isAttached = false;
    protected $moduleId = 'files';
    public function attach()
    {
        if (self::$isAttached) {
            return;
        }

        self::$isAttached = true;
        $attacher = new Attacher([
            'moduleId' => $this->moduleId,
            'tables' => [
                $this->owner->tableName()
            ],
        ]);
        $attacher->safeUp();
    }
}
<?php
namespace execut\files\migrations;

use execut\yii\migration\Migration;
use execut\yii\migration\Inverter;

/**
 * Class m211227_082034_addSortingField
 */
class m211227_082034_addSortingField extends Migration
{
    public function initInverter(Inverter $i)
    {
        $i->table('files_files')
            ->addColumn('ordering', $this->integer());
    }
}

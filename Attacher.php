<?php
/**
 */

namespace execut\files;


use execut\yii\migration\Inverter;
use execut\yii\migration\Migration;

class Attacher extends \execut\yii\migration\Attacher
{
    public $tables = [];
    public $moduleId = null;

    protected function getVariations () {
        return ['tables'];
    }

    public function initInverter(Inverter $i) {
        foreach ($this->tables as $table) {
            $tableSchema = $this->db->getTableSchema($table);
            if (!$tableSchema) {
                continue;
            }

            $isAttached = $tableSchema->getColumn('files_file_id');
            if (!$isAttached) {
                $i->table($table)->addForeignColumn('files_files');
            }
        }

        $modelClass = \yii::$app->getModule($this->moduleId)->modelClass;
        $tableName = $modelClass::tableName();
        $tableSchema = $this->db->getTableSchema($tableName);
        if ($tableSchema) {
            return;
        }

        $i->table($tableName)
            ->create($this->defaultColumns([
                'name' => $this->string()->notNull(),
                'extension' => $this->string()->notNull(),
                'mime_type' => $this->string()->notNull(),
                'data' => $this->binary()->notNull(),
                'file_md5' => $this->string(64)->notNull(),
                'visible' => $this->boolean()->notNull()->defaultValue(true)
            ]))->createIndex('file_md5', true);
    }
}
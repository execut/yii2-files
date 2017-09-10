<?php
/**
 */

namespace execut\files;


use execut\yii\migration\Inverter;
use execut\yii\migration\Migration;

class Attacher extends Migration
{
    public $tables = [];
    public function initInverter(Inverter $i) {
        foreach ($this->tables as $table) {
            $cache = \yii::$app->cache;
            $cacheKey = __CLASS__ . '_' . $table;
            if ($cache->get($cacheKey)) {
                continue;
            }

            $tableSchema = $this->db->getTableSchema($table);
            if (!$tableSchema) {
                continue;
            }

            $isAttached = $tableSchema->getColumn('files_file_id');
            if (!$isAttached) {
                $i->table($table)->addForeignColumn('files_files');
            }

            $cache->set($cacheKey, 1);
        }
    }
}
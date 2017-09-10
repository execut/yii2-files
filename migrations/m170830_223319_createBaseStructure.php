<?php

use execut\yii\migration\Migration;
use execut\yii\migration\Inverter;

class m170830_223319_createBaseStructure extends Migration
{
    public function initInverter(Inverter $i)
    {
        $i->table('files_files')
            ->create($this->defaultColumns([
                'name' => $this->string()->notNull(),
                'extension' => $this->string()->notNull(),
                'mime_type' => $this->string()->notNull(),
                'data' => 'bytea NOT NULL',
                'file_md5' => $this->string(64)->notNull(),
                'visible' => $this->boolean()->notNull()->defaultValue(true)
            ]))->createIndex('file_md5', true);
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}

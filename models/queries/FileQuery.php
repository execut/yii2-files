<?php
/**
 */

namespace execut\files\models\queries;


use yii\db\ActiveQuery;

class FileQuery extends ActiveQuery
{
    public function withoutData($exclude = []) {
        $modelClass = $this->modelClass;
        $columns = $modelClass::getTableSchema()->columns;
        $select = [];
        $dataColumns = $modelClass::getDataColumns();
        foreach ($columns as $column) {
            if (!in_array($column->name, $dataColumns) || in_array($column->name, $exclude)) {
                $select[] = $column->name;
            }
        }

        return $this->select($select);
    }
}
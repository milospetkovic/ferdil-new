<?php

namespace App\Traits\Models;

trait GetTableNameForModel
{
    public static function getTableName()
    {
        return with(new static())->getTable();
    }

}

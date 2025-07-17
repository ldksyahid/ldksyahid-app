<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MsCatalogBook extends Model
{
    protected $table = 'ms_catalog_book';

    public static function getTableName()
    {
        return (new static)->getTable();
    }
}

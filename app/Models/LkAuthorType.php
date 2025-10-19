<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LkAuthorType extends Model
{
    protected $table = 'lk_author_type';
    protected $primaryKey = 'authorTypeID';
    public $timestamps = false;

    protected $fillable = ['authorTypeName'];

    public static function getTableName(): string
    {
        return (new static)->getTable();
    }

    public static function attributeLabels(): array
    {
        return [
            'authorTypeID' => 'Author Type ID',
            'authorTypeName' => 'Author Type Name',
        ];
    }
}

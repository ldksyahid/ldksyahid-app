<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LkLanguage extends Model
{
    protected $table = 'lk_language';
    protected $primaryKey = 'languageID';
    public $timestamps = false;

    protected $fillable = [
        'languageName'
    ];

    public static function getTableName(): string
    {
        return (new static)->getTable();
    }

    public static function attributeLabels(): array
    {
        return [
            'languageID' => 'Language ID',
            'languageName' => 'Language Name',
        ];
    }

    public function books()
    {
        return $this->hasMany(MsCatalogBook::class, 'languageID', 'languageID');
    }
}
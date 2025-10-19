<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LkBookCategory extends Model
{
    protected $table = 'lk_book_category';
    protected $primaryKey = 'bookCategoryID';
    public $timestamps = false;

    protected $fillable = ['bookCategoryName'];

    public static function getTableName(): string
    {
        return (new static)->getTable();
    }

    public static function attributeLabels(): array
    {
        return [
            'bookCategoryID' => 'Book Category ID',
            'bookCategoryName' => 'Book Category Name',
        ];
    }

    public function books()
    {
        return $this->hasMany(MsCatalogBook::class, 'bookCategoryID', 'bookCategoryID');
    }
}
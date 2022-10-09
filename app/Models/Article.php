<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $table = 'articles';
    protected $guarded =[];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function articlecomments() {
        return $this->hasMany('App\Models\ArticleComment','articles_id');
    }
}

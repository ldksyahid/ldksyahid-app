<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $guarded =[];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function newscomments() {
        return $this->hasMany('App\Models\NewsComment','news_id');
    }
}

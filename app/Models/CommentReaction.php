<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentReaction extends Model
{
    protected $table      = 'tr_comment_reaction';
    protected $primaryKey = 'reactionID';

    const CREATED_AT = 'createdDate';
    const UPDATED_AT = null;

    protected $fillable = ['commentID', 'userID', 'reactionType'];

    public function comment()
    {
        return $this->belongsTo(Comment::class, 'commentID', 'commentID');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }
}

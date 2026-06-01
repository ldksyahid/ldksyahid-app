<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table      = 'tr_comment';
    protected $primaryKey = 'commentID';

    const CREATED_AT = 'createdDate';
    const UPDATED_AT = 'updatedDate';

    protected $casts = [
        'createdDate' => 'datetime',
        'updatedDate' => 'datetime',
    ];

    protected $fillable = [
        'userID',
        'contentType',
        'contentID',
        'parentID',
        'commentText',
        'mediaUrl',
        'mediaType',
        'mediaGdriveId',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    public function reactions()
    {
        return $this->hasMany(CommentReaction::class, 'commentID', 'commentID');
    }

    // Eager-loads up to 2 levels of nested replies
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parentID', 'commentID')
            ->with(['user.profile', 'replies.user.profile', 'replies.replies.user.profile']);
    }
}

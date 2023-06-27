<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCommentProduct extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'product_name',
        'comment',
        'created_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCommentTimeAttribute()
    {
        return getTimeComment($this->created_at);
    }

    public function getCommentReplyTimeAttribute()
    {
        return getTimeComment($this->user_reply_comment_created_at);
    }
}

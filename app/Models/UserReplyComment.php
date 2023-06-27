<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserReplyComment extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'users_comment_product_id',
        'user_reply_comment_id',
        'user_id',
        'comment',
        'created_at',
    ];

    public function userCommentProducts()
    {
        return $this->belongsTo(UserCommentProduct::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

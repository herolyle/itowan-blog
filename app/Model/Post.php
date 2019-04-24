<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'post';

    protected $fillable = [
        'user_id', 'title', 'describe', 'content',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    protected $table = 'post';

    protected $fillable = [
        'user_id', 'title', 'describe', 'content',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeByRole() {
        $user = Auth::user();
        if ($user && $user->role == 0) {
            return $this;
        }
        return $this->where('user_id', $user->id);
    }

}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'log';

    protected $fillable = [
        'user_id', 'email', 'ip', 'type', 'change_content',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Number extends Model
{
    protected $fillable = [
        'number_format_id', 'counter', 'number', 'generate_tries', 'user_id', 'api_key_id'
    ];
}

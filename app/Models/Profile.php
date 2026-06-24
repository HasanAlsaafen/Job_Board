<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'phone_number',
        'phone_prefix',
        'img_url',
        'user_id'
    ];
}

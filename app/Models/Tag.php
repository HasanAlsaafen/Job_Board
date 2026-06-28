<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{
    protected $fillable = [
        "name",
        'slug',
        'color',
        'bg',
    ];

    public function jobListings()
    {
        return $this->belongsToMany(JobListing::class);
    }
}

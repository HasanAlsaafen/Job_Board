<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobListing extends Model
{
    /** @use HasFactory<\Database\Factories\JobListingFactory> */
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'requirements',
        'salary_range',
        'location',
        'company_name',
        'type',
        'user_id',
        'latitude',
        'longitude',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function applications()
    {
        return $this->hasMany(Applications::class);
    }

    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'job_user', 'job_id', 'user_id')->withTimestamps()->withPivot('note');
    }

    public function scopeRemote(Builder $query)
    {
        return $query->where('type', 'remote');
    }
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', 'true');
    }
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where('title', 'LIKE', '%' . $search . '%')
            ->orWhere('company_name', 'LIKE', '%' . $search . '%');
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}

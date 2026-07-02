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
        'expires_at',
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
    public function scopeNotExpired(Builder $query)
    {
        return $query->where(function ($q) {
            return $q->whereNull('expires_at')->orWhere('expires_at', '>=', now());
        });
    }
    public function scopeRemote(Builder $query)
    {
        return $query->where('type', 'remote');
    }
    public function scopeExpired(Builder $query): Builder
    {

        return $query->where('expires_at', '<',now());
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

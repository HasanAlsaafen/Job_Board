<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Applications extends Model
{
    protected $fillable = [
        'resume_path',
        'cover_letter',
        'user_id',
        'job_listing_id',
        'status',
    ];

    private const STATUS_KEYS = [
        'Pending'               => 'messages.status.pending',
        'Assesment in Progress' => 'messages.status.assessment_in_progress',
        'Interview'             => 'messages.status.interview',
        'Offer'                 => 'messages.status.offer',
        'Not proceding'         => 'messages.status.not_proceeding',
        'Rejected'              => 'messages.status.rejected',
        'Withdrawn'             => 'messages.status.withdrawn',
    ];

    public function getTranslatedStatusAttribute(): string
    {
        return __(self::STATUS_KEYS[$this->status] ?? $this->status);
    }

    public static function statusLabel(string $status): string
    {
        return __(self::STATUS_KEYS[$status] ?? $status);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function jobListing()
    {
        return $this->belongsTo(JobListing::class, 'job_listing_id');
    }
}

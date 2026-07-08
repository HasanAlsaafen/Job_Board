<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = ['job_listing_id', 'employer_id', 'seeker_id', 'last_message_at'];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    public function messages()
    {
        return $this->hasMany(Message::class)->oldest();
    }

    public function latestMessage()
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    public function seeker()
    {
        return $this->belongsTo(User::class, 'seeker_id');
    }

    public function jobListing()
    {
        return $this->belongsTo(JobListing::class);
    }

    public function otherParticipant(): User
    {
        return auth()->id() === $this->employer_id
            ? $this->seeker
            : $this->employer;
    }
}

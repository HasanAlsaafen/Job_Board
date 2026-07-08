<?php

namespace App\Services;

use App\Models\Applications;
use App\Models\JobListing;
use App\Notifications\ApplicationStatusChanged;
use Illuminate\Http\UploadedFile;

class ApplicationService
{

    public const STATUSES = [
        'Pending',
        'Assessment in Progress',
        'Interview',
        'Offer',
        'Not proceeding',
        'Rejected',
        'Withdrawn',
    ];
    public function __construct() {}

    public function apply(
        int $user_id,
        JobListing $jobListing,
        UploadedFile $resume,
        ?string $cover_letter
    ): Applications|false {
        $alreadyApplied = Applications::where("user_id", $user_id)->where('job_listing_id', $jobListing->id)
            ->exists();

        if ($alreadyApplied) {
            return false;
        }
        return Applications::create([
            'user_id' => $user_id,
            'job_listing_id' => $jobListing->id,
            'cover_letter' => $cover_letter,
            'resume_path' => $resume->store('resumes', 'public'),
        ]);
    }

    public function updateStatus(Applications $application, string $status): void
    {
        abort_unless(in_array($status, self::STATUSES), 422);
        $application = Applications::whereHas('jobListing', fn($q) => $q->where('user_id', auth()->id()))
            ->findOrFail($application->id);
        $previousStatus = $application->status;
        $application->update(['status' => $status]);
        event(new \App\Events\ApplicationStatusChanged($application, $previousStatus));
    }
    public function withdraw(Applications $application)
    {
        if ($application->user_id !== auth()->id()) {
            abort(403);
        }
        $application->update(['status' => 'Withdrawn']);
    }
}

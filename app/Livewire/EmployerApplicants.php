<?php

namespace App\Livewire;

use App\Models\Applications;
use App\Models\JobListing;
use Livewire\Attributes\Layout;
use Livewire\Component;

use App\Notifications\ApplicationStatusChanged;
use App\Services\ApplicationService;

class EmployerApplicants extends Component
{
    public const STATUSES = [
        'Pending',
        'Assesment in Progress',
        'Interview',
        'Offer',
        'Not proceding',
        'Rejected',
    ];

    public function updateStatus(
        int $applicationId,
        string $status,
        ApplicationService $service
    ): void {
        $application = Applications::where("id", $applicationId)->first();

        $service->updateStatus($application, $status);
    }

    public function render()
    {
        $myJobs = JobListing::where('user_id', auth()->id())
            ->with(['applications.user'])
            ->has('applications')
            ->latest()
            ->get();

        return view('livewire.employer-applicants', [
            'myJobs'   => $myJobs,
            'statuses' => self::STATUSES,
        ]);
    }
}

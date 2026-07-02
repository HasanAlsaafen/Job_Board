<?php

namespace App\Livewire;

use App\Models\Applications;
use App\Models\JobListing;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.bare')]

class SeekerDashboard extends Component
{
    public function render()
    {
        $userId = auth()->id();

        $applications = Applications::where('user_id', $userId)
            ->whereNotIn('status', ['Withdrawn']);

        return view('livewire.seeker-dashboard', [
            'applicationsCount' => (clone $applications)->count(),
            'savedJobsCount'    => auth()->user()->savedJobs()->count(),
            'interviewCount'    => (clone $applications)->where('status', 'Interview')->count(),
            'offerCount'        => (clone $applications)->where('status', 'Offer')->count(),
            'recentApplications' => Applications::with('jobListing')
                ->where('user_id', $userId)
                ->whereNotIn('status', ['Withdrawn'])
                ->latest()
                ->take(5)
                ->get(),
            'recommendedJobs' => JobListing::notExpired()
                ->whereDoesntHave('applications', fn($q) => $q->where('user_id', $userId))
                ->latest()
                ->take(5)
                ->get(),
        ]);
    }
}

<?php

namespace App\Livewire;

use App\Models\Applications;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Services\ApplicationService;

#[Layout('layouts.bare')]

class MyApplications extends Component
{
    public function withdraw(Applications $application, ApplicationService $service): void
    {
        $service->withdraw($application);
    }
    public function render()
    {
        $applications = Applications::with('jobListing')
            ->where('user_id', auth()->id())
            ->whereNotIn('status', ['Withdrawn'])
            ->latest()
            ->get();

        return view('livewire.my-applications', compact('applications'));
    }
}

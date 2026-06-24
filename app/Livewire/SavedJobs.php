<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.bare')]

class SavedJobs extends Component
{
    public function unsaveJob(int $jobId): void
    {
        $user = auth()->user();
        if (!$user) return;

        $user->savedJobs()->detach($jobId);
    }

    public function render()
    {
        $jobs = auth()->user()->savedJobs()->latest('job_user.created_at')->get();

        return view('livewire.saved-jobs', compact('jobs'));
    }
}

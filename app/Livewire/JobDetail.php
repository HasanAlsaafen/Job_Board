<?php

namespace App\Livewire;

use App\Models\Applications;
use App\Models\JobListing;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class JobDetail extends Component
{
    public JobListing $job;

    public function mount(JobListing $job): void
    {
        $this->job = $job->load('user');
    }

    public function render()
    {
        $alreadyApplied = Auth::check()
            ? Applications::where('user_id', Auth::id())
                ->where('job_listing_id', $this->job->id)
                ->exists()
            : false;

        return view('livewire.job-detail', compact('alreadyApplied'));
    }
}

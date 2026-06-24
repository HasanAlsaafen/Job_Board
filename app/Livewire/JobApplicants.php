<?php

namespace App\Livewire;

use App\Models\JobListing;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.bare')]
class JobApplicants extends Component
{
    use WithPagination;

    public JobListing $job;

    public function mount(JobListing $job): void
    {
        if ($job->user_id !== auth()->id()) {
            abort(403);
        }

        $this->job = $job;
    }

    public function render()
    {
        return view('livewire.job-applicants', [
            'applications' => $this->job->applications()
                ->with('user')
                ->latest()
                ->paginate(15),
        ]);
    }
}

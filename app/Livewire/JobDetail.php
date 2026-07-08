<?php

namespace App\Livewire;

use App\Models\Applications;
use App\Models\JobListing;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class JobDetail extends Component
{
    public JobListing $job;
    public function startConversation(): void
    {
        abort_unless(auth()->check(), 403);
        abort_unless(auth()->user()->role === 'employer', 403);

        $conversation = \App\Models\Conversation::firstOrCreate([
            'employer_id' => auth()->id(),
            'seeker_id' => $this->applicant->id,
            'job_listing_id' => $this->job->id,
        ]);

        $this->redirect(route('conversations.show', $conversation));
    }
    public function mount(JobListing $job): void
    {
        if ($job->expires_at && $job->expires_at < now()) {
            abort(404);
        }

        $this->job = $job->load(['user', 'tags']);
        $this->job->count += 1;
        $this->job->save();
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

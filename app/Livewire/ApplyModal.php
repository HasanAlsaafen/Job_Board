<?php

namespace App\Livewire;

use App\Models\Applications;
use App\Models\JobListing;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\ApplicationService;
use App\Http\Requests\StoreApplicationRequest;

class ApplyModal extends Component
{
    use WithFileUploads;

    public int $jobId;

    public mixed $resume = null;
    public string $cover_letter = '';

    public bool $isSaved = false;

    public function mount(int $jobId): void
    {
        $this->jobId = $jobId;
    }



    public function submitApplication(ApplicationService $applicationService): void
    {
        $this->validate(
            (new StoreApplicationRequest())->rules(),
            (new StoreApplicationRequest())->messages()
        );

        $result = $applicationService->apply(
            Auth::id(),
            JobListing::findOrFail($this->jobId),
            $this->resume,
            $this->cover_letter
        );
        if ($result === false) {
            $this->addError('application', __('messages.applications.already_applied'));
            return;
        }
        $this->reset(['resume', 'cover_letter']);
        $this->isSaved = true;
    }

    public function render()
    {
        $alreadyApplied = Auth::check()
            ? Applications::where('user_id', Auth::id())
            ->where('job_listing_id', $this->jobId)
            ->exists()
            : false;

        return view('livewire.apply-modal', [
            'alreadyApplied' => $alreadyApplied,
        ]);
    }
}

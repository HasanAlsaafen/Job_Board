<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Applications;
use App\Models\JobListing;
use App\Http\Requests\StoreJobListingRequest;
use App\Models\Tag;

#[Layout('layouts.bare')]

class EmployerDashboard extends Component
{
    public $title = '';
    public $company_name = '';
    public $description = '';
    public $requirements = '';
    public $salary_range = '';
    public $location = '';
    public $type = 'Full-time';
    public $successMessage = '';
    public ?float $latitude = 31.9038;
    public ?float $longitude = 35.2034;
    public string $location_name = '';

    public array $selectedTagIds = [];
    public ?string $expires_at = null;



    public function removeTag(int $tagId): void
    {
        $this->selectedTagIds = array_values(array_filter($this->selectedTagIds, fn($id) => $id !== $tagId));
    }

    public function createJob()
    {
        $this->validate(
            (new StoreJobListingRequest())->rules(),
        );

        $job = JobListing::create([
            'user_id' => auth()->id(),
            'title' => $this->title,
            'company_name' => $this->company_name,
            'description' => $this->description,
            'requirements' => $this->requirements,
            'salary_range' => $this->salary_range,
            'type' => $this->type,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'location' => $this->location,
            'expires_at' => $this->expires_at,

        ]);
        $job->tags()->sync($this->selectedTagIds);

        $this->reset(['title', 'description', 'location_name', 'latitude', 'longitude', 'type', 'selectedTagIds', 'expires_at']);
        $this->successMessage = 'Job listing created successfully!';
    }

    public function render()
    {
        $userId = auth()->id();

        $myJobs = JobListing::where('user_id', $userId)
            ->with(['applications.user'])
            ->latest()
            ->get();

        $myApplicants = Applications::whereHas('jobListing', fn($q) => $q->where('user_id', $userId));

        return view('livewire.employer-dashboard', [
            'myJobs' => $myJobs,
            'tags' => Tag::all(),
            'activeJobsCount' => JobListing::where('user_id', $userId)->notExpired()->count(),
            'totalJobsCount' => $myJobs->count(),
            'totalApplicantsCount' => (clone $myApplicants)->count(),
            'pendingApplicantsCount' => (clone $myApplicants)->where('status', 'Pending')->count(),
            'recentApplicants' => (clone $myApplicants)->with(['user', 'jobListing'])->latest()->take(5)->get(),
        ]);
    }
}

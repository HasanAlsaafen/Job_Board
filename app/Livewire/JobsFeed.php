<?php

namespace App\Livewire;

use App\Models\JobListing;
use App\Models\Tag;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.bare')]

class JobsFeed extends Component
{
    use WithPagination;

    public string $search = '';
    public string $selectedType = '';
    public string $selectedTag = '';
    public ?float $userLat = null;
    public ?float $userLng = null;
    public int $radius = 50; // km
    public bool $nearMe = false;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }
    public function setLocation(float $lat, float $lng): void
    {
        $this->userLat = $lat;
        $this->userLng = $lng;
        $this->nearMe = true;
        $this->resetPage();
    }

    public function clearLocation(): void
    {
        $this->userLat = null;
        $this->userLng = null;
        $this->nearMe = false;
        $this->resetPage();
    }
    public function updatedSelectedTag(): void
    {
        $this->resetPage();
    }

    public function updatedSelectedType(): void
    {
        $this->resetPage();
    }
    public function saveJob(int $jobId): void
    {
        $user = auth()->user();
        if (!$user) return;
        $alreadySaved = $user->savedJobs()->where('job_id', $jobId)->exists();
        if ($alreadySaved) {
            return;
        }
        $user->savedJobs()->attach($jobId);
    }
    public function unsaveJob(int $jobId)
    {
        $user = auth()->user();
        if (!$user) return;

        $user->savedJobs()->detach($jobId);
    }

    public function render()
    {
        $query = JobListing::search($this->search)
            ->when($this->selectedType, function ($query) {
                $query->where('type', $this->selectedType);
            })
            ->notExpired()
            ->when($this->selectedTag, function ($query) {
                $query->whereHas('tags', function ($query) {
                    $query->where('tag_id', $this->selectedTag);
                });
            })
            ->withExists(['savedByUsers' => function ($query) {
                $query->where('user_id', auth()->id());
            }])
            ->with('tags')
            ->latest();


        return view('livewire.jobs-feed', [
            'jobs' => $query->paginate(10),
            'tags' => Tag::orderBy('name')->get(),
        ]);
    }
}

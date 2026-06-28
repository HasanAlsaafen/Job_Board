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

    public string $view = 'list';

    public function updatedSearch(): void
    {
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
            'jobs' => $this->view === 'map'
                ? $query->get()
                : $query->paginate(10),
            'tags' => Tag::orderBy('name')->get(),
        ]);
    }
}

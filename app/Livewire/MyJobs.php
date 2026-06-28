<?php

namespace App\Livewire;

use App\Models\JobListing;
use App\Models\Tag;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.bare')]

class MyJobs extends Component
{
    public $title = '';
    public $company_name = '';
    public $location = '';
    public $description = '';
    public $requirements = '';
    public $salary_range = '';
    public $type = 'Full-time';
    public $successMessage = '';

    public ?JobListing $jobListing = null;
    public bool $showEditModal = false;
    public array $selectedTagIds = [];

    public function deleteJob(JobListing $job)
    {
        $this->authorize('delete', $job);
        $job->delete();
    }

    public function editJob(JobListing $jobListing)
    {
        $this->authorize('update', $jobListing);
        $this->jobListing = $jobListing;
        $this->title = $jobListing->title;
        $this->company_name = $jobListing->company_name;
        $this->location = $jobListing->location;
        $this->description = $jobListing->description;
        $this->requirements = $jobListing->requirements;
        $this->salary_range = $jobListing->salary_range;
        $this->type = $jobListing->type;
        $this->selectedTagIds = $jobListing->tags->pluck('id')->map(fn($id) => (string) $id)->toArray();
        $this->showEditModal = true;
    }

    public function removeTag(int $tagId): void
    {
        $this->selectedTagIds = array_values(array_filter($this->selectedTagIds, fn($id) => (int) $id !== $tagId));
    }

    public function cancelEdit()
    {
        $this->reset(['title', 'location', 'description', 'requirements', 'type', 'company_name', 'salary_range', 'jobListing', 'showEditModal', 'selectedTagIds']);
    }

    public function updateJob()
    {
        $this->validate([
            'title' => 'required|min:3|max:255',
            'company_name' => 'required|min:2',
            'description' => 'required|min:20',
            'requirements' => 'required|min:10',
            'type' => 'required|in:Full-time,Part-time,Contract',
        ]);

        $this->jobListing->update([
            'title' => $this->title,
            'company_name' => $this->company_name,
            'location' => $this->location,
            'description' => $this->description,
            'requirements' => $this->requirements,
            'salary_range' => $this->salary_range,
            'type' => $this->type,
        ]);
        $this->jobListing->tags()->sync($this->selectedTagIds);

        $this->successMessage = 'Job updated successfully!';
        $this->reset(['title', 'location', 'description', 'requirements', 'type', 'company_name', 'salary_range', 'jobListing', 'showEditModal']);
    }
    public function render()
    {
        $myJobs = JobListing::where('user_id', auth()->id())
            ->withCount('applications')
            ->with('tags')
            ->latest()
            ->get();

        return view('livewire.my-jobs', ['myJobs' => $myJobs, 'tags' => Tag::all()]);
    }
}

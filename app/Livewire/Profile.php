<?php

namespace App\Livewire;

use Livewire\Component;
use Flux\Flux;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads;

    public string $phone_number = '';
    public string $phone_prefix = '+1';
    public ?string $currentAvatarPath = null;
    public $avatar = null;
    public string $title = '';
    public string $location = '';
    public string $linkedin = '';
    public string $github = '';
    public string $bio = '';
    public $resume = null;

    public function mount()
    {
        $user = auth()->user();
        $profile = $user->profile;
        $this->phone_number = $profile?->phone_number ?? '';
        $this->phone_prefix = $profile?->phone_prefix ?? '+1';
        $this->title = $profile?->title ?? '';
        $this->bio = $profile?->bio ?? '';
        $this->location = $profile?->location ?? '';
        $this->linkedin = $profile?->linkedin ?? '';
        $this->github = $profile?->github ?? '';
        $this->currentAvatarPath = $profile?->img_url;
    }

    public function submitProfile()
    {
        $this->validate([
            'phone_number' => 'required|string',
            'phone_prefix' => 'required|string',
            'title' => 'nullable|string|max:100',
            'bio' => 'nullable|string|max:1000',
            'location' => 'nullable|string|max:100',
            'linkedin' => 'nullable|url',
            'github' => 'nullable|url',
            'avatar' => 'nullable|image|max:2048',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $user = auth()->user();

        $profileData = [
            'phone_number' => $this->phone_number,
            'phone_prefix' => $this->phone_prefix,
            'title' => $this->title,
            'bio' => $this->bio,
            'location' => $this->location,
            'linkedin' => $this->linkedin,
            'github' => $this->github,
        ];

        if ($this->avatar) {
            if ($user->profile?->img_url) {
                Storage::disk('public')->delete($user->profile->img_url);
            }
            $profileData['img_url'] = $this->avatar->store('avatars', 'public');
            $this->currentAvatarPath = $profileData['img_url'];
        }

        if ($this->resume) {
            if ($user->profile?->resume_path) {
                Storage::disk('public')->delete($user->profile->resume_path);
            }
            $profileData['resume_path'] = $this->resume->store('resumes', 'public');
        }

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $profileData
        );

        $this->reset(['avatar', 'resume']);
        Flux::toast('Your changes have been saved.');
    }

    public function render()
    {
        return view('livewire.profile', [
            'profile' => auth()->user()->profile,
        ]);
    }
}

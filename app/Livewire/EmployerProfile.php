<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Profile as MyProfile;

class EmployerProfile extends Component
{
    public string $phone_number = '';
    public string $phone_prefix = '+1';
    public ?string $img_url = null;
    public string $title = '';
    public string $bio = '';
    public string $location = '';
    public string $linkedin = '';
    public string $website = '';
    public string $successMessage = '';

    public function mount()
    {
        $profile = MyProfile::where('user_id', auth()->id())->first();
        if ($profile) {
            $this->phone_number = $profile->phone_number ?? '';
            $this->phone_prefix = $profile->phone_prefix ?? '+1';
            $this->img_url      = $profile->img_url;
            $this->title        = $profile->title ?? '';
            $this->bio          = $profile->bio ?? '';
            $this->location     = $profile->location ?? '';
            $this->linkedin     = $profile->linkedin ?? '';
            $this->website      = $profile->github ?? '';
        }
    }

    public function submitProfile()
    {
        $this->validate([
            'phone_number' => 'required|string',
            'phone_prefix' => 'required|string',
            'img_url'      => 'nullable|url',
            'title'        => 'nullable|string|max:100',
            'bio'          => 'nullable|string|max:1000',
            'location'     => 'nullable|string|max:100',
            'linkedin'     => 'nullable|url',
            'website'      => 'nullable|url',
        ]);

        MyProfile::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'phone_number' => $this->phone_number,
                'phone_prefix' => $this->phone_prefix,
                'img_url'      => $this->img_url,
                'title'        => $this->title,
                'bio'          => $this->bio,
                'location'     => $this->location,
                'linkedin'     => $this->linkedin,
                'github'       => $this->website,
            ]
        );

        $this->successMessage = 'Profile saved successfully!';
    }

    public function render()
    {
        return view('livewire.employer-profile');
    }
}

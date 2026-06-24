<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Profile as MyProfile;

class Profile extends Component
{

    public string $phone_number = '';
    public string $phone_prefix = '+1';
    public ?string $img_url = null;
    public string $successMessage = '';

    public function mount()
    {
        $profile = MyProfile::where('user_id', auth()->id())->first();
        if ($profile) {
            $this->phone_number = $profile->phone_number ?? '';
            $this->phone_prefix = $profile->phone_prefix ?? '+1';
            $this->img_url      = $profile->img_url;
        }
    }

    public function submitProfile()
    {
        $this->validate([
            "phone_number" => "required|string",
            "phone_prefix" => "required|string",
            "img_url"      => "nullable|string|url",
        ]);
        MyProfile::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'phone_number' => $this->phone_number,
                'phone_prefix' => $this->phone_prefix,
                'img_url'      => $this->img_url,
            ]
        );
        $this->successMessage = 'Profile saved successfully!';
    }
    public function render()
    {
        $profile = MyProfile::where('user_id', auth()->id())->first();
        return view(
            'livewire.profile',
            [
                'profile' => $profile
            ]
        );
    }
}

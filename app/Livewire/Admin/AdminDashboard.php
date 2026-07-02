<?php

namespace App\Livewire\Admin;

use App\Models\Applications;
use App\Models\JobListing;
use App\Models\Tag;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.bare')]
class AdminDashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard', [
            'userCount'        => User::count(),
            'employerCount'    => User::where('role', 'employer')->count(),
            'seekerCount'      => User::where('role', 'seeker')->count(),
            'jobCount'         => JobListing::count(),
            'applicationCount' => Applications::count(),
            'tagCount'         => Tag::count(),
            'recentJobs'       => JobListing::with('user')->latest()->take(5)->get(),
            'recentApps'       => Applications::with(['user', 'jobListing'])->latest()->take(5)->get(),
        ]);
    }
}

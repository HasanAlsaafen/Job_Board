<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\EmployerDashboard;
use App\Livewire\MyJobs;
use App\Livewire\EmployerApplicants;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\JobsFeed;
use App\Livewire\MyApplications;
use App\Livewire\Profile;
use App\Livewire\EmployerProfile;
use App\Livewire\SavedJobs;
use App\Livewire\SeekerDashboard;
use App\Livewire\ManageTags;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\AdminUsers;
use App\Livewire\Admin\AdminJobListings;
use App\Livewire\Admin\AdminApplications;
use App\Livewire\Admin\AdminTags;

Route::view('/', 'welcome')->name('home');

Route::middleware('throttle:guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
});
Route::get('/jobs/{job}', \App\Livewire\JobDetail::class)->name('jobs.show');

Route::get('/dashboard/jobs/{job}/applicants', \App\Livewire\JobApplicants::class)
    ->name('employer.job.applicants');

Route::middleware(['auth', 'employer', 'verified'])->group(function () {
    Route::get('/dashboard', EmployerDashboard::class)->name('dashboard');
    Route::get('/dashboard/jobs', MyJobs::class)->name('employer.jobs');
    Route::get('/dashboard/applicants', EmployerApplicants::class)->name('employer.applicants');
    Route::get('/dashboard/profile', EmployerProfile::class)->name('employer.profile');
    Route::get('/dashboard/tags', ManageTags::class)->name('employer.tags');
});
Route::middleware(['auth', 'seeker'])->group(function () {
    Route::get('/overview', SeekerDashboard::class)->name('seeker.dashboard');
    Route::get('/openings', JobsFeed::class)->name('openings');
    Route::get('/my-applications', MyApplications::class)->name('seeker.applications');
    Route::get('/saved-jobs', SavedJobs::class)->name('seeker.saved-jobs');
    Route::get('/profile', Profile::class)->name('seeker.profile');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', AdminDashboard::class)->name('admin.dashboard');
    Route::get('/users', AdminUsers::class)->name('admin.users');
    Route::get('/jobs', AdminJobListings::class)->name('admin.jobs');
    Route::get('/applications', AdminApplications::class)->name('admin.applications');
    Route::get('/tags', AdminTags::class)->name('admin.tags');
});

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');


Route::get('/lang/{locale}', function (string $locale) {
    abort_unless(in_array($locale, ['en', 'ar']), 404);
    session(['locale' => $locale]);
    return redirect()->back();
})->name('lang.switch');

Route::middleware(['auth'])->group(function () {
    Route::get('/conversations', \App\Livewire\ConversationList::class)
        ->name('conversations.index');

    Route::get('/conversations/{conversation}', \App\Livewire\ChatBox::class)
        ->name('conversations.show');
});

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

Route::view('/', 'welcome')->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
});
Route::get('/jobs/{job}', \App\Livewire\JobDetail::class)->name('jobs.show');

Route::get('/dashboard/jobs/{job}/applicants', \App\Livewire\JobApplicants::class)
    ->name('employer.job.applicants');

Route::middleware(['auth', 'employer'])->group(function () {
    Route::get('/dashboard', EmployerDashboard::class)->name('dashboard');
    Route::get('/dashboard/jobs', MyJobs::class)->name('employer.jobs');
    Route::get('/dashboard/applicants', EmployerApplicants::class)->name('employer.applicants');
    Route::get('/dashboard/profile', EmployerProfile::class)->name('employer.profile');
});
Route::middleware(['auth', 'seeker'])->group(function () {
    Route::get('/openings', JobsFeed::class)->name('openings');
    Route::get('/my-applications', MyApplications::class)->name('seeker.applications');
    Route::get('/saved-jobs', SavedJobs::class)->name('seeker.saved-jobs');
    Route::get('/profile', Profile::class)->name('seeker.profile');
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

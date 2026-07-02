<?php

use App\Models\User;
use App\Models\JobListing;
use App\Models\Applications;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('Seeker can apply to a job', function () {
    $seeker = User::factory()->create(['role' => 'seeker']);
    $job = JobListing::factory()->create();

    Livewire::actingAs($seeker)->test(\App\Livewire\ApplyModal::class, ['jobId' => $job->id])->set('resume', UploadedFile::fake()->create('cv.pdf', 500))->call('submitApplication');
    $this->assertDatabaseHas('applications', [
        'user_id' => $seeker->id,
        'job_listing_id' => $job->id,
    ]);
});
test('seeker cannot apply twice to the same job', function () {
    $seeker = User::factory()->create(['role' => 'seeker']);
    $job = JobListing::factory()->create();

    Applications::create([
        'user_id' => $seeker->id,
        'job_listing_id' => $job->id,
        'resume_path' => 'test'
    ]);

    Livewire::actingAs($seeker)
        ->test(\App\Livewire\ApplyModal::class, ['jobId' => $job->id])
        ->set('resume', UploadedFile::fake()->create('cv1.pdf', 500))
        ->call('submitApplication')
        ->assertHasErrors(['application']);

    $this->assertDatabaseCount('applications', 1);
});

<?php

use App\Models\User;
use App\Models\JobListing;
use Illuminate\Foundation\Testing\RefreshDatabase;
use \App\Livewire\MyJobs;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test("the employer shoud be able to remove his own job", function () {
    $employer = User::factory()->create([
        "role" => "employer",
    ]);
    $job = JobListing::factory()->create(['user_id' => $employer->id]);
    Livewire::actingAs($employer)
        ->test(MyJobs::class)
        ->call('deleteJob', $job->id);
    $this->assertDatabaseMissing('job_listings', ['id' => $job->id]);
});

test('the employer must not be able to delte another one job ', function () {
    $employer1 = User::factory()->create(['role' => 'employer']);
    $employer2 = User::factory()->create(['role'=> 'employer']);
    $job = JobListing::factory()->create(['user_id' => $employer1->id]);
    Livewire::actingAs($employer2)
        ->test(MyJobs::class)
        ->call('deleteJob', $job->id)
        ->assertForbidden();

    $this->assertDatabaseHas('job_listings', ['id' => $job->id]);
});

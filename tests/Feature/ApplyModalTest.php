<?php

use App\Livewire\ApplyModal;
use App\Models\JobListing;
use Livewire\Livewire;

test('apply modal component can be resolved and rendered', function () {
    $job = JobListing::factory()->create();

    Livewire::test(ApplyModal::class, ['jobId' => $job->id])
        ->assertSee('Apply for this job');
});

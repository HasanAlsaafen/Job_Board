<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\JobListingResource;
use App\Models\JobListing;
use Illuminate\Http\Request;

class JobListingController extends Controller
{
    public function index(Request $request)
    {
        $jobs = JobListing::notExpired()
            ->with('tags')
            ->when($request->search, fn($q) => $q->search($request->search))
            ->latest()
            ->paginate(10);
        return JobListingResource::collection($jobs);
    }
    public function show(JobListing $job)
    {
        return new JobListingResource($job->load('tags', 'user'));
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\JobListingResource;
use App\Models\JobListing;
use Illuminate\Http\Request;

class JobListingController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/jobs",
     *     summary="Get all job listings",
     *     tags={"Jobs"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of jobs",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="title", type="string"),
     *                     @OA\Property(property="company", type="string"),
     *                     @OA\Property(property="location", type="string"),
     *                     @OA\Property(property="type", type="string"),
     *                     @OA\Property(property="posted_at", type="string")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $jobs = JobListing::notExpired()
            ->with('tags')
            ->when($request->search, fn($q) => $q->search($request->search))
            ->latest()
            ->paginate(10);
        return JobListingResource::collection($jobs);
    }
    /**
     * @OA\Get(
     *     path="/api/jobs/{id}",
     *     summary="Get single job listing",
     *     tags={"Jobs"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Job details"),
     *     @OA\Response(response=404, description="Job not found")
     * )
     */
    public function show(JobListing $job)
    {
        return new JobListingResource($job->load('tags', 'user'));
    }
}

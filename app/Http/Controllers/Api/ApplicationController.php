<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobListing;
use App\Services\ApplicationService;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/jobs/{id}/apply",
     *     summary="Apply to a job",
     *     tags={"Applications"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="resume", type="file"),
     *                 @OA\Property(property="cover_letter", type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=201, description="Application submitted"),
     *     @OA\Response(response=422, description="Already applied"),
     *     @OA\Response(response=403, description="Unauthorized")
     * )
     */
    public function store(Request $request, JobListing $job, ApplicationService $service)
    {
        $request->validate([
            'resume' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $result = $service->apply(
            $request->user()->id,
            $job,
            $request->file('resume'),
            $request->cover_letter
        );

        if ($result === false) {
            return response()->json(['message' => 'You have applied earlier'], 422);
        }

        return response()->json(['message' => 'Applied successfully'], 201);
    }
}

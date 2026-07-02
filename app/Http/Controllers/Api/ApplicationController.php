<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobListing;
use App\Services\ApplicationService;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
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

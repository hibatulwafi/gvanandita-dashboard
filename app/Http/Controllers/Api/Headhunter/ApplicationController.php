<?php

namespace App\Http\Controllers\Api\Headhunter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HhApplication;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'job_listing_id' => 'required|exists:hh_job_listings,id',
        ]);

        $candidate = Auth::user(); // karena token sudah pakai sanctum
        if (!$candidate) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Cek apakah sudah apply
        $exists = HhApplication::where('candidate_id', $candidate->id)
            ->where('job_listing_id', $request->job_listing_id)
            ->first();

        if ($exists) {
            return response()->json(['message' => 'You already applied to this job.'], 422);
        }

        $application = HhApplication::create([
            'candidate_id'   => $candidate->id,
            'job_listing_id' => $request->job_listing_id,
            'status'         => 'applied',
            'applied_at'     => now(),
        ]);

        return response()->json([
            'message' => 'Application submitted successfully.',
            'data'    => $application,
        ], 201);
    }

    public function history()
    {
        $candidate = Auth::user();
        if (!$candidate) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $applications = HhApplication::with('jobListing.company', 'jobListing.category')
            ->where('candidate_id', $candidate->id)
            ->orderBy('applied_at', 'desc')
            ->get();

        return response()->json([
            'message' => 'Application history fetched successfully.',
            'data'    => $applications,
        ]);
    }
}

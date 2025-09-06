<?php

namespace App\Http\Controllers\Api\Headhunter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\HhCandidate;

class AuthCandidateController extends Controller
{
    /**
     * Handle an incoming authentication request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // 1. Validasi kredensial yang dikirim dari frontend
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        // 2. Mencari kandidat berdasarkan email
        $candidate = HhCandidate::where('email', $credentials['email'])->first();

        // 3. Verifikasi kandidat dan kata sandi
        if (!$candidate || !Hash::check($credentials['password'], $candidate->password)) {
            return response()->json([
                'message' => 'Kredensial tidak cocok dengan data kami.'
            ], 401);
        }

        // 4. Buat token API untuk otentikasi di masa mendatang
        // 'token-nama-aplikasi' bisa diganti dengan nama yang lebih deskriptif
        $token = $candidate->createToken('candidate-token')->plainTextToken;

        // 5. Kembalikan data pengguna dan token sebagai respons
        // Gunakan array untuk mengembalikan data kandidat dan token
        return response()->json([
            'user' => $candidate,
            'token' => $token,
        ]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'nullable|string|max:255',
            'email'      => 'required|email|unique:hh_candidates,email',
            'password'   => 'required|string|min:6|confirmed',
            'phone_number' => 'nullable|string|max:50',

            // optional fields
            'address'              => 'nullable|string',
            'current_job_title'    => 'nullable|string|max:255',
            'current_company'      => 'nullable|string|max:255',
            'employment_status'    => 'nullable|in:employed,unemployed,freelancer',
            'willing_to_relocate'  => 'nullable|in:yes,no,negotiable',
            'work_experience_years' => 'nullable|in:<1,1-3,3-5,5-10,>10',
            'skills'               => 'nullable|string',
            'resume_path'          => 'nullable|file|mimes:pdf,doc,docx|max:2048', // <= ubah ke file
            'portfolio_url'        => 'nullable|url',
            'linkedin_url'         => 'nullable|url',
            'current_salary'       => 'nullable|numeric',
            'expected_salary'      => 'nullable|numeric',
        ]);

        // simpan file resume kalau ada
        $resumePath = null;
        if ($request->hasFile('resume_path')) {
            $resumePath = $request->file('resume_path')->store('resumes', 'public');
        }

        $candidate = HhCandidate::create([
            'uuid'        => \Illuminate\Support\Str::uuid(),
            'first_name'  => $validated['first_name'],
            'last_name'   => $validated['last_name'] ?? null,
            'email'       => $validated['email'],
            'phone_number' => $validated['phone_number'] ?? null,
            'password'    => \Illuminate\Support\Facades\Hash::make($validated['password']),
            'address'     => $validated['address'] ?? null,
            'current_job_title'    => $validated['current_job_title'] ?? null,
            'current_company'      => $validated['current_company'] ?? null,
            'employment_status'    => $validated['employment_status'] ?? null,
            'willing_to_relocate'  => $validated['willing_to_relocate'] ?? 'no',
            'work_experience_years' => $validated['work_experience_years'] ?? null,
            'skills'               => $validated['skills'] ?? null,
            'resume_path'          => $resumePath, // simpan path hasil upload
            'portfolio_url'        => $validated['portfolio_url'] ?? null,
            'linkedin_url'         => $validated['linkedin_url'] ?? null,
            'current_salary'       => $validated['current_salary'] ?? null,
            'expected_salary'      => $validated['expected_salary'] ?? null,
            'is_active'            => true,
            'is_profile_complete'  => false,
        ]);

        $token = $candidate->createToken('auth-token')->plainTextToken;

        return response()->json([
            'message' => 'Registrasi berhasil',
            'user'    => $candidate,
            'token'   => $token,
        ], 201);
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend\HH;

use App\Http\Controllers\Controller;
use App\Http\Requests\HHJob\StoreHhJobRequest;
use App\Http\Requests\HHJob\UpdateHhJobRequest;
use App\Models\HhJobListing;
use App\Models\HhJobCategory;
use App\Models\HhCompany;
use App\Services\Headhunter\JobService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class JobListingController extends Controller
{
    public function __construct(private readonly JobService $jobService) {}

    public function index(Request $request): Renderable
    {
        $filters = [
            'search'   => $request->search,
            'category' => $request->category,
            'is_open'  => $request->is_open,
        ];

        $jobs = $this->jobService->get($filters);

        return view('backend.pages.jobs.index', compact('jobs'))
            ->with([
                'breadcrumbs' => [
                    'title' => 'Jobs',
                ],
            ]);
    }

    public function create(): Renderable
    {
        $companies = HhCompany::all();
        $categories = HhJobCategory::all();

        return view('backend.pages.jobs.create', compact('companies', 'categories'))
            ->with([
                'breadcrumbs' => [
                    'title' => 'New Job',
                    'items' => [
                        ['label' => 'Jobs', 'url' => route('admin.headhunters.jobs.index')],
                    ],
                ],
            ]);
    }

    public function store(StoreHhJobRequest $request): RedirectResponse
    {
        $this->jobService->create($request->validated());

        return redirect()->route('admin.headhunters.jobs.index')
            ->with('success', 'Job created successfully.');
    }

    public function show(string $id): Renderable
    {
        $job = HhJobListing::with(['company', 'category'])->findOrFail($id);

        return view('backend.pages.jobs.show', compact('job'))
            ->with([
                'breadcrumbs' => [
                    'title' => "View Job: {$job->job_title}",
                    'items' => [
                        ['label' => 'Jobs', 'url' => route('admin.headhunters.jobs.index')],
                    ],
                ],
            ]);
    }

    public function edit(string $id): Renderable
    {
        $job = HhJobListing::findOrFail($id);
        $companies = HhCompany::all();
        $categories = HhJobCategory::all();

        return view('backend.pages.jobs.edit', compact('job', 'companies', 'categories'))
            ->with([
                'breadcrumbs' => [
                    'title' => "Edit Job: {$job->job_title}",
                    'items' => [
                        ['label' => 'Jobs', 'url' => route('admin.headhunters.jobs.index')],
                    ],
                ],
            ]);
    }

    public function update(UpdateHhJobRequest $request, string $id): RedirectResponse
    {
        $job = HhJobListing::findOrFail($id);

        $this->jobService->update($job, $request->validated());

        return redirect()->route('admin.headhunters.jobs.edit', $job->id)
            ->with('success', 'Job updated successfully.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $job = HhJobListing::findOrFail($id);
        $this->jobService->delete($job);

        return redirect()->route('admin.headhunters.jobs.index')
            ->with('success', 'Job deleted successfully.');
    }

    public function bulkDelete(Request $request): RedirectResponse
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return redirect()->route('admin.headhunters.jobs.index')
                ->with('error', 'No jobs selected for deletion.');
        }

        $deleted = $this->jobService->bulkDelete($ids);

        return redirect()->route('admin.headhunters.jobs.index')
            ->with('success', "$deleted jobs deleted successfully.");
    }

    public function indexPublic(Request $request)
    {
        $query = HhJobListing::with(['company', 'category']);

        // Filter berdasarkan negara
        if ($request->has('country') && $request->country !== 'All') {
            $query->where('country', $request->country);
        }

        // Filter berdasarkan posisi (judul pekerjaan)
        if ($request->has('position') && !empty($request->position)) {
            $query->where('job_title', 'like', '%' . $request->position . '%');
        }

        // Filter berdasarkan lokasi (city)
        if ($request->has('location') && !empty($request->location)) {
            $query->where('city', 'like', '%' . $request->location . '%');
        }

        // Pagination (default 10 per halaman)
        $jobs = $query->orderBy('published_at', 'desc')->paginate($request->get('per_page', 10));

        return response()->json($jobs);
    }

    /**
     * Display the specified job details.
     */
    public function showPublic($id)
    {
        $job = HhJobListing::with(['company', 'category'])->findOrFail($id);

        return response()->json($job);
    }
}

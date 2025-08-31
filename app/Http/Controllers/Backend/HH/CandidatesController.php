<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend\HH;

use App\Http\Controllers\Controller;
use App\Http\Requests\HHCandidate\StoreHhCandidateRequest;
use App\Http\Requests\HHCandidate\UpdateHhCandidateRequest;
use App\Models\HhCandidate;
use App\Services\Headhunter\CandidateService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CandidatesController extends Controller
{
    public function __construct(private readonly CandidateService $candidateService)
    {
        // $this->authorizeResource(HhCandidate::class, 'candidate');
    }

    public function index(Request $request): Renderable
    {
        // $this->authorize('viewAny', HhCandidate::class);

        // Prepare filters
        $filters = [
            'search' => $request->search,
            'is_active' => $request->is_active,
            'is_profile_complete' => $request->is_profile_complete,
        ];

        // Get candidates with pagination using service.
        $candidates = $this->candidateService->get($filters);

        return view('backend.pages.candidates.index', compact('candidates'))
            ->with([
                'breadcrumbs' => [
                    'title' => 'Candidates',
                ],
            ]);
    }

    public function create(): Renderable
    {
        // $this->authorize('create', HhCandidate::class);

        return view('backend.pages.candidates.create')
            ->with([
                'breadcrumbs' => [
                    'title' => 'New Candidate',
                    'items' => [
                        [
                            'label' => 'Candidates',
                            'url' => route('admin.headhunters.candidates.index'),
                        ],
                    ],
                ],
            ]);
    }

    public function store(StoreHhCandidateRequest $request): RedirectResponse
    {
        // $this->authorize('create', HhCandidate::class);

        $this->candidateService->create($request->validated());

        return redirect()->route('admin.headhunters.candidates.index')
            ->with('success', 'Candidate created successfully');
    }

    public function show(string $id): Renderable
    {
        $candidate = HhCandidate::findOrFail($id);
        // $this->authorize('view', $candidate);

        return view('backend.pages.candidates.show', compact('candidate'))
            ->with([
                'breadcrumbs' => [
                    'title' => "View Candidate: {$candidate->first_name}",
                    'items' => [
                        [
                            'label' => 'Candidates',
                            'url' => route('admin.headhunters.candidates.index'),
                        ],
                    ],
                ],
            ]);
    }

    public function edit(string $id): Renderable
    {
        $candidate = HhCandidate::findOrFail($id);
        // $this->authorize('update', $candidate);

        return view('backend.pages.candidates.edit', compact('candidate'))
            ->with([
                'breadcrumbs' => [
                    'title' => "Edit Candidate: {$candidate->first_name}",
                    'items' => [
                        [
                            'label' => 'Candidates',
                            'url' => route('admin.headhunters.candidates.index'),
                        ],
                    ],
                ],
            ]);
    }

    public function update(UpdateHhCandidateRequest $request, string $id): RedirectResponse
    {
        $candidate = HhCandidate::findOrFail($id);
        // $this->authorize('update', $candidate);

        $this->candidateService->update($candidate, $request->validated());

        return redirect()->route('admin.headhunters.candidates.edit', $candidate->id)
            ->with('success', 'Candidate updated successfully');
    }

    public function destroy(string $id): RedirectResponse
    {
        $candidate = HhCandidate::findOrFail($id);
        // $this->authorize('delete', $candidate);

        $this->candidateService->delete($candidate);

        return redirect()->route('admin.headhunters.candidates.index')
            ->with('success', 'Candidate deleted successfully');
    }

    public function bulkDelete(Request $request): RedirectResponse
    {
        $ids = $request->input('ids', []);
        // $this->authorize('bulkDelete', HhCandidate::class);

        if (empty($ids)) {
            return redirect()->route('admin.headhunters.candidates.index')
                ->with('error', 'No candidates selected for deletion');
        }

        $this->candidateService->bulkDelete($ids);

        return redirect()->route('admin.headhunters.candidates.index')
            ->with('success', count($ids) . ' candidates deleted successfully');
    }
}

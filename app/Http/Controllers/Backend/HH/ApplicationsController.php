<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend\HH;

use App\Http\Controllers\Controller;
use App\Models\HhApplication;
use App\Services\Headhunter\ApplicationService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ApplicationsController extends Controller
{
    public function __construct(private readonly ApplicationService $applicationService) {}

    public function index(Request $request): Renderable
    {
        $filters = [
            'search' => $request->search,
            'status' => $request->status,
        ];


        $applications = $this->applicationService->get($filters);

        return view('backend.pages.applications.index', compact('applications'))
            ->with([
                'breadcrumbs' => [
                    'title' => 'Job Applications',
                ],
            ]);
    }

    public function show(string $id): Renderable
    {
        $application = HhApplication::with(['candidate', 'jobListing'])->findOrFail($id);

        $phone = optional($application->candidate)->phone_number;
        if ($phone) {
            $phone = preg_replace('/\D+/', '', $phone);

            if (substr($phone, 0, 2) === '08') {
                $phone = '62' . substr($phone, 1);
            }

            if (substr($phone, 0, 1) === '0') {
                $phone = '62' . substr($phone, 1);
            }
        }

        $application->candidate->wa_number = $phone;

        return view('backend.pages.applications.show', compact('application'))
            ->with([
                'breadcrumbs' => [
                    'title' => 'View Application',
                    'items' => [
                        ['label' => 'Job Applications', 'url' => route('admin.headhunters.applications.index')],
                    ],
                ],
            ]);
    }


    /**
     * Update the status and feedback for a job application.
     *
     * @param Request $request
     * @param string $id
     * @return RedirectResponse
     */
    public function updateStatus(Request $request, string $id): RedirectResponse
    {
        $application = HhApplication::findOrFail($id);

        $validatedData = $request->validate([
            'status' => 'required|string|in:applied,in_review,interview,rejected,hired',
            'feedback' => 'nullable|string',
        ]);

        $this->applicationService->updateStatusAndFeedback($application, $validatedData);

        return redirect()->route('admin.headhunters.applications.show', $application->id)
            ->with('success', 'Application status and feedback updated successfully.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $application = HhApplication::findOrFail($id);

        $this->applicationService->delete($application);

        return redirect()->route('admin.headhunters.applications.index')
            ->with('success', 'Application deleted successfully.');
    }

    public function bulkDelete(Request $request): RedirectResponse
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return redirect()->route('admin.headhunters.applications.index')
                ->with('error', 'No applications selected for deletion.');
        }

        $deleted = $this->applicationService->bulkDelete($ids);

        return redirect()->route('admin.headhunters.applications.index')
            ->with('success', "$deleted applications deleted successfully.");
    }
}

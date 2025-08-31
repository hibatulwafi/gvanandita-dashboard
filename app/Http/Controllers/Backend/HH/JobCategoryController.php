<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend\HH;

use App\Http\Controllers\Controller;
use App\Http\Requests\HHJobCategory\StoreHhJobCategoryRequest;
use App\Http\Requests\HHJobCategory\UpdateHhJobCategoryRequest;
use App\Models\HhJobCategory;
use App\Services\Headhunter\JobCategoryService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class JobCategoryController extends Controller
{
    public function __construct(private readonly JobCategoryService $jobCategoryService) {}

    public function index(Request $request): Renderable
    {
        $filters = [
            'search' => $request->search,
        ];

        $categories = $this->jobCategoryService->get($filters);

        return view('backend.pages.job-categories.index', compact('categories'))
            ->with([
                'breadcrumbs' => [
                    'title' => 'Job Categories',
                ],
            ]);
    }

    public function create(): Renderable
    {
        return view('backend.pages.job-categories.create')
            ->with([
                'breadcrumbs' => [
                    'title' => 'New Job Category',
                    'items' => [
                        [
                            'label' => 'Job Categories',
                            'url' => route('admin.headhunters.job-categories.index'),
                        ],
                    ],
                ],
            ]);
    }

    public function store(StoreHhJobCategoryRequest $request): RedirectResponse
    {
        $this->jobCategoryService->create($request->validated());

        return redirect()->route('admin.headhunters.job-categories.index')
            ->with('success', 'Job Category created successfully');
    }

    public function edit(string $id): Renderable
    {
        $category = HhJobCategory::findOrFail($id);

        return view('backend.pages.job-categories.edit', compact('category'))
            ->with([
                'breadcrumbs' => [
                    'title' => "Edit Job Category: {$category->name}",
                    'items' => [
                        [
                            'label' => 'Job Categories',
                            'url' => route('admin.headhunters.job-categories.index'),
                        ],
                    ],
                ],
            ]);
    }

    public function update(UpdateHhJobCategoryRequest $request, string $id): RedirectResponse
    {
        $category = HhJobCategory::findOrFail($id);

        $this->jobCategoryService->update($category, $request->validated());

        return redirect()->route('admin.headhunters.job-categories.edit', $category->id)
            ->with('success', 'Job Category updated successfully');
    }

    public function destroy(string $id): RedirectResponse
    {
        $category = HhJobCategory::findOrFail($id);

        $this->jobCategoryService->delete($category);

        return redirect()->route('admin.headhunters.job-categories.index')
            ->with('success', 'Job Category deleted successfully');
    }

    public function bulkDelete(Request $request): RedirectResponse
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return redirect()->route('admin.headhunters.job-categories.index')
                ->with('error', 'No job categories selected for deletion');
        }

        $this->jobCategoryService->bulkDelete($ids);

        return redirect()->route('admin.headhunters.job-categories.index')
            ->with('success', count($ids) . ' job categories deleted successfully');
    }
}

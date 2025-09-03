<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend\HH;

use App\Http\Controllers\Controller;
use App\Http\Requests\HHCompany\StoreHhCompanyRequest;
use App\Http\Requests\HHCompany\UpdateHhCompanyRequest;
use App\Models\HhCompany;
use App\Models\User;
use App\Services\Headhunter\CompanyService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    public function __construct(private readonly CompanyService $companyService)
    {
        // $this->authorizeResource(HhCompany::class, 'company');
    }

    public function index(Request $request): Renderable
    {
        // $this->authorize('viewAny', HhCompany::class);

        $filters = [
            'search'    => $request->search,
            'industry'  => $request->industry,
            'is_active' => $request->is_active,
        ];

        $companies = $this->companyService->get($filters);

        return view('backend.pages.companies.index', compact('companies'))
            ->with([
                'breadcrumbs' => [
                    'title' => 'Companies',
                ],
            ]);
    }

    public function create(): View
    {
        // $this->authorize('create', HhCompany::class);

        $users = User::all();

        return view('backend.pages.companies.create')
            ->with([
                'breadcrumbs' => [
                    'title' => 'New Company',
                    'items' => [
                        [
                            'label' => 'Companies',
                            'url' => route('admin.headhunters.companies.index'),
                        ],
                    ],
                ],
                'users' => $users
            ]);
    }

    public function store(StoreHhCompanyRequest $request): RedirectResponse
    {
        // $this->authorize('create', HhCompany::class);

        $validatedData = $request->validated();

        $this->companyService->create($validatedData);

        return redirect()->route('admin.headhunters.companies.index')
            ->with('success', 'Company created successfully');
    }

    public function show(string $id): Renderable
    {
        // $this->authorize('view', $company);
        $company = HhCompany::findOrFail($id);

        return view('backend.pages.companies.show', compact('company'))
            ->with([
                'breadcrumbs' => [
                    'title' => "View Company: {$company->company_name}",
                    'items' => [
                        [
                            'label' => 'Companies',
                            'url' => route('admin.headhunters.companies.index'),
                        ],
                    ],
                ],
            ]);
    }

    public function edit(string $id): Renderable
    {
        // $this->authorize('update', $company);
        $company = HhCompany::findOrFail($id);
        $users = User::all();

        return view('backend.pages.companies.edit', compact('company'))
            ->with([
                'breadcrumbs' => [
                    'title' => "Edit Company: {$company->company_name}",
                    'items' => [
                        [
                            'label' => 'Companies',
                            'url' => route('admin.headhunters.companies.index'),
                        ],
                    ],
                ],
                'users' => $users
            ]);
    }

    public function update(UpdateHhCompanyRequest $request, string $id): RedirectResponse
    {
        $company = HhCompany::findOrFail($id);
        // $this->authorize('update', $company);

        $this->companyService->update($company, $request->validated());

        return redirect()->route('admin.headhunters.companies.edit', $company->id)
            ->with('success', 'Company updated successfully');
    }

    public function destroy(string $id): RedirectResponse
    {
        $company = HhCompany::findOrFail($id);
        // $this->authorize('delete', $company);

        $this->companyService->delete($company);

        return redirect()->route('admin.headhunters.companies.index')
            ->with('success', 'Company deleted successfully');
    }

    public function bulkDelete(Request $request): RedirectResponse
    {
        $ids = $request->input('ids', []);
        // $this->authorize('bulkDelete', HhCompany::class);

        if (empty($ids)) {
            return redirect()->route('admin.headhunters.companies.index')
                ->with('error', 'No companies selected for deletion');
        }

        $this->companyService->bulkDelete($ids);

        return redirect()->route('admin.headhunters.companies.index')
            ->with('success', count($ids) . ' companies deleted successfully');
    }
}

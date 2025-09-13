<?php

declare(strict_types=1);

namespace App\Services\Headhunter;

use App\Models\HhCompany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class CompanyService
{
    public function get(array $filters): LengthAwarePaginator
    {
        $query = HhCompany::query()->orderBy('created_at', 'desc');

        if (!empty($filters['search'])) {
            $search = "%{$filters['search']}%";
            $query->where(function (Builder $q) use ($search) {
                $q->where('company_name', 'like', $search)
                    ->orWhere('contact_person_name', 'like', $search)
                    ->orWhere('contact_person_email', 'like', $search);
            });
        }

        if (isset($filters['is_active'])) {
            $query->where('is_active', (bool) $filters['is_active']);
        }

        return $query->paginate(15);
    }

    public function create(array $data): HhCompany
    {
        $data['uuid'] = Str::uuid();
        return HhCompany::create($data);
    }

    public function update(HhCompany $company, array $data): HhCompany
    {
        $company->update($data);
        return $company;
    }

    public function delete(HhCompany $company): void
    {
        $company->delete();
    }

    public function bulkDelete(array $ids): void
    {
        HhCompany::whereIn('id', $ids)->delete();
    }
}

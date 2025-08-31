<?php

declare(strict_types=1);

namespace App\Services\Headhunter;

use App\Models\HhJobListing;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class JobService
{
    public function get(array $filters = []): LengthAwarePaginator
    {
        $query = HhJobListing::with(['company', 'category'])->latest();

        if (!empty($filters['search'])) {
            $query->where('job_title', 'like', "%{$filters['search']}%");
        }

        if (!empty($filters['category'])) {
            $query->where('category_id', $filters['category']);
        }

        if (isset($filters['is_open'])) {
            $query->where('is_open', $filters['is_open']);
        }

        return $query->paginate(10);
    }

    public function create(array $data): HhJobListing
    {
        return HhJobListing::create($data);
    }

    public function update(HhJobListing $job, array $data): bool
    {
        return $job->update($data);
    }

    public function delete(HhJobListing $job): bool
    {
        return $job->delete();
    }

    public function bulkDelete(array $ids): int
    {
        return HhJobListing::whereIn('id', $ids)->delete();
    }
}

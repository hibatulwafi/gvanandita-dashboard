<?php

declare(strict_types=1);

namespace App\Services\Headhunter;

use App\Models\HhJobListing;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

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
        $data['slug'] = Str::slug($data['job_title'] . '-' . Str::random(6));
        return HhJobListing::create($data);
    }

    public function update(HhJobListing $job, array $data): bool
    {
        if (isset($data['job_title'])) {
            $data['slug'] = Str::slug($data['job_title'] . '-' . Str::random(6));
        }
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

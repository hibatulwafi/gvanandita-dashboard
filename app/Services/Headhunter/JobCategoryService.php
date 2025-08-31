<?php

namespace App\Services\Headhunter;

use App\Models\HhJobCategory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class JobCategoryService
{
    public function get(array $filters = []): LengthAwarePaginator
    {
        $query = HhJobCategory::query();

        if (!empty($filters['search'])) {
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        }

        return $query->latest()->paginate(10);
    }

    public function create(array $data): HhJobCategory
    {
        return HhJobCategory::create($data);
    }

    public function update(HhJobCategory $category, array $data): bool
    {
        return $category->update($data);
    }

    public function delete(HhJobCategory $category): bool
    {
        return $category->delete();
    }

    public function bulkDelete(array $ids): int
    {
        return HhJobCategory::whereIn('id', $ids)->delete();
    }
}

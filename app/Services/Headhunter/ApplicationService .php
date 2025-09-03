<?php

namespace App\Services\Headhunter;

use App\Models\HhApplication;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ApplicationService
{
    /**
     * Get a list of job applications with filters and pagination.
     *
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function get(array $filters): LengthAwarePaginator
    {
        $query = HhApplication::with(['candidate', 'jobListing'])
            ->latest();

        if (!empty($filters['search'])) {
            $query->where(function (Builder $query) use ($filters) {
                $query->whereHas('candidate', function (Builder $q) use ($filters) {
                    $q->where('name', 'like', '%' . $filters['search'] . '%');
                })->orWhereHas('jobListing', function (Builder $q) use ($filters) {
                    $q->where('job_title', 'like', '%' . $filters['search'] . '%');
                });
            });
        }

        return $query->paginate(15);
    }

    /**
     * Delete a single job application.
     *
     * @param HhApplication $application
     * @return bool|null
     */
    public function delete(HhApplication $application): bool|null
    {
        return $application->delete();
    }

    /**
     * Perform a bulk delete on a list of applications by their IDs.
     *
     * @param array $ids
     * @return int
     */
    public function bulkDelete(array $ids): int
    {
        return HhApplication::destroy($ids);
    }
}

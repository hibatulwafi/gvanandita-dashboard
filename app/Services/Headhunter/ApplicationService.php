<?php

declare(strict_types=1);

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

        // Tambahkan filter status
        if (!empty($filters['status'])) {
            $formattedStatus = ucwords(str_replace('_', ' ', $filters['status']));
            $query->where('status', $formattedStatus);
        }

        if (!empty($filters['search'])) {
            $searchTerm = $filters['search'];
            $query->where(function (Builder $query) use ($searchTerm) {
                // Search for full name in candidate table
                $query->whereHas('candidate', function (Builder $q) use ($searchTerm) {
                    $terms = explode(' ', $searchTerm);
                    foreach ($terms as $term) {
                        $q->where(function (Builder $subQ) use ($term) {
                            $subQ->where('first_name', 'like', '%' . $term . '%')
                                ->orWhere('last_name', 'like', '%' . $term . '%');
                        });
                    }
                })
                    // Search for job title in job listing table
                    ->orWhereHas('jobListing', function (Builder $q) use ($searchTerm) {
                        $q->where('job_title', 'like', '%' . $searchTerm . '%');
                    });
            });
        }

        return $query->paginate(15);
    }

    /**
     * Update the status and feedback for a job application.
     *
     * @param HhApplication $application
     * @param array $data
     * @return bool
     */
    public function updateStatusAndFeedback(HhApplication $application, array $data): bool
    {
        return $application->update([
            'status' => $data['status'],
            'feedback' => $data['feedback'],
        ]);
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

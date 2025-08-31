<?php

declare(strict_types=1);

namespace App\Services\Headhunter;

use App\Models\HhCandidate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CandidateService
{
    public function get(array $filters): LengthAwarePaginator
    {
        $query = HhCandidate::query();

        if (isset($filters['search'])) {
            $query->where(function (Builder $q) use ($filters) {
                $search = "%{$filters['search']}%";
                $q->where('first_name', 'like', $search)
                    ->orWhere('last_name', 'like', $search)
                    ->orWhere('email', 'like', $search);
            });
        }

        if (isset($filters['is_active'])) {
            $query->where('is_active', (bool) $filters['is_active']);
        }

        if (isset($filters['is_profile_complete'])) {
            $query->where('is_profile_complete', (bool) $filters['is_profile_complete']);
        }

        return $query->paginate(15);
    }

    public function create(array $data): HhCandidate
    {
        $data['uuid'] = Str::uuid();
        $data['password'] = Hash::make($data['password']);

        if (isset($data['resume_file'])) {
            $data['resume_path'] = $this->uploadResume($data['resume_file']);
            unset($data['resume_file']);
        }

        $candidate = HhCandidate::create($data);

        return $candidate;
    }

    public function update(HhCandidate $candidate, array $data): HhCandidate
    {
        if (isset($data['resume_file'])) {
            // Delete old resume file if it exists
            if ($candidate->resume_path) {
                $this->deleteResume($candidate->resume_path);
            }
            $data['resume_path'] = $this->uploadResume($data['resume_file']);
            unset($data['resume_file']);
        } elseif (isset($data['remove_resume']) && $data['remove_resume']) {
            $this->deleteResume($candidate->resume_path);
            $data['resume_path'] = null;
        }

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $candidate->update($data);

        return $candidate;
    }

    public function delete(HhCandidate $candidate): void
    {
        if ($candidate->resume_path) {
            $this->deleteResume($candidate->resume_path);
        }

        $candidate->delete();
    }

    public function bulkDelete(array $ids): void
    {
        $candidates = HhCandidate::whereIn('id', $ids)->get();

        foreach ($candidates as $candidate) {
            $this->delete($candidate);
        }
    }

    protected function uploadResume($file): string
    {
        $filePath = $file->store('resumes');
        return $filePath;
    }

    protected function deleteResume(string $path): void
    {
        if (Storage::exists($path)) {
            Storage::delete($path);
        }
    }
}

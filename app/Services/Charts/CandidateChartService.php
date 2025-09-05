<?php

declare(strict_types=1);

namespace App\Services\Charts;

use App\Models\HhCandidate as Candidate;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class CandidateChartService extends ChartService
{
    /**
     * Get candidate growth data for the line chart.
     */
    public function getCandidateGrowthData(string $period = 'last_12_months'): JsonResponse
    {
        [$startDate, $endDate] = $this->getDateRange($period);

        // Determine if the range spans less than a month
        $isLessThanMonth = $startDate->diffInMonths($endDate) === 0;

        $format = $isLessThanMonth ? 'd M Y' : 'M Y';
        $dbFormat = $isLessThanMonth ? 'Y-m-d' : 'Y-m';
        $intervalMethod = $isLessThanMonth ? 'addDay' : 'addMonth';

        $labels = $this->generateLabels($startDate, $endDate, $format, $intervalMethod);
        $candidateGrowth = $this->fetchCandidateGrowthData($startDate, $endDate, $isLessThanMonth);

        $formattedData = $labels->mapWithKeys(function ($label) use ($candidateGrowth, $format, $dbFormat) {
            $dbKey = Carbon::createFromFormat($format, $label)->format($dbFormat);

            return [$label => $candidateGrowth[$dbKey] ?? 0]; // Default to 0 if not found
        });

        return response()->json([
            'labels' => $formattedData->keys()->toArray(),
            'data' => $formattedData->values()->toArray(),
        ]);
    }

    /**
     * Get candidate history data for the pie chart
     */
    public function getCandidateHistoryData(): array
    {
        $thirtyDaysAgo = Carbon::now()->subDays(30);
        $totalCandidates = Candidate::count();

        // Get new candidates count (last 30 days).
        $newCandidates = Candidate::where('created_at', '>=', $thirtyDaysAgo)->count();

        return [
            'new_candidates' => $newCandidates,
            'old_candidates' => $totalCandidates - $newCandidates,
            'total_candidates' => $totalCandidates,
        ];
    }

    private function fetchCandidateGrowthData(Carbon $startDate, Carbon $endDate, bool $isLessThanMonth): Collection
    {
        $connection = DB::connection();
        $driver = $connection->getDriverName();

        if ($isLessThanMonth) {
            $selectRaw = 'DATE(created_at) as day, COUNT(id) as total';
            $groupBy = 'day';
        } else {
            if ($driver === 'sqlite') {
                $selectRaw = "strftime('%Y-%m', created_at) as month, COUNT(id) as total";
            } else {
                $selectRaw = "DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(id) as total";
            }
            $groupBy = 'month';
        }

        return Candidate::selectRaw($selectRaw)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy($groupBy)
            ->orderBy($groupBy)
            ->pluck('total', $groupBy);
    }
}

<?php

namespace Database\Factories;

use App\Models\HhApplication;
use App\Models\HhCandidate;
use App\Models\HhJobListing;
use Illuminate\Database\Eloquent\Factories\Factory;

class HhApplicationFactory extends Factory
{
    protected $model = HhApplication::class;

    public function definition(): array
    {
        $candidateIds = HhCandidate::pluck('id')->toArray();
        $jobListingIds = HhJobListing::pluck('id')->toArray();

        return [
            'candidate_id' => !empty($candidateIds) ? $this->faker->randomElement($candidateIds) : HhCandidate::factory(),
            'job_listing_id' => !empty($jobListingIds) ? $this->faker->randomElement($jobListingIds) : HhJobListing::factory(),
            'status' => $this->faker->randomElement(['applied', 'in_review', 'interview', 'hired', 'rejected']),
            'applied_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
            'feedback' => $this->faker->boolean(30) ? $this->faker->sentence() : null,
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\HhJobListing;
use App\Models\HhCompany;
use App\Models\HhJobCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class HhJobListingFactory extends Factory
{
    protected $model = HhJobListing::class;

    public function definition(): array
    {
        // Ambil id company dan category yang ada
        $companyIds = HhCompany::pluck('id')->toArray();
        $categoryIds = HhJobCategory::pluck('id')->toArray();

        return [
            'company_id' => !empty($companyIds) ? $this->faker->randomElement($companyIds) : HhCompany::factory(),
            'category_id' => !empty($categoryIds) ? $this->faker->randomElement($categoryIds) : HhJobCategory::factory(),
            'job_title' => $this->faker->jobTitle(),
            'description' => $this->faker->paragraphs(3, true),
            'job_location_type' => $this->faker->randomElement(['On-site', 'Remote', 'Hybrid']),
            'experience_level' => $this->faker->randomElement(['Junior', 'Mid', 'Senior']),
            'city' => $this->faker->city(),
            'country' => $this->faker->country(),
            'salary_currency' => 'IDR',
            'min_salary' => $this->faker->numberBetween(5_000_000, 10_000_000),
            'max_salary' => $this->faker->numberBetween(10_000_000, 25_000_000),
            'job_type' => $this->faker->randomElement(['full-time', 'part-time', 'contract', 'freelance']),
            'is_featured' => $this->faker->boolean(10),
            'is_open' => $this->faker->boolean(95),
            'expires_at' => $this->faker->dateTimeBetween('now', '+3 months'),
            'published_at' => now(),
        ];
    }
}

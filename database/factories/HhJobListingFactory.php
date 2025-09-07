<?php

namespace Database\Factories;

use App\Models\HhJobListing;
use App\Models\HhCompany;
use App\Models\HhJobCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class HhJobListingFactory extends Factory
{
    protected $model = HhJobListing::class;

    public function definition(): array
    {
        // Ambil id company dan category yang ada
        $companyIds = HhCompany::pluck('id')->toArray();
        $categoryIds = HhJobCategory::pluck('id')->toArray();
        $title = $this->faker->jobTitle();

        return [
            'company_id' => !empty($companyIds) ? $this->faker->randomElement($companyIds) : HhCompany::factory(),
            'category_id' => !empty($categoryIds) ? $this->faker->randomElement($categoryIds) : $this->faker->numberBetween(1, 9),
            'job_title' => $title,
            'slug' => Str::slug($title . '-' . Str::random(6)),
            'description' => $this->faker->paragraphs(3, true),
            'job_location_type' => $this->faker->randomElement(['Remote', 'On-site', 'Hybrid']),
            'experience_level' => $this->faker->randomElement(['Entry-level', 'Mid-level', 'Senior-level', 'Director', 'Executive']),
            'city' => $this->faker->city(),
            'country' => $this->faker->country(),
            'salary_currency' => 'IDR',
            'min_salary' => $this->faker->numberBetween(5_000_000, 10_000_000),
            'max_salary' => $this->faker->numberBetween(10_000_000, 25_000_000),
            'job_type' => $this->faker->randomElement(['Full-time', 'Part-time', 'Contract', 'Internship', 'Temporary']),
            'is_featured' => $this->faker->boolean(20), // 20% chance to be featured
            'is_open' => true,
            'expires_at' => $this->faker->dateTimeBetween('+1 month', '+3 months'),
            'published_at' => now(),
        ];
    }
}

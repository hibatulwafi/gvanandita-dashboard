<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class HhCandidateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $employmentStatus = $this->faker->randomElement(['employed', 'unemployed', 'freelancer']);
        $workExperience = $this->faker->randomElement(['<1', '1-3', '3-5', '5-10', '>10']);

        return [
            'uuid' => Str::uuid(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone_number' => $this->faker->phoneNumber(),
            'password' => Hash::make('password'),
            'address' => $this->faker->address(),
            'current_job_title' => $this->faker->jobTitle(),
            'current_company' => $this->faker->company(),
            'employment_status' => $employmentStatus,
            'willing_to_relocate' => $this->faker->randomElement(['yes', 'no', 'negotiable']),
            'work_experience_years' => $workExperience,
            'skills' => $this->faker->words(5, true),
            'resume_path' => 'resumes/' . $this->faker->slug() . '.pdf',
            'portfolio_url' => $this->faker->url(),
            'linkedin_url' => 'https://linkedin.com/in/' . $this->faker->userName(),
            'current_salary' => $this->faker->numberBetween(5000000, 20000000),
            'expected_salary' => $this->faker->numberBetween(7000000, 25000000),
            'email_verified_at' => $this->faker->boolean(80) ? now() : null,
            'is_active' => true,
            'is_profile_complete' => $this->faker->boolean(75),

        ];
    }
}

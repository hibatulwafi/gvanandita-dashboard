<?php

namespace Database\Factories;

use App\Models\HhCompany;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class HhCompanyFactory extends Factory
{
    protected $model = HhCompany::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'company_name' => $this->faker->company(),
            'contact_person_name' => $this->faker->name(),
            'contact_person_email' => $this->faker->unique()->safeEmail(),
            'contact_person_phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'industry' => $this->faker->jobTitle(),
            'is_active' => $this->faker->boolean(90),
        ];
    }
}
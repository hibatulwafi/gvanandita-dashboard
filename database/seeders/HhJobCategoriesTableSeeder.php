<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HhJobCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Software Development',
            'Digital Marketing',
            'Finance',
            'Human Resources',
            'Data Science',
            'UI/UX Design',
            'Operations',
            'Sales',
            'Customer Service'
        ];

        foreach ($categories as $category) {
            DB::table('hh_job_categories')->insert([
                'name' => $category,
                'slug' => Str::slug($category),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

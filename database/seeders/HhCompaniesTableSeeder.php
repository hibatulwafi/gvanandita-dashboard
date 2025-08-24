<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HhCompany;

class HhCompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HhCompany::factory()->count(100)->create();
    }
}
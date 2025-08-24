<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HhJobListing;

class HhJobListingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat 30 job listing secara acak
        HhJobListing::factory(30)->create();
    }
}

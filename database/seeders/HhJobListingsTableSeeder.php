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
        HhJobListing::factory(30)->create();
    }
}

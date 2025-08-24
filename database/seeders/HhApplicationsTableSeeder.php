<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HhApplication;

class HhApplicationsTableSeeder extends Seeder
{
    /**
     * Jalankan database seeder.
     */
    public function run(): void
    {
        // Buat 50 aplikasi secara acak
        HhApplication::factory(50)->create();
    }
}

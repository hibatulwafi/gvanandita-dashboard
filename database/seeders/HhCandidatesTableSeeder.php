<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\HhCandidate;

class HhCandidatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HhCandidate::query()->delete();
        HhCandidate::factory()->count(500)->create();
        $this->command->info('Tabel hh_candidates seeded dengan 500 kandidat!');
    }
}

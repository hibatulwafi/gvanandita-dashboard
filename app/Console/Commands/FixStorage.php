<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class FixStorage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:storage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perbaiki folder storage/framework agar Laravel bisa jalan normal';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $paths = [
            storage_path('framework/cache'),
            storage_path('framework/sessions'),
            storage_path('framework/views'),
            storage_path('framework/testing'),
        ];

        foreach ($paths as $path) {
            if (!File::exists($path)) {
                File::makeDirectory($path, 0775, true);
                $this->info("✅ Created: {$path}");
            } else {
                $this->line("✔ Already exists: {$path}");
            }
        }

        // Clear caches
        $this->callSilent('config:clear');
        $this->callSilent('cache:clear');
        $this->callSilent('view:clear');

        $this->info("🎉 Storage framework fixed and caches cleared!");
    }
}

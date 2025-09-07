<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hh_candidates', function (Blueprint $table) {
            $table->id();
            // Informasi Pribadi & Kontak
            $table->uuid('uuid')->unique();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('phone_number', 50)->nullable();
            $table->string('password')->nullable();
            $table->text('address')->nullable();

            // Informasi Profesional
            $table->string('current_job_title')->nullable();
            $table->string('current_company')->nullable();
            $table->enum('employment_status', ['employed', 'unemployed', 'freelancer'])->nullable();
            $table->enum('willing_to_relocate', ['yes', 'no', 'negotiable'])->default('no');
            $table->enum('work_experience_years', ['<1', '1-3', '3-5', '5-10', '>10'])->nullable();

            // Keahlian & Kualifikasi
            $table->text('skills')->nullable();
            $table->string('resume_path')->nullable();
            $table->string('portfolio_url')->nullable();
            $table->string('linkedin_url')->nullable();

            // Gaji & Preferensi
            $table->decimal('current_salary', 10, 2)->nullable();
            $table->decimal('expected_salary', 10, 2)->nullable();

            // Verifikasi & Status Akun
            $table->string('email_verification_token')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone_verification_token')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_profile_complete')->default(false);
            $table->text('remember_token')->nullable();

            // Log Waktu
            $table->timestamps();
            $table->index(['is_active', 'is_profile_complete']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hh_candidates');
    }
};

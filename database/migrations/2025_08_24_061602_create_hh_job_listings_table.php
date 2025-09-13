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
        Schema::create('hh_job_listings', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('category_id')->nullable();

            $table->string('job_title');
            $table->string('slug')->unique();
            $table->longText('description');
            $table->string('job_location_type', 50)->default('On-site');
            $table->string('experience_level', 50);
            $table->string('city')->nullable();
            $table->string('country')->nullable();

            $table->string('salary_currency', 10)->default('IDR');
            $table->decimal('min_salary', 12, 2)->nullable();
            $table->decimal('max_salary', 12, 2)->nullable();

            $table->enum('job_type', ['full-time', 'part-time', 'contract', 'freelance', 'internship', 'temporary'])->nullable();
            $table->boolean('is_show_salary')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_open')->default(true);

            $table->timestamp('expires_at')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('hh_companies')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('hh_job_categories')->onDelete('set null');

            $table->index(['is_open', 'job_location_type', 'experience_level']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hh_job_listings');
    }
};

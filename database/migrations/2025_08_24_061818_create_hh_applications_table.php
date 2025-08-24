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
        Schema::create('hh_applications', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('candidate_id');
            $table->unsignedBigInteger('job_listing_id');
            
            $table->enum('status', ['applied', 'in_review', 'interview', 'hired', 'rejected'])->default('applied');

            $table->timestamp('applied_at');
            $table->text('feedback')->nullable();

            $table->timestamps();

            $table->foreign('candidate_id')->references('id')->on('hh_candidates')->onDelete('cascade');
            $table->foreign('job_listing_id')->references('id')->on('hh_job_listings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hh_applications');
    }
};
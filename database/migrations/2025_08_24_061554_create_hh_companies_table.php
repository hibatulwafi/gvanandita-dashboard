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
        Schema::create('hh_companies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('company_name');
            $table->string('contact_person_name');
            $table->string('contact_person_email');
            $table->string('contact_person_phone', 50)->nullable();
            $table->text('address')->nullable();
            $table->string('industry');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Mendefinisikan kunci asing
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hh_companies');
    }
};

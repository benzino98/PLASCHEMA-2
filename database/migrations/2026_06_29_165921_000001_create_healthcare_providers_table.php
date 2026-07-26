<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('healthcare_providers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('lga');
            $table->string('specialty')->nullable();
            $table->string('ownership')->nullable();
            $table->json('services')->nullable();
            $table->text('address');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('working_hours')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('accreditation_status')->default('accredited');
            $table->boolean('is_published')->default(true);
            $table->timestamps();

            $table->index('lga');
            $table->index('specialty');
            $table->index('ownership');
            $table->index('accreditation_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('healthcare_providers');
    }
};

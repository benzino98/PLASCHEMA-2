<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plan_benefits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('health_plan_id')->constrained()->cascadeOnDelete();
            $table->string('benefit_key');
            $table->string('benefit_label');
            $table->boolean('is_included')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['health_plan_id', 'benefit_key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plan_benefits');
    }
};

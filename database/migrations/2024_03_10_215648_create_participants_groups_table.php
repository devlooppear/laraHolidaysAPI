<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('participants_groups', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('holiday_plan_id')->nullable();
            $table->bigInteger('participant_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('participants_groups');
    }
};

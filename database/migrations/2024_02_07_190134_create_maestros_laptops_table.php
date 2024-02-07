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
        Schema::create('maestros_laptops', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('maestro_id');
            $table->foreign('maestro_id')->references('id')->on('maestro_apto_lap');
            $table->unsignedBigInteger('laptop_id');
            $table->foreign('laptop_id')->references('id')->on('laptops_data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maestros_laptops');
    }
};

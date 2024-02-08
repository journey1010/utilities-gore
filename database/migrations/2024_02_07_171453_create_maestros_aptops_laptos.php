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
        Schema::create('maestro_apto_lap', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('provincia');
            $table->string('dni')->nullable();
            $table->string('ie')->nullable();
            $table->string('condicion')->nullable();
            $table->string('nivel')->nullable();
            $table->string('distrito')->nullable();
            $table->boolean('is_laptop_received')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maestro_apto_lap');
    }
};

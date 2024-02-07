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
            $table->foreignId('provincia_id')->references('id')->on('provincias');
            $table->string('id_provincia');
            $table->string('dni')->nullable();
            $table->string('ie')->nullable();
            $table->string('condicion')->nullable();
            $table->string('nivel')->nullable();
            $table->string('distrito')->nullable();
            $table->boolean('is_laptop_received')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maestro_apto_lap', function (Blueprint $table) {
            $table->dropForeign('id_provincia');
        });
        Schema::dropIfExists('maestro_apto_lap');
    }
};

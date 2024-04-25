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
        Schema::table('agentes_participantes_presupuesto', function (Blueprint $table) {
            $table->boolean('discapacitado')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agentes_participantes_presupuesto', function (Blueprint $table) {
            $table->dropColumn('discapacitado');
        });
    }
};

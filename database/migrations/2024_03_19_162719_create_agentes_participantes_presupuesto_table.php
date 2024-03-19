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
        Schema::create('agentes_participantes_presupuesto', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 500);
            $table->string('dni', 8);
            $table->date('fecha_nacimiento')->nullable();
            $table->enum('genero', ['M', 'F']);
            $table->string('organizacion');
            $table->string('organizacion_tipo');
            $table->string('email')->nullable();
            $table->string('profesion', 500)->nullable();
            $table->string('cargo', 500);
            $table->string('comite_vigilancia', 800);
            $table->string('equipo_tecnico', 800);
            $table->string('grado_instruccion')->nullable();
            $table->string('credencial');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agentes_participantes_presupuesto');
    }
};
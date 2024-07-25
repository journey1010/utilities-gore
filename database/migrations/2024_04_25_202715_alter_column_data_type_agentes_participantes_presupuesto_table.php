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
        Schema::table('agentes_participantes_presupuesto', function(Blueprint $table){
            $table->enum('genero', ['M', 'F'])->nullable()->change();
            $table->date('fecha_nacimiento')->nullable()->change();
            $table->string('organizacion')->nullable()->change();
            $table->string('organizacion_tipo')->nullable()->change();
            $table->string('cargo')->nullable()->change();
            $table->string('comite_vigilancia')->nullable()->change();
            $table->string('equipo_tecnico')->nullable()->change();
            $table->string('credencial')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agentes_participantes_presupuesto', function(Blueprint $table){
            $table->enum('genero', ['M', 'F'])->change();
            $table->date('fecha_nacimiento')->change();
            $table->string('organizacion')->change();
            $table->string('cargo')->change();
            $table->string('comite_vigilancia')->change();
            $table->string('equipo_tecnico')->change();
            $table->string('credencial')->change();
            $table->string('organizacion_tipo')->change();
        });
    }
};

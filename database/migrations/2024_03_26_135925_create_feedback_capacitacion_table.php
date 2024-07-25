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
        Schema::create('feedback_capacitacion', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('grado_satisfacción');
            $table->enum('curso_maxima_atencion', ['SIGEDOC', 'HELPDESK', 'CHATBOT', 'OFIMATICA-WORD', 'OFIMATICA-EXCEL', 'SEGURIDAD DE LA INFORMACION']);
            $table->enum('curso_gustaria_aprender', ['Portal de Transparencia Estándar', 'Ofimática Avanzada-IA']);
            $table->enum('opinion_mejora_capacitacion', ['Presencial', 'Zoom', 'Equipos Tecnológicos']);
            $table->string('horario_capacitacion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback_capacitacion');
    }
};

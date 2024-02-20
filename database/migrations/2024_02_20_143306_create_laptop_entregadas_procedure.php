<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared("
            CREATE PROCEDURE laptopEntregadas()
            BEGIN 
                SELECT 
                    m.provincia AS Provincia,
                    (SELECT COUNT(*) FROM maestro_apto_lap WHERE provincia = m.provincia) AS TotalPorProvincia,
                    COUNT(ml.maestro_id) AS Entregado, 
                    (SELECT COUNT(id) FROM maestro_apto_lap WHERE provincia = m.provincia) - COUNT(ml.maestro_id) AS RestanteProvincia
                FROM  
                    maestro_apto_lap AS m
                INNER JOIN  
                    maestros_laptops AS ml ON m.id = ml.maestro_id
                GROUP BY 
                    m.provincia;
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS laptopEntregadas');
    }
};

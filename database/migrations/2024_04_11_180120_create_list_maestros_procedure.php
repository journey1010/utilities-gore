<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared("
            DROP PROCEDURE IF EXISTS obtenerListMaestrosLaptops;
            CREATE PROCEDURE obtenerListMaestrosLaptops(
                IN provincia VARCHAR(255)
            )
            BEGIN 
                SELECT 
                    m.provincia as Provincia, 
                    m.full_name as FullName, 
                    m.dni as DNI,
                    COALESCE(lap.serie, 'Sin laptop asignada') as SerieLap, 
                    CASE WHEN ml.id IS NOT NULL THEN 'Sí' ELSE 'No' END as LaptopRecibida,
                    ml.created_at  as date
                FROM maestro_apto_lap as m 
                LEFT JOIN maestros_laptops as ml ON ml.maestro_id = m.id 
                LEFT JOIN laptops_data AS lap ON ml.laptop_id = lap.id 
                WHERE m.provincia LIKE CONCAT('%', provincia, '%')
                ORDER BY m.is_laptop_received DESC;
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_maestros_procedure');
    }
};

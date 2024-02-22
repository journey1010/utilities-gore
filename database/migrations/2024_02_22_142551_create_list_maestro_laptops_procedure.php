<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Crea una migracion para obtener la lista de maestros con las laptops que le fueron asignadas
     * Si es que recibio alguna
     */
    public function up(): void
    {
        DB::unprepared("
            CREATE PROCEDURE obtenerListMaestrosLaptops(
                IN provincia VARCHAR(255)
            )
            BEGIN 
                SELECT 
                    m.provincia as Provincia, 
                    m.full_name as FullName, 
                    COALESCE(lap.serie, 'Sin laptop asignada') as SerieLap, 
                    CASE WHEN ml.id IS NOT NULL THEN 'Sí' ELSE 'No' END as LaptopRecibida 
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
        DB::unprepared('DROP IF EXIST obtenerListMaestrosLaptops');
    }
};

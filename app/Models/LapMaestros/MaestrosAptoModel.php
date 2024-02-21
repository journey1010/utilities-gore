<?php

namespace App\Models\LapMaestros;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MaestrosAptoModel extends Model
{
    use HasFactory;

    public $table = 'maestro_apto_lap';

    protected $connection = 'utilities'; 

    protected $fillable = [
        'full_name',
        'provincia',
        'dni',
        'ie',
        'condicion',
        'nivel',
        'distrito',
    ];

    public static function searchDNI($dni)
    {
        $connection = DB::connection('utilities');
        $maestro = $connection->table('maestro_apto_lap as m')
            ->leftJoin('maestros_laptops as ml', 'm.id', '=', 'ml.maestro_id')
            ->leftJoin('laptops_data as lap', 'ml.laptop_id', '=', 'lap.id')
            ->where('m.dni', $dni)
            ->select('m.id as id', 'm.dni as dni', 'm.full_name', 'm.provincia', 'm.ie', 'm.is_laptop_received', 'm.condicion', 'm.nivel', 'lap.serie')
            ->first();
        
        if(!$maestro){
            throw new Exception('No se encontro el número de DNI');
        }
        return $maestro;
    }

    public static function searchByName($name) 
    {

        $connection = DB::connection('utilities');
        $maestroData = $connection->table('maestro_apto_lap as m')
            ->leftJoin('maestros_laptops as ml', 'm.id', '=', 'ml.maestro_id')
            ->leftJoin('laptops_data as lap', 'ml.laptop_id', '=', 'lap.id')
            ->where('m.full_name', 'like',  "%$name%")
            ->select('m.id as id', 'm.dni as dni', 'm.full_name', 'm.provincia', 'm.ie', 'm.is_laptop_received', 'm.condicion', 'm.nivel', 'lap.serie')
            ->get();
        
        if ($maestroData->count() === 0) {
            throw new Exception('No se encontró ninguna coincidencia');
        }
        
        $maestrosArray = [];
        
        // Si solo hay un resultado, no será una colección
        if ($maestroData->count() === 1) {
            $m = $maestroData->first();
            $maestrosArray[] = [
                'id' => $m->id,
                'dni' => $m->dni,
                'full_name' => $m->full_name,
                'provincia' => $m->provincia,
                'ie' => $m->ie,
                'recibio_laptop' => ($m->is_laptop_received == 1) ? 'Sí' : 'No',
                'c' => $m->condicion,
                'nivel' => $m->nivel,
                'serieLap' => $m->serie
            ];
        } else {
            foreach ($maestroData as $m) {
                $maestrosArray[] = [
                    'id' => $m->id,
                    'dni' => $m->dni,
                    'full_name' => $m->full_name,
                    'provincia' => $m->provincia,
                    'ie' => $m->ie,
                    'recibio_laptop' => ($m->is_laptop_received == 1) ? 'Sí' : 'No',
                    'Condicion' => $m->condicion,
                    'nivel' => $m->nivel,
                    'serieLap' => $m->serie
                ];
            }
        }
        
        return $maestrosArray;
    
    }
}
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
        
        $maestro = MaestrosAptoModel::where('dni', $dni)
        ->join('maestros_laptops', 'maestro_apto_lap.id', '=', 'maestros_laptops.maestro_id')
        ->join('laptops_data', 'maestros_laptops.laptop_id', '=')
        ->get();
        if(!$maestro){
            throw new Exception('No se encontro el número de DNI');
        }
        return $maestro;
    }

    public static function searchByName($name) 
    {
        $maestroData = MaestrosAptoModel::where('full_name', 'like', "%$name%")
                ->select('id', 'dni', 'full_name', 'provincia', 'ie', 'is_laptop_received', 'condicion', 'nivel')
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
                'Condicion' => $m->condicion,
                'nivel' => $m->nivel
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
                    'nivel' => $m->nivel
                ];
            }
        }
        
        return $maestrosArray;
    
    }
}
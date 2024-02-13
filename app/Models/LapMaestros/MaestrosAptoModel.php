<?php

namespace App\Models\LapMaestros;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        $maestro = MaestrosAptoModel::where('dni', $dni)->first();
        if(!$dni){
            throw new Exception('No se encontro el número de DNI');
        }
        return $maestro;
    }

    public static function searchByName($name) 
    {
        $maestroData = MaestrosAptoModel::where('full_name', 'like', "%$name%")
                    ->select('id', 'full_name', 'provincia', 'ie', 'is_laptop_received', 'condicion', 'nivel')
                    ->get();
        if(!$maestroData){
            throw new Exception('No se encontro ninguna coincidencia');
        }
        foreach ($maestroData as $m) {
            $maestrosArray[] = [
                'id' => $m->id,
                'full_name' => $m->full_name,
                'provincia' => $m->provincia,
                'ie' => $m->ie,
                'Recibio Laptop' => ($m->is_laptop_received == 1) ? 'Sí' : 'No',
                'Condicion' => $m->condicion,
                'nivel' => $m->nivel
            ];
        }
        return $maestrosArray;
    }
}
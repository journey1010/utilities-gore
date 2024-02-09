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
        'status',
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
        $maestro = MaestrosAptoModel::where('full_name','like', "%$name%")->first();
        if($maestro){
            throw new Exception('No se encontro ninguna coincidencia');
        }

        return $maestro;
    }
}

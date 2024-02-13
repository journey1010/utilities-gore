<?php

namespace App\Models\LapMaestros;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LapMaestro extends Model
{
    use HasFactory;
    
    public $table = 'maestros_laptops';
    protected $connection = 'utilities';

    protected $fillable  = [
        'maestro_id',
        'laptop_id',
    ];

    public static function saveLapMaestro(int $idMaestro, string $idSerie)
    {
        try {
            DB::beginTransaction();
            
            $connection  = DB::connection('utilities');
            $connection->table('maestros_laptops')->insert([
                'maestro_id' => $idMaestro,
                'laptop_id' => $idSerie
            ]);
        
            $connectionMaestro = DB::connection('utilities');
            $connectionMaestro->table('maestro_apto_lap')->where('id', $idMaestro)->update([
                'is_laptop_received' => 1
            ]);
        
            $connectionLap = DB::connection('utilities');
            $connectionLap->table('laptops_data')->where('id', $idSerie)->update([
                'isFree' => 0
            ]);
        
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }           
    }
}
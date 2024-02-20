<?php

namespace App\Models\LapMaestros;

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

    public static function laptopsEntregadasProvincia()
    {
        $connectLaps = DB::connection('utilities');
        $laps = $connectLaps->select('call laptopEntregadas()');
        return $laps;
    }


    public static function laptopsEntregadasList(int $page, int $itemsPerPage, string $provincia)
    {
        $connection = DB::connection('utilities');
        $reportData = $connection->table('maestro_apto_lap as m')
        ->select(
            'm.provincia as Provincia',
            'm.full_name as FullName',
            'lap.serie as SerieLap' 
        )
        ->join('maestros_laptops as ml', 'm.id', '=', 'ml.maestro_id')
        ->join('laptops_data as lap', 'm.id', '=', 'ml.laptop_id')
        ->where('lap.isFree', '=', 0)
        ->where('m.provincia', '=' ,$provincia)
        ->paginate($itemsPerPage, ['*'], 'page', $page);


        $response = [
            'data' => $reportData->items(),
            'current_page' => $reportData->currentPage(),
            'total_pages' => $reportData->total(),
            'per_pages' => $reportData->perPage(),
            'last_page' => $reportData->lastPage()
        ];
        return $response;
    }
}
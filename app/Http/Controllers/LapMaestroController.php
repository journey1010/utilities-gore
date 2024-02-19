<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use App\Http\Requests\LapMaestros\LapMaestroRequest;
use App\Http\Requests\LapMaestros\SearchByNameRequest;
use App\Http\Requests\LapMaestros\StoreRequest;

use App\Models\LapMaestros\MaestrosAptoModel as Maestro;
use App\Models\LapMaestros\LapSerieModel as Lap;
use App\Models\LapMaestros\LapMaestro;
use Exception;

class LapMaestroController extends Controller
{
    
    public function searchDni(LapMaestroRequest $request)
    {
        try {
            $maestro  = Maestro::searchDNI($request->dni);
            return response()->json([
                'status' => 'success',
                'data' => [
                    'id' => $maestro->id,
                    'dni' => $maestro->dni,
                    'full_name' => $maestro->full_name,
                    'provincia' => $maestro->provincia,
                    'ie' => $maestro->ie,
                    'recibio_laptop' => ($maestro->is_laptop_received == 1) ? 'Sí' : 'No',
                    'Condicion' => $maestro->condicion,
                    'nivel' => $maestro->nivel
                ]
            ], 200);
        } catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function searchByName(SearchByNameRequest $request)
    {
        try {
            $maestro = Maestro::searchByName($request->fullName);
            return response()->json([
                'status' => 'success',
                'data' => $maestro,
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function storeLapMaestro(StoreRequest $request)
    {
        try {
            $serie =  Lap::where('serie', '=', $request->serieLap)
                    ->where('isFree', '=', 1)        
                    ->first();
            $isSave = LapMaestro::saveLapMaestro($request->idMaestro, $serie->id);
            if(!$isSave){
                throw new Exception('No se pudo guardar el registro. Vuelva a intentar');
            }    
            return response()->json([
                'status' => 'success', 
                'message' => 'Registro ingresado con exito'
            ]);
        }catch (\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
             ], 500);
        }
    }
}
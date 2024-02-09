<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LapMaestros\LapMaestroRequest;
use App\Models\LapMaestros\MaestrosAptoModel as Maestro;

class LapMaestroController extends Controller
{
    
    public function searhDni(LapMaestroRequest $request)
    {
        try {
            $maestro  = Maestro::searchDNI($request->dni);
            return response()->json([
                'status' => 'success',
                'data' => [
                    'id' => $maestro->id,
                    'full_name' => $maestro->full_name,
                    'provincia' => $maestro->provincia,
                    'ie' => $maestro->ie,
                    'Recibio Laptop' => ($maestro->is_laptop_received == 1) ? 'Sí' : 'No',
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

    public function searhByName()
    {
        
    }
}

<?php

namespace App\Http\Controllers;


use App\Http\Requests\LapMaestros\LapMaestroRequest;
use App\Http\Requests\LapMaestros\SearchByNameRequest;
use App\Http\Requests\LapMaestros\StoreRequest;
use App\Http\Requests\LapMaestros\ListLaptopEntregado;
use App\Http\Requests\LapMaestros\lisMaestrosLaptopsRequest as ListMaestro;

use App\Models\LapMaestros\MaestrosAptoModel as Maestro;
use App\Models\LapMaestros\LapSerieModel as Lap;
use App\Models\LapMaestros\LapMaestro;
use Exception;

use App\Services\LapMaestros\ReporteExcelMaestros AS SpreedSheet;
use App\Services\LapMaestros\ReporteTotal as SpreedSheetTotal;


class LapMaestroController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except'=> ['searchDni', 'searchByName', 'laptopsEntregadas', 'laptopsEntregadasList', 'totalListMaestro', 'totalLaptopsProvincia']]);
    }
    
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
                    'nivel' => $maestro->nivel,
                    'serieLap' => $maestro->serie
                ]
            ], 200);
        } catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 404);
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
            ], 404);
        }
    }

    public function storeLapMaestro(StoreRequest $request)
    {
        try {
            $serie =  Lap::where('serie', '=', $request->serieLap)
                    ->where('isFree', '=', 1)        
                    ->first();
            $isSave = LapMaestro::saveLapMaestro($request->idMaestro, $serie->id, $request->userId);
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

    public function laptopsEntregadas()
    {
        try {
            $data  = LapMaestro::laptopsEntregadasProvincia();
            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);
        } catch (\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => 'No se pudo obtener el reporte'
            ], 404);
        }
    }

    public function laptopsEntregadasList (ListLaptopEntregado $request)
    {
        try {
            $list = LapMaestro::laptopsEntregadasList($request->page, $request->itemsPerPage, $request->provincia);
            return response()->json([
                'status' => 'success',
                'data' => $list['data'],
                'total_items' => $list['total_items'],
            ], 200);
        } catch (\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => 'No se pudo obtener lista'
            ], 500);
        }
    }

    /**
     * Genera un reporte de cada maestro y la laptop que recibió
     * @param ListMaestro $request (Provincia)
     * @return string link del archivo excel
     */
    public function totalListMaestro(ListMaestro $request)
    {   
        try {
            $provincia = !$request->provincia ? '' : $request->provincia;
            $list = LapMaestro::listMaestroLaptops($provincia);
            $makeReport = new SpreedSheet();
            $path = $makeReport->generateReporte($list);
            return response()->json([
                'status' => 'success',
                'path' => $path
            ], 200);
        } catch (Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Genera un reporte del total de laptops entregadas por provincia y el total restante
     * De laptops por entregar
     * @return url 
    */

    public function totalLaptopsProvincia()
    {
        try{
            $list = LapMaestro::laptopsEntregadasProvincia();
            $makeReport = new SpreedSheetTotal();
            $path = $makeReport->generateReporte($list);
            return response()->json([
                'status' => 'success',
                'path' => $path
            ]);
        } catch(Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgentePresupuesto\Store;
use App\Http\Requests\AgentePresupuesto\Lists;
use Illuminate\Http\JsonResponse;
use App\Models\AgenteParticipantePresupuesto AS AgenteModel;

class AgenteParticipantePresupuesto extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Lists $request): JsonResponse
    {
        try {   
            $lista  = AgenteModel::list($request->itemsPerPage, $request->page);
            return response()->json([
                'status' => 'success',
                'data' => $lista['items'],
                'total' => $lista['total_items']
            ], 200);
        } catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => 'Error al devolver lista'
            ], 500);
        }
    }

    public function store(Store $request): JsonResponse
    {
        try {

           $path = $this->saveFile($request->file('credencial'), $request->dni);

            AgenteModel::saveAgente(
                $request->fullName,
                $request->dni,
                $request->fechaNacimiento,
                $request->genero,
                $request->organizacion,
                $request->organizacionTipo,
                $request->email,
                $request->profesion,
                $request->cargo,
                $request->comiteVigilancia,
                $request->equipoTecnico,
                $request->gradoInstruccion,
                $path
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Registro Exitoso'
            ], 200);

        } catch (\Throwable $e){
            return response()->json([
                'status' => 'error',
                'message' => 'Erro al guardar'
            ], 500);
        };
    }

    public function saveFile($file, $dni): string
    {   
        $uniqueName = $dni . date('-HmYdis');
        $extension = $file->getClientOriginalExtension();
        $path = $file->storeAs(
            'ljkkjg/' . date('Y/m'),
            $uniqueName . '.' . $extension,
            'public'
        );
    
        return $path;
    }
}
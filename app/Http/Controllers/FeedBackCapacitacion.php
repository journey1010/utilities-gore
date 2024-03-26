<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedBackCapacitacion AS FBC;
use App\Models\FeedbackCapacitacion AS FBCModel;
use Illuminate\Http\JsonResponse;

class FeedBackCapacitacion extends Controller
{
    public function index()
    {
        return view('feedback-capacitacion');
    }

    public function store(FBC $request): JsonResponse
    {
        try {
            FBCModel::create([
                'grado_satisfacción' => $request->gradoSatisfaccion,
                'curso_maxima_atencion' => $request->cursoMaximaAtencion,
                'curso_gustaria_aprender' => $request->cursoGustariaAprender,
                'opinion_mejora_capacitacion' => $request->opinionMejoraCapacitacion,
                'horario_capacitacion' => $request->horarioCapacitacion
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Gracias por participar de esta encuesta'
            ], 200);
        } catch(\Exception $e){
            return response()->json([
                'status' => 'success',
                'message' => 'Ocurrio un problema :('
            ], 500);
        }
    }
}
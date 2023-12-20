<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Feedback;
use App\Models\FeedBackModel;
use Carbon\Carbon;

class FeedbackController extends Controller
{
    public function storeFeedback (Feedback $request)
    {   
        try {
            $data = $request->all();
            $data['date'] = Carbon::now()->format('Y-m-d');
            FeedBackModel::create($data);
            return response()->json(['status' => 'success', 'message'=> 'Se ha registrado su información.'], 201);
        } catch(\Exception $e){
            return response()->json(['status' =>'error', 'message' => 'En este momento no podemos atender su solicitud.'], 500);
        }
    }

    public function listFeedbacks(Request $request)
    {
        try  {
            $feedbacks = FeedBackModel::query()
                    ->where('status', 1)
                    ->orderBy('date', 'desc');        

            $paginatedFeedbacks = $feedbacks->paginate();
        } catch(\Exception $e){
            return response()->json(['status' => 'error', 'message' => 'Ocurrio un error al procesar su solicitud']);
        }

        return response()->json([
            "satus" => "success",
            'draw' => intval($request->draw),
            'recordsTotal' => $paginatedFeedbacks->total(),
            'recordsFiltered' => $paginatedFeedbacks->total(),
            'data' => $paginatedFeedbacks->items(),
        ], 200);
    }   
}

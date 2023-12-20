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
            // return response()->json(['status' =>'error', 'message' => 'En este momento no podemos atender su solicitud.'], 500);
            return response()->json(['status' =>'error', 'message' => $e->getMessage()], 500);
        }
    }
}

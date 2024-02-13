<?php

namespace App\Http\Requests\LapMaestros;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Exceptions\HttpResponseException;

use App\Rules\LapMaestros\UniqueMaestroLaptopReceived as MaestroStatus;
use App\Rules\LapMaestros\UniqueSerieLapReceived AS LapStatus; 

class StoreRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;


    protected function failedValidation(Validator $validator)
    {
        $jsonResponse = new JsonResponse([
            'status' => 'error',
            'message' =>  messageValidation($validator)
        ], 422);
        throw new HttpResponseException($jsonResponse);
    }
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'idMaestro' => ['required', 'numeric', new MaestroStatus],
            'serieLap' => ['required', 'string', new LapStatus],
        ];
    }

    public function message()
    {  
        return [
            'idMaestro.required' => 'ID de maestro no proporcionado',
            'idMaestro.numeric' => 'ID de maestro debe ser númerico',
            'serieLap.required' => 'Debe proporcionar un número de serie',
            'serieLap.string' => 'El número de serie debe ser alfanumérico'
        ];
    }
}
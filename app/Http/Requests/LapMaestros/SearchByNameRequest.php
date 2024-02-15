<?php

namespace App\Http\Requests\LapMaestros;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SearchByNameRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        $jsonRespone = new JsonResponse([
            'status' => 'error',
            'message' => messageValidation($validator)
        ], 422);
        
        throw new HttpResponseException($jsonRespone);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fullName' => 'required|string'
        ];
    }

    public function messages()
    {   
        return [
            'fullName.required' => 'Ingrese un nombre',
            'fullName.string' => 'El nombre a buscar tiene que ser de tipo texto'
        ];
    }
}

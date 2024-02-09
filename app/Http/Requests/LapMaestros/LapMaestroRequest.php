<?php

namespace App\Http\Requests\LapMaestros;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class LapMaestroRequest extends FormRequest
{

    protected $stopOnFirstFailured = true;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        $jsonResponse = new JsonResponse([
            'status' => 'error',
            'message' => messageValidation($validator)
        ], 422);

        throw new HttpResponseException($jsonResponse);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'dni' => 'required|string|max:8'
        ];
    }

    public function messages()
    {
        return [
            'dni.required' => 'Ingrese el número de dni',
            'dni.string' => 'Debe ser de tipo númerico',
            'dni.max' => 'El número de dni ha excedido los 8 digitos'
        ];
    }
}

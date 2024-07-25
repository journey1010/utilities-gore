<?php

namespace App\Http\Requests\AgentePresupuesto;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class StoreCaballococha extends FormRequest
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
            'fullName' => 'required|string',
            'dni' => 'required|string',
            'organizacion' => 'required|string',
            'cargo' => 'required|string',
            'credencial' => 'required|file|mimes:jpg,jpeg,png,gif,webp',
            'isDiscapacitado' => 'required|in:1,0',
            'idForm' => 'required|string|max:255|in:caballococha'
        ];
    }

    public function messages(): array
    {
        return [
            'idForm.required' => 'ID de formulario es requerido',
            'idForm.in' => 'ID de este formulario es: caballococha',
            'isDiscapacitado.required' => 'isDiscapacito es requerido',
            'isDiscapacitado.in' => 'isDiscapacitado solo puede ser 1 ó 0'
        ];
    }
}
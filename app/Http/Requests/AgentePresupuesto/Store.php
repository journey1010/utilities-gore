<?php

namespace App\Http\Requests\AgentePresupuesto;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;

class Store extends FormRequest
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
        $jsonResponse  = new JsonResponse([
            'status' => 'error',
            'message' => messageValidation($validator),
        ]);

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
            'fechaNacimiento' => 'date',
            'genero' => 'required|string|in:M,F',
            'organizacion' => 'required|string',
            'organizacionTipo' => 'required|string',
            'email' => 'string',
            'profesion' => 'string',
            'cargo' => 'required|string',
            'comiteVigilancia' => 'required|string',
            'equipoTecnico' => 'required|string',
            'gradoInstruccion' => 'string',
            'credencial' => 'required|file|mimes:jpg,jpeg,png,gif,webp',
        ];
    }
}
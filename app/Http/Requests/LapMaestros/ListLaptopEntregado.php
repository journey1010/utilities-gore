<?php

namespace App\Http\Requests\LapMaestros;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ListLaptopEntregado extends FormRequest
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
            'itemsPerPage' => 'required|numeric',
            'page' => 'required|numeric'
        ];
    }
}

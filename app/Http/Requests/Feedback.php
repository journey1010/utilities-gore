<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class Feedback extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->getMessages();

        $firstErrors = [];
        foreach ($errors as $field => $messages) {
            $firstErrors[$field] = $messages[0];
        }
    
        $jsonResponse = new JsonResponse([
            'status' => 'error',
            'message' => $firstErrors
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
            'user_name' => 'required|string|max:255',
            'email' => 'nullable|max:40',
            'phone' => 'nullable|numeric|min:8',
            'codeCountry' => 'nullable|numeric|min:2|max:4',
            'experience' => 'required|string|min:4|max:8',
            'com_design' => 'nullable|string|max:700',
            'com_content' => 'required|string|max:700',
            'com_funtionallity' => 'nullable|string|max:700',
            'com_ease_use' => 'required|string|max:700',
            'com_suggest' => 'nullable|string|max:500'
        ]; 
    }


    public function messages()
    {
        return [
            'user_name.required' => 'Su nombre es importante.',
            'user_name.max' => 'Su nombre no debe superar los 400 caracteristicas.', 
            'user_name.string' => 'El nombre debe ser del tipo texto.',
            'phone.numeric' => 'Su número de telefono debe ser númerico.',
            'phone.min' => 'Ingrese un número valido.',
            'email.email' => 'El formato del email es incorrecto.', 
            'email.max' => 'El email no debe superar los 400 caracteres.',
            'codeCountry.numeric' => 'El código del país debe ser númerico.',
            'codeCountry.min' => 'El código del país debe tener al menos 2 caracteres.',
            'codeCountry.max' => 'El código del país no debe superar los 4 caracteres.',
            'com_design.max' => 'Su comentario sobre el diseño no debe superar los 700 caracteres.',
            'com_content.required' => 'Debe ingresar su comentario sobre el contenido.',
            'com_funtionallity.max' => 'Su comentario sobre la funcionalidad no debe superar los 700 caracteres.',
            'com_ease_use.required' => 'Debe ingresar su comentario sobre la facilidad de uso.',
            'com_suggest.max' => 'Su sugerencia no debe superar los 500 caracteres.',
        ];
    }
}

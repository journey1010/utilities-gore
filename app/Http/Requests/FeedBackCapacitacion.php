<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;

class FeedBackCapacitacion extends FormRequest
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
            'g-recaptcha-response' => 'required|captcha',
            'gradoSatisfaccion' => 'required|string',
            'cursoMaximaAtencion' => 'required|string',
            'cursoGustariaAprender' => 'required|string',
            'opinionMejoraCapacitacion' => 'required|string',
            'horarioCapacitacion' => 'required|string'
        ];
    }

    public function messages(): array
    {
        return [
            'g-recaptcha-response.required' => 'Token recaptcha es requerido',
            'g-recaptcha-response.required' => 'Token recaptcha no es valido',
            'gradoSatisfaccion.required' => 'Debe Seleccionar el grado de satisfacción',
            'cursoMaximaAtencion.required' => 'Debe Indicar el curso que fue de su máxima atención',
            'cursoGustariaAprender.required' => 'Debe Indicar el curso que le gustaría aprender',
            'opinionMejoraCapacitacion' => 'Debe indicar ¿En qué desea que mejore o se implemente las capacitaciones de TI?',
            'horarioCapacitacion.required' => 'Debe indicar un horario'
        ];
    }
}
<?php

namespace App\Rules\LapMaestros;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\LapMaestros\LapSerieModel as Lap;

class UniqueSerieLapReceived implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $serie = Lap::where('serie', '=', $value)->first();
        if(!$serie){
            $fail('Ha ingresado un número de serie que no se encuentra registrado en nuestro almacén');
            return;
        }
        if($serie->isFree == 0){
            $fail('Esta Laptop ya ha sido entregada');
            return;
        }
    }
}

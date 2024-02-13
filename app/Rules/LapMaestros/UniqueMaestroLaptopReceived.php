<?php

namespace App\Rules\LapMaestros;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\LapMaestros\MaestrosAptoModel as Maestro;

class UniqueMaestroLaptopReceived implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $maestro  = Maestro::where('id', $value)
                    ->first();

        if(!$maestro){
            $fail('Este maestro no se encuentra en los registros');
            return;
        }
        if($maestro->is_laptop_received ==  1){
            $fail('Este Maestro recibio una laptop');
        }
    }
}

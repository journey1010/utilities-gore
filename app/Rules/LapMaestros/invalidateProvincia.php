<?php

namespace App\Rules\LapMaestros;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class invalidateProvincia implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $connec = DB::connection('utilities');
        $provincia = $connec->table('maestro_apto_lap')
            ->where('provincia','like', '%RAMON CASTILLA%')
            ->first();
        if($provincia) {
            $fail('Provincia cerrada');
        }
    }
}

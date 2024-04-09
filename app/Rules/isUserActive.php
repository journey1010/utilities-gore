<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class isUserActive implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $user =  DB::table('users')
                ->where('email', $value)
                ->first();
        if(!$user){
            $fail('Este correo no existe'); 
            return;
        }
        if($user->status != 1){
            $fail('Su cuenta ha sido inhabilitada de manera temporal');
        }
    }
}
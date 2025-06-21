<?php

namespace App\Validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UfValidator
{
    public static function validate(string $uf): void
    {
        $validator = Validator::make(
            ['uf' => $uf],
            ['uf' => ['required', 'regex:/^[a-zA-Z]{2}$/']],
            ['uf.regex' => 'UF must contain exactly two letters.']
        );

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}

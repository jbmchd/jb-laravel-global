<?php


namespace JbGlobal\Validators;

use JbGlobal\Rules\PrimaryKeyRule;

class PrimaryKeyValidation
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        return (new PrimaryKeyRule())->passes($attribute, $value);
    }
}

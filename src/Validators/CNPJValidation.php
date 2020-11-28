<?php


namespace JbGlobal\Validators;

use JbGlobal\Rules\CNPJRule;

class CNPJValidation
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        return (new CNPJRule())->passes($attribute, $value);
    }
}

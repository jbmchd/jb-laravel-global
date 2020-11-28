<?php


namespace JbGlobal\Validators;

use JbGlobal\Rules\CPFRule;

class CPFValidation
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        return (new CPFRule())->passes($attribute, $value);
    }
}

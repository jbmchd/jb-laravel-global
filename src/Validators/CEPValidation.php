<?php


namespace JbGlobal\Validators;

use JbGlobal\Rules\CEPRule;

class CEPValidation
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        return (new CEPRule())->passes($attribute, $value);
    }
}

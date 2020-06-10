<?php


namespace JbGlobal\Validators;

use JbGlobal\Rules\ForeignKeyRule;

class ForeignKeyValidation
{
    public function validate($attribute, $value, array $parameters, $validator)
    {
        return (new ForeignKeyRule($parameters))->passes($attribute, $value);
    }
}

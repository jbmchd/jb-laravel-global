<?php


namespace JbGlobal\Validators;

class CEPValidation
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        return $this->isValidate($attribute, $value);
    }

    protected function isValidate($attribute, $value)
    {
        return mb_strlen($value) === 8 && preg_match('/^(\d){8}$/', $value);
    }
}

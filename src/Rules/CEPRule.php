<?php

namespace JbGlobal\Rules;

use Illuminate\Contracts\Validation\Rule;

class CEPRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return mb_strlen($value) === 8 && preg_match('/^(\d){8}$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        //
    }
}

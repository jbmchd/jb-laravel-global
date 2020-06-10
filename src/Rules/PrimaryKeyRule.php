<?php

namespace JbGlobal\Rules;

use Illuminate\Contracts\Validation\ImplicitRule;

class PrimaryKeyRule implements ImplicitRule
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
        return !!$value && (float) $value >= 1;
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

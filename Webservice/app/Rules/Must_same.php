<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Must_same implements Rule
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
        return (strtolower($value) == "bus" || strtolower($value) == "train");
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Data must be bus or train';
    }
}

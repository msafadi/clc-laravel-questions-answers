<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Filter implements Rule
{
    protected $invalid;

    protected $black;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($words)
    {
        $this->black = $words;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        foreach ($this->black as $word) {
            if (stripos($value, $word) !== false) {
                $this->invalid = $word;
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Word "' . $this->invalid . '" not allowed';
    }
}

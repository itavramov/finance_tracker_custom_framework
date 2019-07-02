<?php
namespace Support\Validator\Rules;

use Support\Validator\Rule;

class Integer extends Rule
{
    protected $message = "The :attribute must be a integer!";

    public function check($value)
    {
        return (bool) filter_var($value, FILTER_VALIDATE_INT);
    }
}
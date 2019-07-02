<?php
namespace Support\Validator\Rules;

use Support\Validator\Rule;

class Numeric extends Rule
{
    protected $message = "The :value is not numeric!";

    public function check($value)
    {
        return is_numeric($value);
    }
}

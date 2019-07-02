<?php
namespace Support\Validator\Rules;

use Support\Validator\Rule;

class Email extends Rule
{
    protected $message = "The :value is not valid email";

    public function check($value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }
}

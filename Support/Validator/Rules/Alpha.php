<?php
namespace Support\Validator\Rules;

use Support\Validator\Rule;

class Alpha extends Rule
{
    protected $message = "The :attribute must contain only alphabet characters!";

    public function check($value)
    {
        return (bool)ctype_alpha($value);
    }
}

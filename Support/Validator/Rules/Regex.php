<?php
namespace Support\Validator\Rules;

use Support\Validator\Rule;

class Regex extends Rule
{
    protected $message = "The :value is not valid format";
    protected $fillParams = ['regex'];

    public function check($value)
    {
        $regex = $this->paramsPrepare('regex');

        return (bool) preg_match($regex, $value);
    }
}

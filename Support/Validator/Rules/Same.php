<?php
namespace Support\Validator\Rules;

use Router;
use Support\Validator\Rule;

class Same extends Rule
{
    protected $message = "The :attribute is not like :same";
    protected $fillParams = ['same'];

    public function check($value)
    {
        $anotherValue = $this->attribute-> getValidation()->getValue($this->paramsPrepare('same'));

        return $value === $anotherValue;
    }
}

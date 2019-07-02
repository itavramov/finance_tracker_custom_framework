<?php
namespace Support\Validator\Rules;

use Support\Validator\Rule;
use Support\Validator\Rules\Traits\SizeTrait;

class МinStrLen extends Rule
{
    use Traits\SizeTrait;

    protected $message = "The :attribute minimum len :min";
    protected $fillParams = ['min'];

    public function check($value)
    {
        $min = $this->getBytesSize($this->paramsPrepare('minStrLen'));
        return strlen($value) >= $min;
    }
}
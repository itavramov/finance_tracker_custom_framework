<?php
namespace Support\Validator\Rules;

use Support\Validator\Rule;

class Min extends Rule
{
    use Traits\SizeTrait;

    protected $message = "The :attribute minimum is :min";
    protected $fillParams = ['min'];

    public function check($value)
    {
        $min = $this->getBytesSize($this->paramsPrepare('min'));
        return intval($value) >= $min;
    }
}

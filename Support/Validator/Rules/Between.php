<?php
namespace Support\Validator\Rules;

use Support\Validator\Rule;

class Between extends Rule
{
    use Traits\SizeTrait;

    protected $message = "The :attribute must be between :min and :max!";
    protected $fillParams = [
        'min',
        'max'
    ];

    public function check($value)
    {
        $min = $this->paramsPrepare($this->parameter('min'));
        $max = $this->paramsPrepare($this->parameter('max'));
        $valueSize = $this->getValueSize($value);
        if (!is_numeric($valueSize)) {
            return false;
        }
        return ($valueSize >= $min && $valueSize <= $max);
    }
}

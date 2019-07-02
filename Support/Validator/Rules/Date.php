<?php
namespace Support\Validator\Rules;

use Support\Validator\Rule;
use util\Constants;

class Date extends Rule
{
    protected $message = "The :attribute is not valid date format";
    protected $fillParams = ['format'];
    protected $params = [
        'format' => Constants::DATE_FORMAT_PHP
    ];

    public function check($value)
    {
        $format = $this->paramsPrepare('format');
        return (bool) date_create_from_format($format, $value);
    }
}

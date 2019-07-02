<?php
namespace Support\Validator\Rules;

use Router\Request;
use Support\Validator\Rule;

class Get extends Rule
{
    protected $message = "The :attribute is not get param!";
    protected $fillParams = ['get'];

    public function check($value)
    {
        $getArr = Request::getInstance()->getGetParams();
        $key = $this->paramsPrepare('get');

        return array_key_exists($key, $getArr);
    }
}
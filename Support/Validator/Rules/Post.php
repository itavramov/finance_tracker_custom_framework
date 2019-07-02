<?php
namespace Support\Validator\Rules;

use Router\Request;
use Support\Validator\Rule;

class Post extends Rule
{
    protected $message = "The :attribute is not post param!";
    protected $fillParams = ['post'];

    public function check($value)
    {
        $postArr = Request::getInstance()->getPostParams();
        $key = $this->paramsPrepare('post');

        return array_key_exists($key, $postArr);
    }
}
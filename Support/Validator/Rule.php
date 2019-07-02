<?php
namespace Support\Validator;

abstract class Rule
{
    protected $key;
    protected $attribute;
    protected $validation;
    protected $params = [];
    protected $fillParams = [];
    protected $message = "The attribute is invalid!";

    abstract public function check($value);

    protected function paramsPrepare($key)
    {
        return isset($this->params[$key]) ? $this->params[$key] : null;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function setKey($key)
    {
        $this->key = $key;
    }

    public function getAttribute()
    {
        return $this->attribute;
    }

    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;
    }

    public function getValidation()
    {
        return $this->validation;
    }

    public function setValidation($validation)
    {
        $this->validation = $validation;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function setParams($params)
    {
        $this->params = $params;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }
}

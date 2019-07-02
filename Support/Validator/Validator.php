<?php
namespace Support\Validator;

use Router\Request;

class Validator
{
    protected $validators  = [];
    protected $errors = [];
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->registerValidators();
    }

    public function validate() {}

    public function createValidation(array $rules)
    {
        $inputs = array_merge(
            $this->request->getPostParams(),
            $this->request->getGetParams()
        );
        $validation = new Validation(
            $this,
            $inputs,
            $rules
        );

        return $validation;
    }

    public function getValidator($key)
    {
        $validator = isset($this->validators[$key]) ? $this->validators[$key] : null;
        return $validator;
    }

    public function setValidator ($key, Rule $rule)
    {
        $this->validators[$key] = $rule;
        $rule->setKey($key);
    }

    protected function registerValidators()
    {
        $validators = [
            'alpha' => new Rules\Alpha(),
            'between' => new Rules\Between(),
            'date' => new Rules\Date(),
            'email' => new Rules\Email(),
            'fileUpload' => new Rules\FileUpload(),
            'get' => new Rules\Get(),
            'integer' => new Rules\Integer(),
            'min' => new Rules\Min(),
            'minStrLen' => new Rules\МinStrLen(),
            'numeric' => new Rules\Numeric(),
            'post' => new Rules\Post(),
            'regex' => new Rules\Regex(),
            'same' => new Rules\Same(),
            'required' => new Rules\Required()
        ];

        foreach ($validators as $key => $validator) {
            $this->setValidator($key, $validator);
        }
    }

    public function getAllValidators()
    {
        return $this->validators;
    }
}

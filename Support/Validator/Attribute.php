<?php
namespace Support\Validator;

class Attribute
{
    protected $rules = [];
    protected $key;
    protected $alias;
    protected $required = false;
    protected $validation;

    public function __construct(
                    $key,
                    array $rules,
                    Validation $validation
    )
    {
        $this->validation = $validation;
        $this->key = $key;
        foreach ($rules as $rule) {
            $this->addRule($rule);
        }
    }

    public function getValidation()
    {
        return $this->validation;
    }

    public function addRule(Rule $rule)
    {
        $this->rules[$rule->getKey()] = $rule;
    }

    public function getRules()
    {
        return $this->rules;
    }

    public function setRules($rules)
    {
        $this->rules = $rules;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function setKey($key)
    {
        $this->key = $key;
    }

    public function getAlias()
    {
        return $this->alias;
    }

    public function setAlias($alias)
    {
        $this->alias = $alias;
    }

    public function isRequired()
    {
        return $this->required;
    }

    public function setRequired($required)
    {
        $this->required = $required;
    }
}

<?php
namespace Support\Validator;

use Exception\ValidationException;

class Validation
{
    protected $validator;
    protected $inputs = [];
    protected $attributes = [];
    protected $validData = [];
    protected $invalidData = [];
    protected $errors = [];

    public function __construct(
                    Validator $validator,
                    array $inputs,
                    array $rules
    )
    {
        $this->validator = $validator;
        $this->sanitize($inputs);
        foreach ($rules as $key => $rule) {
            $this->addAttribute($key, $rule);
        }
    }

    public function validate()
    {
        $attributes = $this->getAttributes();
        $inputs = $this->getInputs();
        foreach ($inputs as $key => $input) {
            $attribute = $attributes[$key];
            $this->validateAttribute($attribute);
        }
    }

    public function validateAttribute(Attribute $attribute)
    {
        $attributeKey = $attribute->getKey();
        $rules = $attribute->getRules();
        $value = $this->getValue($attributeKey);
        $check = true;

        foreach ($rules as $rule) {
            $rule->setAttribute($attribute);
            $check = $rule->check($value);
            if (!$check) {
                break;
            }
        }

        if ($check) {
            $this->setValidData($attribute, $value);
        } else {
            $this->setInvalidData($attribute, $value);
        }
    }

    public function validationCheck()
    {
        if (empty($this->invalidData)) {
            return true;
        }

        return false;
    }

    public function addAttribute(
                    $key,
                    string $rules

    )
    {
        $resolvedRules = $this->resolveRules($rules);
        $attribute = new Attribute(
                         $key,
                         $resolvedRules,
                         $this
        );
        $this->attributes[$key] = $attribute;
    }

    public function resolveRules($rules)
    {
        $registeredValidators = $this->validator->getAllValidators();
        $resolvedRules = [];
        if (empty($rules)) {
            throw new ValidationException("There are no rules...");
        }
        if (is_string($rules)) {
            $rules = explode("@", $rules);
        }
        foreach ($rules as $rule) {
            if (strpos($rule, ':')){
                $arr = $this->resolveRulesParams($rule);
                $resolvedRules[] = $registeredValidators[$arr['rule']];
                $params[$arr['rule']] = $arr['param'];
                $registeredValidators[$arr['rule']]->setParams($params);
            } else {
                $resolvedRules[] = $registeredValidators[$rule];
            }
        }

        return $resolvedRules;
    }

    public function resolveRulesParams($rule)
    {
        $arr = explode(":", $rule);
        $rule = $arr[0];
        $ruleParam = $arr[1];
        $result = [
            'rule' => $rule,
            'param' => $ruleParam
        ];

        return $result;
    }

    public function sanitize(array $inputs)
    {
//        if (empty($inputs)) {
//            throw new ValidationException("No elements for sanitize...");
//        }
        foreach ($inputs as &$input) {
            $input = htmlentities(trim($input));
        }
        $this->setInputs($inputs);
    }

    public function getValue($key)
    {
        $inputs = $this->getInputs();
        if (!array_key_exists($key, $inputs)) {
            throw new ValidationException("There is no such attribute...");
        }

        return $inputs[$key];
    }

    public function setValidData(Attribute $attribute, $value)
    {
        $key = $attribute->getKey();
        $attributes = $this->getAttributes();
        if (!in_array($attribute, $attributes)) {
            throw new ValidationException("The attribute doesn't exists...");
        }
        $this->validData[$key] = $value;
    }

    public function setInvalidData(Attribute $attribute, $value)
    {
        $key = $attribute->getKey();
        $attributes = $this->getAttributes();
        if (!in_array($attribute, $attributes)) {
            throw new ValidationException("The attribute doens't exists...");
        }
        $this->invalidData[$key] = $value;
    }

    public function getValidData()
    {
        return $this->validData;
    }

    public function getInvalidData()
    {
        return $this->invalidData;
    }

    public function getValidator()
    {
        return $this->validator;
    }

    public function setValidator($validator)
    {
        $this->validator = $validator;
    }

    public function getInputs()
    {
        return $this->inputs;
    }

    public function setInputs($inputs)
    {
        $this->inputs = $inputs;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

    public function getAliases()
    {
        return $this->aliases;
    }

    public function setAliases($aliases)
    {
        $this->aliases = $aliases;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function setErrors($errors)
    {
        $this->errors = $errors;
    }
}

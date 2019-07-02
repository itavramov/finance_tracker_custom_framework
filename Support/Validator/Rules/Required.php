<?php
namespace Support\Validator\Rules;

use Support\Validator\Rule;

class Required extends Rule
{
    protected $message = "The :attribute is required!";

    public function check($value)
    {
        $this->makeAttributeRequired();

        if (is_string($value)) {
            return (bool) mb_strlen(trim($value), 'UTF-8');
        }
        if (is_array($value)) {
            return (bool) count($value);
        }
        return !is_null($value);
    }

    protected function makeAttributeRequired()
    {
        if (!$this->getAttribute()) {
            $this->setAttribute(true);
        }
   }
}

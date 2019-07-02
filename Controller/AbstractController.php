<?php
namespace Controller;

use http\Response;
use Router\Request;
use Router\Url;
use Support\Validator\Validator;

abstract class AbstractController
{
    protected $responseCode;
    protected $isAjax = false;

    public function before()
    {
    }

    public function after()
    {
    }

    public function response($statusCode, $responseData) {}

    public function doValidate(array $validationRules)
    {
        $request = Request::getInstance();
        $validator = new Validator($request);
        $validation = $validator->createValidation($validationRules);
        $validation->validate();
        $result['isValid'] = $validation->validationCheck();
        $result['validatedData'] = $validation->getValidData();

        return $result;
    }

    public function getResponseCode()
    {
        return $this->responseCode;
    }

    public function setResponseCode($responseCode)
    {
        $this->responseCode = $responseCode;
    }

    public function isAjax()
    {
        return $this->isAjax;
    }
}

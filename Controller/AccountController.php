<?php
namespace Controller;

use Exception\ServiceException;
use http\Response;
use Interfaces\Editable;

use Service\AccountService;

class AccountController extends AbstractAjaxController implements Editable
{
    public function regAccount()
    {
        $validationRules = [
            'acc_name' => 'post:acc_name@required@alpha',
            'acc_type' => 'post:acc_type@required',
            'balance' => 'post:balance@required@min:1@numeric',
            'acc_currency' => 'post:acc_currency@required'
        ];
        $validation = $this->doValidate($validationRules);
        if ($validation['isValid']) {
            $validData = $validation['validatedData'];
            $accountService = new AccountService();
            $response = $accountService->registerAccount($validData);
            $this->responseCode = $response ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR;
            $arr["response"] = $response;
        } else {
            $this->responseCode = Response::HTTP_NOT_ACCEPTABLE;
            $arr["response"] = false;
        }

        $this->response(
            $this->getResponseCode(),
            $arr
        );
    }

    public function allUserAccounts()
    {
        $accountService = new AccountService();
        $accounts = $accountService->getAllAccounts();
        $this->responseCode = $accountService->getSuccessCheck() ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR;

        $this->response(
            $this->getResponseCode(),
            $accounts
        );
    }

    public function edit()
    {
        $validationRules = [
            'acc_id' => 'post:acc_id@required',
            'acc_name' => 'post:acc_name@required@alpha',
            'acc_type' => 'post:acc_type@required',
            'balance' => 'post:balance@required@min:1@numeric',
            'acc_currency' => 'post:acc_currency@required'
        ];
        $validation = $this->doValidate($validationRules);

        if ($validation['isValid']) {
            $validData = $validation['validatedData'];
            $accountService = new AccountService();
            $response = $accountService->editAccount($validData);
            $this->responseCode = $response ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR;
            $arr['response'] = $response;
        } else {
            $this->responseCode = Response::HTTP_NOT_ACCEPTABLE;
            $arr['response'] = false;
        }

        $this->response(
            $this->getResponseCode(),
            $arr
        );
    }

    public function deleteAccount()
    {
        $validationRules = [
            'acc_id' => 'post:acc_id@required'
        ];
        $validation = $this->doValidate($validationRules);

        if ($validation['isValid']) {
            $validData = $validation['validatedData'];
            $accountService = new AccountService();
            $response = $accountService->deleteAccount($validData['acc_id']);
            $this->responseCode = $response ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR;
        } else{
            $this->responseCode = Response::HTTP_NOT_ACCEPTABLE;
            $response = false;
        }

        $arr['response'] = $response;

        $this->response(
            $this->getResponseCode(),
            $arr
        );
    }

    public function accountInfo()
    {
        $validationRules = [
            'acc_id' => 'post:acc_id@required'
        ];
        $validation = $this->doValidate($validationRules);

        if ($validation['isValid']) {
            $validData = $validation['validatedData'];
            $accountService = new AccountService();
            $response = $accountService->getAccountInfo($validData['acc_id']);
            $this->responseCode = $response ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR;
        } else{
            $this->responseCode = Response::HTTP_NOT_ACCEPTABLE;
            $response = false;
        }

        $this->response(
            $this->getResponseCode(),
            $response
        );
    }
}

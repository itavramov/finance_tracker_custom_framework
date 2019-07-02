<?php
namespace Controller;

use Exception\ServiceException;
use http\Response;
use Service\RecordService;

class RecordController extends AbstractAjaxController
{

    public function recordRegistration()
    {
        $validationRules = [
            'record_name' => 'post:record_name@required',
            'record_desc' => 'post:record_desc@required@minStrLen:5',
            'amount' => 'post:amount@required@min:1@numeric',
            'category_id' => 'post:category_id@required',
            'acc_id' => 'post:acc_id@required'
        ];
        $validation = $this->doValidate($validationRules);
        if ($validation['isValid']) {
            $validData = $validation['validatedData'];
            $recordService = new RecordService();
            $result = $recordService->registerRecord($validData);
            $this->responseCode = $result ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR;
        } else {
            $this->responseCode = Response::HTTP_NOT_ACCEPTABLE;
            $result = false;
        }
        $response['response'] = $result;

        $this->response(
            $this->getResponseCode(),
            $response
        );
    }

    public function listRecords()
    {
        $recordService = new RecordService();
        $result = $recordService->listRecords();
        $this->responseCode = $recordService->getSuccessCheck() ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR;

        $this->response(
           $this->getResponseCode(),
           $result
       );
    }

    public function getSumTotal()
    {
        $validationRules = [
            'acc_id' => 'post:acc_id',
            'start_date' => 'post:start_date@date',
            'end_date' => 'post:end_date@date',
        ];
        $validation = $this->doValidate($validationRules);

        if ($validation['isValid']) {
            $validData = $validation['validatedData'];
            $recordService = new RecordService();
            $result = $recordService->getSumTotal($validData);
            $this->responseCode = $result ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR;
        } else {
            $this->responseCode = Response::HTTP_NOT_ACCEPTABLE;
            $result = false;
        }

        $this->response(
            $this->getResponseCode(),
            $result
        );
    }

    public function chartExpenses()
    {
        $validationRules = [
            'acc_id' => 'post:acc_id',
            'start_date' => 'post:start_date@date',
            'end_date' => 'post:end_date@date',
        ];
        $validation = $this->doValidate($validationRules);
        if ($validation['isValid']) {
            $validData = $validation['validatedData'];
            $recordService = new RecordService();
            $result = $recordService->chartExpenses($validData);
            $this->responseCode = $result ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR;
        } else {
            $this->responseCode = Response::HTTP_NOT_ACCEPTABLE;
            $result = false;
        }

        $this->response(
            $this->getResponseCode(),
            $result
        );
    }

    public function listLastFiveRecords()
    {
        $recordService = new RecordService();
        $result = $recordService->listLastFiveRecords();
        $this->responseCode = $recordService->getSuccessCheck() ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR;

        $this->response(
            $this->getResponseCode(),
            $result
        );
    }

    public function listIncomesAndExpense()
    {
        $validationRules = [
            'acc_id' => 'post:acc_id',
            'start_date' => 'post:start_date@date',
            'end_date' => 'post:end_date@date',
        ];
        $validation = $this->doValidate($validationRules);

        if ($validation['isValid']) {
            $validData = $validation['validatedData'];
            $recordService = new RecordService();
            $result = $recordService->listIncomesAndExpense($validData);
            $this->responseCode = $result ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR;
        } else {
            $this->responseCode = Response::HTTP_NOT_ACCEPTABLE;
            $result = false;
        }

        $this->response(
            $this->getResponseCode(),
            $result
        );
    }

    public function radarDiagramExpenses()
    {
        $validationRules = [
            'acc_id' => 'post:acc_id',
            'start_date' => 'post:start_date@date',
            'end_date' => 'post:end_date@date',
        ];
        $validation = $this->doValidate($validationRules);

        if ($validation['isValid']) {
            $validData = $validation['validatedData'];
            $recordService = new RecordService();
            $result = $recordService->radarDiagramExpenses($validData);
            $this->responseCode = $result ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR;

        } else {
            $this->responseCode = Response::HTTP_NOT_ACCEPTABLE;
            $result = false;
        }

        $this->response(
            $this->getResponseCode(),
            $result
        );
    }

    public function averageIncomeInfo()
    {
        $validationRules = [
            'acc_id' => 'post:acc_id'
        ];
        $validation = $this->doValidate($validationRules);

        if ($validation['isValid']) {
            $validData = $validation['validatedData'];
            $recordService = new RecordService();
            $result = $recordService->averageIncomeInfo($validData);
            $this->responseCode = $result ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR;
        } else {
            $this->responseCode = Response::HTTP_NOT_ACCEPTABLE;
            $result = false;
        }

        $this->response(
            $this->getResponseCode(),
            $result
        );

    }

    public function averageExpenseInfo()
    {
        $validationRules = [
            'acc_id' => 'post:acc_id'
        ];
        $validation = $this->doValidate($validationRules);

        if ($validation['isValid']) {
            $validData = $validation['validatedData'];
            $recordService = new RecordService();
            $result = $recordService->averageExpenseInfo($validData);
            $this->responseCode = $result ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR;
        } else {
            $this->responseCode = Response::HTTP_NOT_ACCEPTABLE;
            $result = false;
        }

        $this->response(
            $this->getResponseCode(),
            $result
        );
    }
}
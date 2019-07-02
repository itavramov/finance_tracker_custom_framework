<?php
namespace Controller;

use http\Response;
use Service\BudgetService;

class BudgetController extends AbstractAjaxController
{
    public function registerBudget()
    {
        $validationRules = [
            'budget_name' => 'post:budget_name@required',
            'budget_desc' => 'post:budget_desc@required@minStrLen:5',
            'budget_amount' => 'post:budget_amount@required@min:10@numeric',
            'category_id' => 'post:category_id@required',
            'from_date' => 'post:from_date@required@date',
            'to_date' => 'post:to_date@required@date'
        ];
        $validation = $this->doValidate($validationRules);

        if ($validation['isValid']) {
            $validData = $validation['validatedData'];
            $budgetService = new BudgetService();
            $response = $budgetService->registerBudget($validData);
            $this->responseCode = $response ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR;
        } else {
            $this->responseCode = Response::HTTP_NOT_ACCEPTABLE;
            $response = false;
        }

        $arr['response'] = $response;
        $this->response(
            $this->getResponseCode(),
            $arr
        );
    }

    public function listAllBudgets()
    {
        $budgetService = new BudgetService();
        $response = $budgetService->getAllBudgets();
        $this->responseCode = $budgetService->getSuccessCheck() ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR;

        $this->response(
            $this->getResponseCode(),
            $response
        );
    }

    public function deleteBudget()
    {
        $validationRules = [
            'budget_id' => 'post:budget_id@required'
        ];
        $validation = $this->doValidate($validationRules);

        if ($validation['isValid']) {
            $validData = $validation['validatedData'];
            $budgetService = new BudgetService();
            $response = $budgetService->deleteBudget($validData['budget_id']);
            $this->responseCode = $response ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR;
        } else {
            $this->responseCode = Response::HTTP_NOT_ACCEPTABLE;
            $response = false;
        }

        $arr['response'] = $response;
        $this->response(
            $this->getResponseCode(),
            $arr
        );
    }
}

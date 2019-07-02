<?php
namespace Service;

use Model\Record;
use Repository\AccountRepository;
use Repository\BudgetRepository;
use Repository\CategoryRepository;
use Repository\RecordRepository;
use Support\Manager\CustomerManager;
use util\Constants;

class RecordService extends AbstractService
{
    public function registerRecord(array $recordData)
    {
        $recordRepository = new RecordRepository();
        $categoryRepository = new CategoryRepository();
        $budgetRepository = new BudgetRepository();
        $accountRepository = new AccountRepository();
        $record = new Record(
            $recordData['record_name'],
            $recordData['record_desc'],
            $recordData['amount'],
            $recordData['category_id'],
            $recordData['acc_id']
        );

        $recordAmount = $record->getAmount();
        $categoryId = $record->getCategoryId();
        $accountId = $record->getAccId();
        $categoryType = $categoryRepository->getCategoryType($categoryId);
        $response = true;

        try {
            $recordRepository->beginTransaction();
            $recordRepository->insertRecord($record);
            if ($categoryType['category_type'] === 'income') {
                $accountRepository->addToAccountBalance(
                    $accountId,
                    $recordAmount
                );
            } else {
                $budgetId = $budgetRepository->pickBudgetId($categoryId);
                $budgetRepository->addToBudgetAmount(
                    $budgetId,
                    $recordAmount*(-1)
                );
                $accountRepository->addToAccountBalance(
                    $accountId,
                    $recordAmount*(-1)
                );
            }
            $recordRepository->commit();
        }catch (\PDOException $exception) {
            $recordRepository->rollBack();
            $response = false;
        }

        return $response;
    }

    public function listRecords()
    {
        $userId = CustomerManager::getUserId();
        $recordRepository = new RecordRepository();
        $allRecords = $recordRepository->getAllRecordsByUser($userId);
        $result = [];
        foreach ($allRecords as $allRecord) {
            $result[] = array_values(get_object_vars($allRecord));
        }

        if (!$allRecords) {
            return false;
        }

        return array_values($result);
    }

    public function getSumTotal(array $validatedData)
    {
        $userId = CustomerManager::getUserId();
        $recordRepository = new RecordRepository();
        if (empty($validatedData["acc_id"])) {
            $accId = "0";
        }
        else {
            $accId = $validatedData["acc_id"];
        }
        if (empty($validatedData["start_date"]) && empty( $validatedData["end_date"])){
            $startDate = date(
                Constants::DATE_FORMAT_PHP,
                strtotime('-1 months')
            );
            $endDate = date(
                Constants::DATE_FORMAT_PHP,
                strtotime('+1 days')
            );
        }else{
            $startDate = $validatedData["start_date"];
            $endDate = $validatedData["end_date"];
        }
        $sum = $recordRepository->sumAllExpenses($userId,
            $startDate,
            $endDate,
            $accId
        );

        if(empty($sum[0]["total_sum"])){
            $sum[0]["total_sum"] = "0";
        }
        if(empty($sum[0]["total_sum"])){
            $sum[1]["total_sum"] = "0";
        }

        return $sum;
    }

    public function chartExpenses(array $validData)
    {
        $recordRepository = new RecordRepository();
        $userId = CustomerManager::getUserId();
        if(empty($validData["acc_id"])){
            $accId = "0";
        }
        else{
            $accId = $validData["acc_id"];
        }
        if(empty( $validData["start_date"]) && empty( $_POST["end_date"])){
            $startDate = date(Constants::DATE_FORMAT_PHP, strtotime('-1 months'));
            $endDate = date(Constants::DATE_FORMAT_PHP, strtotime('+1 days'));
        }else{
            $startDate = $validData["start_date"];
            $endDate = $validData["end_date"];
        }

        $expenses = $recordRepository->getAllExpensesById(
            $userId,
            $startDate,
            $endDate,
            $accId
        );
        $labels = [];
        $data = [];
        $arr = [];

        if (!empty($expenses)) {
            foreach ($expenses as $expens) {
                $labels[] = $expens["category_name"];
                $data[] = $expens["sum"];
            }
        }

        $arr[] = $labels;
        $arr[] = $data;

       return $arr;
    }

    public function listLastFiveRecords()
    {
        $userId = CustomerManager::getUserId();
        $recordRepository = new RecordRepository();
        $arr = $recordRepository->getLastFiveRecordsById($userId);

        return $arr;
    }

    public function listIncomesAndExpense(array $validData)
    {
        $recordRepository = new RecordRepository();
        $userId = CustomerManager::getUserId();
        if(empty($validData["acc_id"])){
            $accId = "0";
        }
        else{
            $accId = $validData["acc_id"];
        }
        if(empty( $validData["start_date"])){
            $validData["start_date"] = date(Constants::DATE_FORMAT_PHP, strtotime('-1 months'));
        }
        if(empty( $validData["end_date"])){
            $validData["end_date"] = date(Constants::DATE_FORMAT_PHP, strtotime('+1 days'));
        }

        $allRecords = $recordRepository->getAllRecordsByUserFiltered(
            $userId,
            $validData["start_date"],
            $validData["end_date"],
            $accId
        );
        $labelsExpense = [];
        $labelsIncome = [];
        $dataExpense = [];
        $dataIncome = [];
        $arr = [];

        foreach ($allRecords as $allRecord) {
            if($allRecord["category_type"] == "expense"){
                $labelsExpense[] = $allRecord["action_date"];
                $dataExpense[] = $allRecord["amount"];
            }
            else{
                $labelsIncome[] = $allRecord["action_date"];
                $dataIncome[] = $allRecord["amount"];
            }
        }

        $arr[] = $labelsExpense;
        $arr[] = $dataExpense;
        $arr[] = $labelsIncome;
        $arr[] = $dataIncome;

        return array_values($arr);
    }

    public function radarDiagramExpenses(array $validData)
    {
        $recordRepository = new RecordRepository();
        $userId  = CustomerManager::getUserId();
        if(empty($validData["acc_id"])){
            $accId = "0";
        }
        else{
            $accId = $validData["acc_id"];
        }
        if(empty( $validData["start_date"]) && empty( $validData["end_date"])){
            $startDate = date(Constants::DATE_FORMAT_PHP, strtotime('-1 months'));
            $endDate = date(Constants::DATE_FORMAT_PHP, strtotime('+1 days'));
        }else{
            $startDate = $validData["start_date"];
            $endDate =  $validData["end_date"];
        }
        $firstComparePeriod = $recordRepository->getAllExpensesById(
            $userId,
            $startDate,
            $endDate,
            $accId
        );
        $labels = [];
        $data = [];
        $arr = [];

        foreach ($firstComparePeriod as $expens) {
            $labels[] = $expens["category_name"];
            $data[]   = $expens["sum"];
        }

        $arr[] = $labels;
        $arr[] = $data;

        return $arr;
    }

    public function averageIncomeInfo(array $validData)
    {
        $recordRepository = new RecordRepository();
        $userId  = CustomerManager::getUserId();
        $accId = $validData["acc_id"];
        $avgIncome = $recordRepository->getAverageIncome($userId, $accId);

        return $avgIncome;
    }

    public function averageExpenseInfo(array $validData)
    {
        $recordRepository = new RecordRepository();
        $userId  = CustomerManager::getUserId();
        $accId = $validData["acc_id"];
        $avgExpense = $recordRepository->getAverageExpense($userId, $accId);

        return $avgExpense;
    }
}
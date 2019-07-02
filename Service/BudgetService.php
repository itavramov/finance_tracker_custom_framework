<?php
namespace Service;

use Model\Budget;
use Repository\BudgetRepository;
use Support\Manager\CustomerManager;
use util\Constants;

class BudgetService extends AbstractService
{
    public function registerBudget(array $validData)
    {
        $budgetRepository = new BudgetRepository();
        $userId = CustomerManager::getUserId();
        $newBudget = new Budget(
            $userId,
            $validData['budget_name'],
            $validData['budget_desc'],
            $validData['budget_amount'],
            $validData['budget_amount'],
            $validData['category_id'],
            $validData['from_date'],
            $validData['to_date']
        );
        $response = $budgetRepository->addBudget($newBudget);

        return $response;
    }

    public function getAllBudgets()
    {
        $budgetRepository = new BudgetRepository();
        $userId = CustomerManager::getUserId();
        $startData = date(Constants::DATE_FORMAT_PHP, strtotime('-2 months'));
        $endData = date(Constants::DATE_FORMAT_PHP);
        $result = $budgetRepository->getAllBudgetsById($userId, $startData, $endData);

        return $result;
    }

    public function deleteBudget($budgetId)
    {
        $budgetRepository = new BudgetRepository();
        $result  = $budgetRepository->deleteBudget($budgetId);

        return $result;
    }
}

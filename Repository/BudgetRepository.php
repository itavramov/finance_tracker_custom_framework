<?php
namespace Repository;

use Model\Budget;
use util\Constants;

class BudgetRepository extends AbstractRepository
{
    public function addBudget(Budget $budget)
    {
        $userId = $budget->getUserId();
        $budgetName = $budget->getBudgetName();
        $budgetDesc = $budget->getBudgetDesc();
        $currentAmount = $budget->getCurrentAmount();
        $initAmount    = $budget->getInitAmount();
        $categoryId = $budget->getCategoryId();
        $fromDate = $budget->getFromDate();
        $toDate = $budget->getToDate();
        $sql = "
            INSERT INTO
                budgets(
                    user_id, 
                    budget_name, 
                    budget_desc,
                    init_amount,
                    current_amount,
                    category_id,
                    from_date,
                    to_date
                )
            VALUES(
                :user_id,
                :budget_name,
                :budget_desc,
                :init_amount,
                :current_amount,
                :category_id,
                STR_TO_DATE(:from_date, '".Constants::DATE_FORMAT."'),
                STR_TO_DATE(:to_date, '".Constants::DATE_FORMAT."')
            )
        ";
        $bindParams = [
            "user_id" => $userId,
            "budget_name" => $budgetName,
            "budget_desc" => $budgetDesc,
            "init_amount" => $initAmount,
            "current_amount" => $currentAmount,
            "category_id" => $categoryId,
            "from_date" => $fromDate,
            "to_date"   => $toDate
        ];
        $this->execute($sql, $bindParams);
        if($this->lastInsertedId() === 0){
            return false;
        }
        return true;
    }

    public function getAllBudgetsById($userId, $startDate, $endDate)
    {
        $sql = "
            SELECT
                b.budget_id,
                b.budget_name,
                b.init_amount,
                b.current_amount,
                c.category_name,
                b.from_date,
                b.to_date
            FROM
                budgets AS b
                INNER JOIN categories AS c ON (b.category_id = c.category_id)
            WHERE b.user_id = :user_id
                  AND b.from_date <= STR_TO_DATE(:from_date, '".Constants::DATE_FORMAT."')
                  AND b.to_date >= STR_TO_DATE(:to_date, '".Constants::DATE_FORMAT."')
        ";
        $bindParams = [
            "user_id" =>$userId,
            "from_date" => $endDate,
            "to_date"  => $startDate
        ];

        $result = [];
        $result = $this->fetchAssoc($sql, $bindParams);
        return $result;
    }

    public function deleteBudget($budgetId)
    {
        $sql = "
            DELETE FROM
                budgets
            WHERE
                budget_id = :budget_id
        ";
        $bindParams = [
          "budget_id" => $budgetId
        ];
        $this->execute($sql, $bindParams);
        if ($this->getEffectedRows() === 0) {
            return false;
        }
        return true;
    }

    public function pickBudgetId($categoryId)
    {
        $sql = "
                    SELECT
                        budget_id
                    FROM
                        budgets
                    WHERE 
                        category_id = :category_id
                        AND curdate() BETWEEN from_date 
                        AND to_date
                ";
        $bindParams = [
            "category_id" => $categoryId
        ];
        $result = $this->fetchAssocSingleRow($sql, $bindParams);
        if ($this->getEffectedRows() === 0) {
            return false;
        }

        return $result;
    }

    public function addToBudgetAmount($budgetId, $amount)
    {
        $sql = "
                        UPDATE
                            budgets
                        SET 
                            current_amount = current_amount + :amount 
                        WHERE 
                            budget_id = :budget_id
                    ";
        $bindParams = [
            "amount" => $amount,
            "budget_id" => $budgetId
        ];
        $result = $this->execute($sql, $bindParams);

        if ($this->getEffectedRows() === 0) {
            return false;
        }

        return $result;
    }
}

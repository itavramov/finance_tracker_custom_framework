<?php
namespace Repository;

use Model\Record;
use util\Constants;

class RecordRepository extends AbstractRepository
{
    public function insertRecord(Record $record)
    {
        $sql = "
                INSERT INTO records (
                    record_name,
                    record_desc,
                    amount,
                    category_id,
                    acc_id,
                    action_date
                )
                VALUES (
                    :record_name,
                    :record_desc,
                    :amount,
                    :category_id,
                    :acc_id,
                    NOW()
                )
            ";
        $bindParams = [
            'record_name' => $record->getRecordName(),
            'record_desc' => $record->getRecordDesc(),
            'amount' => $record->getAmount(),
            'category_id' => $record->getCategoryId(),
            'acc_id' => $record->getAccId()
        ];
        $this->execute($sql, $bindParams);

        if($this->getEffectedRows() > 0){
            return true;
        }

        return false;
    }

    public function getAllRecordsByUser($userId)
    {
        $sql = "
            SELECT
                a.acc_name,
                r.record_name, 
                r.record_desc, 
                r.amount, 
                r.action_date, 
                s.category_name, 
                s.category_type
            FROM 
                records AS r
                INNER JOIN categories AS s ON (r.category_id = s.category_id)
                INNER JOIN accounts AS a ON (a.acc_id = r.acc_id)
                INNER JOIN users AS u ON (u.user_id = a.user_id)
            WHERE
                 u.user_id = :user_id
        ";
        $bindParams = [
          "user_id" => $userId
        ];
        $result = $this->fetchObject($sql,$bindParams);

        if($this->getEffectedRows() > 0){
            return $result;
        }

        return false;
    }

    public function sumAllExpenses($userId, $startDate, $endDate, $accId)
    {
        $sql = "
           SELECT
                category_type, 
                SUM(r.amount) AS total_sum
            FROM
                records r
                INNER JOIN categories AS s ON (r.category_id = s.category_id)
                INNER JOIN accounts AS a ON (a.acc_id = r.acc_id)
                INNER JOIN users AS u ON (u.user_id = a.user_id)
            WHERE
                u.user_id = :user_id 
                AND r.action_date BETWEEN STR_TO_DATE(:start_date, '".Constants::DATE_FORMAT."') AND STR_TO_DATE(:end_date, '".Constants::DATE_FORMAT."')
        ";
        $bindParams = [
            "user_id" => $userId,
            "start_date" => $startDate,
            "end_date" => $endDate
        ];

        if($accId !== "0"){
            $sql .= " AND r.acc_id = :acc_id";
            $bindParams["acc_id"] = intval($accId);
        }
        $sql .= " GROUP BY s.category_type";
        $result = $this->fetchAssoc($sql, $bindParams);

        if($this->getEffectedRows() > 0){
            return $result;
        }

        return false;
    }

    public function getAllExpensesById($userId, $startDate, $endDate, $accId)
    {
        $sql = "
            SELECT
                c.category_name,
                SUM(r.amount) AS sum 
            FROM
                records AS r
                INNER JOIN categories AS c ON (c.category_id = r.category_id)
                INNER JOIN accounts AS a ON(a.acc_id = r.acc_id)
            WHERE
                a.user_id = :user_id
                AND c.category_type = 'expense' 
                AND r.action_date BETWEEN STR_TO_DATE(:start_date, '".Constants::DATE_FORMAT."') AND STR_TO_DATE(:end_date, '".Constants::DATE_FORMAT."')
         ";
        $bindParams = [
          "user_id" => $userId,
          "start_date" => $startDate,
          "end_date"   => $endDate
        ];
        if($accId !== "0"){
            $sql .= " AND r.acc_id = :acc_id";
            $bindParams["acc_id"] = intval($accId);
        }
        $sql .= " GROUP BY c.category_id";
        $result = $this->fetchAssoc($sql, $bindParams);

        if($this->getEffectedRows() > 0){
            return $result;
        }

        return false;
    }

    public function getLastFiveRecordsById($userId)
    {
        $sql = "
            SELECT
                c.category_name,
                a.acc_name,
                r.amount,
                r.action_date,
                c.category_type
            FROM 
                records r    
                INNER JOIN accounts a ON (r.acc_id = a.acc_id)
                INNER JOIN categories c ON (r.category_id = c.category_id)
            WHERE 
                a.user_id = :user_id
            ORDER BY
                r.action_date DESC
            LIMIT 0, 5
            
            ";
        $bindParams = [
            "user_id" => $userId
        ];
        $result = $this->fetchAssoc($sql, $bindParams);

        if($this->getEffectedRows() > 0){
            return $result;
        }

        return false;
    }

    public function getAverageIncome($userId, $accId)
    {
        $sql = "
            SELECT 
                ROUND(AVG(r.amount),2) AS average
            FROM
                records AS r 
                INNER JOIN categories AS c ON (c.category_id = r.category_id)
                INNER JOIN accounts AS a ON(a.acc_id = r.acc_id)
            WHERE
                a.user_id = :user_id
                AND c.category_type = 'income'
        ";
        $bindParams = [
          "user_id" => $userId
        ];
        if($accId !== "0"){
            $sql .= " AND r.acc_id = :acc_id";
            $bindParams["acc_id"] = $accId;
        }
        $result = $this->fetchAssocSingleRow($sql, $bindParams);

        if($this->getEffectedRows() > 0){
            return $result;
        }

        return false;
    }

    public function getAverageExpense($userId, $accId)
    {
        $sql = "
            SELECT 
                ROUND(AVG(r.amount),2) AS average
            FROM
                records AS r 
                INNER JOIN categories AS c ON (c.category_id = r.category_id)
                INNER JOIN accounts AS a ON(a.acc_id = r.acc_id)
            WHERE
                a.user_id = :user_id
                AND c.category_type = 'expense'
        ";
        $bindParams = [
            "user_id" => $userId
        ];
        if($accId !== "0"){
            $sql .= " AND a.acc_id = :acc_id";
            $bindParams["acc_id"] =  intval($accId);
        }
        $result = [];
        $result = $this->fetchAssocSingleRow($sql, $bindParams);

        return $result;
    }

    public function getAllRecordsByUserFiltered($userId, $startDate, $endDate, $accId)
    {
        $sql = "
            SELECT
                r.record_name, 
                r.record_desc, 
                r.amount, 
                r.action_date, 
                s.category_name, 
                s.category_type
            FROM 
                records r
                INNER JOIN categories AS s ON (r.category_id = s.category_id)
                INNER JOIN accounts AS a ON (a.acc_id = r.acc_id)
                INNER JOIN users AS u ON (u.user_id = a.user_id)
            WHERE
                u.user_id = :user_id
                AND r.action_date BETWEEN STR_TO_DATE(:start_date, '".Constants::DATE_FORMAT."') AND STR_TO_DATE(:end_date, '".Constants::DATE_FORMAT."')
        ";
        $bindParams = [
            "user_id" => $userId,
            "start_date" => $startDate,
            "end_date"   => $endDate
        ];
        if($accId !== "0"){
            $sql .= " AND r.acc_id = :acc_id";
            $bindParams["acc_id"] = intval($accId);
        }
        $result = $this->fetchAssoc($sql, $bindParams);

        if($this->getEffectedRows() > 0){
            return $result;
        }

        return false;
    }
}
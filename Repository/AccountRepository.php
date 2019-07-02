<?php
namespace Repository;

use Model\Account;

class AccountRepository extends AbstractRepository
{
    public function addAccount(Account $account)
    {
        $name = $account->getAccName();
        $type = $account->getAccType();
        $balance = $account->getBalance();
        $currency = $account->getCurrency();
        $userId  = $account->getUserId();
        $sql = "
            INSERT INTO
                accounts (
                  acc_name, 
                  acc_type,
                  balance,
                  currency,
                  user_id
                )
            VALUES (
                :acc_name,
                :acc_type,
                :balance,
                :currency,
                :user_id
            )
        ";
        $bindParams = [
          "acc_name" => $name,
          "acc_type" => $type,
          "balance" => $balance,
          "currency" => $currency,
          "user_id" => $userId
        ];

        $this->execute($sql,$bindParams);

        if($this->getEffectedRows() > 0){
            return true;
        }

        return false;
    }

    public function getAllAccountsById($userId)
    {
        $sql = "
           SELECT
                acc_id,
                acc_name,
                balance,
                currency 
           FROM
                accounts 
           WHERE
                user_id = :user_id 
        ";
        $bindParams = [
          "user_id" => $userId
        ];
        $result = $this->fetchAssoc($sql,$bindParams);

        return $result;
    }

    public function updateAccount(Account $account, $accId)
    {
        $accName = $account->getAccName();
        $accType = $account->getAccType();
        $balance = $account->getBalance();
        $currency = $account->getCurrency();

        $sql = "
            UPDATE
                accounts
            SET 
                acc_name = :acc_name,
                acc_type = :acc_type,
                balance = :balance,
                currency = :currency
            WHERE
                acc_id = :acc_id      
        ";
        $bindParams = [
            'acc_name' => $accName,
            'acc_type' => $accType,
            'balance' => $balance,
            'currency' => $currency,
            'acc_id' => $accId
        ];

        $this->execute($sql,$bindParams);

        if ($this->getEffectedRows() === 0){
            return false;
        }
        return true;
    }

    public function deleteAccount($accId)
    {
        $sql = "
            DELETE FROM
                accounts
            WHERE 
                acc_id = :acc_id
        ";
        $bindParams = [
            "acc_id" => $accId
        ];
        $this->execute($sql, $bindParams);
        if ($this->getEffectedRows() === 0) {
            return false;
        }
        return true;
    }

    public function getAccountInfo($accId){
        $sql = "
            SELECT
                acc_name,
                acc_type,
                balance,
                currency 
            FROM
                accounts
            WHERE
                acc_id = :acc_id
        ";
        $bindParams = [
          "acc_id" => $accId
        ];
        $accInfo = $this->fetchAssocSingleRow($sql, $bindParams);

        return $accInfo;
    }

    public function addToAccountBalance($accId, $amount)
    {
        $sql = "
                    UPDATE
                        accounts
                    SET
                        balance = balance + :amount
                    WHERE
                        acc_id = :acc_id 
                ";
        $bindParams = [
            'amount' => $amount,
            'acc_id' => $accId
        ];
        $this->execute($sql, $bindParams);

        if($this->getEffectedRows() > 0){
            return true;
        }

        return false;
    }
}

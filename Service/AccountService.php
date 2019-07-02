<?php
namespace Service;

use Model\Account;
use Repository\AccountRepository;
use Support\Manager\CustomerManager;

class AccountService extends AbstractService
{
    public function registerAccount(array $accountData)
    {
        $accountRepository = new AccountRepository();
        $userId = CustomerManager::getUserId();
        $account = new Account(
            $accountData['acc_name'],
            $accountData['acc_type'],
            $accountData['balance'],
            $accountData['acc_currency'],
            $userId);
        $response = $accountRepository->addAccount($account);

        return $response;
    }

    public function getAllAccounts()
    {
        $accountRepository = new AccountRepository();
        $userId = CustomerManager::getUserId();
        $accounts = $accountRepository->getAllAccountsById($userId);

        return $accounts;
    }

    public function editAccount(array $accountData)
    {
        $userId =CustomerManager::getUserId();
        $accountRepository = new AccountRepository();

        $accEdited = new Account(
            $accountData['acc_name'],
            $accountData['acc_type'],
            $accountData['balance'],
            $accountData['acc_currency'],
            $userId
        );
        $response  = $accountRepository->updateAccount($accEdited, $accountData['acc_id']);

        return $response;
    }

    public function deleteAccount($accId)
    {
        $accountRepository = new AccountRepository();
        $result = $accountRepository->deleteAccount($accId);

        return $result;
    }

    public function getAccountInfo($accId)
    {
        $accountRepository = new AccountRepository();
        $result = $accountRepository->getAccountInfo($accId);

        return $result;
    }
}

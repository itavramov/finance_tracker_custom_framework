<?php
namespace Support\Manager;

use http\SessionHandler;

class CustomerManager
{
    public static function setUserData(array $userData)
    {
        $session = SessionHandler::getInstance();
        foreach ($userData as $key => $value) {
            $session->setSessionValue(
                $key,
                $value
            );
        }
    }

    public static function isLogged()
    {
        $customerId = CustomerManager::getUserId();

        return !empty($customerId);
    }

    public static function getUserId()
    {
        $session = SessionHandler::getInstance();

        return $session->getSessionValue('user_id');
    }

    public static function unsetUserSession()
    {
        $session = SessionHandler::getInstance();
        $session->sessionDestroy();
    }
}
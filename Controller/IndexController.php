<?php
namespace Controller;

use http\SessionHandler;
use Support\Manager\CustomerManager;

class IndexController extends AbstractController
{
    public function before()
    {
    }

    public function index()
    {
//        if (!isset($_SESSION["logged"])){
//            $_SESSION["logged"] = false;
//        }
        if (CustomerManager::isLogged()){
            require_once 'view/dashboard.phtml';
            die();
        }else{
            require_once 'view/welcomePage.phtml';
            die();
        }
    }

    public function error404()
    {
        require_once 'view/404.html';
    }

    public function error500()
    {
        require_once 'view/500.html';
    }

    public function error503()
    {
        require_once 'view/503.html';
    }

    public function unhandledError()
    {
        require_once 'view/unhandledError.html';
    }
}

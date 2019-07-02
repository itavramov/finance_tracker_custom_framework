<?php
namespace Support\Factory;

use Exception\RoutingException;

class ControllerFactory
{
    public static function createController($name)
    {
        $controllerName = "\\Controller\\" . ucfirst($name) . "Controller";
        if (!class_exists($controllerName)) {
            throw new RoutingException("The controller class doesn't exists...");
        }

        return  new $controllerName();
    }
}
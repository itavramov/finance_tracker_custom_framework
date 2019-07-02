<?php
use \Router;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "autoLoader.php";
include "debuggerTool.php";
include "routes.php";

$request = Router\Request::getInstance();
$router  = new Router\Router($request, $routesRegistrator);

try {
    $router->start();
} catch (\Exception\SessionException $exception) {
   \http\Response::getInstance()->redirect(Router\Url::generateUrl('serviceError'));
} catch (\Exception\RoutingException $exception) {
    if (!empty($router->getControllerClass())) {
        if ($router->getControllerClass()->isAjax()) {
            $error['message'] = "Something went wrong...";
        } else {
            \http\Response::getInstance()->redirect(Router\Url::generateUrl('pageNotFoundError'));
        }
    } else {
        \http\Response::getInstance()->redirect(Router\Url::generateUrl('pageNotFoundError'));
    }
} catch (\Exception\DataBaseConnectionException $exception) {
    \http\Response::getInstance()->redirect(Router\Url::generateUrl('serverError'));
} catch (\Exception\ValidationException $exception) {
    \http\Response::getInstance()->redirect(Router\Url::generateUrl('serviceError'));
} catch (\Exception\ResponseException $exception) {
    \http\Response::getInstance()->redirect(Router\Url::generateUrl('serverError'));
} catch (Throwable $exception) {
    \http\Response::getInstance()->redirect(Router\Url::generateUrl('unhandledError'));
}

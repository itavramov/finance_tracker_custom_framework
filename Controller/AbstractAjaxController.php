<?php
namespace Controller;

use http\Response;

class AbstractAjaxController extends AbstractController
{
    protected $isAjax = true;

    public function response($statusCode, $responseData)
    {
        $responseInstance = Response::getInstance($statusCode);
        $statusMessage = $responseInstance->mapStatusMessages($statusCode);
        $response = [
            'statusInfo' => [
                $statusCode => $statusMessage
            ],
            'data' => $responseData
        ];
        $headers = [
            'Content-Type' => 'application/json; charset=UTF-8'
        ];

        $responseInstance->setHeaders($headers);
        $responseInstance->setBody($responseData);
        $responseInstance->json();
        $responseInstance->send();
    }
}

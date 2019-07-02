<?php
namespace Router;

class Request
{
    const DOMAIN = "https://ivan-avramov-finance-tracker.upnetix.tech";

    private static $instance;

    private $url;
    private $uri;
    private $getParams = [];
    private $postParams = [];
    private $filesParams = [];
    private $requestMethod;

    private function __construct()
    {
        $url = self::DOMAIN . $_SERVER['REQUEST_URI'];
        $this->setUrl($url);
        $this->setUri((empty($_SERVER['REQUEST_URI']) || $_SERVER['REQUEST_URI'] == "/") ? $_SERVER['REQUEST_URI'] : substr($_SERVER['REQUEST_URI'], 1));
        $this->setGetParams($_GET);
        $this->setPostParams($_POST);
        $this->setRequestMethod($_SERVER["REQUEST_METHOD"]);
        $this->setFilesParams($_FILES);
    }

    public static function getInstance()
    {
        if (empty(self::$instance)){
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getFilesParams()
    {
        return $this->filesParams;
    }

    public function setFilesParams($filesParams)
    {
        $this->filesParams = $filesParams;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    public function getGetParams()
    {
        return $this->getParams;
    }

    public function setGetParams($getParams)
    {
        $this->getParams = $getParams;
    }

    public function getPostParams()
    {
        return $this->postParams;
    }

    public function setPostParams($postParams)
    {
        $this->postParams = $postParams;
    }

    public function getRequestMethod()
    {
        return $this->requestMethod;
    }

    public function setRequestMethod($requestMethod)
    {
        $this->requestMethod = $requestMethod;
    }


}

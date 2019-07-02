<?php
namespace Repository;

class Database
{
    private $dbName;
    private $dbHost;
    private $dbPort;
    private $dbUser;
    private $dbPass;

    public function __construct($dbName, $dbHost, $dbPort, $dbUser, $dbPass)
    {
        $this->dbName = $dbName;
        $this->dbHost = $dbHost;
        $this->dbPort = $dbPort;
        $this->dbUser = $dbUser;
        $this->dbPass = $dbPass;
    }

    public function getDbName()
    {
        return $this->dbName;
    }

    public function getDbHost()
    {
        return $this->dbHost;
    }

    public function getDbPort()
    {
        return $this->dbPort;
    }

    public function getDbUser()
    {
        return $this->dbUser;
    }

    public function getDbPass()
    {
        return $this->dbPass;
    }
}

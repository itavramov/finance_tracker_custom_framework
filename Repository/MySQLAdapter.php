<?php
namespace Repository;

use Exception\DataBaseConnectionException;

class MySQLAdapter
{
    /** @var \PDO $conn*/
    private $conn;
    private $db;
    private $effectedRows;

    public function __construct(Database $database)
    {
        $this->db = $database;
        $this->connect();
    }

    private function connect()
    {
        try{
            $this->conn = new \PDO(
                "mysql:host=" . $this->db->getDbHost() . ":" . $this->db->getDbPort() . ";dbname=" . $this->db->getDbName(),
                $this->db->getDbUser(),
                $this->db->getDbPass()
            );
            $this->conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
        }catch (\PDOException $exception){
            throw new DataBaseConnectionException("Database connection problem");
        }
    }

    public function execute($query, array $bindParams)
    {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($bindParams);
        $this->setEffectedRows($stmt->rowCount());
        return $stmt;
    }

    public function beginTransAction()
    {
        $this->conn->beginTransaction();
    }

    public function commit()
    {
        $this->conn->commit();
    }

    public function lastInsertedId()
    {
        $this->conn->lastInsertId();
    }

    public function rollBack()
    {
        $this->conn->rollBack();
    }

    public function getConn()
    {
        return $this->conn;
    }

    public function setConn($conn)
    {
        $this->conn = $conn;
    }

    public function getDb()
    {
        return $this->db;
    }

    public function setDb($db)
    {
        $this->db = $db;
    }

    public function getEffectedRows()
    {
        return $this->effectedRows;
    }

    public function setEffectedRows($effectedRows)
    {
        $this->effectedRows = $effectedRows;
    }
}

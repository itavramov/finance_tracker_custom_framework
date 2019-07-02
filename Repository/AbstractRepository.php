<?php
namespace Repository;

use Support\Factory\AdapterFactory;
use util\Constants;

abstract class AbstractRepository
{
    /** @var \MySQLAdapter $adapter*/
    protected $adapter;

    public function __construct()
    {
        $db = new Database(Constants::DB_NAME, Constants::DB_HOST, Constants::DB_PORT, Constants::DB_NAME, Constants::DB_PASS);
        $this->adapter = AdapterFactory::createMySQLAdapter($db);
    }

    public function execute($query, array $bindParams)
    {
        return $this->adapter->execute($query, $bindParams);
    }

    public function fetchAssocSingleRow($query, array $bindParams)
    {
        $stmt = $this->execute($query,$bindParams);
        if ($stmt) {
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function fetchSingleValue($query, array $bindParams)
    {
        $stmt = $this->execute($query,$bindParams);
        if ($stmt) {
             return $stmt->fetchAll(\PDO::FETCH_COLUMN, 0);
        }
        return false;
    }

    public function fetchColumn($query, array $bindParams)
    {
        $stmt = $this->execute($query,$bindParams);
        if ($stmt) {
            return $stmt->fetchAll(\PDO::FETCH_COLUMN);
        }
        return false;
    }

    public function fetchAssoc($query, array $bindParams)
    {
        $stmt = $this->execute($query,$bindParams);
        if ($stmt) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function fetchPair($query, array $bindParams)
    {
        $stmt = $this->execute($query,$bindParams);
        if ($stmt) {
            return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
        }
        return false;
    }

    public function fetchObject($query, array $bindParams)
    {
        $stmt = $this->execute($query,$bindParams);
        if ($stmt) {
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        }
        return false;
    }

    public function lastInsertedId()
    {
        return $this->adapter->lastInsertedId();
    }

    public function beginTransaction()
    {
        $this->adapter->beginTransaction();
    }

    public function commit()
    {
        $this->adapter->commit();
    }

    public function rollBack()
    {
        $this->adapter->rollBack();
    }

    public function getEffectedRows()
    {
        return $this->adapter->getEffectedRows();
    }
}

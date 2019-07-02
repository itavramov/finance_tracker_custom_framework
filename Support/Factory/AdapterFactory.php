<?php
namespace Support\Factory;

use Repository\Database;
use Repository\MySQLAdapter;

class AdapterFactory
{
    private static $adapters = [];

    public static function createMySQLAdapter(Database $database)
    {
        if (empty(self::$adapters['mySql'])) {
            self::$adapters['mySql'] = new MySQLAdapter($database);
        }
        return self::$adapters['mySql'];
    }
}

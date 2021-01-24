<?php
/**
 * MySQL data mapper trait.
 * 
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 MitopatHs
 */ 
namespace Mitopaths\DataMapper;

/**
 * MySQL data mapper trait.
 *
 * Implements a MySQL trait. Internally uses  PDO for queries,
 * relying on prepared statements to avoid SQL injections.
 *
 * This class follows the Proxy Design Pattern.
 *
 * @author Marco Zanella <marco.zanella.1991@gmail.com>
 * @copyright 2018 Mitopaths
 * @package Mitopaths\DataMapper
 */
trait SqlServer {
    /**
     * @var mixed $dbh Connection to database.
     */
    protected static $dbh = null;
    
    /**
     * Performs a query against the database.
     *
     * @param string $query_string Query string
     * @param array $parameters Associative array of binders for prepared statement
     * @return mixed Result of the query
     * @note In multi-processes scenarios (e.g. fork) when a child terminates, also
     *       father's connection is badly closed. When this happens, executing
     *       a query raises a "MySQL server has gone away" error. This method fixes
     *       this bad behavior by reconnecting.
     */
    protected function query($query_string, $parameters = []) {
        try {
            $stmt = $this->getConnection()->prepare($query_string);
            if (!$stmt->execute($parameters)) {
                $stmt = null;
                throw new \Exception("Error during query \"$query_string\": " . $stmt->errorCode());
            }
        }
        catch(\PDOException $e) {
            if (strpos($e->getMessage(), "MySQL server has gone away") !== false) {
                $this->closeConnection();
                return $this->query($query_string, $parameters);
            }
            throw $e;
        }
        catch(\Exception $e) {
            $this->closeConnection();
            throw new \Exception("Error during query \"$query_string\": " . $e->getMessage());
        }
        
        return $stmt;
    }
    
    
    
    /**
     * Converts a raw record into a model.
     * 
     * @param mixed $row Raw record
     * @return mixed|null instance of appropriate model or null
     */
    protected abstract function rowToModel($row);
    
    
    
    /**
     * Converts a record set into an array of models.
     *
     * @param mixed $rows Record set
     * @return array Array of appropriate models
     */
    protected function rowsToModels($rows) {
        $items = [];
        foreach ($rows as $row) {
            $items[] = $this->rowToModel($row);
        }
        return $items;
    }
    
    
    
    /**
     * Returns last inserted id.
     * 
     * @return int Last inserted id
     */
    protected function getLastInsertedId() {
        return $this->getConnection()->lastInsertId();
    }
    
    
    
    /**
     * Returns connection to the database.
     *
     * @return mixed Active connection to database
     */
    protected function getConnection() {
        if (!is_null(self::$dbh)) {
            return self::$dbh;
        }
        
        $config = parse_ini_file('config.ini', true);

        self::$dbh = new \PDO(
            'mysql:host=' . $config['database_server']['host'] . ';dbname=' . $config['database_server']['name'] . ';charset=utf8', 
            $config['database_server']['user'],
            $config['database_server']['password']
        );
        self::$dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        self::$dbh->setAttribute(\PDO::ATTR_PERSISTENT, true);
        
        return self::$dbh;
    }



    /**
     * Closes connection to database.
     */
    protected function closeConnection() {
        self::$dbh = null;
    }
}

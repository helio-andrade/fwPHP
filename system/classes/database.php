<?php
/**
 * Base class for database access
 */
abstract class Database
{
    protected $type = null;     
    protected $host = 'localhost';
    protected $port = 0;
    protected $username;
    protected $password;
    protected $database;
    protected $connection;

    abstract public function connect();
    abstract public function executeSQL($sql);

    public function setHost($host)
    {
        $this->host = $host;
    }

    public function setPort($port)
    {
        $this->port = $port;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setDatabase($database)
    {
        $this->database = $database;
    }
}

/**
 * Class for managing MySQL databases
 */
class MySQL extends Database
{
    public function __construct()
    {
        $this->type = 'mysql';
    }

    public function connect()
    {
        $this->connection = new mysqli(
            $this->host,
            $this->username,
            $this->password,
            $this->database,
            $this->port
        );

        return $this->connection;
    }

    public function executeSQL($sql)
    {
        if ($this->connection !== false) {
            $result = $this->connection->query($sql);  
            return $result;  
        }
        else {
            return false;
        }
    }
}
?>

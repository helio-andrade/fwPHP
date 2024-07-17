<?php
    /**
     * Classe abstrata para gerenciamento do banco de dados
     * @abstract
     */
    abstract class DataBase {
        protected $dbType;
        protected $server = 'localhost';
        protected $port = 0;
        protected $username;
        protected $password;
        protected $database;
        protected $connection = false;
        protected $resultSet = false;
        protected $numRows = -1;
        protected $currentRow = false;
        protected $currentPosition = -1;
        protected $lastError = '';

        abstract public function connect();
        abstract public function executeQuery($sql);
        abstract protected function updateNumRows();
        abstract protected function moveToPosition($position);
        abstract protected function fetchNextRow();

        public function startTransaction() {
            $this->executeQuery('START TRANSACTION');
        }

        public function commit() {
            $this->executeQuery('COMMIT');
        }

        public function rollback() {
            $this->executeQuery('ROLLBACK');
        }

        public function setServer($server) {
            $this->server = $server;
            return $this;
        }

        public function setPort($port) {
            $this->port = $port;
            return $this;
        }

        public function setUsername($username) {
            $this->username = $username;
            return $this;
        }

        public function setPassword($password) {
            $this->password = $password;
            return $this;
        }

        public function setDatabase($database) {
            $this->database = $database;
            return $this;
        }

        protected function isSelectQuery($sql) {
            if (substr(trim(strtolower($sql)), 0, 6) == 'select') {
                $this->resultSet = mysqli_query($this->connection, $sql);

                if ($this->resultSet === false) {
                    $this->numRows = -1;
                    error_log('Erro ao executar SQL: ' . mysqli_error($this->connection));
                    return false;
                }

                $this->updateNumRows();
                return $this->resultSet;
            } else {
                $this->numRows = -1;
                return false;
            }
        }

        public function getNumRows() {
            return $this->numRows;
        }

        public function moveTo($position = 0) {
            $this->currentRow = false;
            $this->moveToPosition($position);
            $this->currentPosition = $position;

            return $this->currentRow;
        }

        public function first() {
            return $this->moveTo(0);
        }

        public function next() {
            $this->currentRow = false;
            $this->fetchNextRow();
            $this->currentPosition++;

            return $this->currentRow;
        }

        public function previous() {
            return $this->moveTo($this->currentPosition - 1);
        }

        public function last() {
            return $this->moveTo($this->numRows - 1);
        }

        public function getCurrentRowData() {
            return $this->currentRow;
        }

        public function getLastError() {
            return "[$this->dbType]: {$this->lastError}";
        }

    }

    /**
     * Classe para o banco de dados MySQL (mysql)
     */
    class MySQL extends DataBase {
        public function __construct() {
            $this->dbType = 'mysql';
        }

        public function connect() {
            $this->connection = mysqli_connect($this->server, $this->username, $this->password, $this->database, $this->port);

            if ($this->connection === false) {
                $this->lastError = 'Erro ao conectar ao banco de dados: ' . mysqli_connect_error();
                die($this->lastError);
            }

            return $this->connection;
        }

        public function executeQuery($sql) {
            if ($this->connection !== false) {
                $result = mysqli_query($this->connection, $sql);
                if ($result === false) {
                    $this->lastError = 'Erro ao executar SQL: ' . mysqli_error($this->connection);
                    error_log($this->lastError);
                } else {
                    return $this->isSelectQuery($sql);
                }
            }
            return false;
        }

        protected function updateNumRows() {
            if ($this->resultSet !== false) {
                $this->numRows = mysqli_num_rows($this->resultSet);
            } else {
                $this->numRows = -1;
            }
        }

        protected function moveToPosition($position) {
            if ($this->resultSet !== false) {
                if ($this->resultSet->data_seek($position) !== false) {
                    $this->currentRow = $this->resultSet->fetch_assoc();
                }
            }
        }

        protected function fetchNextRow() {
            if ($this->resultSet !== false) {
                $this->currentRow = $this->resultSet->fetch_assoc();
            }
        }

        public function close() {
            if ($this->connection !== false) {
                mysqli_close($this->connection);
            }
        }
    }
?>

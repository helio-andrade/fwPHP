<?php
/**
 * Classe abstrata para gerenciamento do banco de dados
 * @abstract
 */
abstract class BancoDados {
    protected $_tipo;
    protected $_servidor = 'localhost';
    protected $_porta = 0;
    protected $_usuario;
    protected $_senha;
    protected $_banco;
    protected $_conn = false;
    protected $_dataset = false;
    protected $_numrows = -1;

    abstract public function conectar();

    abstract public function executaSQL($_sql);

    abstract protected function setNumRows();

    public function startTransaction() {
        $this->executaSQL('START TRANSACTION');
    }

    public function commit() {
        $this->executaSQL('COMMIT');
    }

    public function rollback() {
        $this->executaSQL('ROLLBACK');
    }

    public function setServidor($servidor) {
        $this->_servidor = $servidor;
        return $this;
    }

    public function setPorta($porta) {
        $this->_porta = $porta;
        return $this;
    }

    public function setUsuario($usuario) {
        $this->_usuario = $usuario;
        return $this;
    }

    public function setSenha($senha) {
        $this->_senha = $senha;
        return $this;
    }

    public function setBanco($banco) {
        $this->_banco = $banco;
        return $this;
    }

    protected function isSELECT($_sql) {
        if (substr(trim(strtolower($_sql)),0,6) == 'select'){

            // Guardamos o dataset
            $this->_dataset = $_res;

            // Buscamos o número de registros no dataset
            $this->setNumRows();

            return true;
        } else{
            $this->_numrows = -1;
            return false;
        }
    }

    public function getNumRows(){
        return $this->_numrows;
    }
}

/**
 * Classe para gerenciamento do banco de dados MySQL (mysql)
 */
class Mysql extends BancoDados {
    public function __construct() {
        $this->_tipo = 'mysql';
    }

    public function conectar() {
        $_strconn = "host={$this->_servidor} ";

        if (!empty($this->_porta)) {
            $_strconn .= "port={$this->_porta} ";
        }

        $_strconn .= "dbname={$this->_banco} ";
        $_strconn .= "user={$this->_usuario} ";

        if (!empty($this->_senha)) {
            $_strconn .= "password={$this->_senha} ";
        }

        $this->_conn = mysqli_connect($this->_servidor, $this->_usuario, $this->_senha, $this->_banco, $this->_porta);
        return $this->_conn;
    }

    public function executaSQL($_sql) {
        if ($this->_conn !== false) {
            $_res = mysqli_query($this->_conn, $_sql);
            return $_res;
        } else {
            return false;
        }
    }

    protected function setNumRows(){
        $this->_numrows = ($this->_dataset != false ? mysqli_num_rows($this->_dataset) : 0);
    }
}
?>

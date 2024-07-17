<?php
/**
 * Classe abstrata para gerenciamento do banco de dados
 * @abstract
 */
abstract class DataBase {
    protected $_tipo;
    protected $_servidor = 'localhost';
    protected $_porta = 0;
    protected $_usuario;
    protected $_senha;
    protected $_banco;
    protected $_conn = false;
    protected $_dataset = false;
    protected $_numrows = -1;
    protected $_tupla = false;
    protected $_posatual = -1;

    abstract public function conectar();
    abstract public function executaSQL($_sql);
    abstract protected function setNumRows();
    abstract protected function navegaInterno($_pos);
    abstract protected function proximoInterno();

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
        if (substr(trim(strtolower($_sql)), 0, 6) == 'select') {
            $this->_dataset = mysqli_query($this->_conn, $_sql);

            if ($this->_dataset === false) {
                $this->_numrows = -1;
                error_log('Erro ao executar SQL: ' . mysqli_error($this->_conn));
                return false;
            }

            $this->setNumRows();

            return true;
        } else {
            $this->_numrows = -1;
            return false;
        }
    }

    public function getNumRows() {
        return $this->_numrows;
    }

    public function navega($_pos = 0) {
        $this->_tupla = false;
        $this->navegaInterno($_pos);
        $this->_posatual = $_pos;

        return $this->_tupla;
    }

    public function primeiro() {
        return $this->navega(0);
    }

    public function proximo() {
        $this->_tupla = false;
        $this->proximoInterno();
        $this->_posatual++;

        return $this->_tupla;
    }

    public function anterior() {
        return $this->navega($this->_posatual - 1);
    }

    public function ultimo() {
        return $this->navega($this->_numrows - 1);
    }

    public function getDadosAtual() {
        return $this->_tupla;
    }
}

/**
 * Classe para o banco de dados MySQL (mysql)
 */
class Mysql extends DataBase {
    public function __construct() {
        $this->_tipo = 'mysql';
    }

    public function conectar() {
        $this->_conn = mysqli_connect($this->_servidor, $this->_usuario, $this->_senha, $this->_banco, $this->_porta);

        if ($this->_conn === false) {
            die('Erro ao conectar ao banco de dados: ' . mysqli_connect_error());
        }

        return $this->_conn;
    }

    public function executaSQL($_sql) {
        if ($this->_conn !== false) {
            $_res = mysqli_query($this->_conn, $_sql);
            if ($_res === false) {
                error_log('Erro ao executar SQL: ' . mysqli_error($this->_conn));
            } else {
                if ($this->isSELECT($_sql)) {
                    return $_res;
                }
            }
        }
        return false;
    }

    protected function setNumRows() {
        if ($this->_dataset !== false) {
            $this->_numrows = mysqli_num_rows($this->_dataset);
        } else {
            $this->_numrows = -1;
        }
    }

    protected function navegaInterno($_pos) {
        if ($this->_dataset !== false) {
            if ($this->_dataset->data_seek($_pos) !== false) {
                $this->_tupla = $this->_dataset->fetch_assoc();
            }
        }
    }

    protected function proximoInterno() {
        if ($this->_dataset !== false) {
            $this->_tupla = $this->_dataset->fetch_assoc();
        }
    }
}
?>

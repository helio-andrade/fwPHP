<?php
    /**
     * Classe para gerenciamento do banco de dados PostgreSQL (pgsql)
     * @abstract
     */
    
     abstract class BancoDados{
        protected $_tipo = null;
        protected $_servidor = 'localhost';
        protected $_porta = 0;
        protected $_usuario;
        protected $_senha;
        protected $_banco;
        protected $_conn = false;

        abstract public function conectar();

        abstract public function executaSQL($_sql);

        public function setServidor($servidor){
            $this->_servidor = $servidor;
        }

        public function setPorta($porta){
            $this->_porta = $porta;
        }

        public function setUsuario($usuario){
            $this->_usuario = $usuario;
        }

        public function setSenha($senha){
            $this->_senha = $senha;
        }

        public function setBanco($banco){
            $this->_banco = $banco;
        }
    } // Fim da classe BancoDados

    /**
     * Classe para gerenciamento do banco de dados PostgreSQL (pgsql)
     */
    
    class Pgsql extends BancoDados{
        public function __construct(){
            $this->_tipo = 'pgsql';
        }

        public function conectar(){
            $_strconn = "host={$this->_servidor} ";

            if ($this->_porta !== null && $this->_porta !== ""){
                $_strconn .= "port={$this->_porta} ";
            }

            $_strconn .= "dbname={$this->_banco} ";
            $_strconn .= "user={$this->_usuario} ";
            
            if ($this->_senha !== null && $this->_senha !== ""){
                $_strconn .= "password={$this->_senha} ";
            }

            $this->_conn = @pg_connect($_strconn);
            return $this->_conn;
        }

        public function executaSQL($_sql) {
            if ($this->_conn !== false) {
                $_res = pg_query($this->_conn, $_sql);
        
                if ($_res !== false) {
                    return $_res;
                } else {
                    // Lidar com erro na execução da consulta
                    return false;
                }
            } else {
                return false;
            }
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

            if ($this->_porta !== null && $this->_porta !== "") {
                $_strconn .= "port={$this->_porta} ";
            }

            $_strconn .= "dbname={$this->_banco} ";
            $_strconn .= "user={$this->_usuario} ";

            if ($this->_senha !== null && $this->_senha !== "") {
                $_strconn .= "password={$this->_senha} ";
            }

            $this->_conn = mysqli_connect($_strconn);
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
        
    }

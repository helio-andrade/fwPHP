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

        abstract public function Conectar();

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
    }

    /**
     * Classe para gerenciamento do banco de dados PostgreSQL (pgsql)
     */
    
    class pgsql extends BancoDados{
        public function __construct(){
            $this->_tipo = 'pgsql';
        }

        public function Conectar(){
            $_strconn = "host={$this->_servidor} ";

            if ($this->_porta !== null && $this->_porta !== ""){
                $_strconn .= "port={$this->_porta} ";
            }

            $_strconn .= "dbname={$this->_banco} ";
            $_strconn .= "user={$this->_usuario} ";
            
            if ($this->_senha !== null && $this->_senha !== ""){
                $_strconn .= "password={$this->_senha} ";
            }

            $this->_conn = pg_connect($_strconn);
            return $this->_conn;
        }
    }

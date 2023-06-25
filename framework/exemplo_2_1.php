<?php
    /**
     * Exemplo de utilização da classe banco de dados
     * e suas descendentes
     */

    include_once("classes/classe_bancodados.inc.php");

    $_bd = new pgsql();
    $_bd->setServidor('localhost');
    $_bd->setPorta(5432);
    $_bd->setBanco('nome_do_banco'); 
    $_bd->setUsuario('usuario');
    $_bd->setSenha('senha');

    var_dump($_bd->Conectar());

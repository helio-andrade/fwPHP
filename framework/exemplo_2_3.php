<?php
	/**
	 *  Exemplo de utilização do controle de transações
	 *  1.o executamos mudanças permanentes
	 * */

	include_once("classes/classe_bancodados.inc.php");

	$servidor = 'localhost';
	$porta = 5432;
	$banco = 'siteweb';
	$usuario = 'postgres';
	$senha = '';

	$_bd = new Pgsql();
	$_bd->setServidor($servidor);
	$_bd->setPorta($porta);
	$_bd->setBanco($banco);
	$_bd->setUsuario($usuario);
	$_bd->setSenha($senha);
	$_bd->conectar();

	$_bd->startTransaction();
	$_sql = "insert into tab_teste values(10, 'teste 10', 15.1)";
	$_bd->executaSQL($_sql);
	$_bd->commit();
?>

<?php
	/**
	 * Exemplo de utilização do controle de transações
	 * 2. Executamos algumas mudanças e depois descartamos os comandos
	 */

	include_once("classes/classe_bancodados.inc.php");

	// Configurações do banco de dados
	$config = [
	    'servidor' => 'localhost',
	    'porta' => 3306,
	    'banco' => 'siteweb',
	    'usuario' => 'root',
	    'senha' => 'root',
	];

	try {
	    // Criando uma instância da classe Mysql e configurando-a
	    $_bd = new Mysql();
	    $_bd->setServidor($config['servidor'])
	        ->setPorta($config['porta'])
	        ->setBanco($config['banco'])
	        ->setUsuario($config['usuario'])
	        ->setSenha($config['senha'])
	        ->conectar();

	    // Iniciando transação
	    $_bd->startTransaction();

	    // Consulta SQL para inserir dados
	    $_sql_insert = "INSERT INTO tab_teste VALUES (11, 'teste 11', 21.7)";
	    $_bd->executaSQL($_sql_insert);

	    // Consulta SQL para excluir dados
	    $_sql_delete = "DELETE FROM tab_teste";
	    $_bd->executaSQL($_sql_delete);

	    // Descartando transação
	    $_bd->rollback();

	    echo "Transação descartada com sucesso!";
	} catch (Exception $e) {
	    echo "Erro ao executar transação: " . $e->getMessage();
	}
?>

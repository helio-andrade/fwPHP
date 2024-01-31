<?php
/**
 * Exemplo de utilização do controle de transações
 * 1. Executamos mudanças permanentes
 */

include_once("classes/classe_bancodados.inc.php");

// Configurações do banco de dados
$config = [
    'servidor' => 'localhost',
    'porta' => 5432,
    'banco' => 'siteweb',
    'usuario' => 'postgres',
    'senha' => '',
];

// Criando uma instância da classe Pgsql e configurando-a
$_bd = new Pgsql();
$_bd->setServidor($config['servidor'])
    ->setPorta($config['porta'])
    ->setBanco($config['banco'])
    ->setUsuario($config['usuario'])
    ->setSenha($config['senha'])
    ->conectar();

// Iniciando transação
$_bd->startTransaction();

// Consulta SQL para inserir dados
$_sql = "INSERT INTO tab_teste (codigo, descricao, valor) VALUES (12, '{Teste 10}', 15)";

var_dump($_sql);

// Executando a consulta SQL
$_bd->executaSQL($_sql);

// Confirmar transação
$_bd->commit();
?>
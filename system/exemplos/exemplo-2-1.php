<?php
/**
 * Example usage of the Database class
 * and its descendants
 */

// Ajuste o caminho conforme sua estrutura de pastas
include_once(__DIR__ . '/../../system/classes/Database.php');

// Cria uma instância da classe MySQL
$db = new MySQL();

// Configurações de conexão
$db->setHost('localhost');
$db->setDatabase('siteweb');
$db->setUsername('root');
$db->setPassword('root');
$db->setPort(3306);

// Conecta e exibe informações sobre a conexão
// var_dump($db->connect());
print_r($db->connect());

echo '<br />Deu certo?!';

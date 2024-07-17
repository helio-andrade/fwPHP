<?php
/**
 *  Exemplo para utilização da recuperação de
 * registro no banco de dados.
 * 
 */

// Inclui a classe de gerenciamento de banco de dados
include_once("classes/DataBase.php");

// Configurações do banco de dados
$config = [
    'server' => 'localhost',
    'port' => 3306,
    'database' => 'siteweb',
    'username' => 'root',
    'password' => 'root',
];

// Criando uma instância da classe MySQL e configurando-a
$db = new MySQL();
$db->setServer($config['server'])
    ->setPort($config['port'])
    ->setDatabase($config['database'])
    ->setUsername($config['username'])
    ->setPassword($config['password'])
    ->connect();

$sql = "SELECT * FROM tab_teste";
$result = $db->executeQuery($sql);
if ($result === false) {
    die('Erro ao executar a consulta SQL.');
}

echo "Numero de registros retornados pelo SELECT: ";
echo $db->getNumRows() . "<br>";
echo "<table border=1 cellpadding=5 width=400>
<tr><th>Código</th><th>Descrição</th><th>Valor</th></tr>";

while ($db->next()) {
    $row = $db->getCurrentRowData();
    echo "<tr><td>" . htmlspecialchars($row['codigo']) . "</td>
          <td>" . htmlspecialchars($row['descricao']) . "</td>
          <td align=right>" . htmlspecialchars($row['valor']) . "</td></tr>";
}

echo "</table>";
?>

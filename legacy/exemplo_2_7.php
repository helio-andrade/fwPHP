<?php
    /**
     *  Exemplo de tratamento de exceção
     *  no banco de dados. 
     */
    include_once("classes/DataBase.php");

    // Instanciando a classe de banco de dados MySQL
    $database = new MySQL();

    // Configuração de conexão com dados incorretos para forçar um erro
    $database->setServer('localhost')
        ->setPort(3306)
        ->setDatabase('siteweb')
        ->setUsername('root')
        ->setPassword('root');

    $database->connect() or die($database->getLastError());

    $sql = "SELECT * FROM tab_teste_Err";   // <---- Erro proposital
    $database->executeQuery($sql) or die($database->getLastError());

    echo "Numero de registros retornados pelo SELECT: ";
    echo $database->getNumRows() . "<br>";
    echo "<table border=1 cellpadding=5 width=400>
    <tr><th>Código</th><th>Descrição</th><th>Valor</th></tr>";

    while ($database->next()) {
    $row = $database->getCurrentRowData();
    echo "<tr><td>" . htmlspecialchars($row['codigo']) . "</td>
          <td>" . htmlspecialchars($row['descricao']) . "</td>
          <td align=right>" . htmlspecialchars($row['valor']) . "</td></tr>";
    }

    echo "</table>";
?>

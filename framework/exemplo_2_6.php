<?php
    include_once("classes/DataBase.php");

    // Instanciando a classe de banco de dados MySQL
    $database = new MySQL();

    // Configuração de conexão com dados incorretos para forçar um erro
    $database->setServer('localhost')
        ->setPort(3306)
        ->setDatabase('sitewebb') // <---- Erro proposital
        ->setUsername('root')
        ->setPassword('root');

    $database->connect();
?>

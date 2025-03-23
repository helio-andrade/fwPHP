<?php

include_once(__DIR__ . '/../../system/classes/Database.php');

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tableName = $_POST['tableName'] ?? 'tab_teste';
    $mysql = new MySQL();
    $mysql->setHost('localhost');
    $mysql->setDatabase('siteweb');
    $mysql->setUsername('root');
    $mysql->setPassword('root');
    $mysql->setPort(3306);
    $mysql->connect();

    $checkResult = $mysql->executeSQL("SHOW TABLES LIKE '{$tableName}'");

    if ($checkResult && $checkResult->num_rows > 0) {
        $message = "A tabela {$tableName} já existe!";
    } else {
        $createSQL = "CREATE TABLE IF NOT EXISTS {$tableName} (
            codigo INT AUTO_INCREMENT PRIMARY KEY, 
            descricao VARCHAR(20),
            valor FLOAT
        )";
        if ($mysql->executeSQL($createSQL)) {
            $message = "Tabela {$tableName} criada com sucesso!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Escolher Tabela</title>
</head>
<body>
    <form method="post">
        <label for="tableName">Nome da Tabela:</label>
        <input type="text" name="tableName" id="tableName" />
        <button type="submit">Criar Tabela</button>
    </form>

    <?php if (!empty($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
</body>
</html>

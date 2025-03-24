<?php

include_once(__DIR__ . '/../../system/classes/Database.php');

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tableName = trim($_POST['tableName'] ?? '');

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
        $createTable = "CREATE TABLE IF NOT EXISTS {$tableName} (
            codigo INT AUTO_INCREMENT PRIMARY KEY,
            descricao VARCHAR(20),
            valor FLOAT
        )";
        if ($mysql->executeSQL($createTable)) {
            $message = "Tabela <b>{$tableName}</b> criada com sucesso!";

            $registros = [
                ['Livro PHP', 45.80],
                ['Livro Java', 100.80],
                ['Python', 35.22],
                ['C++', 25.69],
                ['Linguagem C', 47.89],
                ['C++ Builder', 99.99]
            ];

            foreach ($registros as $registro) {
                $desc = $registro[0];
                $val = $registro[1];
                $insertData = "INSERT INTO {$tableName} (descricao, valor) VALUES ('$desc', $val)";
                $mysql->executeSQL($insertData);
            }

            $message .= " <br>Dados inseridos com sucesso!";
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
        <input type="text" name="tableName" id="tableName" required />
        <button type="submit">Criar Tabela</button>
    </form>

    <?php if (!empty($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
</body>
</html>

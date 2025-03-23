<?php
/**
 * Exemplo de utilização da classe banco de dados
 * e suas descendentes
 */

include_once("classes/DataBase.php");

$servidor = isset($_POST['servidor']) ? $_POST['servidor'] : 'localhost';
$porta = isset($_POST['porta']) ? $_POST['porta'] : 3306;
$banco = isset($_POST['banco']) ? $_POST['banco'] : 'siteweb';
$usuario = isset($_POST['usuario']) ? $_POST['usuario'] : 'root';
$senha = isset($_POST['senha']) ? $_POST['senha'] : 'root';

$_bd = new MySQL();
$_bd->setServer($servidor);
$_bd->setPort($porta);
$_bd->setDatabase($banco); 
$_bd->setUsername($usuario);
$_bd->setPassword($senha);

$conectado = $_bd->connect();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Exemplo de Utilização do Banco de Dados</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1, h2, p {
            text-align: center;
        }

        .error-message {
            margin-bottom: 20px;
            color: red;
            font-weight: bold;
        }

        .success-message {
            margin-bottom: 20px;
            color: green;
            font-weight: bold;
        }

        form {
            max-width: 300px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="number"],
        input[type="password"] {
            width: 100%;
            padding: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        button[type="submit"] {
            padding: 10px 20px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Exemplo de Utilização do Banco de Dados</h1>

    <?php if ($conectado): ?>
        <p class="success-message">Conexão com o banco de dados estabelecida com sucesso!</p>
    <?php else: ?>
        <p class="error-message">Erro ao conectar ao banco de dados.</p>
    <?php endif; ?>

    <h2>Configurações do Banco de Dados</h2>
    <form method="POST" action="">
        <label for="servidor">Servidor:</label>
        <input type="text" id="servidor" name="servidor" value="<?= htmlspecialchars($servidor) ?>"><br>

        <label for="porta">Porta:</label>
        <input type="number" id="porta" name="porta" value="<?= htmlspecialchars($porta) ?>"><br>

        <label for="banco">Banco de Dados:</label>
        <input type="text" id="banco" name="banco" value="<?= htmlspecialchars($banco) ?>"><br>

        <label for="usuario">Usuário:</label>
        <input type="text" id="usuario" name="usuario" value="<?= htmlspecialchars($usuario) ?>"><br>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" value="<?= htmlspecialchars($senha) ?>"><br>

        <button type="submit">Conectar</button>
    </form>
</body>
</html>

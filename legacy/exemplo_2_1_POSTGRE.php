<?php
    /**
     * Exemplo de utilização da classe banco de dados
     * e suas descendentes
     */

    include_once("classes/classe_bancodados.inc.php");

    $servidor = isset($_POST['servidor']) ? $_POST['servidor'] : 'localhost';
    $porta = isset($_POST['porta']) ? $_POST['porta'] : 5432;
    $banco = isset($_POST['banco']) ? $_POST['banco'] : 'siteweb';
    $usuario = isset($_POST['usuario']) ? $_POST['usuario'] : 'postgres';
    $senha = isset($_POST['senha']) ? $_POST['senha'] : '';

    $_bd = new Pgsql();
    $_bd->setServidor($servidor);
    $_bd->setPorta($porta);
    $_bd->setBanco($banco); 
    $_bd->setUsuario($usuario);
    $_bd->setSenha($senha);

    $conectado = $_bd->conectar();
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
        <input type="text" id="servidor" name="servidor" value="<?= $servidor ?>"><br>

        <label for="porta">Porta:</label>
        <input type="number" id="porta" name="porta" value="<?= $porta ?>"><br>

        <label for="banco">Banco de Dados:</label>
        <input type="text" id="banco" name="banco" value="<?= $banco ?>"><br>

        <label for="usuario">Usuário:</label>
        <input type="text" id="usuario" name="usuario" value="<?= $usuario ?>"><br>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" value="<?= $senha ?>"><br>

        <button type="submit">Conectar</button>
    </form>
</body>
</html>

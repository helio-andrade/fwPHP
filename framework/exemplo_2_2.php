<?php
/**
 * Exemplo de utilização do método executaSQL
 * 
 */
include_once("classes/classe_bancodados.inc.php");

$servidor = 'localhost';
$porta = 5432;
$banco = 'siteweb';
$usuario = 'postgres';
$senha = '';

$_bd = new Pgsql();
$_bd->setServidor($servidor);
$_bd->setPorta($porta);
$_bd->setBanco($banco);
$_bd->setUsuario($usuario);
$_bd->setSenha($senha);
$_bd->conectar();

$mensagem = '';

if (isset($_POST['tabela'])) {
    $tabela = $_POST['tabela'];

    $sql = "CREATE TABLE IF NOT EXISTS $tabela (
                codigo      INT DEFAULT 0, 
                descricao   VARCHAR(20),
                valor       FLOAT,
                PRIMARY KEY (codigo)
            )";

    if ($_bd->executaSQL($sql)) {
        $mensagem .= "<div class=\"mensagem mensagem-success\">Tabela `$tabela` criada com sucesso!</div>";
    } else {
        $mensagem .= "<div class=\"mensagem mensagem-error\">Erro ao criar tabela.</div>";
    }

    $registros = array(
        array(1, 'Livro PHP', 45.80),
        array(2, 'Livro Java', 100.80),
        array(3, 'Python', 35.22),
        array(4, 'C++', 25,69)
    );

    foreach ($registros as $registro) {
        $codigo = $registro[0];
        $descricao = $registro[1];
        $valor = $registro[2];

        $sql = "INSERT INTO $tabela VALUES ($codigo, '$descricao', $valor)";
        if ($_bd->executaSQL($sql)) {
            $mensagem .= "<div class=\"mensagem mensagem-success\">Registro inserido!</div>";
        } else {
            $mensagem .= "<div class=\"mensagem mensagem-error\">Erro ao inserir registro.</div>";
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Criação de Tabela</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            text-align: center;
        }

        .container form {
            width: 300px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"] {
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

        .mensagem {
            font-weight: bold;
            margin-top: 20px;
        }

        .mensagem-success {
            color: green;
        }

        .mensagem-error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <form method="POST" action="">
            <label for="tabela">Nome da tabela:</label>
            <input type="text" id="tabela" name="tabela" required>
            <button type="submit">Criar tabela</button>
        </form>

        <?php echo $mensagem; ?>
    </div>
</body>
</html>

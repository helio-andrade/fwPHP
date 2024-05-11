<?php
    /**
     * Exemplo de utilização do método executaSQL
     * 
     */
    include_once("classes/classe_bancodados.inc.php");

    // Definições de conexão
    $configuracao = [
        'servidor' => 'localhost',
        'porta' => 3306,
        'banco' => 'siteweb',
        'usuario' => 'root',
        'senha' => 'root'
    ];

    // Instanciando a classe de banco de dados MySQL
    $_bd = new Mysql();
    $_bd->setServidor($configuracao['servidor'])
        ->setPorta($configuracao['porta'])
        ->setBanco($configuracao['banco'])
        ->setUsuario($configuracao['usuario'])
        ->setSenha($configuracao['senha']);
    $_bd->conectar();

    $mensagem = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tabela'])) {
        $tabela = $_POST['tabela'];

        // Criando tabela se não existir
        $sql = "CREATE TABLE IF NOT EXISTS $tabela (
                    codigo      INT AUTO_INCREMENT PRIMARY KEY, 
                    descricao   VARCHAR(20),
                    valor       FLOAT
                )";

        if ($_bd->executaSQL($sql)) {
            $mensagem .= "<div class=\"mensagem mensagem-success\">Tabela `$tabela` criada com sucesso!</div>";
        } else {
            $mensagem .= "<div class=\"mensagem mensagem-error\">Erro ao criar tabela.</div>";
        }

        // Inserindo registros de exemplo
        $registros = [
            ['Livro PHP', 45.80],
            ['Livro Java', 100.80],
            ['Python', 35.22],
            ['C++', 25.69]
        ];

        foreach ($registros as $registro) {
            $descricao = $registro[0];
            $valor = $registro[1];

            $sql = "INSERT INTO $tabela (descricao, valor) VALUES ('$descricao', $valor)";
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

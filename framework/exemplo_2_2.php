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

    if (isset($_POST['tabela'])) {
        $tabela = $_POST['tabela'];

        $sql = "CREATE TABLE IF NOT EXISTS $tabela (
                    codigo      INT DEFAULT 0, 
                    descricao   VARCHAR(20),
                    valor       FLOAT,
                    PRIMARY KEY (codigo)
                )";
        
        if ($_bd->executaSQL($sql)) {
            echo "Tabela `$tabela` criada com sucesso! <br />";
        } else {
            echo "Erro ao criar tabela. <br />";
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Criação de Tabela</title>
</head>
<body>
    <form method="POST" action="">
        <label for="tabela">Nome da tabela:</label>
        <input type="text" id="tabela" name="tabela" required>
        <button type="submit">Criar tabela</button>
    </form>
</body>
</html>

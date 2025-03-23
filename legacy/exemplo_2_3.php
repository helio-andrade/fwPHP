<?php
    /**
     * Exemplo de utilização do controle de transações
     * 1. Executamos mudanças permanentes
     */

    include_once("classes/classe_bancodados.inc.php");

    // Configurações do banco de dados
    $config = [
        'servidor' => 'localhost',
        'porta' => 3306,
        'banco' => 'siteweb',
        'usuario' => 'root',
        'senha' => 'root',
    ];

    // Criando uma instância da classe Mysql e configurando-a
    $_bd = new Mysql();
    $_bd->setServidor($config['servidor'])
        ->setPorta($config['porta'])
        ->setBanco($config['banco'])
        ->setUsuario($config['usuario'])
        ->setSenha($config['senha'])
        ->conectar();

    // Iniciando transação
    $_bd->startTransaction();

    try {
        // Consulta SQL para criar a tabela tab_teste
        $sql_create_table = "
            CREATE TABLE IF NOT EXISTS tab_teste (
                codigo INT AUTO_INCREMENT PRIMARY KEY,
                descricao VARCHAR(255),
                valor FLOAT
            )
        ";

        // Executando a consulta SQL para criar a tabela
        $_bd->executaSQL($sql_create_table);

        // Consulta SQL para inserir dados
        $codigo = 12;
        $descricao = '{Teste 10}';
        $valor = 15;
        $sql_insert_data = "INSERT INTO tab_teste (codigo, descricao, valor) VALUES ($codigo, '$descricao', $valor)";

        // Executando a consulta SQL para inserir os dados
        $_bd->executaSQL($sql_insert_data);

        // Confirmar transação
        $_bd->commit();

        echo "Transação concluída com sucesso!";
    } catch (Exception $e) {
        // Rolback da transação em caso de erro
        $_bd->rollback();

        echo "Erro ao executar transação: " . $e->getMessage();
    }
?>

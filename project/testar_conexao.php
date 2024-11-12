<?php
// Incluir o arquivo de conexão
include 'conexao.php';

// Testar a conexão
if ($conn) {
    echo "Conexão ao banco de dados realizada com sucesso!";
} else {
    echo "Falha na conexão ao banco de dados.";
}
?>

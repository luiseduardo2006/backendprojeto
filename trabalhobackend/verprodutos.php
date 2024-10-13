<?php
header('Content-Type: application/json');

// Conexão com o banco de dados
$servername = "localhost"; // Substitua pelo seu servidor
$username = "usuario";      // Substitua pelo seu usuário do banco de dados
$password = "senha";        // Substitua pela sua senha do banco de dados
$dbname = "nome_do_banco";  // Substitua pelo seu nome do banco de dados

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Consulta para obter produtos
$sql = "SELECT id, nome, descricao, preco FROM produtos"; // Substitua 'produtos' pelo nome da sua tabela
$result = $conn->query($sql);

$produtos = array();

if ($result->num_rows > 0) {
    // Saída de cada linha
    while ($row = $result->fetch_assoc()) {
        $produtos[] = $row;
    }
}

// Retornar os produtos em formato JSON
echo json_encode($produtos);

// Fechar conexão
$conn->close();
?>

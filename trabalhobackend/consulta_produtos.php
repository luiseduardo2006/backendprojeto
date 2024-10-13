<?php
include 'conexao.php'; // Arquivo para conexão com o banco de dados

// Consulta para obter todos os produtos
$query = "SELECT * FROM produtos"; // Certifique-se de que 'produtos' é o nome correto da tabela
$result = $conn->query($query);

// Inicializa um array para armazenar os produtos
$produtos = [];

// Loop para buscar os produtos da consulta
while ($row = $result->fetch_assoc()) {
    $produtos[] = [
        'nome' => $row['nome'],  // Nome do produto
        'preco' => $row['preco']  // Preço do produto
    ];
}

// Retorna os produtos em formato JSON
header('Content-Type: application/json');
echo json_encode($produtos);

// Fechar a conexão com o banco de dados
$conn->close(); // Adicione esta linha para garantir que a conexão seja fechada
?>

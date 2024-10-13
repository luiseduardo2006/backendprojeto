<?php
include 'conexao.php'; // Arquivo para conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];

    // Insere o novo produto no banco de dados
    $query = "INSERT INTO produtos (nome, preco) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $nome, $preco);

    if ($stmt->execute()) {
        echo "<script>alert('Produto adicionado com sucesso!'); window.location.href='produtos.html';</script>";
    } else {
        echo "<script>alert('Erro ao adicionar produto.'); window.location.href='produtos.html';</script>";
    }
}
?>

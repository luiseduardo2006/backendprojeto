<?php
include 'conexao.php'; // Arquivo para conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $login = $_POST['login'];
    $senha = $_POST['senha'];

    // Verifica se o login já existe
    $query = "SELECT * FROM usuarios WHERE login = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Login já existe!'); window.location.href='cadastro.html';</script>";
    } else {
        // Insere o novo usuário no banco de dados
        $query = "INSERT INTO usuarios (nome, email, login, senha) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssss", $nome, $email, $login, $senha);

        if ($stmt->execute()) {
            echo "<script>alert('Usuário cadastrado com sucesso!'); window.location.href='login.html';</script>";
        } else {
            echo "<script>alert('Erro ao cadastrar usuário.'); window.location.href='cadastro.html';</script>";
        }
    }
}
?>

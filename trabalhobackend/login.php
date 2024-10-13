<?php
session_start();
include 'conexao.php'; // Arquivo para conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $senha = $_POST['senha'];

    // Consulta para verificar se o login e senha estão corretos
    $query = "SELECT * FROM usuarios WHERE login = ? AND senha = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $login, $senha);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Login bem-sucedido
        $_SESSION['login'] = $login;
        header("Location: painel.php"); // Redireciona para o painel principal
    } else {
        // Falha no login
        echo "<script>alert('Login ou senha inválidos!'); window.location.href='login.html';</script>";
    }
}
?>

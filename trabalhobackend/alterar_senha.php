<?php
session_start();
include 'conexao.php'; // Arquivo para conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_SESSION['login']; // Usuário logado
    $senha_atual = $_POST['senha_atual'];
    $nova_senha = $_POST['nova_senha'];

    // Verifica se a senha atual está correta
    $query = "SELECT * FROM usuarios WHERE login = ? AND senha = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $login, $senha_atual);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Atualiza a senha
        $query = "UPDATE usuarios SET senha = ? WHERE login = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $nova_senha, $login);

        if ($stmt->execute()) {
            echo "<script>alert('Senha alterada com sucesso!'); window.location.href='painel.php';</script>";
        } else {
            echo "<script>alert('Erro ao alterar a senha.'); window.location.href='alterar_senha.html';</script>";
        }
    } else {
        echo "<script>alert('Senha atual incorreta!'); window.location.href='alterar_senha.html';</script>";
    }
}
?>

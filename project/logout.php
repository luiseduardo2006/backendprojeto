<?php
session_start(); // Inicia a sessão
include 'conexao.php'; // Inclui a conexão com o banco de dados

// Função para registrar o log
function registrarLog($conn, $idUsuario, $acao) {
    $sql = "INSERT INTO log_master (ID_Usuario, Data_Hora, Acao) VALUES (:idUsuario, NOW(), :acao)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
    $stmt->bindParam(':acao', $acao, PDO::PARAM_STR);
    $stmt->execute();
}

// Verifica se há uma sessão ativa
if (isset($_SESSION['id_usuario'])) {
    $id_usuario = $_SESSION['id_usuario'];

    // Registra o log de logout
    registrarLog($conn, $id_usuario, 'Logout realizado');

    session_unset(); // Remove todas as variáveis de sessão
    session_destroy(); // Destroi a sessão
}

// Redireciona para a página de login ou inicial
header("Location: login.html"); // Altere para a página desejada após o logout
exit();

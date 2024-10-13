<?php
session_start();
include 'conexao.php'; // Arquivo para conexão com o banco de dados

// Verifica se o usuário é master
if ($_SESSION['perfil'] !== 'master') {
    echo "Acesso negado!";
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Exclui o usuário com o ID fornecido
    $query = "DELETE FROM usuarios WHERE id = ? AND perfil = 'comum'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Usuário excluído com sucesso!";
    } else {
        echo "Erro ao excluir usuário.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "ID do usuário não fornecido.";
}
?>

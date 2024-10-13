<?php
session_start();
include 'conexao.php'; // Arquivo para conexão com o banco de dados

// Verifica se o usuário é master
if ($_SESSION['perfil'] !== 'master') {
    echo "<script>alert('Acesso negado!'); window.location.href='index.html';</script>";
    exit();
}

$search = isset($_GET['search']) ? $_GET['search'] : ''; // Obtém o termo de pesquisa

// Consulta para buscar usuários comuns que contenham o termo de pesquisa no nome
$query = "SELECT id, nome, login, email FROM usuarios WHERE perfil = 'comum' AND nome LIKE ?";
$stmt = $conn->prepare($query);
$searchTerm = "%" . $search . "%";
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

// Cria um array para armazenar os resultados
$usuarios = [];

while ($row = $result->fetch_assoc()) {
    $usuarios[] = $row;
}

// Retorna os usuários em formato JSON
header('Content-Type: application/json');
echo json_encode($usuarios);

$stmt->close();
$conn->close();
?>

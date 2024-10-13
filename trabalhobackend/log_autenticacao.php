<?php
include 'conexao.php'; // Arquivo de conexão com o banco de dados

$filtro = isset($_GET['filtro']) ? $_GET['filtro'] : '';

$query = "SELECT u.nome, u.cpf, l.data_hora, l.2fa 
          FROM logs_autenticacao l
          JOIN usuarios u ON l.usuario_id = u.id
          WHERE u.nome LIKE ? OR u.cpf LIKE ?";

$stmt = $conn->prepare($query);
$searchTerm = "%{$filtro}%";
$stmt->bind_param("ss", $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

$logs = [];

while ($row = $result->fetch_assoc()) {
    $logs[] = [
        'nome' => $row['nome'],
        'cpf' => $row['cpf'],
        'data_hora' => $row['data_hora'],
        '2fa' => $row['2fa']
    ];
}

// Retorna os logs em formato JSON
header('Content-Type: application/json');
echo json_encode($logs);
?>

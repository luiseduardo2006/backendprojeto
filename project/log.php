<?php
session_start();
include 'conexao.php';

// Verifica se o usuário está logado e tem perfil Master
if (!isset($_SESSION['id_usuario']) || $_SESSION['usuario_perfil'] !== 'master') {
    header("Location: login.html");
    exit();
}

$idUsuario = $_SESSION['id_usuario'];

// Função para buscar logs com filtros
function buscarLogs($conn, $filtros = []) {
    $sql = "SELECT ID_Log, Data_Hora, ID_Usuario, Acao FROM log_master WHERE 1=1";
    $params = [];

    if (!empty($filtros['data_inicio'])) {
        $sql .= " AND Data_Hora >= :data_inicio";
        $params[':data_inicio'] = $filtros['data_inicio'];
    }
    if (!empty($filtros['data_fim'])) {
        $sql .= " AND Data_Hora <= :data_fim";
        $params[':data_fim'] = $filtros['data_fim'];
    }
    if (!empty($filtros['id_usuario'])) {
        $sql .= " AND ID_Usuario = :id_usuario";
        $params[':id_usuario'] = $filtros['id_usuario'];
    }
    if (!empty($filtros['acao'])) {
        $sql .= " AND Acao LIKE :acao";
        $params[':acao'] = '%' . $filtros['acao'] . '%';
    }

    $sql .= " ORDER BY Data_Hora DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Exportação para CSV
if (isset($_POST['exportar'])) {
    $logs = buscarLogs($conn);
    $filename = "log_atividades_" . date('Ymd') . ".csv";
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=' . $filename);

    $output = fopen('php://output', 'w');
    fputcsv($output, ['ID Log', 'Data e Hora', 'ID do Usuário', 'Descrição da Ação']);
    foreach ($logs as $log) {
        fputcsv($output, $log);
    }
    fclose($output);
    exit();
}

// Filtragem de logs
$filtros = [
    'data_inicio' => $_GET['data_inicio'] ?? '',
    'data_fim' => $_GET['data_fim'] ?? '',
    'id_usuario' => $_GET['id_usuario'] ?? '',
    'acao' => $_GET['acao'] ?? ''
];
$logs = buscarLogs($conn, $filtros);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log de Atividades - On Market</title>
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/logado.css">
    <link rel="stylesheet" href="css/consulta_produtos.css">
</head>
<body>
<header>
    <div class="logo">
        <a href="index.php"><img src="img/logo.png" alt="Logo"></a>
    </div>
    <h1 class="titulo">ON MARKET</h1>

    <nav class="menu-navegacao">
        <ul class="barra-navegacao">
            <li><a href="index.php">Home</a></li>
            <li><a href="produtos.php">Produtos</a></li>
            <li>
                <?php if (isset($_SESSION['usuario_nome'])): ?>
                    <a href="#"><?php echo htmlspecialchars($_SESSION['usuario_nome']); ?></a>
                    <ul class="sub-menu">
                        <li><a href="logout.php">Logoff</a></li>
                        <?php if ($_SESSION['usuario_perfil'] === 'master'): ?>
                            <li><a href="log.php">Log</a></li>
                            <li><a href="consulta_usuarios.php">Consulta de Usuários</a></li>
                            <li><a href="consulta_produtos.php">Consulta de Produtos</a></li>
                        <?php endif; ?>
                    </ul>
                <?php else: ?>
                    <a href="login.html">Perfil</a>
                    <ul class="sub-menu">
                        <li><a href="login.html">Login</a></li>
                        <li><a href="cadastro.html">Cadastre-se</a></li>
                    </ul>
                <?php endif; ?>
            </li>
            <li><a href="#" onclick="toggleDarkMode()"><img src="img/dark.png" alt="Modo Escuro" class="dark-icon"></a></li>
            <!-- Botões de Aumento e Diminuição do Tamanho da Fonte -->
            <li>
                    <button onclick="aumentarFonte()" class="font-size-btn">A+</button>
                    <button onclick="diminuirFonte()" class="font-size-btn">A-</button>
                </li>
        </ul>
    </nav>
</header>

<main class="container mt-5">
    <h2>Registros de Atividades</h2>

    <form method="GET" class="filtro-form">
        <label>Data Início: <input type="date" name="data_inicio" value="<?php echo htmlspecialchars($filtros['data_inicio']); ?>"></label>
        <label>Data Fim: <input type="date" name="data_fim" value="<?php echo htmlspecialchars($filtros['data_fim']); ?>"></label>
        <label>ID Usuário: <input type="text" name="id_usuario" value="<?php echo htmlspecialchars($filtros['id_usuario']); ?>"></label>
        <label>Ação: <input type="text" name="acao" value="<?php echo htmlspecialchars($filtros['acao']); ?>"></label>
        <button type="submit">Filtrar</button>
        <button type="submit" name="exportar" value="1">Exportar CSV</button>
    </form>

    <table border="1" cellpadding="10" cellspacing="0" class="log-table">
        <tr>
            <th>ID Log</th>
            <th>Data e Hora</th>
            <th>ID do Usuário</th>
            <th>Descrição da Ação</th>
        </tr>
        <?php if (!empty($logs)): ?>
            <?php foreach ($logs as $log): ?>
                <tr>
                    <td><?php echo htmlspecialchars($log['ID_Log']); ?></td>
                    <td><?php echo htmlspecialchars($log['Data_Hora']); ?></td>
                    <td><?php echo htmlspecialchars($log['ID_Usuario']); ?></td>
                    <td><?php echo htmlspecialchars($log['Acao']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">Nenhum registro de atividade encontrado.</td>
            </tr>
        <?php endif; ?>
    </table>
</main>

<script src="consulta_produtos.js"></script>
<script src="fonte.js"></script>
</body>
</html>

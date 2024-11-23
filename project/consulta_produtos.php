<?php
session_start();
include 'conexao.php';

// Verifica se o usuário está logado e é do perfil Master
if (!isset($_SESSION['id_usuario']) || $_SESSION['usuario_perfil'] !== 'master') {
    header("Location: login.html");
    exit;
}

// Funções CRUD
function buscarProdutos($conn) {
    $sql = "SELECT ID_Produto, Nome, Preco, Imagem FROM produto ORDER BY Nome ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function adicionarProduto($conn, $nome, $preco, $imagem) {
    $sql = "INSERT INTO produto (Nome, Preco, Imagem) VALUES (:nome, :preco, :imagem)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':preco', $preco);
    $stmt->bindParam(':imagem', $imagem);
    return $stmt->execute();
}

function editarProduto($conn, $id, $nome, $preco, $imagem) {
    $sql = "UPDATE produto SET Nome = :nome, Preco = :preco, Imagem = :imagem WHERE ID_Produto = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':preco', $preco);
    $stmt->bindParam(':imagem', $imagem);
    return $stmt->execute();
}

function excluirProduto($conn, $id) {
    $sql = "DELETE FROM produto WHERE ID_Produto = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
}

// Tratamento de ações CRUD
$action = isset($_GET['action']) ? $_GET['action'] : '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $imagem = $_POST['imagem'];

    if ($action == 'adicionar') {
        adicionarProduto($conn, $nome, $preco, $imagem);
    } elseif ($action == 'editar') {
        $id = $_POST['id'];
        editarProduto($conn, $id, $nome, $preco, $imagem);
    }
    header("Location: consulta_produtos.php");
    exit;
} elseif ($action == 'excluir' && isset($_GET['id'])) {
    $id = $_GET['id'];
    excluirProduto($conn, $id);
    header("Location: consulta_produtos.php");
    exit;
}

// Busca de Produtos para exibição
$produtos = buscarProdutos($conn);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Produtos - On Market</title>
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
        <h2>Produtos</h2>

        <?php if ($action == 'adicionar' || ($action == 'editar' && isset($_GET['id']))): ?>
            <?php
            $produto = ['Nome' => '', 'Preco' => '', 'Imagem' => ''];
            if ($action == 'editar') {
                $id = $_GET['id'];
                $stmt = $conn->prepare("SELECT * FROM produto WHERE ID_Produto = :id");
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $produto = $stmt->fetch(PDO::FETCH_ASSOC);
            }
            ?>
            <form action="consulta_produtos.php?action=<?php echo $action; ?>" method="POST">
                <?php if ($action == 'editar'): ?>
                    <input type="hidden" name="id" value="<?php echo $produto['ID_Produto']; ?>">
                <?php endif; ?>
                <label for="nome">Nome:</label>
                <input type="text" name="nome" id="nome" value="<?php echo htmlspecialchars($produto['Nome']); ?>" required>
                
                <label for="preco">Preço:</label>
                <input type="number" name="preco" id="preco" value="<?php echo htmlspecialchars($produto['Preco']); ?>" required>
                
                <label for="imagem">Imagem (URL):</label>
                <input type="text" name="imagem" id="imagem" value="<?php echo htmlspecialchars($produto['Imagem']); ?>">
                
                <button type="submit"><?php echo ucfirst($action); ?> Produto</button>
                <a href="consulta_produtos.php">Cancelar</a>
            </form>
        <?php else: ?>
            <ul class="lista-produtos">
                <?php foreach ($produtos as $produto): ?>
                <li>
                    <img src="<?php echo htmlspecialchars($produto['Imagem']); ?>" alt="<?php echo htmlspecialchars($produto['Nome']); ?>" class="produto-imagem">
                    <div class="produto-info">
                        <h3><?php echo htmlspecialchars($produto['Nome']); ?></h3>
                        <p>Preço: R$<?php echo number_format($produto['Preco'], 2, ',', '.'); ?></p>
                        <div class="produto-acoes">
                            <a href="consulta_produtos.php?action=editar&id=<?php echo $produto['ID_Produto']; ?>" class="btn-editar">Editar</a>
                            <a href="consulta_produtos.php?action=excluir&id=<?php echo $produto['ID_Produto']; ?>" class="btn-excluir" onclick="return confirm('Tem certeza que deseja excluir este produto?')">Excluir</a>
                        </div>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
            <a href="consulta_produtos.php?action=adicionar" class="btn-adicionar">Adicionar Novo Produto</a>
        <?php endif; ?>
    </main>

    <script src="consulta_produtos.js"></script>
    <script src="fonte.js"></script>
</body>
</html>

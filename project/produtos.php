<?php
session_start();
include 'conexao.php'; // Conexão com o banco de dados

// Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.html"); // Redireciona para a página de login se não estiver logado
    exit();
}

// Busca os produtos no banco de dados
$query = $conn->prepare("SELECT * FROM produto");
$query->execute();
$produtos = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>On Market</title>
    <link href="css/produtos.css" rel="stylesheet">
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
                <!-- Verifica o perfil do usuário para exibir o menu correto -->
                <li>
                    <?php if (isset($_SESSION['usuario_nome'])): ?>
                        <a href="#"><?php echo htmlspecialchars($_SESSION['usuario_nome']); ?></a>
                        <ul class="sub-menu">
                            <li><a href="logout.php">Logoff</a></li>

                            <!-- Exibe opções adicionais para o usuário Master -->
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

                <li><a href="#" onclick="toggleCart()"><img src="img/carrinho.png" alt="Carrinho" class="cart-icon"></a></li>
            </ul>
            <button class="dark-mode-toggle" onclick="toggleDarkMode()">
                <img src="img/dark.png" alt="Modo Escuro" class="dark-mode-icon">
            </button>
            <!-- Botões de Aumento e Diminuição do Tamanho da Fonte -->
            <li>
                    <button onclick="aumentarFonte()" class="font-size-btn">A+</button>
                    <button onclick="diminuirFonte()" class="font-size-btn">A-</button>
                </li>
        </nav>
    </header>

    <h2 align="center">Produtos</h2>
    <br>

    <h2>Confira abaixo nossos produtos!</h2>
    <br>
    <main>
        <?php foreach ($produtos as $produto): ?>
        <section class="about">
            <center><img src="<?php echo htmlspecialchars($produto['Imagem']); ?>" width="200" height="250"
                    alt="<?php echo htmlspecialchars($produto['Nome']); ?>"></center>
            <a href="produto.php?id=<?php echo $produto['ID_Produto']; ?>">
                <p><?php echo htmlspecialchars($produto['Nome']); ?></p>
                <strong>
                    <h3>R$<?php echo number_format($produto['Preco'], 2, ',', '.'); ?></h3>
            </a></strong>
            <button
                onclick="addToCart('<?php echo addslashes($produto['Nome']); ?>', <?php echo $produto['Preco']; ?>)">Adicionar
                ao Carrinho</button>
        </section>
        <br>
        <?php endforeach; ?>
    </main>

    <div id="cart" class="cart">
        <h2>Carrinho de Compras</h2>
        <ul id="cart-items"></ul>
        <button onclick="clearCart()">Limpar Carrinho</button>
        <button onclick="toggleCart()">Fechar Carrinho</button>
        <button id="pay-button">Pagar</button>
    </div>

    <footer>
        <p>&copy; 2024 ON MARKET. Todos os direitos reservados.</p>
        <p>Entre em contato conosco: (21) 1234-5678</p>
        <div class="footer-logo">
            <img src="img/logo.png" alt="Logo">
            <p>Preço bom sempre é ON!</p>
        </div>
    </footer>

    <script src="produtos.js"></script>
    <script src="fonte.js"></script>
</body>

</html>

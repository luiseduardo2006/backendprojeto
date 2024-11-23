<?php
session_start();
include 'conexao.php'; // Arquivo de conexão com o banco de dados

// Verifica se o usuário está logado pelo ID_Usuario
$loggedIn = isset($_SESSION['id_usuario']);

if ($loggedIn) {
    $idUsuario = $_SESSION['id_usuario'];

    // Consulta para obter o nome e perfil do usuário a partir do ID_Usuario
    $query = $conn->prepare("SELECT Nome, Perfil FROM usuario JOIN credenciais ON usuario.ID_Usuario = credenciais.ID_Usuario WHERE usuario.ID_Usuario = :idUsuario");
    $query->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
    $query->execute();
    $userData = $query->fetch(PDO::FETCH_ASSOC);

    if ($userData) {
        // Armazena o nome e perfil do usuário na sessão para fácil acesso
        $_SESSION['usuario_nome'] = $userData['Nome'];
        $_SESSION['usuario_perfil'] = $userData['Perfil'];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>On Market</title>
    <link rel="stylesheet" href="css/novo.css">
    <link rel="stylesheet" href="css/logado.css">
    <link rel="stylesheet" href="css/consulta_usuarios.css">
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
    <?php
    // Exibe a mensagem de sucesso se ela existir
    if (isset($_SESSION['mensagem_sucesso'])) {
        echo "<div class='success-message'>" . $_SESSION['mensagem_sucesso'] . "</div>";
        unset($_SESSION['mensagem_sucesso']); // Remove a mensagem após exibir
    }
    ?>

    <header>
        <div class="logo">
            <a href="index.php"><img src="img/logo.png" alt="Logo"></a>
        </div>
        <h1 class="titulo">ON MARKET</h1>

        <nav class="menu-navegacao">
            <ul class="barra-navegacao">
                <li><a href="produtos.php">Produtos</a></li>
                <li>
                    <?php if ($loggedIn && isset($_SESSION['usuario_nome'])): ?>
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
                <li><a href="#" onclick="toggleCart()"><img src="img/carrinho.png" alt="Carrinho" class="cart-icon"></a></li>
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
        <h2 class="titulo">Bem-vindo à On Market!</h2>

        <!-- Conteúdo para todos os usuários -->
        <section class="section">
            <h2>Sobre a Nossa Loja</h2>
            <p>
                A On Market é uma loja focada em oferecer produtos de alta qualidade com um atendimento acolhedor. 
                Valorizamos a experiência do cliente, trazendo itens cuidadosamente selecionados para atender 
                as preferências de cada um. Nossa missão é garantir que cada visita à nossa loja seja mais do que 
                uma compra – seja uma experiência satisfatória.
            </p>
        </section>

        <section class="section">
            <h2>Localização e Horário de Funcionamento</h2>
            <p>
                Estamos localizados no coração da cidade, na Rua Central, 123. Nosso horário de funcionamento é:
            </p>
            <ul>
                <li>Segunda a Sexta: 9h - 18h</li>
                <li>Sábado: 9h - 13h</li>
                <li>Domingo e feriados: Fechado</li>
            </ul>
        </section>

        <section class="section">
            <h2>Depoimentos de Clientes</h2>
            <p>"A melhor experiência de compra que já tive! Produtos de qualidade e atendimento excelente!" - <strong>Maria S.</strong></p>
            <p>"Sempre encontro o que preciso na On Market, recomendo a todos!" - <strong>João P.</strong></p>
        </section>

        <section class="section">
            <h2>Valores e Compromissos</h2>
            <p>
                Nos esforçamos para trazer transparência, qualidade e ética em cada transação. Prezamos por relações duradouras com nossos clientes,
                oferecendo suporte e ajuda personalizada para garantir que cada produto atenda às suas necessidades.
            </p>
        </section>

        <section class="section">
            <h2>Vantagens para Clientes Cadastrados</h2>
            <p>
                Ao se cadastrar na On Market, você recebe atualizações sobre nossos lançamentos, promoções exclusivas e eventos. 
                Clientes cadastrados também têm acesso a ofertas especiais que são renovadas a cada mês.
            </p>
        </section>
    </main>

    <script src="home.js"></script>
    <script src="fonte.js"></script>
</body>
</html>

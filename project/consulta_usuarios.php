<?php
session_start();
include 'conexao.php'; // Conexão com o banco de dados

// Verificação de login e perfil Master
if (!isset($_SESSION['id_usuario']) || $_SESSION['usuario_perfil'] !== 'master') {
    header("Location: login.html"); // Redireciona se o usuário não for Master ou não estiver logado
    exit();
}

// Mensagem de confirmação para as operações
$mensagem = "";

// Funções CRUD e mudança de perfil
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idUsuario = $_POST['user_id'];
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $dataNascimento = $_POST['data_nascimento'];
    $cep = $_POST['cep'];
    $endereco = $_POST['endereco'];
    $sexo = $_POST['sexo'];
    $telefoneCelular = $_POST['telefone_celular'];
    $nomeMaterno = $_POST['nome_materno'];
    $acao = $_POST['acao'];

    if ($acao === 'edit') {
        // Atualizar dados do usuário
        $query = $conn->prepare("UPDATE usuario SET Nome = :nome, CPF = :cpf, Data_Nascimento = :dataNascimento, CEP = :cep, Endereco = :endereco, Sexo = :sexo, Telefone_Celular = :telefoneCelular, Nome_Materno = :nomeMaterno WHERE ID_Usuario = :idUsuario");
        $query->execute([
            ':nome' => $nome,
            ':cpf' => $cpf,
            ':dataNascimento' => $dataNascimento,
            ':cep' => $cep,
            ':endereco' => $endereco,
            ':sexo' => $sexo,
            ':telefoneCelular' => $telefoneCelular,
            ':nomeMaterno' => $nomeMaterno,
            ':idUsuario' => $idUsuario
        ]);
        $mensagem = "Usuário atualizado com sucesso.";
    } elseif ($acao === 'delete') {
        // Excluir usuário
        $query = $conn->prepare("DELETE FROM usuario WHERE ID_Usuario = :idUsuario");
        $query->execute([':idUsuario' => $idUsuario]);
        $mensagem = "Usuário excluído com sucesso.";
    } elseif ($acao === 'toggleProfile') {
        // Alterar o perfil do usuário
        $perfilAtual = $_POST['perfil'];
        $novoPerfil = $perfilAtual === 'master' ? 'comum' : 'master';
        $query = $conn->prepare("UPDATE credenciais SET Perfil = :novoPerfil WHERE ID_Usuario = :idUsuario");
        $query->execute([':novoPerfil' => $novoPerfil, ':idUsuario' => $idUsuario]);
        $mensagem = "Perfil do usuário atualizado para $novoPerfil.";
    }
}

// Consulta para obter todos os usuários
$query = $conn->query("SELECT usuario.ID_Usuario, Nome, CPF, Data_Nascimento, CEP, Endereco, Sexo, Telefone_Celular, Nome_Materno, Perfil 
                       FROM usuario 
                       JOIN credenciais ON usuario.ID_Usuario = credenciais.ID_Usuario");
$usuarios = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Usuários</title>
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/logado.css">
    <link rel="stylesheet" href="css/consulta_produtos.css">
    <link rel="stylesheet" href="css/consulta_usuarios.css">
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

    <main>
        <h2>Consulta de Usuários</h2>
        <?php if ($mensagem): ?>
            <p><?php echo $mensagem; ?></p>
        <?php endif; ?>
        
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Data Nascimento</th>
                    <th>CEP</th>
                    <th>Endereço</th>
                    <th>Sexo</th>
                    <th>Telefone Celular</th>
                    <th>Nome Materno</th>
                    <th>Perfil</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <form method="POST">
                            <input type="hidden" name="user_id" value="<?php echo $usuario['ID_Usuario']; ?>">
                            <input type="hidden" name="perfil" value="<?php echo $usuario['Perfil']; ?>">
                            <td><input type="text" name="nome" value="<?php echo htmlspecialchars($usuario['Nome']); ?>"></td>
                            <td><input type="text" name="cpf" value="<?php echo htmlspecialchars($usuario['CPF']); ?>"></td>
                            <td><input type="date" name="data_nascimento" value="<?php echo htmlspecialchars($usuario['Data_Nascimento']); ?>"></td>
                            <td><input type="text" name="cep" value="<?php echo htmlspecialchars($usuario['CEP']); ?>"></td>
                            <td><input type="text" name="endereco" value="<?php echo htmlspecialchars($usuario['Endereco']); ?>"></td>
                            <td>
                                <select name="sexo">
                                    <option value="Masculino" <?php echo $usuario['Sexo'] === 'Masculino' ? 'selected' : ''; ?>>Masculino</option>
                                    <option value="Feminino" <?php echo $usuario['Sexo'] === 'Feminino' ? 'selected' : ''; ?>>Feminino</option>
                                </select>
                            </td>
                            <td><input type="text" name="telefone_celular" value="<?php echo htmlspecialchars($usuario['Telefone_Celular']); ?>"></td>
                            <td><input type="text" name="nome_materno" value="<?php echo htmlspecialchars($usuario['Nome_Materno']); ?>"></td>
                            <td><?php echo htmlspecialchars($usuario['Perfil']); ?></td>
                            <td>
                                <button type="submit" name="acao" value="edit">Salvar</button>
                                <button type="submit" name="acao" value="delete" onclick="return confirm('Excluir usuário?');">Excluir</button>
                                <button type="submit" name="acao" value="toggleProfile">
                                    Tornar <?php echo $usuario['Perfil'] === 'master' ? 'Comum' : 'Master'; ?>
                                </button>
                            </td>
                        </form>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <script src="consulta_produtos.js"></script>
    <script src="fonte.js"></script>
</body>

</html>

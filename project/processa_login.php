<?php
session_start();
include 'conexao.php'; // Arquivo de conexão

// Função para registrar o log
function registrarLog($conn, $idUsuario, $acao) {
    $sql = "INSERT INTO log_master (ID_Usuario, Data_Hora, Acao) VALUES (:idUsuario, NOW(), :acao)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
    $stmt->bindParam(':acao', $acao, PDO::PARAM_STR);
    $stmt->execute();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $senha = $_POST['password'];

    // Consulta para verificar o login
    $query = $conn->prepare("SELECT * FROM credenciais WHERE Login = :login");
    $query->bindParam(':login', $login);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($senha, $user['Senha'])) {
        $_SESSION['id_usuario'] = $user['ID_Usuario']; // Salva o ID do usuário na sessão
        $_SESSION['perfil'] = $user['Perfil']; // Salva o perfil (master/comum)
        
        // Gera uma pergunta aleatória para o 2FA
        $perguntas = [
            "Qual o nome da sua mãe?",
            "Qual a data do seu nascimento?",
            "Qual o CEP do seu endereço?"
        ];
        $indice_pergunta = array_rand($perguntas);
        $_SESSION['2fa_question'] = $perguntas[$indice_pergunta];

        // Registra o log de login bem-sucedido
        registrarLog($conn, $user['ID_Usuario'], 'Login bem-sucedido');

        // Redireciona para a tela 2FA
        header("Location: 2fa.php");
        exit();
    } else {
        // Registra o log de falha de login
        $idUsuario = $user ? $user['ID_Usuario'] : null; // Caso o login exista mas a senha falhe
        registrarLog($conn, $idUsuario, 'Login falhou');

        // Mensagem de erro se o login ou senha estiverem incorretos
        $_SESSION['login_error'] = "Login ou senha incorretos.";
        header("Location: login.html"); // Redireciona de volta para a tela de login
        exit();
    }
}
?>

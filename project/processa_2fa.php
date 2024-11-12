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
    $resposta_2fa = $_POST['2fa_answer'];
    $id_usuario = $_SESSION['id_usuario'];

    // Consulta para verificar a resposta correta baseada na pergunta 2FA
    $query = $conn->prepare("SELECT Nome_Materno, Data_Nascimento, CEP FROM usuario WHERE ID_Usuario = :id_usuario");
    $query->bindParam(':id_usuario', $id_usuario);
    $query->execute();
    $usuario = $query->fetch(PDO::FETCH_ASSOC);

    // Verificação da pergunta e resposta
    if ($_SESSION['2fa_question'] == 'Qual o nome da sua mãe?' && $resposta_2fa === $usuario['Nome_Materno']) {
        // Autenticação 2FA bem-sucedida
        registrarLog($conn, $id_usuario, '2FA bem-sucedido');
        $_SESSION['mensagem_sucesso'] = "Login efetuado com sucesso!";
        header("Location: index.php");
        exit();
    } elseif ($_SESSION['2fa_question'] == 'Qual a data do seu nascimento?' && $resposta_2fa === $usuario['Data_Nascimento']) {
        // Autenticação 2FA bem-sucedida
        registrarLog($conn, $id_usuario, '2FA bem-sucedido');
        $_SESSION['mensagem_sucesso'] = "Login efetuado com sucesso!";
        header("Location: index.php");
        exit();
    } elseif ($_SESSION['2fa_question'] == 'Qual o CEP do seu endereço?' && $resposta_2fa === $usuario['CEP']) {
        // Autenticação 2FA bem-sucedida
        registrarLog($conn, $id_usuario, '2FA bem-sucedido');
        $_SESSION['mensagem_sucesso'] = "Login efetuado com sucesso!";
        header("Location: index.php");
        exit();
    } else {
        // Autenticação falhou
        registrarLog($conn, $id_usuario, '2FA falhou');
        $_SESSION['2fa_error'] = "Resposta incorreta!";
        header("Location: login.html");
        exit();
    }
}
?>

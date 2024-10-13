<?php
session_start();
include 'conexao.php'; // Arquivo de conexão com o banco

$login = $_SESSION['login'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resposta = $_POST['resposta'];

    // Obter pergunta e resposta do banco de dados
    $query = "SELECT pergunta, resposta FROM perguntas_2fa WHERE usuario_id = (SELECT id FROM usuarios WHERE login = ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $resposta_correta = $row['resposta'];

        // Verificar se a resposta está correta
        if (strtolower($resposta) === strtolower($resposta_correta)) {
            // Redireciona para a página do painel após sucesso
            header("Location: painel.php");
        } else {
            // Mensagem de erro após 3 tentativas
            if (!isset($_SESSION['tentativas'])) {
                $_SESSION['tentativas'] = 1;
            } else {
                $_SESSION['tentativas']++;
            }

            if ($_SESSION['tentativas'] >= 3) {
                echo "<script>alert('3 tentativas sem sucesso! Favor realizar Login novamente.'); window.location.href='login.html';</script>";
                session_destroy();
            } else {
                echo "<script>alert('Resposta incorreta! Tente novamente.'); window.location.href='2fa.html';</script>";
            }
        }
    } else {
        echo "<script>alert('Erro ao buscar pergunta de segurança.'); window.location.href='login.html';</script>";
    }
}
?>

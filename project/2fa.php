<?php
session_start(); // Inicia a sessão

// Verifica se a pergunta do 2FA foi definida na sessão
if (!isset($_SESSION['2fa_question'])) {
    // Se não houver pergunta definida, redireciona para o login
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autenticação 2FA</title>
    <link rel="stylesheet" href="css/cadastro.css">
</head>

<body>
    <div class="page">
        <form method="POST" action="processa_2fa.php" class="form2FA">
            <h1>Autenticação de Dois Fatores</h1>
            <p>Responda à pergunta de segurança abaixo para completar o login.</p>

            <!-- Pergunta de segurança (apenas leitura) -->
            <label for="2fa_question">Pergunta de Segurança</label>
            <input type="text" id="2fa_question" name="2fa_question" value="<?php echo $_SESSION['2fa_question']; ?>" readonly />

            <!-- Campo de resposta -->
            <label for="2fa_answer">Resposta</label>
            <input type="text" id="2fa_answer" name="2fa_answer" placeholder="Digite sua resposta" required />

            <!-- Botão para verificar -->
            <input type="submit" value="Verificar" class="btn" />
        </form>
    </div>
</body>

</html>

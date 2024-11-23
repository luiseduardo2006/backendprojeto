<?php
session_start();
include 'conexao.php';

// Função para limpar e proteger os dados recebidos
function limparDados($dados) {
    return htmlspecialchars(stripslashes(trim($dados)));
}

// Função para registrar o log
function registrarLog($conn, $idUsuario, $acao) {
    $sql = "INSERT INTO log_master (ID_Usuario, Data_Hora, Acao) VALUES (:idUsuario, NOW(), :acao)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
    $stmt->bindParam(':acao', $acao, PDO::PARAM_STR);
    $stmt->execute();
}

// Recebe os dados do formulário
$nome = limparDados($_POST['nome']);
$data_nascimento = limparDados($_POST['data_nascimento']);
$cpf = limparDados($_POST['cpf']);
$cep = limparDados($_POST['cep']);
$endereco = limparDados($_POST['endereco']);
$sexo = limparDados($_POST['sexo']);
$telefone_celular = limparDados($_POST['telefone']);
$login = limparDados($_POST['login']);
$senha = limparDados($_POST['senha']);
$nome_materno = limparDados($_POST['nome_materno']); // Campo para o nome materno

// Verifica se o perfil foi enviado e atribui 'comum' como valor padrão
$perfil = isset($_POST['perfil']) ? limparDados($_POST['perfil']) : 'comum';

// Validação da imagem
if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
    $imagem_temp = $_FILES['imagem']['tmp_name'];
    $imagem_nome = 'imagens/' . basename($_FILES['imagem']['name']);
    if (!move_uploaded_file($imagem_temp, $imagem_nome)) {
        die("Erro ao enviar a imagem.");
    }
} else {
    $imagem_nome = null; // Se a imagem não for fornecida, define como nulo
}

try {
    // Inicia uma transação
    $conn->beginTransaction();

    // Insere os dados na tabela Usuario, sem o campo de telefone fixo
    $sql_usuario = "INSERT INTO usuario (Nome, Data_Nascimento, CPF, CEP, Endereco, Sexo, Telefone_Celular, Nome_Materno) 
                    VALUES (:nome, :data_nascimento, :cpf, :cep, :endereco, :sexo, :telefone_celular, :nome_materno)";
    $stmt_usuario = $conn->prepare($sql_usuario);
    $stmt_usuario->bindParam(':nome', $nome);
    $stmt_usuario->bindParam(':data_nascimento', $data_nascimento);
    $stmt_usuario->bindParam(':cpf', $cpf);
    $stmt_usuario->bindParam(':cep', $cep);
    $stmt_usuario->bindParam(':endereco', $endereco);
    $stmt_usuario->bindParam(':sexo', $sexo);
    $stmt_usuario->bindParam(':telefone_celular', $telefone_celular);
    $stmt_usuario->bindParam(':nome_materno', $nome_materno);
    $stmt_usuario->execute();

    // Obtém o último ID inserido (ID_Usuario)
    $id_usuario = $conn->lastInsertId();

    // Insere os dados na tabela Credenciais
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT); // Hash da senha para segurança
    $sql_credenciais = "INSERT INTO credenciais (Login, Senha, Perfil, ID_Usuario) 
                        VALUES (:login, :senha, :perfil, :id_usuario)";
    $stmt_credenciais = $conn->prepare($sql_credenciais);
    $stmt_credenciais->bindParam(':login', $login);
    $stmt_credenciais->bindParam(':senha', $senha_hash);
    $stmt_credenciais->bindParam(':perfil', $perfil);
    $stmt_credenciais->bindParam(':id_usuario', $id_usuario);
    $stmt_credenciais->execute();

    // Chama a função para registrar o log do cadastro
    registrarLog($conn, $id_usuario, 'Cadastro de usuário realizado');

    // Confirma a transação
    $conn->commit();

    // Exibe uma mensagem de sucesso e redireciona após 5 segundos
    echo "<script>alert('Cadastro efetuado com sucesso! Você será redirecionado para a página de login.');</script>";
    echo "<meta http-equiv='refresh' content='5;url=login.html'>"; // Redireciona após 5 segundos
    exit;

} catch (Exception $e) {
    // Desfaz a transação em caso de erro
    $conn->rollBack();
    die("Erro ao cadastrar: " . $e->getMessage());
}
?>

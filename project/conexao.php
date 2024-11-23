<?php
// Configurações do banco de dados
$host = 'localhost';  // O host do banco de dados
$dbname = 'loja_eletronicos';  // Nome do banco de dados
$username = 'root';  // Usuário do banco de dados (por padrão, root no XAMPP)
$password = '';  // Senha do banco de dados (geralmente vazia no XAMPP)

// Criar a conexão
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Definir o modo de erro PDO para exceção
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Conexão bem-sucedida!";
} catch(PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}
?>

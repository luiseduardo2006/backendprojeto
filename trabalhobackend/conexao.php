<?php
// Configurações de conexão com o banco de dados
$servername = "localhost";
$username = "root"; // Usuário padrão do XAMPP
$password = "";     // Senha vazia no XAMPP por padrão
$dbname = "loja_esportiva"; // Nome do banco de dados que você criou

// Criando a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificando a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 12/11/2024 às 22:05
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `loja_eletronicos`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `credenciais`
--

CREATE TABLE `credenciais` (
  `ID_Credenciais` int(11) NOT NULL,
  `Login` varchar(6) NOT NULL,
  `Senha` varchar(255) NOT NULL,
  `Perfil` enum('master','comum') NOT NULL,
  `ID_Usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `credenciais`
--

INSERT INTO `credenciais` (`ID_Credenciais`, `Login`, `Senha`, `Perfil`, `ID_Usuario`) VALUES
(14, 'aaaeee', '$2y$10$O3otXbvpse4CZC8vFObkUOjK9xsa27/JeQ.0GmATbZKLVMgXgKcRa', 'master', 15),
(18, 'Carro0', '$2y$10$faySbplJ0Qux/Wdi0yzQ.O9b0VK6Rm3Sl7vf74chPw42hnhfpLUZW', 'comum', 20);

-- --------------------------------------------------------

--
-- Estrutura para tabela `log_autenticacao`
--

CREATE TABLE `log_autenticacao` (
  `ID_Log` int(11) NOT NULL,
  `ID_Credenciais` int(11) NOT NULL,
  `Data_Hora` datetime NOT NULL,
  `Tipo_2FA` varchar(255) NOT NULL,
  `Status` enum('sucesso','falha') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `log_master`
--

CREATE TABLE `log_master` (
  `ID_Log` int(11) NOT NULL,
  `ID_Usuario` int(11) NOT NULL,
  `Data_Hora` datetime NOT NULL,
  `Acao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `log_master`
--

INSERT INTO `log_master` (`ID_Log`, `ID_Usuario`, `Data_Hora`, `Acao`) VALUES
(1, 15, '2024-11-12 16:43:23', 'Logout realizado'),
(2, 20, '2024-11-12 16:45:39', 'Cadastro de usuário realizado'),
(3, 20, '2024-11-12 16:45:56', 'Login bem-sucedido'),
(4, 20, '2024-11-12 16:46:00', '2FA bem-sucedido'),
(5, 20, '2024-11-12 16:46:28', 'Logout realizado'),
(6, 15, '2024-11-12 16:46:41', 'Login bem-sucedido'),
(7, 15, '2024-11-12 16:46:44', '2FA bem-sucedido'),
(8, 15, '2024-11-12 16:47:33', 'Logout realizado'),
(9, 20, '2024-11-12 16:47:46', 'Login bem-sucedido'),
(10, 20, '2024-11-12 16:47:48', '2FA falhou'),
(11, 20, '2024-11-12 16:48:00', 'Login bem-sucedido'),
(12, 20, '2024-11-12 16:48:02', '2FA bem-sucedido'),
(13, 20, '2024-11-12 17:01:07', 'Logout realizado'),
(14, 20, '2024-11-12 17:01:39', 'Login bem-sucedido'),
(15, 20, '2024-11-12 17:01:45', '2FA falhou'),
(16, 20, '2024-11-12 17:01:52', 'Login bem-sucedido'),
(17, 20, '2024-11-12 17:01:55', '2FA bem-sucedido'),
(18, 20, '2024-11-12 17:58:56', 'Logout realizado'),
(19, 15, '2024-11-12 17:59:02', 'Login bem-sucedido'),
(20, 15, '2024-11-12 17:59:06', '2FA bem-sucedido');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto`
--

CREATE TABLE `produto` (
  `ID_Produto` int(11) NOT NULL,
  `Nome` varchar(100) NOT NULL,
  `Preco` decimal(10,2) NOT NULL,
  `Imagem` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produto`
--

INSERT INTO `produto` (`ID_Produto`, `Nome`, `Preco`, `Imagem`) VALUES
(1, 'Gabinete', 299.99, 'img/gabinete.png'),
(2, 'Fonte', 199.99, 'img/fonte.png'),
(3, 'Fone', 88.99, 'img/fone.png'),
(4, 'Placa Mãe', 599.99, 'img/placamae.png'),
(5, 'Processador', 899.99, 'img/processador.png');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `ID_Usuario` int(11) NOT NULL,
  `Nome` varchar(80) NOT NULL,
  `Data_Nascimento` date NOT NULL,
  `CPF` varchar(11) NOT NULL,
  `CEP` varchar(8) NOT NULL,
  `Endereco` varchar(255) NOT NULL,
  `Sexo` enum('M','F','Outro') NOT NULL,
  `Telefone_Celular` varchar(15) NOT NULL,
  `Nome_Materno` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`ID_Usuario`, `Nome`, `Data_Nascimento`, `CPF`, `CEP`, `Endereco`, `Sexo`, `Telefone_Celular`, `Nome_Materno`) VALUES
(15, 'Luis Eduardo Silva da Silveira', '2006-02-22', '20412850796', '23092060', 'Rua Campina Grande, Campo Grande, Rio de Janeiro - RJ', '', '5521980618717', 'maria betania da silva'),
(20, 'Maria clara da silva', '2004-02-22', '07592318776', '23092060', 'Rua Campina Grande, Campo Grande, Rio de Janeiro - RJ', '', '5521970115047', 'maria betania da silva');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `credenciais`
--
ALTER TABLE `credenciais`
  ADD PRIMARY KEY (`ID_Credenciais`),
  ADD UNIQUE KEY `Login` (`Login`),
  ADD KEY `ID_Usuario` (`ID_Usuario`);

--
-- Índices de tabela `log_autenticacao`
--
ALTER TABLE `log_autenticacao`
  ADD PRIMARY KEY (`ID_Log`),
  ADD KEY `ID_Credenciais` (`ID_Credenciais`);

--
-- Índices de tabela `log_master`
--
ALTER TABLE `log_master`
  ADD PRIMARY KEY (`ID_Log`),
  ADD KEY `ID_Usuario` (`ID_Usuario`);

--
-- Índices de tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`ID_Produto`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`ID_Usuario`),
  ADD UNIQUE KEY `CPF` (`CPF`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `credenciais`
--
ALTER TABLE `credenciais`
  MODIFY `ID_Credenciais` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `log_autenticacao`
--
ALTER TABLE `log_autenticacao`
  MODIFY `ID_Log` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `log_master`
--
ALTER TABLE `log_master`
  MODIFY `ID_Log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `ID_Produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `ID_Usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `credenciais`
--
ALTER TABLE `credenciais`
  ADD CONSTRAINT `credenciais_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuario` (`ID_Usuario`) ON DELETE CASCADE;

--
-- Restrições para tabelas `log_autenticacao`
--
ALTER TABLE `log_autenticacao`
  ADD CONSTRAINT `log_autenticacao_ibfk_1` FOREIGN KEY (`ID_Credenciais`) REFERENCES `credenciais` (`ID_Credenciais`) ON DELETE CASCADE;

--
-- Restrições para tabelas `log_master`
--
ALTER TABLE `log_master`
  ADD CONSTRAINT `log_master_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuario` (`ID_Usuario`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

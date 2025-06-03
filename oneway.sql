-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 26/03/2025 às 01:53
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `oneway`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `avaliacoes`
--

CREATE TABLE `avaliacoes` (
  `id` int(11) NOT NULL,
  `id_aluno` int(11) NOT NULL,
  `id_professor` int(11) NOT NULL,
  `curso` varchar(10) NOT NULL,
  `nome_atividade` varchar(100) DEFAULT NULL,
  `nota` decimal(4,2) DEFAULT NULL,
  `atividade` text DEFAULT NULL,
  `data_atribuicao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `avaliacoes`
--

INSERT INTO `avaliacoes` (`id`, `id_aluno`, `id_professor`, `curso`, `nome_atividade`, `nota`, `atividade`, `data_atribuicao`) VALUES
(2, 12, 11, '2', 'Checkout 1', 99.99, NULL, '2025-03-25 20:08:54'),
(3, 12, 11, '2', 'Writing 1', 90.00, NULL, '2025-03-25 20:10:18');

-- --------------------------------------------------------

--
-- Estrutura para tabela `dados_pessoais`
--

CREATE TABLE `dados_pessoais` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `nivel` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `dados_pessoais`
--

INSERT INTO `dados_pessoais` (`id`, `nome`, `nivel`, `email`, `senha`) VALUES
(7, 'Karina', '8', 'kaka@gmail.com', '$2y$10$xBdETbD4b3I8.w7dcNOste1Ey7/TCk9gxjLp86DkSSIDHsMNqApmG'),
(11, 'Jeff', 'professor', 'jeffsilva@gmail.com', '$2y$10$YWeMQp1LonpBpT/eLz5p2eZvwyU1uEvE23JG1rtxYKCSQS3N9YWeW'),
(12, 'Vitor', '2', 'vitor@gmail.com', '$2y$10$3KIelqgt4ROZxegBYs8sQeANMZi/wlnfvoqaMGXcdbGDoZnH46KLa'),
(13, 'Tchelo', 'professor', 'tchelo@professor.com', '$2y$10$QxVMGBNVkKWAruZuGnZQL.bgb6Ok/k9e5HkvaNOazu22BBA77eWSG'),
(14, 'teste', '2', 'teste@gmail.com', '$2y$10$KVmBYbZbVPfH/4vaYrnnquKqKFYMv23MdaxQxIdVlqt.edz9ToIri');

-- --------------------------------------------------------

--
-- Estrutura para tabela `email`
--

CREATE TABLE `email` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `email`
--

INSERT INTO `email` (`id`, `email`) VALUES
(8, 'jeffop801@gmail.com'),
(9, 'jeffsenai2024@gmail.com'),
(10, 'drivefotosjeff@gmail.com');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_aluno` (`id_aluno`),
  ADD KEY `fk_professor` (`id_professor`);

--
-- Índices de tabela `dados_pessoais`
--
ALTER TABLE `dados_pessoais`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `email`
--
ALTER TABLE `email`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `dados_pessoais`
--
ALTER TABLE `dados_pessoais`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `email`
--
ALTER TABLE `email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `avaliacoes`
--
ALTER TABLE `avaliacoes`
  ADD CONSTRAINT `fk_aluno` FOREIGN KEY (`id_aluno`) REFERENCES `dados_pessoais` (`id`),
  ADD CONSTRAINT `fk_professor` FOREIGN KEY (`id_professor`) REFERENCES `dados_pessoais` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

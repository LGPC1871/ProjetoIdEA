-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13-Abr-2020 às 18:14
-- Versão do servidor: 8.0.19
-- versão do PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `projetoidea`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `aa_users`
--

CREATE TABLE `aa_users` (
  `AA_id` int NOT NULL,
  `AA_username` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `AA_password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `aa_users`
--

INSERT INTO `aa_users` (`AA_id`, `AA_username`, `AA_password`) VALUES
(1, 'admin', '$2y$10$wB36b0oXZDyPK/uptfxH6ebNo3JgbVtitEQ5xFR/AB3apBEBw4S3y');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `aa_users`
--
ALTER TABLE `aa_users`
  ADD PRIMARY KEY (`AA_id`),
  ADD UNIQUE KEY `A_userName_UNIQUE` (`AA_username`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `aa_users`
--
ALTER TABLE `aa_users`
  MODIFY `AA_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

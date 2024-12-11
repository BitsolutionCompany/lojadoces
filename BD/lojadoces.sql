-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13/11/2024 às 15:15
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `lojadoces`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `adm`
--

CREATE TABLE `adm` (
  `codeAdm` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `loja` varchar(100) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `birthdate` date NOT NULL,
  `cpf` varchar(15) NOT NULL,
  `cep` varchar(15) NOT NULL,
  `estado` varchar(100) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `logradouro` varchar(100) NOT NULL,
  `numero` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `adm`
--

INSERT INTO `adm` (`codeAdm`, `nome`, `loja`, `gender`, `birthdate`, `cpf`, `cep`, `estado`, `cidade`, `logradouro`, `numero`, `email`, `password`) VALUES
(82790, 'Antonio Wesley Silva do Nascimento', 'Tudo da Terra', 'Masculino', '2002-06-09', '080.128.673-54', '62370-000', 'CE', 'São Benedito', 'rua deputado vicente ribeiro', 572, 'silvawesley978@gmail.com', '$2y$10$4rGYDdXHsk1GYccAi/t88OEXuLr1kyseMxwN9tWQZg14yZWH3QnIO');

-- --------------------------------------------------------

--
-- Estrutura para tabela `funcionarios`
--

CREATE TABLE `funcionarios` (
  `codFunc` int(8) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `birthdate` date NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `cep` varchar(11) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `bairro` varchar(100) NOT NULL,
  `numero` int(11) NOT NULL,
  `estado` varchar(100) NOT NULL,
  `logradouro` varchar(100) NOT NULL,
  `cargo` varchar(100) NOT NULL,
  `data_admissao` date NOT NULL,
  `meta_vendas` decimal(10,2) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `password` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `funcionarios`
--

INSERT INTO `funcionarios` (`codFunc`, `nome`, `birthdate`, `cpf`, `cep`, `cidade`, `bairro`, `numero`, `estado`, `logradouro`, `cargo`, `data_admissao`, `meta_vendas`, `email`, `gender`, `password`) VALUES
(50479124, 'Antonio Wesley Silva do Nascimento', '2002-06-09', '080.128.673-54', '62370-000', 'São Benedito', '', 572, 'CE', 'rua deputado vicente ribeiro', 'Masculino', '2024-11-09', NULL, 'silvawesley978@gmail.com', 'Masculino', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `codProd` int(8) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` text NOT NULL,
  `precoVarejo` decimal(10,2) NOT NULL,
  `precoAtacado` decimal(10,2) NOT NULL,
  `estoque` int(11) NOT NULL,
  `categoria` varchar(100) NOT NULL,
  `barcode` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`codProd`, `nome`, `descricao`, `precoVarejo`, `precoAtacado`, `estoque`, `categoria`, `barcode`) VALUES
(94074, 'Sachê Doces Flor de Leite', 'Sachê com 6 doces em formato de flor da empresa Flor de Leite', 8.00, 5.50, 300, 'Doces', '0602883457904');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `adm`
--
ALTER TABLE `adm`
  ADD PRIMARY KEY (`codeAdm`);

--
-- Índices de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`codFunc`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`codProd`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

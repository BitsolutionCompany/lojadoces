-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 26/12/2024 às 20:15
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
-- Estrutura para tabela `address`
--

CREATE TABLE `address` (
  `codeaddress` int(11) NOT NULL,
  `cep` varchar(11) NOT NULL,
  `uf` varchar(10) NOT NULL,
  `city` varchar(100) NOT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `logradouro` varchar(300) NOT NULL,
  `number` int(11) NOT NULL,
  `codeuser` int(11) DEFAULT NULL,
  `coderevenda` int(11) DEFAULT NULL,
  `tipocad` enum('USER','REVENDA') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Estrutura para tabela `cart`
--

CREATE TABLE `cart` (
  `codecart` int(11) NOT NULL,
  `codeuser` int(11) NOT NULL,
  `codeprod` int(11) NOT NULL,
  `quant` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `fav`
--

CREATE TABLE `fav` (
  `id` int(11) NOT NULL,
  `codeuser` int(11) NOT NULL,
  `codeprod` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `salario` decimal(10,2) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `demissao` date DEFAULT NULL,
  `deletado` tinyint(1) NOT NULL,
  `codeadm` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `imgprod`
--

CREATE TABLE `imgprod` (
  `id` int(11) NOT NULL,
  `codeprod` int(11) NOT NULL,
  `img_dir` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `infofrete`
--

CREATE TABLE `infofrete` (
  `id` int(11) NOT NULL,
  `peso` double NOT NULL,
  `comprimento` double NOT NULL,
  `largura` double NOT NULL,
  `altura` double NOT NULL,
  `tipoembalagem` varchar(100) NOT NULL,
  `codeprod` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `itempedido`
--

CREATE TABLE `itempedido` (
  `id` int(11) NOT NULL,
  `codeprod` int(11) NOT NULL,
  `quant` int(11) NOT NULL,
  `valor` double NOT NULL,
  `codepedrev` int(11) DEFAULT NULL,
  `codeped` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedido`
--

CREATE TABLE `pedido` (
  `codepedido` int(11) NOT NULL,
  `codeuser` int(11) NOT NULL,
  `val_frete` double NOT NULL,
  `val_tot` double NOT NULL,
  `formapag` varchar(100) NOT NULL,
  `datapedido` date NOT NULL,
  `status` varchar(200) NOT NULL,
  `enderentrega` int(11) NOT NULL,
  `dataentregaestimada` date NOT NULL,
  `statuspag` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidorev`
--

CREATE TABLE `pedidorev` (
  `code` int(11) NOT NULL,
  `coderev` int(11) NOT NULL,
  `val_frete` double NOT NULL,
  `valtot` double NOT NULL,
  `formapag` varchar(100) NOT NULL,
  `datapedido` date NOT NULL,
  `status` text NOT NULL,
  `enderentrega` int(11) NOT NULL,
  `statuspag` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `barcode` mediumtext NOT NULL,
  `codadm` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `promotions`
--

CREATE TABLE `promotions` (
  `id` int(11) NOT NULL,
  `codeprod` int(11) NOT NULL,
  `newprice` decimal(10,2) NOT NULL,
  `tempo` float NOT NULL,
  `datalancamento` date NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `revenda`
--

CREATE TABLE `revenda` (
  `coderevenda` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `cpf_cnpj` varchar(25) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(14) NOT NULL,
  `birthdate` date NOT NULL,
  `password` text DEFAULT NULL,
  `razaosocial` varchar(100) DEFAULT NULL,
  `deletado` tinyint(1) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `user`
--

CREATE TABLE `user` (
  `codeuser` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `email` varchar(100) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `phone` varchar(14) NOT NULL,
  `birthdate` date NOT NULL,
  `password` text DEFAULT NULL,
  `deletado` tinyint(1) NOT NULL,
  `status` varchar(100) NOT NULL,
  `isvendor` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `user`
--

INSERT INTO `user` (`codeuser`, `name`, `cpf`, `email`, `gender`, `phone`, `birthdate`, `password`, `deletado`, `status`, `isvendor`) VALUES
(27427530, 'Antonio Wesley Silva do Nascimento', '080.128.673-54', 'silvawesley978@gmail.com', 'Masculino', '(88) 99408-664', '2002-06-09', '$2y$10$9uBSMVr3kkpMsR3.4VnstuFOTzvCOILELvUATzJM3jspFokjLXUba', 0, 'ativo', 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`codeaddress`),
  ADD KEY `fk_codeuser` (`codeuser`),
  ADD KEY `coderevenda` (`coderevenda`);

--
-- Índices de tabela `adm`
--
ALTER TABLE `adm`
  ADD PRIMARY KEY (`codeAdm`);

--
-- Índices de tabela `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`codecart`),
  ADD KEY `coduser` (`codeuser`),
  ADD KEY `fk_cart_produtos` (`codeprod`);

--
-- Índices de tabela `fav`
--
ALTER TABLE `fav`
  ADD PRIMARY KEY (`id`),
  ADD KEY `codeuser` (`codeuser`),
  ADD KEY `fk_fav_produtos` (`codeprod`);

--
-- Índices de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`codFunc`),
  ADD KEY `fk_funcionarios_adm` (`codeadm`);

--
-- Índices de tabela `imgprod`
--
ALTER TABLE `imgprod`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_imgprod_produtos` (`codeprod`);

--
-- Índices de tabela `infofrete`
--
ALTER TABLE `infofrete`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_infofrete_produtos` (`codeprod`);

--
-- Índices de tabela `itempedido`
--
ALTER TABLE `itempedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_itempedido_produtos` (`codeprod`),
  ADD KEY `fk_itempedido_pedidorev` (`codepedrev`),
  ADD KEY `fk_itempedido_pedido` (`codeped`);

--
-- Índices de tabela `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`codepedido`),
  ADD KEY `cduser` (`codeuser`),
  ADD KEY `cdaddress` (`enderentrega`);

--
-- Índices de tabela `pedidorev`
--
ALTER TABLE `pedidorev`
  ADD PRIMARY KEY (`code`),
  ADD KEY `fk_pedidorev_address` (`enderentrega`),
  ADD KEY `fk_pedidorev_revenda` (`coderev`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`codProd`),
  ADD KEY `fk_produtos_adm` (`codadm`);

--
-- Índices de tabela `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_promotions_produtos` (`codeprod`);

--
-- Índices de tabela `revenda`
--
ALTER TABLE `revenda`
  ADD PRIMARY KEY (`coderevenda`);

--
-- Índices de tabela `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`codeuser`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `fav`
--
ALTER TABLE `fav`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `infofrete`
--
ALTER TABLE `infofrete`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `coderevenda` FOREIGN KEY (`coderevenda`) REFERENCES `revenda` (`coderevenda`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_codeuser` FOREIGN KEY (`codeuser`) REFERENCES `user` (`codeuser`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `coduser` FOREIGN KEY (`codeuser`) REFERENCES `user` (`codeuser`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cart_produtos` FOREIGN KEY (`codeprod`) REFERENCES `produtos` (`codProd`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `fav`
--
ALTER TABLE `fav`
  ADD CONSTRAINT `fav_ibfk_1` FOREIGN KEY (`codeuser`) REFERENCES `user` (`codeuser`),
  ADD CONSTRAINT `fk_fav_produtos` FOREIGN KEY (`codeprod`) REFERENCES `produtos` (`codProd`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD CONSTRAINT `fk_funcionarios_adm` FOREIGN KEY (`codeadm`) REFERENCES `adm` (`codeAdm`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `imgprod`
--
ALTER TABLE `imgprod`
  ADD CONSTRAINT `fk_imgprod_produtos` FOREIGN KEY (`codeprod`) REFERENCES `produtos` (`codProd`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `infofrete`
--
ALTER TABLE `infofrete`
  ADD CONSTRAINT `fk_infofrete_produtos` FOREIGN KEY (`codeprod`) REFERENCES `produtos` (`codProd`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `itempedido`
--
ALTER TABLE `itempedido`
  ADD CONSTRAINT `fk_itempedido_pedido` FOREIGN KEY (`codeped`) REFERENCES `pedido` (`codepedido`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_itempedido_pedidorev` FOREIGN KEY (`codepedrev`) REFERENCES `pedidorev` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_itempedido_produtos` FOREIGN KEY (`codeprod`) REFERENCES `produtos` (`codProd`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `cdaddress` FOREIGN KEY (`enderentrega`) REFERENCES `address` (`codeaddress`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `cduser` FOREIGN KEY (`codeuser`) REFERENCES `user` (`codeuser`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `pedidorev`
--
ALTER TABLE `pedidorev`
  ADD CONSTRAINT `fk_pedidorev_address` FOREIGN KEY (`enderentrega`) REFERENCES `address` (`codeaddress`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pedidorev_revenda` FOREIGN KEY (`coderev`) REFERENCES `revenda` (`coderevenda`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `fk_produtos_adm` FOREIGN KEY (`codadm`) REFERENCES `adm` (`codeAdm`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `promotions`
--
ALTER TABLE `promotions`
  ADD CONSTRAINT `fk_promotions_produtos` FOREIGN KEY (`codeprod`) REFERENCES `produtos` (`codProd`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

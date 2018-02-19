-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 16, 2018 at 06:15 PM
-- Server version: 5.7.19
-- PHP Version: 7.0.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sgt`
--

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `SP_activar_cliente`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_activar_cliente` (`id` INT)  BEGIN

UPDATE clientes SET activo = 1
	WHERE clientes.id = id;

END$$

DROP PROCEDURE IF EXISTS `SP_activar_fornecedor`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_activar_fornecedor` (`id` INT)  BEGIN

UPDATE fornecedors SET activo = 1
	WHERE fornecedors.id = id;

END$$

DROP PROCEDURE IF EXISTS `SP_decrementar_qtd_produto`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_decrementar_qtd_produto` (`valor` INT, `prod_id` INT)  BEGIN    
   UPDATE produtos SET produtos.quantidade_dispo = produtos.quantidade_dispo - valor WHERE produtos.id = prod_id;
END$$

DROP PROCEDURE IF EXISTS `SP_decrementar_valor_total_cotacao`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_decrementar_valor_total_cotacao` (`valor` DECIMAL, `cotacao_id` INT)  BEGIN    
   UPDATE cotacaos SET cotacaos.valor_total = cotacaos.valor_total - valor WHERE cotacaos.id = cotacao_id;
END$$

DROP PROCEDURE IF EXISTS `SP_desactivar_cliente`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_desactivar_cliente` (`id` INT)  BEGIN

UPDATE clientes SET activo = 0
	WHERE clientes.id = id;

END$$

DROP PROCEDURE IF EXISTS `SP_desactivar_fornecedor`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_desactivar_fornecedor` (`id` INT)  BEGIN

UPDATE fornecedors SET activo = 0
	WHERE fornecedors.id = id;

END$$

DROP PROCEDURE IF EXISTS `SP_incrementar_qtd_produto`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_incrementar_qtd_produto` (`valor` INT, `prod_id` INT)  BEGIN    
   UPDATE produtos SET produtos.quantidade_dispo = produtos.quantidade_dispo + valor WHERE produtos.id = prod_id;
END$$

DROP PROCEDURE IF EXISTS `SP_incrementar_valor_total_cotacao`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_incrementar_valor_total_cotacao` (`valor` DECIMAL, `cotacao_id` INT)  BEGIN    
   UPDATE cotacaos SET cotacaos.valor_total = cotacaos.valor_total + valor WHERE cotacaos.id = cotacao_id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categorias`
--

INSERT INTO `categorias` (`id`, `nome`) VALUES
(1, 'Toner'),
(2, 'Papel'),
(3, 'Ferramenta');

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
CREATE TABLE IF NOT EXISTS `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) NOT NULL,
  `endereco` varchar(60) DEFAULT NULL,
  `telefone` varchar(15) NOT NULL,
  `nuit` mediumtext,
  `email` varchar(60) DEFAULT NULL,
  `activo` tinyint(1) UNSIGNED NOT NULL,
  `tipo_cliente_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  KEY `fk_tipo_cliente_id_idx` (`tipo_cliente_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clientes`
--

INSERT INTO `clientes` (`id`, `nome`, `endereco`, `telefone`, `nuit`, `email`, `activo`, `tipo_cliente_id`) VALUES
(1, 'SaraPrinter', 'Rua das Estancias', '+258827364287', '1234567890', 'saraprinters@gmail.com', 1, 1),
(2, 'Liibomo', 'Casa dos Bicos', '+258829364274', '1234567890', 'libomo@gmail.com', 0, 2),
(3, 'Mira', 'Rua das Albes, Xai-Xai', '+258847062789', '123094725', 'mira@gmail.com', 1, 3),
(4, 'Mira', 'Rua das Albes, Xai-Xai', '+258847062789', '123094725', 'mira2@gmail.com', 0, 1),
(5, 'Meca', 'Av. 24 de Julho', '+258847062789', '3840938184', 'meca@gmail.com', 1, 2),
(6, 'InfoService', 'Av. Juliu Nherere', '+258847892264', '1234567890', 'infoservice@gmail.com', 1, 3),
(7, 'Casa Printer', 'Av, Karl Max', '+258847062789', '8936510378', 'casaprinter@gmail.com', 1, 1),
(8, 'Osorio', 'Av, Karl Max', '+258847062781', '1239503185', 'osorio@gmail.com', 1, 2),
(9, 'Sahara', 'Av Martires da Revolucao - Maputo', '+258847062781', '4875028493', 'sahara@gmail.com', 1, 1),
(10, 'LAGERT', 'Rua Xa2', '+258847892264', '1234567835', 'lagert@hotmail.com', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cotacaos`
--

DROP TABLE IF EXISTS `cotacaos`;
CREATE TABLE IF NOT EXISTS `cotacaos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `valor_total` decimal(8,2) DEFAULT NULL,
  `cliente_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tipo_cotacao_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`,`cliente_id`,`user_id`),
  KEY `fk_cotacaos_clientes1_idx` (`cliente_id`),
  KEY `fk_cotacaos_users1_idx` (`user_id`),
  KEY `fk_cotacaos_tipo_cotacaos1_idx` (`tipo_cotacao_id`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cotacaos`
--

INSERT INTO `cotacaos` (`id`, `data`, `valor_total`, `cliente_id`, `user_id`, `tipo_cotacao_id`) VALUES
(89, '2018-02-15 15:19:16', '14100.00', 1, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `entradas`
--

DROP TABLE IF EXISTS `entradas`;
CREATE TABLE IF NOT EXISTS `entradas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `valor` decimal(8,2) NOT NULL DEFAULT '0.00',
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`user_id`),
  KEY `fk_entradas_usuariosistemas1_idx` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `entradas`
--

INSERT INTO `entradas` (`id`, `data`, `valor`, `user_id`) VALUES
(1, '2018-01-20 15:40:54', '300.00', 3);

-- --------------------------------------------------------

--
-- Table structure for table `fornecedors`
--

DROP TABLE IF EXISTS `fornecedors`;
CREATE TABLE IF NOT EXISTS `fornecedors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `endereco` varchar(150) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `telefone` varchar(15) NOT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `rubrica` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fornecedors`
--

INSERT INTO `fornecedors` (`id`, `nome`, `endereco`, `email`, `telefone`, `activo`, `rubrica`) VALUES
(1, 'META LTD', 'Av. Samuel Magaia', 'meta@gmail.com', '+258849273298', 1, 'concurso'),
(2, 'SISO', 'Rua das Mangueiras', 'siso@gmail.com', '+258824961046', 1, 'concurso'),
(3, 'CENA GRAFICA', 'Av, Karl Max', 'cena@gmail.com', '+258847062781', 1, 'concurso'),
(4, 'JOSTA LDA', 'Av. Martires da Revolucao', 'josta@gmail.com', '+258847892264', 0, 'memorando'),
(5, 'Cerigrafia Melo', 'Av, Karl Max', 'cerigrafia@gmail.com', '+258847062781', 1, 'memorando'),
(6, 'Paper Seal', 'Av, Karl Max', 'papermemorando@gmail.com', '+258847062781', 0, 'memorando'),
(7, 'INE', 'Av. 24 de Julho', 'ine@gmail.com', '+258847892264', 1, 'memorando'),
(8, 'Fornecedor Teste', 'Rua Fornecedor', 'fornecedor@gmail.com', '+258847062781', 0, 'fornecedor'),
(9, 'Teste 2', 'teste 2', 'teste2@gmail.com', '+258847062781', NULL, 'teste2'),
(10, 'Fornecedor2', 'fornecedor', 'for@gmail.com', '+258847062781', 1, 'fornecedor'),
(12, 'Fornecedor 20', 'Av. Samuel Magaia', 'f@gmail.com', '+258845368772', 1, 'concurso'),
(13, 'Fornecedor 21', 'Rua das Mangueiras', 'f21@gmail.com', '+258845368123', 1, 'concurso'),
(14, 'Fornecedor 22', 'Av, Karl Max', 'f22@gmail.com', '+258847062781', 1, 'concurso');

-- --------------------------------------------------------

--
-- Table structure for table `iten_cotacaos`
--

DROP TABLE IF EXISTS `iten_cotacaos`;
CREATE TABLE IF NOT EXISTS `iten_cotacaos` (
  `quantidade` int(11) NOT NULL,
  `valor` decimal(8,2) NOT NULL,
  `cotacao_id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `desconto` int(11) NOT NULL DEFAULT '0',
  `subtotal` decimal(8,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `composite_cotacao_id_produto_id` (`cotacao_id`,`produto_id`),
  KEY `fk_itencotacaos_cotacaos1_idx` (`cotacao_id`),
  KEY `fk_itencotacaos_produtos1_idx` (`produto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `iten_cotacaos`
--

INSERT INTO `iten_cotacaos` (`quantidade`, `valor`, `cotacao_id`, `produto_id`, `created_at`, `updated_at`, `id`, `desconto`, `subtotal`) VALUES
(2, '3600.00', 89, 9, '2018-02-15 13:19:16', '2018-02-15 18:34:57', 54, 0, '3600.00'),
(10, '2500.00', 89, 8, '2018-02-15 13:19:16', '2018-02-15 13:19:16', 55, 0, '2500.00'),
(10, '8000.00', 89, 5, '2018-02-15 19:39:43', '2018-02-15 19:40:56', 63, 0, '8000.00');

--
-- Triggers `iten_cotacaos`
--
DROP TRIGGER IF EXISTS `tr_actuatlizar_valor_total_after_UPDATE`;
DELIMITER $$
CREATE TRIGGER `tr_actuatlizar_valor_total_after_UPDATE` AFTER UPDATE ON `iten_cotacaos` FOR EACH ROW BEGIN

	DECLARE valor decimal;
	
	IF NEW.subtotal > OLD.subtotal THEN
	SET @valor = NEW.subtotal - OLD.subtotal;

	CALL SP_incrementar_valor_total_cotacao(@valor, NEW.cotacao_id);

	ELSEIF NEW.subtotal <= OLD.subtotal THEN
	SET @valor = OLD.subtotal - NEW.subtotal;

	CALL SP_decrementar_valor_total_cotacao(@valor, NEW.cotacao_id);
	
	END IF;

END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `tr_actuatlizar_valor_total_after_delete`;
DELIMITER $$
CREATE TRIGGER `tr_actuatlizar_valor_total_after_delete` AFTER DELETE ON `iten_cotacaos` FOR EACH ROW BEGIN
	CALL SP_decrementar_valor_total_cotacao(OLD.subtotal, OLD.cotacao_id);
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `tr_actuatlizar_valor_total_after_insert`;
DELIMITER $$
CREATE TRIGGER `tr_actuatlizar_valor_total_after_insert` AFTER INSERT ON `iten_cotacaos` FOR EACH ROW BEGIN
	CALL SP_incrementar_valor_total_cotacao(NEW.subtotal, NEW.cotacao_id);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `iten_entradas`
--

DROP TABLE IF EXISTS `iten_entradas`;
CREATE TABLE IF NOT EXISTS `iten_entradas` (
  `quantidade` int(11) NOT NULL,
  `valor` decimal(8,2) NOT NULL,
  `entrada_id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  PRIMARY KEY (`entrada_id`,`produto_id`),
  KEY `fk_itenentradas_entradas1_idx` (`entrada_id`),
  KEY `fk_itenentradas_produtos1_idx` (`produto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `iten_entradas`
--

INSERT INTO `iten_entradas` (`quantidade`, `valor`, `entrada_id`, `produto_id`) VALUES
(2, '300.00', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `iten_saidas`
--

DROP TABLE IF EXISTS `iten_saidas`;
CREATE TABLE IF NOT EXISTS `iten_saidas` (
  `quantidade` int(11) NOT NULL,
  `valor` decimal(8,2) NOT NULL,
  `saida_id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  PRIMARY KEY (`saida_id`,`produto_id`),
  KEY `fk_itensaidas_saidas1_idx` (`saida_id`),
  KEY `fk_itensaidas_produtos1_idx` (`produto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `iten_saidas`
--

INSERT INTO `iten_saidas` (`quantidade`, `valor`, `saida_id`, `produto_id`) VALUES
(5, '750.00', 1, 1),
(3, '450.00', 2, 1),
(5, '250.00', 2, 2),
(8, '70.00', 3, 3);

--
-- Triggers `iten_saidas`
--
DROP TRIGGER IF EXISTS `actuatlizar_quantidade_disponivel_after_UPDATE`;
DELIMITER $$
CREATE TRIGGER `actuatlizar_quantidade_disponivel_after_UPDATE` AFTER UPDATE ON `iten_saidas` FOR EACH ROW BEGIN

	DECLARE valor int;
	
	IF NEW.quantidade > OLD.quantidade THEN
	SET @valor = NEW.quantidade - OLD.quantidade;

	CALL SP_decrementar_qtd_produto(@valor, NEW.produto_id);

	ELSEIF NEW.quantidade < OLD.quantidade THEN
	SET @valor = OLD.quantidade - NEW.quantidade;

	CALL SP_incrementar_qtd_produto(@valor, NEW.produto_id);
	
	END IF;

END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `actuatlizar_quantidade_disponivel_after_insert`;
DELIMITER $$
CREATE TRIGGER `actuatlizar_quantidade_disponivel_after_insert` AFTER INSERT ON `iten_saidas` FOR EACH ROW UPDATE produtos SET produtos.quantidade_dispo = produtos.quantidade_dispo - New.quantidade 
    WHERE produtos.id = NEW.produto_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `permissaos`
--

DROP TABLE IF EXISTS `permissaos`;
CREATE TABLE IF NOT EXISTS `permissaos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permissaos`
--

INSERT INTO `permissaos` (`id`, `nome`) VALUES
(1, 'gerir_usuario'),
(2, 'geriri_produto'),
(3, 'geriri_fornecedor');

-- --------------------------------------------------------

--
-- Table structure for table `permissaos_roles`
--

DROP TABLE IF EXISTS `permissaos_roles`;
CREATE TABLE IF NOT EXISTS `permissaos_roles` (
  `permissao_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`permissao_id`,`role_id`),
  KEY `fk_permissaos_has_tipousuarios_tipousuarios1_idx` (`role_id`),
  KEY `fk_permissaos_has_tipousuarios_permissaos1_idx` (`permissao_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permissaos_roles`
--

INSERT INTO `permissaos_roles` (`permissao_id`, `role_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `produtos`
--

DROP TABLE IF EXISTS `produtos`;
CREATE TABLE IF NOT EXISTS `produtos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(160) DEFAULT NULL,
  `preco_venda` decimal(8,2) DEFAULT NULL,
  `preco_aquisicao` decimal(8,2) DEFAULT NULL,
  `quantidade_dispo` int(11) DEFAULT NULL,
  `quantidade_min` int(11) NOT NULL,
  `fornecedor_id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`fornecedor_id`,`categoria_id`),
  KEY `fk_produtos_fornecedores_idx` (`fornecedor_id`),
  KEY `fk_produtos_categorias1_idx` (`categoria_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `produtos`
--

INSERT INTO `produtos` (`id`, `descricao`, `preco_venda`, `preco_aquisicao`, `quantidade_dispo`, `quantidade_min`, `fornecedor_id`, `categoria_id`) VALUES
(1, 'Agrafador', '150.00', '140.00', 39, 20, 4, 3),
(2, 'Agrafos', '50.00', '40.00', 30, 15, 3, 3),
(3, 'Blocos pautadoa a4', '75.00', '70.00', 250, 20, 3, 3),
(4, 'Blocos pautados a5', '50.25', '48.00', 240, 20, 3, 2),
(5, 'Agrafador TRIO W', '800.00', '750.00', 100, 20, 1, 3),
(6, 'Afiador metalico', '15.00', '13.00', 300, 20, 1, 3),
(7, 'Produto Teste', '150.00', '145.00', 300, 20, 2, 1),
(8, 'Compasso D2', '250.00', '235.00', 140, 20, 6, 2),
(9, 'J5', '1800.00', '1650.00', 320, 20, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `nome`) VALUES
(1, 'Administrador'),
(2, 'Usuario_comum');

-- --------------------------------------------------------

--
-- Table structure for table `saidas`
--

DROP TABLE IF EXISTS `saidas`;
CREATE TABLE IF NOT EXISTS `saidas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `valor_total` decimal(8,2) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `desconto` decimal(8,2) DEFAULT NULL,
  `subtotal` decimal(8,2) DEFAULT NULL,
  `data_edicao` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`user_id`,`cliente_id`),
  KEY `fk_saidas_usuariosistemas1_idx` (`user_id`),
  KEY `fk_saidas_clientes1_idx` (`cliente_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `saidas`
--

INSERT INTO `saidas` (`id`, `data`, `valor_total`, `user_id`, `cliente_id`, `desconto`, `subtotal`, `data_edicao`) VALUES
(1, '2018-01-20 15:53:37', '750.00', 3, 1, '0.00', '600.00', '2018-01-21 14:09:36'),
(2, '2018-01-20 17:30:07', '700.00', 3, 2, '0.00', '700.00', '2018-01-20 18:41:58'),
(3, '2018-01-21 12:20:53', '280.00', 4, 1, '0.00', '280.00', '2018-01-21 12:24:59');

-- --------------------------------------------------------

--
-- Table structure for table `tipo_clientes`
--

DROP TABLE IF EXISTS `tipo_clientes`;
CREATE TABLE IF NOT EXISTS `tipo_clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_cliente` varchar(45) NOT NULL,
  `descricao` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tipo_clientes`
--

INSERT INTO `tipo_clientes` (`id`, `tipo_cliente`, `descricao`) VALUES
(1, 'anonimo', 'anonimo'),
(2, 'Instituicao Publica', 'Instituicoes Publicas'),
(3, 'Instituicao Privada', 'Instituicoes Privadas'),
(4, 'Novo Tipo', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tipo_cotacaos`
--

DROP TABLE IF EXISTS `tipo_cotacaos`;
CREATE TABLE IF NOT EXISTS `tipo_cotacaos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) DEFAULT NULL,
  `descricao` varchar(150) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tipo_cotacaos`
--

INSERT INTO `tipo_cotacaos` (`id`, `nome`, `descricao`, `created_at`, `updated_at`) VALUES
(1, 'Proforma', 'Cotacao Proforma', '2018-02-15 23:59:57', '2018-02-15 23:59:57'),
(2, 'Normal', 'Cotacao Normal', '2018-02-15 23:59:57', '2018-02-16 09:37:52'),
(6, 'Cotacao', 'Mais um tipo de cotacao', '2018-02-16 05:37:09', '2018-02-16 05:37:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `username` varchar(60) NOT NULL,
  `password` varchar(255) NOT NULL,
  `endereco` varchar(160) DEFAULT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `email` varchar(60) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `active` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`,`role_id`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  KEY `fk_usuariosistemas_tipousuarios1_idx` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `endereco`, `telefone`, `role_id`, `email`, `remember_token`, `created_at`, `updated_at`, `active`) VALUES
(3, 'Osorio Cassiano Malache', 'osoriocassiano', '$2y$10$WMgOYxM5ZceEO2sZUziJVOKIQYMEKsEkMWbKgDrt1a1pkWzk0FUa6', NULL, NULL, 1, 'osoriocassiano@gmail.com', '2Sjyy96iL5OKlu0dJRVZBy73E5D5wNAs0KBG5NbukNEmfzQNsBtyaAPapVzs', '2018-01-20 23:33:54', '2018-01-23 19:47:00', 1),
(4, 'Carlos Manhique', 'carlosmanhique', '$2y$10$bZNJptqSOS1GdRx0uRT6BuGqozCsUR1uik60YGGUOgLpp1y2LpVFu', NULL, NULL, 1, 'carlosmanhique@gmail.com', 'NnoiGwfy0S', '2018-01-20 23:33:54', '2018-01-20 23:33:54', 1),
(5, 'Ossmane Dos Prazeres', 'ossmane', '$2y$10$ULjEX8ds1EewDnkM/vf7peP8XnogLxDL5rFjcwGkUYLaviXuZGjyy', NULL, NULL, 1, 'ossmane@gmail.com', 'NP3UIfUQuL', '2018-01-20 23:33:54', '2018-01-20 23:33:54', 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `fk_tipo_cliente_id` FOREIGN KEY (`tipo_cliente_id`) REFERENCES `tipo_clientes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `cotacaos`
--
ALTER TABLE `cotacaos`
  ADD CONSTRAINT `fk_cotacaos_clientes1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cotacaos_tipo_cotacaos1` FOREIGN KEY (`tipo_cotacao_id`) REFERENCES `tipo_cotacaos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cotacaos_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `entradas`
--
ALTER TABLE `entradas`
  ADD CONSTRAINT `fk_entradas_usuariosistemas1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `iten_cotacaos`
--
ALTER TABLE `iten_cotacaos`
  ADD CONSTRAINT `fk_itencotacaos_cotacaos1` FOREIGN KEY (`cotacao_id`) REFERENCES `cotacaos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_itencotacaos_produtos1` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `iten_entradas`
--
ALTER TABLE `iten_entradas`
  ADD CONSTRAINT `fk_itenentradas_entradas1` FOREIGN KEY (`entrada_id`) REFERENCES `entradas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_itenentradas_produtos1` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `iten_saidas`
--
ALTER TABLE `iten_saidas`
  ADD CONSTRAINT `fk_itensaidas_produtos1` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_itensaidas_saidas1` FOREIGN KEY (`saida_id`) REFERENCES `saidas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `permissaos_roles`
--
ALTER TABLE `permissaos_roles`
  ADD CONSTRAINT `fk_permissaos_has_tipousuarios_permissaos1` FOREIGN KEY (`permissao_id`) REFERENCES `permissaos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_permissaos_has_tipousuarios_tipousuarios1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `fk_produtos_categorias1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_produtos_fornecedores` FOREIGN KEY (`fornecedor_id`) REFERENCES `fornecedors` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `saidas`
--
ALTER TABLE `saidas`
  ADD CONSTRAINT `fk_saidas_clientes1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_saidas_usuariosistemas1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_usuariosistemas_tipousuarios1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

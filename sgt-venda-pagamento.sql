-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 13, 2018 at 09:01 PM
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

DROP PROCEDURE IF EXISTS `SP_decrementar_rest_iten_saidas`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_decrementar_rest_iten_saidas` (`qtd` INT, `saida_id` INT, `produto_id` INT)  BEGIN    

	DECLARE qtd_rest_old int;
	DECLARE qtd_rest_new int;
	DECLARE preco_venda decimal;
	DECLARE valor decimal;
	DECLARE desconto int;
	DECLARE subtotal decimal;
	
	SET @qtd_rest_old = (SELECT iten_saidas.quantidade_rest FROM iten_saidas WHERE iten_saidas.produto_id = produto_id AND iten_saidas.saida_id = saida_id);
	SET @preco_venda = (SELECT produtos.preco_venda FROM produtos WHERE produtos.id = produto_id);
	SET @desconto = (SELECT iten_saidas.desconto FROM iten_saidas WHERE iten_saidas.produto_id = produto_id AND iten_saidas.saida_id = saida_id);
	
	SET @qtd_rest_new = (@qtd_rest_old - qtd);
	
	SET @valor = (@qtd_rest_new * @preco_venda);
	SET @subtotal = ((@qtd_rest_new * @preco_venda) - (@qtd_rest_new * @preco_venda * @desconto) / 100);

	UPDATE iten_saidas SET iten_saidas.quantidade_rest = @qtd_rest_new,
	iten_saidas.valor_rest = @valor,
		iten_saidas.subtotal_rest = @subtotal
		WHERE iten_saidas.saida_id = saida_id AND
			iten_saidas.produto_id = produto_id;
END$$

DROP PROCEDURE IF EXISTS `SP_decrementar_valor_total_cotacao`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_decrementar_valor_total_cotacao` (`valor` DECIMAL, `cotacao_id` INT)  BEGIN    
   UPDATE cotacaos SET cotacaos.valor_total = cotacaos.valor_total - valor WHERE cotacaos.id = cotacao_id;
END$$

DROP PROCEDURE IF EXISTS `SP_decrementar_valor_total_guia_entrega`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_decrementar_valor_total_guia_entrega` (`valor` DECIMAL, `id` INT)  BEGIN    
   UPDATE guia_entregas SET guia_entregas.valor_total= guia_entregas.valor_total - valor WHERE guia_entregas.id = id;
END$$

DROP PROCEDURE IF EXISTS `SP_decrementar_valor_total_saida`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_decrementar_valor_total_saida` (`valor` DECIMAL, `id` INT)  BEGIN    
   UPDATE saidas SET saidas.valor_total = saidas.valor_total - valor WHERE saidas.id = id;
END$$

DROP PROCEDURE IF EXISTS `SP_decrementar_valor_total_venda`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_decrementar_valor_total_venda` (`valor` DECIMAL, `id` INT)  BEGIN    
   UPDATE vendas SET vendas.valor_total = vendas.valor_total - valor WHERE vendas.id = id;
END$$

DROP PROCEDURE IF EXISTS `SP_delete_iten_guiaentregas`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_delete_iten_guiaentregas` (`id` INT)  BEGIN
	DELETE FROM iten_guiaentregas WHERE iten_guiaentregas.guia_entrega_id = id;
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

DROP PROCEDURE IF EXISTS `SP_incrementar_rest_iten_saidas`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_incrementar_rest_iten_saidas` (`qtd` INT, `saida_id` INT, `produto_id` INT)  BEGIN    
	DECLARE qtd_rest_old int;
	DECLARE qtd_rest_new int;
	DECLARE preco_venda decimal;
	DECLARE valor decimal;
	DECLARE desconto int;
	DECLARE subtotal decimal;
	
	SET @qtd_rest_old = (SELECT iten_saidas.quantidade_rest FROM iten_saidas WHERE iten_saidas.produto_id = produto_id AND iten_saidas.saida_id = saida_id);
	SET @preco_venda = (SELECT produtos.preco_venda FROM produtos WHERE produtos.id = produto_id);
	SET @desconto = (SELECT iten_saidas.desconto FROM iten_saidas WHERE iten_saidas.produto_id = produto_id AND iten_saidas.saida_id = saida_id);
	
	SET @qtd_rest_new = (@qtd_rest_old + qtd);
	
	SET @valor = (@qtd_rest_new * @preco_venda);
	SET @subtotal = ((@qtd_rest_new * @preco_venda) - (@qtd_rest_new * @preco_venda * @desconto) / 100);

	UPDATE iten_saidas SET iten_saidas.quantidade_rest = @qtd_rest_new,
	iten_saidas.valor_rest = @valor,
		iten_saidas.subtotal_rest = @subtotal
		WHERE iten_saidas.saida_id = saida_id AND
			iten_saidas.produto_id = produto_id;
END$$

DROP PROCEDURE IF EXISTS `SP_incrementar_valor_total_cotacao`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_incrementar_valor_total_cotacao` (`valor` DECIMAL, `cotacao_id` INT)  BEGIN    
   UPDATE cotacaos SET cotacaos.valor_total = cotacaos.valor_total + valor WHERE cotacaos.id = cotacao_id;
END$$

DROP PROCEDURE IF EXISTS `SP_incrementar_valor_total_guia_entrega`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_incrementar_valor_total_guia_entrega` (`valor` DECIMAL, `id` INT)  BEGIN    
   UPDATE guia_entregas SET guia_entregas.valor_total= guia_entregas.valor_total + valor WHERE guia_entregas.id = id;
END$$

DROP PROCEDURE IF EXISTS `SP_incrementar_valor_total_saida`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_incrementar_valor_total_saida` (`valor` DECIMAL, `id` INT)  BEGIN    
   UPDATE saidas SET saidas.valor_total = saidas.valor_total + valor WHERE saidas.id = id;
END$$

DROP PROCEDURE IF EXISTS `SP_incrementar_valor_total_venda`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_incrementar_valor_total_venda` (`valor` DECIMAL, `id` INT)  BEGIN    
   UPDATE vendas SET vendas.valor_total = vendas.valor_total + valor WHERE vendas.id = id;
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
  `tipo_cotacao_id` int(11) DEFAULT '1',
  PRIMARY KEY (`id`,`cliente_id`,`user_id`),
  KEY `fk_cotacaos_clientes1_idx` (`cliente_id`),
  KEY `fk_cotacaos_users1_idx` (`user_id`),
  KEY `fk_cotacaos_tipo_cotacaos1_idx` (`tipo_cotacao_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cotacaos`
--

INSERT INTO `cotacaos` (`id`, `data`, `valor_total`, `cliente_id`, `user_id`, `tipo_cotacao_id`) VALUES
(1, '2018-03-10 08:43:28', '30.00', 1, 3, NULL),
(2, '2018-03-13 20:48:01', '790.00', 9, 3, NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `forma_pagamentos`
--

DROP TABLE IF EXISTS `forma_pagamentos`;
CREATE TABLE IF NOT EXISTS `forma_pagamentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(45) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `forma_pagamentos`
--

INSERT INTO `forma_pagamentos` (`id`, `descricao`, `created_at`, `updated_at`) VALUES
(1, 'Nenhum', '2018-03-12 09:11:58', NULL),
(2, 'Dinheiro Vivo', '2018-03-12 09:11:58', NULL),
(3, 'Cheque', '2018-03-12 19:02:20', NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

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
(7, 'INE', 'Av. 24 de Julho', 'ine@gmail.com', '+258847892264', 1, 'memorando');

-- --------------------------------------------------------

--
-- Table structure for table `guia_entregas`
--

DROP TABLE IF EXISTS `guia_entregas`;
CREATE TABLE IF NOT EXISTS `guia_entregas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `valor_total` decimal(8,2) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `saida_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_guiaentregas_clientes1_idx` (`cliente_id`),
  KEY `fk_guiaentregas_users1_idx` (`user_id`),
  KEY `fk_guiaentregas_saidas1_idx` (`saida_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `guia_entregas`
--

INSERT INTO `guia_entregas` (`id`, `valor_total`, `cliente_id`, `user_id`, `created_at`, `updated_at`, `saida_id`) VALUES
(1, '170.00', 10, 3, '2018-03-13 18:45:54', '2018-03-13 18:45:54', 1),
(2, '150.00', 7, 3, '2018-03-13 18:46:13', '2018-03-13 18:46:13', 2),
(3, '330.00', 7, 3, '2018-03-13 18:46:53', '2018-03-13 18:46:53', 2);

--
-- Triggers `guia_entregas`
--
DROP TRIGGER IF EXISTS `tr_delete_iten_guia_entregas_after_delete`;
DELIMITER $$
CREATE TRIGGER `tr_delete_iten_guia_entregas_after_delete` AFTER DELETE ON `guia_entregas` FOR EACH ROW BEGIN
	CALL SP_delete_iten_guiaentregas(OLD.id);
END
$$
DELIMITER ;

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `iten_cotacaos`
--

INSERT INTO `iten_cotacaos` (`quantidade`, `valor`, `cotacao_id`, `produto_id`, `created_at`, `updated_at`, `id`, `desconto`, `subtotal`) VALUES
(2, '30.00', 1, 10, '2018-03-10 06:43:28', '2018-03-10 06:43:28', 1, 0, '30.00'),
(5, '425.00', 2, 23, '2018-03-13 18:48:02', '2018-03-13 18:48:02', 2, 0, '425.00'),
(5, '125.00', 2, 22, '2018-03-13 18:48:02', '2018-03-13 18:48:02', 3, 0, '125.00'),
(5, '240.00', 2, 20, '2018-03-13 18:48:02', '2018-03-13 18:48:02', 4, 0, '240.00');

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

-- --------------------------------------------------------

--
-- Table structure for table `iten_guiaentregas`
--

DROP TABLE IF EXISTS `iten_guiaentregas`;
CREATE TABLE IF NOT EXISTS `iten_guiaentregas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quantidade` int(11) NOT NULL DEFAULT '0',
  `valor` decimal(8,2) NOT NULL DEFAULT '0.00',
  `produto_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `desconto` int(11) NOT NULL,
  `subtotal` decimal(8,2) NOT NULL DEFAULT '0.00',
  `guia_entrega_id` int(11) NOT NULL,
  `iten_saida_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_iten_guiaentregas_guia_entregas1_idx` (`guia_entrega_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `iten_guiaentregas`
--

INSERT INTO `iten_guiaentregas` (`id`, `quantidade`, `valor`, `produto_id`, `created_at`, `updated_at`, `desconto`, `subtotal`, `guia_entrega_id`, `iten_saida_id`) VALUES
(1, 2, '170.00', 23, '2018-03-13 18:45:54', '2018-03-13 18:45:54', 0, '170.00', 1, 1),
(2, 2, '150.00', 12, '2018-03-13 18:46:13', '2018-03-13 18:46:13', 0, '150.00', 2, 2),
(3, 0, '0.00', 13, '2018-03-13 18:46:14', '2018-03-13 18:46:14', 0, '0.00', 2, 3),
(4, 1, '75.00', 12, '2018-03-13 18:46:53', '2018-03-13 18:46:53', 0, '75.00', 3, 2),
(5, 3, '255.00', 13, '2018-03-13 18:46:53', '2018-03-13 18:46:53', 0, '255.00', 3, 3);

--
-- Triggers `iten_guiaentregas`
--
DROP TRIGGER IF EXISTS `tr_actuatlizar_rest_iten_saidas_after_insert`;
DELIMITER $$
CREATE TRIGGER `tr_actuatlizar_rest_iten_saidas_after_insert` AFTER INSERT ON `iten_guiaentregas` FOR EACH ROW BEGIN
	DECLARE saida_id int;
	DECLARE produto_id int;

	SET @saida_id = (SELECT guia_entregas.saida_id FROM guia_entregas, iten_guiaentregas
					WHERE iten_guiaentregas.guia_entrega_id = guia_entregas.id AND
						iten_guiaentregas.guia_entrega_id = NEW.guia_entrega_id AND
							iten_guiaentregas.produto_id = NEW.produto_id);

	SET @produto_id = NEW.produto_id;

	CALL SP_incrementar_valor_total_guia_entrega(NEW.subtotal, NEW.guia_entrega_id);
	CALL SP_decrementar_rest_iten_saidas(NEW.quantidade, @saida_id, @produto_id);
	CALL SP_decrementar_qtd_produto(NEW.quantidade, NEW.produto_id);

END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `tr_actuatlizar_rest_iten_saidas_after_update`;
DELIMITER $$
CREATE TRIGGER `tr_actuatlizar_rest_iten_saidas_after_update` AFTER UPDATE ON `iten_guiaentregas` FOR EACH ROW BEGIN
	DECLARE saida_id int;
	DECLARE produto_id int;
	DECLARE quantidade int;
	DECLARE subtotal decimal;

	SET @saida_id = (SELECT guia_entregas.saida_id FROM guia_entregas, iten_guiaentregas
					WHERE iten_guiaentregas.guia_entrega_id = guia_entregas.id AND
						iten_guiaentregas.guia_entrega_id = NEW.guia_entrega_id AND
							iten_guiaentregas.produto_id = NEW.produto_id);

	SET @produto_id = NEW.produto_id;
	

	IF NEW.quantidade > OLD.quantidade THEN
		SET @quantidade = NEW.quantidade - OLD.quantidade;
		CALL SP_decrementar_qtd_produto(@quantidade, NEW.produto_id);
		CALL SP_decrementar_rest_iten_saidas(@quantidade, @saida_id, @produto_id);

	ELSEIF NEW.quantidade <= OLD.quantidade THEN
		SET @quantidade = OLD.quantidade - NEW.quantidade;
		CALL SP_incrementar_rest_iten_saidas(@quantidade, @saida_id, @produto_id);
	END IF;

	IF NEW.subtotal > OLD.subtotal THEN
		SET @subtotal = NEW.subtotal - OLD.subtotal;
		CALL SP_incrementar_valor_total_guia_entrega(@subtotal, NEW.guia_entrega_id);

	ELSEIF NEW.subtotal <= OLD.subtotal THEN
		SET @subtotal = OLD.subtotal - NEW.subtotal;
		CALL SP_decrementar_valor_total_guia_entrega(@subtotal, NEW.guia_entrega_id);
	END IF;
	

END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `tr_actuatlizar_rest_iten_saidas_before_delete`;
DELIMITER $$
CREATE TRIGGER `tr_actuatlizar_rest_iten_saidas_before_delete` BEFORE DELETE ON `iten_guiaentregas` FOR EACH ROW BEGIN
	DECLARE saida_id int;
	DECLARE produto_id int;

	SET @saida_id = (SELECT DISTINCT guia_entregas.saida_id FROM guia_entregas, iten_guiaentregas
					WHERE guia_entregas.id = OLD.guia_entrega_id AND 
						iten_guiaentregas.produto_id = OLD.produto_id);

	SET @produto_id = OLD.produto_id;

	CALL SP_incrementar_rest_iten_saidas(OLD.quantidade, @saida_id, @produto_id);
	CALL SP_incrementar_qtd_produto(OLD.quantidade, @produto_id);
END
$$
DELIMITER ;

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
  `desconto` int(11) NOT NULL DEFAULT '0',
  `subtotal` decimal(8,2) NOT NULL DEFAULT '0.00',
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `quantidade_rest` int(11) NOT NULL DEFAULT '0',
  `valor_rest` decimal(8,2) NOT NULL DEFAULT '0.00',
  `subtotal_rest` decimal(8,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`,`saida_id`,`produto_id`),
  KEY `fk_itensaidas_saidas1_idx` (`saida_id`),
  KEY `fk_itensaidas_produtos1_idx` (`produto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `iten_saidas`
--

INSERT INTO `iten_saidas` (`quantidade`, `valor`, `saida_id`, `produto_id`, `desconto`, `subtotal`, `id`, `created_at`, `updated_at`, `quantidade_rest`, `valor_rest`, `subtotal_rest`) VALUES
(2, '170.00', 1, 23, 0, '170.00', 1, '2018-03-13 09:50:27', '2018-03-13 20:45:54', 0, '0.00', '0.00'),
(4, '300.00', 2, 12, 0, '300.00', 2, '2018-03-13 20:45:29', '2018-03-13 20:46:53', 1, '75.00', '75.00'),
(4, '340.00', 2, 13, 0, '340.00', 3, '2018-03-13 20:45:29', '2018-03-13 20:46:53', 1, '85.00', '85.00');

--
-- Triggers `iten_saidas`
--
DROP TRIGGER IF EXISTS `tr_actuatlizar_iten_saidas_after_update`;
DELIMITER $$
CREATE TRIGGER `tr_actuatlizar_iten_saidas_after_update` AFTER UPDATE ON `iten_saidas` FOR EACH ROW BEGIN

	DECLARE subtotal_dif decimal;
	DECLARE guia_entrega_id int;
	DECLARE produto_id int;

	IF NEW.subtotal > OLD.subtotal THEN
		SET @subtotal_dif = NEW.subtotal - OLD.subtotal;
		CALL SP_incrementar_valor_total_saida(@subtotal_dif, NEW.saida_id);

	ELSEIF NEW.subtotal <= OLD.subtotal THEN
		SET @subtotal_dif = OLD.subtotal - NEW.subtotal;
		CALL SP_decrementar_valor_total_saida(@subtotal_dif, NEW.saida_id);
		
	END IF;

END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `tr_actuatlizar_valor_total_saida_after_delete`;
DELIMITER $$
CREATE TRIGGER `tr_actuatlizar_valor_total_saida_after_delete` AFTER DELETE ON `iten_saidas` FOR EACH ROW BEGIN
	CALL SP_decrementar_valor_total_saida(OLD.subtotal, OLD.saida_id);
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `tr_actuatlizar_valor_total_saida_after_insert`;
DELIMITER $$
CREATE TRIGGER `tr_actuatlizar_valor_total_saida_after_insert` AFTER INSERT ON `iten_saidas` FOR EACH ROW BEGIN
	CALL SP_incrementar_valor_total_saida(NEW.subtotal, NEW.saida_id);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `iten_vendas`
--

DROP TABLE IF EXISTS `iten_vendas`;
CREATE TABLE IF NOT EXISTS `iten_vendas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `produto_id` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `valor` decimal(8,2) NOT NULL,
  `desconto` int(11) NOT NULL,
  `subtotal` decimal(8,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `venda_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `composite_produto_id_venda_id` (`produto_id`,`venda_id`),
  KEY `fk_iten_vendas_produtos1_idx` (`produto_id`),
  KEY `fk_iten_vendas_vendas1_idx` (`venda_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `iten_vendas`
--

INSERT INTO `iten_vendas` (`id`, `produto_id`, `quantidade`, `valor`, `desconto`, `subtotal`, `created_at`, `updated_at`, `venda_id`) VALUES
(2, 20, 1, '48.00', 0, '48.00', '2018-03-12 13:16:26', '2018-03-12 13:16:26', 3),
(3, 19, 2, '150.00', 0, '150.00', '2018-03-13 03:37:55', '2018-03-13 14:03:08', 4),
(5, 11, 2, '900.00', 0, '900.00', '2018-03-13 18:31:47', '2018-03-13 18:31:47', 3);

--
-- Triggers `iten_vendas`
--
DROP TRIGGER IF EXISTS `tr_actuatlizar_valor_total_e_produto_after_insert`;
DELIMITER $$
CREATE TRIGGER `tr_actuatlizar_valor_total_e_produto_after_insert` AFTER INSERT ON `iten_vendas` FOR EACH ROW BEGIN
	DECLARE venda int;
	DECLARE produto_id int;

	SET @venda = NEW.venda_id;

	SET @produto_id = NEW.produto_id;

	CALL SP_incrementar_valor_total_venda(NEW.subtotal, @venda_id);
	CALL SP_decrementar_qtd_produto(NEW.quantidade, NEW.produto_id);

END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `tr_actuatlizar_valor_total_e_produto_after_update`;
DELIMITER $$
CREATE TRIGGER `tr_actuatlizar_valor_total_e_produto_after_update` AFTER UPDATE ON `iten_vendas` FOR EACH ROW BEGIN
	DECLARE venda_id int;
	DECLARE produto_id int;
	DECLARE quantidade int;
	DECLARE subtotal decimal;

	SET @venda_id = NEW.venda_id;

	SET @produto_id = NEW.produto_id;
	

	IF NEW.quantidade > OLD.quantidade THEN
		SET @quantidade = NEW.quantidade - OLD.quantidade;
		CALL SP_decrementar_qtd_produto(@quantidade, NEW.produto_id);

	ELSEIF NEW.quantidade <= OLD.quantidade THEN
		SET @quantidade = OLD.quantidade - NEW.quantidade;
		CALL SP_incrementar_qtd_produto(@quantidade, NEW.produto_id);
	END IF;

	IF NEW.subtotal > OLD.subtotal THEN
		SET @subtotal = NEW.subtotal - OLD.subtotal;
		CALL SP_incrementar_valor_total_venda(@subtotal, @venda_id);

	ELSEIF NEW.subtotal <= OLD.subtotal THEN
		SET @subtotal = OLD.subtotal - NEW.subtotal;
		CALL SP_decrementar_valor_total_venda(@subtotal, @venda_id);
	END IF;
	

END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `tr_actuatlizar_valor_total_venda_after_delete`;
DELIMITER $$
CREATE TRIGGER `tr_actuatlizar_valor_total_venda_after_delete` AFTER DELETE ON `iten_vendas` FOR EACH ROW BEGIN
	CALL SP_decrementar_valor_total_venda(OLD.subtotal, OLD.venda_id);
	CALL SP_incrementar_qtd_produto(OLD.quantidade, OLD.produto_id);
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `tr_actuatlizar_valor_total_venda_after_insert`;
DELIMITER $$
CREATE TRIGGER `tr_actuatlizar_valor_total_venda_after_insert` AFTER INSERT ON `iten_vendas` FOR EACH ROW BEGIN
	CALL SP_incrementar_valor_total_venda(NEW.subtotal, NEW.venda_id);
END
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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `produtos`
--

INSERT INTO `produtos` (`id`, `descricao`, `preco_venda`, `preco_aquisicao`, `quantidade_dispo`, `quantidade_min`, `fornecedor_id`, `categoria_id`) VALUES
(10, 'Afiador metalico', '15.00', '12.00', 51, 50, 1, 3),
(11, 'Afiador de mesa', '450.00', '445.00', 1998, 50, 1, 3),
(12, 'Agrafes 26/6', '75.00', '70.00', 1997, 50, 1, 3),
(13, 'Agrafes 23/23', '85.00', '80.00', 1997, 50, 1, 3),
(14, 'Agrafadorde mesa', '750.00', '740.00', 1997, 50, 1, 3),
(15, 'Agrafador normal', '690.00', '680.00', 2000, 50, 1, 3),
(16, 'Agrafdor normal', '660.00', '650.00', 2000, 50, 1, 3),
(17, 'Agrafador gigante', '4500.00', '4300.00', 1500, 50, 1, 3),
(18, 'Agrafador TRIO W', '750.00', '740.00', 2000, 50, 1, 3),
(19, 'Blocos pautadoa a4', '75.00', '70.00', 1998, 50, 2, 2),
(20, 'Blocos pautados a5', '48.00', '40.00', 1999, 50, 2, 2),
(21, 'Blocos com aspiral a5', '60.00', '55.00', 1998, 50, 2, 2),
(22, 'Cartolina a1', '25.00', '22.00', 50, 50, 2, 2),
(23, 'CDR', '85.00', '80.00', 1998, 50, 3, 3);

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
  `data_edicao` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`user_id`,`cliente_id`),
  KEY `fk_saidas_usuariosistemas1_idx` (`user_id`),
  KEY `fk_saidas_clientes1_idx` (`cliente_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `saidas`
--

INSERT INTO `saidas` (`id`, `data`, `valor_total`, `user_id`, `cliente_id`, `data_edicao`) VALUES
(1, '2018-03-13 09:50:27', '170.00', 3, 10, '2018-03-13 09:50:27'),
(2, '2018-03-13 20:45:29', '640.00', 3, 7, '2018-03-13 20:45:29');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tipo_cotacaos`
--

INSERT INTO `tipo_cotacaos` (`id`, `nome`, `descricao`, `created_at`, `updated_at`) VALUES
(1, 'Proforma', 'Cotacao Proforma', '2018-02-15 23:59:57', '2018-02-15 23:59:57');

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
(3, 'Osorio Cassiano Malache', 'osoriocassiano', '$2y$10$WMgOYxM5ZceEO2sZUziJVOKIQYMEKsEkMWbKgDrt1a1pkWzk0FUa6', NULL, NULL, 1, 'osoriocassiano@gmail.com', '9bUmBrNHVHHKpFaf2PD1nyjFKGDJlvVV5VgZAQCM9C7ccNnANDV67b9easAM', '2018-01-20 23:33:54', '2018-02-21 10:15:18', 1),
(4, 'Carlos Manhique', 'carlosmanhique', '$2y$10$bZNJptqSOS1GdRx0uRT6BuGqozCsUR1uik60YGGUOgLpp1y2LpVFu', NULL, NULL, 1, 'carlosmanhique@gmail.com', 'NnoiGwfy0S', '2018-01-20 23:33:54', '2018-01-20 23:33:54', 1),
(5, 'Ossmane Dos Prazeres', 'ossmane', '$2y$10$ULjEX8ds1EewDnkM/vf7peP8XnogLxDL5rFjcwGkUYLaviXuZGjyy', NULL, NULL, 1, 'ossmane@gmail.com', 'NP3UIfUQuL', '2018-01-20 23:33:54', '2018-01-20 23:33:54', 1);

-- --------------------------------------------------------

--
-- Table structure for table `vendas`
--

DROP TABLE IF EXISTS `vendas`;
CREATE TABLE IF NOT EXISTS `vendas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `valor_total` decimal(8,2) NOT NULL DEFAULT '0.00',
  `user_id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `pago` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `forma_pagamento_id` int(11) DEFAULT '1',
  `nr_documento_forma_pagamento` varchar(45) DEFAULT 'Nao Aplicavel',
  `valor_pago` decimal(8,2) DEFAULT '0.00',
  `troco` decimal(8,2) DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `fk_vendas_users1_idx` (`user_id`),
  KEY `fk_vendas_clientes1_idx` (`cliente_id`),
  KEY `fk_vendas_forma_pagamentos1_idx` (`forma_pagamento_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vendas`
--

INSERT INTO `vendas` (`id`, `valor_total`, `user_id`, `cliente_id`, `pago`, `created_at`, `updated_at`, `forma_pagamento_id`, `nr_documento_forma_pagamento`, `valor_pago`, `troco`) VALUES
(2, '120.00', 3, 1, 1, '2018-03-12 09:17:37', '2018-03-12 19:03:06', 1, 'Nao Aplicavel', '200.00', '80.00'),
(3, '948.00', 3, 2, 1, '2018-03-12 13:16:26', '2018-03-13 18:32:26', 1, 'Nao', '950.00', '2.00'),
(4, '150.00', 3, 5, 1, '2018-03-13 03:37:55', '2018-03-13 18:30:36', 3, '123456', '120.00', '-30.00');

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
-- Constraints for table `guia_entregas`
--
ALTER TABLE `guia_entregas`
  ADD CONSTRAINT `fk_guiaentregas_clientes1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_guiaentregas_saidas1` FOREIGN KEY (`saida_id`) REFERENCES `saidas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_guiaentregas_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
-- Constraints for table `iten_guiaentregas`
--
ALTER TABLE `iten_guiaentregas`
  ADD CONSTRAINT `fk_iten_guiaentregas_guia_entregas1` FOREIGN KEY (`guia_entrega_id`) REFERENCES `guia_entregas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `iten_saidas`
--
ALTER TABLE `iten_saidas`
  ADD CONSTRAINT `fk_itensaidas_produtos1` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `iten_vendas`
--
ALTER TABLE `iten_vendas`
  ADD CONSTRAINT `fk_iten_vendas_produtos1` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_iten_vendas_vendas1` FOREIGN KEY (`venda_id`) REFERENCES `vendas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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

--
-- Constraints for table `vendas`
--
ALTER TABLE `vendas`
  ADD CONSTRAINT `fk_vendas_clientes1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_vendas_forma_pagamentos1` FOREIGN KEY (`forma_pagamento_id`) REFERENCES `forma_pagamentos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_vendas_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

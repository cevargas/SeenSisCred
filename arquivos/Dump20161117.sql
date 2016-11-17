-- MySQL dump 10.13  Distrib 5.7.12, for Win32 (AMD64)
--
-- Host: 127.0.0.1    Database: siscred
-- ------------------------------------------------------
-- Server version	5.7.14

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `sobrenome` varchar(100) NOT NULL,
  `endereco` varchar(200) NOT NULL,
  `telefone` varchar(45) NOT NULL,
  `cidade` varchar(200) NOT NULL,
  `estado` varchar(2) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `data_nascimento` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` VALUES (1,'Carlos','Vargas','Coronel Chicuta','43 4004-3443','Passo Fundo','1','99203040040','cev@outlook.com','2016-11-14'),(4,'Josefina','Avestruz','Cel Chicuta , 1241','55 5454-5454','Passo Fundo','1','33313131331','josefina@gmail.com','2009-11-12'),(14,'Pedro','Barbosa','Coronel Chicuta, 131','(95) 9995-9595','Porto Alegre','1','39381719919','pedro@gmail.com','2016-11-02'),(18,'Bill','Gates','Rua Alferes Rodrigues, 481','(18) 2828-2828','Passo Fundo','1','81818181818','cev@outlook.com','2016-11-08');
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cliente_outro`
--

DROP TABLE IF EXISTS `cliente_outro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cliente_outro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `sobrenome` varchar(100) NOT NULL,
  `telefone` varchar(45) NOT NULL,
  `limite_credito` decimal(10,2) NOT NULL DEFAULT '300.00',
  PRIMARY KEY (`id`),
  KEY `fk_cliente_outros_idx` (`id_cliente`),
  CONSTRAINT `fk_cliente_outros` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente_outro`
--

LOCK TABLES `cliente_outro` WRITE;
/*!40000 ALTER TABLE `cliente_outro` DISABLE KEYS */;
INSERT INTO `cliente_outro` VALUES (13,18,'Pedro','Silva','(82) 8282-8282',121212.00),(14,18,'Maria','Benta','(89) 4949-5959',282828.00),(24,1,'addout1','addout1','(11) 1111-1111',110000.00);
/*!40000 ALTER TABLE `cliente_outro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cliente_referencia`
--

DROP TABLE IF EXISTS `cliente_referencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cliente_referencia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `sobrenome` varchar(100) NOT NULL,
  `telefone` varchar(45) NOT NULL,
  `tipo_referencia` int(11) NOT NULL COMMENT '1 - bancaria\n2 - comercial',
  PRIMARY KEY (`id`),
  KEY `fk_cliente_referencia_idx` (`id_cliente`),
  CONSTRAINT `fk_cliente_referencia` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente_referencia`
--

LOCK TABLES `cliente_referencia` WRITE;
/*!40000 ALTER TABLE `cliente_referencia` DISABLE KEYS */;
INSERT INTO `cliente_referencia` VALUES (7,14,'Maria','Alberta','(11) 8181-8188',1),(19,18,'Eduardo','Vargas','(12) 2222-2224',2),(20,18,'Carlos','Vargas','(12) 1131-3131',1),(36,1,'add1','add1','(11) 1111-1111',2),(37,1,'add2','add2','(22) 2222-2222',1);
/*!40000 ALTER TABLE `cliente_referencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `funcionario`
--

DROP TABLE IF EXISTS `funcionario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `funcionario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `sobrenome` varchar(100) NOT NULL,
  `telefone` varchar(45) NOT NULL,
  `status` int(11) NOT NULL,
  `data_contratacao` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `funcionario`
--

LOCK TABLES `funcionario` WRITE;
/*!40000 ALTER TABLE `funcionario` DISABLE KEYS */;
INSERT INTO `funcionario` VALUES (1,'Carlos ','Vargas','33 3333-3333',1,'2012-02-12 00:00:00');
/*!40000 ALTER TABLE `funcionario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `itens_venda`
--

DROP TABLE IF EXISTS `itens_venda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `itens_venda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_venda` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_vendas_produtos_idx` (`id_produto`),
  KEY `fk_vendas_produtos_vendas_idx` (`id_venda`),
  CONSTRAINT `fk_vendas_produtos` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_vendas_produtos_vendas` FOREIGN KEY (`id_venda`) REFERENCES `venda` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `itens_venda`
--

LOCK TABLES `itens_venda` WRITE;
/*!40000 ALTER TABLE `itens_venda` DISABLE KEYS */;
INSERT INTO `itens_venda` VALUES (1,2,1,1,1.33),(2,3,3,2,12.11),(3,3,3,5,12.11),(4,4,3,2,12.11),(5,4,3,5,12.11),(6,5,3,2,12.11),(7,5,3,5,12.11),(8,6,3,2,12.11),(9,6,3,5,12.11),(10,7,3,2,12.11),(11,7,3,5,12.11),(12,8,2,2,11.21),(13,8,1,5,1.33),(14,9,2,2,11.21),(15,9,1,5,1.33),(16,10,2,2,11.21),(17,10,1,5,1.33),(18,11,2,2,11.21),(19,11,1,5,1.33),(20,12,2,2,11.21),(21,12,1,5,1.33),(22,13,2,2,11.21),(23,13,1,5,1.33),(24,14,2,2,11.21),(25,14,1,5,1.33),(26,15,2,2,11.21),(27,15,1,5,1.33),(28,16,2,2,11.21),(29,16,1,5,1.33),(30,17,2,2,11.21),(31,17,1,5,1.33),(32,18,2,2,11.21),(33,18,1,5,1.33),(34,19,2,2,11.21),(35,19,1,5,1.33),(36,20,2,2,11.21),(37,20,1,5,1.33),(38,21,2,2,11.21),(39,21,1,5,1.33),(40,22,2,2,11.21),(41,22,1,5,1.33),(42,23,2,2,11.21),(43,23,1,5,1.33),(44,24,2,1,11.21),(45,24,5,1,41.13),(46,24,6,4,13.13),(47,25,2,4,11.21),(48,26,1,1,1.33),(49,26,2,2,11.21),(50,27,2,1,11.21),(51,28,2,1,11.21),(52,29,2,1,11.21),(53,30,2,3,11.21),(54,30,3,4,12.11),(55,31,1,1,1.33),(56,31,4,3,13.31),(57,31,3,44,12.11),(58,32,2,1,11.21),(59,32,5,2,41.13),(60,32,3,2,12.11),(61,33,1,1,1.33),(62,33,3,44,12.11),(63,34,2,11,11.21);
/*!40000 ALTER TABLE `itens_venda` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pagamento`
--

DROP TABLE IF EXISTS `pagamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pagamento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_venda` int(11) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `data_pagamento` date NOT NULL,
  `status` int(11) NOT NULL COMMENT '1 - aberto\n2 - pago\n3 - vencido',
  PRIMARY KEY (`id`),
  KEY `fk_vendas_prazo_idx` (`id_venda`),
  CONSTRAINT `fk_vendas_prazo` FOREIGN KEY (`id_venda`) REFERENCES `venda` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pagamento`
--

LOCK TABLES `pagamento` WRITE;
/*!40000 ALTER TABLE `pagamento` DISABLE KEYS */;
INSERT INTO `pagamento` VALUES (1,23,10.00,'2016-12-16',1),(2,23,10.00,'2017-01-16',1),(3,23,10.00,'2017-02-16',1),(4,24,26.22,'2016-12-16',1),(5,24,26.22,'2017-01-16',1),(6,24,26.22,'2017-02-16',1),(7,24,26.22,'2017-03-16',1),(8,25,22.42,'2016-12-16',1),(9,25,22.42,'2017-01-16',1),(10,26,11.88,'2016-12-16',1),(11,26,11.88,'2017-01-16',1),(12,27,3.74,'2016-12-16',1),(13,27,3.74,'2017-01-16',1),(14,27,3.74,'2017-02-16',1),(15,28,3.74,'2016-12-04',1),(16,28,3.74,'2017-01-04',1),(17,28,3.74,'2017-02-04',1),(18,29,3.74,'2016-12-04',1),(19,29,3.74,'2017-01-04',1),(20,29,3.74,'2017-02-04',1),(21,30,20.52,'2016-12-04',1),(22,30,20.52,'2017-01-04',1),(23,30,20.52,'2017-02-04',1),(24,30,20.52,'2017-03-04',1),(55,32,29.42,'2016-12-01',1),(56,32,29.42,'2017-01-01',1),(57,32,29.42,'2017-02-01',1),(58,32,29.42,'2017-03-01',1);
/*!40000 ALTER TABLE `pagamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produto`
--

DROP TABLE IF EXISTS `produto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `descricao` varchar(100) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `disponivel_estoque` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produto`
--

LOCK TABLES `produto` WRITE;
/*!40000 ALTER TABLE `produto` DISABLE KEYS */;
INSERT INTO `produto` VALUES (1,'Lapis','Lapis preto',1.33,12),(2,'Caneta','Caneta preta',11.21,4),(3,'Caderno','Caderno 120 folhas',12.11,13),(4,'Folhas brancas','100 folhas brancas',13.31,12),(5,'Agenda','Agenda 2017',41.13,11),(6,'Mochila','Mochila para materias',13.13,1),(7,'Granpeador','Granpeador',41.13,14);
/*!40000 ALTER TABLE `produto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `venda`
--

DROP TABLE IF EXISTS `venda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `venda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_funcionario` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `data_compra` datetime NOT NULL,
  `valor_total` decimal(10,2) NOT NULL,
  `forma_pagamento` int(11) NOT NULL COMMENT '1 - a vista\n2 - a prazo',
  `prestacoes` int(11) DEFAULT NULL,
  `diapagto` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_vendas_cliente_idx` (`id_cliente`),
  KEY `fk_vendas_funcionario_idx` (`id_funcionario`),
  CONSTRAINT `fk_vendas_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_vendas_funcionario` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venda`
--

LOCK TABLES `venda` WRITE;
/*!40000 ALTER TABLE `venda` DISABLE KEYS */;
INSERT INTO `venda` VALUES (1,1,1,'2016-11-15 00:00:00',1214.00,1,NULL,NULL),(2,1,1,'2016-11-04 00:00:00',1.00,2,NULL,NULL),(3,1,1,'2016-11-24 00:00:00',24.22,1,NULL,NULL),(4,1,1,'2016-11-24 00:00:00',24.22,1,NULL,NULL),(5,1,1,'2016-11-24 00:00:00',24.22,1,NULL,NULL),(6,1,1,'2016-11-24 00:00:00',84.77,1,NULL,NULL),(7,1,1,'2016-11-24 00:00:00',84.77,1,NULL,NULL),(8,1,1,'2016-11-15 00:00:00',29.07,2,NULL,NULL),(9,1,1,'2016-11-15 00:00:00',29.07,2,NULL,NULL),(10,1,1,'2016-11-15 00:00:00',29.07,2,NULL,NULL),(11,1,1,'2016-11-15 00:00:00',29.07,2,NULL,NULL),(12,1,1,'2016-11-15 00:00:00',29.07,2,NULL,NULL),(13,1,1,'2016-11-15 00:00:00',29.07,2,NULL,NULL),(14,1,1,'2016-11-15 00:00:00',29.07,2,NULL,NULL),(15,1,1,'2016-11-15 00:00:00',29.07,2,NULL,NULL),(16,1,1,'2016-11-15 00:00:00',29.07,2,NULL,NULL),(17,1,1,'2016-11-15 00:00:00',29.07,2,NULL,NULL),(18,1,1,'2016-11-15 00:00:00',29.07,2,NULL,NULL),(19,1,1,'2016-11-15 00:00:00',29.07,2,NULL,NULL),(20,1,1,'2016-11-15 00:00:00',29.07,2,NULL,NULL),(21,1,1,'2016-11-15 00:00:00',29.07,2,NULL,NULL),(22,1,1,'2016-11-15 00:00:00',29.07,2,NULL,NULL),(23,1,1,'2016-11-15 00:00:00',29.07,2,NULL,NULL),(24,1,14,'2016-11-16 00:00:00',104.86,2,3,4),(25,1,1,'2016-11-16 00:00:00',44.84,2,2,2),(26,1,1,'2016-11-02 00:00:00',23.75,2,2,10),(27,1,1,'2016-11-16 00:00:00',11.21,2,3,4),(28,1,1,'2016-11-16 00:00:00',11.21,2,3,4),(29,1,1,'2016-11-16 00:00:00',11.21,2,3,4),(30,1,1,'2016-11-16 00:00:00',82.07,2,4,4),(31,1,1,'2016-11-16 00:00:00',574.10,1,NULL,NULL),(32,1,1,'2016-11-16 00:00:00',117.69,2,4,1),(33,1,1,'2016-11-16 00:00:00',534.17,1,NULL,NULL),(34,1,4,'2016-11-01 00:00:00',123.31,1,NULL,NULL);
/*!40000 ALTER TABLE `venda` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-11-17  0:08:29

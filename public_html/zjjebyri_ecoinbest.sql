-- MySQL dump 10.16  Distrib 10.1.24-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: zjjebyri_ecoinbest
-- ------------------------------------------------------
-- Server version	10.1.24-MariaDB-cll-lve

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
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `titulo_site` varchar(50) NOT NULL,
  `nome_site` varchar(50) NOT NULL,
  `logo_site` varchar(50) NOT NULL,
  `min_saque` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `carteira` mediumtext NOT NULL,
  `saque` varchar(15) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` (`id`, `titulo_site`, `nome_site`, `logo_site`, `min_saque`, `username`, `password`, `carteira`, `saque`) VALUES (1,'TXB','TXB','logo4.png','250','admin','25f9e794323b453885f5181f1b624d0b','25f9e794323b453885f5181f1b624d0b','Liberado');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `binarios_bonificados`
--

DROP TABLE IF EXISTS `binarios_bonificados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `binarios_bonificados` (
  `id_binario` int(11) NOT NULL AUTO_INCREMENT,
  `personal_id` int(8) DEFAULT NULL,
  `bonus` float DEFAULT NULL,
  `saldo_antes` mediumtext,
  `saldo_depois` mediumtext,
  `valor_direita` float DEFAULT NULL,
  `valor_esquerda` float DEFAULT NULL,
  `chave_direita` longtext,
  `chave_esquerda` longtext,
  `perna_menor` mediumtext,
  `data` mediumtext,
  `data_binario` datetime DEFAULT NULL,
  `num` mediumtext,
  `pacote_bonificado` mediumtext,
  `equiparado` float DEFAULT NULL,
  PRIMARY KEY (`id_binario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `binarios_bonificados`
--

LOCK TABLES `binarios_bonificados` WRITE;
/*!40000 ALTER TABLE `binarios_bonificados` DISABLE KEYS */;
/*!40000 ALTER TABLE `binarios_bonificados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dados_acesso_usuario`
--

DROP TABLE IF EXISTS `dados_acesso_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dados_acesso_usuario` (
  `data` date DEFAULT NULL,
  `personal_id` varchar(11) DEFAULT NULL,
  `username` varchar(80) DEFAULT NULL,
  `package` varchar(50) DEFAULT NULL,
  `package_anterior` mediumtext,
  `point` varchar(255) DEFAULT NULL,
  `indication` varchar(255) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `direcao_cadastro` varchar(50) DEFAULT '0',
  `chave_linear` longtext,
  `chave_binaria` longtext,
  `perna` varchar(20) DEFAULT 'esquerda',
  `indicacao_id` int(8) DEFAULT NULL,
  `ref_binario_id` int(8) DEFAULT NULL,
  `direcao` varchar(12) DEFAULT NULL,
  `plan` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dados_acesso_usuario`
--

LOCK TABLES `dados_acesso_usuario` WRITE;
/*!40000 ALTER TABLE `dados_acesso_usuario` DISABLE KEYS */;
INSERT INTO `dados_acesso_usuario` (`data`, `personal_id`, `username`, `package`, `package_anterior`, `point`, `indication`, `status`, `photo`, `id`, `direcao_cadastro`, `chave_linear`, `chave_binaria`, `perna`, `indicacao_id`, `ref_binario_id`, `direcao`, `plan`) VALUES (NULL,'1','testeteste','Starter',NULL,'0','empirebits','Pendente','Personal.png',1,'',NULL,NULL,'esquerda',0,NULL,'',NULL);
/*!40000 ALTER TABLE `dados_acesso_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `extrato`
--

DROP TABLE IF EXISTS `extrato`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `extrato` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `personal_id` int(11) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `descricao` varchar(150) DEFAULT NULL,
  `pedido_id` int(11) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `valor` float DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `extrato`
--

LOCK TABLES `extrato` WRITE;
/*!40000 ALTER TABLE `extrato` DISABLE KEYS */;
/*!40000 ALTER TABLE `extrato` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financeiro`
--

DROP TABLE IF EXISTS `financeiro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financeiro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `personal_id` int(11) DEFAULT NULL,
  `label` text,
  `username` varchar(50) DEFAULT NULL,
  `saldo` float DEFAULT NULL,
  `saldo_mining` float DEFAULT '0',
  `saldo_ind` float DEFAULT NULL,
  `plan` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `block` varchar(20) DEFAULT 'Desbloqueado',
  `perna` varchar(10) DEFAULT NULL,
  `binario_status` varchar(20) NOT NULL DEFAULT 'nao qualificado',
  `renovar_saldo` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financeiro`
--

LOCK TABLES `financeiro` WRITE;
/*!40000 ALTER TABLE `financeiro` DISABLE KEYS */;
INSERT INTO `financeiro` (`id`, `personal_id`, `label`, `username`, `saldo`, `saldo_mining`, `saldo_ind`, `plan`, `status`, `block`, `perna`, `binario_status`, `renovar_saldo`) VALUES (1,1,NULL,'testeteste',0,0,0,1,'Pendente','Desbloqueado',NULL,'nao qualificado',0);
/*!40000 ALTER TABLE `financeiro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice_upgrade`
--

DROP TABLE IF EXISTS `invoice_upgrade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice_upgrade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `personal_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `pedido` int(11) DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `price_up` float DEFAULT NULL,
  `price_now` float DEFAULT NULL,
  `patrocinador` varchar(50) DEFAULT NULL,
  `date` date NOT NULL,
  `status` varchar(50) NOT NULL,
  `plan_now` varchar(50) DEFAULT NULL,
  `plan_up` varchar(50) DEFAULT NULL,
  `wallet_confirm` varchar(255) DEFAULT NULL,
  `saldo_renew` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice_upgrade`
--

LOCK TABLES `invoice_upgrade` WRITE;
/*!40000 ALTER TABLE `invoice_upgrade` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoice_upgrade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plan`
--

DROP TABLE IF EXISTS `plan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `price` float NOT NULL,
  `price_btc` float DEFAULT NULL,
  `ran_day` float NOT NULL,
  `mining_min` float NOT NULL,
  `binario` float NOT NULL,
  `pontos` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plan`
--

LOCK TABLES `plan` WRITE;
/*!40000 ALTER TABLE `plan` DISABLE KEYS */;
INSERT INTO `plan` (`id`, `name`, `price`, `price_btc`, `ran_day`, `mining_min`, `binario`, `pontos`) VALUES (1,'Starter',100,0.0105,0.5,0,0,0),(2,'Bronze',250,0.026,0.75,0,5,10),(3,'Prata',500,0.052,1,0,10,20),(4,'Ouro',750,0.0778,1,0,15,30),(5,'Ruby',1000,0.105,1,0,20,40),(6,'Esmeralda',2000,0.2,1,0,25,50),(7,'Diamante',3000,0.32,1,0,30,60),(8,'Titanium',5000,0.52,1.3,0,35,70),(9,'imperium',10000,1.3,5,0,40,80),(10,'Star',50000,1.5,5,0,45,90),(11,'FULL Star',100000,2,6,0,50,100);
/*!40000 ALTER TABLE `plan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rede_binaria`
--

DROP TABLE IF EXISTS `rede_binaria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rede_binaria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `personal_id` int(11) DEFAULT NULL,
  `indicado_id` int(11) DEFAULT NULL,
  `nivel` int(11) DEFAULT NULL,
  `status` int(1) DEFAULT '1',
  `code_kit` int(2) DEFAULT NULL,
  `data` mediumtext,
  `log_perna` mediumtext,
  `log_perna_cadastro` mediumtext,
  `bonificou` int(1) DEFAULT '0',
  `data_binaria` datetime DEFAULT NULL,
  `qualificado` enum('Nao Qualificado','Qualificado') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rede_binaria`
--

LOCK TABLES `rede_binaria` WRITE;
/*!40000 ALTER TABLE `rede_binaria` DISABLE KEYS */;
INSERT INTO `rede_binaria` (`id`, `personal_id`, `indicado_id`, `nivel`, `status`, `code_kit`, `data`, `log_perna`, `log_perna_cadastro`, `bonificou`, `data_binaria`, `qualificado`) VALUES (1,0,1,1,1,NULL,NULL,'','',0,NULL,NULL);
/*!40000 ALTER TABLE `rede_binaria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `renovacao`
--

DROP TABLE IF EXISTS `renovacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `renovacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `personal_id` int(11) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `data_renovar` date DEFAULT NULL,
  `saldo_renovar` float DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `renovacao`
--

LOCK TABLES `renovacao` WRITE;
/*!40000 ALTER TABLE `renovacao` DISABLE KEYS */;
INSERT INTO `renovacao` (`id`, `personal_id`, `username`, `data`, `data_renovar`, `saldo_renovar`) VALUES (1,1,'testeteste','2017-09-30','2017-10-30',0);
/*!40000 ALTER TABLE `renovacao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `patrocinador` varchar(50) NOT NULL,
  `adress` varchar(255) DEFAULT NULL,
  `cpf` varchar(20) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `wallet` varchar(500) DEFAULT NULL,
  `pin` varchar(255) DEFAULT NULL,
  `data_register` date DEFAULT NULL,
  `adress_ip` varchar(25) DEFAULT NULL,
  `chat_status` varchar(50) DEFAULT NULL,
  `agencia` varchar(50) DEFAULT NULL,
  `banco` varchar(50) DEFAULT NULL,
  `conta` varchar(50) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `passmaster` varchar(255) DEFAULT '691b66c9f6854dc29920e0990ba40096',
  `sacar` enum('On','off') NOT NULL DEFAULT 'off',
  `token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` (`id`, `name`, `email`, `username`, `patrocinador`, `adress`, `cpf`, `phone`, `password`, `wallet`, `pin`, `data_register`, `adress_ip`, `chat_status`, `agencia`, `banco`, `conta`, `tipo`, `passmaster`, `sacar`, `token`) VALUES (1,'Teste Teste','victorgomes_stm@hotmail.com','testeteste','empirebits','Rua principal','005.186.442-86','093991233775','25f9e794323b453885f5181f1b624d0b',NULL,NULL,'2017-09-30','198.187.29.77',NULL,NULL,NULL,NULL,NULL,'691b66c9f6854dc29920e0990ba40096','off','95440');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `withdraw`
--

DROP TABLE IF EXISTS `withdraw`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `withdraw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `personal_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `valor` float NOT NULL,
  `data` datetime NOT NULL,
  `descricao` varchar(25) NOT NULL,
  `wallet` varchar(255) DEFAULT NULL,
  `status` varchar(25) NOT NULL,
  `pedido` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `withdraw`
--

LOCK TABLES `withdraw` WRITE;
/*!40000 ALTER TABLE `withdraw` DISABLE KEYS */;
/*!40000 ALTER TABLE `withdraw` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'zjjebyri_ecoinbest'
--

--
-- Dumping routines for database 'zjjebyri_ecoinbest'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-10-04 10:35:21

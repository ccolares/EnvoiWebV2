

DROP TABLE IF EXISTS `bairro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bairro` (
  `bairro_id` int(11) NOT NULL AUTO_INCREMENT,
  `bairro_nome` varchar(200) DEFAULT NULL,
  `bairro_cidade` varchar(200) DEFAULT NULL,
  `bairro_preco` decimal(10,2) DEFAULT 0.00,
  `bairro_ativo` int(1) DEFAULT 1,
  `bairro_tempo` varchar(100) DEFAULT NULL,
  `bairro_obs` text DEFAULT NULL,
  `bairro_cep` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`bairro_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bairro`
--

LOCK TABLES `bairro` WRITE;
/*!40000 ALTER TABLE `bairro` DISABLE KEYS */;
INSERT INTO `bairro` VALUES (2,'Boqueirão','Praia Grande',4.00,1,'40 min','',NULL),(3,'Guilhermina','Praia Grande',3.50,1,'25 min','',NULL);
/*!40000 ALTER TABLE `bairro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `banner`
--

DROP TABLE IF EXISTS `banner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `banner` (
  `banner_id` int(11) NOT NULL AUTO_INCREMENT,
  `banner_url` varchar(200) DEFAULT NULL,
  `banner_pos` int(3) DEFAULT 0,
  `banner_item` int(11) DEFAULT 0,
  `banner_created` timestamp NULL DEFAULT NULL,
  `banner_updated` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`banner_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banner`
--

LOCK TABLES `banner` WRITE;
/*!40000 ALTER TABLE `banner` DISABLE KEYS */;
INSERT INTO `banner` VALUES (8,'android-png.png',0,0,'2020-07-07 15:05:11','2020-07-07 15:05:11');
/*!40000 ALTER TABLE `banner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categoria` (
  `categoria_id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria_nome` varchar(200) DEFAULT NULL,
  `categoria_pos` int(11) DEFAULT NULL,
  `categoria_meia` int(1) DEFAULT 0,
  `categoria_ordem` int(11) DEFAULT NULL,
  `categoria_ref` int(5) NOT NULL DEFAULT 0,
  `categoria_ativa` int(2) DEFAULT 1,
  `categoria_img` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`categoria_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (1,'PIZZAS',1,3,1,255,1,NULL),(2,'ESFIHAS',4,0,4,0,1,NULL),(3,'REFRIGERANTES',6,0,6,0,1,NULL),(5,'CERVEJAS',7,0,7,0,1,NULL),(7,'BROTOS',4,1,3,0,1,NULL),(11,'PIZZA DOCE',3,1,2,0,1,NULL),(13,'ESFIHA DOCE',5,0,5,0,1,NULL),(16,'Pastéis',2,0,NULL,0,1,'categoria-pastel-jpg.jpg'),(17,'COMBOS',0,0,NULL,0,1,NULL),(18,'Lanches',0,1,NULL,0,1,'categoria-banner1-jpg.jpg'),(19,'Mexicano',0,1,NULL,0,1,NULL);
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cliente` (
  `cliente_id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_nome` varchar(200) DEFAULT NULL,
  `cliente_email` varchar(200) DEFAULT NULL,
  `cliente_fone` varchar(20) DEFAULT NULL,
  `cliente_fone2` varchar(20) DEFAULT NULL,
  `cliente_cpf` varchar(200) DEFAULT NULL,
  `cliente_senha` varchar(200) DEFAULT NULL,
  `cliente_fone3` varchar(200) DEFAULT NULL,
  `cliente_foto` varchar(200) DEFAULT NULL,
  `cliente_token` varchar(255) DEFAULT NULL,
  `cliente_nasc` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`cliente_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` VALUES (18,'rafael','falecom@phpstaff.com.br',NULL,'(99) 99999-9999','','b706835de79a2b4e80506f582af3676a',NULL,NULL,NULL,'19/05/1982');
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `config`
--

DROP TABLE IF EXISTS `config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config` (
  `config_id` int(11) NOT NULL AUTO_INCREMENT,
  `config_nome` varchar(200) DEFAULT NULL,
  `config_foto` varchar(200) DEFAULT NULL,
  `config_desc` longtext DEFAULT NULL,
  `config_horario` varchar(200) DEFAULT NULL,
  `config_aberto` int(1) DEFAULT 1,
  `config_entrega` varchar(200) DEFAULT NULL,
  `config_taxa_entrega` double(10,2) DEFAULT NULL,
  `config_fone1` varchar(200) DEFAULT NULL,
  `config_fone2` varchar(200) DEFAULT NULL,
  `config_fone3` varchar(200) DEFAULT NULL,
  `config_endereco` varchar(255) DEFAULT NULL,
  `config_retirada` int(2) DEFAULT 1,
  `config_chat` text DEFAULT NULL,
  `config_color_bd` varchar(20) DEFAULT NULL,
  `config_color_bh` varchar(20) DEFAULT NULL,
  `config_color_cd` varchar(20) DEFAULT NULL,
  `config_color_ch` varchar(20) DEFAULT NULL,
  `config_color_bk` varchar(20) DEFAULT NULL,
  `config_color_top` varchar(20) DEFAULT '222222',
  `config_colors` varchar(2000) DEFAULT NULL,
  `config_foto_round` int(11) DEFAULT 50,
  `config_site_keywords` text DEFAULT NULL,
  `config_site_description` text DEFAULT NULL,
  `config_site_ga` text DEFAULT NULL,
  `config_cep` varchar(20) DEFAULT NULL,
  `config_cep_unico` int(1) NOT NULL DEFAULT 0,
  `config_resumo_whats` int(11) DEFAULT 1,
  `config_home_qtde` int(5) DEFAULT 8,
  `config_bell` int(1) DEFAULT 1,
  `config_pedmin` decimal(10,2) DEFAULT 5.00,
  PRIMARY KEY (`config_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config`
--

LOCK TABLES `config` WRITE;
/*!40000 ALTER TABLE `config` DISABLE KEYS */;
INSERT INTO `config` VALUES (1,'Flux Delivery','flux-delivery-png_1589341890.png','<div><div><div style=\"text-align: justify;\">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.<br><font color=\"#ffffff\" face=\"Arial\" style=\"background-color: inherit;\"></font></div></div></div>','17:00 às 22:00 hrs de Segunda a Domingo',1,'30-45 min',2.75,'(13) 3356-9312','(11) 0000-0000','4','Av: São Paulo Nº 1048 - Centro - SP',1,'','#b31919','#000000','#d25228','#ef6c01',NULL,'#000000','bd=&bh=&cd=d25228&ch=ef6c01&bt=000000&br=10',10,'PHP STAFF','PHP STAFF','','11701-540',0,1,8,0,30.00);
/*!40000 ALTER TABLE `config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cupom`
--

DROP TABLE IF EXISTS `cupom`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cupom` (
  `cupom_id` int(11) NOT NULL AUTO_INCREMENT,
  `cupom_nome` varchar(50) DEFAULT NULL,
  `cupom_validade` date DEFAULT NULL,
  `cupom_valor` double DEFAULT NULL,
  `cupom_percent` int(4) DEFAULT NULL,
  `cupom_tipo` int(11) DEFAULT 1 COMMENT '1 = valor\r\n 2 = percent',
  PRIMARY KEY (`cupom_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cupom`
--

LOCK TABLES `cupom` WRITE;
/*!40000 ALTER TABLE `cupom` DISABLE KEYS */;
INSERT INTO `cupom` VALUES (2,'FICAEMCASA','2020-08-14',5,NULL,1);
/*!40000 ALTER TABLE `cupom` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `endereco`
--

DROP TABLE IF EXISTS `endereco`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `endereco` (
  `endereco_id` int(11) NOT NULL AUTO_INCREMENT,
  `endereco_cliente` int(11) DEFAULT NULL,
  `endereco_endereco` varchar(200) DEFAULT NULL,
  `endereco_numero` varchar(200) DEFAULT NULL,
  `endereco_bairro` varchar(200) DEFAULT NULL,
  `endereco_cidade` varchar(200) DEFAULT NULL,
  `endereco_uf` varchar(200) DEFAULT NULL,
  `endereco_cep` varchar(200) DEFAULT NULL,
  `endereco_referencia` varchar(200) DEFAULT NULL,
  `endereco_nome` varchar(200) DEFAULT NULL,
  `endereco_complemento` varchar(200) DEFAULT NULL,
  `endereco_bairro_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`endereco_id`)
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `endereco`
--

LOCK TABLES `endereco` WRITE;
/*!40000 ALTER TABLE `endereco` DISABLE KEYS */;
INSERT INTO `endereco` VALUES (129,18,'Rua Flamengo','100','Guilhermina','Praia Grande',NULL,'11701-540','','Casa','',2);
/*!40000 ALTER TABLE `endereco` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entrega`
--

DROP TABLE IF EXISTS `entrega`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entrega` (
  `entrega_id` int(11) NOT NULL AUTO_INCREMENT,
  `entrega_inicio` varchar(10) DEFAULT NULL,
  `entrega_fim` varchar(10) DEFAULT NULL,
  `entrega_taxa` decimal(10,2) DEFAULT NULL,
  `entrega_nome` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`entrega_id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entrega`
--

LOCK TABLES `entrega` WRITE;
/*!40000 ALTER TABLE `entrega` DISABLE KEYS */;
INSERT INTO `entrega` VALUES (6,'09780340','09780340',5.00,'Sao bernardo'),(8,'09175360','09175900',2.00,'Vila Helena'),(9,'09132000','09171200',2.00,'Vila Luzita'),(10,'09121400','09195750',2.00,'Vila Pires'),(11,'09175000','09180970',2.00,'Vila Linda'),(12,'09172580','09172750',2.00,'Vila Junqueira'),(13,'09020170','09030700',3.00,'Vila Assunção'),(14,'09030160','09180971',2.00,'Vila Alzira'),(15,'09176000','09176220',2.00,'Vila Marina'),(16,'09010000','09210900',2.00,'Centro de Santo Andre'),(17,'09190040','09181725',3.00,'Jardim Paraíso'),(18,'09185360','09185400',2.00,'Vila Apiaí'),(19,'09040210','09041900',3.00,'Vila Bastos'),(20,'09050000','09051560',3.00,'Vila Floresta'),(21,'09190000','09190999',3.00,'Vila Gilda'),(22,'09172000','09175835',2.00,'Jardim do Estádio'),(23,'09120470','09181340',2.00,'Jardim Progresso'),(24,'09185090','09185235',2.00,'Jardim Cristiane'),(25,'09170080','09290970',3.00,'Vila João Ramalho'),(26,'09170510','09171480',3.00,'Jardim Guarará'),(29,'09172422','09175260',2.00,'Vila Vitória'),(31,'09110620','09121290',2.00,'Vila Humaitá'),(32,'09110410','09111345',3.00,'Vila Homero Thon'),(33,'09130470','09132280',3.00,'Vila Suiça'),(34,'09182000','09182380',3.00,'Jd  Las Vegas'),(35,'18120000','18120990',1.00,'Mairinque - SP'),(36,'11718255','11718255',3.00,'santos sp'),(37,'11045400','11718255',2.53,'Santos e PG');
/*!40000 ALTER TABLE `entrega` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `foto`
--

DROP TABLE IF EXISTS `foto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `foto` (
  `foto_id` int(11) NOT NULL AUTO_INCREMENT,
  `foto_url` varchar(200) DEFAULT NULL,
  `foto_chamado` int(5) DEFAULT NULL,
  `foto_item` varchar(200) DEFAULT NULL,
  `foto_cliente` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`foto_id`),
  KEY `fk_foto_chamado_idx` (`foto_chamado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `foto`
--

LOCK TABLES `foto` WRITE;
/*!40000 ALTER TABLE `foto` DISABLE KEYS */;
/*!40000 ALTER TABLE `foto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupo`
--

DROP TABLE IF EXISTS `grupo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupo` (
  `grupo_id` int(5) NOT NULL AUTO_INCREMENT,
  `grupo_nome` varchar(200) DEFAULT NULL,
  `grupo_desc` varchar(200) DEFAULT NULL,
  `grupo_tipo` int(5) DEFAULT 1,
  `grupo_pos` int(5) DEFAULT 999,
  `grupo_limite` int(3) DEFAULT 0,
  PRIMARY KEY (`grupo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo`
--

LOCK TABLES `grupo` WRITE;
/*!40000 ALTER TABLE `grupo` DISABLE KEYS */;
INSERT INTO `grupo` VALUES (1,'Massa','Massa Pizza',1,1,0),(2,'Bordas','Bordas Pizza',2,2,1),(3,'Molhos','Molhos Extras',2,3,2),(5,'Porções','Porções Pastel',2,0,0),(6,'Tamanho','Tamanho Pizza',1,0,0),(7,'Unidade / KG','Unidade / KG',1,999,0);
/*!40000 ALTER TABLE `grupo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item`
--

DROP TABLE IF EXISTS `item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_categoria` int(11) DEFAULT NULL,
  `item_nome` varchar(200) DEFAULT NULL,
  `item_desc` longtext DEFAULT NULL,
  `item_foto` varchar(200) DEFAULT NULL,
  `item_obs` longtext DEFAULT NULL,
  `item_preco` double(10,2) DEFAULT NULL,
  `item_codigo` varchar(200) NOT NULL,
  `item_ativo` int(2) DEFAULT 1,
  `item_promo` int(11) DEFAULT 0,
  `item_estoque` int(11) DEFAULT 50,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=765 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item`
--

LOCK TABLES `item` WRITE;
/*!40000 ALTER TABLE `item` DISABLE KEYS */;
INSERT INTO `item` VALUES (17,1,'ALICHE','ALICHE,MUSSA,PARMESAO E TOMATE.','img-6941-6018-jpeg_1452020013.JPEG','',38.00,'3',0,0,50),(26,1,'BACON','<b>MUSSA E BACON</b>','img-6941-6018-jpeg_1452020013.JPEG',NULL,34.00,'12',1,1,50),(29,1,'BROCOLIS I','<b>BROCOLIS,CATU E ALHO</b>','img-6941-6018-jpeg_1452020013.JPEG',NULL,34.00,'15',1,1,50),(32,1,'5 QUEIJOS','<b>MUSSA,PROVOLONE,GORGONZOLA,CATU,PARMESAO.</b>','img-6941-6018-jpeg_1452020013.JPEG',NULL,42.00,'18',1,0,50),(33,1,'CALABRESA','<b>CALABRESA E CBL</b>','img-6941-6018-jpeg_1452020013.JPEG',NULL,28.00,'19',1,0,50),(39,1,'2 QUEIJOS','','img-6941-6018-jpeg_1452020013.JPEG','',33.35,'26',1,0,2),(42,1,'ESCAROLA','<b>ESCAROLA,CBL,MUSSA E BACON</b>','img-6941-6018-jpeg_1452020013.JPEG',NULL,32.00,'29',1,0,50),(46,1,'FRANGO CAIPIRA','<b>FRANGO,MILHO ERVILHA E MUSSA</b>','img-6941-6018-jpeg_1452020013.JPEG',NULL,35.00,'33',1,0,50),(66,1,'PALMITO','<b>PALMITO,MUSSA E RDLS DE TOMATE</b>','img-6941-6018-jpeg_1452020013.JPEG',NULL,36.00,'53',1,0,50),(67,1,'PALMITO CATUPIRY','<b>PALMITO E CATU</b>','img-6941-6018-jpeg_1452020013.JPEG',NULL,38.00,'54',1,0,50),(69,1,'4 QUEIJOS I','<b>MUSSA,PARMESAO,PROVOLONE,GORGONZOLA.</b>','img-6941-6018-jpeg_1452020013.JPEG',NULL,38.00,'56',1,0,50),(84,1,'BANANA','<b>BANANA,CANELA E LEITE CONDENSADO</b>','banana-jpg_1479554029.jpg','<p><br></p>',27.00,'71',1,0,50),(85,11,'BANANA CHOCOLATE','<b>BANANA,LEITE CONDENSADO E CHOCOLATE</b>','bananachocolate-jpg_1479553519.jpg','<p><br></p>',32.00,'72',1,0,50),(86,11,'ROMEU E JULIETA','<b>GOIABADA E MUSSA</b>','romeu-jpg_1479554329.jpg','<p><br></p>',28.00,'73',1,0,50),(87,11,'BRIGADEIRO','<b>CHOCOLATE,LEITE CONDENSADO,GRANULADO E CEREJAS</b>','brigadeiro-jpg_1479553989.jpg','<p><br></p>',35.00,'74',1,0,50),(95,1,'JABA I','<b>JABA,CBL E CATU</b>','img-6941-6018-jpeg_1452020013.JPEG',NULL,39.00,'82',1,0,50),(101,1,'CAIPIRA','<b>FRANGO,CALABRESA MOIDA,MUSSA E CBL</b>','img-6941-6018-jpeg_1452020013.JPEG',NULL,35.00,'89',1,0,50),(120,1,'PROVOLONE','<b>MOLHO E  PROVOLONE</b>','img-6941-6018-jpeg_1452020013.JPEG',NULL,36.00,'108',1,0,50),(127,1,'VENEZA','<b>PALMITO,MUSSA,PRESUNTO E CATU</b>','img-6941-6018-jpeg_1452020013.JPEG',NULL,36.00,'115',1,0,50),(128,11,'PRESTIGIO','<b>CHOCOLATE,COCO RALADO E LEITE CONDENSADO</b>','prestigio-jpg_1479554145.jpg','<p><br></p>',35.00,'116',1,0,50),(129,11,'SONHO DE VALSA','<b>CHOCOLATE E SONHO DE VALSA</b>','sonho-png_1479554204.png','<p><br></p>',35.00,'117',1,0,50),(130,1,'PEPERONI','<b>PEPERONI,CBL,MUSSA E RDLS DE TOMATE</b>','img-6941-6018-jpeg_1452020013.JPEG',NULL,40.00,'118',1,0,50),(131,13,'CHOCOLATE','','esfiha-doce-jpg_1479553083.jpg','',4.50,'200',1,0,50),(132,13,'BANANA','','esfiha-doce-jpg_1479553083.jpg','',3.50,'201',1,0,50),(133,13,'ROMEU &JULIETA','','esfiha-doce-jpg_1479553083.jpg','goiabada, queijo mussarela',3.50,'202',1,0,50),(134,2,'CARNE','','esfiras-png_1463265819.png','carne moídda',3.50,'203',1,0,50),(135,2,'CALABRESA','','esfiras-png_1463265819.png','calabresa',3.50,'204',1,0,50),(136,2,'QUEIJO','','esfiras-png_1463265819.png','queijo mussarela',3.50,'205',1,0,50),(137,2,'CATUPIRY','catupiry','esfiras-png_1463265819.png','',3.50,'206',1,0,50),(138,2,'ATUM c/ CATUPIRY','','esfiras-png_1463265819.png','atum, catupiry',4.50,'207',1,0,50),(139,2,'FRANGO c/ CATUPIRY','','esfiras-png_1463265819.png','frango, catupiry',4.50,'208',1,0,50),(140,2,'MILHO c/ CATUPIRY','','esfiras-png_1463265819.png','milho, catupiry',4.50,'209',1,0,50),(141,2,'PALMITO c/ CATUPIRY','','esfiras-png_1463265819.png','palmito, catupiry',4.50,'210',1,0,50),(142,2,'DOIS QUEIJOS','','esfiras-png_1463265819.png','mussarela, catupiry',4.50,'211',1,0,50),(143,2,'CALABRESA c/ CATUPIRY','','esfiras-png_1463265819.png','calabresa, catupiry',4.50,'212',1,0,50),(144,2,'BACON c/ QUEIJO','','esfiras-png_1463265819.png','bacon, mussarela',4.50,'213',1,0,50),(145,2,'PALMITO c/ QUEIJO','','esfiras-png_1463265819.png','palimito, mussarela',4.50,'214',1,0,50),(152,13,'BANANA c/ CHOCOLATE','','esfiha-doce-jpg_1479553083.jpg','banana, chocolate',4.50,'221',1,0,50),(154,2,'CARNE c/ QUEIJO','','esfiras-png_1463265819.png','carne, mussarela',4.50,'223',1,0,50),(163,3,'COCA-COLA 2LT','<b><br></b>','coca-jpg_1479551773.jpg','<p><br></p>',10.00,'300',1,0,50),(164,3,'FANTA 2LT','<b><br></b>','fanta-png_1479551166.png','<p><br></p>',9.00,'301',1,0,50),(165,3,'GUARANA ANT','<b><br></b>','guarana-png_1479551205.png','<p><br></p>',9.00,'302',1,0,50),(166,3,'GUARANA DOLLY','<b><br></b>','dolly-png_1479551224.png','<p><br></p>',6.00,'303',1,0,50),(167,3,'COCA LIGHT 2 LT','<b><br></b>','untitled-png_1479551145.png','<p><br></p>',10.00,'304',1,0,50),(168,3,'SPRITE 2L','','sprite-png_1479551317.png','',9.00,'305',1,0,50),(174,5,'BRAHMA LATA','','brahama-png_1479552071.png','',5.00,'311',1,0,50),(176,5,'ITAIPAVA','','itaipava-png_1479552115.png','',5.00,'313',1,0,50),(177,3,'GUARANA ZERO','<b><br></b>','guaranalight-png_1479551288.png','<p><br></p>',9.00,'315',1,0,50),(178,3,'COCA ZERO','<b><br></b>','cocalight-png_1479551099.png','<p><br></p>',10.00,'316',1,0,50),(179,3,'REFRI 600 ML','<b><br></b>','600x600-png_1479551668.png','<p><br></p>',6.50,'317',1,0,50),(185,5,'SKOL LATA','<b><br></b>','skol2-png_1479552151.png','<p><br></p>',4.50,'406',1,0,50),(188,5,'BOHEMIA LATA','<b><br></b>','bohemia-jpg_1479552314.jpg','<p><br></p>',4.50,'409',1,0,50),(189,5,'BRAHMA ZERO ALCOOL','','semalcool-png_1479552508.png','',4.50,'410',1,0,50),(241,5,'MALZBIER LATA E LONG','<b><br></b>','malzibie-png_1479552244.png','<p><br></p>',4.00,'462',1,0,50),(242,3,'REFRIG 2L','<b><br></b>','refr-2l-png_1479551688.png','<p><br></p>',11.00,'463',1,0,50),(259,3,'FANTA UVA','<b><br></b>','fantauva-png_1479551181.png','<p><br></p>',9.00,'507',1,0,50),(260,7,'ATUM','','img-6941-6018-jpeg_1452020013.JPEG','ATUM E CEBOLA',22.00,'601',1,0,50),(261,7,'ALHO','','img-6941-6018-jpeg_1452020013.JPEG','ALHO FRITO E MUSSARELA',20.00,'602',1,0,50),(262,7,'ALICHE','','img-6941-6018-jpeg_1452020013.JPEG','ALICHE,MUSSA,TOMATE E PARMESAO',23.00,'603',1,0,50),(268,7,'Baiana','','img-6941-6018-jpeg_1452020013.JPEG','CALABRESA MOIDA,PIMENTA,OVOS E CALABRESA',19.00,'609',1,0,50),(271,7,'BACON','','img-6941-6018-jpeg_1452020013.JPEG','MUSSARELA E BACON',22.00,'612',1,0,50),(272,7,'BOLOGNHESA','','img-6941-6018-jpeg_1452020013.JPEG','CARNE MOÍDA  E MUSSARELA',22.00,'613',1,0,50),(274,7,'BROCOLIS I','','img-6941-6018-jpeg_1452020013.JPEG','BROCOLIS, CATUPIRY E ALHO',22.00,'615',1,0,50),(276,7,'CATUPIRY','','img-6941-6018-jpeg_1452020013.JPEG','MOLHO DE TOMATE E CATUPIRY',20.00,'617',1,0,50),(277,7,'5 QUEIJOS','','img-6941-6018-jpeg_1452020013.JPEG','MUSSARELA, PROVOLONE, GORGONZOLA, CATUPIRY E PARMESAO',25.00,'618',1,0,50),(282,7,'CHAMPIGNON','','img-6941-6018-jpeg_1452020013.JPEG','CHAMPIGNON e MUSSARELA',22.00,'623',1,0,50),(284,7,'2 QUEIJOS','','img-6941-6018-jpeg_1452020013.JPEG','MUSSARELA e CATUPIRY',21.00,'626',1,0,50),(287,7,'ESCAROLA','','img-6941-6018-jpeg_1452020013.JPEG','ESCAROLA, MUSSARELA E  BACON',21.00,'629',1,0,50),(384,1,'ALHO','<b></b>','img-6941-6018-jpeg_1452020013.JPEG',NULL,34.00,'1002',1,0,50),(393,1,'BAURU','<b></b>','img-6941-6018-jpeg_1452020013.JPEG',NULL,34.00,'1011',1,0,50),(395,1,'BOLOGNESA I','<b></b>','img-6941-6018-jpeg_1452020013.JPEG',NULL,36.00,'1013',1,0,50),(399,1,'CATUPIRY','<b></b>','img-6941-6018-jpeg_1452020013.JPEG',NULL,34.00,'1017',1,0,50),(405,1,'CHAMPIGNOM','<b></b>','img-6941-6018-jpeg_1452020013.JPEG',NULL,35.00,'1023',1,0,50),(420,1,'AMERICANA','<b></b>','img-6941-6018-jpeg_1452020013.JPEG',NULL,36.00,'1039',1,0,50),(422,1,'LOMBO I','<b></b>','img-6941-6018-jpeg_1452020013.JPEG',NULL,36.00,'1041',1,0,50),(424,1,'MUSSARELA','<b></b>','img-6941-6018-jpeg_1452020013.JPEG',NULL,29.00,'1043',1,0,50),(428,1,'NAPOLITANA','<b></b>','img-6941-6018-jpeg_1452020013.JPEG',NULL,35.00,'1047',1,0,50),(430,1,'PERUANA','<b></b>','img-6941-6018-jpeg_1452020013.JPEG',NULL,38.00,'1049',1,0,50),(431,1,'PORTUGUESA I','<b></b>','img-6941-6018-jpeg_1452020013.JPEG',NULL,37.00,'1050',1,0,50),(441,1,'RUCULA','<b></b>','img-6941-6018-jpeg_1452020013.JPEG',NULL,37.00,'1060',1,0,50),(444,1,'TOSCANA','<b></b>','img-6941-6018-jpeg_1452020013.JPEG',NULL,36.00,'1063',1,0,50),(446,1,'VEGETARIANA I','<b></b>','img-6941-6018-jpeg_1452020013.JPEG',NULL,37.00,'1065',1,0,50),(452,11,'BANANA','<b><br></b>','banana-jpg_1479554049.jpg','<p><br></p>',30.00,'1071',1,0,50),(457,1,'MINEIRA I','<b></b>','img-6941-6018-jpeg_1452020013.JPEG',NULL,36.00,'1076',1,0,50),(461,1,'PRIMAVERA','<b></b>','img-6941-6018-jpeg_1452020013.JPEG',NULL,38.00,'1080',1,0,50),(470,1,'ROMANA','<b></b>','img-6941-6018-jpeg_1452020013.JPEG',NULL,37.00,'1090',1,0,50),(483,1,'Natural','','img-6941-6018-jpeg_1452020013.JPEG','mussarela de bufala, oregano, tomate',37.00,'1103',1,0,50),(485,1,'Pizza Baiana','','img-6941-6018-jpeg_1452020013.JPEG','Mussarela, Calabresa, Pimenta, Molho de Tomate, Orégano e Azeitonas.',35.00,'1105',1,0,50),(616,13,'BRIGADEIRO','','esfiha-doce-jpg_1479553083.jpg','chocolate, granulado',4.90,'2200',1,0,50),(617,13,'BEIJINHO','','esfiha-doce-jpg_1479553083.jpg','coco, leite condensado',3.90,'2201',1,0,50),(626,2,'PALMITO c/ CATUPIRY','','esfiras-png_1463265819.png','milho, catupiry',4.90,'2210',1,0,50),(639,2,'FRANGO','','esfiras-png_1463265819.png','frango desfiado',3.90,'2224',1,0,50),(756,16,'Queijo','','images-jpeg_1585613376.jpeg','massa de pastel, queijo',8.00,'p002',1,0,50),(757,16,'Calabresa c/ Queijo','','images-jpeg_1585613629.jpeg','calabresa, queijo mussarela',8.30,'p003',1,0,50),(758,16,'Palmito','','images-jpeg_1585613849.jpeg','palmito, queijo mussarela e azeitonas',9.00,'005',1,0,50),(759,18,'Hamburguer','','a-jpg_1590764286.jpg','Pão de gergelim, açface, tomate e carne bovina',10.00,'',1,0,50),(760,18,'LANCHE ARTESANAL','','a-jpg_1590762942.jpg','PÃO, BIFE ARTESANAL, QUEIJO, BACON, SALADA E MOLHO ESPECIAL',18.50,'',1,0,50),(761,19,'Tacos','','t-jpg_1590762759.jpg','mussarela, acabate, tomate, pimentão',15.00,'',1,0,50),(762,19,'Burrito','','b-jpg_1590762807.jpg','frango, cebola, feijão vermelho,',21.00,'',1,1,3);
/*!40000 ALTER TABLE `item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `opcao`
--

DROP TABLE IF EXISTS `opcao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `opcao` (
  `opcao_id` int(11) NOT NULL AUTO_INCREMENT,
  `opcao_grupo` int(11) DEFAULT NULL,
  `opcao_nome` varchar(200) DEFAULT NULL,
  `opcao_desc` longtext DEFAULT NULL,
  `opcao_preco` decimal(10,2) DEFAULT 0.00,
  `opcao_status` int(1) DEFAULT 1,
  PRIMARY KEY (`opcao_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opcao`
--

LOCK TABLES `opcao` WRITE;
/*!40000 ALTER TABLE `opcao` DISABLE KEYS */;
INSERT INTO `opcao` VALUES (3,2,'Borda Recheada','asadasda',1.00,0),(4,2,'Borda Catupry','',3.00,1),(5,2,'Borda Vulcão','',5.00,1),(6,2,'Borda Coxinha','',10.00,0),(7,2,'Borda Tradicional','',0.00,1),(8,1,'Massa Tradicional',NULL,0.00,1),(9,1,'Massa Integral',NULL,5.75,1),(10,1,'Massa Folhada',NULL,6.99,1),(11,3,'Maionese',NULL,1.99,1),(12,3,'Catchup',NULL,1.20,1),(14,3,'Barbecue',NULL,1.50,1),(15,3,'Shoyo',NULL,1.00,1),(16,5,'Salada Extra',NULL,1.00,1),(17,5,'Molho Especial',NULL,1.50,1),(18,6,'Pequena',NULL,0.00,1),(19,6,'Média',NULL,10.00,1),(20,6,'Grande',NULL,20.00,1),(21,7,'140GR',NULL,0.00,1),(22,7,'250GR',NULL,2.00,1);
/*!40000 ALTER TABLE `opcao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pagamento`
--

DROP TABLE IF EXISTS `pagamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pagamento` (
  `pagamento_id` int(11) NOT NULL AUTO_INCREMENT,
  `pagamento_gw` varchar(200) DEFAULT 'SANDBOX',
  `pagamento_usuario` varchar(255) DEFAULT NULL,
  `pagamento_senha` varchar(255) DEFAULT NULL,
  `pagamento_retorno` longtext DEFAULT NULL,
  `pagamento_status` int(11) DEFAULT 1 COMMENT '1 = ativado\n0 = desativado',
  PRIMARY KEY (`pagamento_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pagamento`
--

LOCK TABLES `pagamento` WRITE;
/*!40000 ALTER TABLE `pagamento` DISABLE KEYS */;
INSERT INTO `pagamento` VALUES (1,'SANDBOX','teste@hotmail.com','4F30D655DFD64FAA85DA33F663D0B7E9','fdsaa',0);
/*!40000 ALTER TABLE `pagamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedido`
--

DROP TABLE IF EXISTS `pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pedido` (
  `pedido_id` int(11) NOT NULL AUTO_INCREMENT,
  `pedido_data` datetime DEFAULT NULL,
  `pedido_cliente` int(11) DEFAULT NULL,
  `pedido_local` int(11) unsigned zerofill DEFAULT NULL,
  `pedido_status` int(11) DEFAULT 1,
  `pedido_obs` text DEFAULT NULL,
  `pedido_desconto` decimal(10,2) DEFAULT NULL,
  `pedido_total` decimal(10,2) DEFAULT NULL,
  `pedido_entrega` decimal(10,2) DEFAULT NULL,
  `pedido_entrega_prazo` varchar(200) DEFAULT NULL,
  `pedido_entegrador` int(11) DEFAULT 0,
  `pedido_obs_pagto` varchar(200) DEFAULT NULL,
  `pedido_url_code` varchar(255) DEFAULT NULL,
  `pedido_pedidourl` varchar(255) DEFAULT NULL,
  `pedido_pagseguro` int(2) DEFAULT 0,
  PRIMARY KEY (`pedido_id`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedido`
--

LOCK TABLES `pedido` WRITE;
/*!40000 ALTER TABLE `pedido` DISABLE KEYS */;
/*!40000 ALTER TABLE `pedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedido_lista`
--

DROP TABLE IF EXISTS `pedido_lista`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pedido_lista` (
  `lista_id` int(11) NOT NULL AUTO_INCREMENT,
  `lista_pedido` int(11) DEFAULT NULL,
  `lista_item` int(11) DEFAULT NULL,
  `lista_item_nome` varchar(500) DEFAULT NULL,
  `lista_item_preco` double(10,2) DEFAULT NULL,
  `lista_opcao` int(11) DEFAULT NULL,
  `lista_opcao_preco` double(10,2) DEFAULT NULL,
  `lista_opcao_nome` varchar(200) DEFAULT NULL,
  `lista_info` varchar(500) DEFAULT NULL,
  `lista_qtde` int(3) DEFAULT NULL,
  `lista_item_desc` text DEFAULT NULL,
  `lista_item_obs` text DEFAULT NULL,
  `lista_item_codigo` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`lista_id`)
) ENGINE=InnoDB AUTO_INCREMENT=140 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedido_lista`
--

LOCK TABLES `pedido_lista` WRITE;
/*!40000 ALTER TABLE `pedido_lista` DISABLE KEYS */;
INSERT INTO `pedido_lista` VALUES (137,92,32,'5 QUEIJOS',NULL,NULL,47.75,'5 QUEIJOS',NULL,1,'Pequena, Massa Integral, Borda Tradicional','','18'),(138,93,762,'Burrito',NULL,NULL,21.00,'Burrito',NULL,1,'','frango, cebola, feijão vermelho,',''),(139,94,762,'Burrito',NULL,NULL,21.00,'Burrito',NULL,1,'','frango, cebola, feijão vermelho,','');
/*!40000 ALTER TABLE `pedido_lista` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `relprod`
--

DROP TABLE IF EXISTS `relprod`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `relprod` (
  `relprod_id` int(11) NOT NULL AUTO_INCREMENT,
  `relprod_grupo` int(5) DEFAULT NULL,
  `relprod_categoria` int(5) DEFAULT NULL,
  `relprod_status` int(1) DEFAULT 0,
  `relprod_pos` int(3) DEFAULT 0,
  PRIMARY KEY (`relprod_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `relprod`
--

LOCK TABLES `relprod` WRITE;
/*!40000 ALTER TABLE `relprod` DISABLE KEYS */;
INSERT INTO `relprod` VALUES (2,2,1,0,2),(3,1,1,0,1),(6,1,7,0,1),(7,1,13,0,1),(9,5,16,0,1),(11,6,1,0,0),(13,3,17,0,0),(14,3,18,0,0),(17,6,18,0,0),(18,7,18,0,0);
/*!40000 ALTER TABLE `relprod` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `smtp`
--

DROP TABLE IF EXISTS `smtp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `smtp` (
  `smtp_id` int(11) NOT NULL AUTO_INCREMENT,
  `smtp_host` varchar(200) DEFAULT NULL,
  `smtp_port` varchar(200) DEFAULT NULL,
  `smtp_email` varchar(200) DEFAULT NULL,
  `smtp_pass` varchar(200) DEFAULT NULL,
  `smtp_nome` varchar(200) DEFAULT NULL,
  `smtp_bcc` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`smtp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `smtp`
--

LOCK TABLES `smtp` WRITE;
/*!40000 ALTER TABLE `smtp` DISABLE KEYS */;
INSERT INTO `smtp` VALUES (1,'mail.site.com.br','587','abuse@phpstaff.com.br','gadgfasdgs','Flux Delivery','teste@gmail.com');
/*!40000 ALTER TABLE `smtp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `usuario_id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_nome` varchar(200) DEFAULT NULL,
  `usuario_login` varchar(200) DEFAULT NULL,
  `usuario_senha` varchar(200) DEFAULT NULL,
  `usuario_email` varchar(200) DEFAULT NULL,
  `usuario_fone` varchar(200) DEFAULT NULL,
  `usuario_nivel` int(1) DEFAULT NULL,
  `usuario_avatar` longtext DEFAULT NULL,
  PRIMARY KEY (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (8,'admin','admin','21232f297a57a5a743894a0e4a801fc3','suporte@phpstaff.com.br',NULL,1,''),(9,'operador 01','op01','34fffcc3383d3a7508cf6d55d25d60f3','operador@phpstaff.com.br',NULL,2,'');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;


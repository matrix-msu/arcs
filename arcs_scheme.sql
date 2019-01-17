-- MySQL dump 10.13  Distrib 5.7.20, for solaris11 (x86_64)
--
-- Host: localhost    Database: arcs_scheme
-- ------------------------------------------------------
-- Server version	5.7.20

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
-- Table structure for table `annotations`
--

DROP TABLE IF EXISTS `annotations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `annotations` (
  `id` char(36) NOT NULL,
  `relation_id` char(36) DEFAULT NULL,
  `resource_kid` varchar(45) DEFAULT NULL,
  `page_kid` varchar(45) DEFAULT NULL,
  `resource_name` text,
  `relation_resource_kid` varchar(45) DEFAULT NULL,
  `relation_page_kid` varchar(45) DEFAULT NULL,
  `relation_resource_name` text,
  `user_id` char(36) DEFAULT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `user_email` varchar(100) DEFAULT NULL,
  `user_username` varchar(100) DEFAULT NULL,
  `transcript` text,
  `url` text,
  `incoming` varchar(45) DEFAULT NULL,
  `x1` float DEFAULT NULL,
  `y1` float DEFAULT NULL,
  `x2` float DEFAULT NULL,
  `y2` float DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `resource_id` varchar(45) DEFAULT NULL,
  `order_transcript` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `transcript` (`transcript`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `annotations`
--

LOCK TABLES `annotations` WRITE;
/*!40000 ALTER TABLE `annotations` DISABLE KEYS */;
/*!40000 ALTER TABLE `annotations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `collections`
--

DROP TABLE IF EXISTS `collections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `collections` (
  `id` char(36) NOT NULL,
  `collection_id` char(36) DEFAULT NULL,
  `resource_kid` char(36) DEFAULT NULL,
  `user_id` char(36) DEFAULT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `title` text,
  `public` tinyint(2) DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `members` text,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `title` (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `collections`
--

LOCK TABLES `collections` WRITE;
/*!40000 ALTER TABLE `collections` DISABLE KEYS */;
/*!40000 ALTER TABLE `collections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` char(36) NOT NULL,
  `resource_kid` char(36) DEFAULT NULL,
  `parent_id` char(36) DEFAULT NULL,
  `user_id` char(36) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `content` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `content` (`content`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `flags`
--

DROP TABLE IF EXISTS `flags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `flags` (
  `id` char(36) NOT NULL,
  `resource_id` char(36) DEFAULT NULL,
  `page_kid` varchar(45) DEFAULT NULL,
  `resource_kid` varchar(45) DEFAULT NULL,
  `resource_name` text,
  `annotation_id` char(36) DEFAULT NULL,
  `annotation_target` varchar(45) DEFAULT NULL,
  `metadata_kid` varchar(45) DEFAULT NULL,
  `metadata_field` varchar(45) DEFAULT NULL,
  `user_id` char(36) DEFAULT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `user_email` varchar(100) DEFAULT NULL,
  `user_username` varchar(100) DEFAULT NULL,
  `reason` varchar(100) DEFAULT NULL,
  `explanation` text,
  `status` varchar(100) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `flags`
--

LOCK TABLES `flags` WRITE;
/*!40000 ALTER TABLE `flags` DISABLE KEYS */;
/*!40000 ALTER TABLE `flags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `keywords`
--

DROP TABLE IF EXISTS `keywords`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `keywords` (
  `id` char(36) NOT NULL,
  `project_kid` char(36) NOT NULL,
  `resource_kid` char(36) NOT NULL,
  `page_kid` char(36) NOT NULL,
  `keyword` text NOT NULL,
  `count` int(11) NOT NULL DEFAULT '1',
  `user_id` char(36) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `keyword` (`keyword`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `keywords`
--

LOCK TABLES `keywords` WRITE;
/*!40000 ALTER TABLE `keywords` DISABLE KEYS */;
/*!40000 ALTER TABLE `keywords` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mappings`
--

DROP TABLE IF EXISTS `mappings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mappings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` char(36) NOT NULL,
  `role` varchar(45) DEFAULT NULL,
  `pid` int(11) NOT NULL,
  `status` varchar(45) DEFAULT NULL,
  `activation` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_idUser_idx` (`id_user`),
  KEY `FK_idUserP_idU` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=375 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mappings`
--

LOCK TABLES `mappings` WRITE;
/*!40000 ALTER TABLE `mappings` DISABLE KEYS */;
INSERT INTO `mappings` VALUES (66,'572b90d2-bbcc-4d5c-9f5c-1b102309121e','Admin',11,'confirmed',NULL);
/*!40000 ALTER TABLE `mappings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `metadata_edits`
--

DROP TABLE IF EXISTS `metadata_edits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `metadata_edits` (
  `id` char(36) NOT NULL,
  `resource_kid` varchar(45) NOT NULL,
  `resource_name` tinytext,
  `scheme_id` int(11) NOT NULL,
  `control_type` varchar(255) NOT NULL,
  `user_id` char(36) NOT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `field_name` varchar(255) NOT NULL,
  `value_before` text,
  `new_value` text,
  `approved` binary(1) DEFAULT '0',
  `rejected` binary(1) DEFAULT '0',
  `reason_rejected` mediumtext,
  `metadata_kid` varchar(45) NOT NULL,
  `modified` datetime DEFAULT NULL,
  `orphan` binary(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `metadata_edits`
--

LOCK TABLES `metadata_edits` WRITE;
/*!40000 ALTER TABLE `metadata_edits` DISABLE KEYS */;
/*!40000 ALTER TABLE `metadata_edits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` char(36) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `isAdmin` tinyint(1) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `activation` varchar(45) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `reset` char(36) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('572b90d2-bbcc-4d5c-9f5c-1b102309121e','arcs@matrix.msu.edu','Admin','Admin','05b3f39fac1f60eb0f518628b459034ea7ebcfd2',1,'active',NULL,'2018-09-05 09:31:19','2018-09-05 09:31:19',NULL,'2018-09-05 09:31:19');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-10-11 18:39:53

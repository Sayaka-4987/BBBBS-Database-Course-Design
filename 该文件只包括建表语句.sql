-- MySQL dump 10.13  Distrib 8.0.17, for Win64 (x86_64)
--
-- Host: localhost    Database: bbs
-- ------------------------------------------------------
-- Server version	8.0.17

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Temporary view structure for view `count_post_by_user`
--

DROP TABLE IF EXISTS `count_post_by_user`;
/*!50001 DROP VIEW IF EXISTS `count_post_by_user`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `count_post_by_user` AS SELECT 
 1 AS `user_id`,
 1 AS `count(*)`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `forum`
--

DROP TABLE IF EXISTS `forum`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `forum` (
  `forum_name` varchar(16) NOT NULL,
  `bbs_admin` int(11) NOT NULL,
  `membership` int(11) NOT NULL,
  `total_post` int(11) NOT NULL,
  PRIMARY KEY (`forum_name`),
  KEY `bbs_admin` (`bbs_admin`),
  CONSTRAINT `forum_ibfk_1` FOREIGN KEY (`bbs_admin`) REFERENCES `member` (`user_id`),
  CONSTRAINT `not_negative` CHECK (((`membership` >= 0) and (`total_post` >= 0)))
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `member`
--

DROP TABLE IF EXISTS `member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `member` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_mail` varchar(256) NOT NULL,
  `username` varchar(32) NOT NULL,
  `user_password` varchar(32) NOT NULL,
  `signature` varchar(64) DEFAULT NULL,
  `join_date` timestamp NOT NULL,
  `xp` smallint(6) NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `uid` (`user_id`),
  UNIQUE KEY `username` (`username`),
  CONSTRAINT `ranks` CHECK ((`xp` between -(30) and 30))
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `post` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `author` int(11) NOT NULL,
  `heading` varchar(64) NOT NULL,
  `content` text NOT NULL,
  `replies` int(11) NOT NULL,
  `last_reply_time` timestamp NOT NULL,
  `forum_name` varchar(16) NOT NULL,
  `is_recommend` tinyint(1) NOT NULL,
  PRIMARY KEY (`post_id`),
  KEY `author` (`author`),
  KEY `forum_name` (`forum_name`),
  CONSTRAINT `post_ibfk_1` FOREIGN KEY (`author`) REFERENCES `member` (`user_id`),
  CONSTRAINT `post_ibfk_2` FOREIGN KEY (`forum_name`) REFERENCES `forum` (`forum_name`),
  CONSTRAINT `replies_not_negative` CHECK ((`replies` >= 0))
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary view structure for view `public_member`
--

DROP TABLE IF EXISTS `public_member`;
/*!50001 DROP VIEW IF EXISTS `public_member`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `public_member` AS SELECT 
 1 AS `user_mail`,
 1 AS `username`,
 1 AS `signature`,
 1 AS `join_date`,
 1 AS `xp`,
 1 AS `is_admin`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `reply`
--

DROP TABLE IF EXISTS `reply`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reply` (
  `reply_id` int(11) NOT NULL AUTO_INCREMENT,
  `author` int(11) NOT NULL,
  `content` text NOT NULL,
  `quote` int(11) DEFAULT NULL,
  `reply_time` timestamp NOT NULL,
  `post_id` int(11) NOT NULL,
  PRIMARY KEY (`reply_id`),
  KEY `author` (`author`),
  KEY `quote` (`quote`),
  KEY `post_id` (`post_id`),
  CONSTRAINT `reply_ibfk_1` FOREIGN KEY (`author`) REFERENCES `member` (`user_id`),
  CONSTRAINT `reply_ibfk_2` FOREIGN KEY (`quote`) REFERENCES `reply` (`reply_id`),
  CONSTRAINT `reply_ibfk_3` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `insert_reply` AFTER INSERT ON `reply` FOR EACH ROW begin  

    update `post` set `replies`=`replies`+1 where `post_id`=new.`post_id`;

    update `post` set `last_reply_time`=now() where `post_id`=new.`post_id`;

end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `delete_reply` AFTER DELETE ON `reply` FOR EACH ROW BEGIN 

    update `post` set `replies`=`replies`-1 where `post_id`=old.`post_id`;

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Temporary view structure for view `reply_by_user`
--

DROP TABLE IF EXISTS `reply_by_user`;
/*!50001 DROP VIEW IF EXISTS `reply_by_user`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `reply_by_user` AS SELECT 
 1 AS `user_id`,
 1 AS `user_mail`,
 1 AS `username`,
 1 AS `reply_id`,
 1 AS `content`,
 1 AS `quote`,
 1 AS `reply_time`,
 1 AS `post_id`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `security_question`
--

DROP TABLE IF EXISTS `security_question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `security_question` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `question` varchar(64) NOT NULL,
  `answer` varchar(64) NOT NULL,
  PRIMARY KEY (`question_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `security_question_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `member` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Final view structure for view `count_post_by_user`
--

/*!50001 DROP VIEW IF EXISTS `count_post_by_user`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `count_post_by_user` AS select `member`.`user_id` AS `user_id`,count(0) AS `count(*)` from (`member` join `post`) where (`member`.`user_id` = `post`.`author`) group by `member`.`user_id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `public_member`
--

/*!50001 DROP VIEW IF EXISTS `public_member`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `public_member` AS select `member`.`user_mail` AS `user_mail`,`member`.`username` AS `username`,`member`.`signature` AS `signature`,`member`.`join_date` AS `join_date`,`member`.`xp` AS `xp`,`member`.`is_admin` AS `is_admin` from `member` where (`member`.`xp` > 0) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `reply_by_user`
--

/*!50001 DROP VIEW IF EXISTS `reply_by_user`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `reply_by_user` AS select `member`.`user_id` AS `user_id`,`member`.`user_mail` AS `user_mail`,`member`.`username` AS `username`,`reply`.`reply_id` AS `reply_id`,`reply`.`content` AS `content`,`reply`.`quote` AS `quote`,`reply`.`reply_time` AS `reply_time`,`reply`.`post_id` AS `post_id` from (`member` join `reply`) where (`member`.`user_id` = `reply`.`author`) group by `member`.`user_id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-12-26 14:11:23

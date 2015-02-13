-- MySQL dump 10.13  Distrib 5.5.40, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: placement
-- ------------------------------------------------------
-- Server version	5.5.40-0ubuntu0.14.04.1

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
  `adminid` int(11) NOT NULL,
  `username` varchar(10) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `password` varchar(10) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  PRIMARY KEY (`adminid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'admin','admin');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company`
--

DROP TABLE IF EXISTS `company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company` (
  `company_name` varchar(50) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `location` varchar(50) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `status` enum('C1','C2','C3','Others') NOT NULL DEFAULT 'Others',
  `password` varchar(50) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT 'pass',
  `added_by` int(10) NOT NULL,
  `added_on` date DEFAULT NULL,
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`cid`),
  KEY `added_by` (`added_by`),
  CONSTRAINT `company_ibfk_1` FOREIGN KEY (`added_by`) REFERENCES `students` (`rollno`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company`
--

LOCK TABLES `company` WRITE;
/*!40000 ALTER TABLE `company` DISABLE KEYS */;
INSERT INTO `company` VALUES ('google','mountain view','C1','google',102,'2014-09-14',1),('yahoo','california','C1','yahoo',102,'2014-09-14',2),('oracle','bangalore','C1','oracle',102,'2014-09-14',3),('dshaw','chennai','C1','dshaw',102,'2014-09-14',4),('3rat','usa','C1','3rat',102,'2014-09-14',5),('lauda','sdasd','Others','lauda',102,'2014-09-14',6),('mirage','chomi','C1','mirage',102,'2014-09-14',7),('some comp','delhi','C1','some comp',102,'2014-09-14',8),('tower research','gurgaon','C1','tower research',102,'2014-09-14',9),('wer','ttt','C1','wer',102,'2014-09-14',10),('xx','xx','Others','xx',101,'2014-09-17',11),('ibm research','new jersey','Others','ibm research',133059010,'2014-09-17',12),('cse','mumbai','C1','cse',200,'2014-09-26',13),('edgeverve','bangalore','C1','edgeverve',200,'2014-11-21',14),('iitb','bombay','C1','iitb',200,'2014-11-22',15),('sushworks','mumbai','C2','sushworks',200,'2014-11-22',16),('test','test','C3','test',200,'2014-11-23',17),('supercomp','bangalore','C3','supercomp',200,'2014-11-24',18),('iitb cs718','bombay','C1','iitb cs718',200,'2014-11-27',19);
/*!40000 ALTER TABLE `company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jafs`
--

DROP TABLE IF EXISTS `jafs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jafs` (
  `jid` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL,
  `cgpa` float NOT NULL,
  `dept` enum('CSE','EE','ME','CE','AE','ES','PH','MT') NOT NULL,
  `disc` enum('BTech','MTech','MSc','PhD') NOT NULL,
  `position` varchar(50) NOT NULL,
  PRIMARY KEY (`jid`),
  KEY `cid` (`cid`),
  CONSTRAINT `jafs_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `company` (`cid`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jafs`
--

LOCK TABLES `jafs` WRITE;
/*!40000 ALTER TABLE `jafs` DISABLE KEYS */;
INSERT INTO `jafs` VALUES (5,1,5,'CSE','MTech','developer'),(6,1,7,'CSE','MTech','quality assurance'),(7,1,6,'CSE','MTech','architect'),(8,1,7,'CSE','MTech','white box tester'),(9,6,7,'CSE','MTech','dev'),(10,1,9,'ES','BTech','t'),(11,11,7,'CSE','MTech','developer'),(12,1,6,'EE','MTech','quality assurance'),(15,1,8,'EE','BTech','circuit designer'),(16,6,7,'CSE','MTech','tester');
/*!40000 ALTER TABLE `jafs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `placed`
--

DROP TABLE IF EXISTS `placed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `placed` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `rollno` int(11) NOT NULL,
  `jid` int(11) NOT NULL,
  `placed` tinyint(1) NOT NULL DEFAULT '0',
  `cid` int(11) NOT NULL,
  PRIMARY KEY (`pid`),
  KEY `rollno` (`rollno`),
  KEY `jid` (`jid`),
  KEY `cid` (`cid`),
  CONSTRAINT `placed_ibfk_1` FOREIGN KEY (`rollno`) REFERENCES `students` (`rollno`),
  CONSTRAINT `placed_ibfk_2` FOREIGN KEY (`jid`) REFERENCES `jafs` (`jid`),
  CONSTRAINT `placed_ibfk_3` FOREIGN KEY (`cid`) REFERENCES `company` (`cid`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `placed`
--

LOCK TABLES `placed` WRITE;
/*!40000 ALTER TABLE `placed` DISABLE KEYS */;
INSERT INTO `placed` VALUES (2,101,5,0,1),(3,105,5,1,1),(4,101,6,0,1),(7,101,7,1,1),(8,101,9,0,6),(9,101,11,0,11),(10,133059010,11,1,11),(11,133059010,5,0,1),(12,133059010,9,1,6),(13,200,5,0,1),(14,200,6,0,1),(15,200,9,1,6),(16,200,7,1,1),(17,200,8,0,1),(18,200,11,0,11),(19,200,16,1,6);
/*!40000 ALTER TABLE `placed` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `placement_result`
--

DROP TABLE IF EXISTS `placement_result`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `placement_result` (
  `name_of_student` varchar(50) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `name_of_company` varchar(50) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `selected_for_jaf` varchar(3) CHARACTER SET ascii COLLATE ascii_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `placement_result`
--

LOCK TABLES `placement_result` WRITE;
/*!40000 ALTER TABLE `placement_result` DISABLE KEYS */;
/*!40000 ALTER TABLE `placement_result` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `students` (
  `rollno` int(10) NOT NULL,
  `name` varchar(50) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `dept` enum('CSE','EE','ME','CE','AE','ES','PH','MT') CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `disc` enum('BTech','MTech','MSc','PhD') CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `cgpa` float NOT NULL,
  `is_registered` tinyint(1) NOT NULL,
  `is_dpc` tinyint(1) NOT NULL,
  `is_placed` tinyint(1) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`rollno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES (101,'Abc Xyz','CSE','MTech',8,1,1,1,'1234'),(102,'def ghi','CSE','BTech',9,1,1,0,'1234'),(103,'ghi jkl','CSE','MSc',8.5,0,0,0,'1234'),(105,'xyz','CSE','MTech',8,1,0,1,'1234'),(200,'test stu1','CSE','MTech',8,1,1,1,'1234'),(201,'test stu2','EE','BTech',9,1,0,0,'1234'),(203,'test stu3','AE','MTech',8.5,1,0,0,'1234'),(133059010,'saransh sharma','CSE','MTech',8,0,0,1,'1234');
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-12-01 12:26:27

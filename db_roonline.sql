/*
SQLyog Community v13.2.0 (64 bit)
MySQL - 8.0.30 : Database - db_roonline
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_roonline` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `db_roonline`;

/*Table structure for table `data_loger_commet` */

DROP TABLE IF EXISTS `data_loger_commet`;

CREATE TABLE `data_loger_commet` (
  `intDataLoger_ID` int NOT NULL AUTO_INCREMENT,
  `intDevice_ID` int NOT NULL,
  `floatRH` float NOT NULL,
  `floatTemp` float NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`intDataLoger_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `level_has_menu` */

DROP TABLE IF EXISTS `level_has_menu`;

CREATE TABLE `level_has_menu` (
  `intLevel_ID` int unsigned NOT NULL,
  `intMenu_ID` int unsigned NOT NULL,
  KEY `FK_level_has_menu_intLevel_ID_to_mlevels` (`intLevel_ID`),
  KEY `FK_level_has_menu_intMenu_ID_to_mmenu` (`intMenu_ID`),
  CONSTRAINT `FK_level_has_menu_intLevel_ID_to_mlevels` FOREIGN KEY (`intLevel_ID`) REFERENCES `mlevels` (`intLevel_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_level_has_menu_intMenu_ID_to_mmenu` FOREIGN KEY (`intMenu_ID`) REFERENCES `mmenu` (`intMenu_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `log_history` */

DROP TABLE IF EXISTS `log_history`;

CREATE TABLE `log_history` (
  `intLog_History_ID` int NOT NULL AUTO_INCREMENT,
  `intROModule_ID` int NOT NULL,
  `floatValues` float NOT NULL,
  `txtStatus` mediumtext COLLATE utf8mb4_general_ci NOT NULL,
  `txtLineProcessName` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `txtBatchOrder` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `txtProductName` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `txtProductionCode` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `dtmExpireDate` date NOT NULL,
  `txtOptFilling` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `txtOptQA` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`intLog_History_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3084086 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `log_rhandtemp` */

DROP TABLE IF EXISTS `log_rhandtemp`;

CREATE TABLE `log_rhandtemp` (
  `intLog_RhandTemp_ID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `txtLineProcessName` varchar(32) DEFAULT NULL,
  `intArea_ID` int unsigned DEFAULT NULL,
  `intModule_ID` int DEFAULT NULL,
  `floatTemp` float DEFAULT NULL,
  `floatRH` float DEFAULT NULL,
  `TimeStamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`intLog_RhandTemp_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=165801 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Table structure for table `marea` */

DROP TABLE IF EXISTS `marea`;

CREATE TABLE `marea` (
  `intArea_ID` int unsigned NOT NULL AUTO_INCREMENT,
  `txtAreaName` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `txtCreatedBy` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dtmCreatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `txtUpdatedBy` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dtmUpdatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `txtDeletedBy` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dtmDeletedAt` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`intArea_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `mlevels` */

DROP TABLE IF EXISTS `mlevels`;

CREATE TABLE `mlevels` (
  `intLevel_ID` int unsigned NOT NULL AUTO_INCREMENT,
  `txtLevelName` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `dtmCreatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `dtmUpdatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`intLevel_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `mline` */

DROP TABLE IF EXISTS `mline`;

CREATE TABLE `mline` (
  `intLine_ID` int unsigned NOT NULL AUTO_INCREMENT,
  `txtLineProcessName` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `txtCreatedBy` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dtmCreatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `txtUpdatedBy` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dtmUpdatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `txtDeletedBy` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dtmDeletedAt` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`intLine_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `mmenu` */

DROP TABLE IF EXISTS `mmenu`;

CREATE TABLE `mmenu` (
  `intMenu_ID` int unsigned NOT NULL AUTO_INCREMENT,
  `txtMenuTitle` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `txtMenuIcon` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `txtMenuRoute` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `txtMenuUrl` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `intQueue` int NOT NULL,
  `dtmCreatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `dtmUpdatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`intMenu_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `mreasonro` */

DROP TABLE IF EXISTS `mreasonro`;

CREATE TABLE `mreasonro` (
  `intReasonRO_ID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `intLog_History_ID` int NOT NULL,
  `txtReason` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `txtCreatedBy` bigint NOT NULL,
  `dtmCreatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `dtmUpdatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`intReasonRO_ID`),
  KEY `FK_IntLog_History_ID_to_log_history` (`intLog_History_ID`),
  CONSTRAINT `FK_IntLog_History_ID_to_log_history` FOREIGN KEY (`intLog_History_ID`) REFERENCES `log_history` (`intLog_History_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `mst_locater` */

DROP TABLE IF EXISTS `mst_locater`;

CREATE TABLE `mst_locater` (
  `intLocater_ID` int NOT NULL AUTO_INCREMENT,
  `txtLocaterName` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `bitActive` bit(1) NOT NULL,
  `txtInsertedBy` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `dtmInserted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `txtUpdatedBy` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `dtmUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`intLocater_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `mst_product` */

DROP TABLE IF EXISTS `mst_product`;

CREATE TABLE `mst_product` (
  `intProduct_ID` int NOT NULL AUTO_INCREMENT,
  `txtArtCode` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `txtProductName` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`intProduct_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=138 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `mst_romodule` */

DROP TABLE IF EXISTS `mst_romodule`;

CREATE TABLE `mst_romodule` (
  `intROModule_ID` int NOT NULL AUTO_INCREMENT,
  `txtModuleName` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `intLocater_ID` int NOT NULL,
  `bitActive` bit(1) NOT NULL,
  `txtInsertedBy` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `dtmInserted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `txtUpdatedBy` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `dtmUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`intROModule_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `msubmenu` */

DROP TABLE IF EXISTS `msubmenu`;

CREATE TABLE `msubmenu` (
  `intSubmenu_ID` int unsigned NOT NULL AUTO_INCREMENT,
  `intMenu_ID` int unsigned NOT NULL,
  `txtSubmenuTitle` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `txtSubmenuIcon` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `txtSubmenuUrl` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `txtSubmenuRoute` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dtmCreatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `dtmUpdatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`intSubmenu_ID`),
  KEY `FK_msubmenu_intMenu_id_to_mmenu` (`intMenu_ID`),
  CONSTRAINT `FK_msubmenu_intMenu_id_to_mmenu` FOREIGN KEY (`intMenu_ID`) REFERENCES `mmenu` (`intMenu_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `trprocess` */

DROP TABLE IF EXISTS `trprocess`;

CREATE TABLE `trprocess` (
  `intProcess_ID` int NOT NULL AUTO_INCREMENT,
  `txtLineProcessName` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `txtBatchOrder` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `txtProductName` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `txtProductionCode` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `dtmExpireDate` date NOT NULL,
  `txtOptFilling` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `txtOptQA` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`intProcess_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `truser_level` */

DROP TABLE IF EXISTS `truser_level`;

CREATE TABLE `truser_level` (
  `intLevel_ID` int unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `dtmCreatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `dtmUpdatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `truser_level_intLevel_ID_Foreign` (`intLevel_ID`),
  KEY `truser_level_user_id_Foreign` (`user_id`),
  CONSTRAINT `truser_level_intLevel_ID_Foreign` FOREIGN KEY (`intLevel_ID`) REFERENCES `mlevels` (`intLevel_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `truser_level_user_id_Foreign` FOREIGN KEY (`user_id`) REFERENCES `db_standardization`.`musers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(225) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fullname` varchar(225) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(225) COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(225) COLLATE utf8mb4_general_ci NOT NULL,
  `photo` varchar(225) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

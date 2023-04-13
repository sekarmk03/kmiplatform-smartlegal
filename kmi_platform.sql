/*
SQLyog Community v13.2.0 (64 bit)
MySQL - 8.0.30 : Database - db_standardization
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_standardization` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `db_standardization`;

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `maccounts` */

DROP TABLE IF EXISTS `maccounts`;

CREATE TABLE `maccounts` (
  `intAccount_ID` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `txtUsername` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `txtPassword` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `txtCreatedBy` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dtmCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `txtUpdatedBy` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dtmUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`intAccount_ID`),
  KEY `maccounts_user_id_foreign` (`user_id`),
  CONSTRAINT `maccounts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `musers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `maccounts` */

insert  into `maccounts`(`intAccount_ID`,`user_id`,`txtUsername`,`txtPassword`,`txtCreatedBy`,`dtmCreated`,`txtUpdatedBy`,`dtmUpdated`) values 
(4,2,'alidavit','alidavit@123','ALI DAVIT','2023-03-27 08:29:18',NULL,'2023-03-27 08:29:18');

/*Table structure for table `mdatabases` */

DROP TABLE IF EXISTS `mdatabases`;

CREATE TABLE `mdatabases` (
  `intDatabase_ID` int unsigned NOT NULL AUTO_INCREMENT,
  `intAccount_ID` int unsigned NOT NULL,
  `txtDatabaseName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `txtCreatedBy` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dtmCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `txtUpdatedBy` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dtmUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`intDatabase_ID`),
  KEY `mdatabases_intAccount_ID_foreign` (`intAccount_ID`),
  CONSTRAINT `mdatabases_intAccount_ID_foreign` FOREIGN KEY (`intAccount_ID`) REFERENCES `maccounts` (`intAccount_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `mdatabases` */

insert  into `mdatabases`(`intDatabase_ID`,`intAccount_ID`,`txtDatabaseName`,`txtCreatedBy`,`dtmCreated`,`txtUpdatedBy`,`dtmUpdated`) values 
(6,4,'db_roonline','ALI DAVIT','2023-03-27 11:00:59','ALI DAVIT','2023-03-27 11:00:59');

/*Table structure for table `mdepartments` */

DROP TABLE IF EXISTS `mdepartments`;

CREATE TABLE `mdepartments` (
  `intDepartment_ID` int unsigned NOT NULL AUTO_INCREMENT,
  `txtDepartmentName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `txtInitial` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `txtCreatedBy` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dtmCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `txtUpdatedBy` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dtmUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`intDepartment_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `mdepartments` */

insert  into `mdepartments`(`intDepartment_ID`,`txtDepartmentName`,`txtInitial`,`txtCreatedBy`,`dtmCreated`,`txtUpdatedBy`,`dtmUpdated`) values 
(1,'PRODUCTION','PRD',NULL,'2023-02-27 15:00:10',NULL,'2023-02-28 10:50:51'),
(2,'WAREHOUSE','WHS',NULL,'2023-02-28 10:48:28',NULL,'2023-02-28 10:50:52'),
(7,'QA','QA',NULL,'2023-03-26 17:04:59',NULL,'2023-03-26 17:04:59'),
(8,'MANUFACTURING DEVELOPMENT PLANNING','MDP',NULL,'2023-03-31 14:43:52',NULL,'2023-03-31 14:43:52');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'2019_08_19_000000_create_failed_jobs_table',1),
(2,'2023_02_27_015459_create_mlevels_table',1),
(3,'2023_02_27_015739_create_mdepartments_table',1),
(4,'2023_02_27_020005_create_musers_table',1),
(5,'2023_02_27_020927_create_mmenus_table',1),
(6,'2023_02_27_022223_create_msubmenus_table',1),
(7,'2023_03_24_080923_create_mmodules_table',2),
(8,'2023_03_24_134516_create_maccounts_table',3),
(9,'2023_03_26_032220_create_mdatabases_table',4);

/*Table structure for table `mlevel_access` */

DROP TABLE IF EXISTS `mlevel_access`;

CREATE TABLE `mlevel_access` (
  `intLevelAccess_ID` int unsigned NOT NULL AUTO_INCREMENT,
  `intSubmenu_ID` int unsigned NOT NULL,
  `intLevel_ID` int unsigned NOT NULL,
  `dtmCreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `txtCreatedBy` varchar(128) DEFAULT NULL,
  `dtmUpdated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `txtUpdatedBy` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`intLevelAccess_ID`),
  KEY `Foreign_key_mlevelaccess_to_mlevels_intLevel_ID` (`intLevel_ID`),
  KEY `Foreign_Key_mlevelaccess_to_msubmenus_intSubmenu_ID` (`intSubmenu_ID`),
  CONSTRAINT `Foreign_key_mlevelaccess_to_mlevels_intLevel_ID` FOREIGN KEY (`intLevel_ID`) REFERENCES `mlevels` (`intLevel_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Foreign_Key_mlevelaccess_to_msubmenus_intSubmenu_ID` FOREIGN KEY (`intSubmenu_ID`) REFERENCES `msubmenus` (`intSubmenu_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `mlevel_access` */

insert  into `mlevel_access`(`intLevelAccess_ID`,`intSubmenu_ID`,`intLevel_ID`,`dtmCreated`,`txtCreatedBy`,`dtmUpdated`,`txtUpdatedBy`) values 
(1,2,1,'2023-02-28 15:56:42',NULL,'2023-03-01 11:30:09',NULL),
(2,3,1,'2023-02-28 15:57:08',NULL,'2023-03-01 11:30:07',NULL),
(3,1,1,'2023-02-28 15:57:17',NULL,'2023-02-28 15:57:17',NULL),
(4,5,1,'2023-03-01 09:52:10',NULL,'2023-03-01 09:52:10',NULL),
(6,8,1,'2023-03-08 13:54:06',NULL,'2023-03-08 13:54:06',NULL),
(7,7,1,'2023-03-16 09:48:54',NULL,'2023-03-16 09:48:54',NULL),
(8,9,1,'2023-03-20 11:07:22',NULL,'2023-03-20 11:07:22',NULL);

/*Table structure for table `mlevels` */

DROP TABLE IF EXISTS `mlevels`;

CREATE TABLE `mlevels` (
  `intLevel_ID` int unsigned NOT NULL AUTO_INCREMENT,
  `txtLevelName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `txtCreatedBy` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dtmCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `txtUpdatedBy` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dtmUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`intLevel_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `mlevels` */

insert  into `mlevels`(`intLevel_ID`,`txtLevelName`,`txtCreatedBy`,`dtmCreated`,`txtUpdatedBy`,`dtmUpdated`) values 
(1,'ADMINISTRATOR',NULL,'2023-02-27 11:03:35',NULL,'2023-03-16 09:59:12'),
(12,'CHAMPION','ADMIN','2023-03-26 17:04:35',NULL,'2023-03-26 17:04:35');

/*Table structure for table `mmenus` */

DROP TABLE IF EXISTS `mmenus`;

CREATE TABLE `mmenus` (
  `intMenu_ID` int unsigned NOT NULL AUTO_INCREMENT,
  `txtMenuTitle` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `txtMenuIcon` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `txtCreatedBy` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dtmCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `txtUpdatedBy` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dtmUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`intMenu_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `mmenus` */

insert  into `mmenus`(`intMenu_ID`,`txtMenuTitle`,`txtMenuIcon`,`txtCreatedBy`,`dtmCreated`,`txtUpdatedBy`,`dtmUpdated`) values 
(1,'Dashboard','ion-ios-pulse bg-success',NULL,'2023-02-28 15:53:43',NULL,'2023-03-01 10:44:47'),
(2,'Master Data','ion-ios-settings bg-blue',NULL,'2023-02-27 15:49:50',NULL,'2023-03-08 14:12:37'),
(3,'Chart menu','ion-ios-pie bg-purple','ADMIN','2023-03-08 09:23:28','ADMIN','2023-03-20 14:12:59');

/*Table structure for table `mmodules` */

DROP TABLE IF EXISTS `mmodules`;

CREATE TABLE `mmodules` (
  `intModule_ID` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `txtModuleName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `intStatus` tinyint(1) NOT NULL DEFAULT '1',
  `txtCreatedBy` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dtmCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `txtUpdatedBy` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dtmUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`intModule_ID`),
  KEY `mmodules_user_id_foreign` (`user_id`),
  CONSTRAINT `mmodules_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `musers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `mmodules` */

insert  into `mmodules`(`intModule_ID`,`user_id`,`txtModuleName`,`intStatus`,`txtCreatedBy`,`dtmCreated`,`txtUpdatedBy`,`dtmUpdated`) values 
(1,2,'ROonline',1,'ALI DAVIT','2023-03-27 10:48:53',NULL,'2023-03-31 14:43:00'),
(2,3,'OEEonline',1,'IRPAN HIDAYAT PAMIL','2023-03-31 14:46:31',NULL,'2023-03-31 14:46:31'),
(3,2,'FTQ',1,'ALI DAVIT','2023-04-03 09:27:43',NULL,'2023-04-03 09:27:43');

/*Table structure for table `msubmenus` */

DROP TABLE IF EXISTS `msubmenus`;

CREATE TABLE `msubmenus` (
  `intSubmenu_ID` int unsigned NOT NULL AUTO_INCREMENT,
  `intMenu_ID` int unsigned NOT NULL,
  `txtSubmenuTitle` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `txtSubmenuIcon` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `txtUrl` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `txtRouteName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `txtCreatedBy` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dtmCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `txtUpdatedBy` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dtmUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`intSubmenu_ID`),
  KEY `msubmenus_intmenu_id_foreign` (`intMenu_ID`),
  CONSTRAINT `msubmenus_intmenu_id_foreign` FOREIGN KEY (`intMenu_ID`) REFERENCES `mmenus` (`intMenu_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `msubmenus` */

insert  into `msubmenus`(`intSubmenu_ID`,`intMenu_ID`,`txtSubmenuTitle`,`txtSubmenuIcon`,`txtUrl`,`txtRouteName`,`txtCreatedBy`,`dtmCreated`,`txtUpdatedBy`,`dtmUpdated`) values 
(1,1,'Dashboard PRD','fa-solid fa-chart-line','dashboard/prd','manage.user.index',NULL,'2023-02-28 15:54:22',NULL,'2023-03-20 10:56:07'),
(2,2,'Manage Menu','fa-solid fa-list-check','admin/manage-menus','manage.menu.index',NULL,'2023-02-27 16:33:42','ADMIN','2023-03-20 10:56:11'),
(3,2,'Manage Submenu','fa-solid fa-list-check','admin/manage-submenus','manage.submenu.index',NULL,'2023-02-28 15:54:50',NULL,'2023-03-08 14:14:22'),
(5,2,'Manage Users','fa-solid fa-user-plus','admin/manage-users','manage.user.index',NULL,'2023-03-01 09:51:44','ADMIN','2023-03-26 16:56:38'),
(7,2,'Manage Levels','fa-brands fa-elementor','admin/manage-levels','manage.level.index',NULL,'2023-03-08 09:23:14','ADMIN','2023-03-16 14:03:02'),
(8,2,'Manage Departments','fa-solid fa-user-tag','admin/manage-departments','manage.department.index',NULL,'2023-03-08 13:51:49','ADMIN','2023-03-20 15:19:05'),
(9,2,'Manage Modules','fa-solid fa-code','admin/manage-modules','manage.module.index','ADMIN','2023-03-20 08:39:05','ADMIN','2023-03-20 10:48:38'),
(11,2,'Manage DB Account','fa-solid fa-database','admin/manage-dbaccounts','manage.dbaccount.index','ADMIN','2023-03-24 14:04:24',NULL,'2023-03-24 14:30:24');

/*Table structure for table `musers` */

DROP TABLE IF EXISTS `musers`;

CREATE TABLE `musers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `intLevel_ID` int unsigned NOT NULL,
  `intDepartment_ID` int unsigned NOT NULL,
  `txtName` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `txtNik` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `txtUsername` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `txtInitial` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `txtEmail` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `txtPhoto` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default.png',
  `txtPassword` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(155) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `txtCreatedBy` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dtmCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `txtUpdatedBy` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dtmUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `musers_intlevel_id_foreign` (`intLevel_ID`),
  KEY `musers_intdepartment_id_foreign` (`intDepartment_ID`),
  CONSTRAINT `musers_intdepartment_id_foreign` FOREIGN KEY (`intDepartment_ID`) REFERENCES `mdepartments` (`intDepartment_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `musers_intlevel_id_foreign` FOREIGN KEY (`intLevel_ID`) REFERENCES `mlevels` (`intLevel_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `musers` */

insert  into `musers`(`id`,`intLevel_ID`,`intDepartment_ID`,`txtName`,`txtNik`,`txtUsername`,`txtInitial`,`txtEmail`,`txtPhoto`,`txtPassword`,`remember_token`,`txtCreatedBy`,`dtmCreated`,`txtUpdatedBy`,`dtmUpdated`) values 
(1,1,1,'ADMIN','K22222','administrator','ADM','admin@gmail.com','1677569572.png','$2a$12$aAdvzmKopIqZK9/sKTvOB.TWBfAvD8Fc9oZ1LqwkytmJjtF0TEHvq','SKRSfcERYFvKq4ziFJKUC666ducZQIaA9I1L9K3Cxaz5iH7b7A3ixyodaKpN',NULL,'2023-02-28 14:32:52',NULL,'2023-04-03 13:20:51'),
(2,12,7,'ALI DAVIT','K230200025','alidavit','ADT','alidavit85@gmail.com','default.png','$2y$10$jGFLKJfuKtFZQk4yLrFLj.3Z9CwmwLo6nRcET4M/s.bqFaUcuP6A2','inMaHIFF00jY98zDnVulwGopTgpfXy3VbnqybyH3VlzayYOpiLK537wPrmBY',NULL,'2023-03-26 23:04:12',NULL,'2023-04-03 13:59:07'),
(3,12,8,'IRPAN HIDAYAT PAMIL','8726736','irpan.pamil','IHP','irpan.pamil@kalbenutritionals.com','default.png','$2y$10$iZEHvKXaxLzpJfNc32MUSOtmhH2.Dt4U/2fwf5yotn7wzFu6hqODO','vi8SyDcp6rGIQMOa1eUkEvZdV6m1o8t7xUHq49tRRpwmdhM0iZExFkl3lf8L',NULL,'2023-03-31 14:44:49',NULL,'2023-03-31 16:32:21');

/*Table structure for table `trlevel_access` */

DROP TABLE IF EXISTS `trlevel_access`;

CREATE TABLE `trlevel_access` (
  `intLevel_ID` int unsigned NOT NULL,
  `intSubmenu_ID` int unsigned NOT NULL,
  `intRoute_ID` int unsigned NOT NULL,
  `intAccessible` tinyint(1) NOT NULL DEFAULT '0',
  `txtCreatedBy` varchar(128) DEFAULT NULL,
  `dtmCreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `txtUpdatedBy` varchar(128) DEFAULT NULL,
  `dtmUpdated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `FK_trlevel_access_intRoute_ID_to_mroutes` (`intRoute_ID`),
  KEY `FK_trlevel_access_intLevelID_to_mlevel_access` (`intSubmenu_ID`),
  KEY `FK_trlevel_access_intLevel_ID_to_mlevels_intLevel_ID` (`intLevel_ID`),
  CONSTRAINT `FK_trlevel_access_intLevel_ID_to_mlevels_intLevel_ID` FOREIGN KEY (`intLevel_ID`) REFERENCES `mlevels` (`intLevel_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_trlevel_access_intRoute_ID_to_mroutes` FOREIGN KEY (`intRoute_ID`) REFERENCES `trroutes` (`intRoute_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_trlevel_access_intSubmenu_ID_to_msubmenus_intSubmenu_ID` FOREIGN KEY (`intSubmenu_ID`) REFERENCES `msubmenus` (`intSubmenu_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `trlevel_access` */

insert  into `trlevel_access`(`intLevel_ID`,`intSubmenu_ID`,`intRoute_ID`,`intAccessible`,`txtCreatedBy`,`dtmCreated`,`txtUpdatedBy`,`dtmUpdated`) values 
(12,2,1,0,NULL,'2023-03-26 23:04:36',NULL,'2023-03-26 23:04:36'),
(12,2,2,0,NULL,'2023-03-26 23:04:36',NULL,'2023-03-26 23:04:36'),
(12,2,3,0,NULL,'2023-03-26 23:04:36',NULL,'2023-03-26 23:04:36'),
(12,2,4,0,NULL,'2023-03-26 23:04:36',NULL,'2023-03-26 23:04:36'),
(12,2,5,0,NULL,'2023-03-26 23:04:36',NULL,'2023-03-26 23:04:36'),
(12,3,6,0,NULL,'2023-03-26 23:04:36',NULL,'2023-03-26 23:04:36'),
(12,3,7,0,NULL,'2023-03-26 23:04:36',NULL,'2023-03-26 23:04:36'),
(12,3,8,0,NULL,'2023-03-26 23:04:36',NULL,'2023-03-26 23:04:36'),
(12,3,9,0,NULL,'2023-03-26 23:04:36',NULL,'2023-03-26 23:04:36'),
(12,3,10,0,NULL,'2023-03-26 23:04:36',NULL,'2023-03-26 23:04:36'),
(12,5,33,0,NULL,'2023-03-26 23:04:36',NULL,'2023-03-26 23:04:36'),
(12,5,34,0,NULL,'2023-03-26 23:04:36',NULL,'2023-03-26 23:04:36'),
(12,5,35,0,NULL,'2023-03-26 23:04:36',NULL,'2023-03-26 23:04:36'),
(12,5,36,0,NULL,'2023-03-26 23:04:36',NULL,'2023-03-26 23:04:36'),
(12,5,37,0,NULL,'2023-03-26 23:04:36',NULL,'2023-03-26 23:04:36'),
(12,5,38,0,NULL,'2023-03-26 23:04:36',NULL,'2023-03-26 23:04:36'),
(12,7,11,0,NULL,'2023-03-26 23:04:36',NULL,'2023-03-26 23:04:36'),
(12,7,12,0,NULL,'2023-03-26 23:04:36',NULL,'2023-03-26 23:04:36'),
(12,7,13,0,NULL,'2023-03-26 23:04:36',NULL,'2023-03-26 23:04:36'),
(12,7,14,0,NULL,'2023-03-26 23:04:36',NULL,'2023-03-26 23:04:36'),
(12,7,15,0,NULL,'2023-03-26 23:04:36',NULL,'2023-03-26 23:04:36'),
(12,7,16,0,NULL,'2023-03-26 23:04:36',NULL,'2023-03-26 23:04:36'),
(12,7,27,0,NULL,'2023-03-26 23:04:36',NULL,'2023-03-26 23:04:36'),
(12,8,17,0,NULL,'2023-03-26 23:04:36',NULL,'2023-03-26 23:04:36'),
(12,8,18,0,NULL,'2023-03-26 23:04:36',NULL,'2023-03-26 23:04:36'),
(12,8,19,0,NULL,'2023-03-26 23:04:36',NULL,'2023-03-26 23:04:36'),
(12,8,20,0,NULL,'2023-03-26 23:04:36',NULL,'2023-03-26 23:04:36'),
(12,8,21,0,NULL,'2023-03-26 23:04:36',NULL,'2023-03-26 23:04:36'),
(12,9,22,1,NULL,'2023-03-26 23:04:36',NULL,'2023-03-26 23:04:36'),
(12,9,23,1,NULL,'2023-03-26 23:04:36',NULL,'2023-03-26 23:04:36'),
(12,9,24,1,NULL,'2023-03-26 23:04:36',NULL,'2023-03-26 23:04:36'),
(12,9,25,1,NULL,'2023-03-26 23:04:36',NULL,'2023-03-26 23:04:36'),
(12,9,26,1,NULL,'2023-03-26 23:04:36',NULL,'2023-03-26 23:04:36'),
(12,11,28,1,NULL,'2023-03-26 23:04:36',NULL,'2023-03-26 23:04:36'),
(12,11,29,1,NULL,'2023-03-26 23:04:36',NULL,'2023-03-26 23:04:36'),
(12,11,30,1,NULL,'2023-03-26 23:04:36',NULL,'2023-03-26 23:04:36'),
(12,11,31,1,NULL,'2023-03-26 23:04:36',NULL,'2023-03-26 23:04:36'),
(12,11,32,1,NULL,'2023-03-26 23:04:36',NULL,'2023-03-26 23:04:36'),
(1,2,1,1,NULL,'2023-03-27 08:43:13',NULL,'2023-03-27 08:43:13'),
(1,2,2,1,NULL,'2023-03-27 08:43:13',NULL,'2023-03-27 08:43:13'),
(1,2,3,1,NULL,'2023-03-27 08:43:13',NULL,'2023-03-27 08:43:13'),
(1,2,4,1,NULL,'2023-03-27 08:43:13',NULL,'2023-03-27 08:43:13'),
(1,2,5,1,NULL,'2023-03-27 08:43:13',NULL,'2023-03-27 08:43:13'),
(1,3,6,1,NULL,'2023-03-27 08:43:13',NULL,'2023-03-27 08:43:13'),
(1,3,7,1,NULL,'2023-03-27 08:43:13',NULL,'2023-03-27 08:43:13'),
(1,3,8,1,NULL,'2023-03-27 08:43:13',NULL,'2023-03-27 08:43:13'),
(1,3,9,1,NULL,'2023-03-27 08:43:13',NULL,'2023-03-27 08:43:13'),
(1,3,10,1,NULL,'2023-03-27 08:43:13',NULL,'2023-03-27 08:43:13'),
(1,5,33,1,NULL,'2023-03-27 08:43:13',NULL,'2023-03-27 08:43:13'),
(1,5,34,1,NULL,'2023-03-27 08:43:13',NULL,'2023-03-27 08:43:13'),
(1,5,35,1,NULL,'2023-03-27 08:43:13',NULL,'2023-03-27 08:43:13'),
(1,5,36,1,NULL,'2023-03-27 08:43:13',NULL,'2023-03-27 08:43:13'),
(1,5,37,1,NULL,'2023-03-27 08:43:13',NULL,'2023-03-27 08:43:13'),
(1,5,38,1,NULL,'2023-03-27 08:43:13',NULL,'2023-03-27 08:43:13'),
(1,7,11,1,NULL,'2023-03-27 08:43:13',NULL,'2023-03-27 08:43:13'),
(1,7,12,1,NULL,'2023-03-27 08:43:13',NULL,'2023-03-27 08:43:13'),
(1,7,13,1,NULL,'2023-03-27 08:43:13',NULL,'2023-03-27 08:43:13'),
(1,7,14,1,NULL,'2023-03-27 08:43:13',NULL,'2023-03-27 08:43:13'),
(1,7,15,1,NULL,'2023-03-27 08:43:13',NULL,'2023-03-27 08:43:13'),
(1,7,16,1,NULL,'2023-03-27 08:43:13',NULL,'2023-03-27 08:43:13'),
(1,7,27,1,NULL,'2023-03-27 08:43:13',NULL,'2023-03-27 08:43:13'),
(1,8,17,1,NULL,'2023-03-27 08:43:13',NULL,'2023-03-27 08:43:13'),
(1,8,18,1,NULL,'2023-03-27 08:43:13',NULL,'2023-03-27 08:43:13'),
(1,8,19,1,NULL,'2023-03-27 08:43:13',NULL,'2023-03-27 08:43:13'),
(1,8,20,1,NULL,'2023-03-27 08:43:13',NULL,'2023-03-27 08:43:13'),
(1,8,21,1,NULL,'2023-03-27 08:43:13',NULL,'2023-03-27 08:43:13'),
(1,9,22,1,NULL,'2023-03-27 08:43:13',NULL,'2023-03-27 08:43:13'),
(1,9,23,1,NULL,'2023-03-27 08:43:13',NULL,'2023-03-27 08:43:13'),
(1,9,24,1,NULL,'2023-03-27 08:43:13',NULL,'2023-03-27 08:43:13'),
(1,9,25,1,NULL,'2023-03-27 08:43:13',NULL,'2023-03-27 08:43:13'),
(1,9,26,1,NULL,'2023-03-27 08:43:13',NULL,'2023-03-27 08:43:13'),
(1,11,28,1,NULL,'2023-03-27 08:43:13',NULL,'2023-03-27 08:43:13'),
(1,11,29,1,NULL,'2023-03-27 08:43:13',NULL,'2023-03-27 08:43:13'),
(1,11,30,1,NULL,'2023-03-27 08:43:13',NULL,'2023-03-27 08:43:13'),
(1,11,31,1,NULL,'2023-03-27 08:43:13',NULL,'2023-03-27 08:43:13'),
(1,11,32,1,NULL,'2023-03-27 08:43:13',NULL,'2023-03-27 08:43:13');

/*Table structure for table `trroutes` */

DROP TABLE IF EXISTS `trroutes`;

CREATE TABLE `trroutes` (
  `intRoute_ID` int unsigned NOT NULL AUTO_INCREMENT,
  `intSubmenu_ID` int unsigned NOT NULL,
  `txtRouteTitle` varchar(128) NOT NULL,
  `txtRouteName` varchar(128) NOT NULL,
  `dtmCreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `dtmUpdated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`intRoute_ID`),
  KEY `FK_MRoute_intSubmenu_ID_to_msubmenus` (`intSubmenu_ID`),
  CONSTRAINT `FK_MRoute_intSubmenu_ID_to_msubmenus` FOREIGN KEY (`intSubmenu_ID`) REFERENCES `msubmenus` (`intSubmenu_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `trroutes` */

insert  into `trroutes`(`intRoute_ID`,`intSubmenu_ID`,`txtRouteTitle`,`txtRouteName`,`dtmCreated`,`dtmUpdated`) values 
(1,2,'read','manage.menu.index','2023-03-20 10:40:18','2023-03-20 10:40:51'),
(2,2,'create','manage.menu.store','2023-03-20 10:41:20','2023-03-20 10:41:36'),
(3,2,'edit','manage.menu.edit','2023-03-20 10:41:31','2023-03-20 10:41:38'),
(4,2,'update','manage.menu.update','2023-03-20 10:42:18','2023-03-20 10:42:18'),
(5,2,'delete','manage.menu.destroy','2023-03-20 10:42:26','2023-03-20 10:42:26'),
(6,3,'read','manage.submenu.index','2023-03-20 10:43:03','2023-03-20 10:43:03'),
(7,3,'create','manage.submenu.store','2023-03-20 10:43:12','2023-03-20 10:43:12'),
(8,3,'edit','manage.submenu.edit','2023-03-20 10:43:20','2023-03-20 10:43:20'),
(9,3,'update','manage.submenu.update','2023-03-20 10:43:28','2023-03-20 10:43:28'),
(10,3,'delete','manage.submenu.destroy','2023-03-20 10:43:42','2023-03-20 10:51:15'),
(11,7,'read','manage.level.index','2023-03-20 15:14:27','2023-03-20 15:14:27'),
(12,7,'create','manage.level.store','2023-03-20 15:14:27','2023-03-20 15:14:27'),
(13,7,'edit','manage.level.edit','2023-03-20 15:14:27','2023-03-20 15:14:27'),
(14,7,'update','manage.level.update','2023-03-20 15:14:27','2023-03-20 15:14:27'),
(15,7,'delete','manage.level.destroy','2023-03-20 15:14:27','2023-03-20 15:14:27'),
(16,7,'access','manage.level.access','2023-03-20 15:14:27','2023-03-20 15:14:27'),
(17,8,'read','manage.department.index','2023-03-20 15:19:05','2023-03-20 15:19:05'),
(18,8,'create','manage.department.store','2023-03-20 15:19:05','2023-03-20 15:19:05'),
(19,8,'edit','manage.department.edit','2023-03-20 15:19:05','2023-03-20 15:19:05'),
(20,8,'update','manage.department.update','2023-03-20 15:19:05','2023-03-20 15:19:05'),
(21,8,'delete','manage.department.destroy','2023-03-20 15:19:05','2023-03-20 15:19:05'),
(22,9,'read','manage.module.index','2023-03-23 11:21:38','2023-03-23 11:21:38'),
(23,9,'create','manage.module.store','2023-03-23 11:21:38','2023-03-23 11:21:38'),
(24,9,'edit','manage.module.edit','2023-03-23 11:21:38','2023-03-23 11:21:38'),
(25,9,'update','manage.module.update','2023-03-23 11:21:38','2023-03-23 11:21:38'),
(26,9,'delete','manage.module.destroy','2023-03-23 11:21:38','2023-03-23 11:21:38'),
(27,7,'change','manage.level.change','2023-03-23 15:45:26','2023-03-23 15:45:26'),
(28,11,'read','manage.dbaccount.index','2023-03-24 14:04:24','2023-03-24 14:04:24'),
(29,11,'create','manage.dbaccount.store','2023-03-24 14:04:24','2023-03-24 14:04:24'),
(30,11,'edit','manage.dbaccount.edit','2023-03-24 14:04:24','2023-03-24 14:04:24'),
(31,11,'update','manage.dbaccount.update','2023-03-24 14:04:24','2023-03-24 14:04:24'),
(32,11,'delete','manage.dbaccount.destroy','2023-03-24 14:04:24','2023-03-24 14:04:24'),
(33,5,'read','manage.user.index','2023-03-26 16:56:38','2023-03-26 16:56:38'),
(34,5,'create','manage.user.store','2023-03-26 16:56:38','2023-03-26 16:56:38'),
(35,5,'edit','manage.user.edit','2023-03-26 16:56:38','2023-03-26 16:56:38'),
(36,5,'update','manage.user.update','2023-03-26 16:56:38','2023-03-26 16:56:38'),
(37,5,'reset','manage.user.change-password','2023-03-26 16:56:38','2023-03-26 16:56:38'),
(38,5,'delete','manage.user.destroy','2023-03-26 16:56:38','2023-03-26 16:56:38');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

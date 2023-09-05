-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 03, 2023 at 09:32 AM
-- Server version: 8.0.30
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ftq`
--

-- --------------------------------------------------------

--
-- Table structure for table `mcustom_parameter`
--

CREATE TABLE `mcustom_parameter` (
  `intCustomParameter_ID` int UNSIGNED NOT NULL,
  `txtCustomValue` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `txtCreatedBy` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dtmCreatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `txtUpdatedBy` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dtmUpdatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `txtDeletedBy` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dtmDeletedAt` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mcustom_parameter`
--

INSERT INTO `mcustom_parameter` (`intCustomParameter_ID`, `txtCustomValue`, `txtCreatedBy`, `dtmCreatedAt`, `txtUpdatedBy`, `dtmUpdatedAt`, `txtDeletedBy`, `dtmDeletedAt`) VALUES
(2, 'As Standard', 'FARIZ FAUZI PRATAMA', '2023-08-02 08:13:12', 'FARIZ FAUZI PRATAMA', '2023-08-02 08:16:21', 'ALI DAVIT', '2023-08-02 08:16:21'),
(3, 'As Standard', 'FARIZ FAUZI PRATAMA', '2023-08-02 08:14:33', 'FARIZ FAUZI PRATAMA', '2023-08-02 08:14:33', NULL, NULL),
(4, 'As Out Standard', 'FARIZ FAUZI PRATAMA', '2023-08-02 08:15:04', 'ALI DAVIT', '2023-08-02 08:15:47', NULL, NULL),
(5, 'Positive', 'ALI DAVIT', '2023-08-03 01:42:42', 'ALI DAVIT', '2023-08-03 01:42:42', NULL, NULL),
(6, 'Negative', 'ALI DAVIT', '2023-08-03 01:42:48', 'ALI DAVIT', '2023-08-03 01:42:48', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mfatblend_verification`
--

CREATE TABLE `mfatblend_verification` (
  `intVerification_ID` bigint UNSIGNED NOT NULL,
  `txtOkp` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `txtOkpType` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `txtProduct` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `txtTotal` char(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tmPlannedStart` timestamp NOT NULL,
  `txtMoveOrder` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `intFormulaVersion` int NOT NULL,
  `intIsDraft` tinyint DEFAULT '1',
  `txtPic` text COLLATE utf8mb4_general_ci,
  `txtApproveLeader` varchar(156) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dtmApproval` timestamp NULL DEFAULT NULL,
  `txtCreatedBy` bigint UNSIGNED NOT NULL,
  `dtmCreatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `txtUpdatedBy` bigint UNSIGNED NOT NULL,
  `dtmUpdatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mfatblend_verification`
--

INSERT INTO `mfatblend_verification` (`intVerification_ID`, `txtOkp`, `txtOkpType`, `txtProduct`, `txtTotal`, `tmPlannedStart`, `txtMoveOrder`, `intFormulaVersion`, `intIsDraft`, `txtPic`, `txtApproveLeader`, `dtmApproval`, `txtCreatedBy`, `dtmCreatedAt`, `txtUpdatedBy`, `dtmUpdatedAt`) VALUES
(39, 'FB-4468', 'MIX', 'Vegetable Oil - Mixed MM BVOR', '17 MIX', '2023-07-02 17:00:00', '32484947', 1, 0, '[{\"shift\":\"1\",\"processmix\":\"1-17\",\"pic\":\"ALI DAVIT\"}]', NULL, NULL, 330, '2023-07-07 03:05:55', 330, '2023-08-03 09:29:44'),
(40, 'PD-4473C', 'BLD', 'CHIL KID PLATINUM BASE POWDER (R21.2) KMI', '4.62 MIX', '2023-07-13 17:00:00', '32635851', 1, 1, '[{\"shift\":\"1\",\"processmix\":null,\"pic\":\"HERIYANA\"}]', NULL, NULL, 153, '2023-08-01 07:47:31', 153, '2023-08-03 09:24:00');

-- --------------------------------------------------------

--
-- Table structure for table `mform`
--

CREATE TABLE `mform` (
  `intForm_ID` int UNSIGNED NOT NULL,
  `intSubmenu_ID` int UNSIGNED NOT NULL,
  `txtFormName` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `txtNoDoc` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `txtCreatedBy` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `dtmCreatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `txtUpdatedBy` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `dtmUpdatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `txtDeletedBy` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `dtmDeletedAt` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mlevels`
--

CREATE TABLE `mlevels` (
  `intLevel_ID` int UNSIGNED NOT NULL,
  `txtLevelName` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dtmCreatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `dtmUpdatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mlevels`
--

INSERT INTO `mlevels` (`intLevel_ID`, `txtLevelName`, `dtmCreatedAt`, `dtmUpdatedAt`) VALUES
(3, 'ADMIN', '2023-07-31 02:59:31', '2023-07-31 02:59:31'),
(4, 'LEADER', '2023-07-31 03:01:40', '2023-07-31 08:04:29'),
(6, 'ANALYST', '2023-07-31 03:02:00', '2023-07-31 03:03:50'),
(7, 'VIEWER', '2023-07-31 03:04:12', '2023-07-31 03:04:12'),
(8, 'PRODUKSI', '2023-08-03 08:55:33', '2023-08-03 08:55:33');

-- --------------------------------------------------------

--
-- Table structure for table `mmenu`
--

CREATE TABLE `mmenu` (
  `intMenu_ID` int UNSIGNED NOT NULL,
  `txtMenuTitle` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `txtMenuIcon` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `txtMenuRoute` varchar(64) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `txtMenuUrl` varchar(64) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `intQueue` int NOT NULL,
  `dtmCreatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `dtmUpdatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mmenu`
--

INSERT INTO `mmenu` (`intMenu_ID`, `txtMenuTitle`, `txtMenuIcon`, `txtMenuRoute`, `txtMenuUrl`, `intQueue`, `dtmCreatedAt`, `dtmUpdatedAt`) VALUES
(2, 'Dashboard', 'ion-ios-pulse bg-gradient-success', 'ftq.dashboard.index', 'dashboard', 1, '2023-08-01 07:21:56', '2023-08-01 07:40:00'),
(3, 'Verification', 'ion-ios-paper bg-gradient-blue', NULL, NULL, 2, '2023-08-02 01:51:33', '2023-08-02 01:51:33'),
(4, 'Setting', 'ion-ios-options bg-gradient-purple', NULL, NULL, 5, '2023-08-02 02:00:20', '2023-08-02 03:47:07'),
(5, 'Form Analysis', 'ion-ios-filing bg-info', NULL, NULL, 3, '2023-08-02 02:57:37', '2023-08-02 03:01:23'),
(6, 'Master Data', 'ion-ios-clipboard bg-gradient-orange', NULL, NULL, 4, '2023-08-02 03:46:10', '2023-08-02 03:48:19');

-- --------------------------------------------------------

--
-- Table structure for table `mokp_api`
--

CREATE TABLE `mokp_api` (
  `intOkp_ID` bigint UNSIGNED NOT NULL,
  `txtOkp` varchar(16) COLLATE utf8mb4_general_ci NOT NULL,
  `txtOkpType` varchar(16) COLLATE utf8mb4_general_ci NOT NULL,
  `txtProduct` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `txtTotal` char(8) COLLATE utf8mb4_general_ci NOT NULL,
  `tmPlannedStart` timestamp NOT NULL,
  `txtMoveOrder` varchar(16) COLLATE utf8mb4_general_ci NOT NULL,
  `intFormulaVersion` int NOT NULL,
  `txtIngredient` varchar(32) COLLATE utf8mb4_general_ci NOT NULL,
  `txtDescription` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `txtCategory` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `intQty` int NOT NULL,
  `txtUom` varchar(8) COLLATE utf8mb4_general_ci NOT NULL,
  `tmCreatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mokp_api`
--

INSERT INTO `mokp_api` (`intOkp_ID`, `txtOkp`, `txtOkpType`, `txtProduct`, `txtTotal`, `tmPlannedStart`, `txtMoveOrder`, `intFormulaVersion`, `txtIngredient`, `txtDescription`, `txtCategory`, `intQty`, `txtUom`, `tmCreatedAt`) VALUES
(1, 'PD-4473C', 'BLD', 'CHIL KID PLATINUM BASE POWDER (R21.2) KMI', '4.62', '2023-07-14 08:00:00', '32635851', 1, 'KSD2-IACKP002', 'CHIL KID PLATINUM BASE POWDER (R21.2) KMI', 'WIP-SD', 1, 'T65', '2023-07-18 09:31:27'),
(2, 'DP-1891', 'BLD', 'Base Powder - Gum 002', '40', '2023-07-14 08:00:00', '32635841', 9, 'KRM2-RNBPW002', 'Base Powder - Gum 002', 'RM-Major', 150, 'kg', '2023-07-18 09:31:27'),
(3, 'DP-1891A', 'BLD', 'CHIL KID REGULER VANILLA DUMPED POWDER (R21) KMI', '40', '2023-07-14 08:00:00', '32635840', 1, 'KDP2-MCFVC002', 'CHIL KID REGULER VANILLA DUMPED POWDER (R21) KMI', 'WIP-DP', 1, 'BLD', '2023-07-18 09:31:27'),
(4, 'PD-4477A', 'BLD', 'CHIL KID REGULER BASE POWDER (R21) KMI', '25', '2023-07-14 08:00:00', '32635848', 1, 'KSD2-IACKR023', 'CHIL KID REGULER BASE POWDER (R21) KMI', 'WIP-SD', 1, 'T65', '2023-07-18 09:31:27'),
(5, 'BP-1408AA', 'BLD', 'Base Powder - Gum 222', '26', '2023-07-14 16:00:00', '32636822', 4, 'KRM2-RNBPW007', 'Base Powder - Gum 222', 'RM-Major', 175, 'kg', '2023-07-18 09:31:27'),
(6, 'FB-4479', 'MIX', 'Vegetable Oil - MM 61 (NBD TYPE)', '15', '2023-07-15 00:00:00', '32635826', 1, 'KRM2-RCVOI031', 'Vegetable Oil - MM 61 (NBD TYPE)', 'RM-Major', 668, 'kg', '2023-07-18 09:31:27'),
(7, 'PDE-4477D', 'BLD', 'CHIL KID REGULER BASE POWDER (R21) KMI', '16', '2023-07-15 08:00:00', '32636878', 1, 'KSD2-IACKR023', 'CHIL KID REGULER BASE POWDER (R21) KMI', 'WIP-SD', 1, 'T65', '2023-07-18 09:31:27'),
(8, 'BP-1409AA', 'BLD', 'Base Powder - Gum 222', '29', '2023-07-15 08:00:00', '32636823', 5, 'KRM2-RNBPW007', 'Base Powder - Gum 222', 'RM-Major', 175, 'kg', '2023-07-18 09:31:27'),
(9, 'MX-4479', 'MIX', 'FAT BLEND for BMT REGULER BASE (R21) KMI', '15', '2023-07-16 00:00:00', '32635827', 6, 'KFB2-IABRE007', 'FAT BLEND for BMT REGULER BASE (R21) KMI', 'WIP-FB', 1, 'FB', '2023-07-18 09:31:27'),
(10, 'FB-4480', 'MIX', 'Vegetable Oil - Mixed MM BVOR', '15', '2023-07-16 00:00:00', '32635844', 1, 'KRM2-RCVOI017', 'Vegetable Oil - Mixed MM BVOR', 'RM-Major', 512, 'kg', '2023-07-18 09:31:27'),
(11, 'PD-4477AA', 'BLD', 'CHIL KID REGULER HONEY BLENDED POWDER (KMI) (R21)', '25', '2023-07-16 00:00:00', '32636852', 2, 'KBL2-FACKR023-H', 'CHIL KID REGULER HONEY BLENDED POWDER (KMI) (R21)', 'WIP-BL', 1, 'BLD', '2023-07-18 09:31:27'),
(12, 'BP-1410AA', 'BLD', 'Base Powder - Gum 222', '50', '2023-07-16 00:00:00', '32636869', 3, 'KRM2-RNBPW007', 'Base Powder - Gum 222', 'RM-Major', 175, 'kg', '2023-07-18 09:31:27'),
(13, 'PDE-4477DA', 'BLD', 'CHIL KID REGULER VANILLA BLENDED POWDER (KMI) (R21)', '16', '2023-07-16 08:00:00', '32636894', 1, 'KBL2-FACKR023-V', 'CHIL KID REGULER VANILLA BLENDED POWDER (KMI) (R21)', 'WIP-BL', 1, 'BLD', '2023-07-18 09:31:27'),
(14, 'PDE-4478A-1', 'BLD', 'CHIL KID REGULER BASE POWDER (R21) KMI', '50', '2023-07-16 08:00:00', '32636880', 1, 'KSD2-IACKR023', 'CHIL KID REGULER BASE POWDER (R21) KMI', 'WIP-SD', 1, 'T65', '2023-07-18 09:31:27'),
(15, 'MX-4480', 'MIX', 'FAT BLEND for CKD REGULER BASE (R21) KMI', '15', '2023-07-17 00:00:00', '32635845', 5, 'KFB2-IACKR023', 'FAT BLEND for CKD REGULER BASE (R21) KMI', 'WIP-FB', 1, 'FB', '2023-07-18 09:31:27'),
(16, 'DP-1891AA', 'BLD', 'CHIL KID REGULER VANILLA BLENDED-DUMPED POWDER (R21) KMI', '40', '2023-07-17 00:00:00', '32636853', 1, 'KBL2-MCFVC002', 'CHIL KID REGULER VANILLA BLENDED-DUMPED POWDER (R21) KMI', 'WIP-BL', 1, 'BLD', '2023-07-18 09:31:27'),
(17, 'BP-1411AA', 'BLD', 'Base Powder - Gum 002', '36', '2023-07-17 00:00:00', '32715820', 2, 'KRM2-RNBPW002', 'Base Powder - Gum 002', 'RM-Major', 150, 'kg', '2023-07-18 09:31:27'),
(18, 'PD-4473CA', 'BLD', 'CHIL KID PLATINUM VANILLA BLENDED POWDER (KMI) (R21.2)', '4.62', '2023-07-17 00:00:00', '32636873', 3, 'KBL2-FACKP002-V', 'CHIL KID PLATINUM VANILLA BLENDED POWDER (KMI) (R21.2)', 'WIP-BL', 1, 'BLD', '2023-07-18 09:31:27'),
(19, 'PD-4475A-1', 'BLD', 'MORIGRO BASE POWDER KMI', '20', '2023-07-17 00:00:00', '32636862', 1, 'KSD2-IAMOP001', 'MORIGRO BASE POWDER KMI', 'WIP-SD', 1, 'T50', '2023-07-18 09:31:27'),
(20, 'PDE-4478AA-1', 'BLD', 'CHIL KID REGULER VANILLA BLENDED POWDER (KMI) (R21)', '50', '2023-07-17 00:00:00', '32636896', 1, 'KBL2-FACKR023-V', 'CHIL KID REGULER VANILLA BLENDED POWDER (KMI) (R21)', 'WIP-BL', 1, 'BLD', '2023-07-18 09:31:27'),
(21, 'BP-1411AA', 'BLD', 'Base Powder - Gum 002', '36', '2023-07-17 00:00:00', '32636870', 2, 'KRM2-RNBPW002', 'Base Powder - Gum 002', 'RM-Major', 150, 'kg', '2023-07-18 09:31:27'),
(22, 'FB-4481', 'MIX', 'Vegetable Oil - Mixed MM BVOR', '16', '2023-07-17 00:00:00', '32636885', 1, 'KRM2-RCVOI017', 'Vegetable Oil - Mixed MM BVOR', 'RM-Major', 484, 'kg', '2023-07-18 09:31:27'),
(23, 'PD-4473BB', 'BLD', 'CHIL KID PLATINUM HONEY BLENDED POWDER (KMI) (R21.2)', '6', '2023-07-17 00:00:00', '32636857', 2, 'KBL2-FACKP002-H', 'CHIL KID PLATINUM HONEY BLENDED POWDER (KMI) (R21.2)', 'WIP-BL', 1, 'BLD', '2023-07-18 09:31:27'),
(24, 'PD-4477B', 'BLD', 'CHIL KID REGULER BASE POWDER (R21) KMI', '28', '2023-07-17 08:00:00', '32669820', 1, 'KSD2-IACKR023', 'CHIL KID REGULER BASE POWDER (R21) KMI', 'WIP-SD', 1, 'T65', '2023-07-18 09:31:27'),
(25, 'PDE-4480A-1', 'BLD', 'CHIL KID REGULER BASE POWDER (R21) KMI', '20', '2023-07-18 00:00:00', '32673821', 1, 'KSD2-IACKR023', 'CHIL KID REGULER BASE POWDER (R21) KMI', 'WIP-SD', 1, 'T65', '2023-07-18 09:31:27'),
(26, 'PDE-4478A-2', 'BLD', 'CHIL KID REGULER BASE POWDER (R21) KMI', '24.38', '2023-07-18 00:00:00', '32667821', 1, 'KSD2-IACKR023', 'CHIL KID REGULER BASE POWDER (R21) KMI', 'WIP-SD', 1, 'T65', '2023-07-18 09:31:27'),
(27, 'PDE-4478AA-2', 'BLD', 'CHIL KID REGULER VANILLA BLENDED POWDER (KMI) (R21)', '24.38', '2023-07-18 00:00:00', '32677820', 1, 'KBL2-FACKR023-V', 'CHIL KID REGULER VANILLA BLENDED POWDER (KMI) (R21)', 'WIP-BL', 1, 'BLD', '2023-07-18 09:31:27'),
(28, 'PD-4477BA', 'BLD', 'CHIL KID REGULER VANILLA BLENDED POWDER (KMI) (R21)', '28', '2023-07-18 00:00:00', '32676820', 2, 'KBL2-FACKR023-V', 'CHIL KID REGULER VANILLA BLENDED POWDER (KMI) (R21)', 'WIP-BL', 1, 'BLD', '2023-07-18 09:31:27'),
(29, 'MX-4481', 'MIX', 'FAT BLEND for CKD PLATINUM BASE (R21.2) KMI', '16', '2023-07-18 00:00:00', '32636886', 2, 'KFB2-IACKP002', 'FAT BLEND for CKD PLATINUM BASE (R21.2) KMI', 'WIP-FB', 1, 'FB', '2023-07-18 09:31:27'),
(30, 'FB-4482', 'MIX', 'Vegetable Oil - Mixed MM BVOR', '7', '2023-07-18 00:00:00', '32686820', 1, 'KRM2-RCVOI017', 'Vegetable Oil - Mixed MM BVOR', 'RM-Major', 272, 'kg', '2023-07-18 09:31:27'),
(31, 'PD-4476A-R', 'BLD', 'MORIGRO BASE POWDER KMI', '17', '2023-07-18 08:00:00', '32710820', 1, 'KSD2-IAMOP001', 'MORIGRO BASE POWDER KMI', 'WIP-SD', 1, 'T50', '2023-07-18 09:31:27'),
(32, 'PD-4476B', 'BLD', 'MORIGRO BASE POWDER KMI', '14', '2023-07-18 08:00:00', '32710821', 1, 'KSD2-IAMOP001', 'MORIGRO BASE POWDER KMI', 'WIP-SD', 1, 'T50', '2023-07-18 09:31:27'),
(33, 'PD-4476A', 'BLD', 'MORIGRO BASE POWDER KMI', '10', '2023-07-18 08:00:00', '32702823', 1, 'KSD2-IAMOP001', 'MORIGRO BASE POWDER KMI', 'WIP-SD', 1, 'T50', '2023-07-18 09:31:27'),
(34, 'DP-1892', 'BLD', 'Base Powder - Gum 222', '44', '2023-07-18 08:00:00', '32702829', 5, 'KRM2-RNBPW007', 'Base Powder - Gum 222', 'RM-Major', 275, 'kg', '2023-07-18 09:31:27'),
(35, 'DP-1892A', 'BLD', 'CHIL SCHOOL REGULER VANILLA DUMPED POWDER (R21) KMI', '44', '2023-07-18 08:00:00', '32702828', 1, 'KDP2-MSGVC003', 'CHIL SCHOOL REGULER VANILLA DUMPED POWDER (R21) KMI', 'WIP-DP', 1, 'BLD', '2023-07-18 09:31:27'),
(36, 'PD-4475A-2', 'BLD', 'MORIGRO BASE POWDER KMI', '21', '2023-07-18 08:00:00', '32702821', 1, 'KSD2-IAMOP001', 'MORIGRO BASE POWDER KMI', 'WIP-SD', 1, 'T50', '2023-07-18 09:31:27'),
(37, 'PD-4475B-1', 'BLD', 'MORIGRO BASE POWDER KMI', '20', '2023-07-18 08:00:00', '32710823', 1, 'KSD2-IAMOP001', 'MORIGRO BASE POWDER KMI', 'WIP-SD', 1, 'T50', '2023-07-18 09:31:27'),
(38, 'PDE-4480AA-1', 'BLD', 'CHIL KID REGULER VANILLA BLENDED POWDER (KMI) (R21)', '20', '2023-07-18 16:00:00', '32676822', 1, 'KBL2-FACKR023-V', 'CHIL KID REGULER VANILLA BLENDED POWDER (KMI) (R21)', 'WIP-BL', 1, 'BLD', '2023-07-18 09:31:27'),
(39, 'PDE-4480A-2', 'BLD', 'CHIL KID REGULER BASE POWDER (R21) KMI', '40', '2023-07-19 00:00:00', '32702825', 1, 'KSD2-IACKR023', 'CHIL KID REGULER BASE POWDER (R21) KMI', 'WIP-SD', 1, 'T65', '2023-07-18 09:31:27'),
(40, 'PD-4475AA-1', 'BLD', 'MORIGRO VANILLA BLENDED POWDER (KMI)', '20', '2023-07-19 00:00:00', '32713829', 1, 'KBL2-IAMOP001-V', 'MORIGRO VANILLA BLENDED POWDER (KMI)', 'WIP-BL', 1, 'BLD', '2023-07-18 09:31:27'),
(41, 'MX-4482', 'MIX', 'FAT BLEND for CML PLATINUM BASE (R21) KMI', '7', '2023-07-19 00:00:00', '32688820', 2, 'KFB2-IACMP006', 'FAT BLEND for CML PLATINUM BASE (R21) KMI', 'WIP-FB', 1, 'FB', '2023-07-18 09:31:27');

-- --------------------------------------------------------

--
-- Table structure for table `mparameter`
--

CREATE TABLE `mparameter` (
  `intParameter_ID` int UNSIGNED NOT NULL,
  `txtParameter` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `txtStandar` varchar(32) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `txtInputType` varchar(16) COLLATE utf8mb4_general_ci NOT NULL,
  `intMin` int DEFAULT '0',
  `intMax` int DEFAULT '0',
  `txtCreatedBy` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dtmCreatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `txtUpdatedBy` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dtmUpdatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `txtDeletedBy` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dtmDeletedAt` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mparameter`
--

INSERT INTO `mparameter` (`intParameter_ID`, `txtParameter`, `txtStandar`, `txtInputType`, `intMin`, `intMax`, `txtCreatedBy`, `dtmCreatedAt`, `txtUpdatedBy`, `dtmUpdatedAt`, `txtDeletedBy`, `dtmDeletedAt`) VALUES
(1, 'PEROXIDE-VALUE', '1 - 7', 'input', 1, 7, 'ALI DAVIT', '2023-08-03 01:39:23', 'ALI DAVIT', '2023-08-03 01:39:23', NULL, NULL),
(2, 'KREIST TEST', 'Negative', 'select', NULL, NULL, 'ALI DAVIT', '2023-08-03 01:49:57', 'ALI DAVIT', '2023-08-03 02:51:26', NULL, NULL),
(3, 'APPEARANCE (LIQUID)', 'As Standard', 'select', NULL, NULL, 'ALI DAVIT', '2023-08-03 01:52:06', 'ALI DAVIT', '2023-08-03 01:52:06', NULL, NULL),
(4, 'TASTE (LIQUID)', 'As Standard', 'select', NULL, NULL, 'ALI DAVIT', '2023-08-03 01:53:06', 'ALI DAVIT', '2023-08-03 01:53:06', NULL, NULL),
(5, 'COLOUR (LIQUID)', 'As Standard', 'select', NULL, NULL, 'ALI DAVIT', '2023-08-03 01:53:24', 'ALI DAVIT', '2023-08-03 01:53:24', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `msubmenu`
--

CREATE TABLE `msubmenu` (
  `intSubmenu_ID` int UNSIGNED NOT NULL,
  `intMenu_ID` int UNSIGNED NOT NULL,
  `txtSubmenuTitle` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `txtSubmenuIcon` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `txtSubmenuUrl` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `txtSubmenuRoute` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `dtmCreatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `dtmUpdatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `msubmenu`
--

INSERT INTO `msubmenu` (`intSubmenu_ID`, `intMenu_ID`, `txtSubmenuTitle`, `txtSubmenuIcon`, `txtSubmenuUrl`, `txtSubmenuRoute`, `dtmCreatedAt`, `dtmUpdatedAt`) VALUES
(1, 3, 'Fat Blend', 'fa-regular fa-rectangle-list', 'ftq/verifikasi/fat-blend', 'ftq.verifikasi.fat-blend.index', '2023-08-02 02:42:30', '2023-08-02 02:50:38'),
(2, 3, 'Eductor', 'fa-regular fa-rectangle-list', 'ftq/verifikasi/eductor', 'ftq.verifikasi.eductor.index', '2023-08-02 02:52:01', '2023-08-02 02:52:01'),
(3, 4, 'Level', 'fa-solid fa-user-tag', 'ftq/admin/level', 'ftq.admin.level.index', '2023-08-02 02:53:10', '2023-08-02 02:53:10'),
(4, 4, 'Access Level', 'fa-solid fa-user-lock', 'ftq/admin/access', 'ftq.admin.access.index', '2023-08-02 02:54:19', '2023-08-02 02:54:19'),
(5, 4, 'Menu', 'fa-solid fa-bars', 'ftq/admin/menu', 'ftq.admin.menu.index', '2023-08-02 02:55:12', '2023-08-02 02:55:12'),
(6, 4, 'Sub Menu', 'fa-solid fa-bars', 'ftq/admin/submenu', 'ftq.admin.submenu.index', '2023-08-02 02:55:37', '2023-08-02 02:55:37'),
(7, 3, 'Mineral', 'fa-regular fa-rectangle-list', 'ftq/verifikasi/mineral', 'ftq.verifikasi.mineral.index', '2023-08-02 03:03:21', '2023-08-02 03:03:21'),
(8, 6, 'Form', 'fa-solid fa-clipboard', 'ftq/admin/master-form', 'ftq.admin.form.index', '2023-08-02 03:49:20', '2023-08-02 03:50:33'),
(9, 6, 'Parameter', 'fa-solid fa-clipboard-list', 'ftq/admin/parameter', 'ftq.admin.parameter.index', '2023-08-02 03:51:50', '2023-08-02 03:51:50'),
(10, 5, 'Fat Blend', 'fa-solid fa-clipboard-check', 'ftq/analysis/fat-blend', 'ftq.fat-blend.index', '2023-08-02 03:53:32', '2023-08-02 03:53:32'),
(11, 5, 'Mixing', 'fa-solid fa-clipboard-check', 'ftq/analysis/mixing', 'ftq.mixing.index', '2023-08-02 03:56:36', '2023-08-02 03:56:36'),
(12, 6, 'Parameter Value', 'fa-solid fa-list-ol', 'ftq/admin/custom-parameter', 'ftq.admin.custom-parameter.index', '2023-08-02 07:47:56', '2023-08-02 07:47:56');

-- --------------------------------------------------------

--
-- Table structure for table `trfatblend_verification`
--

CREATE TABLE `trfatblend_verification` (
  `intVerification_ID` bigint UNSIGNED NOT NULL,
  `txtIngredient` varchar(32) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `txtDescription` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `intQty` int DEFAULT NULL,
  `txtUom` char(8) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `txtTotalQty` char(8) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `intIsCheck` tinyint DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trfatblend_verification`
--

INSERT INTO `trfatblend_verification` (`intVerification_ID`, `txtIngredient`, `txtDescription`, `intQty`, `txtUom`, `txtTotalQty`, `intIsCheck`) VALUES
(40, 'KSD2-IACKP002', 'CHIL KID PLATINUM BASE POWDER (R21.2) KMI', 1, 'T65', '4.62', 1),
(39, 'KRM2-RCVOI017', 'Vegetable Oil - Mixed MM BVOR', 620, 'kg', '17', 1),
(39, 'KRM2-RFVMP007', 'Vitamin MM-72 - Vitamin Mineral Premix', 1, 'kg', '17', 1),
(39, 'KRM2-RCAMF001', 'Anhydrous Milk Fat', 4, 'kg', '17', 1),
(39, 'KRM2-RGEMU002', 'Soy Lecithine', 9, 'kg', '17', 1);

-- --------------------------------------------------------

--
-- Table structure for table `truser_level`
--

CREATE TABLE `truser_level` (
  `intLevel_ID` int UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `dtmCreatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `dtmUpdatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `truser_level`
--

INSERT INTO `truser_level` (`intLevel_ID`, `user_id`, `dtmCreatedAt`, `dtmUpdatedAt`) VALUES
(3, 210, '2023-07-31 08:02:48', '2023-07-31 08:02:48'),
(3, 330, '2023-07-31 08:02:48', '2023-07-31 08:02:48'),
(4, 15, '2023-07-31 08:04:55', '2023-07-31 08:04:55'),
(4, 54, '2023-07-31 08:04:55', '2023-07-31 08:04:55'),
(4, 121, '2023-07-31 08:04:55', '2023-07-31 08:04:55'),
(4, 173, '2023-07-31 08:04:55', '2023-07-31 08:04:55'),
(6, 153, '2023-07-31 08:05:29', '2023-07-31 08:05:29'),
(6, 209, '2023-07-31 08:05:29', '2023-07-31 08:05:29'),
(6, 266, '2023-07-31 08:05:29', '2023-07-31 08:05:29'),
(6, 327, '2023-07-31 08:05:29', '2023-07-31 08:05:29'),
(3, 44, '2023-07-31 08:07:57', '2023-07-31 08:07:57'),
(3, 210, '2023-07-31 08:07:57', '2023-07-31 08:07:57'),
(3, 235, '2023-07-31 08:07:57', '2023-07-31 08:07:57'),
(3, 330, '2023-07-31 08:07:57', '2023-07-31 08:07:57');

-- --------------------------------------------------------

--
-- Table structure for table `tr_form_parameter`
--

CREATE TABLE `tr_form_parameter` (
  `intForm_ID` int UNSIGNED NOT NULL,
  `intParameter_ID` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tr_parameter`
--

CREATE TABLE `tr_parameter` (
  `intParameter_ID` int UNSIGNED NOT NULL,
  `intCustomParameter_ID` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tr_parameter`
--

INSERT INTO `tr_parameter` (`intParameter_ID`, `intCustomParameter_ID`) VALUES
(2, 5),
(2, 6),
(3, 3),
(3, 4),
(4, 3),
(4, 4),
(5, 3),
(5, 4),
(2, 5),
(2, 6),
(2, 5),
(2, 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mcustom_parameter`
--
ALTER TABLE `mcustom_parameter`
  ADD PRIMARY KEY (`intCustomParameter_ID`),
  ADD KEY `FK_mcustom_parameter_intParameter_ID_to_mparameter` (`intCustomParameter_ID`);

--
-- Indexes for table `mfatblend_verification`
--
ALTER TABLE `mfatblend_verification`
  ADD PRIMARY KEY (`intVerification_ID`),
  ADD KEY `FK_fatblend_verif_created_by` (`txtCreatedBy`),
  ADD KEY `FK_fatblend_verif_updated_by` (`txtUpdatedBy`);

--
-- Indexes for table `mform`
--
ALTER TABLE `mform`
  ADD PRIMARY KEY (`intForm_ID`);

--
-- Indexes for table `mlevels`
--
ALTER TABLE `mlevels`
  ADD PRIMARY KEY (`intLevel_ID`);

--
-- Indexes for table `mmenu`
--
ALTER TABLE `mmenu`
  ADD PRIMARY KEY (`intMenu_ID`);

--
-- Indexes for table `mokp_api`
--
ALTER TABLE `mokp_api`
  ADD PRIMARY KEY (`intOkp_ID`);

--
-- Indexes for table `mparameter`
--
ALTER TABLE `mparameter`
  ADD PRIMARY KEY (`intParameter_ID`);

--
-- Indexes for table `msubmenu`
--
ALTER TABLE `msubmenu`
  ADD PRIMARY KEY (`intSubmenu_ID`),
  ADD KEY `FK_msubmenu_intMenu_id_to_mmenu` (`intMenu_ID`);

--
-- Indexes for table `trfatblend_verification`
--
ALTER TABLE `trfatblend_verification`
  ADD KEY `FK_trfatblend_ID_to_mfatblend` (`intVerification_ID`);

--
-- Indexes for table `truser_level`
--
ALTER TABLE `truser_level`
  ADD KEY `truser_level_intLevel_ID_Foreign` (`intLevel_ID`),
  ADD KEY `truser_level_user_id_Foreign` (`user_id`);

--
-- Indexes for table `tr_form_parameter`
--
ALTER TABLE `tr_form_parameter`
  ADD KEY `FK_tr_form_parameter_intForm_ID_to_mForm` (`intForm_ID`),
  ADD KEY `FK_tr_Form_parameter_intParameter_ID_to_mparameter` (`intParameter_ID`);

--
-- Indexes for table `tr_parameter`
--
ALTER TABLE `tr_parameter`
  ADD KEY `FK_tr_parameter_intParameter_ID_to_mparameter` (`intParameter_ID`),
  ADD KEY `FK_tr_parameter_intParameter_ID_to_mcustomparameter` (`intCustomParameter_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mcustom_parameter`
--
ALTER TABLE `mcustom_parameter`
  MODIFY `intCustomParameter_ID` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `mfatblend_verification`
--
ALTER TABLE `mfatblend_verification`
  MODIFY `intVerification_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `mform`
--
ALTER TABLE `mform`
  MODIFY `intForm_ID` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mlevels`
--
ALTER TABLE `mlevels`
  MODIFY `intLevel_ID` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `mmenu`
--
ALTER TABLE `mmenu`
  MODIFY `intMenu_ID` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `mokp_api`
--
ALTER TABLE `mokp_api`
  MODIFY `intOkp_ID` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `mparameter`
--
ALTER TABLE `mparameter`
  MODIFY `intParameter_ID` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `msubmenu`
--
ALTER TABLE `msubmenu`
  MODIFY `intSubmenu_ID` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `mfatblend_verification`
--
ALTER TABLE `mfatblend_verification`
  ADD CONSTRAINT `FK_fatblend_verif_created_by` FOREIGN KEY (`txtCreatedBy`) REFERENCES `db_standardization`.`musers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_fatblend_verif_updated_by` FOREIGN KEY (`txtUpdatedBy`) REFERENCES `db_standardization`.`musers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `msubmenu`
--
ALTER TABLE `msubmenu`
  ADD CONSTRAINT `FK_msubmenu_intMenu_id_to_mmenu` FOREIGN KEY (`intMenu_ID`) REFERENCES `mmenu` (`intMenu_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `trfatblend_verification`
--
ALTER TABLE `trfatblend_verification`
  ADD CONSTRAINT `FK_trfatblend_ID_to_mfatblend` FOREIGN KEY (`intVerification_ID`) REFERENCES `mfatblend_verification` (`intVerification_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `truser_level`
--
ALTER TABLE `truser_level`
  ADD CONSTRAINT `truser_level_intLevel_ID_Foreign` FOREIGN KEY (`intLevel_ID`) REFERENCES `mlevels` (`intLevel_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `truser_level_user_id_Foreign` FOREIGN KEY (`user_id`) REFERENCES `db_standardization`.`musers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tr_form_parameter`
--
ALTER TABLE `tr_form_parameter`
  ADD CONSTRAINT `FK_tr_form_parameter_intForm_ID_to_mForm` FOREIGN KEY (`intForm_ID`) REFERENCES `mform` (`intForm_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tr_Form_parameter_intParameter_ID_to_mparameter` FOREIGN KEY (`intParameter_ID`) REFERENCES `mparameter` (`intParameter_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tr_parameter`
--
ALTER TABLE `tr_parameter`
  ADD CONSTRAINT `FK_tr_parameter_intParameter_ID_to_mcustomparameter` FOREIGN KEY (`intCustomParameter_ID`) REFERENCES `mcustom_parameter` (`intCustomParameter_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tr_parameter_intParameter_ID_to_mparameter` FOREIGN KEY (`intParameter_ID`) REFERENCES `mparameter` (`intParameter_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

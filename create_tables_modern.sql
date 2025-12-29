-- PHP Timeclock Modernized Schema
-- Optimized for MySQL 5.7 / 8.0
-- Engine: InnoDB, Charset: utf8mb4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- Table structure for table `audit`
--
CREATE TABLE `audit` (
  `audit_id` int(11) NOT NULL AUTO_INCREMENT,
  `modified_by_ip` varchar(45) NOT NULL DEFAULT '',
  `modified_by_user` varchar(50) NOT NULL DEFAULT '',
  `modified_when` bigint(14) NOT NULL,
  `modified_from` bigint(14) NOT NULL,
  `modified_to` bigint(14) NOT NULL,
  `modified_why` varchar(255) NOT NULL DEFAULT '',
  `user_modified` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`audit_id`),
  KEY `modified_when` (`modified_when`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `dbversion`
--
CREATE TABLE `dbversion` (
  `dbversion` decimal(5,1) NOT NULL DEFAULT '0.0',
  PRIMARY KEY (`dbversion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `dbversion` VALUES ('1.5');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--
CREATE TABLE `employees` (
  `empfullname` varchar(50) NOT NULL DEFAULT '',
  `tstamp` bigint(14) DEFAULT NULL,
  `employee_passwd` varchar(255) NOT NULL DEFAULT '', -- Expanded for Bcrypt
  `displayname` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(75) NOT NULL DEFAULT '',
  `groups` varchar(50) NOT NULL DEFAULT '',
  `office` varchar(50) NOT NULL DEFAULT '',
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `reports` tinyint(1) NOT NULL DEFAULT '0',
  `time_admin` tinyint(1) NOT NULL DEFAULT '0',
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`empfullname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Default Admin (Password: 'admin123' - CHANGE THIS AFTER FIRST LOGIN!)
INSERT INTO `employees` VALUES ('admin', NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin@example.com', 'General', 'Main Office', 1, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `groups` 
--
CREATE TABLE `groups` (
  `groupid` int(10) NOT NULL AUTO_INCREMENT,
  `groupname` varchar(50) NOT NULL DEFAULT '',
  `officeid` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`groupid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `info`
--
CREATE TABLE `info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(50) NOT NULL DEFAULT '',
  `inout` varchar(50) NOT NULL DEFAULT '',
  `timestamp` bigint(14) DEFAULT NULL,
  `notes` varchar(250) DEFAULT NULL,
  `ipaddress` varchar(45) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `fullname` (`fullname`),
  KEY `timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `metars`
--
CREATE TABLE `metars` (
  `station` varchar(4) NOT NULL DEFAULT '',
  `metar` varchar(255) NOT NULL DEFAULT '',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`station`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `offices`
--
CREATE TABLE `offices` (
  `officeid` int(10) NOT NULL AUTO_INCREMENT,
  `officename` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`officeid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Default Office
INSERT INTO `offices` VALUES (1, 'Main Office');

-- Default Group (linked to Main Office)
INSERT INTO `groups` VALUES (1, 'General', 1);

-- --------------------------------------------------------

--
-- Table structure for table `punchlist`
--
CREATE TABLE `punchlist` (
  `punchitems` varchar(50) NOT NULL DEFAULT '',
  `color` varchar(7) NOT NULL DEFAULT '',
  `in_or_out` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`punchitems`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `punchlist` VALUES ('in', '#009900', 1);
INSERT INTO `punchlist` VALUES ('out', '#FF0000', 0);
INSERT INTO `punchlist` VALUES ('break', '#FF9900', 0);
INSERT INTO `punchlist` VALUES ('lunch', '#0000FF', 0);

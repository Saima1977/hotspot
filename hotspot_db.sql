-- --------------------------------------------------------
-- Host:                         172.20.184.72
-- Server version:               5.5.53 - MySQL Community Server (GPL) by Remi
-- Server OS:                    Linux
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table hotspot.hotspot_archive
CREATE TABLE IF NOT EXISTS `hotspot_archive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hotel_code` varchar(50) NOT NULL DEFAULT '0',
  `remote_addr` varchar(125) NOT NULL DEFAULT '',
  `ip_addr` varchar(125) NOT NULL DEFAULT '',
  `mac` varchar(125) NOT NULL DEFAULT '',
  `user_name` varchar(125) NOT NULL DEFAULT '',
  `room_no` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `rate_plan` varchar(50) NOT NULL,
  `bytes_in` bigint(20) NOT NULL DEFAULT '0',
  `bytes_out` bigint(20) NOT NULL DEFAULT '0',
  `arrival` datetime NOT NULL,
  `departure` datetime NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'D',
  `active` varchar(10) NOT NULL DEFAULT '1',
  `log_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index 2` (`mac`,`room_no`)
) ENGINE=InnoDB AUTO_INCREMENT=118117 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Data exporting was unselected.
-- Dumping structure for table hotspot.hotspot_device
CREATE TABLE IF NOT EXISTS `hotspot_device` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hotel_code` varchar(50) NOT NULL DEFAULT '0',
  `room_no` varchar(50) NOT NULL DEFAULT '0',
  `mac` varchar(50) NOT NULL DEFAULT '0',
  `description` varchar(100) NOT NULL DEFAULT '0',
  `arrival` datetime NOT NULL,
  `departure` datetime NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `DUPLICATE INFO` (`hotel_code`,`room_no`,`mac`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table hotspot.hotspot_hotel_noauth
CREATE TABLE IF NOT EXISTS `hotspot_hotel_noauth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hotel_code` varchar(50) NOT NULL DEFAULT '0',
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index 2` (`hotel_code`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table hotspot.hotspot_hotel_range
CREATE TABLE IF NOT EXISTS `hotspot_hotel_range` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hotel_id` varchar(50) NOT NULL DEFAULT '0',
  `description` varchar(100) NOT NULL DEFAULT '0',
  `lower_range` varchar(100) NOT NULL DEFAULT '0',
  `upper_range` varchar(100) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table hotspot.hotspot_log
CREATE TABLE IF NOT EXISTS `hotspot_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hotel_code` varchar(50) NOT NULL DEFAULT '0',
  `remote_addr` varchar(125) NOT NULL DEFAULT '',
  `ip_addr` varchar(125) NOT NULL DEFAULT '',
  `mac` varchar(125) NOT NULL DEFAULT '',
  `user_name` varchar(125) NOT NULL DEFAULT '',
  `room_no` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `rate_plan` varchar(50) NOT NULL,
  `bytes_in` bigint(20) NOT NULL DEFAULT '0',
  `bytes_out` bigint(20) NOT NULL DEFAULT '0',
  `arrival` datetime NOT NULL,
  `departure` datetime NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'D',
  `active` varchar(10) NOT NULL DEFAULT '1',
  `log_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index 2` (`mac`,`room_no`)
) ENGINE=InnoDB AUTO_INCREMENT=180927 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table hotspot.hotspot_login
CREATE TABLE IF NOT EXISTS `hotspot_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hotel_code` varchar(10) NOT NULL DEFAULT '0',
  `room_no` varchar(10) DEFAULT NULL,
  `mac` varchar(50) DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `last_name` varchar(20) DEFAULT NULL,
  `api_output` varchar(500) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=231949 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table hotspot.hotspot_premium
CREATE TABLE IF NOT EXISTS `hotspot_premium` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hotel_code` varchar(50) NOT NULL,
  `room_no` varchar(50) NOT NULL DEFAULT '0',
  `end_date` datetime NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index 2` (`hotel_code`,`room_no`)
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table hotspot.hotspot_remove
CREATE TABLE IF NOT EXISTS `hotspot_remove` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hotel_code` varchar(50) NOT NULL DEFAULT '0',
  `room_no` varchar(50) DEFAULT '0',
  `created_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index 2` (`hotel_code`,`room_no`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table hotspot.hotspot_safe
CREATE TABLE IF NOT EXISTS `hotspot_safe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mac` varchar(50) NOT NULL DEFAULT '0',
  `hotel_code` varchar(50) NOT NULL DEFAULT '0',
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index 2` (`mac`)
) ENGINE=InnoDB AUTO_INCREMENT=147 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table hotspot.hotspot_shaped
CREATE TABLE IF NOT EXISTS `hotspot_shaped` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hotel_code` varchar(50) NOT NULL DEFAULT '0',
  `room_no` varchar(50) NOT NULL DEFAULT '0',
  `mac` varchar(50) NOT NULL DEFAULT '0',
  `shaped_bytes` bigint(20) NOT NULL DEFAULT '0',
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index 2` (`mac`,`room_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

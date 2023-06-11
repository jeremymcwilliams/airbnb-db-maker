# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: www.watzekdi.net (MySQL 5.7.42)
# Database: watzekdi_airbnb
# Generation Time: 2023-06-09 20:12:51 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table amenities
# ------------------------------------------------------------

CREATE TABLE `amenities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amenity` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_amenity` (`id`,`amenity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table hosts
# ------------------------------------------------------------

CREATE TABLE `hosts` (
  `id` int(11) NOT NULL,
  `hostUrl` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `hostName` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `hostLocation` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `hostAbout` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `superhost` tinyint(1) NOT NULL,
  `hostPic` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;



# Dump of table listingAmenities
# ------------------------------------------------------------

CREATE TABLE `listingAmenities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `listingID` int(11) NOT NULL,
  `amenityID` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_amenityID` (`amenityID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table listings
# ------------------------------------------------------------

CREATE TABLE `listings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `listingUrl` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `neighborhoodOverview` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `pictureUrl` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `hostId` int(11) NOT NULL,
  `neighborhoodId` int(11) NOT NULL,
  `latitude` text COLLATE utf8_unicode_ci NOT NULL,
  `longitude` text COLLATE utf8_unicode_ci NOT NULL,
  `roomTypeId` int(11) NOT NULL,
  `accommodates` int(11) ,
  `bathrooms` decimal(13,2) ,
  `bedrooms` decimal(13,2) ,
  `beds` decimal(13,2) ,
  `price` decimal(13,2) NOT NULL,
  `minNights` int(11) ,
  `maxNights` int(11) ,
  `numReviews` int(11),
  `rating` decimal(13,2),
  `extId` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;



# Dump of table neighborhoods
# ------------------------------------------------------------

CREATE TABLE `neighborhoods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `neighborhood` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table roomTypes
# ------------------------------------------------------------

CREATE TABLE `roomTypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

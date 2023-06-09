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
  `amenity` varchar(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_amenity` (`id`,`amenity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table hosts
# ------------------------------------------------------------

CREATE TABLE `hosts` (
  `id` int(11) NOT NULL,
  `hostUrl` text COLLATE utf8_unicode_ci NOT NULL,
  `hostName` text COLLATE utf8_unicode_ci NOT NULL,
  `hostLocation` text COLLATE utf8_unicode_ci NOT NULL,
  `hostAbout` text COLLATE utf8_unicode_ci NOT NULL,
  `superhost` tinyint(1) NOT NULL,
  `hostPic` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table listingAmenities
# ------------------------------------------------------------

CREATE TABLE `listingAmenities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `listingID` int(11) NOT NULL,
  `amenityID` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_amenityID` (`amenityID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table listings
# ------------------------------------------------------------

CREATE TABLE `listings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `listingUrl` text COLLATE utf8_unicode_ci NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `neighborhoodOverview` text COLLATE utf8_unicode_ci NOT NULL,
  `pictureUrl` text COLLATE utf8_unicode_ci NOT NULL,
  `hostId` int(11) NOT NULL,
  `neighborhoodId` int(11) NOT NULL,
  `latitude` text COLLATE utf8_unicode_ci NOT NULL,
  `longitude` text COLLATE utf8_unicode_ci NOT NULL,
  `roomTypeId` int(11) NOT NULL,
  `accommodates` int(11) NOT NULL,
  `bathrooms` decimal(13,2) NOT NULL,
  `bedrooms` decimal(13,2) NOT NULL,
  `beds` decimal(13,2) NOT NULL,
  `price` decimal(13,2) NOT NULL,
  `minNights` int(11) NOT NULL,
  `maxNights` int(11) NOT NULL,
  `numReviews` int(11) NOT NULL,
  `rating` decimal(13,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table neighborhoods
# ------------------------------------------------------------

CREATE TABLE `neighborhoods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `neighborhood` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table roomTypes
# ------------------------------------------------------------

CREATE TABLE `roomTypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` text CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

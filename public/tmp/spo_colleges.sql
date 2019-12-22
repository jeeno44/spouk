# ************************************************************
# Sequel Pro SQL dump
# Версия 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Адрес: 127.0.0.1 (MySQL 5.7.11)
# Схема: hungry_storm
# Время создания: 2016-05-19 13:28:34 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Дамп таблицы spo_colleges
# ------------------------------------------------------------

DROP TABLE IF EXISTS `spo_colleges`;

CREATE TABLE `spo_colleges` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `city_id` int(10) unsigned DEFAULT NULL,
  `region_id` int(10) unsigned DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(24) COLLATE utf8_unicode_ci DEFAULT '',
  `logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `city_foreign_idx` (`city_id`),
  KEY `region_foreign_idx` (`region_id`),
  CONSTRAINT `colleges_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `spo_cities` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `colleges_region_id_foreign` FOREIGN KEY (`region_id`) REFERENCES `spo_regions` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `spo_colleges` WRITE;
/*!40000 ALTER TABLE `spo_colleges` DISABLE KEYS */;

INSERT INTO `spo_colleges` (`id`, `city_id`, `region_id`, `title`, `address`, `phone`, `logo`, `created_at`, `updated_at`)
VALUES
	(1,63,1,'Коломенский политехнический  колледж','ул. Октябрьской Революции, д. 408 ','+7 (496) 618-09-48',NULL,NULL,NULL),
	(2,63,1,'Коломенский медицинский колледж','ул. Пушкина, д. 13','+7 (496) 613-34-04',NULL,NULL,NULL),
	(3,63,1,'Коломенский филиал ФГОУ  СПО','ул. Савельича, д. 11','+7 (496) 618-63-83 ',NULL,NULL,NULL);

/*!40000 ALTER TABLE `spo_colleges` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

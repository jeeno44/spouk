# ************************************************************
# Sequel Pro SQL dump
# Версия 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Адрес: 127.0.0.1 (MySQL 5.7.11)
# Схема: hungry_storm
# Время создания: 2016-05-19 13:27:25 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Дамп таблицы spo_regions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `spo_regions`;

CREATE TABLE `spo_regions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(70) COLLATE utf8_unicode_ci DEFAULT NULL,
  `code` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `spo_regions` WRITE;
/*!40000 ALTER TABLE `spo_regions` DISABLE KEYS */;

INSERT INTO `spo_regions` (`id`, `title`, `code`, `created_at`, `updated_at`)
VALUES
	(1,'Москва и Московская обл.',NULL,NULL,NULL),
	(2,'Санкт-Петербург и область',NULL,NULL,NULL),
	(3,'Адыгея',NULL,NULL,NULL),
	(4,'Алтайский край',NULL,NULL,NULL),
	(5,'Амурская обл.',NULL,NULL,NULL),
	(6,'Архангельская обл.',NULL,NULL,NULL),
	(7,'Астраханская обл.',NULL,NULL,NULL),
	(8,'Башкортостан(Башкирия)',NULL,NULL,NULL),
	(9,'Белгородская обл.',NULL,NULL,NULL),
	(10,'Брянская обл.',NULL,NULL,NULL),
	(11,'Бурятия',NULL,NULL,NULL),
	(12,'Владимирская обл.',NULL,NULL,NULL),
	(13,'Волгоградская обл.',NULL,NULL,NULL),
	(14,'Вологодская обл.',NULL,NULL,NULL),
	(15,'Воронежская обл.',NULL,NULL,NULL),
	(16,'Дагестан',NULL,NULL,NULL),
	(17,'Еврейская обл.',NULL,NULL,NULL),
	(18,'Ивановская обл.',NULL,NULL,NULL),
	(19,'Иркутская обл.',NULL,NULL,NULL),
	(20,'Кабардино-Балкария',NULL,NULL,NULL),
	(21,'Калининградская обл.',NULL,NULL,NULL),
	(22,'Калмыкия',NULL,NULL,NULL),
	(23,'Калужская обл.',NULL,NULL,NULL),
	(24,'Камчатский край',NULL,NULL,NULL),
	(25,'Карелия',NULL,NULL,NULL),
	(26,'Кемеровская обл.',NULL,NULL,NULL),
	(27,'Кировская обл.',NULL,NULL,NULL),
	(28,'Коми',NULL,NULL,NULL),
	(29,'Костромская обл.',NULL,NULL,NULL),
	(30,'Краснодарский край',NULL,NULL,NULL),
	(31,'Красноярский край',NULL,NULL,NULL),
	(32,'Курганская обл.',NULL,NULL,NULL),
	(33,'Курская обл.',NULL,NULL,NULL),
	(34,'Липецкая обл.',NULL,NULL,NULL),
	(35,'Магаданская обл.',NULL,NULL,NULL),
	(36,'Марий Эл',NULL,NULL,NULL),
	(37,'Мордовия',NULL,NULL,NULL),
	(38,'Мурманская обл.',NULL,NULL,NULL),
	(39,'Нижегородская (Горьковская)',NULL,NULL,NULL),
	(40,'Новгородская обл.',NULL,NULL,NULL),
	(41,'Новосибирская обл.',NULL,NULL,NULL),
	(42,'Омская обл.',NULL,NULL,NULL),
	(43,'Оренбургская обл.',NULL,NULL,NULL),
	(44,'Орловская обл.',NULL,NULL,NULL),
	(45,'Пензенская обл.',NULL,NULL,NULL),
	(46,'Пермский край',NULL,NULL,NULL),
	(47,'Приморский край',NULL,NULL,NULL),
	(48,'Псковская обл.',NULL,NULL,NULL),
	(49,'Ростовская обл.',NULL,NULL,NULL),
	(50,'Рязанская обл.',NULL,NULL,NULL),
	(51,'Самарская обл.',NULL,NULL,NULL),
	(52,'Саратовская обл.',NULL,NULL,NULL),
	(53,'Саха (Якутия)',NULL,NULL,NULL),
	(54,'Сахалин',NULL,NULL,NULL),
	(55,'Свердловская обл.',NULL,NULL,NULL),
	(56,'Северная Осетия',NULL,NULL,NULL),
	(57,'Смоленская обл.',NULL,NULL,NULL),
	(58,'Ставропольский край',NULL,NULL,NULL),
	(59,'Тамбовская обл.',NULL,NULL,NULL),
	(60,'Татарстан',NULL,NULL,NULL),
	(61,'Тверская обл.',NULL,NULL,NULL),
	(62,'Томская обл.',NULL,NULL,NULL),
	(63,'Тува (Тувинская Респ.)',NULL,NULL,NULL),
	(64,'Тульская обл.',NULL,NULL,NULL),
	(65,'Тюменская обл. и Ханты-Мансийский АО',NULL,NULL,NULL),
	(66,'Удмуртия',NULL,NULL,NULL),
	(67,'Ульяновская обл.',NULL,NULL,NULL),
	(68,'Уральская обл.',NULL,NULL,NULL),
	(69,'Хабаровский край',NULL,NULL,NULL),
	(70,'Хакасия',NULL,NULL,NULL),
	(71,'Челябинская обл.',NULL,NULL,NULL),
	(72,'Чечено-Ингушетия',NULL,NULL,NULL),
	(73,'Читинская обл.',NULL,NULL,NULL),
	(74,'Чувашия',NULL,NULL,NULL),
	(75,'Чукотский АО',NULL,NULL,NULL),
	(76,'Ямало-Ненецкий АО',NULL,NULL,NULL),
	(77,'Ярославская обл.',NULL,NULL,NULL),
	(78,'Карачаево-Черкесская Республика',NULL,NULL,NULL),
	(79,'Республика Крым',NULL,NULL,NULL);

/*!40000 ALTER TABLE `spo_regions` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         5.6.21 - MySQL Community Server (GPL)
-- SO del servidor:              Win32
-- HeidiSQL Versión:             9.3.0.5083
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para blog
DROP DATABASE IF EXISTS `blog`;
CREATE DATABASE IF NOT EXISTS `blog` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `blog`;

-- Volcando estructura para tabla blog.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla blog.categories: ~2 rows (aproximadamente)
DELETE FROM `categories`;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` (`id`, `name`, `description`) VALUES
	(1, 'Desarrollo web', 'Categoría desarrollo web'),
	(2, 'Desarrollo Android', 'Categoría desarrollo Android');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;

-- Volcando estructura para tabla blog.entries
CREATE TABLE IF NOT EXISTS `entries` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `user_id` int(255) NOT NULL,
  `category_id` int(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `status` varchar(20) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_entries_users` (`user_id`),
  KEY `fk_entries_categories` (`category_id`),
  CONSTRAINT `fk_entries_categories` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `fk_entries_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla blog.entries: ~4 rows (aproximadamente)
DELETE FROM `entries`;
/*!40000 ALTER TABLE `entries` DISABLE KEYS */;
INSERT INTO `entries` (`id`, `user_id`, `category_id`, `title`, `content`, `status`, `image`) VALUES
	(3, 1, 1, 'Entrada1', 'dfg sdgf gfgsfgf gfg', 'public', NULL),
	(4, 1, 1, 'Entrada2', 'dfg sdgf gfgsfgf gfg', 'public', NULL),
	(5, 1, 1, 'Entrada con tags', 'dsao fhñdh fkjlsd fñlkds fdsh f', 'public', '1478846961.gif'),
	(6, 1, 1, 'Entrada con tags', 'dsao fhñdh fkjlsd fñlkds fdsh f', 'public', '1478846987.gif'),
	(7, 1, 1, 'Entrada con tags', 'dsao fhñdh fkjlsd fñlkds fdsh f', 'public', '1478847211.gif'),
	(8, 1, 1, 'Entrada con tags', 'dsao fhñdh fkjlsd fñlkds fdsh f', 'public', '1478847331.gif'),
	(9, 1, 1, 'Entrada con tags', 'dsao fhñdh fkjlsd fñlkds fdsh f', 'public', '1478847354.gif'),
	(10, 1, 1, 'Entrada con tags', 'dsao fhñdh fkjlsd fñlkds fdsh f', 'public', '1478847546.gif'),
	(11, 1, 1, 'Entrada con tags', 'dsao fhñdh fkjlsd fñlkds fdsh f', 'public', '1478847571.gif'),
	(12, 1, 1, 'Entrada con tags', 'dsao fhñdh fkjlsd fñlkds fdsh f', 'public', '1478847747.gif'),
	(13, 1, 1, 'Entrada con tags', 'dsao fhñdh fkjlsd fñlkds fdsh f', 'public', '1478850080.gif'),
	(14, 1, 1, 'Entrada con tags', 'dsao fhñdh fkjlsd fñlkds fdsh f', 'public', '1478850126.gif'),
	(15, 1, 1, 'Entrada1', 'fgdsgfdg', 'public', '1478850158.gif'),
	(17, 2, 1, 'Entrada1 de Juan', 'gfdgfdsgdf gfsdg', 'public', '1478852129.gif');
/*!40000 ALTER TABLE `entries` ENABLE KEYS */;

-- Volcando estructura para tabla blog.entry_tag
CREATE TABLE IF NOT EXISTS `entry_tag` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `entry_id` int(255) NOT NULL,
  `tag_id` int(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_entry_tag_entries` (`entry_id`),
  KEY `fk_entry_tag_tags` (`tag_id`),
  CONSTRAINT `fk_entry_tag_entries` FOREIGN KEY (`entry_id`) REFERENCES `entries` (`id`),
  CONSTRAINT `fk_entry_tag_tags` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla blog.entry_tag: ~4 rows (aproximadamente)
DELETE FROM `entry_tag`;
/*!40000 ALTER TABLE `entry_tag` DISABLE KEYS */;
INSERT INTO `entry_tag` (`id`, `entry_id`, `tag_id`) VALUES
	(5, 5, 1),
	(6, 5, 10),
	(7, 5, 3),
	(8, 5, 11),
	(9, 5, 1),
	(10, 5, 10),
	(11, 5, 3),
	(12, 5, 11),
	(13, 5, 1),
	(14, 5, 10),
	(15, 5, 3),
	(16, 5, 11),
	(17, 5, 1),
	(18, 5, 10),
	(19, 5, 3),
	(20, 5, 11),
	(21, 5, 12),
	(22, 5, 13),
	(23, 5, 1),
	(24, 5, 10),
	(25, 5, 3),
	(26, 5, 11),
	(27, 5, 12),
	(28, 5, 13),
	(29, 3, 14),
	(30, 3, 14),
	(31, 17, 15);
/*!40000 ALTER TABLE `entry_tag` ENABLE KEYS */;

-- Volcando estructura para tabla blog.tags
CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla blog.tags: ~8 rows (aproximadamente)
DELETE FROM `tags`;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` (`id`, `name`, `description`) VALUES
	(1, 'php', 'php'),
	(2, 'symfony', 'symfony'),
	(3, 'html', 'html'),
	(4, 'zend framework 2', 'zend'),
	(5, '.net', '.NET framework'),
	(7, 'java', 'etiqueta de java'),
	(9, 'django', 'framework de python'),
	(10, 'css', 'css'),
	(11, 'fw', 'fw'),
	(12, 'handlebars', 'handlebars'),
	(13, 'json', 'json'),
	(14, 'gf', 'gf'),
	(15, 'abc seo', 'abc seo');
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;

-- Volcando estructura para tabla blog.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `role` varchar(20) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla blog.users: ~4 rows (aproximadamente)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `role`, `name`, `surname`, `email`, `password`, `imagen`) VALUES
	(1, 'ROLE_ADMIN', 'josu', 'mendi', 'josufmc@hotmail.com', '$2a$04$HUfXSnmL8vIPRPjFyYOQwuuMWdoUtNUEMs0zKE4t9Lfxbx7Y4G.Cm', NULL),
	(2, 'ROLE_USER', 'juan', 'lópez', 'juan@juan.com', '$2a$04$5LLTzKPgmsODTIrwFbdkmua92gnYSyFqwUHOiajpdsjISSQ9pUCCW', NULL),
	(3, 'ROLE_USER', 'David', 'López', 'david@david.com', '$2y$04$xm4aidGT/osCwpJR2aA5ouuTdom8HuqUmwFdyCmNiQYJuy3pyIdGi', NULL),
	(4, 'ROLE_USER', 'k', 'k', 'k', '$2a$04$HUfXSnmL8vIPRPjFyYOQwuuMWdoUtNUEMs0zKE4t9Lfxbx7Y4G.Cm', NULL),
	(5, 'ROLE_USER', 'Fernando', 'Fernandez', 'f@f.f', '$2y$04$xm4aidGT/osCwpJR2aA5ouuTdom8HuqUmwFdyCmNiQYJuy3pyIdGi', NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.5-10.1.30-MariaDB : Database - layanan_bantu_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`layanan_bantu_db` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `layanan_bantu_db`;

/*Table structure for table `groups` */

DROP TABLE IF EXISTS `groups`;

CREATE TABLE `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `groups` */

insert  into `groups`(`id`,`name`,`description`) values (1,'admin','Administrator'),(2,'cs','Customer Service'),(3,'toko','Toko');

/*Table structure for table `layanan_bantu` */

DROP TABLE IF EXISTS `layanan_bantu`;

CREATE TABLE `layanan_bantu` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(50) NOT NULL COMMENT 'LB-Date-ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `layanan_bantu` */

/*Table structure for table `lb_sessions` */

DROP TABLE IF EXISTS `lb_sessions`;

CREATE TABLE `lb_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `lb_sessions` */

insert  into `lb_sessions`(`id`,`ip_address`,`timestamp`,`data`) values ('i739kqa7i813ahgva7tgbsik0khlhcfv','::1',1516845299,'__ci_last_regenerate|i:1516845293;'),('hf616b6pdcjsgah0mhge7tlovjn03907','::1',1531385595,'__ci_last_regenerate|i:1531385595;identity|s:13:\"administrator\";username|s:13:\"administrator\";email|s:15:\"admin@admin.com\";user_id|s:1:\"1\";old_last_login|s:10:\"1513047943\";last_check|i:1531380257;'),('5suu10je6hr5j8n4k45hodoqfqe4697k','::1',1531385901,'__ci_last_regenerate|i:1531385901;identity|s:13:\"administrator\";username|s:13:\"administrator\";email|s:15:\"admin@admin.com\";user_id|s:1:\"1\";old_last_login|s:10:\"1513047943\";last_check|i:1531380257;message|s:11:\"Group Saved\";__ci_vars|a:1:{s:7:\"message\";s:3:\"old\";}'),('vto4e0cgtasqhnn7pv24l06phlkehbi5','::1',1531386289,'__ci_last_regenerate|i:1531386289;identity|s:13:\"administrator\";username|s:13:\"administrator\";email|s:15:\"admin@admin.com\";user_id|s:1:\"1\";old_last_login|s:10:\"1513047943\";last_check|i:1531380257;'),('5m6qu8pnvbdljseu7562nerbscrs74fp','::1',1531386553,'__ci_last_regenerate|i:1531386289;identity|s:13:\"administrator\";username|s:13:\"administrator\";email|s:15:\"admin@admin.com\";user_id|s:1:\"1\";old_last_login|s:10:\"1513047943\";last_check|i:1531380257;message|s:154:\"<div class=\"alert alert-info\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>Group created Successfully</div>\";__ci_vars|a:1:{s:7:\"message\";s:3:\"old\";}');

/*Table structure for table `login_attempts` */

DROP TABLE IF EXISTS `login_attempts`;

CREATE TABLE `login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `login_attempts` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(254) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`id`,`ip_address`,`username`,`password`,`salt`,`email`,`activation_code`,`forgotten_password_code`,`forgotten_password_time`,`remember_code`,`created_on`,`last_login`,`active`,`first_name`,`last_name`,`phone`) values (1,'127.0.0.1','administrator','$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36','','admin@admin.com','',NULL,NULL,NULL,1268889823,1531380257,1,'System','Administrator','01234567'),(2,'::1','anoerman','$2y$08$7Y5JK.V54tQ4XrC.xft/SeYtHcqqUrMrV4J7PtY2jNVNDLvifBRmS',NULL,'noerman.agustiyan@gmail.com',NULL,NULL,NULL,NULL,1512716561,1513047961,1,'Noerman','Agustiyan','123456');

/*Table structure for table `users_groups` */

DROP TABLE IF EXISTS `users_groups`;

CREATE TABLE `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`),
  CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `users_groups` */

insert  into `users_groups`(`id`,`user_id`,`group_id`) values (5,1,1),(6,1,2),(8,2,1);

/*Table structure for table `users_photo` */

DROP TABLE IF EXISTS `users_photo`;

CREATE TABLE `users_photo` (
  `username` varchar(100) NOT NULL,
  `photo` text,
  `thumbnail` text,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `users_photo` */

insert  into `users_photo`(`username`,`photo`,`thumbnail`,`updated_on`) values ('administrator','ADMINISTRATOR.jpg','ADMINISTRATOR_thumb.jpg','2017-12-08 14:02:41'),('anoerman','no_picture.png','no_picture.png','2017-12-08 14:04:05');

/* Trigger structure for table `users` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `after_users_insert` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `after_users_insert` AFTER INSERT ON `users` FOR EACH ROW BEGIN
	INSERT INTO users_photo VALUES( NEW.username, "no_picture.png", "no_picture.png", now());
    END */$$


DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

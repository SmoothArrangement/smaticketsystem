/*
SQLyog Community v9.20 
MySQL - 5.1.53-community-log : Database - crmdeva1_crm2
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`crmdeva1_crm2` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `crmdeva1_crm2`;

/*Table structure for table `inventories` */

DROP TABLE IF EXISTS `inventories`;

CREATE TABLE `inventories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Condition` varchar(100) DEFAULT NULL,
  `Year` int(11) DEFAULT NULL,
  `Make` varchar(250) DEFAULT NULL,
  `Model` varchar(250) DEFAULT NULL,
  `Type` varchar(250) DEFAULT NULL,
  `Color` varchar(250) DEFAULT NULL,
  `StockNum` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `inventories` */

insert  into `inventories`(`id`,`Condition`,`Year`,`Make`,`Model`,`Type`,`Color`,`StockNum`) values (1,'New ',2014,'Honda ','CBR 600R ','Cruiser/Vtwin','Red','#542fg'),(2,'New ',2014,'Yamaha ','YZ 125 ','Dirt Bike','Blue','#5673yw'),(3,'Used ',2012,'Polaris ','Ranger X','Side By Side','Blue','#2341Sid'),(4,'Used ',2010,'Harley-Davidson','FLCTH ','Cruiser/Vtwin','White','#65hd76');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

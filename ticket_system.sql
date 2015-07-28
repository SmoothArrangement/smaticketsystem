/*
SQLyog Community v9.20 
MySQL - 5.1.53-community-log : Database - ticketsystem
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`ticketsystem` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `ticketsystem`;

/*Table structure for table `email_template` */

DROP TABLE IF EXISTS `email_template`;

CREATE TABLE `email_template` (
  `iId` int(11) NOT NULL AUTO_INCREMENT,
  `vTemplate` varchar(750) DEFAULT NULL,
  `vSubject` varchar(1500) DEFAULT NULL,
  `tMessage` text,
  `vSender` varchar(750) DEFAULT NULL,
  PRIMARY KEY (`iId`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `email_template` */

insert  into `email_template`(`iId`,`vTemplate`,`vSubject`,`tMessage`,`vSender`) values (1,'Create new account','Bike Arena Benneker Ticket System | Your Account has been created {benutzername}','Hallo {benutzername},\r\n<br><br>\r\nJust your user account has been unlocked.<br>\r\nPlease log on with the following data:<br>\r\n<br>\r\nTicketsystem = {ticketlogin}\r\n<br>\r\nUsername = {benutzeremail}\r\n<br>\r\nPassword = As Enter on Registration.&nbsp;<br>\r\n<br>\r\nIf you have forgotten it, you can RESET it: {ticketlogin}\r\n<br>\r\nSimply click on the link Forgot Password?&nbsp;<br>\r\n<br>\r\nHave fun. If you need help, please contact your authorized superiors.<br><br>Other span Bike Arena Benneker | Ticket System</div>','ticketsystem@bikearena-benneker.de'),(2,'New Ticket','New Ticket from {absender} | {ticketbeschreibung}','Hallo {benutzername},&nbsp;<br><br>{absender} hat ein Ticket fÃ¼r Dich erstelt.<br><br>Das Ticket hat folgenden Inhalt:<br><br>{tickettext}&nbsp;<br><br>Um zu antworten melde Dich bitte am Ticketsystem an.<br><br>{ticketlogin}<br><br>Beste GrÃ¼ÃŸe<br>Bikearena Benneker | Ticket System','ticketmailer@ticketsystem.de'),(3,'In response to a ticket','{absender} replied on {zeitstempel} to the following ticket: {ticketbeschreibung} ','Hallo {benutzername},\r\n<br>\r\n<br>\r\n{absender} hat auf Dein Ticket geantwortet.<br>\r\nDas Ticket hat folgenden Inhalt:<br>\r\n<br>\r\n{tickettext}\r\n<br>\r\n<br>Um zu antworten melde Dich bitte am Ticketsystem an.<br><br>{ticketlogin}<br><br>\r\nBeste GrÃ¼ÃŸe<br>Bikearena Benneker | Ticket System','ticketsystem@bikearena-benneker.de'),(4,'Ticket status changed','Status for the ticket: {ticketbeschreibung} was of {absender} changed','Dear {benutzername},\\r\\n<br>\\r\\n<br>\\r\\n{absender} has changed ticketstatus to: {ticketstatus}.\\r\\n<br>\\r\\n<br>\\r\\nThis is ticket content:\\r\\n<br>\\r\\n<br>\\r\\n{tickettext}\\r\\n<br>\\r\\n<br>\\r\\nBest Reagrds\\r\\n<br>\\r\\n<br>\\r\\nAdmin','status@ticketsystem.de'),(5,'Forgot Password','Your new password for the ticket system {benutzername}','<span style=\"font-weight: normal;\">Hallo {benutzername},\r\n<br>\r\ndu hast Dein Passwort vergessen?<br>Gar kein Problem. Hier ist ein neues Passwort fÃ¼r Dich.<br><br>Bitte logge Dich beim nÃ¤chsten mal mit diesem Passwort ein: </span><span style=\"font-weight: bold;\">{passwort}</span><br>\r\n<br>\r\nLogin:\r\n<br>\r\n<br>Ticketsystem = {ticketlogin}&nbsp;<br>Benutzername = {benutzeremail}&nbsp;<br>Passwort = {passwort}<br>\r\n<br><span style=\"font-weight: bold; text-decoration: underline; color: rgb(255, 0, 0);\">\r\nBitte Ã¤ndere Dein Passwort nach dem 1. Login.</span><br>\r\n<br>Solltest Du kein Passwort angefordert haben, wende Dich bitte an Deinen Vorgesetzten.<br><br>Beste GrÃ¼ÃŸe<div style=\"font-weight: normal;\">Bike Arena Benneker | Ticket System</div>','ticketsystem@bikearena-benneker.de'),(6,'New User','{newuser} has for the ticket system registers','Hallo Admin,\r\n<br>{neuerbenutzername}&nbsp;hat sich fÃ¼r das Ticketsystem regestriert.&nbsp;&nbsp;<br><br>\r\nEr kann nun Tickets verfassen und beantworten.<br><br>\r\nName = {neuerbenutzername}<br>\r\nE-Mail &nbsp;= {neuebenutzeremail}<br>\r\nRechte = {benutzerstatus}\r\n<br><br>Beste GrÃ¼ÃŸe<div>Bikearena Benneker | Ticket System</div>','ticketsystem@bikearena-benneker.de');

/*Table structure for table `tick_ans` */

DROP TABLE IF EXISTS `tick_ans`;

CREATE TABLE `tick_ans` (
  `iId` int(11) NOT NULL AUTO_INCREMENT,
  `iTickId` int(11) DEFAULT NULL,
  `iUserId` int(11) DEFAULT NULL,
  `vAnswer` blob,
  `vFile` varchar(750) DEFAULT NULL,
  `tCreateOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`iId`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

/*Data for the table `tick_ans` */

insert  into `tick_ans`(`iId`,`iTickId`,`iUserId`,`vAnswer`,`vFile`,`tCreateOn`) values (8,7,14,'Okay i will now close this ticket. Thanks for support','','2014-03-04 19:17:28'),(7,7,4,'Okay ill check this and send back a attachement to hans.','1393940654_bab.ico','2014-03-04 19:14:14'),(6,7,14,'This i my answer to the ticket from Philipp.\r\nI will set up a attachement.','1393940447_3d.ico','2014-03-04 19:10:47'),(9,8,4,'Bitte geben Sie einen Wert größer oder gleich Bitte geben Sie einen Wert größer oder gleich','','2014-03-05 16:49:39'),(10,8,4,'Bitte geben Sie einen Wert größer oder gleich Bitte geben Sie einen Wert größer oder gleich','','2014-03-05 16:50:05'),(15,8,4,'asdfasdf','','2014-03-05 20:41:39'),(16,8,4,'dasfasdfsdafsadf','','2014-03-06 10:58:27'),(13,11,4,'Jau Antwort','1394030079_Download.ico','2014-03-05 20:04:39'),(14,11,30,'OK Close','','2014-03-05 20:05:31');

/*Table structure for table `ticket_mst` */

DROP TABLE IF EXISTS `ticket_mst`;

CREATE TABLE `ticket_mst` (
  `iId` int(11) NOT NULL AUTO_INCREMENT,
  `iParentId` int(11) DEFAULT NULL,
  `vSubject` varchar(501) DEFAULT NULL,
  `tMatterConcern` text,
  `iSenderId` int(11) DEFAULT NULL,
  `iReceiverId` int(11) DEFAULT NULL,
  `tCreateDate` timestamp NULL DEFAULT NULL,
  `dEditDate` datetime DEFAULT NULL,
  `dDate` date DEFAULT NULL,
  `vPriority` varchar(100) DEFAULT NULL,
  `vAttechedFile` varchar(250) DEFAULT NULL,
  `vView` varchar(10) NOT NULL DEFAULT 'NO',
  `vStatus` varchar(51) DEFAULT NULL,
  PRIMARY KEY (`iId`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

/*Data for the table `ticket_mst` */

insert  into `ticket_mst`(`iId`,`iParentId`,`vSubject`,`tMatterConcern`,`iSenderId`,`iReceiverId`,`tCreateDate`,`dEditDate`,`dDate`,`vPriority`,`vAttechedFile`,`vView`,`vStatus`) values (11,NULL,'Test','Ã–ffner',30,4,'2014-03-05 20:04:12','2014-03-05 15:35:31','0000-00-00','Normal','1394030052_3d.ico','YES','Close'),(12,NULL,'asdf','asdf',4,30,'2014-03-05 20:41:09','2014-03-05 16:11:09','2014-03-06','Normal','','YES','Open'),(13,NULL,'Answer for Ticket {ticketbeschreibung} from {absender}','MÃ¤rz MÃ¤rzMÃ¤rz MÃ¤rz MÃ¤rz MÃ¤rz MÃ¤rz  MÃ¤rz vMÃ¤rz MÃ¤rz MÃ¤rzMÃ¤rz MÃ¤rz MÃ¤rz MÃ¤rz MÃ¤rz MÃ¤rz MÃ¤rz MÃ¤rz MÃ¤rz MÃ¤rz MÃ¤rz MÃ¤rz MÃ¤rz',4,15,'2014-03-06 11:45:07','2014-03-06 07:15:07','0000-00-00','Normal','','YES','Open'),(8,NULL,'Bitte geben Sie einen Wert grÃ¶ÃŸer oder gleich','Bitte geben Sie einen Wert grÃ¶ÃŸer oder gleich Bitte geben Sie einen Wert grÃ¶ÃŸer oder gleich Bitte geben Sie einen Wert grÃ¶ÃŸer oder gleich',4,15,'2014-03-05 16:48:33','2014-03-06 06:28:27','0000-00-00','Normal','','YES','Open'),(7,NULL,'Test Ticket To Hans Mitarbeiter','Tis is text i send to Hans. This is startup Text. 1. Entry in Ticket cause i am opener.\r\nI add no attachement and set no estimate date to it. I leave ticket opened.',4,15,'2014-03-04 18:56:52','2014-03-04 14:47:28','0000-00-00','Normal','','YES','Close');

/*Table structure for table `user_mst` */

DROP TABLE IF EXISTS `user_mst`;

CREATE TABLE `user_mst` (
  `iId` int(11) NOT NULL AUTO_INCREMENT,
  `vFname` varchar(250) DEFAULT NULL,
  `vLname` varchar(250) DEFAULT NULL,
  `vEmail` varchar(250) DEFAULT NULL,
  `vPassword` varchar(250) DEFAULT NULL,
  `vUserType` varchar(11) DEFAULT NULL,
  `vStatus` varchar(11) DEFAULT '1',
  `dLastLogin` datetime NOT NULL,
  PRIMARY KEY (`iId`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

/*Data for the table `user_mst` */

insert  into `user_mst`(`iId`,`vFname`,`vLname`,`vEmail`,`vPassword`,`vUserType`,`vStatus`,`dLastLogin`) values (4,'Philipp','Dallmann','mysticdefiance@gmail.com','MjIyMzIyMzI=','1','1','2014-04-01 09:10:03'),(15,'Yash','Amipara','amiparayash@gmail.com','MjIyMzIyMzI=','3','1','2014-03-08 10:54:14'),(30,'Hans','Mitarbeiter','info@smootharrangement.eu','MjIyMzIyMzI=','2','1','2014-04-01 09:14:46');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

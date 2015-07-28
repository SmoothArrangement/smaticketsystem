/*
Navicat MySQL Data Transfer

Source Server         : Bike Arena Benneker
Source Server Version : 50541
Source Host           : bikearena-benneker.de:3306
Source Database       : ticketsystem

Target Server Type    : MYSQL
Target Server Version : 50541
File Encoding         : 65001

Date: 2015-07-28 14:17:15
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for email_template
-- ----------------------------
DROP TABLE IF EXISTS `email_template`;
CREATE TABLE `email_template` (
  `iId` int(11) NOT NULL AUTO_INCREMENT,
  `vTemplate` varchar(750) DEFAULT NULL,
  `vSubject` varchar(1500) DEFAULT NULL,
  `tMessage` text,
  `vSender` varchar(750) DEFAULT NULL,
  PRIMARY KEY (`iId`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of email_template
-- ----------------------------
INSERT INTO `email_template` VALUES ('1', 'Create new account', 'Bike Arena Benneker Ticket System | Dein Account wurde erstellt {benutzername}', 'Hallo {benutzername},<br><br>Ein Account wurde f&uuml;r Dich erstellt.<br>Bitte logg dich mit den folgenden Daten ein:<br><br>Ticketsystem = http://it.bikearena-benneker.de<br>Benutzername = {benutzeremail}<br>Passwort = Bei der Regestrierung selbst vergeben<br><br>Wenn Du Dein Passwort vergessen hast, kannst Du es hier zur&uuml;ck setzen: http://it.bikearena-benneker.de<br>Klick einfach auf den Link: Passwort vergessen.<br><br>Beste Gr&uuml;ÃŸe<br>Bike Arena Benneker | Ticket System', 'noreply@bikearena-benneker.de');
INSERT INTO `email_template` VALUES ('2', 'New Ticket', 'Neues ticket von {absender} | {ticketbeschreibung}', 'Hallo {benutzername},<br><br>{absender} hat ein Ticket f&uuml;r Dich erstellt.<br><br>Das Ticket hat folgenden Inhalt:<br><br>{tickettext}<br><br>Um zu antworten melde Dich bitte am Ticketsystem an.<br>http://it.bikearena-benneker.de<br><br>Beste Gr&uuml;&szlig;e<br>Bike Arena Benneker | Ticket System', 'noreply@bikearena-benneker.de');
INSERT INTO `email_template` VALUES ('3', 'In response to a ticket', '{absender} hat auf folgendes Ticket geantwortet: {ticketbeschreibung} ', 'Hallo {benutzername},<br><br>{absender} hat auf Dein Ticket geantwortet.<br>Das Ticket hat folgenden Inhalt:<br><br>{tickettext}<br><br>Um zu antworten melde Dich bitte am Ticketsystem an.<br><br>http://it.bikearena-benneker.de</a><br><br>Beste Gr&uuml;&szlig;e<br>Bikearena Benneker | Ticket System', 'noreply@bikearena-benneker.de');
INSERT INTO `email_template` VALUES ('4', 'Ticket status changed', 'Status fÃ¼r das Ticket: {ticketbeschreibung} wurde von {absender} geÃ¤ndert', 'Hallo {benutzername},<br><br>{absender} hat den ticketstaus auf: {ticketstatus} gesetzt.<br><br>Das ist der Inhalt des Tickets:<br><br>{tickettext}<br><br><br>Beste Gr&uuml;&szlig;e<br>Bike Arena Benneker | Ticketsystem<br>', 'noreply@bikearena-benneker.de');
INSERT INTO `email_template` VALUES ('5', 'Forgot Password', 'Dein neues Passwort f&uuml;r das ticketsystem {benutzername}', 'Hallo {benutzername},du hast Dein Passwort vergessen?Gar kein Problem. Hier ist ein neues Passwort fÃ¼r Dich.<br>Bitte logge Dich beim n&auml;chsten mal mit diesem Passwort ein: {passwort}<br><br>Login:<br><br>Ticketsystem = http://it.bikearena-benneker.de<br>Benutzername = {benutzeremail} <br>Passwort = {passwort}<br><br>Bitte &auml;ndere Dein Passwort nach dem 1. Login.<br><br>Solltest Du kein Passwort angefordert haben, wende Dich bitte an einen Vorgesetzten.<br><br>Beste Gr&uuml;ÃŸe<br>Bike Arena Benneker | Ticket System', 'noreply@bikearena-benneker.de');
INSERT INTO `email_template` VALUES ('6', 'New User', '{neuerbenutzername} hat ein Account erstellt', 'Hallo Admin,<br>{neuerbenutzername} hat sich fÃ¼r das Ticketsystem registriert. &nbsp;<br><br>Er kann nun Tickets verfassen und beantworten.<br><br>Name = {neuerbenutzername}<br>E-Mail&nbsp; = {neuebenutzeremail}<br>Rechte = {benutzerstatus}<br><br>Beste Gr&uuml;&szlig;e<br>Bikearena Benneker | Ticket System', 'noreply@bikearena-benneker.de');

-- ----------------------------
-- Table structure for tick_ans
-- ----------------------------
DROP TABLE IF EXISTS `tick_ans`;
CREATE TABLE `tick_ans` (
  `iId` int(11) NOT NULL AUTO_INCREMENT,
  `iTickId` int(11) DEFAULT NULL,
  `iUserId` int(11) DEFAULT NULL,
  `vAnswer` blob,
  `vFile` varchar(750) DEFAULT NULL,
  `tCreateOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`iId`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tick_ans
-- ----------------------------

-- ----------------------------
-- Table structure for ticket_mst
-- ----------------------------
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
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ticket_mst
-- ----------------------------

-- ----------------------------
-- Table structure for user_mst
-- ----------------------------
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
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user_mst
-- ----------------------------
INSERT INTO `user_mst` VALUES ('4', 'Philipp', 'Dallmann', 'mysticdefiance@gmail.com', 'c3VwcG9ydA==', '1', '1', '2015-07-28 13:49:42');

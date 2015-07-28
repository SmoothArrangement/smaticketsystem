/*
SQLyog Community v9.20 
MySQL - 5.1.53-community-log 
*********************************************************************
*/
/*!40101 SET NAMES utf8 */;

create table `email_template` (
	`iId` int (11),
	`vTemplate` varchar (750),
	`vSubject` varchar (1500),
	`tMessage` blob ,
	`vSender` varchar (750)
); 
insert into `email_template` (`iId`, `vTemplate`, `vSubject`, `tMessage`, `vSender`) values('1','Neues Benutzer Account','Ihr Account wurde erstellt {benutzername}','Dear {benutzername},\r\n<br>\r\nan account is created for you. Now you can start create and recive workflows.\r\n<br>\r\nPlease log in with this data:\r\n<br>\r\n<br>\r\nCP Login = {ticketlogin}\r\n<br>\r\nUsername = {benutzeremail}\r\n<br>\r\nPassword = self-selected at registration\r\n<br>\r\n<br>\r\nIf you have forgotten your password, you can reset it here: {ticketlogin}\r\n<br>\r\nUse passwort vorgett link.\r\n<br>\r\n<br>\r\nHave fun.\r\n<br>\r\nBest Reagrds\r\n<br>\r\n<br>\r\nAdmin','account@ticketsystem.de');
insert into `email_template` (`iId`, `vTemplate`, `vSubject`, `tMessage`, `vSender`) values('2','Neues Ticket','Neues Ticket von {absender} | {ticketbeschreibung}','Dear {benutzername},\r\n<br>\r\n<br>\r\n{absender} has create a new ticket for you. Your asnwer is required.\r\n<br>\r\nThis is ticket content:\r\n<br>\r\n<br>\r\n{tickettext}\r\n<br>\r\n<br>\r\nBest Reagrds\r\n<br>\r\n<br>\r\nAdmin','ticketmailer@ticketsystem.de');
insert into `email_template` (`iId`, `vTemplate`, `vSubject`, `tMessage`, `vSender`) values('3','Antwort auf ein Ticket','Answer for Ticket {ticketbeschreibung} from {absender}','Dear {benutzername},\r\n<br>\r\n<br>\r\n{absender} has answered to your ticket.\r\n<br>\r\nThis is ticket content:\r\n<br>\r\n<br>\r\n{tickettext}\r\n<br>\r\n<br>\r\nBest Reagrds\r\n<br>\r\n<br>\r\nAdmin','ticketanswer@ticketsystem.de');
insert into `email_template` (`iId`, `vTemplate`, `vSubject`, `tMessage`, `vSender`) values('4','Ticket Status geandert','The status of the ticket {ticketbeschreibung} has been changed.','Dear {benutzername},\r\n<br>\r\n<br>\r\n{absender} has changed ticketstatus to: {ticketstatus}.\r\n<br>\r\n<br>\r\nThis is ticket content:\r\n<br>\r\n<br>\r\n{tickettext}\r\n<br>\r\n<br>\r\nBest Reagrds\r\n<br>\r\n<br>\r\nAdmin','status@ticketsystem.de');
insert into `email_template` (`iId`, `vTemplate`, `vSubject`, `tMessage`, `vSender`) values('5','Passwort vergessen','Your new password for ticketsystem','Dear {benutzername},\r\n<br>\r\nyou have used the passsword lost feature.\r\n<br>\r\nPlease login with temp password: {passwort} to ticketsystem.\r\n<br>\r\nChange your Password in settings area.\r\n<br>\r\n<br>\r\nLogindata:\r\n<br>\r\n<br>\r\nCP Login = {ticketlogin}\r\n<br>\r\nUsername = {benutzeremail}\r\n<br>\r\nPassword = {passwort}\r\n<br>\r\n<br>\r\nBest Reagrds\r\n<br>\r\n<br>\r\nAdmin','security@ticketsystem.de');
insert into `email_template` (`iId`, `vTemplate`, `vSubject`, `tMessage`, `vSender`) values('6','Neuer Benutzer','A new user has registered | {newusername}','Dear Admin,\r\n<br>\r\nan account is created for {newusername}.\r\n<br><br>\r\nNow he can start create and recive workflows.\r\n<br><br>\r\nUsername = {neuerbenutzername}\r\nUser e_mail = {neuebenutzeremail}\r\nuser status = {benutzerstatus}\r\n<br><br>\r\nIf you have forgotten your password, you can reset it here: {ticketlogin}\r\nUse passwort vorgett link.\r\n<br><br>\r\nBest Reagrds\r\n<br><br>\r\nSystem','security@ticketsystem.de');

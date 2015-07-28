/*
SQLyog Community v9.20 
MySQL - 5.1.53-community-log 
*********************************************************************
*/
/*!40101 SET NAMES utf8 */;

create table `tick_ans` (
	`iId` int (11),
	`iTickId` int (11),
	`iUserId` int (11),
	`vAnswer` blob ,
	`vFile` varchar (750),
	`tCreateOn` timestamp 
); 
insert into `tick_ans` (`iId`, `iTickId`, `iUserId`, `vAnswer`, `vFile`, `tCreateOn`) values('1','2','1','Test Reply',NULL,'2014-02-27 18:50:03');
insert into `tick_ans` (`iId`, `iTickId`, `iUserId`, `vAnswer`, `vFile`, `tCreateOn`) values('2','2','1','Yash was on fire',NULL,'2014-02-27 19:34:05');
insert into `tick_ans` (`iId`, `iTickId`, `iUserId`, `vAnswer`, `vFile`, `tCreateOn`) values('3','2','1','Hey this was greate and good tested',NULL,'2014-02-27 19:35:49');

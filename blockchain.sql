/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 10.4.22-MariaDB 
*********************************************************************
*/
/*!40101 SET NAMES utf8 */;

create table `m_blockchain` (
	`id` int (11),
	`blockchain` varchar (150),
	`image` varchar (765),
	`description` text ,
	`price` int (11),
	`fee` int (11),
	`created_at` int (11),
	`created_by` int (11),
	`modified_at` int (11),
	`modified_by` int (11),
	`is_deleted` tinyint (1)
); 

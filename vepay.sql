/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 10.4.22-MariaDB : Database - db_vepay
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

/*Table structure for table `_transaksi_detail` */

DROP TABLE IF EXISTS `_transaksi_detail`;

CREATE TABLE `_transaksi_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaksi_id` int(11) NOT NULL,
  `m_product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` int(11) NOT NULL DEFAULT 0,
  `total` int(11) NOT NULL DEFAULT 0,
  `created_at` int(11) NOT NULL DEFAULT 0,
  `created_by` varchar(15) NOT NULL DEFAULT '0',
  `modified_at` int(11) NOT NULL DEFAULT 0,
  `modified_by` varchar(15) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`,`transaksi_id`,`m_product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `_transaksi_detail` */

insert  into `_transaksi_detail`(`id`,`transaksi_id`,`m_product_id`,`quantity`,`price`,`total`,`created_at`,`created_by`,`modified_at`,`modified_by`,`is_deleted`) values 
(4,18,1,5,21999,109995,1671510837,'1',0,'0',0),
(5,19,1,5,21999,109995,1671510867,'1',0,'0',0);

/*Table structure for table `m_categories` */

DROP TABLE IF EXISTS `m_categories`;

CREATE TABLE `m_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categories` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` int(11) NOT NULL DEFAULT 0,
  `created_by` varchar(255) NOT NULL DEFAULT '0',
  `modified_at` int(11) NOT NULL DEFAULT 0,
  `modified_by` varchar(255) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `m_categories` */

insert  into `m_categories`(`id`,`categories`,`description`,`created_at`,`created_by`,`modified_at`,`modified_by`,`is_deleted`) values 
(1,'testtt','test',1669005854,'2',0,'0',0);

/*Table structure for table `m_metode` */

DROP TABLE IF EXISTS `m_metode`;

CREATE TABLE `m_metode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `metode` varchar(25) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` int(11) NOT NULL DEFAULT 0,
  `created_by` varchar(15) NOT NULL DEFAULT '0',
  `modified_at` int(11) NOT NULL DEFAULT 0,
  `modified_by` varchar(15) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `m_metode` */

insert  into `m_metode`(`id`,`metode`,`image`,`description`,`created_at`,`created_by`,`modified_at`,`modified_by`,`is_deleted`) values 
(2,'Bank MANDIRI',NULL,'',1670769650,'1',0,'0',0),
(3,'Bank BCA',NULL,'',1671463944,'1',0,'0',0),
(4,'test','berkas/metode/12/2022/1671497451.jpg','adawd',1671497451,'1',0,'0',0);

/*Table structure for table `m_payments_settings` */

DROP TABLE IF EXISTS `m_payments_settings`;

CREATE TABLE `m_payments_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_method` varchar(50) DEFAULT NULL,
  `type_method` varchar(50) DEFAULT NULL,
  `code_method` varchar(50) DEFAULT NULL,
  `img_method` varchar(255) DEFAULT NULL,
  `fee_method` varchar(255) DEFAULT NULL,
  `type_fee_method` int(5) DEFAULT 1 COMMENT '1: percentage; 2: flat',
  `data` text DEFAULT NULL,
  `tutorial` text DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` int(11) NOT NULL DEFAULT 0,
  `created_by` varchar(15) NOT NULL DEFAULT '0',
  `modified_at` int(11) NOT NULL DEFAULT 0,
  `modified_by` varchar(15) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `m_payments_settings` */

insert  into `m_payments_settings`(`id`,`payment_method`,`type_method`,`code_method`,`img_method`,`fee_method`,`type_fee_method`,`data`,`tutorial`,`active`,`created_at`,`created_by`,`modified_at`,`modified_by`,`is_deleted`) values 
(1,'Paypal','manual','paypal','assets/images/payments/paypal.png',NULL,2,'','',0,0,'0',1667362455,'USER-ADM-01',0),
(3,'Western Union','manual','western_union','assets/images/payments/western_union.png',NULL,3,'{\r\n    \"first_name\": \"Meldi Latifah\",\r\n    \"last_name\": \"Saraswati\",\r\n    \"id_number\": \"99429734658\",\r\n    \"city\": \"IZMIT\",\r\n    \"state\": \"KOCAELI\",\r\n    \"country\": \"Turkiye\"\r\n}','<p>Western Union / Moneygram Payment for Foreign Participants:</p>\r\n\r\n<p>1. Go directly to the nearest Western Union in your area<br />\r\n2. Fill &quot;To Send Money&quot; form<br />\r\n3. Fill the receiver data according to the:</p>\r\n\r\n<p><strong>First Name </strong>: Meldi Latifah<br />\r\n<strong>Last Name </strong>: Saraswati<br />\r\n<strong>ID Number </strong>: 99429734658<br />\r\n<strong>City </strong>: IZMIT<br />\r\n<strong>State</strong>: KOCAELI<br />\r\n<strong>Country </strong>: Turkiye</p>\r\n\r\n<p>4. Give your cash to the officer<br />\r\n5. Take a photo of your filled &quot;To Send Money&quot; form and keep your MTCN in order to do your payment confirmation<br />\r\n6. Please pay attention to filling in the receiver data. The data filled must be exactly the same and should not be false even one letter according to the information above. Otherwise, your payment will not be acknowledged.<br />\r\n7. The amount that should be paid according to the registration fee. <strong>This amount has not included the charge from&nbsp;Western&nbsp;Union.</strong></p>\r\n',1,0,'0',1667714500,'USER-ADM-01',0),
(7,'Mandiri','manual','mandiri','assets/images/payments/mandiri.png',NULL,3,'{\r\n    \"atas_nama\": \"Meldi Latifah Saraswati\",\r\n    \"no_rekening\": \"137-00-1614461-6\"\r\n}','<ol>\r\n	<li>Pertama, masukkan kartu ATM Mandiri dengan posisi yang benar</li>\r\n	<li>Selanjutnya, pilih menu Bahasa Indonesia</li>\r\n	<li>Masukan 6 digit PIN kamu dengan benar</li>\r\n	<li>Lalu, pilih menu transaksi lainnya</li>\r\n	<li>Pilih menu Transfer</li>\r\n	<li>Pilih menu ke Rekening Mandiri</li>\r\n	<li>Masukan nomor rekening tujuan (pilih Benar)</li>\r\n	<li>Masukan jumlah uang yang akan ditransfer (pilih Benar)</li>\r\n	<li>Perhatikan konfirmasi transfer, jika benar pilih Benar</li>\r\n	<li>Transaksi telah selesai, pilih Keluar atau tekan Cancel.</li>\r\n</ol>\r\n',1,0,'0',1667368547,'USER-ADM-01',0);

/*Table structure for table `m_price` */

DROP TABLE IF EXISTS `m_price`;

CREATE TABLE `m_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `m_product_id` int(11) DEFAULT NULL,
  `type` varchar(25) DEFAULT 'Top Up',
  `price` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` int(11) NOT NULL DEFAULT 0,
  `created_by` varchar(15) NOT NULL DEFAULT '0',
  `modified_at` int(11) NOT NULL DEFAULT 0,
  `modified_by` varchar(15) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `m_price` */

insert  into `m_price`(`id`,`m_product_id`,`type`,`price`,`status`,`created_at`,`created_by`,`modified_at`,`modified_by`,`is_deleted`) values 
(1,1,'Top Up',15999,0,1671463531,'1',0,'0',0),
(2,1,'Withdraw',17999,1,1671463769,'1',0,'0',0),
(3,1,'Top Up',21999,1,1671463883,'1',0,'0',0);

/*Table structure for table `m_product` */

DROP TABLE IF EXISTS `m_product`;

CREATE TABLE `m_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `m_categories_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT 'assets/images/placeholder.jpg',
  `description` text DEFAULT NULL,
  `created_at` int(11) NOT NULL DEFAULT 0,
  `created_by` varchar(255) NOT NULL,
  `modified_at` int(11) NOT NULL DEFAULT 0,
  `modified_by` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `m_product` */

insert  into `m_product`(`id`,`m_categories_id`,`name`,`image`,`description`,`created_at`,`created_by`,`modified_at`,`modified_by`,`is_deleted`) values 
(1,0,'Payeer','assets/images/placeholder.jpg','Test',1669000361,'2',1669002422,'2',0),
(3,1,'Paypal','berkas/product/11/2022/1669002681.jpg','test',1669002681,'2',1669005938,'2',0),
(4,0,'Paypal',NULL,'test',1669003300,'2',1669003308,'2',1);

/*Table structure for table `m_promo` */

DROP TABLE IF EXISTS `m_promo`;

CREATE TABLE `m_promo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `value` int(11) NOT NULL,
  `expired` int(11) NOT NULL DEFAULT 0,
  `quota` int(5) DEFAULT NULL,
  `jenis` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` int(11) NOT NULL DEFAULT 0,
  `created_by` varchar(255) NOT NULL DEFAULT '0',
  `modified_at` int(11) NOT NULL DEFAULT 0,
  `modified_by` varchar(255) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_type_promo` (`jenis`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Data for the table `m_promo` */

insert  into `m_promo`(`id`,`kode`,`nama`,`image`,`value`,`expired`,`quota`,`jenis`,`status`,`created_at`,`created_by`,`modified_at`,`modified_by`,`is_deleted`) values 
(3,'NL051','PROMO NATAL',NULL,25000,0,5,1,1,1670291436,'1',1670291819,'1',1),
(4,'NL051','PROMO NATAL',NULL,25,1670432400,5,2,1,1670291682,'1',1670767776,'1',0),
(5,'1234567890123456','TEST','berkas/promo/1671494362.jpg',100,1671642000,1,2,1,1671494362,'1',0,'0',0);

/*Table structure for table `tb_auth` */

DROP TABLE IF EXISTS `tb_auth`;

CREATE TABLE `tb_auth` (
  `user_id` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` int(5) NOT NULL DEFAULT 2 COMMENT '0: SU; 1: Admin; 2: User',
  `status` int(5) NOT NULL COMMENT '0: unverified; 1: verified; 2: suspend',
  `online` tinyint(1) NOT NULL DEFAULT 0,
  `device` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `log_time` int(11) NOT NULL DEFAULT 0,
  `created_at` int(11) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `tb_auth` */

insert  into `tb_auth`(`user_id`,`username`,`email`,`password`,`role`,`status`,`online`,`device`,`log_time`,`created_at`,`is_deleted`) values 
('1','ngodingin','ngodingin.indonesia@gmail.com','$2y$10$1hg1pDmFo9NYLXLuKxr86.qZpBwWcFo.gQgLLye5Hsk9VXmZqdW12',0,1,1,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',1671494193,1668947154,0),
('2','admin','admin@vepay.id','$2y$10$1hg1pDmFo9NYLXLuKxr86.qZpBwWcFo.gQgLLye5Hsk9VXmZqdW12',1,1,1,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36',1668990210,1668947154,0),
('USR-MHNDR-d8eb4','mahendra','mahendradwipurwanto@gmail.com','$2y$10$q1XjBKoVw06w1TRBpU60m.x/imDg9sUvOypLR0eFFAHRyY8wt9o1G',2,1,0,NULL,0,1668961722,0);

/*Table structure for table `tb_settings` */

DROP TABLE IF EXISTS `tb_settings`;

CREATE TABLE `tb_settings` (
  `key` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL DEFAULT 0,
  `modified_at` int(11) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `tb_settings` */

insert  into `tb_settings`(`key`,`value`,`desc`,`created_at`,`modified_at`,`is_deleted`) values 
('bypass_otp','true',NULL,1653641032,0,0),
('mailer_alias','Vepay.id',NULL,1653641032,0,0),
('mailer_connection','ssl',NULL,1653641032,0,0),
('mailer_host','smtp.googlemail.com',NULL,1653641032,0,0),
('mailer_mode','1',NULL,1653641032,0,0),
('mailer_password','ctzpmwrozzycessd',NULL,1653641032,0,0),
('mailer_port','465',NULL,1653641032,0,0),
('mailer_smtp','1',NULL,1653641032,0,0),
('mailer_username','mail.ngodingin@gmail.com',NULL,1653641032,0,0),
('master_password','12344321',NULL,1653641032,0,0),
('sosmed_facebook','ngodingin.indonesia',NULL,1653641032,0,0),
('sosmed_ig','ngodingin.indonesia',NULL,1653641032,0,0),
('sosmed_twitter','ngodingin.indonesia',NULL,1653641032,0,0),
('sosmed_yt','ngodingin.indonesia',NULL,1653641032,0,0),
('upload_size','5',NULL,1653641032,0,0),
('upload_type','{\"pdf\":true,\"jpg\":true,\"jpeg\":true,\"png\":true,\"docx\":true,\"pptx\":true,\"xlsx\":true}',NULL,1653641032,0,0),
('web_alamat','Indonesia',NULL,1653641032,0,0),
('web_desc','<p>This is Base Project Template</p>\r\n',NULL,1653641032,0,0),
('web_email','ngodingin.indonesia@gmail.com',NULL,0,0,0),
('web_icon','assets/images/icon.png',NULL,1653641032,0,0),
('web_logo','assets/images/logo.png',NULL,1653641032,0,0),
('web_logo_white','assets/images/logo.png',NULL,0,0,0),
('web_telepon','+6285173386622 ',NULL,1653641032,0,0),
('web_title','Vepay.id',NULL,1653641032,0,0);

/*Table structure for table `tb_token` */

DROP TABLE IF EXISTS `tb_token`;

CREATE TABLE `tb_token` (
  `id_token` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(15) NOT NULL,
  `key` varchar(255) NOT NULL,
  `type` int(5) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: inactive, 1: active',
  `date_created` int(20) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_token`)
) ENGINE=InnoDB AUTO_INCREMENT=927 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_token` */

insert  into `tb_token`(`id_token`,`user_id`,`key`,`type`,`status`,`date_created`) values 
(926,'USR-MHNDR-d8eb4','78253f7a4758ed55eddc67040285fba5c58d38352588c1ef31cd55e308b07c1acf288e4e161bda0ce700056da2b9557c7ddd356d44dcb51bb20d7e9746ea5b90rzKAYCGNxousYtFN92QFVOeFnfA0MmfFMnRsZ5OV/9Y=',1,1,1668961722);

/*Table structure for table `tb_token_type` */

DROP TABLE IF EXISTS `tb_token_type`;

CREATE TABLE `tb_token_type` (
  `ID_TYPE` int(10) NOT NULL AUTO_INCREMENT,
  `TYPE` int(10) NOT NULL,
  `KETERANGAN` text DEFAULT NULL,
  PRIMARY KEY (`ID_TYPE`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_token_type` */

insert  into `tb_token_type`(`ID_TYPE`,`TYPE`,`KETERANGAN`) values 
(1,1,'Proses verifikasi email'),
(2,2,'Permintaan link recovery password');

/*Table structure for table `tb_transaksi` */

DROP TABLE IF EXISTS `tb_transaksi`;

CREATE TABLE `tb_transaksi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(255) DEFAULT NULL,
  `user_id` varchar(15) NOT NULL DEFAULT '0',
  `m_metode_id` int(11) DEFAULT 0,
  `remarks` varchar(255) DEFAULT NULL,
  `account` varchar(255) DEFAULT NULL COMMENT 'no rek/email',
  `notes` text DEFAULT NULL COMMENT '1: pending; 2: success; 3: terminated/reject; 4: cancel; 5: expired',
  `bukti` varchar(255) DEFAULT NULL,
  `sub_total` int(11) NOT NULL DEFAULT 0,
  `status` int(5) DEFAULT 1 COMMENT '1: pending; 2: success; 3: rejected; 4: expired',
  `created_at` int(11) NOT NULL DEFAULT 0,
  `created_by` varchar(15) NOT NULL DEFAULT '0',
  `modified_at` int(11) NOT NULL DEFAULT 0,
  `modified_by` varchar(15) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

/*Data for the table `tb_transaksi` */

insert  into `tb_transaksi`(`id`,`kode`,`user_id`,`m_metode_id`,`remarks`,`account`,`notes`,`bukti`,`sub_total`,`status`,`created_at`,`created_by`,`modified_at`,`modified_by`,`is_deleted`) values 
(18,'zdjpBKalV0','USR-MHNDR-d8eb4',2,NULL,'tsst','adawdad','berkas/transaction/12/2022/1671510837.jpg',109995,1,1671510837,'1',0,'0',0),
(19,'zQhkBLWE51','USR-MHNDR-d8eb4',2,NULL,'tsst','adawdad','berkas/transaction/12/2022/1671510867.jpg',109995,1,1671510867,'1',0,'0',0);

/*Table structure for table `tb_user` */

DROP TABLE IF EXISTS `tb_user`;

CREATE TABLE `tb_user` (
  `user_id` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `tb_user` */

insert  into `tb_user`(`user_id`,`name`,`gender`,`address`,`phone`) values 
('1','Super Admin',NULL,NULL,NULL),
('2','Admin',NULL,NULL,NULL),
('USR-MHNDR-d8eb4','Mahendra Dwi Purwanto','Laki-laki','Singosari\r\nCandirenggo','85785111746');

/*Table structure for table `tb_vcc` */

DROP TABLE IF EXISTS `tb_vcc`;

CREATE TABLE `tb_vcc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(15) DEFAULT NULL,
  `number` varchar(50) DEFAULT NULL,
  `holder` varchar(50) DEFAULT NULL,
  `valid_date` varchar(5) DEFAULT NULL,
  `security_code` varchar(255) DEFAULT NULL,
  `status` int(5) NOT NULL DEFAULT 1,
  `created_at` int(11) NOT NULL DEFAULT 0,
  `created_by` varchar(15) NOT NULL DEFAULT '0',
  `modified_at` int(11) NOT NULL DEFAULT 0,
  `modified_by` varchar(15) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tb_vcc` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

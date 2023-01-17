-- Adminer 4.8.1 MySQL 5.5.5-10.3.34-MariaDB-cll-lve dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `m_categories` (`id`, `categories`, `description`, `created_at`, `created_by`, `modified_at`, `modified_by`, `is_deleted`) VALUES
(1,	'Topup',	'',	1671518688,	'2',	0,	'0',	0),
(2,	'Withdraw',	'',	1671518695,	'2',	0,	'0',	0);

DROP TABLE IF EXISTS `m_metode`;
CREATE TABLE `m_metode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `metode` varchar(25) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `no_rekening` varchar(255) DEFAULT NULL,
  `atas_nama` varchar(255) DEFAULT NULL,
  `created_at` int(11) NOT NULL DEFAULT 0,
  `created_by` varchar(15) NOT NULL DEFAULT '0',
  `modified_at` int(11) NOT NULL DEFAULT 0,
  `modified_by` varchar(15) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `m_metode` (`id`, `metode`, `image`, `description`, `no_rekening`, `atas_nama`, `created_at`, `created_by`, `modified_at`, `modified_by`, `is_deleted`) VALUES
(1,	'Bank BCA',	'berkas/metode/12/2022/1671518993.jpg',	'tes',	'017218192738191',	'VEPAY TEKNOLOGI INDONESIA',	1671519061,	'2',	0,	'0',	0);

DROP TABLE IF EXISTS `m_price`;
CREATE TABLE `m_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `m_product_id` int(11) DEFAULT NULL,
  `type` varchar(25) DEFAULT 'Top Up',
  `price` int(11) NOT NULL DEFAULT 0,
  `fee` double DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` int(11) NOT NULL DEFAULT 0,
  `created_by` varchar(15) NOT NULL DEFAULT '0',
  `modified_at` int(11) NOT NULL DEFAULT 0,
  `modified_by` varchar(15) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `m_price` (`id`, `m_product_id`, `type`, `price`, `fee`, `status`, `created_at`, `created_by`, `modified_at`, `modified_by`, `is_deleted`) VALUES
(1,	1,	'Top Up',	15000,	5,	1,	1671519049,	'2',	0,	'0',	0),
(2,	2,	'Top Up',	14000,	2,	1,	1673319214,	'2',	0,	'0',	0),
(3,	3,	'Top Up',	16000,	5,	1,	1673319831,	'2',	0,	'0',	0),
(4,	4,	'Top Up',	13000,	2,	0,	1673319857,	'2',	0,	'0',	0),
(5,	4,	'Top Up',	15000,	3,	0,	1673511191,	'2',	0,	'0',	0),
(6,	4,	'Top Up',	15500,	0,	1,	1673511211,	'2',	0,	'0',	0);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `m_product` (`id`, `m_categories_id`, `name`, `image`, `description`, `created_at`, `created_by`, `modified_at`, `modified_by`, `is_deleted`) VALUES
(1,	1,	'PayPal',	'berkas/product/01/2023/1672570274.jpg',	'',	1671519031,	'2',	1672570274,	'2',	0),
(2,	1,	'Skrill',	'berkas/product/01/2023/1673319203.jpg',	'',	1673319203,	'2',	0,	'',	0),
(3,	1,	'Perfect Money',	'berkas/product/01/2023/1673319822.jpg',	'',	1673319822,	'2',	0,	'',	0),
(4,	1,	'Payeer',	'berkas/product/01/2023/1673319844.jpg',	'',	1673319844,	'2',	0,	'',	0);

SET NAMES utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `m_promo` (`id`, `kode`, `nama`, `image`, `value`, `expired`, `quota`, `jenis`, `status`, `created_at`, `created_by`, `modified_at`, `modified_by`, `is_deleted`) VALUES
(1,	'G3434',	'Diskon',	'berkas/promo/12/2022/1671519375.jpg',	10,	1672246800,	5,	2,	1,	1671519375,	'2',	0,	'0',	0);

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

INSERT INTO `tb_auth` (`user_id`, `username`, `email`, `password`, `role`, `status`, `online`, `device`, `log_time`, `created_at`, `is_deleted`) VALUES
('1',	'ngodingin',	'ngodingin.indonesia@gmail.com',	'$2y$10$1hg1pDmFo9NYLXLuKxr86.qZpBwWcFo.gQgLLye5Hsk9VXmZqdW12',	0,	1,	1,	'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',	1673508850,	1668947154,	0),
('2',	'admin',	'admin@vepay.id',	'$2y$10$1hg1pDmFo9NYLXLuKxr86.qZpBwWcFo.gQgLLye5Hsk9VXmZqdW12',	1,	1,	1,	'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36',	1673511129,	1668947154,	0),
('USR-HNDRT-8a02b',	NULL,	'hendraeunda@gmail.com',	'$2y$10$H5wiAqIwC8IlFSxHkxboauCrB7Q9YL7M/znbR6RzkAmGRi3q5xopi',	2,	1,	1,	'Dart/2.18 (dart:io)',	1673511497,	1672656052,	0),
('USR-MHNDR-bef45',	NULL,	'mahendradwipurwanto@gmail.com',	'$2y$10$zwWrc70lMY/2IhXCp2zMGeZo886G74zP9l6BDC250Xe3IKTZ0Z9MK',	2,	1,	1,	'PostmanRuntime/7.30.0',	1673505130,	1672713499,	0),
('USR-SHNDR-561b2',	NULL,	'hendrapolover@gmail.com',	'$2y$10$rUieGdtONLB4QNgQq6sMcOYNBschI5/j/eBfj6aLtalmUabpjy2cS',	2,	1,	0,	NULL,	0,	1671518827,	0),
('USR-TST-593d8c',	NULL,	'test123@email.co',	'$2y$10$u4SnwguLZntYoNHTsodo3OT.B537CieRpmobdinINtZd0bx2dK3Yi',	2,	1,	1,	'Dart/2.18 (dart:io)',	1673314049,	1672670497,	0);

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

INSERT INTO `tb_settings` (`key`, `value`, `desc`, `created_at`, `modified_at`, `is_deleted`) VALUES
('bypass_otp',	'true',	NULL,	1653641032,	0,	0),
('mailer_alias',	'Vepay.id',	NULL,	1653641032,	0,	0),
('mailer_connection',	'tls',	NULL,	1653641032,	0,	0),
('mailer_host',	'smtp.googlemail.com',	NULL,	1653641032,	0,	0),
('mailer_mode',	'0',	NULL,	1653641032,	0,	0),
('mailer_password',	'nosppitscteyfsqq',	NULL,	1653641032,	0,	0),
('mailer_port',	'587',	NULL,	1653641032,	0,	0),
('mailer_smtp',	'1',	NULL,	1653641032,	0,	0),
('mailer_username',	'mail.ngodingin@gmail.com',	NULL,	1653641032,	0,	0),
('master_password',	'12344321',	NULL,	1653641032,	0,	0),
('sosmed_facebook',	'vepay.id',	NULL,	1653641032,	0,	0),
('sosmed_ig',	'vepay.id',	NULL,	1653641032,	0,	0),
('sosmed_twitter',	'vepay.id',	NULL,	1653641032,	0,	0),
('sosmed_yt',	'ngodingin.indonesia',	NULL,	1653641032,	0,	0),
('upload_size',	'5',	NULL,	1653641032,	0,	0),
('upload_type',	'{\"pdf\":true,\"jpg\":true,\"jpeg\":true,\"png\":true,\"docx\":true,\"pptx\":true,\"xlsx\":true}',	NULL,	1653641032,	0,	0),
('web_alamat',	'Indonesia',	NULL,	1653641032,	0,	0),
('web_desc',	'<p>This is Base Project Template</p>\r\n',	NULL,	1653641032,	0,	0),
('web_email',	'ngodingin.indonesia@gmail.com',	NULL,	0,	0,	0),
('web_icon',	'assets/images/icon.png',	NULL,	1653641032,	0,	0),
('web_logo',	'assets/images/logo.png',	NULL,	1653641032,	0,	0),
('web_logo_white',	'assets/images/logo.png',	NULL,	0,	0,	0),
('web_telepon',	'+6285173386622 ',	NULL,	1653641032,	0,	0),
('web_title',	'Vepay.id',	NULL,	1653641032,	0,	0);

DROP TABLE IF EXISTS `tb_token`;
CREATE TABLE `tb_token` (
  `id_token` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(15) NOT NULL,
  `key` varchar(255) NOT NULL,
  `type` int(5) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: inactive, 1: active',
  `date_created` int(20) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tb_token` (`id_token`, `user_id`, `key`, `type`, `status`, `date_created`) VALUES
(1,	'USR-SHNDR-561b2',	'0dca929dde76dda0950cb78cf93f804efd54618329bc8e439ec469061ad7e2b56cd97eb4b6ab8ce3426f82cab7e00b714e78c3e87a7ce33e1faa452af0f4d1b32YpZx74U0Ixw3UQ2kGjyTrdyl6EKGZHKwBo3I4yzoIM=',	1,	1,	1671518827),
(2,	'USR-HNDRT-8a02b',	'9994e404497e4042c3a557c98186c2500435fa23be4a4f62729668c831896ed88c4200e82960e29f7a335cf0ad830bc5dd0301e85c9607dc4fcb652f46324d9a723q/Dbm2yLEyZ1xBZGwCP1cHt0rukCe5Lrh6pGTXGk=',	1,	1,	1672656052),
(4,	'USR-TST-593d8c',	'c7a947c3ec9170654ff6c6cac8a97eab44988a8d74d2fbff3b00d67a6bd954f28d7827d797c60d0948a6440765d07708cb9565362208023993508b436bd7f06e+qqFxN0B52F6+0yGethUgAVTQIQ0bIwHUfZ/0q+w0Aw=',	1,	1,	1672670497),
(23,	'USR-MHNDR-bef45',	'83ecb79414ff3ec38ea8bbdfca5a177e5f28b58e8ec5396d9106ea6e959b9b6de865fb4031bb65c2633555f91c1d10044e4e5f23ce797b45341f4e827785833e+9gQR++aId8syEHOrnV4JsEx5Uf+sCSF+vB1GBHOnV4=',	1,	1,	1672713499);

DROP TABLE IF EXISTS `tb_token_type`;
CREATE TABLE `tb_token_type` (
  `ID_TYPE` int(10) NOT NULL AUTO_INCREMENT,
  `TYPE` int(10) NOT NULL,
  `KETERANGAN` text DEFAULT NULL,
  PRIMARY KEY (`ID_TYPE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `tb_transaksi` (`id`, `kode`, `user_id`, `m_metode_id`, `remarks`, `account`, `notes`, `bukti`, `sub_total`, `status`, `created_at`, `created_by`, `modified_at`, `modified_by`, `is_deleted`) VALUES
(18,	'zdjpBKalV0',	'USR-MHNDR-d8eb4',	2,	NULL,	'tsst',	'adawdad',	'berkas/transaction/12/2022/1671510837.jpg',	109995,	1,	1671510837,	'1',	0,	'0',	0),
(19,	'zQhkBLWE51',	'USR-MHNDR-d8eb4',	2,	NULL,	'tsst',	'adawdad',	'berkas/transaction/12/2022/1671510867.jpg',	109995,	1,	1671510867,	'1',	0,	'0',	0),
(20,	'mOQM4TD0Qp',	'USR-SHNDR-561b2',	1,	NULL,	'testakun',	'tes',	'berkas/transaction/12/2022/1671519257.jpg',	300000000,	1,	1671519257,	'2',	0,	'0',	0),
(25544417,	'fbBYSStXHz',	'USR-HNDRT-8a02b',	1,	NULL,	NULL,	NULL,	'berkas/user//transaksi/25544417/63bfbc3ccd1cf.',	63000,	1,	1673509940,	'USR-HNDRT-8a02b',	1673509948,	'',	0),
(104218865,	'nIvFmUwltA',	'USR-HNDRT-8a02b',	1,	NULL,	NULL,	NULL,	NULL,	20000,	1,	1673506948,	'0',	0,	'0',	0),
(108707124,	'ddFGqoLqmn',	'USR-MHNDR-d8eb4',	2,	NULL,	NULL,	NULL,	NULL,	15999,	1,	1673506948,	'0',	0,	'0',	0),
(234282764,	'Y5FIxhTdlr',	'USR-HNDRT-8a02b',	1,	NULL,	NULL,	NULL,	NULL,	63000,	1,	1673510016,	'USR-HNDRT-8a02b',	0,	'0',	0),
(251454862,	'AgXQkDj0iK',	'USR-MHNDR-d8eb4',	1,	NULL,	NULL,	NULL,	'berkas/user/USR-MHNDR-bef45/transaksi/251454862/63bfaed08b067.jpeg',	15999,	1,	1673506442,	'0',	0,	'0',	0),
(255250829,	'hWVTN0qArS',	'USR-HNDRT-8a02b',	1,	NULL,	NULL,	NULL,	NULL,	126000,	1,	1673506948,	'0',	0,	'0',	0),
(331509768,	'rSYy6emYuM',	'USR-HNDRT-8a02b',	1,	NULL,	NULL,	NULL,	'berkas/user//transaksi/331509768/63bfbcf403658.',	63000,	1,	1673510124,	'USR-HNDRT-8a02b',	1673510132,	'',	0),
(362396531,	'Z31QlWNQgu',	'USR-MHNDR-d8eb4',	2,	NULL,	NULL,	NULL,	NULL,	15999,	1,	1673506948,	'0',	0,	'0',	0),
(373495913,	'Cnsq6S6sic',	'USR-MHNDR-d8eb4',	2,	NULL,	NULL,	NULL,	NULL,	15999,	1,	1673506948,	'0',	0,	'0',	0),
(378791459,	'GwwgznoCWt',	'USR-MHNDR-d8eb4',	1,	NULL,	NULL,	NULL,	NULL,	15999,	1,	1673506407,	'0',	0,	'0',	0),
(395606896,	'mmtUbww6h2',	'USR-HNDRT-8a02b',	1,	NULL,	NULL,	NULL,	'berkas/user/USR-HNDRT-8a02b/transaksi/395606896/63bfbcc961dc4.jpeg',	63000,	1,	1673510040,	'USR-HNDRT-8a02b',	1673510089,	'',	0),
(610574368,	'p3JKF69lrM',	'USR-HNDRT-8a02b',	1,	NULL,	NULL,	NULL,	NULL,	141750,	1,	1673506450,	'0',	0,	'0',	0),
(639971111,	'WqUWmEsN6L',	'USR-MHNDR-d8eb4',	2,	NULL,	NULL,	NULL,	NULL,	15999,	1,	1673506948,	'0',	0,	'0',	0),
(726124694,	'LZHfrFHivF',	'USR-MHNDR-d8eb4',	1,	NULL,	NULL,	NULL,	NULL,	15999,	1,	1673506948,	'0',	0,	'0',	0),
(732950791,	'UlQxYHvD01',	'USR-MHNDR-d8eb4',	2,	NULL,	NULL,	NULL,	NULL,	15999,	1,	1673506948,	'0',	0,	'0',	0),
(734197487,	'FHVWmUCxgc',	'USR-MHNDR-d8eb4',	2,	NULL,	NULL,	NULL,	NULL,	15999,	1,	1673506948,	'0',	0,	'0',	0),
(796014352,	'VkGWW3HMn7',	'USR-MHNDR-d8eb4',	2,	NULL,	NULL,	NULL,	NULL,	15999,	1,	1673506948,	'0',	0,	'0',	0),
(804986353,	'p9x3dhWkMp',	'USR-MHNDR-d8eb4',	2,	NULL,	NULL,	NULL,	NULL,	15999,	1,	1673506948,	'0',	0,	'0',	0),
(833732000,	'F6Vyl2NmaJ',	'USR-HNDRT-8a02b',	1,	NULL,	NULL,	NULL,	'berkas/user//transaksi/833732000/63bfc53047bb1.jpeg',	1575000,	2,	1673512222,	'USR-HNDRT-8a02b',	1673512357,	'2',	0),
(836394982,	'eFExgkT2TD',	'USR-MHNDR-d8eb4',	2,	NULL,	NULL,	NULL,	NULL,	15999,	1,	1673506948,	'0',	0,	'0',	0),
(930065648,	'fRLgM31ui9',	'USR-HNDRT-8a02b',	1,	NULL,	NULL,	NULL,	NULL,	15999,	1,	1673506948,	'0',	0,	'0',	0),
(936430807,	'mO90FG0F8O',	'USR-HNDRT-8a02b',	1,	NULL,	NULL,	NULL,	'berkas/user/USR-HNDRT-8a02b/transaksi/936430807/63bfb9fcccfbc.jpeg',	31500,	1,	1673509104,	'USR-HNDRT-8a02b',	1673509372,	'',	0),
(951857451,	'uelli3r0UT',	'USR-HNDRT-8a02b',	1,	NULL,	NULL,	NULL,	'berkas/user//transaksi/951857451/63bfbd2f4c9b6.jpeg',	15750,	1,	1673510184,	'USR-HNDRT-8a02b',	1673510191,	'',	0),
(965322337,	'sUI6l4TDGP',	'USR-HNDRT-8a02b',	1,	NULL,	NULL,	NULL,	NULL,	50400,	1,	1673508391,	'USR-HNDRT-8a02b',	0,	'0',	0),
(998057808,	'LSvtWe2cMF',	'USR-HNDRT-8a02b',	1,	NULL,	NULL,	NULL,	'berkas/user//transaksi/998057808/63bfbd6deb3b2.jpeg',	110250,	1,	1673510246,	'USR-HNDRT-8a02b',	1673510253,	'',	0);

DROP TABLE IF EXISTS `tb_user`;
CREATE TABLE `tb_user` (
  `user_id` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthdate` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tb_user` (`user_id`, `name`, `photo`, `gender`, `birthdate`, `address`, `phone`) VALUES
('1',	'Super Admin',	NULL,	NULL,	NULL,	NULL,	NULL),
('2',	'Admin',	NULL,	NULL,	NULL,	NULL,	NULL),
('USR-SHNDR-561b2',	'Suhendra',	NULL,	'Laki-laki',	'28-03-1999',	'Jln. Candi 3E No. 142 Karang Besuki',	'81350204469'),
('USR-HNDRT-8a02b',	'Hendra Test',	NULL,	NULL,	NULL,	NULL,	'081350204469'),
('USR-TST-593d8c',	'test 123',	NULL,	NULL,	NULL,	NULL,	'08112233556677'),
('USR-MHNDR-bef45',	'mahendra',	NULL,	NULL,	NULL,	NULL,	'085785111746');

DROP TABLE IF EXISTS `tb_vcc`;
CREATE TABLE `tb_vcc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(15) DEFAULT NULL,
  `number` varchar(50) DEFAULT NULL,
  `holder` varchar(50) DEFAULT NULL,
  `valid_date` varchar(5) DEFAULT NULL,
  `security_code` varchar(255) DEFAULT NULL,
  `saldo` double DEFAULT 0,
  `status` int(5) NOT NULL DEFAULT 1,
  `created_at` int(11) NOT NULL DEFAULT 0,
  `created_by` varchar(15) NOT NULL DEFAULT '0',
  `modified_at` int(11) NOT NULL DEFAULT 0,
  `modified_by` varchar(15) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `tb_vcc` (`id`, `user_id`, `number`, `holder`, `valid_date`, `security_code`, `saldo`, `status`, `created_at`, `created_by`, `modified_at`, `modified_by`, `is_deleted`) VALUES
(1,	'USR-MHNDR-d8eb4',	'5888477241',	'Mahendra Dwi Purwanto',	'04/24',	'425',	4000000,	1,	0,	'0',	0,	'0',	0);

DROP TABLE IF EXISTS `_transaksi_detail`;
CREATE TABLE `_transaksi_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaksi_id` int(11) NOT NULL,
  `m_price_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` int(11) NOT NULL DEFAULT 0,
  `total` int(11) NOT NULL DEFAULT 0,
  `created_at` int(11) NOT NULL DEFAULT 0,
  `created_by` varchar(15) NOT NULL DEFAULT '0',
  `modified_at` int(11) NOT NULL DEFAULT 0,
  `modified_by` varchar(15) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`,`transaksi_id`,`m_price_id`),
  KEY `m_price_id` (`m_price_id`),
  CONSTRAINT `_transaksi_detail_ibfk_1` FOREIGN KEY (`m_price_id`) REFERENCES `m_price` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `_transaksi_detail` (`id`, `transaksi_id`, `m_price_id`, `quantity`, `price`, `total`, `created_at`, `created_by`, `modified_at`, `modified_by`, `is_deleted`) VALUES
(1,	20,	1,	20000,	15000,	300000000,	1671519257,	'2',	0,	'0',	0),
(2,	836394982,	1,	1,	0,	15999,	0,	'0',	0,	'0',	0),
(3,	796014352,	1,	1,	0,	15999,	0,	'0',	0,	'0',	0),
(4,	362396531,	1,	1,	0,	15999,	0,	'0',	0,	'0',	0),
(5,	804986353,	1,	1,	0,	15999,	0,	'0',	0,	'0',	0),
(6,	108707124,	1,	1,	0,	15999,	0,	'0',	0,	'0',	0),
(7,	373495913,	1,	1,	0,	15999,	0,	'0',	0,	'0',	0),
(8,	639971111,	1,	1,	0,	15999,	0,	'0',	0,	'0',	0),
(9,	734197487,	1,	1,	0,	15999,	0,	'0',	0,	'0',	0),
(10,	732950791,	1,	1,	0,	15999,	0,	'0',	0,	'0',	0),
(11,	726124694,	1,	1,	0,	15999,	0,	'0',	0,	'0',	0),
(12,	930065648,	4,	1,	0,	15999,	0,	'0',	0,	'0',	0),
(13,	104218865,	4,	2,	0,	20000,	0,	'0',	0,	'0',	0),
(14,	255250829,	1,	8,	0,	126000,	0,	'0',	0,	'0',	0),
(15,	378791459,	1,	1,	0,	15000,	1673506407,	'0',	0,	'0',	0),
(16,	251454862,	1,	1,	0,	15000,	1673506442,	'0',	0,	'0',	0),
(17,	610574368,	1,	9,	0,	135000,	1673506450,	'0',	0,	'0',	0),
(18,	965322337,	3,	3,	0,	48000,	1673508391,	'USR-HNDRT-8a02b',	0,	'0',	0),
(19,	936430807,	1,	2,	0,	30000,	1673509104,	'USR-HNDRT-8a02b',	0,	'0',	0),
(20,	25544417,	1,	4,	0,	60000,	1673509940,	'USR-HNDRT-8a02b',	0,	'0',	0),
(21,	234282764,	1,	4,	0,	60000,	1673510016,	'USR-HNDRT-8a02b',	0,	'0',	0),
(22,	395606896,	1,	4,	0,	60000,	1673510040,	'USR-HNDRT-8a02b',	0,	'0',	0),
(23,	331509768,	1,	4,	0,	60000,	1673510124,	'USR-HNDRT-8a02b',	0,	'0',	0),
(24,	951857451,	1,	1,	0,	15000,	1673510184,	'USR-HNDRT-8a02b',	0,	'0',	0),
(25,	998057808,	1,	7,	0,	105000,	1673510246,	'USR-HNDRT-8a02b',	0,	'0',	0),
(26,	833732000,	1,	100,	0,	1500000,	1673512222,	'USR-HNDRT-8a02b',	0,	'0',	0);

-- 2023-01-17 00:26:47

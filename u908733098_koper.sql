-- MySQL dump 10.15  Distrib 10.0.14-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: u908733098_koper
-- ------------------------------------------------------
-- Server version	10.0.13-MariaDB-wsrep

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tb_admin_auth`
--

DROP TABLE IF EXISTS `tb_admin_auth`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_admin_auth` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `id_admin_grup` tinyint(4) NOT NULL DEFAULT '0',
  `id_menu_admin` smallint(6) NOT NULL DEFAULT '0',
  `modify_user_id` int(11) NOT NULL,
  `modify_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `create_user_id` int(11) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_admin_auth`
--

/*!40000 ALTER TABLE `tb_admin_auth` DISABLE KEYS */;
INSERT INTO `tb_admin_auth` VALUES (46,1,41,0,'2014-06-06 17:18:52',270611,'2014-06-06 17:18:52'),(45,1,39,0,'2014-06-06 17:18:17',270611,'2014-06-06 17:18:17'),(43,1,37,0,'2014-06-06 17:17:59',270611,'2014-06-06 17:17:59'),(44,1,38,0,'2014-06-06 17:18:07',270611,'2014-06-06 17:18:07'),(42,1,54,0,'2014-06-06 17:17:39',270611,'2014-06-06 17:17:39'),(41,1,58,0,'2014-06-06 17:17:15',270611,'2014-06-06 17:17:15'),(47,1,66,0,'2014-06-06 17:19:27',270611,'2014-06-06 17:19:27'),(40,1,28,0,'2014-06-06 17:16:53',270611,'2014-06-06 17:16:53'),(39,1,67,0,'2014-06-06 17:16:40',270611,'2014-06-06 17:16:40'),(38,1,57,0,'2014-06-06 17:16:31',270611,'2014-06-06 17:16:31'),(37,1,45,0,'2014-06-06 17:16:21',270611,'2014-06-06 17:16:21'),(35,1,42,0,'2014-06-06 17:15:27',270611,'2014-06-06 17:15:27'),(36,1,61,0,'2014-06-06 17:16:01',270611,'2014-06-06 17:16:01'),(32,1,59,0,'2014-06-06 17:14:30',270611,'2014-06-06 17:14:30'),(31,1,51,0,'2014-06-06 17:14:17',270611,'2014-06-06 17:14:17'),(30,1,50,0,'2014-06-06 17:14:05',270611,'2014-06-06 17:14:05'),(29,1,49,0,'2014-06-06 17:13:47',270611,'2014-06-06 17:13:47'),(28,1,43,0,'2014-06-06 17:12:58',270611,'2014-06-06 17:12:58'),(27,1,53,0,'2014-06-06 17:12:27',270611,'2014-06-06 17:12:27'),(26,1,1,0,'2014-06-06 17:12:15',270611,'2014-06-06 17:12:15'),(25,2,55,0,'2014-06-06 17:12:06',270611,'2014-06-06 17:12:06'),(48,1,52,0,'2014-06-06 17:19:56',270611,'2014-06-06 17:19:56'),(51,1,32,0,'2014-06-06 17:20:39',270611,'2014-06-06 17:20:39'),(50,1,48,0,'2014-06-06 17:20:15',270611,'2014-06-06 17:20:15'),(52,1,36,0,'2014-06-06 17:20:49',270611,'2014-06-06 17:20:49'),(53,1,62,0,'2014-06-06 17:20:57',270611,'2014-06-06 17:20:57'),(54,1,35,0,'2014-06-06 17:21:08',270611,'2014-06-06 17:21:08'),(55,1,60,0,'2014-06-06 17:21:21',270611,'2014-06-06 17:21:21'),(56,1,30,0,'2014-06-06 17:21:39',270611,'2014-06-06 17:21:39'),(57,1,65,0,'2014-06-06 17:21:57',270611,'2014-06-06 17:21:57'),(58,1,68,0,'2014-06-08 23:05:02',270611,'2014-06-08 23:05:02'),(59,1,69,0,'2014-06-08 23:14:00',270611,'2014-06-08 23:14:00'),(60,1,70,0,'2014-06-08 23:14:09',270611,'2014-06-08 23:14:09'),(61,1,71,0,'2014-06-08 23:14:21',270611,'2014-06-08 23:14:21');
/*!40000 ALTER TABLE `tb_admin_auth` ENABLE KEYS */;

--
-- Table structure for table `tb_admin_grup`
--

DROP TABLE IF EXISTS `tb_admin_grup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_admin_grup` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `modify_user_id` int(11) NOT NULL,
  `modify_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `create_user_id` int(11) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_admin_grup`
--

/*!40000 ALTER TABLE `tb_admin_grup` DISABLE KEYS */;
INSERT INTO `tb_admin_grup` VALUES (1,'Admin',1,'2012-05-30 00:00:00',1,'2012-05-30 00:00:00'),(2,'Karyawan',1,'2012-05-30 00:00:00',1,'2012-05-30 00:00:00'),(3,'Kasir',1,'0000-00-00 00:00:00',1,'0000-00-00 00:00:00'),(6,'Administrator',1,'0000-00-00 00:00:00',1,'0000-00-00 00:00:00');
/*!40000 ALTER TABLE `tb_admin_grup` ENABLE KEYS */;

--
-- Table structure for table `tb_config_kas`
--

DROP TABLE IF EXISTS `tb_config_kas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_config_kas` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `item` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `kas` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_config_kas`
--

/*!40000 ALTER TABLE `tb_config_kas` DISABLE KEYS */;
INSERT INTO `tb_config_kas` VALUES (1,'Penjualan',2),(2,'Simpan Pinjam',1),(3,'Pembelian',2),(4,'SHU',1);
/*!40000 ALTER TABLE `tb_config_kas` ENABLE KEYS */;

--
-- Table structure for table `tb_group_inventory`
--

DROP TABLE IF EXISTS `tb_group_inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_group_inventory` (
  `id` bigint(150) NOT NULL AUTO_INCREMENT,
  `kode_group` varchar(50) NOT NULL DEFAULT '' COMMENT 'manual ketik',
  `kode_group_parent` varchar(50) NOT NULL DEFAULT '' COMMENT 'manual ketik',
  `nama` varchar(150) DEFAULT NULL COMMENT 'manual ketik',
  `status` varchar(1) DEFAULT 'y' COMMENT 'y=> aktif n=>nonaktif',
  `masuk_oleh` int(10) NOT NULL COMMENT 'dari session id_user',
  `masuk_tgl` datetime NOT NULL,
  `edit_oleh` int(10) DEFAULT NULL,
  `edit_tgl` datetime DEFAULT NULL,
  PRIMARY KEY (`id`,`kode_group`,`kode_group_parent`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_group_inventory`
--

/*!40000 ALTER TABLE `tb_group_inventory` DISABLE KEYS */;
INSERT INTO `tb_group_inventory` VALUES (1,'GRP1','none','Grup1','y',6,'2014-04-14 23:44:04',6,'2014-04-15 00:07:55');
/*!40000 ALTER TABLE `tb_group_inventory` ENABLE KEYS */;

--
-- Table structure for table `tb_inventory`
--

DROP TABLE IF EXISTS `tb_inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_inventory` (
  `id` bigint(150) NOT NULL AUTO_INCREMENT,
  `kode_barang` varchar(50) NOT NULL COMMENT 'manual input',
  `kode_group` varchar(50) NOT NULL DEFAULT '' COMMENT 'drop down dari tb_inventori_group',
  `nama` varchar(150) DEFAULT NULL,
  `keterangan` text,
  `harga_dasar` double NOT NULL COMMENT 'harga dasar',
  `satuan` varchar(255) DEFAULT NULL,
  `jumlah` double NOT NULL COMMENT 'jumlah barang',
  `min_qty` int(11) NOT NULL,
  `status` varchar(1) NOT NULL COMMENT 'y=>aktif n=>nonaktif h=>habis',
  `masuk_oleh` int(10) unsigned NOT NULL,
  `masuk_tgl` datetime NOT NULL,
  `edit_oleh` int(10) DEFAULT NULL,
  `edit_tgl` datetime DEFAULT NULL,
  PRIMARY KEY (`id`,`kode_barang`,`kode_group`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_inventory`
--

/*!40000 ALTER TABLE `tb_inventory` DISABLE KEYS */;
INSERT INTO `tb_inventory` VALUES (1,'BRG001','GRP1','Sikat','sikat kamar mandi',50000,'BH',98,10,'y',6,'2014-04-14 23:57:07',270611,'2014-06-04 22:27:04'),(2,'BRG002','GRP1','Sapu','Sapu Terbang',100000,'BH',1,5,'y',6,'2014-04-25 04:04:35',270611,'2014-06-04 23:08:21'),(3,'BRG003','GRP1','Milkuat','Milkuat 100ml',0,'BH',228,10,'y',270611,'2014-05-14 23:42:40',270611,'2014-06-04 23:08:33');
/*!40000 ALTER TABLE `tb_inventory` ENABLE KEYS */;

--
-- Table structure for table `tb_inventory_harga`
--

DROP TABLE IF EXISTS `tb_inventory_harga`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_inventory_harga` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `kode_barang` varchar(50) NOT NULL COMMENT 'ambil dari tb_inventori',
  `tanggal` datetime NOT NULL,
  `harga_beli` double DEFAULT NULL,
  `harga_jual` double NOT NULL COMMENT 'tentukan harga jualnya',
  PRIMARY KEY (`id`,`kode_barang`,`tanggal`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_inventory_harga`
--

/*!40000 ALTER TABLE `tb_inventory_harga` DISABLE KEYS */;
INSERT INTO `tb_inventory_harga` VALUES (4,'BRG003','2014-05-14 00:00:00',1000,1200),(5,'BRG001','2014-05-15 00:00:00',13500,15000);
/*!40000 ALTER TABLE `tb_inventory_harga` ENABLE KEYS */;

--
-- Table structure for table `tb_inventory_jumlah`
--

DROP TABLE IF EXISTS `tb_inventory_jumlah`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_inventory_jumlah` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `tgl` datetime DEFAULT NULL,
  `kode_barang` varchar(50) NOT NULL,
  `stok` bigint(255) DEFAULT NULL,
  `masuk_oleh` varchar(255) DEFAULT NULL,
  `jumlah` bigint(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_inventory_jumlah`
--

/*!40000 ALTER TABLE `tb_inventory_jumlah` DISABLE KEYS */;
INSERT INTO `tb_inventory_jumlah` VALUES (2,'2014-05-28 23:25:25','BRG001',105,'Jhanojan',40);
/*!40000 ALTER TABLE `tb_inventory_jumlah` ENABLE KEYS */;

--
-- Table structure for table `tb_inventory_koreksi`
--

DROP TABLE IF EXISTS `tb_inventory_koreksi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_inventory_koreksi` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `tgl` datetime DEFAULT NULL,
  `kode_barang` varchar(50) NOT NULL,
  `stok` bigint(255) DEFAULT NULL,
  `masuk_oleh` varchar(255) DEFAULT NULL,
  `jumlah` bigint(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_inventory_koreksi`
--

/*!40000 ALTER TABLE `tb_inventory_koreksi` DISABLE KEYS */;
INSERT INTO `tb_inventory_koreksi` VALUES (4,'2014-05-29 10:27:48','BRG001',105,'Jhanojan',100);
/*!40000 ALTER TABLE `tb_inventory_koreksi` ENABLE KEYS */;

--
-- Table structure for table `tb_jabatan`
--

DROP TABLE IF EXISTS `tb_jabatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_jabatan` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `kode_jabatan` varchar(50) NOT NULL COMMENT 'manual input',
  `nama` varchar(250) NOT NULL COMMENT 'digunakan untuk jabatan karyawan',
  `status` varchar(1) DEFAULT NULL COMMENT 'y=>aktif n=>nonaktif s=>suspend',
  `masuk_oleh` int(10) NOT NULL,
  `masuk_tgl` datetime NOT NULL,
  `edit_oleh` int(10) DEFAULT NULL,
  `edit_tgl` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_jabatan`
--

/*!40000 ALTER TABLE `tb_jabatan` DISABLE KEYS */;
INSERT INTO `tb_jabatan` VALUES (1,'11','Direksi','y',0,'0000-00-00 00:00:00',6,'2014-04-14 21:20:20');
/*!40000 ALTER TABLE `tb_jabatan` ENABLE KEYS */;

--
-- Table structure for table `tb_karyawan`
--

DROP TABLE IF EXISTS `tb_karyawan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_karyawan` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `kode_karyawan` varchar(50) NOT NULL,
  `nik` varchar(150) DEFAULT NULL,
  `nama` varchar(250) NOT NULL,
  `kode_jabatan` varchar(50) NOT NULL,
  `kelamin` varchar(1) NOT NULL,
  `tmpt_lahir` varchar(150) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `agama` varchar(1) NOT NULL,
  `alamat` text NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `notel` varchar(50) NOT NULL,
  `images` text NOT NULL,
  `status` varchar(1) NOT NULL,
  `pinjamlagi` enum('n','y') DEFAULT 'n',
  `masuk_oleh` int(10) NOT NULL,
  `masuk_tgl` datetime NOT NULL,
  `edit_oleh` int(10) DEFAULT NULL,
  `edit_tgl` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_karyawan`
--

/*!40000 ALTER TABLE `tb_karyawan` DISABLE KEYS */;
INSERT INTO `tb_karyawan` VALUES (5,'1100001','123123','Handoko Susilo','1','L','sragen','1983-01-07','I','Bandung','handoko@gmail.com','02133214321','uploads/foto/medium/Handoko_Susilo20140506142658_medium-80x80.png','y','y',6,'2014-04-14 22:56:49',270611,'2014-05-15 13:22:06'),(8,'1100002','54321','Fauzan Rabbani','1','L','Jakarta','1994-09-06','I','Jl. Camar','jhanojan@gmail.com','081297555987','','y','n',270611,'2014-05-14 21:19:54',NULL,'2014-05-14 21:19:54'),(9,'1100003','443','Ridwan Hakim','1','L','Sukabumi','2001-06-12','I','Kramatjati','balabala@gmail.com','08121036451','','y','y',6,'2014-06-10 14:28:26',NULL,'2014-06-10 14:28:26');
/*!40000 ALTER TABLE `tb_karyawan` ENABLE KEYS */;

--
-- Table structure for table `tb_karyawan_rekening`
--

DROP TABLE IF EXISTS `tb_karyawan_rekening`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_karyawan_rekening` (
  `kode_karyawan` varchar(50) NOT NULL,
  `rekening` varchar(50) NOT NULL COMMENT 'di awali dengan kode koperasi=>bulan lahir=>kode urut 5  digit,kode koperasi diambil dari config bikin aja 2 digit angka asal',
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_karyawan_rekening`
--

/*!40000 ALTER TABLE `tb_karyawan_rekening` DISABLE KEYS */;
INSERT INTO `tb_karyawan_rekening` VALUES ('1100001','110100001','2014-04-14'),('1100002','110900002','2014-05-14'),('1100003','110600003','2014-06-10');
/*!40000 ALTER TABLE `tb_karyawan_rekening` ENABLE KEYS */;

--
-- Table structure for table `tb_kas`
--

DROP TABLE IF EXISTS `tb_kas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_kas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_kas` text,
  `nama` text NOT NULL,
  `value` float(100,0) NOT NULL,
  `created_on` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modify_on` datetime DEFAULT NULL,
  `modify_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_kas`
--

/*!40000 ALTER TABLE `tb_kas` DISABLE KEYS */;
INSERT INTO `tb_kas` VALUES (1,'123','Kas Utama',4017350,NULL,NULL,NULL,NULL),(2,'456','Kas Jual Beli',5182500,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `tb_kas` ENABLE KEYS */;

--
-- Table structure for table `tb_kode_koperasi`
--

DROP TABLE IF EXISTS `tb_kode_koperasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_kode_koperasi` (
  `id` bigint(50) NOT NULL AUTO_INCREMENT,
  `kode` varchar(100) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `jml_kar` int(100) NOT NULL,
  `alamat` text,
  `tlp` varchar(255) DEFAULT NULL,
  `foto` text,
  `masuk_oleh` int(11) DEFAULT NULL,
  `masuk_tgl` datetime DEFAULT NULL,
  `edit_oleh` int(11) DEFAULT NULL,
  `edit_tgl` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_kode_koperasi`
--

/*!40000 ALTER TABLE `tb_kode_koperasi` DISABLE KEYS */;
INSERT INTO `tb_kode_koperasi` VALUES (1,'11','Koperasi Frisian Flag Indonesia',3,'Jl. Raya Bogor, Pasar Rebo, Jakarta Timur','02183324252','Logo_Koperasi_thumb.jpg',6,NULL,270611,'2014-05-24 18:43:26');
/*!40000 ALTER TABLE `tb_kode_koperasi` ENABLE KEYS */;

--
-- Table structure for table `tb_menu_admin`
--

DROP TABLE IF EXISTS `tb_menu_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_menu_admin` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `id_parents` smallint(6) NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `filez` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `sort` smallint(6) NOT NULL DEFAULT '100',
  `is_publish` enum('Publish','NotPublish') COLLATE latin1_general_ci NOT NULL DEFAULT 'Publish',
  `edit_oleh` int(11) NOT NULL,
  `edit_tgl` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `masuk_oleh` int(11) NOT NULL,
  `masuk_tgl` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=72 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_menu_admin`
--

/*!40000 ALTER TABLE `tb_menu_admin` DISABLE KEYS */;
INSERT INTO `tb_menu_admin` VALUES (1,0,'Dashboard','dashboard',1,'Publish',6,'2014-04-14 20:59:03',1,'2012-01-31 13:23:13'),(28,0,'Pengaturan','#',100,'Publish',1,'0000-00-00 00:00:00',1,'0000-00-00 00:00:00'),(32,28,'Nama Koperasi','kode_koperasi',100,'Publish',270611,'2014-05-18 18:06:52',1,'0000-00-00 00:00:00'),(30,62,'Akun Pengguna','akun_admin',100,'Publish',270611,'2014-05-24 17:34:19',1,'0000-00-00 00:00:00'),(31,28,'Manage Auth','manage_auth',100,'Publish',1,'0000-00-00 00:00:00',1,'0000-00-00 00:00:00'),(33,28,'Manage Menu','manage_menu',100,'Publish',1,'0000-00-00 00:00:00',1,'0000-00-00 00:00:00'),(35,62,'Data Karyawan','ms_kar',1,'Publish',270611,'2014-05-23 16:16:52',6,'2014-04-14 21:07:45'),(36,28,'Jabatan','jabatan',100,'Publish',6,'2014-04-14 21:15:52',6,'2014-04-14 21:11:29'),(37,0,'Inventory','#',7,'Publish',270611,'2014-05-24 17:24:57',6,'2014-04-14 23:18:28'),(38,37,'Grup Inventory','grup_inventory',1,'Publish',6,'2014-04-14 23:19:41',6,'2014-04-14 23:18:53'),(39,37,'Inventory','inventory',2,'Publish',0,'2014-04-14 23:19:22',6,'2014-04-14 23:19:22'),(40,37,'Kontrol Harga','harga_inventory',3,'Publish',0,'2014-04-14 23:21:19',6,'2014-04-14 23:21:19'),(41,37,'Stok Opname','stok_inventory',4,'Publish',270611,'2014-05-28 21:52:01',6,'2014-04-14 23:21:37'),(42,0,'Catatan Transaksi','#',6,'Publish',270611,'2014-05-24 17:24:09',6,'2014-04-15 18:29:49'),(43,42,'Simpan Pinjam','simpan_pinjam',1,'Publish',0,'2014-04-15 18:30:05',6,'2014-04-15 18:30:05'),(55,0,'Profil Karyawan','profil_karyawan',100,'Publish',270611,'2014-05-13 16:56:26',270611,'2014-05-13 16:07:03'),(45,42,'Penjualan','penjualan',3,'Publish',0,'2014-04-15 18:33:51',6,'2014-04-15 18:33:51'),(54,57,'Kas','ms_kas',4,'Publish',270611,'2014-05-18 23:17:46',270611,'2014-05-09 16:53:42'),(47,42,'SHU','shu',5,'Publish',270611,'2014-05-24 17:25:57',6,'2014-04-15 18:37:35'),(48,28,'PPN','ppn',6,'Publish',0,'2014-04-15 21:51:06',6,'2014-04-15 21:51:06'),(49,0,'Simpan Pinjam','#',1,'Publish',0,'2014-04-15 23:23:35',6,'2014-04-15 23:23:35'),(50,49,'Simpan/Pinjam Form','simpan_pinjam_form',1,'Publish',0,'2014-04-15 23:24:12',6,'2014-04-15 23:24:12'),(51,49,'Pembayaran Angsuran','pembayaran',2,'Publish',0,'2014-04-15 23:25:35',6,'2014-04-15 23:25:35'),(52,28,'Tipe Simpan Pinjam','tipe_simpan_pinjam',1,'Publish',0,'2014-04-15 23:26:55',6,'2014-04-15 23:26:55'),(53,0,'POS','pos_app',1,'Publish',0,'2014-04-24 18:17:05',6,'2014-04-24 18:17:05'),(57,0,'KAS','#',6,'Publish',270611,'2014-05-24 17:29:58',270611,'2014-05-18 23:17:00'),(58,57,'Pengaturan','kas_config',2,'Publish',0,'2014-05-18 23:18:17',270611,'2014-05-18 23:18:17'),(59,0,'Pembelian','buyout',4,'Publish',270611,'2014-05-24 11:15:01',270611,'2014-05-23 16:12:06'),(60,62,'Daftar Supplier','ms_supplier',1,'Publish',270611,'2014-05-23 17:33:12',270611,'2014-05-23 16:12:35'),(61,42,'Catatan Pembelian','pembelian',2,'Publish',270611,'2014-05-24 13:40:06',270611,'2014-05-23 16:14:43'),(62,0,'Data Master','#',100,'Publish',0,'2014-05-23 16:16:16',270611,'2014-05-23 16:16:16'),(63,0,'SHU','shu_form',5,'Publish',270611,'2014-05-28 14:55:25',270611,'2014-05-24 17:27:15'),(64,28,'Persentasi SHU','persen_shu',1,'Publish',0,'2014-05-24 17:35:25',270611,'2014-05-24 17:35:25'),(65,0,'Report','report',100,'Publish',0,'2014-05-28 11:48:12',270611,'2014-05-28 11:48:12'),(66,37,'Koreksi Stok','koreksi_stok',5,'Publish',0,'2014-05-29 10:18:33',270611,'2014-05-29 10:18:33'),(67,57,'Debit/Kredit','debit_kredit_kas',1,'Publish',0,'2014-06-05 14:34:56',270611,'2014-06-05 14:34:56'),(68,0,'GRAPH','#',101,'Publish',270611,'2014-06-08 22:35:43',270611,'2014-06-08 22:32:13'),(69,68,'Penjualan','graph_penjualan',1,'Publish',0,'2014-06-08 22:36:15',270611,'2014-06-08 22:36:15'),(70,68,'Laba','graph_laba',2,'Publish',0,'2014-06-08 22:36:36',270611,'2014-06-08 22:36:36'),(71,68,'Pinjaman','graph_pinjaman',3,'Publish',0,'2014-06-08 22:36:54',270611,'2014-06-08 22:36:54');
/*!40000 ALTER TABLE `tb_menu_admin` ENABLE KEYS */;

--
-- Table structure for table `tb_pembelian`
--

DROP TABLE IF EXISTS `tb_pembelian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_pembelian` (
  `id` bigint(50) NOT NULL AUTO_INCREMENT,
  `id_pembelian` varchar(150) DEFAULT NULL,
  `tanggal` datetime NOT NULL,
  `kasir` varchar(100) NOT NULL,
  `id_supplier` bigint(255) DEFAULT NULL,
  `bunga` tinyint(3) DEFAULT NULL COMMENT 'kalo kredit wajib isi',
  `ppn` tinyint(3) DEFAULT NULL COMMENT 'ambil dari config',
  `diskon` tinyint(3) DEFAULT NULL COMMENT 'manual input',
  `sub_total` double NOT NULL COMMENT 'jumlah keseluruhan sebelum di kurang ppn dan diskon',
  `total` double NOT NULL DEFAULT '0' COMMENT 'jumlah keseluruhan',
  `status` varchar(1) NOT NULL COMMENT 'l=>lunas b=>belum lunas',
  PRIMARY KEY (`id`,`tanggal`,`kasir`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_pembelian`
--

/*!40000 ALTER TABLE `tb_pembelian` DISABLE KEYS */;
INSERT INTO `tb_pembelian` VALUES (4,'112805-14-00001','2014-05-28 21:42:02','jhanojan',1,NULL,0,0,65000,65000,''),(5,'110406-14-00001','2014-06-04 00:00:00','admin',1,NULL,0,0,10000,10000,'');
/*!40000 ALTER TABLE `tb_pembelian` ENABLE KEYS */;

--
-- Table structure for table `tb_pembelian_detail`
--

DROP TABLE IF EXISTS `tb_pembelian_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_pembelian_detail` (
  `id_pembelian` varchar(255) NOT NULL COMMENT 'ambil dari penjualan',
  `kode_group` varchar(50) NOT NULL DEFAULT '0' COMMENT 'ambil dari inventori_detail',
  `kode_barang` varchar(50) NOT NULL DEFAULT '0' COMMENT 'ambil dari inventori',
  `jumlah` int(5) NOT NULL DEFAULT '0',
  `satuan` int(5) NOT NULL DEFAULT '0' COMMENT 'harga satuan',
  `total` int(5) NOT NULL DEFAULT '0',
  KEY `id_penjualan` (`id_pembelian`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_pembelian_detail`
--

/*!40000 ALTER TABLE `tb_pembelian_detail` DISABLE KEYS */;
INSERT INTO `tb_pembelian_detail` VALUES ('112805-14-00001','GRP1','BRG001',1,15000,15000),('112805-14-00001','GRP1','BRG002',1,50000,50000);
/*!40000 ALTER TABLE `tb_pembelian_detail` ENABLE KEYS */;

--
-- Table structure for table `tb_penjualan`
--

DROP TABLE IF EXISTS `tb_penjualan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_penjualan` (
  `id` bigint(50) NOT NULL AUTO_INCREMENT,
  `id_penjualan` varchar(150) DEFAULT NULL,
  `tanggal` datetime NOT NULL,
  `kasir` varchar(100) NOT NULL,
  `tipe_pembayaran` enum('kredit','cash') NOT NULL COMMENT 'tipe cash / kredit',
  `id_karyawan` varchar(50) DEFAULT '' COMMENT 'kalo kredit wajib isi',
  `jangka_waktu` tinyint(2) DEFAULT NULL COMMENT 'kalo kredit wajib isi',
  `bunga` tinyint(3) DEFAULT NULL COMMENT 'kalo kredit wajib isi',
  `ppn` tinyint(3) DEFAULT NULL COMMENT 'ambil dari config',
  `diskon` tinyint(3) DEFAULT NULL COMMENT 'manual input',
  `sub_total` double NOT NULL COMMENT 'jumlah keseluruhan sebelum di kurang ppn dan diskon',
  `total` double NOT NULL DEFAULT '0' COMMENT 'jumlah keseluruhan',
  `status` varchar(1) NOT NULL COMMENT 'l=>lunas b=>belum lunas',
  `kas` int(255) DEFAULT NULL,
  PRIMARY KEY (`id`,`tanggal`,`kasir`,`tipe_pembayaran`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_penjualan`
--

/*!40000 ALTER TABLE `tb_penjualan` DISABLE KEYS */;
INSERT INTO `tb_penjualan` VALUES (2,'112005-14-00002','2014-05-20 18:21:15','Jhanojan','kredit','',NULL,NULL,10,NULL,16200,23100,'b',NULL),(3,'112005-14-00003','2014-05-20 18:23:10','Jhanojan','kredit','',NULL,NULL,10,NULL,16200,23100,'b',NULL),(4,'112005-14-00001','2014-05-20 18:48:58','Jhanojan','cash','1100001',NULL,NULL,10,NULL,16200,19140,'l',NULL),(5,'112405-14-00001','2014-05-20 18:52:00','Jhanojan','kredit','',NULL,NULL,10,NULL,16200,148500,'b',NULL),(9,'112805-14-00001','2014-05-28 15:23:42','Jhanojan','cash','',NULL,NULL,10,NULL,15000,16500,'l',2),(10,'110606-14-00001','2014-06-06 06:38:53','Jhanojan','cash','',NULL,NULL,10,NULL,15000,16500,'l',2),(11,'110606-14-00002','2014-06-06 06:46:58','Jhanojan','cash','54321',NULL,NULL,10,NULL,15000,16500,'l',2),(12,'110606-14-00003','2014-06-06 11:51:32','Jhanojan','cash','54321',NULL,NULL,10,NULL,180000,198000,'l',2);
/*!40000 ALTER TABLE `tb_penjualan` ENABLE KEYS */;

--
-- Table structure for table `tb_penjualan_detail`
--

DROP TABLE IF EXISTS `tb_penjualan_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_penjualan_detail` (
  `id_penjualan` varchar(255) NOT NULL COMMENT 'ambil dari penjualan',
  `kode_group` varchar(50) NOT NULL DEFAULT '0' COMMENT 'ambil dari inventori_detail',
  `kode_barang` varchar(50) NOT NULL DEFAULT '0' COMMENT 'ambil dari inventori',
  `jumlah` int(5) NOT NULL DEFAULT '0',
  `beli` int(11) DEFAULT NULL,
  `satuan` int(11) NOT NULL DEFAULT '0' COMMENT 'harga satuan',
  `total` int(11) NOT NULL DEFAULT '0',
  `laba` int(11) DEFAULT NULL,
  KEY `id_penjualan` (`id_penjualan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_penjualan_detail`
--

/*!40000 ALTER TABLE `tb_penjualan_detail` DISABLE KEYS */;
INSERT INTO `tb_penjualan_detail` VALUES ('112005-14-00001','GRP1','BRG001',1,NULL,15000,15000,1000),('112005-14-00001','GRP1','BRG003',2,NULL,1200,2400,20000),('112005-14-00001','GRP1','BRG001',1,NULL,15000,15000,3000),('112005-14-00001','GRP1','BRG003',100,NULL,1200,120000,3000),('112405-14-00001','GRP1','BRG001',100,NULL,14000,1400000,4000),('112405-14-00001','GRP1','BRG001',100,NULL,14000,1400000,3000),('112805-14-00001','GRP1','BRG001',1,NULL,15000,15000,3000),('110606-14-00001','GRP1','BRG001',1,NULL,15000,15000,15000),('110606-14-00003','GRP1','BRG001',1,13500,15000,15000,1500),('110606-14-00003','GRP1','BRG003',150,1000,1200,180000,30000);
/*!40000 ALTER TABLE `tb_penjualan_detail` ENABLE KEYS */;

--
-- Table structure for table `tb_ppn`
--

DROP TABLE IF EXISTS `tb_ppn`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_ppn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` text NOT NULL,
  `value` float(100,3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_ppn`
--

/*!40000 ALTER TABLE `tb_ppn` DISABLE KEYS */;
INSERT INTO `tb_ppn` VALUES (1,'ppn',10.000),(2,'bunga',15.000),(3,'shu',4.000);
/*!40000 ALTER TABLE `tb_ppn` ENABLE KEYS */;

--
-- Table structure for table `tb_report`
--

DROP TABLE IF EXISTS `tb_report`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_report` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `title_document` varchar(150) NOT NULL,
  `detail` text NOT NULL,
  `attrib` text NOT NULL,
  `aksi_print` text NOT NULL,
  `statusisasi` enum('0','1') DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_report`
--

/*!40000 ALTER TABLE `tb_report` DISABLE KEYS */;
INSERT INTO `tb_report` VALUES (1,'Pembelian','Report Pembelian Barang','periodtgl,supplier,kasir','report/pembelian','1'),(2,'Pembelian Barang','Report Pembelian Barang Detail','periodtgl,supplier,kasir','report/pembelian_detail','1'),(3,'Penjualan','Report Penjualan','periodtgl,krywan,detailbrg,kasir,jenisbayar','report/penjualan','1'),(4,'Penjualan Barang','Report Penjualan Barang Detail','periodtgl,krywan,detailbrg,kasir,jenisbayar','report/penjualan_detail','1'),(6,'Barang Limit','Report Barang dengan Stok memenuhi Limit','periodtgl,kategori,detailbrg','report/barang_limit','1'),(7,'Koreksi Stok','Report Koreksi Stok','periodtgl,detailbrg','report/koreksi_stok','1'),(8,'Stok Opname','Report Stok Opname','kategori','report/stok_opname','1'),(9,'Price List','Report List Harga','kategori,startdate','report/pricelist','1'),(5,'Stok','Report Stok','kategori','report/stok','1'),(10,'Kas','Report Transaksi Kas','periodtgl,kas','report/kas','1'),(11,'Laba Rugi','Report Laba Rugi','periodtgl,detailbrg,kasir,jenisbayar','report/labarugi','1');
/*!40000 ALTER TABLE `tb_report` ENABLE KEYS */;

--
-- Table structure for table `tb_seri_pembelian`
--

DROP TABLE IF EXISTS `tb_seri_pembelian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_seri_pembelian` (
  `tgl` date DEFAULT NULL,
  `pembelian` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_seri_pembelian`
--

/*!40000 ALTER TABLE `tb_seri_pembelian` DISABLE KEYS */;
INSERT INTO `tb_seri_pembelian` VALUES ('2014-05-24',3),('2014-05-28',1);
/*!40000 ALTER TABLE `tb_seri_pembelian` ENABLE KEYS */;

--
-- Table structure for table `tb_seri_penjualan`
--

DROP TABLE IF EXISTS `tb_seri_penjualan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_seri_penjualan` (
  `tgl` date DEFAULT NULL,
  `penjualan` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_seri_penjualan`
--

/*!40000 ALTER TABLE `tb_seri_penjualan` DISABLE KEYS */;
INSERT INTO `tb_seri_penjualan` VALUES ('2014-05-20',2),('2014-05-22',0),('2014-05-24',2),('2014-05-28',1),('2014-06-06',3);
/*!40000 ALTER TABLE `tb_seri_penjualan` ENABLE KEYS */;

--
-- Table structure for table `tb_seri_pinjaman`
--

DROP TABLE IF EXISTS `tb_seri_pinjaman`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_seri_pinjaman` (
  `tahun` int(100) NOT NULL,
  `pinjaman` int(255) NOT NULL,
  PRIMARY KEY (`tahun`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_seri_pinjaman`
--

/*!40000 ALTER TABLE `tb_seri_pinjaman` DISABLE KEYS */;
INSERT INTO `tb_seri_pinjaman` VALUES (2014,20),(2015,0),(2016,0),(2017,0),(2018,0),(2019,0),(2020,0),(2021,0),(2022,0),(2023,0),(2024,0),(2025,0),(2026,0),(2027,0),(2028,0),(2029,0),(2030,0),(2031,0),(2032,0),(2033,0),(2034,0),(2035,0),(2036,0),(2037,0),(2038,0),(2039,0),(2040,0),(2041,0),(2042,0),(2043,0),(2044,0),(2045,0),(2046,0),(2047,0),(2048,0),(2049,0),(2050,0);
/*!40000 ALTER TABLE `tb_seri_pinjaman` ENABLE KEYS */;

--
-- Table structure for table `tb_shu`
--

DROP TABLE IF EXISTS `tb_shu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_shu` (
  `id` bigint(150) NOT NULL AUTO_INCREMENT,
  `tanggal` datetime NOT NULL,
  `id_user` int(10) NOT NULL DEFAULT '0',
  `id_jabatan` varchar(1) NOT NULL DEFAULT '0',
  `persen` int(3) NOT NULL DEFAULT '0',
  `jumlah` float(255,0) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_shu`
--

/*!40000 ALTER TABLE `tb_shu` DISABLE KEYS */;
INSERT INTO `tb_shu` VALUES (1,'2014-04-29 00:00:00',3,'1',10,NULL);
/*!40000 ALTER TABLE `tb_shu` ENABLE KEYS */;

--
-- Table structure for table `tb_simpan_pinjam`
--

DROP TABLE IF EXISTS `tb_simpan_pinjam`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_simpan_pinjam` (
  `id` bigint(150) NOT NULL AUTO_INCREMENT,
  `id_simpan_pinjam` varchar(150) CHARACTER SET utf8 NOT NULL COMMENT 'di buat dengan format nota yaitu kode koperasi=>bulan=>tahun=>kode urut yang di reset 0 lagi setiap tahun',
  `tipe` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT 'tipenya ada macam - macam di simpan aja di config misal simpanan pokok, simpanan wajib dan pinjaman belanja ',
  `id_karyawan` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `id_penjualan` bigint(50) DEFAULT NULL,
  `jml_angsuran` int(2) DEFAULT NULL,
  `bunga` int(11) DEFAULT NULL,
  `tgl_jatuh_tempo` int(2) DEFAULT NULL COMMENT 'isi 2 digit tanggalnya aja',
  `total_debit` double NOT NULL DEFAULT '0' COMMENT 'total utang/saldo',
  `total_kredit` double NOT NULL DEFAULT '0' COMMENT 'total yang sudah di bayar utangnya',
  `email` varchar(255) NOT NULL,
  `tlp` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `status` varchar(5) CHARACTER SET utf8 NOT NULL DEFAULT '''b''' COMMENT 'l=>lunas b=>belum lunas',
  `waktu` datetime DEFAULT NULL,
  PRIMARY KEY (`id`,`id_simpan_pinjam`,`tipe`,`id_karyawan`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_simpan_pinjam`
--

/*!40000 ALTER TABLE `tb_simpan_pinjam` DISABLE KEYS */;
INSERT INTO `tb_simpan_pinjam` VALUES (1,'1104-14-00001','3','1100001',NULL,10,10,12,1100000,1100000,'','','','l','2014-04-24 15:03:45'),(2,'1104-14-00002','3','1100001',NULL,10,15,1,1725000,172500,'','','','b','2014-04-25 21:54:53'),(3,'1105-14-00003','4','1100001',NULL,10,10,12,385000,385000,'handoko@gmail.com','08988447236','Kipas angin Miyako, 2014','l','2014-05-15 11:45:10'),(4,'1105-14-00004','3','54321',NULL,10,15,12,172500,0,'handoko@gmail.com','08988447236','','b','2014-05-18 21:02:37'),(7,'1105-14-00015','3','1100001',NULL,10,15,12,1150000,0,'handoko@gmail.com','08988447236','','b','2014-05-28 15:30:22'),(8,'1105-14-00016','4','1100001',NULL,10,15,12,1150000,0,'handoko@gmail.com','08988447236','qq','b','2014-05-28 15:32:29'),(9,'1105-14-00017','3','1100001',NULL,10,15,12,1150000,0,'handoko@gmail.com','08988447236','','b','2014-05-28 18:49:14'),(10,'1105-14-00018','1','1100001',NULL,NULL,15,NULL,0,500000,'','','','l','2014-05-28 19:00:09'),(11,'1105-14-00019','1','1100001',NULL,NULL,15,NULL,0,500000,'','','','l','2014-05-28 19:00:59'),(12,'1106-14-00020','2','443',NULL,NULL,15,NULL,0,2000000,'','','','l','2014-06-10 14:31:29');
/*!40000 ALTER TABLE `tb_simpan_pinjam` ENABLE KEYS */;

--
-- Table structure for table `tb_simpan_pinjam_detail`
--

DROP TABLE IF EXISTS `tb_simpan_pinjam_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_simpan_pinjam_detail` (
  `id` bigint(150) NOT NULL AUTO_INCREMENT,
  `id_simpan_pinjam` varchar(150) NOT NULL COMMENT 'ambil dari simpan_pinjam',
  `rekening` varchar(50) NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `angsuran_ke` int(2) DEFAULT NULL COMMENT 'urutan angsuran',
  `debit` double DEFAULT NULL COMMENT 'uang keluar dari rekening',
  `kredit` double DEFAULT NULL COMMENT 'uang masuk ke rekening',
  PRIMARY KEY (`id`,`rekening`,`id_simpan_pinjam`,`tanggal`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_simpan_pinjam_detail`
--

/*!40000 ALTER TABLE `tb_simpan_pinjam_detail` DISABLE KEYS */;
INSERT INTO `tb_simpan_pinjam_detail` VALUES (1,'1104-14-00001','110100001','2014-04-24 15:03:45',NULL,1000000,0),(2,'1104-14-00001','110100001','2014-04-24 18:00:08',1,NULL,110000),(3,'1104-14-00001','110100001','2014-04-24 18:03:54',2,NULL,110000),(4,'1104-14-00001','110100001','2014-04-24 18:09:59',3,NULL,110000),(5,'1104-14-00001','110100001','2014-04-24 18:11:10',4,NULL,110000),(6,'1104-14-00001','110100001','2014-04-24 18:11:28',5,NULL,660000),(7,'1104-14-00002','110100001','2014-04-25 21:54:53',NULL,1500000,NULL),(8,'1105-14-00003','110100001','2014-05-15 11:45:10',NULL,350000,NULL),(9,'1105-14-00003','110100001','2014-05-15 11:47:53',1,NULL,385000),(10,'1105-14-00004','0','2014-05-18 21:02:37',NULL,150000,NULL),(15,'1105-14-00009','110100001','2014-05-20 18:52:00',NULL,148500,NULL),(16,'1105-14-00010','110100001','2014-05-22 14:50:47',NULL,0,NULL),(17,'1105-14-00011','110100001','2014-05-22 14:51:01',NULL,0,NULL),(18,'1105-14-00012','110100001','2014-05-22 15:21:50',NULL,0,NULL),(19,'1105-14-00013','0','2014-05-24 12:59:16',NULL,1400000,NULL),(20,'1105-14-00014','0','2014-05-24 13:02:03',NULL,1400000,NULL),(21,'1105-14-00015','110100001','2014-05-28 15:30:22',NULL,1000000,NULL),(22,'1105-14-00016','110100001','2014-05-28 15:32:29',NULL,1000000,NULL),(23,'1105-14-00017','110100001','2014-05-28 15:33:28',NULL,1000000,NULL),(24,'1105-14-00017','110100001','2014-05-28 18:49:14',NULL,1000000,NULL),(25,'1105-14-00018','110100001','2014-05-28 19:00:09',NULL,NULL,500000),(26,'1105-14-00019','110100001','2014-05-28 19:00:59',NULL,NULL,500000),(27,'1104-14-00002','110100001','2014-05-28 19:07:57',1,NULL,172500),(28,'1106-14-00020','0','2014-06-10 14:31:29',NULL,NULL,2000000);
/*!40000 ALTER TABLE `tb_simpan_pinjam_detail` ENABLE KEYS */;

--
-- Table structure for table `tb_supplier`
--

DROP TABLE IF EXISTS `tb_supplier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_supplier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_supplier`
--

/*!40000 ALTER TABLE `tb_supplier` DISABLE KEYS */;
INSERT INTO `tb_supplier` VALUES (1,'Batak','Jakarta'),(2,'Udin','Bogor'),(3,'Doni','Serang');
/*!40000 ALTER TABLE `tb_supplier` ENABLE KEYS */;

--
-- Table structure for table `tb_tipe_simpan_pinjam`
--

DROP TABLE IF EXISTS `tb_tipe_simpan_pinjam`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_tipe_simpan_pinjam` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `nama` text NOT NULL,
  `tipe` varchar(100) NOT NULL,
  `status` enum('n','y') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_tipe_simpan_pinjam`
--

/*!40000 ALTER TABLE `tb_tipe_simpan_pinjam` DISABLE KEYS */;
INSERT INTO `tb_tipe_simpan_pinjam` VALUES (1,'Simpanan Pokok','simpan','y'),(2,'Simpanan Wajib','simpan','y'),(3,'Pinjaman Sembako','pinjam','y'),(4,'Pinjaman Pembiayaan','pinjam','y'),(5,'Hutang Pembelian','pinjam','y'),(6,'Kredit Belanja','pinjam','n');
/*!40000 ALTER TABLE `tb_tipe_simpan_pinjam` ENABLE KEYS */;

--
-- Table structure for table `tb_transaksi_kas`
--

DROP TABLE IF EXISTS `tb_transaksi_kas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_transaksi_kas` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `tipe_transaksi` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id_transaksi` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `kas` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `debit` float(255,2) DEFAULT NULL,
  `kredit` float(255,2) DEFAULT NULL,
  `tgl` datetime DEFAULT NULL,
  `kasir` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `saldo` float(255,0) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_transaksi_kas`
--

/*!40000 ALTER TABLE `tb_transaksi_kas` DISABLE KEYS */;
INSERT INTO `tb_transaksi_kas` VALUES (1,'Penjualan','112805-14-00001','2',NULL,16500.00,NULL,NULL,NULL),(2,'Simpan Pinjam','1105-14-00018','1',NULL,500000.00,NULL,NULL,NULL),(3,'Simpan Pinjam','1105-14-00019','1',NULL,500000.00,NULL,NULL,NULL),(4,'Simpan Pinjam','1104-14-00002','1',NULL,172500.00,NULL,NULL,NULL),(5,'Pembelian','112805-14-00001','2',65000.00,NULL,NULL,NULL,NULL),(14,'Kas Awal',NULL,'1',100000.00,1000000.00,'2014-06-05 15:38:11',NULL,NULL),(15,'Penjualan','110606-14-00001','2',NULL,16500.00,'2014-06-06 06:38:53',NULL,NULL),(16,'Penjualan','110606-14-00002','2',NULL,16500.00,'2014-06-06 06:46:58',NULL,NULL),(17,'Penjualan','110606-14-00003','2',NULL,198000.00,'2014-06-06 11:51:32',NULL,NULL),(18,'Simpan Pinjam','1106-14-00020','1',NULL,2000000.00,'2014-06-10 14:31:29',NULL,NULL);
/*!40000 ALTER TABLE `tb_transaksi_kas` ENABLE KEYS */;

--
-- Table structure for table `tb_user`
--

DROP TABLE IF EXISTS `tb_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(150) NOT NULL COMMENT 'password disini menggunakan salt',
  `salt` varchar(150) NOT NULL COMMENT 'salt adalah kunci untuk generate password',
  `email` varchar(150) NOT NULL DEFAULT '',
  `jabatan` varchar(1) DEFAULT NULL COMMENT 'ambil jenis jabatan dari config buat aja array key-nya satu karakter namanya tes - tes aja',
  `jml_login` double(255,0) NOT NULL DEFAULT '0' COMMENT 'di tampilkan di home menu si login',
  `terakhir_masuk` datetime DEFAULT NULL,
  `terakhir_keluar` datetime DEFAULT NULL,
  `status` varchar(1) NOT NULL DEFAULT 'Y' COMMENT 'y=> aktif n=> nonaktif s=> suspend user suspend gk bisa login ke system alertnya pas login tulisannya status akun anda suspend silahkan hubungi administrator',
  `masuk_oleh` varchar(100) DEFAULT NULL,
  `masuk_tgl` datetime DEFAULT NULL,
  `edit_oleh` varchar(100) DEFAULT NULL,
  `edit_tgl` datetime DEFAULT NULL,
  PRIMARY KEY (`id`,`username`,`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_user`
--

/*!40000 ALTER TABLE `tb_user` DISABLE KEYS */;
INSERT INTO `tb_user` VALUES (3,'direksi','de401cdb190cb375c6fd2ff186b90a5d','3,1213','Dirga@gmail.com','1',2,'2014-04-13 21:56:52','2014-05-13 16:08:40','y','6',NULL,'6','2014-04-14 21:31:56'),(4,'5','390ba5f6b5f18dd4c63d7cda170a0c74','123','','2',2,'2014-05-13 16:26:20',NULL,'Y',NULL,NULL,NULL,NULL),(5,'8','8cfa2282b17de0a598c010f5f0109e7d','12345','','2',5,'2014-05-18 21:32:26',NULL,'Y',NULL,NULL,NULL,NULL),(6,'administrator','d959caadac9b13dcb3e609440135cf54','12345678','admin@yahoo.com','1',27,'2014-07-27 09:56:09','2014-06-27 22:48:39','y','270611',NULL,NULL,'2014-05-20 19:03:36'),(9,'9','8cfa2282b17de0a598c010f5f0109e7d','12345','','2',0,NULL,NULL,'Y',NULL,NULL,NULL,NULL),(10,'10','8cfa2282b17de0a598c010f5f0109e7d','12345','','2',0,NULL,NULL,'Y',NULL,NULL,NULL,NULL),(11,'11','8cfa2282b17de0a598c010f5f0109e7d','12345','','2',0,NULL,NULL,'Y',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `tb_user` ENABLE KEYS */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-04-09 16:24:07

/*
SQLyog Ultimate v10.00 Beta1
MySQL - 5.5.15 : Database - ci_crud
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`ci_crud` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `ci_crud`;

/*Table structure for table `ciudad` */

DROP TABLE IF EXISTS `ciudad`;

CREATE TABLE `ciudad` (
  `id_ciudad` int(10) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) DEFAULT NULL,
  `cod_postal` varchar(100) DEFAULT NULL,
  `id_provincia` int(10) NOT NULL DEFAULT '0',
  `activo` char(1) NOT NULL DEFAULT 'S',
  `eliminado` smallint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_ciudad`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `ciudad` */

insert  into `ciudad`(`id_ciudad`,`nombre`,`cod_postal`,`id_provincia`,`activo`,`eliminado`) values (1,'Lanus','1822',1,'S',0),(2,'Avellaneda','1874',1,'S',0),(3,'Gerli',NULL,1,'S',0),(4,'Lomas de Zamora',NULL,1,'S',0),(5,'San Telmo','1437',1,'S',0),(6,'Parque Patricios','1822',1,'S',0);

/*Table structure for table `provincia` */

DROP TABLE IF EXISTS `provincia`;

CREATE TABLE `provincia` (
  `id_provincia` int(10) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) DEFAULT NULL,
  `id_pais` int(10) NOT NULL DEFAULT '0',
  `activo` char(1) NOT NULL DEFAULT 'S',
  `eliminado` smallint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_provincia`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `provincia` */

insert  into `provincia`(`id_provincia`,`nombre`,`id_pais`,`activo`,`eliminado`) values (1,'Buenos Aires',0,'S',0),(2,'Cordoba',0,'S',0),(3,'Santa Fe',0,'S',0),(4,'La Pampa',0,'S',0),(5,'Entre Ríos',0,'S',0),(6,'Corrientes',0,'S',0);

/*Table structure for table `usuario` */

DROP TABLE IF EXISTS `usuario`;

CREATE TABLE `usuario` (
  `id_usuario` int(10) NOT NULL AUTO_INCREMENT,
  `entidad` enum('LOCAL','EXTERNO') DEFAULT NULL,
  `usuario` varchar(200) DEFAULT NULL,
  `contrasenia` varchar(200) DEFAULT NULL,
  `nombre` varchar(200) DEFAULT NULL,
  `apellido` varchar(200) DEFAULT NULL,
  `id_avatar` int(10) NOT NULL DEFAULT '0',
  `id_ciudad` int(10) NOT NULL DEFAULT '0',
  `id_provincia` int(10) NOT NULL DEFAULT '0',
  `domicilio` varchar(200) DEFAULT NULL,
  `dni` int(10) NOT NULL DEFAULT '0',
  `activo` smallint(1) NOT NULL DEFAULT '1',
  `eliminado` smallint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `usuario` */

insert  into `usuario`(`id_usuario`,`entidad`,`usuario`,`contrasenia`,`nombre`,`apellido`,`id_avatar`,`id_ciudad`,`id_provincia`,`domicilio`,`dni`,`activo`,`eliminado`) values (1,'LOCAL','diego22','die22','Diego','Olmedo',0,1,2,'Chiclana 3195',291233490,0,0);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

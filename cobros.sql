-- Adminer 3.3.3 MySQL dump

SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = 'SYSTEM';
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `amounts`;
CREATE TABLE `amounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `importe` double(9,2) NOT NULL,
  `concept_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `concept_id` (`concept_id`),
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO `amounts` (`id`, `fecha`, `importe`, `concept_id`, `course_id`) VALUES
(1,	'2011-09-20',	450.00,	1,	1),
(2,	'2011-09-21',	50.55,	2,	1),
(3,	'2011-04-01',	400.00,	3,	1);

DROP TABLE IF EXISTS `cities`;
CREATE TABLE `cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state_id` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `state_id` (`state_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO `cities` (`id`, `state_id`, `nombre`) VALUES
(2,	1,	'Desamparados'),
(3,	3,	'Valdivia'),
(4,	1,	'Rawson'),
(5,	0,	'Rawson');

DROP TABLE IF EXISTS `concepts`;
CREATE TABLE `concepts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `concepto` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `pago_parcial` tinyint(1) DEFAULT NULL,
  `ciclo_lectivo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `concepto` (`concepto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO `concepts` (`id`, `concepto`, `pago_parcial`, `ciclo_lectivo`) VALUES
(1,	'Matricula',	1,	2011),
(2,	'Distintivo',	1,	2011),
(3,	'Cuota',	1,	2011);

DROP TABLE IF EXISTS `countries`;
CREATE TABLE `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pais` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO `countries` (`id`, `pais`) VALUES
(1,	'Argentina'),
(2,	'Jamaica'),
(3,	'Chile'),
(4,	'Bolivia');

DROP TABLE IF EXISTS `courses`;
CREATE TABLE `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level_id` int(11) NOT NULL,
  `division_id` int(11) NOT NULL,
  `course` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `level_id` (`level_id`),
  KEY `division_id` (`division_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO `courses` (`id`, `level_id`, `division_id`, `course`) VALUES
(1,	1,	1,	1);

DROP TABLE IF EXISTS `debts`;
CREATE TABLE `debts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `amount_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `amount_id` (`amount_id`),
  KEY `student_id` (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO `debts` (`id`, `student_id`, `amount_id`) VALUES
(6,	6,	2),
(8,	6,	1),
(9,	6,	3);

DROP TABLE IF EXISTS `details`;
CREATE TABLE `details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `debt_id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `importe` double(9,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `payment_id` (`payment_id`),
  KEY `debt_id` (`debt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO `details` (`id`, `debt_id`, `payment_id`, `importe`) VALUES
(64,	6,	2347,	30.33),
(65,	8,	2347,	360.00),
(66,	9,	2348,	400.00);

DROP TABLE IF EXISTS `divisions`;
CREATE TABLE `divisions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `division` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO `divisions` (`id`, `division`) VALUES
(1,	'A');

DROP TABLE IF EXISTS `families`;
CREATE TABLE `families` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `tutor_id` int(11) NOT NULL,
  PRIMARY KEY (`student_id`,`tutor_id`),
  UNIQUE KEY `id` (`id`),
  KEY `tutor_id` (`tutor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `inscriptions`;
CREATE TABLE `inscriptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  PRIMARY KEY (`student_id`,`course_id`),
  UNIQUE KEY `id` (`id`),
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO `inscriptions` (`id`, `student_id`, `course_id`) VALUES
(1,	6,	1);

DROP TABLE IF EXISTS `levels`;
CREATE TABLE `levels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nivel` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO `levels` (`id`, `nivel`) VALUES
(1,	'Primario');

DROP TABLE IF EXISTS `modalities`;
CREATE TABLE `modalities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level_id` int(11) NOT NULL,
  `description` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `level_id` (`level_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `importe` double(9,2) NOT NULL,
  `fecha` datetime NOT NULL,
  `anulado` tinyint(4) NOT NULL DEFAULT '0',
  `fecha_anulado` datetime DEFAULT NULL,
  `nro_comprobante` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `moneda` int(11) NOT NULL,
  `cotizacion` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO `payments` (`id`, `student_id`, `user_id`, `importe`, `fecha`, `anulado`, `fecha_anulado`, `nro_comprobante`, `moneda`, `cotizacion`) VALUES
(2347,	6,	1,	390.33,	'2011-09-28 00:00:00',	0,	NULL,	'',	0,	NULL),
(2348,	6,	1,	400.00,	'2011-10-01 00:00:00',	0,	NULL,	'',	0,	NULL);

DROP TABLE IF EXISTS `scolarships`;
CREATE TABLE `scolarships` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `porcien_descuento` double(9,2) DEFAULT NULL,
  `amount_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `ciclo_lectivo` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `amount_id` (`amount_id`),
  KEY `student_id` (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO `scolarships` (`id`, `porcien_descuento`, `amount_id`, `student_id`, `ciclo_lectivo`) VALUES
(1,	20.00,	1,	6,	2011),
(2,	40.00,	2,	6,	2011),
(4,	50.00,	2,	7,	2011);

DROP TABLE IF EXISTS `states`;
CREATE TABLE `states` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `provincia` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO `states` (`id`, `country_id`, `provincia`) VALUES
(1,	1,	'San Juan'),
(2,	2,	'La serena'),
(3,	3,	'Santiago de Chile'),
(4,	1,	'Mendoza'),
(6,	4,	'Cochabamba'),
(7,	2,	'San CristÃ³bal'),
(8,	3,	'Punta arenas');

DROP TABLE IF EXISTS `students`;
CREATE TABLE `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '		',
  `apellido` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `tipo_documento` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `nro_documento` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `sexo` char(1) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'M y F',
  `domicilio` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `city_id` int(11) NOT NULL,
  `nacionalidad` varchar(40) COLLATE utf8_spanish2_ci NOT NULL,
  `telefono` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `celular` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `grupo_sanguineo` varchar(3) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `obs_medicas` text COLLATE utf8_spanish2_ci,
  `observaciones` text COLLATE utf8_spanish2_ci,
  `colegio_procedencia` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `fecha_inscripcion` date NOT NULL,
  `tenencia` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `city_id` (`city_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO `students` (`id`, `apellido`, `nombre`, `fecha_nacimiento`, `tipo_documento`, `nro_documento`, `sexo`, `domicilio`, `city_id`, `nacionalidad`, `telefono`, `celular`, `grupo_sanguineo`, `obs_medicas`, `observaciones`, `colegio_procedencia`, `fecha_inscripcion`, `tenencia`) VALUES
(6,	'Casares',	'Ricardo',	'1986-06-24',	'DNI',	'32168033',	'M',	'Libertad 1094 Sur',	4,	'Argentino',	'4241759',	'2645152632',	'A+',	'Alergico a la penicilina',	'Muy buen concepto',	'Escuela Boero',	'2011-09-27',	'Compartida'),
(7,	'Ferrari',	'MatÃ­a',	'1986-09-18',	'DNI',	'28475458',	'M',	'Av. Libertador 1234',	3,	'Argentino',	'4241759',	'2645152632',	'A+',	'Alergico a las nueces',	'Hiperactivo',	'Escuela Boero',	'2011-09-17',	'Compartida'),
(8,	'Lorenzo',	'Andrea',	'2011-09-17',	'DNI',	'34234234',	'M',	'Roger Ballet 323 Sur',	2,	'Argentino',	'4241759',	'1234123123',	'A+',	'Ninguna',	'Ninguna',	'Escuela Boero',	'2011-09-15',	'Compartida'),
(9,	'Paez',	'Lucas',	'1986-09-18',	'DNI',	'48475458',	'M',	'Av. Libertador 1234',	2,	'Argentino',	'4241759',	'23232323',	'A+',	'',	'',	'Escuela Boero',	'2011-09-22',	'Compartida'),
(10,	'Labuckas',	'Ludmila',	'2011-09-15',	'DNI',	'58475458',	'F',	'Lavalle 123 Sur',	2,	'Argentino',	'4241759',	'2645152632',	'A+',	'',	'',	'Escuela Boero',	'2011-09-22',	'Compartida'),
(11,	'RodrÃ­guez',	'Vanesa',	'2011-09-02',	'DNI',	'24234234',	'F',	'Libertad 1094 Sur',	2,	'Argentino',	'4241759',	'1234123123',	'A+',	'',	'',	'Escuela Boero',	'2011-09-22',	'Compartida'),
(12,	'RodrÃ­guez',	'Tito',	'2011-09-08',	'DNI',	'54234234',	'F',	'Juana Manso 324 Sur',	2,	'Argentino',	'4242424',	'2645152632',	'A+',	'',	'',	'Escuela Boero',	'2011-09-22',	'Compartida'),
(13,	'Sanna',	'Julieta',	'1986-09-18',	'DNI',	'22168033',	'F',	'Aberastain 123 Sur',	2,	'Argentino',	'4241759',	'2645152632',	'A+',	'',	'',	'Escuela de comercio',	'2011-09-27',	'Compartida'),
(14,	'Acosta',	'Lisandro',	'1986-09-18',	'DNI',	'434323423',	'M',	'Av. Libertador 1234 Oeste',	2,	'Argentino',	'02644241759',	'23232323',	'A+',	'',	'',	'Escuela Boero',	'2011-09-06',	'Compartida'),
(16,	'Paez',	'Manuel',	'1986-09-18',	'DNI',	'123123213',	'M',	'Libertad 1094 Sur',	2,	'Argentino',	'02644241759',	'2645152632',	'A+',	'',	'',	'Escuela Boero',	'2011-09-27',	'Compartida'),
(17,	'Guevara',	'Ricardo',	'2011-09-15',	'DNI',	'234324234',	'M',	'Entre RÃ­os 958 Sur',	2,	'Argentino',	'02644241759',	'1234123123',	'A+',	'',	'',	'Escuela Boero',	'2011-09-22',	'Compartida'),
(18,	'BerÃ³n',	'Javier',	'2011-03-17',	'DNI',	'74234234',	'M',	'Roger Ballet 323 Sur',	2,	'Argentino',	'4241759',	'2645152632',	'A+',	'',	'',	'Escuela Boero',	'2011-09-27',	'Compartida');

DROP TABLE IF EXISTS `tutors`;
CREATE TABLE `tutors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `apellido` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `relacion` int(11) NOT NULL COMMENT '1 madre 2 padre 3 abuelo 4  otro',
  `ocupacion` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `nacionalidad` int(11) NOT NULL,
  `domicilio` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `city_id` int(11) NOT NULL,
  `telefono_fijo` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `telefono_trabajo` varchar(20) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `celular` varchar(20) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `city_id` (`city_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `grupo` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `apellido` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `direccion` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `telefono` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `celular` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `hash` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO `users` (`id`, `grupo`, `apellido`, `nombre`, `email`, `usuario`, `password`, `direccion`, `telefono`, `celular`, `hash`) VALUES
(1,	'admin',	'Casares',	'Ricardo',	'ricardocasares@gmail.com',	'rcasares',	'7f3936cd1ab1bafa1e677c1e09d49717f57c920d',	'Libertad 1094 sur',	'4241759',	'155152632',	NULL),
(2,	'user',	'Ferrari',	'MatÃ­as',	'matias.ferrari@itexa.com.ar',	'mferrari',	'209d5fae8b2ba427d30650dd0250942af944a0c9',	'Rivadavia 345',	'43434343',	'1244123123',	'4e8a2b9da5c25');

-- 2011-10-03 18:45:06

-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 05-05-2014 a las 17:16:21
-- Versión del servidor: 5.6.16
-- Versión de PHP: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `u974710561_proy1`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulo`
--

CREATE TABLE IF NOT EXISTS `articulo` (
  `PROD_CODIGO` int(11) NOT NULL AUTO_INCREMENT,
  `PROD_TITULO` longtext NOT NULL,
  `PROD_RESUMEN` longtext NOT NULL,
  `PROD_FECHA_PUBLICACION` date NOT NULL,
  `PROD_GRUPO_INVESTIGACION` longtext NOT NULL,
  `PROD_PERMISO` int(11) NOT NULL,
  `PROD_ESTADO` longtext NOT NULL,
  `ART_ARCHIVO_ADJUNTO` longtext NOT NULL,
  `ART_FACTOR_IMPACTO` char(2) NOT NULL,
  PRIMARY KEY (`PROD_CODIGO`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(40) COLLATE utf8_bin NOT NULL,
  `login` varchar(50) COLLATE utf8_bin NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `login_attempts`
--

INSERT INTO `login_attempts` (`id`, `ip_address`, `login`, `time`) VALUES
(6, '127.0.0.1', 'wfpantoja', '2014-05-03 14:53:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `monografia`
--

CREATE TABLE IF NOT EXISTS `monografia` (
  `PROD_CODIGO` int(11) NOT NULL,
  `MONOGRAFIA_TIPO` varchar(100) NOT NULL,
  `MONOGRAFIA_AUTOR1` varchar(50) NOT NULL,
  `MONOGRAFIA_AUTOR2` varchar(50) DEFAULT NULL,
  `MONOGRAFIA_CODIRECTOR` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`PROD_CODIGO`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `monografia`
--

INSERT INTO `monografia` (`PROD_CODIGO`, `MONOGRAFIA_TIPO`, `MONOGRAFIA_AUTOR1`, `MONOGRAFIA_AUTOR2`, `MONOGRAFIA_CODIRECTOR`) VALUES
(1, 'ASD', 'ASD', 'ASD', 'ASD1'),
(2, 'sdsf', 'cesar', 'cece', 'ju');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `produccion`
--

CREATE TABLE IF NOT EXISTS `produccion` (
  `PROD_CODIGO` int(11) NOT NULL,
  `PROD_TITULO` varchar(200) NOT NULL,
  `PROD_RESUMEN` longtext NOT NULL,
  `PROD_FECHA_PUBLICACION` date NOT NULL,
  `PROD_GRUPO_INVESTIGACION` varchar(50) NOT NULL,
  `PROD_PERMISO` varchar(20) NOT NULL,
  `PROD_ESTADO` varchar(50) NOT NULL DEFAULT 'Sin Aprobar',
  `PROD_ARCHIVO_ADJUNTO` varchar(100) NOT NULL,
  PRIMARY KEY (`PROD_CODIGO`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `produccion`
--

INSERT INTO `produccion` (`PROD_CODIGO`, `PROD_TITULO`, `PROD_RESUMEN`, `PROD_FECHA_PUBLICACION`, `PROD_GRUPO_INVESTIGACION`, `PROD_PERMISO`, `PROD_ESTADO`, `PROD_ARCHIVO_ADJUNTO`) VALUES
(1, 'ASD', '<p>\n	ASD</p>\n', '2014-04-15', 'IDIS', '2', 'Sin Aprobar', '144a9-10a-weka-practica-upv-17.pdf'),
(2, 'ing art', '<p>\n	de poco nada</p>\n', '2014-04-11', 'GIT', '2', 'Sin Aprobar', '24d54-04_xml.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte_tecnico`
--

CREATE TABLE IF NOT EXISTS `reporte_tecnico` (
  `PROD_CODIGO` int(11) NOT NULL AUTO_INCREMENT,
  `PROD_TITULO` longtext NOT NULL,
  `PROD_RESUMEN` longtext NOT NULL,
  `PROD_FECHA_PUBLICACION` date NOT NULL,
  `PROD_GRUPO_INVESTIGACION` longtext NOT NULL,
  `PROD_PERMISO` int(11) NOT NULL,
  `PROD_ESTADO` longtext NOT NULL,
  PRIMARY KEY (`PROD_CODIGO`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE IF NOT EXISTS `rol` (
  `ROL_CODIGO` decimal(10,0) NOT NULL,
  `ROL_NOMBRE` longtext NOT NULL,
  PRIMARY KEY (`ROL_CODIGO`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`ROL_CODIGO`, `ROL_NOMBRE`) VALUES
('1', 'administrador'),
('2', 'jefe_departamento'),
('3', 'docente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tp1_sess`
--

CREATE TABLE IF NOT EXISTS `tp1_sess` (
  `session_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `ip_address` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `user_agent` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tp1_sess`
--

INSERT INTO `tp1_sess` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('2855503fadadaf9d3384950e519bc302', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:29.0) Gecko/20100101 Firefox/29.0', 1399134062, 'a:6:{s:9:"user_data";s:0:"";s:7:"user_id";s:1:"3";s:8:"username";s:8:"docente1";s:6:"status";s:1:"1";s:5:"email";s:8:"docente1";s:4:"tipo";a:1:{i:0;s:7:"docente";}}'),
('44a46dd452a803d42e7feaf58db6586e', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:29.0) Gecko/20100101 Firefox/29.0', 1399302407, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '1',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `ban_reason` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `new_password_key` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `new_password_requested` datetime DEFAULT NULL,
  `new_email` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `new_email_key` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `activated`, `banned`, `ban_reason`, `new_password_key`, `new_password_requested`, `new_email`, `new_email_key`, `last_ip`, `last_login`, `created`, `modified`) VALUES
(1, 'administrador', '$2a$08$udgWivAPjobFBX6FyxN4x.WmxuwS/d5fBg6rPWzZ95yGC7GmUq43i', 'administrador@unicauca.edu.co', 1, 0, NULL, NULL, NULL, NULL, NULL, '127.0.0.1', '2014-05-03 18:20:46', '2014-05-03 16:53:55', '2014-05-03 16:20:46'),
(2, 'jefe', '$2a$08$LIxMWJ4KQkM7V13.360zKuCyhxhDDoyQNkMvL8kVMCJ97440ABHsq', 'jefe@unicauca.edu.co', 1, 0, NULL, NULL, NULL, NULL, NULL, '127.0.0.1', '2014-05-03 16:59:17', '2014-05-03 16:57:09', '2014-05-03 14:59:17'),
(3, 'docente1', '$2a$08$4qhmo5Am4drru2ZJHxy6.OVr/rzOstfjX536Tm2AI4jJw08aqUe.u', 'docente1@unicauca.edu.co', 1, 0, NULL, NULL, NULL, NULL, NULL, '127.0.0.1', '2014-05-03 18:21:08', '2014-05-03 16:57:35', '2014-05-03 16:21:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_autologin`
--

CREATE TABLE IF NOT EXISTS `user_autologin` (
  `key_id` char(32) COLLATE utf8_bin NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_profiles`
--

CREATE TABLE IF NOT EXISTS `user_profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `country` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `user_id`, `country`, `website`) VALUES
(2, 4, NULL, NULL),
(3, 5, NULL, NULL),
(4, 6, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `USU_CODIGO` int(11) NOT NULL AUTO_INCREMENT,
  `USU_NOMBRE` varchar(50) NOT NULL,
  `USU_APELLIDO` varchar(50) NOT NULL,
  `USU_EMAIL` varchar(50) NOT NULL,
  `USU_CONTRASENA` varchar(50) NOT NULL,
  `USU_ESTADO` varchar(20) NOT NULL,
  PRIMARY KEY (`USU_CODIGO`),
  UNIQUE KEY `USU_EMAIL` (`USU_EMAIL`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`USU_CODIGO`, `USU_NOMBRE`, `USU_APELLIDO`, `USU_EMAIL`, `USU_CONTRASENA`, `USU_ESTADO`) VALUES
(2, 'jefe depto', 'sistemas', 'jefe@unicauca.edu.co', '12345', 'activo'),
(3, 'docente1', 'docente1 sistemas', 'docente1@unicauca.edu.co', '12345', 'activo'),
(1, 'administrador', 'administrador', 'administrador@unicauca.edu.co', '12345', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_produccion`
--

CREATE TABLE IF NOT EXISTS `usuario_produccion` (
  `USU_CODIGO` int(11) NOT NULL,
  `PROD_CODIGO` decimal(50,0) NOT NULL,
  PRIMARY KEY (`USU_CODIGO`,`PROD_CODIGO`),
  KEY `FK_USUARIO_PRODUCCION2` (`PROD_CODIGO`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_rol`
--

CREATE TABLE IF NOT EXISTS `usuario_rol` (
  `USU_CODIGO` int(11) NOT NULL,
  `ROL_CODIGO` decimal(10,0) NOT NULL DEFAULT '3',
  PRIMARY KEY (`USU_CODIGO`,`ROL_CODIGO`),
  KEY `FK_USUARIO_ROL2` (`ROL_CODIGO`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario_rol`
--

INSERT INTO `usuario_rol` (`USU_CODIGO`, `ROL_CODIGO`) VALUES
(2, '2'),
(2, '3'),
(3, '3'),
(4, '3'),
(18, '3'),
(20, '2'),
(35, '2'),
(38, '3'),
(39, '3'),
(40, '3');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

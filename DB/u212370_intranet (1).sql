-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-03-2016 a las 22:24:01
-- Versión del servidor: 10.1.10-MariaDB
-- Versión de PHP: 5.5.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `u212370_intranet`
--
CREATE DATABASE IF NOT EXISTS `u212370_intranet` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `u212370_intranet`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areasitw`
--

DROP TABLE IF EXISTS `areasitw`;
CREATE TABLE `areasitw` (
  `area_ID` int(11) NOT NULL,
  `Descripcion` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `areasitw`
--

INSERT INTO `areasitw` (`area_ID`, `Descripcion`) VALUES
(1, 'Desarrollo'),
(2, 'Testing'),
(3, 'Administración');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `diasvacaciones`
--

DROP TABLE IF EXISTS `diasvacaciones`;
CREATE TABLE `diasvacaciones` (
  `vacaciones_ID` int(11) NOT NULL,
  `Anios` int(11) NOT NULL,
  `Dias` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `diasvacaciones`
--

INSERT INTO `diasvacaciones` (`vacaciones_ID`, `Anios`, `Dias`) VALUES
(1, 1, 6),
(2, 2, 8),
(3, 3, 10),
(4, 4, 12),
(5, 9, 14),
(6, 14, 16),
(7, 19, 18),
(8, 24, 20),
(9, 29, 22),
(10, 34, 24);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_civil`
--

DROP TABLE IF EXISTS `estado_civil`;
CREATE TABLE `estado_civil` (
  `idCivil` int(11) NOT NULL,
  `desc` varchar(15) NOT NULL COMMENT 'edo civil'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estado_civil`
--

INSERT INTO `estado_civil` (`idCivil`, `desc`) VALUES
(1, 'SOLTERO'),
(2, 'CASADO'),
(3, 'DIVORCIADO'),
(4, 'UNION LIBRE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estatus`
--

DROP TABLE IF EXISTS `estatus`;
CREATE TABLE `estatus` (
  `idEstatus` int(11) NOT NULL,
  `desc` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estatus`
--

INSERT INTO `estatus` (`idEstatus`, `desc`) VALUES
(1, 'ACTIVO'),
(2, 'INACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estatussolcitiud`
--

DROP TABLE IF EXISTS `estatussolcitiud`;
CREATE TABLE `estatussolcitiud` (
  `idSolicitudEstatus` int(11) NOT NULL,
  `Descripcion` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estatussolcitiud`
--

INSERT INTO `estatussolcitiud` (`idSolicitudEstatus`, `Descripcion`) VALUES
(1, 'PENDIENTE'),
(2, 'APROVADA'),
(3, 'RECHAZADA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `idMenu` int(11) NOT NULL,
  `descripcion` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `alias` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `posicion` int(2) DEFAULT NULL,
  `href` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `idPerfilExclusivo` int(11) DEFAULT NULL COMMENT 'Id Perfil con acceso a este menú',
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `icono` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla de Menu de la INTRANET';

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`idMenu`, `descripcion`, `alias`, `posicion`, `href`, `idPerfilExclusivo`, `visible`, `icono`) VALUES
(1, 'Mi Cuenta', 'M1', 1, '', 0, 1, 'glyphicon glyphicon-briefcase'),
(2, 'Usuarios', 'M2', 2, '', 1, 1, 'glyphicon glyphicon-user'),
(3, 'Vacaciones', 'M3', 3, NULL, 0, 1, 'glyphicon glyphicon-plane'),
(4, 'Permisos', 'M4', 4, NULL, 0, 1, 'glyphicon glyphicon-time'),
(5, 'Directorio', 'M5', 5, '', 0, 1, 'glyphicon glyphicon-book');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

DROP TABLE IF EXISTS `perfil`;
CREATE TABLE `perfil` (
  `idPerfil` int(11) NOT NULL,
  `desc` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'nombre del perfil'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Tabla con los perfiles de usuario';

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`idPerfil`, `desc`) VALUES
(1, 'ADMINISTRADOR'),
(2, 'ESTANDAR');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos`
--

DROP TABLE IF EXISTS `proyectos`;
CREATE TABLE `proyectos` (
  `proyecto_ID` int(11) NOT NULL,
  `usuario_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `proyectos`
--

INSERT INTO `proyectos` (`proyecto_ID`, `usuario_ID`) VALUES
(1, 14);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sexo`
--

DROP TABLE IF EXISTS `sexo`;
CREATE TABLE `sexo` (
  `idSexo` int(11) NOT NULL,
  `desc` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `alias` varchar(1) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `sexo`
--

INSERT INTO `sexo` (`idSexo`, `desc`, `alias`) VALUES
(1, 'HOMBRE', 'H'),
(2, 'MUJER', 'M');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudvaciones`
--

DROP TABLE IF EXISTS `solicitudvaciones`;
CREATE TABLE `solicitudvaciones` (
  `solicitud_ID` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL,
  `fechaI` date NOT NULL,
  `fechaF` date NOT NULL,
  `diasCorrespondientes` int(11) NOT NULL,
  `diasSolicitados` int(11) NOT NULL,
  `diasAdicionales` int(11) NOT NULL,
  `lider_ID` int(11) NOT NULL,
  `aprobacion_L` int(5) NOT NULL,
  `Director_ID` int(11) NOT NULL,
  `aprobacion_D` int(5) NOT NULL,
  `documentoURL` varchar(60) DEFAULT NULL,
  `fechaSolicitud` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `correoEnviado` tinyint(1) DEFAULT NULL,
  `correoEnviadoD` tinyint(1) DEFAULT '0',
  `correoDeR` tinyint(1) DEFAULT '0',
  `correoDEA` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `solicitudvaciones`
--

INSERT INTO `solicitudvaciones` (`solicitud_ID`, `user_ID`, `fechaI`, `fechaF`, `diasCorrespondientes`, `diasSolicitados`, `diasAdicionales`, `lider_ID`, `aprobacion_L`, `Director_ID`, `aprobacion_D`, `documentoURL`, `fechaSolicitud`, `correoEnviado`, `correoEnviadoD`, `correoDeR`, `correoDEA`) VALUES
(1, 11, '2016-02-15', '2016-02-19', 6, 4, 0, 14, 2, 16, 2, 'sin archivo', '2016-03-03 18:10:54', 0, 0, 0, 1),
(2, 14, '2016-02-09', '2016-02-10', 16, 2, 0, 14, 1, 16, 1, 'u212370_intranet (1).pdf', '2016-03-03 00:04:44', 0, 0, 0, 0),
(3, 7, '2016-02-16', '2016-02-17', 16, 2, 0, 14, 1, 16, 1, 'Details.pdf', '2016-02-29 18:38:04', 0, NULL, NULL, NULL),
(4, 14, '2016-02-16', '2016-02-18', 16, 3, 0, 14, 1, 16, 1, 'sin archivo', '2016-02-29 23:37:42', 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `submenu`
--

DROP TABLE IF EXISTS `submenu`;
CREATE TABLE `submenu` (
  `idSubMenu` int(11) NOT NULL,
  `idMenu` int(11) NOT NULL,
  `descripcion` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `alias` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `posicion` int(2) DEFAULT NULL,
  `href` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `idPerfilExclusivo` int(11) DEFAULT NULL COMMENT 'Id Perfil que puede tener acceso a este submenu',
  `visible` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla de submenu para la INTRANET';

--
-- Volcado de datos para la tabla `submenu`
--

INSERT INTO `submenu` (`idSubMenu`, `idMenu`, `descripcion`, `alias`, `posicion`, `href`, `idPerfilExclusivo`, `visible`) VALUES
(1, 1, 'Mi Perfil', 'M1S1', 1, 'submenu_MiCuenta_MiPerfil.php', 0, 1),
(2, 1, 'Cambiar Contrase&ntilde;a', 'M1S2', 2, 'submenu_MiCuenta_CambiaPwd.php', 0, 1),
(3, 1, 'Cerrar Sesi&oacute;n', 'M1S3', 3, 'submenu_MiCuenta_CerrarSesion.php', 0, 1),
(4, 2, 'Alta', 'M2S1', 1, 'submenu_UsuariosAlta.php', 1, 1),
(5, 2, 'Administrar', 'M2S2', 1, 'submenu_UsuariosModifica.php', 1, 1),
(7, 3, 'Solicitud de vacaciones', 'M3S1', 1, 'submenu_Solicitud_Vacaciones.php', 0, 1),
(8, 3, 'Solicitudes recibidas', 'M3S2', 2, 'submenu_SolicitudesVacaciones_Recibidas.php', 1, 1),
(9, 4, 'Solicitud de permiso', 'M4S1', 1, 'submenu_Solicitud_Permisos.php', 0, 1),
(10, 4, 'Solicitudes recibidas', 'M4S2', 2, 'submenu_SolicitudesPermisos_Recibidas.php', 1, 1),
(11, 5, 'Buscar', 'M5S1', 1, 'sub_menuDirectorio.php', 0, 1),
(13, 5, 'Carga de datos', 'M5S2', 2, 'submenu_cargainfo.php', 1, 1),
(14, 3, 'Administración de vacaciones', 'M3S3', 3, 'submenu_AdminVacaciones.php', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL,
  `usrIntranet` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `pwdIntranet` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `paterno` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `materno` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechaNacimiento` date DEFAULT NULL COMMENT 'Fecha nacimiento',
  `idPerfil` int(11) NOT NULL DEFAULT '1',
  `idEstatus` int(11) NOT NULL DEFAULT '1',
  `Idsexo` int(11) NOT NULL,
  `IdCivil` int(11) NOT NULL DEFAULT '1',
  `direccion` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechaIngreso` date DEFAULT NULL,
  `fechaSalida` date DEFAULT NULL,
  `telPersonal` int(14) DEFAULT NULL,
  `celPersonal` int(14) DEFAULT NULL,
  `emailPersonal` varchar(80) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telOfna` int(14) DEFAULT NULL,
  `celOfna` int(14) DEFAULT NULL,
  `emailOfna` varchar(80) COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccionOfna` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Proyecto_id` int(11) NOT NULL DEFAULT '0',
  `area_ID` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `usrIntranet`, `pwdIntranet`, `nombre`, `paterno`, `materno`, `fechaNacimiento`, `idPerfil`, `idEstatus`, `Idsexo`, `IdCivil`, `direccion`, `fechaIngreso`, `fechaSalida`, `telPersonal`, `celPersonal`, `emailPersonal`, `telOfna`, `celOfna`, `emailOfna`, `direccionOfna`, `Proyecto_id`, `area_ID`) VALUES
(1, 'arturo.davila@itw.mx', '25d55ad283aa400af464c76d713c07ad', 'ARTURO', 'DAVILA', 'HERNANDEZ', NULL, 1, 1, 1, 4, ' Rosario Castellanos 561 Int. 218 Col. Artes Grï¿½ficas C.P. 15830 Mï¿½xico, D.F. Del. Venustiano Carranza', '2014-04-15', NULL, 2147483647, 2147483647, ' arturoenlaweb@yahoo.com.mx', 22260739, 2147483647, ' arturo.davilahernandez@citi.com', ' Oficinas Moras', 0, 0),
(2, 'roberto.galicia@itworkers.com.mx', 'bc45060b4c3d413012d5ebc6543214a5', 'Roberto Carlos', 'Galicia', 'Galicia', NULL, 1, 1, 1, 2, 'Santa Fe', '2013-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0),
(3, 'beatriz.lopez@itworkers.com.mx', 'bb21ceefa4186c19cc7b55f0e645572d', 'Beatriz', 'Lopez', 'Botello', NULL, 1, 1, 2, 1, 'SUR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0),
(4, 'homero.jimenez@itworkers.com.mx', '45d78ae2b3c15757d689bf7f8e87f7d6', 'Homero', 'Jimenez', 'M.', NULL, 1, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0),
(5, 'arturoenlaweb@yahoo.com.mx', '18e572bb4b667f01827866bad2d94737', 'arturo', 'davila', 'hernandez', '1975-12-09', 2, 1, 1, 4, '', '0000-00-00', NULL, 0, 0, '', 0, 0, '', '', 0, 0),
(7, 'calero.adrian93@gmail.com', 'e94891b121d8ce90ffb7046911c7db7d', 'Adrian', 'Calero', NULL, NULL, 2, 1, 1, 1, ' ', NULL, NULL, 0, 0, '', 0, 2147483647, ' ', ' ', 1, 0),
(11, 'calero.adrian93@gmail.com', 'e94891b121d8ce90ffb7046911c7db7d', 'Jesús Adrian', 'Calero', 'Hidalgo', NULL, 2, 1, 1, 1, ' ', '2016-01-18', NULL, 0, 0, '', 0, 2147483647, ' ', ' ', 1, 0),
(14, 'jesus.calero@hotmail.com', 'e94891b121d8ce90ffb7046911c7db7d', 'Jesus', 'Calero', NULL, NULL, 1, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0),
(16, 'jesus.calero@itw.mx', 'e94891b121d8ce90ffb7046911c7db7d', 'JESUS ADRIAN', 'Calero', NULL, NULL, 1, 1, 1, 1, ' ', '2016-01-18', NULL, 0, 0, '', 0, 0, ' ', ' ', 1, 1),
(17, 'zule_utim@itx.mx', '850806d84f2ad365325db0f72114f915', 'Zule', 'Aguilar', '', '0000-00-00', 2, 1, 1, 1, '', '0000-00-00', NULL, 0, 0, '', 0, 0, '', '', 0, 0),
(18, 'jesus.calero@hotmail.com', 'e94891b121d8ce90ffb7046911c7db7d', 'Jesus', 'Calero', NULL, NULL, 1, 1, 1, 1, NULL, '2016-01-18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `areasitw`
--
ALTER TABLE `areasitw`
  ADD PRIMARY KEY (`area_ID`);

--
-- Indices de la tabla `diasvacaciones`
--
ALTER TABLE `diasvacaciones`
  ADD PRIMARY KEY (`vacaciones_ID`);

--
-- Indices de la tabla `estado_civil`
--
ALTER TABLE `estado_civil`
  ADD PRIMARY KEY (`idCivil`);

--
-- Indices de la tabla `estatus`
--
ALTER TABLE `estatus`
  ADD PRIMARY KEY (`idEstatus`);

--
-- Indices de la tabla `estatussolcitiud`
--
ALTER TABLE `estatussolcitiud`
  ADD PRIMARY KEY (`idSolicitudEstatus`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`idMenu`);

--
-- Indices de la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`idPerfil`);

--
-- Indices de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD PRIMARY KEY (`proyecto_ID`),
  ADD KEY `usuario_ID` (`usuario_ID`);

--
-- Indices de la tabla `sexo`
--
ALTER TABLE `sexo`
  ADD PRIMARY KEY (`idSexo`);

--
-- Indices de la tabla `solicitudvaciones`
--
ALTER TABLE `solicitudvaciones`
  ADD PRIMARY KEY (`solicitud_ID`),
  ADD KEY `user_ID` (`user_ID`),
  ADD KEY `aprobacion_L` (`aprobacion_L`),
  ADD KEY `aprobacion_D` (`aprobacion_D`);

--
-- Indices de la tabla `submenu`
--
ALTER TABLE `submenu`
  ADD PRIMARY KEY (`idSubMenu`,`idMenu`),
  ADD KEY `idMenu` (`idMenu`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`,`usrIntranet`),
  ADD KEY `idPerfil` (`idPerfil`),
  ADD KEY `IdCivil` (`IdCivil`),
  ADD KEY `Idsexo` (`Idsexo`),
  ADD KEY `idEstatus` (`idEstatus`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `areasitw`
--
ALTER TABLE `areasitw`
  MODIFY `area_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `diasvacaciones`
--
ALTER TABLE `diasvacaciones`
  MODIFY `vacaciones_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `estado_civil`
--
ALTER TABLE `estado_civil`
  MODIFY `idCivil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `estatus`
--
ALTER TABLE `estatus`
  MODIFY `idEstatus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `estatussolcitiud`
--
ALTER TABLE `estatussolcitiud`
  MODIFY `idSolicitudEstatus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `idMenu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `perfil`
--
ALTER TABLE `perfil`
  MODIFY `idPerfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  MODIFY `proyecto_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `sexo`
--
ALTER TABLE `sexo`
  MODIFY `idSexo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `solicitudvaciones`
--
ALTER TABLE `solicitudvaciones`
  MODIFY `solicitud_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `submenu`
--
ALTER TABLE `submenu`
  MODIFY `idSubMenu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD CONSTRAINT `proyectos_ibfk_1` FOREIGN KEY (`usuario_ID`) REFERENCES `usuarios` (`idUsuario`);

--
-- Filtros para la tabla `solicitudvaciones`
--
ALTER TABLE `solicitudvaciones`
  ADD CONSTRAINT `solicitudvaciones_ibfk_1` FOREIGN KEY (`aprobacion_L`) REFERENCES `estatussolcitiud` (`idSolicitudEstatus`),
  ADD CONSTRAINT `solicitudvaciones_ibfk_2` FOREIGN KEY (`aprobacion_D`) REFERENCES `estatussolcitiud` (`idSolicitudEstatus`);

--
-- Filtros para la tabla `submenu`
--
ALTER TABLE `submenu`
  ADD CONSTRAINT `submenu_ibfk_1` FOREIGN KEY (`idMenu`) REFERENCES `menu` (`idMenu`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`idPerfil`) REFERENCES `perfil` (`idPerfil`),
  ADD CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`IdCivil`) REFERENCES `estado_civil` (`idCivil`),
  ADD CONSTRAINT `usuarios_ibfk_3` FOREIGN KEY (`Idsexo`) REFERENCES `sexo` (`idSexo`),
  ADD CONSTRAINT `usuarios_ibfk_4` FOREIGN KEY (`idEstatus`) REFERENCES `estatus` (`idEstatus`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

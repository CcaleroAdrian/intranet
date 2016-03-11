-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-03-2016 a las 00:32:15
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

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
  `area_ID` int(11) NOT NULL DEFAULT '0',
  `DiasLey` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `usrIntranet`, `pwdIntranet`, `nombre`, `paterno`, `materno`, `fechaNacimiento`, `idPerfil`, `idEstatus`, `Idsexo`, `IdCivil`, `direccion`, `fechaIngreso`, `fechaSalida`, `telPersonal`, `celPersonal`, `emailPersonal`, `telOfna`, `celOfna`, `emailOfna`, `direccionOfna`, `Proyecto_id`, `area_ID`, `DiasLey`) VALUES
(1, 'arturo.davila@itw.mx', '25d55ad283aa400af464c76d713c07ad', 'ARTURO', 'DAVILA', 'HERNANDEZ', '0000-00-00', 1, 1, 1, 4, ' Rosario Castellanos 561 Int. 218 Col. Artes Grï¿½ficas C.P. 15830 Mï¿½xico, D.F. Del. Venustiano Carranza', '0000-00-00', '0000-00-00', 2147483647, 2147483647, 'arturoenlaweb@yahoo.com.mx', 22260739, 2147483647, 'arturo.davilahernandez@citi.com', ' Oficinas Moras', 0, 1, 0),
(2, 'roberto.galicia@itworkers.com.mx', 'bc45060b4c3d413012d5ebc6543214a5', 'Roberto Carlos', 'Galicia', 'Galicia', NULL, 1, 1, 1, 2, 'Santa Fe', '2013-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
(3, 'beatriz.lopez@itworkers.com.mx', 'bb21ceefa4186c19cc7b55f0e645572d', 'Beatriz', 'Lopez', 'Botello', NULL, 1, 1, 2, 1, 'SUR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
(4, 'homero.jimenez@itworkers.com.mx', '45d78ae2b3c15757d689bf7f8e87f7d6', 'Homero', 'Jimenez', 'M.', NULL, 1, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
(5, 'arturoenlaweb@yahoo.com.mx', '18e572bb4b667f01827866bad2d94737', 'arturo', 'davila', 'hernandez', '1975-12-09', 2, 1, 1, 4, '', '0000-00-00', NULL, 0, 0, '', 0, 0, '', '', 0, 0, 0),
(14, 'calero.adrian93@gmail.com', 'e94891b121d8ce90ffb7046911c7db7d', 'Jesus', 'Calero', NULL, NULL, 2, 1, 1, 1, ' ', NULL, NULL, 0, 0, '', 0, 0, ' ', ' ', 0, 1, 0),
(16, 'jesus.calero@itw.mx', 'e94891b121d8ce90ffb7046911c7db7d', 'JESUS ADRIAN', 'Calero', NULL, NULL, 1, 1, 1, 1, ' ', '2015-01-19', NULL, 0, 0, '', 2147483647, 0, ' ', ' ', 1, 1, 6),
(18, 'jesus.calero@hotmail.com', 'e94891b121d8ce90ffb7046911c7db7d', 'Jesus', 'Calero', NULL, NULL, 4, 1, 1, 1, ' ', '2016-01-18', NULL, 0, 0, '', 0, 0, ' ', ' ', 0, 1, 0),
(19, 'calero.adrian@ouclok.com', 'e94891b121d8ce90ffb7046911c7db7d', 'Adrian', 'Calero', 'Hidalgo', NULL, 3, 1, 1, 1, NULL, '2016-03-02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0),
(20, 'intranet@itw.mx', 'e94891b121d8ce90ffb7046911c7db7d', 'Intranet', 'ITW', NULL, NULL, 5, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0);

--
-- Índices para tablas volcadas
--

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
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- Restricciones para tablas volcadas
--

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

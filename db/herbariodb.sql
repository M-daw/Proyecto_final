-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-03-2020 a las 16:31:47
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `herbariodb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes`
--

CREATE TABLE `imagenes` (
  `id_imagen` int(11) NOT NULL,
  `id_planta` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `enlace_imagen` varchar(50) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plantas`
--

CREATE TABLE `plantas` (
  `id_planta` int(11) NOT NULL,
  `nombre_cientifico` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `nombre_castellano` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `nombre_valenciano` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `nombre_ingles` varchar(100) COLLATE latin1_spanish_ci DEFAULT NULL,
  `familia` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  `caracteres_diagnosticos` text COLLATE latin1_spanish_ci NOT NULL,
  `uso` text COLLATE latin1_spanish_ci DEFAULT NULL,
  `biotipo` enum('terófito','hemicriptófito','geófito','caméfito','fanerófito','hidrófito') COLLATE latin1_spanish_ci NOT NULL,
  `habitat` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `distribucion` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `cat_UICN` enum('LC Preocupación menor','NT Casi amenazada','VU Vulnerable','EN En peligro','CR EN peligro crítico','EW Extinta en estado silvestre','EX Extinta') COLLATE latin1_spanish_ci NOT NULL,
  `floracion` text COLLATE latin1_spanish_ci NOT NULL,
  `foto_general` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `foto_flor` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `foto_hoja` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `foto_fruto` varchar(50) COLLATE latin1_spanish_ci DEFAULT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `plantas`
--

INSERT INTO `plantas` (`id_planta`, `nombre_cientifico`, `nombre_castellano`, `nombre_valenciano`, `nombre_ingles`, `familia`, `caracteres_diagnosticos`, `uso`, `biotipo`, `habitat`, `distribucion`, `cat_UICN`, `floracion`, `foto_general`, `foto_flor`, `foto_hoja`, `foto_fruto`, `id_usuario`) VALUES
(1, 'Diplotaxis erucoides', 'Oruga silvestre, rabaniza blanca, jaramago blanco', 'Ravenissa blanca, ravanell', ' white rocket, white wallrocket', 'Cruciferae', '                                                                                                                                                                                                                                     Es una planta herbácea con hojas irregulares y flores blancas de 4 pétalos con disposición en cruz, 6 estambres en 2 niveles. Presenta cáliz y estambres en la misma flor, también hay sépalos, que en el botón floral son densamente hirsutos.\r\nEs la única del género con flores de pétalos blancos. Alcanza un porte de 20-50 cm y sus hojas inferiores, que se agrupan en roseta, son oblongas, de pinnatífidas a pinnatipartidas, las superiores son sésiles y de base truncada o semiamplexicaule, raramente cuneada.\r\nEs una de las hierbas más abundantes durante el otoño y el invierno en los campos de cultivo, aunque puede estar en flor en cualquier época del año. Las semillas se encuentran en vainas dehiscentes con disposición en doble fila, raíz típica, alrededor de un eje central.                                                                                                                                                                                                                                              ', '                                                                                                                                                                                                                                             Alimento de ganado y aves domésticas                                                                                                                                                                                                                                                ', 'terófito', 'Habita frecuentemente en terrenos baldíos, bordes de los caminos y campos de cultivo', 'Cuenca Mediterránea', 'LC Preocupación menor', 'Todo el año', '', '', '', '', 1),
(39, 'plantus borradie', '', 'plantuja', '', '', '                                                ', '                                                ', 'terófito', '', '', 'LC Preocupación menor', '', '', '', '', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre_usuario` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  `email_usuario` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  `pass_usuario` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  `tipo_usuario` enum('Usuario','Colaborador','Administrador') COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre_usuario`, `email_usuario`, `pass_usuario`, `tipo_usuario`) VALUES
(1, 'admin', 'admin@correo.com', 'admin', 'Administrador'),
(2, 'ana', 'ana@correo.com', 'ana', 'Usuario'),
(3, 'pepe', 'pepe@correo.com', 'pepe', 'Usuario'),
(5, 'Profesor Uno', 'profesoruno@correo.com', 'uno', 'Colaborador'),
(8, 'probando', 'probando#loqienans', '', 'Usuario'),
(35, 'otro más', 'otro@correo.com', 'pass', 'Usuario'),
(37, 'pepe', 'pepe@correo.es', 'pepe2', 'Usuario'),
(45, 'manolo', 'manolo@correo.com', 'manolo', 'Usuario');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  ADD PRIMARY KEY (`id_imagen`),
  ADD UNIQUE KEY `id_planta` (`id_planta`,`id_usuario`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `plantas`
--
ALTER TABLE `plantas`
  ADD PRIMARY KEY (`id_planta`),
  ADD UNIQUE KEY `nombre_cientifico` (`nombre_cientifico`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email_usuario` (`email_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  MODIFY `id_imagen` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `plantas`
--
ALTER TABLE `plantas`
  MODIFY `id_planta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `imagenes`
--
ALTER TABLE `imagenes`
  ADD CONSTRAINT `imagenes_ibfk_1` FOREIGN KEY (`id_planta`) REFERENCES `plantas` (`id_planta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `imagenes_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `plantas`
--
ALTER TABLE `plantas`
  ADD CONSTRAINT `plantas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-04-2020 a las 18:18:14
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
-- Base de datos: `copia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes`
--

CREATE TABLE `imagenes` (
  `id_imagen` int(11) NOT NULL,
  `id_planta` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `enlace_imagen` varchar(250) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plantas`
--

CREATE TABLE `plantas` (
  `id_planta` int(11) NOT NULL,
  `nombre_cientifico` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `nombre_castelllano` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `nombre_valenciano` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `nombre_ingles` varchar(30) COLLATE latin1_spanish_ci DEFAULT NULL,
  `familia` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  `caracteres_diagnosticos` text COLLATE latin1_spanish_ci NOT NULL,
  `uso` text COLLATE latin1_spanish_ci DEFAULT NULL,
  `biotipo` enum('terófito','hemicriptófito','geófito','caméfito','fanerófito','hidrófito') COLLATE latin1_spanish_ci NOT NULL,
  `habitat` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `distribucion` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `cat_UICN` enum('LC Preocupación menor','NT Casi amenazada','VU Vulnerable','EN En peligro','CR EN peligro crítico','EW Extinta en estado silvestre','EX Extinta') COLLATE latin1_spanish_ci NOT NULL,
  `floracion` text COLLATE latin1_spanish_ci NOT NULL,
  `foto_general` varchar(250) COLLATE latin1_spanish_ci NOT NULL,
  `foto_flor` varchar(250) COLLATE latin1_spanish_ci NOT NULL,
  `foto_hoja` varchar(250) COLLATE latin1_spanish_ci NOT NULL,
  `foto_fruto` varchar(250) COLLATE latin1_spanish_ci DEFAULT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre_usuario` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  `email_usuario` varchar(40) COLLATE latin1_spanish_ci NOT NULL,
  `pass_usuario` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  `tipo_usuario` enum('Usuario','Colaborador','Administrador') COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  ADD PRIMARY KEY (`id_imagen`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_planta` (`id_planta`,`id_usuario`) USING BTREE;

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
  MODIFY `id_planta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT;

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

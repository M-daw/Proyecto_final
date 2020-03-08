-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-03-2020 a las 17:38:45
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
-- Estructura de tabla para la tabla `galeria`
--

CREATE TABLE `galeria` (
  `id_imagen` int(11) NOT NULL,
  `id_planta` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `imagen` varchar(50) COLLATE latin1_spanish_ci NOT NULL
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
  `cat_UICN` enum('LC','NT','VU','EN','CR','EW','EX') COLLATE latin1_spanish_ci NOT NULL,
  `floracion` text COLLATE latin1_spanish_ci NOT NULL,
  `foto-general` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `foto-flor` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `foto-hoja` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `foto-fruto` varchar(50) COLLATE latin1_spanish_ci DEFAULT NULL,
  `galeria` varchar(50) COLLATE latin1_spanish_ci DEFAULT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre_usuario` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  `email_usuario` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  `pass_usuario` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  `tipo_usuario` varchar(3) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre_usuario`, `email_usuario`, `pass_usuario`, `tipo_usuario`) VALUES
(1, 'admin', 'admin@correo.com', 'admin', 'adm'),
(2, 'ana', 'ana@correo.com', 'ana', 'adm'),
(3, 'pepe', 'pepe@correo.com', 'pepe', 'usr');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `galeria`
--
ALTER TABLE `galeria`
  ADD PRIMARY KEY (`id_imagen`),
  ADD UNIQUE KEY `id_planta` (`id_planta`,`id_usuario`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `plantas`
--
ALTER TABLE `plantas`
  ADD PRIMARY KEY (`id_planta`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `galeria`
--
ALTER TABLE `galeria`
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
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `galeria`
--
ALTER TABLE `galeria`
  ADD CONSTRAINT `galeria_ibfk_1` FOREIGN KEY (`id_planta`) REFERENCES `plantas` (`id_planta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `galeria_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `plantas`
--
ALTER TABLE `plantas`
  ADD CONSTRAINT `plantas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

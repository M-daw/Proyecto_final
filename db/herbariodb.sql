-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-05-2020 a las 20:41:15
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
  `enlace_imagen` varchar(250) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `imagenes`
--

INSERT INTO `imagenes` (`id_imagen`, `id_planta`, `id_usuario`, `enlace_imagen`) VALUES
(1, 1, 1, './img/plantas/galerias/diplotaxis1.jpg'),
(3, 1, 1, './img/plantas/galerias/diplotaxis3.jpg'),
(4, 1, 1, './img/plantas/galerias/diplotaxis2.jpg'),
(5, 4, 1, './img/plantas/galerias/Cistus-albidus-1.jpg'),
(6, 4, 2, './img/plantas/galerias/Cistus-albidus-2.jpg'),
(7, 4, 2, './img/plantas/galerias/Cistus-albidus-3.jpg'),
(8, 4, 2, './img/plantas/galerias/Cistus-albidus-4.jpg'),
(9, 3, 2, './img/plantas/galerias/Lavatera-1.jpg'),
(10, 3, 2, './img/plantas/galerias/Lavatera-2.jpg'),
(11, 3, 2, './img/plantas/galerias/Lavatera-3.jpg'),
(12, 2, 2, './img/plantas/galerias/romero-1.jpg'),
(13, 2, 2, './img/plantas/galerias/romero-2.jpg'),
(14, 2, 2, './img/plantas/galerias/romero-3.jpg'),
(15, 6, 2, './img/plantas/galerias/cantaueso-1.JPG'),
(16, 4, 3, './img/plantas/galerias/Cistus-albidus-5.jpg'),
(17, 4, 3, './img/plantas/galerias/Cistus-albidus-6.jpg'),
(18, 6, 3, './img/plantas/galerias/cantaueso-2.jpg'),
(19, 6, 3, './img/plantas/galerias/cantaueso-3.jpg'),
(20, 6, 3, './img/plantas/galerias/cantaueso-4.jpg'),
(21, 6, 3, './img/plantas/galerias/cantaueso-5.jpg'),
(22, 3, 3, './img/plantas/galerias/Lavatera-4.jpg'),
(23, 3, 3, './img/plantas/galerias/Lavatera-5.jpg'),
(24, 3, 1, './img/plantas/galerias/Lavatera-7.jpg'),
(25, 5, 1, './img/plantas/galerias/Asphodelus-1.jpg'),
(26, 5, 1, './img/plantas/galerias/Asphodelus-2.jpg'),
(27, 5, 1, './img/plantas/galerias/Asphodelus-3.jpg'),
(28, 5, 1, './img/plantas/galerias/Asphodelus-4.jpg'),
(29, 5, 1, './img/plantas/galerias/Asphodelus-6.jpg'),
(30, 5, 1, './img/plantas/galerias/Asphodelus-7.jpg'),
(31, 2, 1, './img/plantas/galerias/romero-4.jpg'),
(32, 2, 1, './img/plantas/galerias/romero-5.jpg');

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
  `foto_general` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `foto_flor` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `foto_hoja` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `foto_fruto` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `plantas`
--

INSERT INTO `plantas` (`id_planta`, `nombre_cientifico`, `nombre_castellano`, `nombre_valenciano`, `nombre_ingles`, `familia`, `caracteres_diagnosticos`, `uso`, `biotipo`, `habitat`, `distribucion`, `cat_UICN`, `floracion`, `foto_general`, `foto_flor`, `foto_hoja`, `foto_fruto`, `id_usuario`) VALUES
(1, 'Diplotaxis erucoides', 'Oruga silvestre, rabaniza blanca, jaramago blanco', 'Ravenissa blanca, ravanell', 'white rocket, white wallrocket', 'Cruciferae', 'Es una planta herbácea con hojas irregulares y flores blancas de 4 pétalos con disposición en cruz, 6 estambres en 2 niveles. Presenta cáliz y estambres en la misma flor, también hay sépalos, que en el botón floral son densamente hirsutos.\r\nEs la única del género con flores de pétalos blancos. Alcanza un porte de 20-50 cm y sus hojas inferiores, que se agrupan en roseta, son oblongas, de pinnatífidas a pinnatipartidas, las superiores son sésiles y de base truncada o semiamplexicaule, raramente cuneada.\r\nEs una de las hierbas más abundantes durante el otoño y el invierno en los campos de cultivo, aunque puede estar en flor en cualquier época del año. Las semillas se encuentran en vainas dehiscentes con disposición en doble fila, raíz típica, alrededor de un eje central.', 'Alimento de ganado y aves domésticas', 'terófito', 'Habita frecuentemente en terrenos baldíos, bordes de los caminos y campos de cultivo', 'Cuenca Mediterránea', 'LC Preocupación menor', 'Todo', './img/plantas/fichas/diploeru-general.jpg', './img/plantas/fichas/diploeru-flor.jpg', './img/plantas/fichas/diploeru-hoja.jpg', './img/plantas/fichas/diploeru-fruto.jpg', 1),
(2, 'Rosmarinus officinalis', 'Romero', 'Romaní, romer', 'Rosemary', 'Lamiaceae', 'Arbusto perennifolio, siempre verde, muy ramificado, de hasta 1 metro de altura, aromático. \r\nHojas opuestas, lineares o linear-lanceoladas, gruesas, lustrosas, sésiles, con márgenes revolutos, verde brillantes por el haz y tomentoso-blanquecinas por el envés. \r\nInflorescencia en racimos de verticilastros paucifloros. \r\nFlores hermafroditas, zigomorfas. Cáliz campanulado, bilabiado. \r\nCorola bilabiada, labio superior cóncavo y bífido, labio inferior trilobado, de color azul claro hasta lila. Androceo con 2 estambres exertos. \r\nFruto formado por cuatro núculas de 1,5-3 por 1-2 mm, ovoides, aplanadas, color castaño claro con una mancha clara en la zona de inserción.', 'Es muy utilizado como condimentos para aromatizar platos de carne y salsas. \r\nEl alcohol de romero se utiliza para tratar dolores reumáticos y en lumbalgias. Es antiséptico y cicatrizante. En infusión alivia la tos se usa tratamiento sintomático de trastornos digestivos.', 'fanerófito', 'Preferentemente en matorrales basófilos de hasta 1200 m de altitud. Requiere de suelo ligero, seco y calizo, clima templado y exposición soleada.', 'Extendido por toda el área mediterránea.', 'LC Preocupación menor', 'De Septiembre a Junio', './img/plantas/fichas/rosmarinus-officinalis-general.jpg', './img/plantas/fichas/rosmarinus-officinalis-flores.jpg', './img/plantas/fichas/rosmarinus-officinalis-hojas.jpg', './img/plantas/fichas/rosmarinus-officinalis-fruto.jpg', 1),
(3, 'Lavatera cretica', 'Malva', 'Malva', 'Cornish mallow, Cretan hollyhock', 'Malvaceae', 'Planta anual o bienal, con pilosidad en las partes jóvenes. Las hojas, pecioladas, tienen un limbo de unos 20 cm de diámetro, suborbicular - cordado, con 5 - 7 lóbulos poco profundos y redondeados en las hojas basales y 5 más pronunciados, las medias y superiores.\r\nLas flores se disponen en fascículos axilares.\r\nPresentan un epicáliz formado por 3 segmentos casi libres. Tienen 5 sépalos. La corola está formada por 5 pétalos emarginados, de color violáceo o rosado. \r\nNumerosos estambres cuyos filamentos están soldados formando un tubo por el cual pasa el estilo.\r\nTiene un ovario súpero, formado por numerosos carpelos unidos en un verticilo, cuyos estilos están soldados formando uno.\r\nEl fruto es un esquizocarpo, formado por entre 7 y 9 mericarpos lisos o ligeramente acostillado.', 'En infusión se usa para problemas respiratorios como la bronquitis y la amigdalitis y como laxante ligero. De forma externa, se puede usar para aclarar manchas causadas por el Sol y el embarazo. Además, se usan para eliminar los forúnculos, combatir gingivitis y aftas, y para aliviar los dolores de', 'terófito', 'Crece en bordes de caminos, cunetas, escombreras, campos de cultivo, roquedos marinos.', 'Es originaria del sur y oeste de Europa hasta el suroestede Inglaterra, Macaronesia, norte de África y suroeste de Asia. Naturalizada en África del Sur y en algunas regiones de Norteamérica.', 'LC Preocupación menor', 'De Marzo a Septiembre', './img/plantas/fichas/1589409577Lavatera-cretica-general.jpg', './img/plantas/fichas/Lavatera-cretica-flor.jpg', './img/plantas/fichas/Lavatera-cretica-hoja.jpg', './img/plantas/fichas/Lavatera-cretica-fruto.jpg', 1),
(4, 'Cistus albidus', 'Jara blanca', 'Estepa blanca, bordiol blanc', 'Grey leaved cistus', 'Cistaceae', 'Arbusto espeso, con muchas ramas, erecto, algo aromático, de hasta 1,5 m de altura. Flores pentámeras, rosadas (raramente blancas), sobre pedúnculos alargados. Hojas planas de color verde grisáceo o blanquecinas, opuestas en cruz, abrazando el tallo. Fruto en cápsula, ovalado, de 6-8 mm de largo, con 5 lóculos.', 'Su resina se usaba como jarabe para la tos, y sus hojas, que son rugosas, para limpiar utensilios. Se usaba en infusión para aliviar dolores de estómago y como linimento', 'fanerófito', 'Suelos calcáreos, con clima cálido y seco', 'Cuenca del Mediterráneo, sobre todo en la península ibérica.', 'LC Preocupación menor', 'De marzo a julio', './img/plantas/fichas/cistus-albidus-general.jpg', './img/plantas/fichas/cistus-albidus-flor.jpg', './img/plantas/fichas/cistus-albidus-hoja.jpg', './img/plantas/fichas/cistus-albidus-fruto.jpg', 2),
(5, 'Asphodelus fistulosus', 'Vara de San José, gamoncillo', 'Cebollí', 'hollow stemmed asphodel, onionweed, onion leafed asphodel, pink asphodel', 'Xanthorrhoeaceae', 'Es una planta herbácea anual o perenne de corta duración con un tallo hueco de hasta 70 centímetros de altura. El sistema radical tiene una serie de tubérculos en la base del tallo. La planta tiene la forma de un gran mechón como hojas de cebolla, redondeadas y huecas de hasta 30 centímetros de largo. La inflorescencia es una panícula con flores muy separadas. Cada flor tiene de 5 a 12 milímetros de ancho, con seis tépalos, que son generalmente de color blanco o rosa muy pálido, con una clara franja longitudinal de color marrón-rojizo a morado. Las flores son diurnas, que se cierran por la noche y en días nublados. El fruto es una cápsula ovoide, dehiscente en 3 lóculos, cada uno con 2 semillas triédricas con profundas muescas, de color pardo.', 'Es una planta muy tóxica. Se usaba como ungüentos para heridas, tumores, moratones y callos.', 'hemicriptófito', 'Pastizales, estepas y arenales costeros, en substratos preferentemente básicos y ocasionalmente silíceos', 'Es nativa a la región mediterránea. Es una especie invasora en los Estados Unidos.  En México tiene una amplia distribución y se encuentra asociada a los cultivos.', 'LC Preocupación menor', 'De Enero a Junio', './img/plantas/fichas/asphodelus-general.jpg', './img/plantas/fichas/asphodelus-flor.jpg', './img/plantas/fichas/asphodelus-hoja.jpg', './img/plantas/fichas/1589475742asphodelus-fruto.jpg', 2),
(6, 'Thymus moroderi', 'Cantaeso', 'Cantaueso', '', 'Lamiaceae', 'Matita leñosa, pubescente, con glándulas amarillas. Brácteas violáceas, muy vistosas, amplias y formando una inflorescencia globular de la que surgen flores alargadas de color púrpura, excediendo bastante a los sépalos y las brácteas. Presenta un labio superior con 2 lóbulos cortos y labio inferior con 3 lóbulos iguales. Hojas lineares y revolutas. El fruto es una núcula.', 'Se toma en infusión al 2-3% como digestiva y antiséptica, especialmente indicada en digestiones pesadas. \r\nEn uso externo para curar heridas. \r\nSe usa para la elaboración del licor de cantueso por destilación alcohólica de la flor y el pedúnculo de la planta', 'caméfito', 'Matorrales secos calcáreos.', 'Iberolevantina', 'NT Casi amenazada', 'De Abril a Junio', './img/plantas/fichas/thymus-moroderi-general.jpg', './img/plantas/fichas/thymus-moroderi-flor.jpg', '', '', 1);

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
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre_usuario`, `email_usuario`, `pass_usuario`, `tipo_usuario`) VALUES
(1, 'admin', 'herbarioonline@gmail.com', 'Admin1', 'Administrador'),
(2, 'Colaborador', 'herbarioonline+col@gmail.com', 'Col1', 'Colaborador'),
(3, 'Usuario', 'herbarioonline+user@gmail.com', 'User1', 'Usuario');

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
  MODIFY `id_imagen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `plantas`
--
ALTER TABLE `plantas`
  MODIFY `id_planta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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

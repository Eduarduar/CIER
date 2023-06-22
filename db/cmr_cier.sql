-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-06-2023 a las 04:13:21
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `crm_cier`
--
CREATE DATABASE IF NOT EXISTS `crm_cier` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `crm_cier`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades`
--

CREATE TABLE `actividades` (
  `eCodeActividades` int(11) NOT NULL,
  `tTituloActividades` varchar(100) NOT NULL,
  `tImgsActividades` varchar(500) NOT NULL,
  `fCreateActividades` date NOT NULL DEFAULT current_timestamp(),
  `fUpdateActividades` date DEFAULT current_timestamp(),
  `eCreateActividades` int(11) NOT NULL,
  `eUpdateActividades` int(11) DEFAULT NULL,
  `bEstadoActividades` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estancias`
--

CREATE TABLE `estancias` (
  `eCodeEstancias` int(11) NOT NULL,
  `tNombreEstancias` varchar(100) NOT NULL,
  `tProvenienciaEstancias` varchar(100) NOT NULL,
  `tProyectoEstancias` varchar(100) NOT NULL,
  `fFechaEstancias` date NOT NULL DEFAULT current_timestamp(),
  `tInstalacionesEstancias` varchar(100) DEFAULT NULL,
  `eTipoEstancias` int(11) NOT NULL,
  `tLinksEstancias` varchar(1000) DEFAULT NULL,
  `tImgsEstancias` varchar(1000) NOT NULL,
  `fCreateEstancias` date NOT NULL DEFAULT current_timestamp(),
  `fUpdateEstancias` date DEFAULT current_timestamp(),
  `eCreateEstancias` int(11) NOT NULL,
  `eUpdateEstancias` int(11) DEFAULT NULL,
  `bEstadoEstancias` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estructuras`
--

CREATE TABLE `estructuras` (
  `eCodeEstructuras` int(11) NOT NULL,
  `tNombreEstructuras` varchar(100) NOT NULL,
  `tReglamentoEstructuras` varchar(100) NOT NULL,
  `tPdfEstructuras` varchar(100) NOT NULL,
  `fCreateEstructuras` date NOT NULL DEFAULT current_timestamp(),
  `fUpdateEstructuras` date DEFAULT current_timestamp(),
  `eCreateEstructuras` int(11) NOT NULL,
  `eUpdateEstructuras` int(11) DEFAULT NULL,
  `bEstadoEstructuras` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

CREATE TABLE `historial` (
  `eCodeHistorial` int(11) NOT NULL,
  `tAccionHistorial` varchar(100) NOT NULL,
  `eUsuarioHistorial` int(11) NOT NULL,
  `fCreateHistorial` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicaciones`
--

CREATE TABLE `publicaciones` (
  `eCodePublicaciones` int(11) NOT NULL,
  `eUserPublicaciones` int(11) NOT NULL,
  `tMensajePublicaciones` varchar(1000) NOT NULL,
  `tImgPublicaciones` varchar(100) DEFAULT NULL,
  `tPdfPublicaciones` varchar(100) DEFAULT NULL,
  `eTipoPublicaciones` int(11) NOT NULL,
  `fCreatePublicaciones` date NOT NULL DEFAULT current_timestamp(),
  `fUpdatePublicaciones` date DEFAULT current_timestamp(),
  `eUpdatePublicaciones` int(11) DEFAULT current_timestamp(),
  `bEstadoPublicaciones` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `eCodeRol` int(11) NOT NULL,
  `tNombreRol` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`eCodeRol`, `tNombreRol`) VALUES
(1, 'administrador'),
(2, 'coordinador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoestancia`
--

CREATE TABLE `tipoestancia` (
  `eCodeTipoEstancia` int(11) NOT NULL,
  `tNombreTipoEstancia` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipoestancia`
--

INSERT INTO `tipoestancia` (`eCodeTipoEstancia`, `tNombreTipoEstancia`) VALUES
(1, 'Postdoctorado'),
(2, 'Estancia corta de Investigación');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipopublicaciones`
--

CREATE TABLE `tipopublicaciones` (
  `eCodeTipoPublicaciones` int(11) NOT NULL,
  `tNombreTipoPublicaciones` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipopublicaciones`
--

INSERT INTO `tipopublicaciones` (`eCodeTipoPublicaciones`, `tNombreTipoPublicaciones`) VALUES
(1, 'Publicacion'),
(2, 'Divulgación'),
(3, 'Reporte Técnico '),
(4, 'Congreso'),
(5, 'Convenio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `eCodeUsuarios` int(11) NOT NULL,
  `tNombreUsuarios` varchar(100) NOT NULL,
  `tNumControlUsuarios` varchar(100) NOT NULL,
  `tContraUsuarios` varchar(100) NOT NULL,
  `eRolUsuarios` int(11) NOT NULL,
  `fCreateUsuarios` date NOT NULL DEFAULT current_timestamp(),
  `fUpdateUsuarios` date DEFAULT current_timestamp(),
  `bEstadoUsuarios` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`eCodeUsuarios`, `tNombreUsuarios`, `tNumControlUsuarios`, `tContraUsuarios`, `eRolUsuarios`, `fCreateUsuarios`, `fUpdateUsuarios`, `bEstadoUsuarios`) VALUES
(1, 'Admin', '0000', '$2y$10$lcmnytnzzJScvWIBROq2auTFaTHTjnc9gU7BlEyEwantAKZXiymPG', 1, '2023-06-21', NULL, 1),
(2, 'Coord', '0001', '$2y$10$lcmnytnzzJScvWIBROq2auTFaTHTjnc9gU7BlEyEwantAKZXiymPG', 2, '2023-06-21', NULL, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD PRIMARY KEY (`eCodeActividades`),
  ADD KEY `eCreateActividades` (`eCreateActividades`),
  ADD KEY `eUpdateActividades` (`eUpdateActividades`);

--
-- Indices de la tabla `estancias`
--
ALTER TABLE `estancias`
  ADD PRIMARY KEY (`eCodeEstancias`),
  ADD KEY `eCreateEstancias` (`eCreateEstancias`),
  ADD KEY `eUpdateEstancias` (`eUpdateEstancias`),
  ADD KEY `eTipoEstancia` (`eTipoEstancias`);

--
-- Indices de la tabla `estructuras`
--
ALTER TABLE `estructuras`
  ADD PRIMARY KEY (`eCodeEstructuras`),
  ADD KEY `eCreateEstructuras` (`eCreateEstructuras`),
  ADD KEY `eUpdateEstructuras` (`eUpdateEstructuras`);

--
-- Indices de la tabla `historial`
--
ALTER TABLE `historial`
  ADD PRIMARY KEY (`eCodeHistorial`),
  ADD KEY `eUsuarioHistorial` (`eUsuarioHistorial`);

--
-- Indices de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  ADD PRIMARY KEY (`eCodePublicaciones`),
  ADD KEY `eUserPublicaciones` (`eUserPublicaciones`),
  ADD KEY `eUpdatePublicaciones` (`eUpdatePublicaciones`),
  ADD KEY `eTipoPublicaciones` (`eTipoPublicaciones`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`eCodeRol`);

--
-- Indices de la tabla `tipoestancia`
--
ALTER TABLE `tipoestancia`
  ADD PRIMARY KEY (`eCodeTipoEstancia`);

--
-- Indices de la tabla `tipopublicaciones`
--
ALTER TABLE `tipopublicaciones`
  ADD PRIMARY KEY (`eCodeTipoPublicaciones`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`eCodeUsuarios`),
  ADD KEY `eRolUsuarios` (`eRolUsuarios`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividades`
--
ALTER TABLE `actividades`
  MODIFY `eCodeActividades` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estancias`
--
ALTER TABLE `estancias`
  MODIFY `eCodeEstancias` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estructuras`
--
ALTER TABLE `estructuras`
  MODIFY `eCodeEstructuras` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historial`
--
ALTER TABLE `historial`
  MODIFY `eCodeHistorial` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  MODIFY `eCodePublicaciones` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `eCodeRol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipoestancia`
--
ALTER TABLE `tipoestancia`
  MODIFY `eCodeTipoEstancia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipopublicaciones`
--
ALTER TABLE `tipopublicaciones`
  MODIFY `eCodeTipoPublicaciones` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `eCodeUsuarios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD CONSTRAINT `actividades_ibfk_1` FOREIGN KEY (`eCreateActividades`) REFERENCES `usuarios` (`eCodeUsuarios`) ON UPDATE CASCADE,
  ADD CONSTRAINT `actividades_ibfk_2` FOREIGN KEY (`eUpdateActividades`) REFERENCES `usuarios` (`eCodeUsuarios`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `estancias`
--
ALTER TABLE `estancias`
  ADD CONSTRAINT `estancias_ibfk_1` FOREIGN KEY (`eCreateEstancias`) REFERENCES `usuarios` (`eCodeUsuarios`) ON UPDATE CASCADE,
  ADD CONSTRAINT `estancias_ibfk_2` FOREIGN KEY (`eUpdateEstancias`) REFERENCES `usuarios` (`eCodeUsuarios`) ON UPDATE CASCADE,
  ADD CONSTRAINT `estancias_ibfk_3` FOREIGN KEY (`eTipoEstancias`) REFERENCES `tipoestancia` (`eCodeTipoEstancia`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `estructuras`
--
ALTER TABLE `estructuras`
  ADD CONSTRAINT `estructuras_ibfk_1` FOREIGN KEY (`eCreateEstructuras`) REFERENCES `usuarios` (`eCodeUsuarios`) ON UPDATE CASCADE,
  ADD CONSTRAINT `estructuras_ibfk_2` FOREIGN KEY (`eUpdateEstructuras`) REFERENCES `usuarios` (`eCodeUsuarios`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `historial`
--
ALTER TABLE `historial`
  ADD CONSTRAINT `historial_ibfk_1` FOREIGN KEY (`eUsuarioHistorial`) REFERENCES `usuarios` (`eCodeUsuarios`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  ADD CONSTRAINT `publicaciones_ibfk_1` FOREIGN KEY (`eUserPublicaciones`) REFERENCES `usuarios` (`eCodeUsuarios`) ON UPDATE CASCADE,
  ADD CONSTRAINT `publicaciones_ibfk_2` FOREIGN KEY (`eUpdatePublicaciones`) REFERENCES `usuarios` (`eCodeUsuarios`) ON UPDATE CASCADE,
  ADD CONSTRAINT `publicaciones_ibfk_3` FOREIGN KEY (`eTipoPublicaciones`) REFERENCES `tipopublicaciones` (`eCodeTipoPublicaciones`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`eRolUsuarios`) REFERENCES `roles` (`eCodeRol`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

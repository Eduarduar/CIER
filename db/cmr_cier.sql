-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-06-2023 a las 23:50:42
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
(2, 'Eduarduar', '1510', '$2y$10$tlmsGYicDw2kIYnzeYuV3ePvvTaL.D8CCV/4YgjQPyvaP5SYJM4f6', 1, '2023-06-11', '2023-06-17', 1),
(3, 'Saul Elizandro Madrigal Ortega', '2020', '$2y$10$3h6tRkNb0/uQy0IRaR2OJu5gBASR3gYIvHZHzXXAYKtSTKk9XH9GG', 1, '2023-06-15', '2023-06-17', 0),
(4, 'Marco Dair Martin Rojo', '1112', '$2y$10$3h6tRkNb0/uQy0IRaR2OJu5gBASR3gYIvHZHzXXAYKtSTKk9XH9GG', 2, '2023-06-15', '2023-06-17', 0),
(5, 'Víctor Manuel Cárdenas Galindo', '3131', '$2y$10$3h6tRkNb0/uQy0IRaR2OJu5gBASR3gYIvHZHzXXAYKtSTKk9XH9GG', 1, '2023-06-15', '2023-06-17', 1),
(12, 'Arturo Gael Duran Díaz', '5555', '$2y$10$/gnCIlhGFo7mO4nhqCa0iumPCoH5.WtZyt/t6ry15C3mSC3BMI866', 2, '2023-06-17', NULL, 1);

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
-- AUTO_INCREMENT de la tabla `historial`
--
ALTER TABLE `historial`
  MODIFY `eCodeHistorial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  MODIFY `eCodePublicaciones` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `eCodeRol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipopublicaciones`
--
ALTER TABLE `tipopublicaciones`
  MODIFY `eCodeTipoPublicaciones` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `eCodeUsuarios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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

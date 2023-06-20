-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-06-2023 a las 18:11:06
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

--
-- Volcado de datos para la tabla `actividades`
--

INSERT INTO `actividades` (`eCodeActividades`, `tTituloActividades`, `tImgsActividades`, `fCreateActividades`, `fUpdateActividades`, `eCreateActividades`, `eUpdateActividades`, `bEstadoActividades`) VALUES
(2, 'dasdasd', '../src/img/7DCt0w2I9t.jpg,../src/img/U0FoCiLEdp.jpg,../src/img/b97amGOvw8.jpg,../src/img/gO38akFwUY.jpg', '2023-06-18', '2023-06-19', 2, 2, 1),
(3, 'dsadasdvsjvb', '../src/img/pHyJIOJQnK.jpg,../src/img/bY6BQiVq3f.jpg,../src/img/43t44zuiaL.jpg,../src/img/X9fjwcRUgL.jpg', '2023-06-18', '2023-06-19', 2, 2, 1),
(4, 'dasdsad', '../src/img/NsiT9VEouR.jpg,../src/img/OSY86BRQcP.png,../src/img/WZBAhXu3Uo.jpg,../src/img/CnU9TejXl4.jpg', '2023-06-18', '2023-06-19', 2, 2, 1),
(5, 'dasdsad', '../src/img/ndsYDe5BoE.jpg,../src/img/x7FzVjXMM8.jpg,../src/img/6rmZBVlxgt.jpg,../src/img/eOeKGCE4nl.jpg', '2023-06-18', '2023-06-19', 2, 2, 1),
(6, 'asdsvvsdvsdvsdva', '../src/img/xEsg6vIJ9P.jpg,../src/img/WGRv0PkuWD.png,../src/img/6eTl6DfpEb.jpg,../src/img/563r5uKnnH.jpg', '2023-06-18', '2023-06-19', 2, 2, 1),
(7, 'adasdafasd', '../src/img/zZ5qlU6oAk.jpg,../src/img/D6ExyeJkBY.jpg,../src/img/bPomxNmvcY.jpg,../src/img/O3GEnMNMDJ.jpg', '2023-06-18', '2023-06-19', 2, 2, 0),
(8, 'asdasfdfasd', '../src/img/6SvzSx8481.jpg,../src/img/F6bm421ovx.jpg,../src/img/gFwSSUYo29.jpg,../src/img/1f7y5pTsm0.png', '2023-06-18', '2023-06-19', 2, 2, 0),
(10, 'nlkasjdvnlaksjdvnlkasdjv', '../src/img/O8idQNL2tf.webp,../src/img/J0V5EUrZgv.jpg,../src/img/TMPjprb93t.webp,../src/img/UZ7KtuTF76.jpg', '2023-06-18', '2023-06-19', 2, 2, 0),
(11, 'dadas', '../src/img/GQtToOq3fl.jpg', '2023-06-18', '2023-06-19', 2, 2, 0),
(12, 'Reportes del año', '../src/img/H3DBlWmVh2.jpg,../src/img/DhpEmItRld.jpg,../src/img/9w8g4BvTYD.jpg,../src/img/a0U7BZKUBm.jpg,../src/img/a9DXY9zLRF.jpg,../src/img/7UjbTLmhbg.jpg,../src/img/OYJTopjdJf.jpg,../src/img/7wp2Bn7pWm.jpg', '2023-06-19', '2023-06-19', 2, 2, 0),
(13, 'fgsdbvcbvs', '../src/img/50jKa6UKvS.jpg,../src/img/Ti0m1Oa85D.jpg,../src/img/lqQnfEmNmz.jpg,../src/img/XsvlofVXmv.jpg', '2023-06-19', '2023-06-19', 2, 2, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estancias`
--

CREATE TABLE `estancias` (
  `eCodeEstancias` int(11) NOT NULL,
  `tNombreEstancias` varchar(100) NOT NULL,
  `tProvenienciaEstancia` varchar(100) NOT NULL,
  `tProyectoEstancia` varchar(100) NOT NULL,
  `fFechaEstancia` date NOT NULL DEFAULT current_timestamp(),
  `tInstalacionesEstancias` varchar(100) DEFAULT NULL,
  `eTipoEstancia` int(11) NOT NULL,
  `tLinksEstancias` varchar(1000) DEFAULT NULL,
  `tImgsEstancias` varchar(1000) NOT NULL,
  `fCreateEstancias` date NOT NULL DEFAULT current_timestamp(),
  `fUpdateEstancias` date DEFAULT current_timestamp(),
  `eCreateEstancias` int(11) NOT NULL,
  `eUpdateEstancias` int(11) DEFAULT NULL,
  `bEstadoEstancias` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `estancias`
--

INSERT INTO `estancias` (`eCodeEstancias`, `tNombreEstancias`, `tProvenienciaEstancia`, `tProyectoEstancia`, `fFechaEstancia`, `tInstalacionesEstancias`, `eTipoEstancia`, `tLinksEstancias`, `tImgsEstancias`, `fCreateEstancias`, `fUpdateEstancias`, `eCreateEstancias`, `eUpdateEstancias`, `bEstadoEstancias`) VALUES
(1, '', '', '', '2023-06-19', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sequi tempora magnam cumque ullam ab volup', 1, 'https://www.youtube.com/watch?v=Qr4FPQxPx54&list=RDQr4FPQxPx54&start_radio=1 https://www.youtube.com/watch?v=D9G1VOjN_84&list=RDQr4FPQxPx54&index=2 https://www.youtube.com/watch?v=GQPnbH2y82o&list=RDQr4FPQxPx54&index=3 https://www.youtube.com/watch?v=X-iaGXyVOaE&list=RDQr4FPQxPx54&index=4 https://www.youtube.com/watch?v=t95ry4d56R8 https://www.facebook.com/plugins/video.php?height=314&href=https%3A%2F%2Fwww.facebook.com%2FYoSoyUTeM%2Fvideos%2F6243622942381449%2F&show_text=false&width=560&t=0', '../src/img/1f7y5pTsm0.png,../src/img/43t44zuiaL.jpg,../src/img/50jKa6UKvS.jpg,../src/img/6eTl6DfpEb.jpg', '2023-06-19', NULL, 2, NULL, 1),
(2, '', '', '', '2023-06-19', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sequi tempora magnam cumque ullam ab volup', 2, 'https://www.youtube.com/watch?v=Qr4FPQxPx54&list=RDQr4FPQxPx54&start_radio=1 https://www.youtube.com/watch?v=D9G1VOjN_84&list=RDQr4FPQxPx54&index=2 https://www.youtube.com/watch?v=GQPnbH2y82o&list=RDQr4FPQxPx54&index=3 https://www.youtube.com/watch?v=X-iaGXyVOaE&list=RDQr4FPQxPx54&index=4 https://www.youtube.com/watch?v=t95ry4d56R8 https://www.facebook.com/plugins/video.php?height=314&href=https%3A%2F%2Fwww.facebook.com%2FYoSoyUTeM%2Fvideos%2F6243622942381449%2F&show_text=false&width=560&t=0', '../src/img/1f7y5pTsm0.png,../src/img/43t44zuiaL.jpg,../src/img/50jKa6UKvS.jpg,../src/img/6eTl6DfpEb.jpg', '2023-06-19', NULL, 2, NULL, 1);

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

--
-- Volcado de datos para la tabla `historial`
--

INSERT INTO `historial` (`eCodeHistorial`, `tAccionHistorial`, `eUsuarioHistorial`, `fCreateHistorial`) VALUES
(95, 'Inicio sesión', 2, '2023-06-18'),
(96, 'Inicio sesión', 2, '2023-06-18'),
(97, 'Inicio sesión', 2, '2023-06-18'),
(98, 'Inicio sesión', 2, '2023-06-18'),
(99, 'Inicio sesión', 2, '2023-06-19'),
(100, 'Inicio sesión', 2, '2023-06-19'),
(101, 'Inicio sesión', 2, '2023-06-19'),
(102, 'Inicio sesión', 2, '2023-06-19'),
(103, 'Inicio sesión', 2, '2023-06-20');

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
-- Indices de la tabla `estancias`
--
ALTER TABLE `estancias`
  ADD PRIMARY KEY (`eCodeEstancias`),
  ADD KEY `eCreateEstancias` (`eCreateEstancias`),
  ADD KEY `eUpdateEstancias` (`eUpdateEstancias`),
  ADD KEY `eTipoEstancia` (`eTipoEstancia`);

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
  MODIFY `eCodeActividades` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `estancias`
--
ALTER TABLE `estancias`
  MODIFY `eCodeEstancias` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `historial`
--
ALTER TABLE `historial`
  MODIFY `eCodeHistorial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  MODIFY `eCodePublicaciones` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

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
-- Filtros para la tabla `estancias`
--
ALTER TABLE `estancias`
  ADD CONSTRAINT `estancias_ibfk_1` FOREIGN KEY (`eCreateEstancias`) REFERENCES `usuarios` (`eCodeUsuarios`) ON UPDATE CASCADE,
  ADD CONSTRAINT `estancias_ibfk_2` FOREIGN KEY (`eUpdateEstancias`) REFERENCES `usuarios` (`eCodeUsuarios`) ON UPDATE CASCADE,
  ADD CONSTRAINT `estancias_ibfk_3` FOREIGN KEY (`eTipoEstancia`) REFERENCES `tipoestancia` (`eCodeTipoEstancia`) ON UPDATE CASCADE;

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

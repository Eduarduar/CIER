

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

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


CREATE TABLE `estancias` (
  `eCodeEstancias` int(11) NOT NULL,
  `tTextoEstancias` varchar(1000) NOT NULL,
  `tYoutubeEstancias` varchar(1000) NOT NULL,
  `tImgsEstancias` varchar(1000) NOT NULL,
  `fCreateEstancias` date NOT NULL DEFAULT current_timestamp(),
  `fUpdateEstancias` date DEFAULT current_timestamp(),
  `eCreateEstancias` int(11) NOT NULL,
  `eUpdateEstancias` int(11) DEFAULT NULL,
  `bEstadoEstancias` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `historial` (
  `eCodeHistorial` int(11) NOT NULL,
  `tAccionHistorial` varchar(100) NOT NULL,
  `eUsuarioHistorial` int(11) NOT NULL,
  `fCreateHistorial` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `historial` (`eCodeHistorial`, `tAccionHistorial`, `eUsuarioHistorial`, `fCreateHistorial`) VALUES
(95, 'Inicio sesión', 2, '2023-06-18'),
(96, 'Inicio sesión', 2, '2023-06-18'),
(97, 'Inicio sesión', 2, '2023-06-18'),
(98, 'Inicio sesión', 2, '2023-06-18'),
(99, 'Inicio sesión', 2, '2023-06-19'),
(100, 'Inicio sesión', 2, '2023-06-19');

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

CREATE TABLE `roles` (
  `eCodeRol` int(11) NOT NULL,
  `tNombreRol` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `roles` (`eCodeRol`, `tNombreRol`) VALUES
(1, 'administrador'),
(2, 'coordinador');

CREATE TABLE `tipopublicaciones` (
  `eCodeTipoPublicaciones` int(11) NOT NULL,
  `tNombreTipoPublicaciones` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tipopublicaciones` (`eCodeTipoPublicaciones`, `tNombreTipoPublicaciones`) VALUES
(1, 'Publicacion'),
(2, 'Divulgación'),
(3, 'Reporte Técnico '),
(4, 'Congreso'),
(5, 'Convenio');

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

INSERT INTO `usuarios` (`eCodeUsuarios`, `tNombreUsuarios`, `tNumControlUsuarios`, `tContraUsuarios`, `eRolUsuarios`, `fCreateUsuarios`, `fUpdateUsuarios`, `bEstadoUsuarios`) VALUES
(2, 'Eduarduar', '1510', '$2y$10$tlmsGYicDw2kIYnzeYuV3ePvvTaL.D8CCV/4YgjQPyvaP5SYJM4f6', 1, '2023-06-11', '2023-06-17', 1),
(3, 'Saul Elizandro Madrigal Ortega', '2020', '$2y$10$3h6tRkNb0/uQy0IRaR2OJu5gBASR3gYIvHZHzXXAYKtSTKk9XH9GG', 1, '2023-06-15', '2023-06-17', 0),
(4, 'Marco Dair Martin Rojo', '1112', '$2y$10$3h6tRkNb0/uQy0IRaR2OJu5gBASR3gYIvHZHzXXAYKtSTKk9XH9GG', 2, '2023-06-15', '2023-06-17', 0),
(5, 'Víctor Manuel Cárdenas Galindo', '3131', '$2y$10$3h6tRkNb0/uQy0IRaR2OJu5gBASR3gYIvHZHzXXAYKtSTKk9XH9GG', 1, '2023-06-15', '2023-06-17', 1),
(12, 'Arturo Gael Duran Díaz', '5555', '$2y$10$/gnCIlhGFo7mO4nhqCa0iumPCoH5.WtZyt/t6ry15C3mSC3BMI866', 2, '2023-06-17', NULL, 1);

ALTER TABLE `actividades`
  ADD PRIMARY KEY (`eCodeActividades`),
  ADD KEY `eCreateActividades` (`eCreateActividades`),
  ADD KEY `eUpdateActividades` (`eUpdateActividades`);

ALTER TABLE `estancias`
  ADD PRIMARY KEY (`eCodeEstancias`),
  ADD KEY `eCreateEstancias` (`eCreateEstancias`),
  ADD KEY `eUpdateEstancias` (`eUpdateEstancias`);

ALTER TABLE `historial`
  ADD PRIMARY KEY (`eCodeHistorial`),
  ADD KEY `eUsuarioHistorial` (`eUsuarioHistorial`);

ALTER TABLE `publicaciones`
  ADD PRIMARY KEY (`eCodePublicaciones`),
  ADD KEY `eUserPublicaciones` (`eUserPublicaciones`),
  ADD KEY `eUpdatePublicaciones` (`eUpdatePublicaciones`),
  ADD KEY `eTipoPublicaciones` (`eTipoPublicaciones`);

ALTER TABLE `roles`
  ADD PRIMARY KEY (`eCodeRol`);

ALTER TABLE `tipopublicaciones`
  ADD PRIMARY KEY (`eCodeTipoPublicaciones`);

ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`eCodeUsuarios`),
  ADD KEY `eRolUsuarios` (`eRolUsuarios`);

ALTER TABLE `actividades`
  MODIFY `eCodeActividades` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

ALTER TABLE `estancias`
  MODIFY `eCodeEstancias` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `historial`
  MODIFY `eCodeHistorial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

ALTER TABLE `publicaciones`
  MODIFY `eCodePublicaciones` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

ALTER TABLE `roles`
  MODIFY `eCodeRol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `tipopublicaciones`
  MODIFY `eCodeTipoPublicaciones` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `usuarios`
  MODIFY `eCodeUsuarios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

ALTER TABLE `actividades`
  ADD CONSTRAINT `actividades_ibfk_1` FOREIGN KEY (`eCreateActividades`) REFERENCES `usuarios` (`eCodeUsuarios`) ON UPDATE CASCADE,
  ADD CONSTRAINT `actividades_ibfk_2` FOREIGN KEY (`eUpdateActividades`) REFERENCES `usuarios` (`eCodeUsuarios`) ON UPDATE CASCADE;

ALTER TABLE `estancias`
  ADD CONSTRAINT `estancias_ibfk_1` FOREIGN KEY (`eCreateEstancias`) REFERENCES `usuarios` (`eCodeUsuarios`) ON UPDATE CASCADE,
  ADD CONSTRAINT `estancias_ibfk_2` FOREIGN KEY (`eUpdateEstancias`) REFERENCES `usuarios` (`eCodeUsuarios`) ON UPDATE CASCADE;

ALTER TABLE `historial`
  ADD CONSTRAINT `historial_ibfk_1` FOREIGN KEY (`eUsuarioHistorial`) REFERENCES `usuarios` (`eCodeUsuarios`) ON UPDATE CASCADE;

ALTER TABLE `publicaciones`
  ADD CONSTRAINT `publicaciones_ibfk_1` FOREIGN KEY (`eUserPublicaciones`) REFERENCES `usuarios` (`eCodeUsuarios`) ON UPDATE CASCADE,
  ADD CONSTRAINT `publicaciones_ibfk_2` FOREIGN KEY (`eUpdatePublicaciones`) REFERENCES `usuarios` (`eCodeUsuarios`) ON UPDATE CASCADE,
  ADD CONSTRAINT `publicaciones_ibfk_3` FOREIGN KEY (`eTipoPublicaciones`) REFERENCES `tipopublicaciones` (`eCodeTipoPublicaciones`) ON UPDATE CASCADE;

ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`eRolUsuarios`) REFERENCES `roles` (`eCodeRol`) ON UPDATE CASCADE;
COMMIT;




-- CREATE TABLE `estancias` (
--   `eCodeEstancias` int(11) NOT NULL,
--   `tTextoEstancias` varchar(1000) NOT NULL,
--   `tYoutubeEstancias` varchar(1000) NOT NULL,
--   `tImgsEstancias` varchar(1000) NOT NULL,
--   `fCreateEstancias` date NOT NULL DEFAULT current_timestamp(),
--   `fUpdateEstancias` date DEFAULT current_timestamp(),
--   `eCreateEstancias` int(11) NOT NULL,
--   `eUpdateEstancias` int(11) DEFAULT NULL,
--   `bEstadoEstancias` tinyint(1) NOT NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ALTER TABLE `estancias`
--   MODIFY `eCodeEstancias` int(11) NOT NULL AUTO_INCREMENT;

-- CREATE TABLE `usuarios` (
--   `eCodeUsuarios` int(11) NOT NULL,
--   `tNombreUsuarios` varchar(100) NOT NULL,
--   `tNumControlUsuarios` varchar(100) NOT NULL,
--   `tContraUsuarios` varchar(100) NOT NULL,
--   `eRolUsuarios` int(11) NOT NULL,
--   `fCreateUsuarios` date NOT NULL DEFAULT current_timestamp(),
--   `fUpdateUsuarios` date DEFAULT current_timestamp(),
--   `bEstadoUsuarios` tinyint(1) NOT NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ALTER TABLE `usuarios`
--   MODIFY `eCodeUsuarios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

-- ALTER TABLE `estancias`
--   ADD CONSTRAINT `estancias_ibfk_1` FOREIGN KEY (`eCreateEstancias`) REFERENCES `usuarios` (`eCodeUsuarios`) ON UPDATE CASCADE,
--   ADD CONSTRAINT `estancias_ibfk_2` FOREIGN KEY (`eUpdateEstancias`) REFERENCES `usuarios` (`eCodeUsuarios`) ON UPDATE CASCADE;
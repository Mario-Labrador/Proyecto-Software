-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-04-2025 a las 17:46:28
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gestor`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `dni` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`dni`) VALUES
('123456789'),
('a');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contrato`
--

CREATE TABLE `contrato` (
  `idContrato` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `lugar` varchar(255) NOT NULL,
  `dni` varchar(255) NOT NULL,
  `idEmpresa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contratoservicio`
--

CREATE TABLE `contratoservicio` (
  `idContrato` int(11) NOT NULL,
  `idServicio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `idEmpresa` int(11) NOT NULL,
  `nombreEmpresa` varchar(255) NOT NULL,
  `telefonoEmpresa` int(11) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `correoDirector` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`idEmpresa`, `nombreEmpresa`, `telefonoEmpresa`, `direccion`, `correoDirector`) VALUES
(1, 'yatuchaberia', 0, 'calle yatu', 'pancho@gmail.com'),
(1234, 'Si', 123, 'Si', 'Si'),
(111111, 'Empresa2', 99928, 'C/ tu carita', 'directo2@test'),
(123456, 'Empresa1 ', 123, 'C/joseante ', 'director1@test');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formapago`
--

CREATE TABLE `formapago` (
  `idContrato` int(11) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paypal`
--

CREATE TABLE `paypal` (
  `idContrato` int(11) NOT NULL,
  `correo` int(11) NOT NULL,
  `contraseña` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `dni` varchar(255) NOT NULL,
  `nombrePersona` varchar(255) NOT NULL,
  `apellidosPersona` varchar(255) NOT NULL,
  `emailPersona` varchar(255) NOT NULL,
  `contrasenyaPersona` varchar(255) NOT NULL,
  `telefonoPersona` int(11) NOT NULL,
  `fechaNacimiento` date NOT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`dni`, `nombrePersona`, `apellidosPersona`, `emailPersona`, `contrasenyaPersona`, `telefonoPersona`, `fechaNacimiento`, `foto_perfil`) VALUES
('00000', 'masca', 'tuna', 'masca@gmail.com', '$2y$10$NdECXFH03IfPFdCHpaHE/.NmaLTxIuZ3hYSr89svMB8v4C8Qvuxwa', 0, '2000-01-01', NULL),
('123456789', 'yatu', 'sabe', 'yatusa@gmail.com', '$2y$10$RpdZMFsMIEMuZbSuSayOSe7dOshzHt15gdBElhgIAML/RU2lskKDe', 999000888, '1999-12-12', NULL),
('23123123', 'testTrabajador2', 'testTrabajador2', 'tt@test', '$2y$10$UI5lPUc5vMyhcEEc8nQDiuNynKOaU/Km1PGepO5XAUyx8moHWLNxe', 123333, '2025-04-10', NULL),
('565656', 'panecho', 'panecho', 'pancho@gmail.com', '$2y$10$qd8AsyHRC4OGUv4hi80GoOXePQvpP5Pyl3/VfN93kaNRrnOFcqjJm', 565656, '1956-06-05', '../assets/uploads/default.png'),
('77215141R', 'testTrabajadorNombre', 'testTrabajadorApellido', 'testTrabajador@test', '$2y$10$8bz5lpnUaQLM4MgjkKEB3u4/MtgRje9/gviJ7Y8nj/EcQGMmhI61e', 123456, '2025-04-10', NULL),
('876543', 'Sisisisisi', 'nonononnono', 'director1@test', '$2y$10$gwQTWzFHnUGW2qhyJMvcT.gVEh5hkAh50A4UPYCRevdpzQAr7ZKe2', 2147483647, '2025-04-18', NULL),
('a', 'a', 'a', 'a@a', '$2y$10$fFY4EcdfMLgncvQCo82wLegQlXgDiqPwKdTWl49oD6kMD.k/y2ew.', 1, '0000-00-00', '../assets/uploads/foto_a.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `idServicio` int(11) NOT NULL,
  `precio` int(11) NOT NULL,
  `nombreServicio` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `sueldo` int(11) NOT NULL,
  `horas` int(11) NOT NULL,
  `idEmpresa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicio`
--

INSERT INTO `servicio` (`idServicio`, `precio`, `nombreServicio`, `descripcion`, `sueldo`, `horas`, `idEmpresa`) VALUES
(1, 50, 'Limpieza Piso/Apartamento Completa', 'Limpieza', 20, 2, 123456),
(2, 100, 'Limpieza prueba', 'limpieza', 50, 1, 1),
(3, 120, 'tusaaaaa', 'tuassasasa', 1, 1, 1),
(4, 20, 'alberto gei', 'si', 10, 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudempleo`
--

CREATE TABLE `solicitudempleo` (
  `idSolicitud` int(11) NOT NULL,
  `dniTrabajador` varchar(255) NOT NULL,
  `idEmpresa` int(11) NOT NULL,
  `fechaSolicitud` date NOT NULL DEFAULT curdate(),
  `estado` enum('pendiente','aceptada','rechazada') DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitudempleo`
--

INSERT INTO `solicitudempleo` (`idSolicitud`, `dniTrabajador`, `idEmpresa`, `fechaSolicitud`, `estado`) VALUES
(2, '23123123', 1234, '2025-04-23', 'pendiente'),
(3, '23123123', 111111, '2025-04-23', 'pendiente'),
(8, '00000', 123456, '2025-04-26', 'pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarjeta`
--

CREATE TABLE `tarjeta` (
  `idContrato` int(11) NOT NULL,
  `numeroTarjeta` int(11) NOT NULL,
  `cvv` int(11) NOT NULL,
  `fechaExpiracion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajador`
--

CREATE TABLE `trabajador` (
  `rol` varchar(255) NOT NULL,
  `especialidad` varchar(255) DEFAULT NULL,
  `dni` varchar(255) NOT NULL,
  `idEmpresa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `trabajador`
--

INSERT INTO `trabajador` (`rol`, `especialidad`, `dni`, `idEmpresa`) VALUES
('empleado', NULL, '00000', NULL),
('empleado', NULL, '23123123', 123456),
('administrador', NULL, '565656', 1),
('empleado', NULL, '77215141R', 1234),
('administrador', NULL, '876543', 123456);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valoracion`
--

CREATE TABLE `valoracion` (
  `nota` int(11) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `idContrato` int(11) NOT NULL,
  `idServicio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`dni`);

--
-- Indices de la tabla `contrato`
--
ALTER TABLE `contrato`
  ADD PRIMARY KEY (`idContrato`),
  ADD KEY `dni` (`dni`),
  ADD KEY `fk_idEmpresa` (`idEmpresa`);

--
-- Indices de la tabla `contratoservicio`
--
ALTER TABLE `contratoservicio`
  ADD PRIMARY KEY (`idContrato`,`idServicio`),
  ADD KEY `idServicio` (`idServicio`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`idEmpresa`);

--
-- Indices de la tabla `formapago`
--
ALTER TABLE `formapago`
  ADD PRIMARY KEY (`idContrato`);

--
-- Indices de la tabla `paypal`
--
ALTER TABLE `paypal`
  ADD PRIMARY KEY (`idContrato`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`dni`),
  ADD UNIQUE KEY `emailPersona` (`emailPersona`),
  ADD UNIQUE KEY `telefonoPersona` (`telefonoPersona`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`idServicio`),
  ADD KEY `idEmpresa` (`idEmpresa`);

--
-- Indices de la tabla `solicitudempleo`
--
ALTER TABLE `solicitudempleo`
  ADD PRIMARY KEY (`idSolicitud`),
  ADD KEY `fk_trabajador` (`dniTrabajador`),
  ADD KEY `fk_empresa` (`idEmpresa`);

--
-- Indices de la tabla `tarjeta`
--
ALTER TABLE `tarjeta`
  ADD PRIMARY KEY (`idContrato`);

--
-- Indices de la tabla `trabajador`
--
ALTER TABLE `trabajador`
  ADD PRIMARY KEY (`dni`),
  ADD KEY `idEmpresa` (`idEmpresa`);

--
-- Indices de la tabla `valoracion`
--
ALTER TABLE `valoracion`
  ADD PRIMARY KEY (`idContrato`,`idServicio`),
  ADD KEY `idServicio` (`idServicio`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `idServicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `solicitudempleo`
--
ALTER TABLE `solicitudempleo`
  MODIFY `idSolicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `cliente_ibfk_1` FOREIGN KEY (`dni`) REFERENCES `persona` (`dni`);

--
-- Filtros para la tabla `contrato`
--
ALTER TABLE `contrato`
  ADD CONSTRAINT `contrato_ibfk_1` FOREIGN KEY (`dni`) REFERENCES `cliente` (`dni`),
  ADD CONSTRAINT `fk_idEmpresa` FOREIGN KEY (`idEmpresa`) REFERENCES `empresa` (`idEmpresa`) ON DELETE CASCADE;

--
-- Filtros para la tabla `contratoservicio`
--
ALTER TABLE `contratoservicio`
  ADD CONSTRAINT `contratoservicio_ibfk_1` FOREIGN KEY (`idContrato`) REFERENCES `contrato` (`idContrato`),
  ADD CONSTRAINT `contratoservicio_ibfk_2` FOREIGN KEY (`idServicio`) REFERENCES `servicio` (`idServicio`);

--
-- Filtros para la tabla `formapago`
--
ALTER TABLE `formapago`
  ADD CONSTRAINT `formapago_ibfk_1` FOREIGN KEY (`idContrato`) REFERENCES `contrato` (`idContrato`);

--
-- Filtros para la tabla `paypal`
--
ALTER TABLE `paypal`
  ADD CONSTRAINT `paypal_ibfk_1` FOREIGN KEY (`idContrato`) REFERENCES `formapago` (`idContrato`);

--
-- Filtros para la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD CONSTRAINT `servicio_ibfk_1` FOREIGN KEY (`idEmpresa`) REFERENCES `empresa` (`idEmpresa`);

--
-- Filtros para la tabla `solicitudempleo`
--
ALTER TABLE `solicitudempleo`
  ADD CONSTRAINT `fk_empresa` FOREIGN KEY (`idEmpresa`) REFERENCES `empresa` (`idEmpresa`),
  ADD CONSTRAINT `fk_trabajador` FOREIGN KEY (`dniTrabajador`) REFERENCES `trabajador` (`dni`);

--
-- Filtros para la tabla `tarjeta`
--
ALTER TABLE `tarjeta`
  ADD CONSTRAINT `tarjeta_ibfk_1` FOREIGN KEY (`idContrato`) REFERENCES `formapago` (`idContrato`);

--
-- Filtros para la tabla `trabajador`
--
ALTER TABLE `trabajador`
  ADD CONSTRAINT `trabajador_ibfk_1` FOREIGN KEY (`idEmpresa`) REFERENCES `empresa` (`idEmpresa`),
  ADD CONSTRAINT `trabajador_ibfk_2` FOREIGN KEY (`dni`) REFERENCES `persona` (`dni`);

--
-- Filtros para la tabla `valoracion`
--
ALTER TABLE `valoracion`
  ADD CONSTRAINT `valoracion_ibfk_1` FOREIGN KEY (`idContrato`) REFERENCES `contratoservicio` (`idContrato`),
  ADD CONSTRAINT `valoracion_ibfk_2` FOREIGN KEY (`idServicio`) REFERENCES `contratoservicio` (`idServicio`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

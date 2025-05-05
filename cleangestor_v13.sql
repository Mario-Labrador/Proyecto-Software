-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-05-2025 a las 02:43:25
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
('98765432Z');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contrato`
--

CREATE TABLE `contrato` (
  `idContrato` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `lugar` varchar(255) NOT NULL,
  `dni` varchar(255) NOT NULL,
  `estado` enum('abierto','finalizado') DEFAULT 'abierto'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contratoservicio`
--

CREATE TABLE `contratoservicio` (
  `idContrato` int(11) NOT NULL,
  `idServicio` int(11) NOT NULL,
  `dni` varchar(255) DEFAULT NULL
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
(1, 'Limpiezas Sol', 912345678, 'Calle Mayor 10, Madrid', 'director@limpiezassol.com'),
(2, 'Brillo Total', 934567890, 'Av. Diagonal 200, Barcelona', 'info@brillototal.es'),
(3, 'EcoClean', 955123456, 'Av. Andalucía 50, Sevilla', 'contacto@ecoclean.es');

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
('11223344V', 'Lucía', 'Martín Castro', 'lucia.martin@hotmail.com', '$2y$10$lAOgqsgodfiNT/ST7yMGSeooNyiRFumFg8dEGyTr/BG/Fu4JGLSWS', 611223344, '1993-03-15', NULL),
('11224433R', 'Sofía', 'López Martín', 'sofia.lopez@hotmail.com', '$2y$10$GVs4fGysDUnZwuSgf98zO.ycIAC1Ia9zeCpNmWsucUU8fkwbqvdw6', 611223355, '2002-02-22', NULL),
('12345678A', 'Laura', 'Martínez López', 'director@limpiezassol.com', '$2y$10$6sh6wgQ/aqNu2EgLkGXcCe07QfLH5c7Nw48BmOSa6MjrMPQtabrTu', 912345678, '1980-05-12', NULL),
('23456789B', 'Pablo', 'García Torres', 'info@brillototal.es', '$2y$10$RkRi2UPm8olrwZFDHDA20OQ20sgcKpk4b4HrH6dKZdsv8GlULGsHm', 934567890, '1975-09-22', NULL),
('34567890C', 'Marta', 'Ruiz Sánchez', 'contacto@ecoclean.es', '$2y$10$D5KjBczb0vV1DDsjVSkk2u4aw6i5M61Ovh2IDObFIZIm8q80QM4t2', 955123456, '1988-03-30', NULL),
('55443322W', 'David', 'Sánchez Pérez', 'david.sanchez@gmail.com', '$2y$10$8Q6.fBHKBU.AsFetMMRBcO9GxDtmXoqvutSm4F6NJSUS7L7c/EHgW', 655443322, '1987-11-08', NULL),
('87654321X', 'Ana', 'Gómez Jiménez', 'ana.gomez@outlook.com', '$2y$10$Jo2gMyARa.YHNKRblB/uxOs6GICxFKr1Qiy71JYwDIpTCvQj21s7a', 677889900, '1983-07-25', NULL),
('98765432Z', 'Mateo', 'Fernández Ruiz', 'mateo.fernandez@gmail.com', '$2y$10$AlJsHDVud2Qs2dEnl7zGQu0dlr2/fk6eg/j/NPaOdu5hZIIjqL1Ku', 699112233, '1990-04-20', NULL);

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
  `fotoServicio` varchar(255) DEFAULT NULL,
  `idEmpresa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(11, '11224433R', 2, '2025-05-05', 'pendiente');

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
('empleado', NULL, '11223344V', 2),
('empleado', NULL, '11224433R', NULL),
('administrador', NULL, '12345678A', 1),
('administrador', NULL, '23456789B', 2),
('administrador', NULL, '34567890C', 3),
('empleado', NULL, '55443322W', 1),
('empleado', NULL, '87654321X', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valoracion`
--

CREATE TABLE `valoracion` (
  `nota` int(11) NOT NULL,
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
  ADD KEY `dni` (`dni`);

--
-- Indices de la tabla `contratoservicio`
--
ALTER TABLE `contratoservicio`
  ADD PRIMARY KEY (`idContrato`,`idServicio`),
  ADD KEY `idServicio` (`idServicio`),
  ADD KEY `dni` (`dni`);

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
-- AUTO_INCREMENT de la tabla `contrato`
--
ALTER TABLE `contrato`
  MODIFY `idContrato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `idServicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `solicitudempleo`
--
ALTER TABLE `solicitudempleo`
  MODIFY `idSolicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
  ADD CONSTRAINT `contrato_ibfk_1` FOREIGN KEY (`dni`) REFERENCES `cliente` (`dni`);

--
-- Filtros para la tabla `contratoservicio`
--
ALTER TABLE `contratoservicio`
  ADD CONSTRAINT `contratoservicio_ibfk_1` FOREIGN KEY (`idContrato`) REFERENCES `contrato` (`idContrato`),
  ADD CONSTRAINT `contratoservicio_ibfk_2` FOREIGN KEY (`idServicio`) REFERENCES `servicio` (`idServicio`),
  ADD CONSTRAINT `contratoservicio_ibfk_3` FOREIGN KEY (`dni`) REFERENCES `trabajador` (`dni`);

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

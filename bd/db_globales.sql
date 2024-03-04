-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-03-2024 a las 16:43:58
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_globales`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_altas`
--

CREATE TABLE `registro_altas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `fecha_baja` date NOT NULL,
  `fecha_reingreso` date NOT NULL,
  `fecha_segunda_baja` date NOT NULL,
  `telefono_celular` int(15) NOT NULL,
  `correo_electronico` varchar(255) NOT NULL,
  `telefono_casa` int(15) NOT NULL,
  `nombre_contacto` varchar(255) NOT NULL,
  `telefono_contacto` int(15) NOT NULL,
  `num_seguro` int(50) NOT NULL,
  `alta_seguro` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_empleados`
--

CREATE TABLE `registro_empleados` (
  `id` int(11) NOT NULL,
  `nombre_completo` varchar(255) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `estatus` enum('activo','inactivo') NOT NULL,
  `telefono_celular` varchar(15) NOT NULL,
  `correo_electronico` varchar(255) NOT NULL,
  `nombre_contacto` varchar(255) DEFAULT NULL,
  `telefono_contacto` varchar(15) DEFAULT NULL,
  `sueldo_quincenal` decimal(10,2) NOT NULL,
  `horario_trabajo` varchar(255) NOT NULL,
  `numero_seguridad_social` varchar(20) DEFAULT NULL,
  `fecha_alta_seguro_social` date DEFAULT NULL,
  `redes_sociales` varchar(255) DEFAULT NULL,
  `area_asignada` varchar(255) DEFAULT NULL,
  `archivos` varchar(255) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `carpeta_drive_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_login`
--

CREATE TABLE `registro_login` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `contrasena` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `registro_login`
--

INSERT INTO `registro_login` (`id`, `nombre`, `usuario`, `contrasena`) VALUES
(1, 'admin', 'admin', 'admin1'),
(3, 'Administrador 1', 'Admin_1', 'Administrador2023'),
(4, 'Administrador 2', 'Admin_2', 'Administrador2022'),
(5, 'Administrador 3', 'admin_3', 'Administrador2021'),
(6, 'Nash', 'nash', 'nash.admin123'),
(7, 'Elizabeth Molina', 'elizabeth', 'elizabeth.2023'),
(8, 'Alizbeth Molina', 'alizbeth', 'alizbeth.2023'),
(9, 'Maria Jose Echeverria', 'm.jose.echeverria', 'echeverria123@');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `registro_altas`
--
ALTER TABLE `registro_altas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `registro_empleados`
--
ALTER TABLE `registro_empleados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `registro_login`
--
ALTER TABLE `registro_login`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `registro_altas`
--
ALTER TABLE `registro_altas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `registro_empleados`
--
ALTER TABLE `registro_empleados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `registro_login`
--
ALTER TABLE `registro_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

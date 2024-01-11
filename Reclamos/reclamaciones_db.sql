-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 27-03-2022 a las 21:42:38
-- Versión del servidor: 10.5.12-MariaDB
-- Versión de PHP: 7.3.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `id18632459_reclamaciones_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `s_admin`
--

CREATE TABLE `s_admin` (
  `a_dni` varchar(10) NOT NULL,
  `a_username` text NOT NULL,
  `a_email` varchar(255) NOT NULL,
  `a_password` text NOT NULL,
  `a_email_respaldo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `s_admin`
--

INSERT INTO `s_admin` (`a_dni`, `a_username`, `a_email`, `a_password`, `a_email_respaldo`) VALUES
('71941581', 'Ketin Tobias Rojas Padilla', 'ketinrojaspadilla@gmail.com', 'OThhZG1pbjEy', 'default@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `s_contactos`
--

CREATE TABLE `s_contactos` (
  `c_id` int(11) NOT NULL,
  `c_nombre` varchar(255) NOT NULL,
  `c_area` varchar(255) NOT NULL,
  `c_cargo` varchar(255) DEFAULT NULL,
  `c_email` varchar(255) NOT NULL,
  `c_telefono` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `s_mensajes`
--

CREATE TABLE `s_mensajes` (
  `m_id` int(11) NOT NULL,
  `m_datetime` varchar(50) NOT NULL,
  `m_emisor` varchar(255) NOT NULL,
  `m_contenido` text NOT NULL,
  `m_estado` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `s_reclamo`
--

CREATE TABLE `s_reclamo` (
  `r_id` int(11) NOT NULL,
  `r_date` varchar(50) NOT NULL,
  `r_username` varchar(255) NOT NULL,
  `r_dni` varchar(30) NOT NULL,
  `r_email` varchar(255) NOT NULL,
  `r_telefono` varchar(30) NOT NULL,
  `r_descripcion` text NOT NULL,
  `r_estado` varchar(20) NOT NULL DEFAULT 'pendiente',
  `r_archivo` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `s_admin`
--
ALTER TABLE `s_admin`
  ADD PRIMARY KEY (`a_dni`);

--
-- Indices de la tabla `s_contactos`
--
ALTER TABLE `s_contactos`
  ADD PRIMARY KEY (`c_id`);

--
-- Indices de la tabla `s_mensajes`
--
ALTER TABLE `s_mensajes`
  ADD PRIMARY KEY (`m_id`);

--
-- Indices de la tabla `s_reclamo`
--
ALTER TABLE `s_reclamo`
  ADD PRIMARY KEY (`r_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `s_contactos`
--
ALTER TABLE `s_contactos`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `s_mensajes`
--
ALTER TABLE `s_mensajes`
  MODIFY `m_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `s_reclamo`
--
ALTER TABLE `s_reclamo`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

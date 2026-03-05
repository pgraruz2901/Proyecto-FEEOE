-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-01-2026 a las 18:32:02
-- Versión del servidor: 12.1.2-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acl_roles`
--

CREATE TABLE `acl_roles` (
  `cod_acl_role` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `perm1` tinyint(1) NOT NULL DEFAULT 0,
  `perm2` tinyint(1) NOT NULL DEFAULT 0,
  `perm3` tinyint(1) NOT NULL DEFAULT 0,
  `perm4` tinyint(1) NOT NULL DEFAULT 0,
  `perm5` tinyint(1) NOT NULL DEFAULT 0,
  `perm6` tinyint(1) NOT NULL DEFAULT 0,
  `perm7` tinyint(1) NOT NULL DEFAULT 0,
  `perm8` tinyint(1) NOT NULL DEFAULT 0,
  `perm9` tinyint(1) NOT NULL DEFAULT 0,
  `perm10` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `acl_roles`
--

INSERT INTO `acl_roles` (`cod_acl_role`, `nombre`, `perm1`, `perm2`, `perm3`, `perm4`, `perm5`, `perm6`, `perm7`, `perm8`, `perm9`, `perm10`) VALUES
(8, 'comprador', 0, 0, 0, 0, 0, 0, 0, 1, 0, 0),
(9, 'administrativo', 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(10, 'administrador', 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acl_usuarios`
--

CREATE TABLE `acl_usuarios` (
  `cod_acl_usuario` int(11) NOT NULL,
  `nick` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL DEFAULT '',
  `contrasenia` varchar(64) NOT NULL,
  `cod_acl_role` int(11) NOT NULL,
  `borrado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `acl_usuarios`
--

INSERT INTO `acl_usuarios` (`cod_acl_usuario`, `nick`, `nombre`, `contrasenia`, `cod_acl_role`, `borrado`) VALUES
(6, 'pablo', 'Pable', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 8, 1),
(7, 'medina', 'mario', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 8, 1),
(12, 'damian', 'A', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8', 10, 0),
(13, 'pablog', 'pablo', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 10, 0),
(14, 'pablo1', 'pablo3', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 10, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `cod_categoria` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`cod_categoria`, `descripcion`) VALUES
(1, 'Categoria1'),
(2, 'Categoria2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `cod_compra` int(10) NOT NULL,
  `cod_usuario` int(10) NOT NULL,
  `fecha` date NOT NULL,
  `importe_base` int(10) NOT NULL,
  `importe_iva` int(20) NOT NULL,
  `importe_total` int(20) NOT NULL,
  `modo_pago` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`cod_compra`, `cod_usuario`, `fecha`, `importe_base`, `importe_iva`, `importe_total`, `modo_pago`) VALUES
(1, 25, '2026-01-04', 62, 0, 62, 'tarjeta'),
(2, 25, '2026-01-04', 31, 0, 31, 'tarjeta'),
(3, 25, '2026-01-04', 41, 0, 41, 'transferencia'),
(4, 25, '2026-01-04', 213, 0, 213, 'tarjeta'),
(5, 25, '2026-01-04', 82, 0, 82, 'tarjeta'),
(6, 25, '2026-01-04', 31, 0, 31, 'tarjeta'),
(7, 25, '2026-01-04', 31, 0, 31, 'tarjeta'),
(8, 25, '2026-01-04', 31, 7, 38, 'tarjeta'),
(9, 25, '2026-01-04', 62, 13, 75, 'tarjeta'),
(10, 25, '2026-01-04', 124, 26, 150, 'tarjeta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra_lineas`
--

CREATE TABLE `compra_lineas` (
  `cod_compra_linea` int(10) NOT NULL,
  `cod_compra` int(10) NOT NULL,
  `cod_producto` int(10) NOT NULL,
  `orden` int(10) NOT NULL,
  `unidades` int(20) NOT NULL,
  `precio_unidad` int(20) NOT NULL,
  `iva` int(20) NOT NULL,
  `importe_base` int(20) NOT NULL,
  `importe_iva` int(10) NOT NULL,
  `importe_total` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `compra_lineas`
--

INSERT INTO `compra_lineas` (`cod_compra_linea`, `cod_compra`, `cod_producto`, `orden`, `unidades`, `precio_unidad`, `iva`, `importe_base`, `importe_iva`, `importe_total`) VALUES
(1, 2, 4, 1, 1, 31, 0, 31, 0, 31),
(2, 3, 3, 1, 1, 41, 0, 41, 0, 41),
(3, 4, 5, 1, 2, 91, 0, 182, 0, 182),
(4, 4, 4, 2, 1, 31, 0, 31, 0, 31),
(5, 5, 3, 1, 2, 41, 0, 82, 0, 82),
(6, 6, 4, 1, 1, 31, 0, 31, 0, 31),
(7, 7, 4, 1, 1, 31, 0, 31, 0, 31),
(8, 8, 4, 1, 1, 31, 21, 31, 7, 38),
(9, 9, 4, 1, 2, 31, 21, 62, 13, 75),
(10, 10, 4, 1, 4, 31, 21, 124, 26, 150);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `cod_producto` int(11) NOT NULL,
  `cod_categoria` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `fabricante` varchar(50) NOT NULL,
  `fecha_alta` date NOT NULL,
  `unidades` int(10) NOT NULL,
  `precio_base` int(50) NOT NULL,
  `iva` int(10) NOT NULL,
  `precio_iva` int(10) NOT NULL,
  `precio_venta` int(20) NOT NULL,
  `foto` varchar(50) NOT NULL,
  `borrado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`cod_producto`, `cod_categoria`, `nombre`, `fabricante`, `fecha_alta`, `unidades`, `precio_base`, `iva`, `precio_iva`, `precio_venta`, `foto`, `borrado`) VALUES
(1, 1, 'Televisor 51', 'Samsung', '2023-12-15', 10, 4000, 21, 4840, 4840, 'General', 1),
(2, 1, 'hola  g', 'pepe', '2023-01-29', 2, 34, 2, 35, 35, 'awdawd', 1),
(3, 2, 'producto3', 'hola', '2020-10-20', 0, 34, 21, 41, 41, 'awdawd', 0),
(4, 1, 'Camiseta Deportiva', 'Nike', '2022-03-15', 37, 26, 21, 31, 31, 'default.jpg', 0),
(5, 2, 'Zapatillas Running', 'Adidas', '2021-06-01', 28, 75, 21, 91, 91, 'default.jpg', 0),
(6, 1, 'Balón de Fútbol', 'Select', '2023-01-20', 10, 35, 10, 39, 39, 'default.jpg', 0),
(7, 1, 'Gorra Casual', 'Puma', '2022-12-10', 15, 18, 21, 22, 22, 'default.jpg', 0),
(8, 2, 'Mochila Escolar', 'Reebok', '2020-09-05', 25, 40, 21, 48, 48, 'default.jpg', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `cod_usuario` int(11) NOT NULL,
  `nick` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `nif` varchar(10) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `poblacion` varchar(30) NOT NULL,
  `provincia` varchar(30) NOT NULL,
  `CP` varchar(5) NOT NULL DEFAULT '00000',
  `fecha_nacimiento` date NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0,
  `foto` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`cod_usuario`, `nick`, `nombre`, `nif`, `direccion`, `poblacion`, `provincia`, `CP`, `fecha_nacimiento`, `borrado`, `foto`) VALUES
(22, 'pablo', 'Pable', '12345678D', '29200', 'Malaga', 'Málaga', '29200', '2025-12-24', 1, 'descarga.jpg'),
(23, 'medina', 'mario', '12345678D', '29200', 'Malaga', 'Málaga', '29200', '2025-12-04', 1, 'descarga.jpg'),
(24, 'damian', 'A', '12345678D', 'a', 'a', 'a', 'a', '2025-12-19', 0, 'descarga.jpg'),
(25, 'pablo1', 'pablo3', '12345678D', '29201', 'Malaga', 'Málaga', '29200', '2026-01-01', 0, 'descarga.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acl_roles`
--
ALTER TABLE `acl_roles`
  ADD PRIMARY KEY (`cod_acl_role`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `acl_usuarios`
--
ALTER TABLE `acl_usuarios`
  ADD PRIMARY KEY (`cod_acl_usuario`),
  ADD UNIQUE KEY `uq_acl_roles_1` (`nick`),
  ADD KEY `cod_acl_role` (`cod_acl_role`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`cod_categoria`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`cod_compra`);

--
-- Indices de la tabla `compra_lineas`
--
ALTER TABLE `compra_lineas`
  ADD PRIMARY KEY (`cod_compra_linea`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`cod_producto`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`cod_usuario`),
  ADD UNIQUE KEY `nick` (`nick`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `acl_roles`
--
ALTER TABLE `acl_roles`
  MODIFY `cod_acl_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `acl_usuarios`
--
ALTER TABLE `acl_usuarios`
  MODIFY `cod_acl_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `cod_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `cod_compra` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `compra_lineas`
--
ALTER TABLE `compra_lineas`
  MODIFY `cod_compra_linea` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `cod_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `cod_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `acl_usuarios`
--
ALTER TABLE `acl_usuarios`
  ADD CONSTRAINT `fk_acl_roles_1` FOREIGN KEY (`cod_acl_role`) REFERENCES `acl_roles` (`cod_acl_role`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

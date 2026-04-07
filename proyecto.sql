-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-04-2026 a las 11:33:23
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `acl_roles`
--

INSERT INTO `acl_roles` (`cod_acl_role`, `nombre`, `perm1`, `perm2`, `perm3`, `perm4`, `perm5`, `perm6`, `perm7`, `perm8`, `perm9`, `perm10`) VALUES
(8, 'comprador', 0, 0, 0, 0, 0, 0, 0, 1, 0, 0),
(9, 'administrativo', 0, 0, 0, 0, 0, 0, 0, 1, 1, 0),
(10, 'administrador', 0, 0, 0, 0, 0, 0, 0, 1, 1, 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `acl_usuarios`
--

INSERT INTO `acl_usuarios` (`cod_acl_usuario`, `nick`, `nombre`, `contrasenia`, `cod_acl_role`, `borrado`) VALUES
(22, 'administrador', 'administrador', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 10, 0),
(23, 'comprador', 'comprador', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 8, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `cod_categoria` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`cod_categoria`, `descripcion`) VALUES
(1, 'Cervezas'),
(2, 'Vinos'),
(3, 'Refrescos'),
(4, 'Licores'),
(5, 'Aguas');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`cod_compra`, `cod_usuario`, `fecha`, `importe_base`, `importe_iva`, `importe_total`, `modo_pago`) VALUES
(1, 25, '2026-01-10', 11, 2, 13, 'tarjeta'),
(2, 25, '2026-01-11', 20, 4, 24, 'efectivo'),
(3, 25, '2026-01-12', 35, 7, 42, 'transferencia'),
(4, 25, '2026-01-13', 50, 11, 61, 'tarjeta'),
(5, 25, '2026-01-14', 15, 3, 18, 'tarjeta'),
(6, 25, '2026-01-15', 80, 17, 97, 'transferencia'),
(7, 25, '2026-01-16', 22, 5, 27, 'efectivo'),
(8, 25, '2026-01-17', 12, 3, 15, 'tarjeta'),
(9, 25, '2026-01-18', 60, 13, 73, 'tarjeta'),
(10, 25, '2026-01-19', 100, 21, 121, 'transferencia');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `compra_lineas`
--

INSERT INTO `compra_lineas` (`cod_compra_linea`, `cod_compra`, `cod_producto`, `orden`, `unidades`, `precio_unidad`, `iva`, `importe_base`, `importe_iva`, `importe_total`) VALUES
(1, 1, 1, 1, 10, 1, 21, 11, 2, 13),
(2, 2, 5, 1, 3, 7, 21, 20, 4, 24),
(3, 3, 13, 1, 3, 12, 21, 36, 8, 44),
(4, 4, 9, 1, 20, 1, 21, 29, 6, 35),
(5, 5, 17, 1, 30, 0, 10, 13, 1, 15),
(6, 6, 6, 1, 10, 8, 21, 85, 18, 102),
(7, 7, 3, 1, 20, 1, 21, 21, 4, 26),
(8, 8, 10, 1, 10, 1, 21, 13, 3, 16),
(9, 9, 15, 1, 5, 11, 21, 54, 11, 65),
(10, 10, 14, 1, 8, 12, 21, 92, 19, 111);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `cons_compras`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `cons_compras` (
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `cons_compra_lineas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `cons_compra_lineas` (
`cod_compra_linea` int(10)
,`cod_compra` int(10)
,`cod_producto` int(10)
,`orden` int(10)
,`unidades` int(20)
,`precio_unidad` int(20)
,`iva` int(20)
,`importe_base` int(20)
,`importe_iva` int(10)
,`importe_total` int(20)
,`nombre_producto` varchar(50)
,`fabricante` varchar(50)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `cons_productos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `cons_productos` (
`cod_producto` int(11)
,`cod_categoria` int(11)
,`nombre` varchar(50)
,`fabricante` varchar(50)
,`fecha_alta` date
,`unidades` int(10)
,`precio_base` decimal(10,2)
,`iva` int(10)
,`precio_iva` decimal(10,2)
,`precio_venta` decimal(10,2)
,`foto` varchar(50)
,`borrado` tinyint(1)
,`categoria` varchar(50)
);

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
  `precio_base` decimal(10,2) NOT NULL,
  `iva` int(10) NOT NULL,
  `precio_iva` decimal(10,2) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL,
  `foto` varchar(50) NOT NULL,
  `borrado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`cod_producto`, `cod_categoria`, `nombre`, `fabricante`, `fecha_alta`, `unidades`, `precio_base`, `iva`, `precio_iva`, `precio_venta`, `foto`, `borrado`) VALUES
(1, 1, 'Cerveza Alhambra 1925', 'Mahou', '2024-01-10', 120, 0.85, 21, 0.18, 1.03, 'alhambra.jpg', 0),
(2, 1, 'Cerveza Estrella Galicia', 'Hijos de Rivera', '2024-01-12', 155, 0.90, 21, 0.19, 1.09, 'estrella.jpg', 0),
(3, 1, 'Cerveza Heineken', 'Heineken', '2024-01-15', 200, 1.00, 21, 0.21, 1.21, 'heineken.jpg', 1),
(4, 1, 'Cerveza Cruzcampo', 'Heineken España', '2024-02-01', 180, 0.80, 21, 0.17, 0.97, 'cruzcampo.jpg', 1),
(5, 2, 'Vino Rioja Crianza', 'Campo Viejo', '2023-10-10', 60, 5.50, 21, 1.16, 6.66, 'rioja.jpg', 0),
(6, 2, 'Vino Ribera del Duero', 'Protos', '2023-09-05', 40, 7.50, 21, 1.58, 9.08, 'ribera.jpg', 0),
(7, 2, 'Vino Blanco Verdejo', 'Marques de Riscal', '2023-11-01', 55, 4.50, 21, 0.95, 5.45, 'verdejo.jpg', 1),
(8, 2, 'Vino Rosado Navarra', 'Chivite', '2023-12-01', 45, 3.80, 21, 0.80, 4.60, 'rosado.jpg', 0),
(9, 3, 'Coca-Cola 2L', 'Coca-Cola', '2024-01-01', 300, 1.80, 21, 0.38, 2.18, 'cocacola.jpg', 1),
(10, 3, 'Fanta Naranja', 'Coca-Cola', '2024-01-02', 250, 1.60, 21, 0.34, 1.94, 'fanta.jpg', 0),
(11, 3, 'Pepsi 2L', 'PepsiCo', '2024-01-03', 220, 1.50, 21, 0.32, 1.82, 'pepsi.jpg', 0),
(12, 3, 'Sprite 2L', 'Coca-Cola', '2024-01-04', 180, 1.55, 21, 0.33, 1.88, 'sprite.jpg', 0),
(13, 4, 'Whisky JB', 'J&B', '2023-08-01', 35, 11.50, 21, 2.42, 13.92, 'jb.jpg', 0),
(14, 4, 'Ron Barceló', 'Barceló', '2023-08-05', 30, 12.00, 21, 2.52, 14.52, 'barcelo.jpg', 1),
(15, 4, 'Ginebra Larios', 'Larios', '2023-08-10', 28, 10.50, 21, 2.21, 12.71, 'larios.jpg', 1),
(16, 4, 'Vodka Absolut', 'Absolut', '2023-08-15', 25, 13.00, 21, 2.73, 15.73, 'absolut.jpg', 0),
(17, 5, 'Agua Lanjarón', 'Lanjarón', '2024-02-01', 400, 0.45, 10, 0.05, 0.50, 'lanjaron.jpg', 0),
(18, 5, 'Agua Bezoya', 'Bezoya', '2024-02-02', 355, 0.40, 10, 0.04, 0.44, 'bezoya.jpg', 0),
(19, 5, 'Agua Font Vella', 'Font Vella', '2024-02-03', 320, 0.50, 10, 0.05, 0.55, 'fontvella.jpg', 1),
(20, 5, 'Agua con Gas Perrier', 'Perrier', '2024-02-04', 150, 1.20, 21, 0.25, 1.45, 'perrier.jpg', 0),
(23, 5, 'Chicles Alberto', 'Alberto Chicote', '2026-03-06', 4000, 2.00, 4, 0.00, 2.00, 'prod_1774433621_7761.jpeg', 0),
(24, 2, 'Vino Creado', 'Pablo Gabriel', '2026-03-25', 2000, 500.00, 10, 50.00, 550.00, 'default.jpg', 0);

-- --------------------------------------------------------

--
-- Estructura para la vista `cons_compras`
--
DROP TABLE IF EXISTS `cons_compras`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `cons_compras`  AS SELECT `c`.`cod_compra` AS `cod_compra`, `c`.`cod_usuario` AS `cod_usuario`, `c`.`fecha` AS `fecha`, `c`.`importe_base` AS `importe_base`, `c`.`importe_iva` AS `importe_iva`, `c`.`importe_total` AS `importe_total`, `c`.`modo_pago` AS `modo_pago`, `u`.`nick` AS `nick_usuario`, `u`.`nombre` AS `nombre_usuario` FROM (`compras` `c` join `usuarios` `u` on(`c`.`cod_usuario` = `u`.`cod_usuario`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `cons_compra_lineas`
--
DROP TABLE IF EXISTS `cons_compra_lineas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `cons_compra_lineas`  AS SELECT `c`.`cod_compra_linea` AS `cod_compra_linea`, `c`.`cod_compra` AS `cod_compra`, `c`.`cod_producto` AS `cod_producto`, `c`.`orden` AS `orden`, `c`.`unidades` AS `unidades`, `c`.`precio_unidad` AS `precio_unidad`, `c`.`iva` AS `iva`, `c`.`importe_base` AS `importe_base`, `c`.`importe_iva` AS `importe_iva`, `c`.`importe_total` AS `importe_total`, `p`.`nombre` AS `nombre_producto`, `p`.`fabricante` AS `fabricante` FROM (`compra_lineas` `c` join `productos` `p` on(`c`.`cod_producto` = `p`.`cod_producto`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `cons_productos`
--
DROP TABLE IF EXISTS `cons_productos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `cons_productos`  AS SELECT `p`.`cod_producto` AS `cod_producto`, `p`.`cod_categoria` AS `cod_categoria`, `p`.`nombre` AS `nombre`, `p`.`fabricante` AS `fabricante`, `p`.`fecha_alta` AS `fecha_alta`, `p`.`unidades` AS `unidades`, `p`.`precio_base` AS `precio_base`, `p`.`iva` AS `iva`, `p`.`precio_iva` AS `precio_iva`, `p`.`precio_venta` AS `precio_venta`, `p`.`foto` AS `foto`, `p`.`borrado` AS `borrado`, `c`.`descripcion` AS `categoria` FROM (`productos` `p` join `categorias` `c` on(`p`.`cod_categoria` = `c`.`cod_categoria`)) ;

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
  MODIFY `cod_acl_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `cod_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `cod_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

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

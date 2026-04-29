-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-04-2026 a las 09:11:44
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
-- Estructura de tabla para la tabla `clientes_api`
--

CREATE TABLE `clientes_api` (
  `cod_cliente` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(150) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `fecha_alta` date DEFAULT NULL,
  `activo` tinyint(4) DEFAULT 1,
  `saldo` decimal(10,2) DEFAULT 0.00,
  `borrado` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes_api`
--

INSERT INTO `clientes_api` (`cod_cliente`, `nombre`, `apellidos`, `email`, `telefono`, `fecha_alta`, `activo`, `saldo`, `borrado`) VALUES
(1, 'Bar La Esquina', 'Centro', 'contacto@barlaesquina.com', '600123001', '2024-01-10', 1, 120.50, 0),
(2, 'Restaurante El Mirador', 'Gastronomía SL', 'info@elmirador.com', '600123002', '2024-02-15', 1, 350.00, 0),
(3, 'Cafetería Sol y Sombra', 'SL', 'solysombra@gmail.com', '600123003', '2024-03-05', 1, 75.20, 0),
(4, 'Pizzería Napoli', 'Italia Foods SL', 'napoli@pizza.com', '600123004', '2024-01-22', 1, 210.00, 0),
(5, 'Cervecería Estrella', 'Andalucía Hostelería', 'estrella@cerveceria.com', '600123005', '2024-04-01', 1, 540.90, 0),
(6, 'Hotel Costa Azul', 'Costa Azul S.A.', 'reservas@costaazul.com', '600123006', '2024-02-28', 1, 1200.00, 0),
(7, 'Bar El Tapeo', 'Tapeo SL', 'eltapeo@gmail.com', '600123007', '2024-03-18', 1, 95.62, 0),
(8, 'Restaurante La Parrilla', 'Carnes SL', 'laparrilla@food.com', '600123008', '2024-01-12', 1, 430.00, 0),
(9, 'Cafetería Central', 'Urban Coffee SL', 'central@coffee.com', '600123009', '2024-03-25', 1, 60.00, 0),
(10, 'Bodega El Vino', 'Vinícola SL', 'elvino@bodega.com', '600123010', '2024-02-10', 1, 890.00, 0),
(11, 'Hamburguesería King Burger', 'Fast Food SL', 'kingburger@food.com', '600123011', '2024-04-12', 1, 310.00, 0),
(12, 'Bar Puerto Viejo', 'Marina SL', 'puertoviejo@bar.com', '600123012', '2024-01-30', 1, 150.75, 0),
(13, 'Restaurante Sakura', 'Japan Food SL', 'sakura@japan.com', '600123013', '2024-02-05', 1, 500.00, 0),
(14, 'Cafetería Buen Café', 'Coffee SL', 'buencafe@gmail.com', '600123014', '2024-03-01', 1, 80.00, 0),
(15, 'Taberna El Rincón', 'Tradición SL', 'rincon@taberna.com', '600123015', '2024-04-20', 1, 260.00, 0),
(16, 'Pablo', 'Ruz', 'pablogranadosruz2006@gmail.com', '678909876', '2026-04-28', 1, 100.00, 0);

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
,`cod_cliente` int(11)
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
  `borrado` tinyint(1) NOT NULL,
  `cod_cliente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`cod_producto`, `cod_categoria`, `nombre`, `fabricante`, `fecha_alta`, `unidades`, `precio_base`, `iva`, `precio_iva`, `precio_venta`, `foto`, `borrado`, `cod_cliente`) VALUES
(1, 1, 'Cerveza Alhambra 1925', 'Mahou', '2024-01-10', 120, 0.85, 21, 0.18, 1.03, 'alhambra.jpg', 0, 14),
(2, 1, 'Cerveza Estrella Galicia', 'Hijos de Rivera', '2026-04-28', 0, 1.60, 21, 0.34, 1.94, 'estrella.jpg', 0, 4),
(3, 1, 'Cerveza Heineken', 'Heineken', '2024-01-15', 200, 1.00, 21, 0.21, 1.21, 'heineken.jpg', 1, 9),
(4, 1, 'Cerveza Cruzcampo', 'Heineken España', '2024-02-01', 180, 0.80, 21, 0.17, 0.97, 'cruzcampo.jpg', 0, 14),
(5, 2, 'Vino Rioja Crianza', 'Campo Viejo', '2023-10-10', 60, 5.50, 21, 1.16, 6.66, 'rioja.jpg', 0, 1),
(6, 2, 'Vino Ribera del Duero', 'Protos', '2023-09-05', 40, 7.50, 21, 1.58, 9.08, 'ribera.jpg', 0, 6),
(7, 2, 'Vino Blanco Verdejo', 'Marques de Riscal', '2023-11-01', 55, 4.50, 21, 0.95, 5.45, 'verdejo.jpg', 1, 10),
(8, 2, 'Vino Rosado Navarra', 'Chivite', '2023-12-01', 45, 3.80, 21, 0.80, 4.60, 'rosado.jpg', 0, 3),
(9, 3, 'Coca-Cola 2L', 'Coca-Cola', '2024-01-01', 300, 1.80, 21, 0.38, 2.18, 'cocacola.jpg', 1, 1),
(10, 3, 'Fanta Naranja', 'Coca-Cola', '2024-01-02', 250, 1.60, 21, 0.34, 1.94, 'fanta.jpg', 0, 10),
(11, 3, 'Pepsi 2L', 'PepsiCo', '2024-01-03', 220, 1.50, 21, 0.32, 1.82, 'pepsi.jpg', 0, 1),
(12, 3, 'Sprite 2L', 'Coca-Cola', '2024-01-04', 180, 1.55, 21, 0.33, 1.88, 'sprite.jpg', 0, 5),
(13, 4, 'Whisky JB', 'J&B', '2023-08-01', 35, 11.50, 21, 2.42, 13.92, 'jb.jpg', 0, 4),
(14, 4, 'Ron Barceló', 'Barceló', '2023-08-05', 30, 12.00, 21, 2.52, 14.52, 'barcelo.jpg', 1, 8),
(15, 4, 'Ginebra Larios', 'Larios', '2023-08-10', 28, 10.50, 21, 2.21, 12.71, 'larios.jpg', 1, 10),
(16, 4, 'Vodka Absolut', 'Absolut', '2023-08-15', 25, 13.00, 21, 2.73, 15.73, 'absolut.jpg', 0, 9),
(17, 5, 'Agua Lanjarón', 'Lanjarón', '2024-02-01', 400, 0.45, 10, 0.05, 0.50, 'lanjaron.jpg', 0, 2),
(18, 5, 'Agua Bezoya', 'Bezoya', '2024-02-02', 355, 0.40, 10, 0.04, 0.44, 'bezoya.jpg', 0, 12),
(19, 5, 'Agua Font Vella', 'Font Vella', '2024-02-03', 320, 0.50, 10, 0.05, 0.55, 'fontvella.jpg', 0, 7),
(20, 5, 'Agua con Gas Perrier', 'Perrier', '2026-04-28', 0, 1.32, 10, 0.13, 1.45, 'prod_1777278028_6894.jpg', 0, 15),
(23, 5, 'Chicles Alberto', 'Alberto Chicote', '2026-03-06', 4000, 2.00, 4, 0.00, 2.00, 'prod_1774433621_7761.jpeg', 0, 8),
(24, 2, 'Vino Creado', 'Pablo Gabriel', '2026-03-25', 2000, 500.00, 10, 50.00, 550.00, 'default.jpg', 0, 7);

-- --------------------------------------------------------

--
-- Estructura para la vista `cons_productos`
--
DROP TABLE IF EXISTS `cons_productos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `cons_productos`  AS SELECT `p`.`cod_producto` AS `cod_producto`, `p`.`cod_categoria` AS `cod_categoria`, `p`.`nombre` AS `nombre`, `p`.`fabricante` AS `fabricante`, `p`.`fecha_alta` AS `fecha_alta`, `p`.`unidades` AS `unidades`, `p`.`precio_base` AS `precio_base`, `p`.`iva` AS `iva`, `p`.`precio_iva` AS `precio_iva`, `p`.`precio_venta` AS `precio_venta`, `p`.`foto` AS `foto`, `p`.`borrado` AS `borrado`, `p`.`cod_cliente` AS `cod_cliente`, `cat`.`descripcion` AS `categoria` FROM (`productos` `p` join `categorias` `cat` on(`p`.`cod_categoria` = `cat`.`cod_categoria`)) ;

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
  ADD UNIQUE KEY `nick` (`nick`),
  ADD KEY `cod_acl_role` (`cod_acl_role`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`cod_categoria`);

--
-- Indices de la tabla `clientes_api`
--
ALTER TABLE `clientes_api`
  ADD PRIMARY KEY (`cod_cliente`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`cod_producto`),
  ADD KEY `cod_cliente` (`cod_cliente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes_api`
--
ALTER TABLE `clientes_api`
  MODIFY `cod_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `acl_usuarios`
--
ALTER TABLE `acl_usuarios`
  ADD CONSTRAINT `fk_acl_roles_1` FOREIGN KEY (`cod_acl_role`) REFERENCES `acl_roles` (`cod_acl_role`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`cod_cliente`) REFERENCES `clientes_api` (`cod_cliente`);
COMMIT;


DROP VIEW IF EXISTS cons_productos;

CREATE VIEW cons_productos AS
SELECT 
    p.*,
    cat.descripcion AS categoria
FROM productos p
JOIN categorias cat 
    ON p.cod_categoria = cat.cod_categoria;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS proyecto;
USE proyecto;

/* =========================
   BORRADO SEGURO
========================= */
DROP VIEW IF EXISTS cons_compra_lineas;
DROP VIEW IF EXISTS cons_productos;

DROP TABLE IF EXISTS compra_lineas;
DROP TABLE IF EXISTS compras;
DROP TABLE IF EXISTS productos;
DROP TABLE IF EXISTS categorias;
DROP TABLE IF EXISTS acl_usuarios;
DROP TABLE IF EXISTS acl_roles;

/* =========================
   ROLES
========================= */
CREATE TABLE acl_roles (
  cod_acl_role INT(11) NOT NULL,
  nombre VARCHAR(30) NOT NULL,
  perm1 TINYINT(1) NOT NULL DEFAULT 0,
  perm2 TINYINT(1) NOT NULL DEFAULT 0,
  perm3 TINYINT(1) NOT NULL DEFAULT 0,
  perm4 TINYINT(1) NOT NULL DEFAULT 0,
  perm5 TINYINT(1) NOT NULL DEFAULT 0,
  perm6 TINYINT(1) NOT NULL DEFAULT 0,
  perm7 TINYINT(1) NOT NULL DEFAULT 0,
  perm8 TINYINT(1) NOT NULL DEFAULT 0,
  perm9 TINYINT(1) NOT NULL DEFAULT 0,
  perm10 TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (cod_acl_role),
  UNIQUE KEY nombre (nombre)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO acl_roles VALUES
(8,'comprador',0,0,0,0,0,0,0,1,0,0),
(9,'administrativo',0,0,0,0,0,0,0,1,1,0),
(10,'administrador',0,0,0,0,0,0,0,1,1,1);

/* =========================
   USUARIOS
========================= */
CREATE TABLE acl_usuarios (
  cod_acl_usuario INT(11) NOT NULL,
  nick VARCHAR(50) NOT NULL,
  nombre VARCHAR(50) NOT NULL DEFAULT '',
  contrasenia VARCHAR(64) NOT NULL,
  cod_acl_role INT(11) NOT NULL,
  borrado TINYINT(1) NOT NULL,
  PRIMARY KEY (cod_acl_usuario),
  UNIQUE KEY nick (nick),
  KEY cod_acl_role (cod_acl_role),
  CONSTRAINT fk_acl_roles_1
    FOREIGN KEY (cod_acl_role)
    REFERENCES acl_roles(cod_acl_role)
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO acl_usuarios VALUES
(22,'administrador','administrador','40bd001563085fc35165329ea1ff5c5ecbdbbeef',10,0),
(23,'comprador','comprador','40bd001563085fc35165329ea1ff5c5ecbdbbeef',8,0);

/* =========================
   CATEGORIAS
========================= */
CREATE TABLE categorias (
  cod_categoria INT(11) NOT NULL,
  descripcion VARCHAR(50) NOT NULL,
  PRIMARY KEY (cod_categoria)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO categorias VALUES
(1,'Cervezas'),
(2,'Vinos'),
(3,'Refrescos'),
(4,'Licores'),
(5,'Aguas');

/* =========================
   PRODUCTOS (TODOS LOS DATOS)
========================= */
CREATE TABLE productos (
  cod_producto INT(11) NOT NULL,
  cod_categoria INT(11) NOT NULL,
  nombre VARCHAR(50) NOT NULL,
  fabricante VARCHAR(50) NOT NULL,
  fecha_alta DATE NOT NULL,
  unidades INT(10) NOT NULL,
  precio_base DECIMAL(10,2) NOT NULL,
  iva INT(10) NOT NULL,
  precio_iva DECIMAL(10,2) NOT NULL,
  precio_venta DECIMAL(10,2) NOT NULL,
  foto VARCHAR(50) NOT NULL,
  borrado TINYINT(1) NOT NULL,
  PRIMARY KEY (cod_producto)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO productos VALUES
(1,1,'Cerveza Alhambra 1925','Mahou','2024-01-10',120,0.85,21,0.18,1.03,'alhambra.jpg',0),
(2,1,'Cerveza Estrella Galicia','Hijos de Rivera','2024-01-12',155,0.90,21,0.19,1.09,'estrella.jpg',0),
(3,1,'Cerveza Heineken','Heineken','2024-01-15',200,1.00,21,0.21,1.21,'heineken.jpg',1),
(4,1,'Cerveza Cruzcampo','Heineken España','2024-02-01',180,0.80,21,0.17,0.97,'cruzcampo.jpg',1),
(5,2,'Vino Rioja Crianza','Campo Viejo','2023-10-10',60,5.50,21,1.16,6.66,'rioja.jpg',0),
(6,2,'Vino Ribera del Duero','Protos','2023-09-05',40,7.50,21,1.58,9.08,'ribera.jpg',0),
(7,2,'Vino Blanco Verdejo','Marques de Riscal','2023-11-01',55,4.50,21,0.95,5.45,'verdejo.jpg',1),
(8,2,'Vino Rosado Navarra','Chivite','2023-12-01',45,3.80,21,0.80,4.60,'rosado.jpg',0),
(9,3,'Coca-Cola 2L','Coca-Cola','2024-01-01',300,1.80,21,0.38,2.18,'cocacola.jpg',1),
(10,3,'Fanta Naranja','Coca-Cola','2024-01-02',250,1.60,21,0.34,1.94,'fanta.jpg',0),
(11,3,'Pepsi 2L','PepsiCo','2024-01-03',220,1.50,21,0.32,1.82,'pepsi.jpg',0),
(12,3,'Sprite 2L','Coca-Cola','2024-01-04',180,1.55,21,0.33,1.88,'sprite.jpg',0),
(13,4,'Whisky JB','J&B','2023-08-01',35,11.50,21,2.42,13.92,'jb.jpg',0),
(14,4,'Ron Barceló','Barceló','2023-08-05',30,12.00,21,2.52,14.52,'barcelo.jpg',1),
(15,4,'Ginebra Larios','Larios','2023-08-10',28,10.50,21,2.21,12.71,'larios.jpg',1),
(16,4,'Vodka Absolut','Absolut','2023-08-15',25,13.00,21,2.73,15.73,'absolut.jpg',0),
(17,5,'Agua Lanjarón','Lanjarón','2024-02-01',400,0.45,10,0.05,0.50,'lanjaron.jpg',0),
(18,5,'Agua Bezoya','Bezoya','2024-02-02',355,0.40,10,0.04,0.44,'bezoya.jpg',1),
(19,5,'Agua Font Vella','Font Vella','2024-02-03',320,0.50,10,0.05,0.55,'fontvella.jpg',1),
(20,5,'Agua con Gas Perrier','Perrier','2024-02-04',150,1.20,21,0.25,1.45,'perrier.jpg',0),
(23,5,'Chicles Alberto','Alberto Chicote','2026-03-06',4000,2.00,4,0.00,2.00,'prod_1774433621_7761.jpeg',0),
(24,2,'Vino Creado','Pablo Gabriel','2026-03-25',2000,500.00,10,50.00,550.00,'default.jpg',0);

/* =========================
   COMPRAS
========================= */
CREATE TABLE compras (
  cod_compra INT(10) NOT NULL,
  cod_usuario INT(10) NOT NULL,
  fecha DATE NOT NULL,
  importe_base INT(10) NOT NULL,
  importe_iva INT(20) NOT NULL,
  importe_total INT(20) NOT NULL,
  modo_pago VARCHAR(20) NOT NULL,
  PRIMARY KEY (cod_compra)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO compras VALUES
(1,25,'2026-01-10',11,2,13,'tarjeta'),
(2,25,'2026-01-11',20,4,24,'efectivo'),
(3,25,'2026-01-12',35,7,42,'transferencia'),
(4,25,'2026-01-13',50,11,61,'tarjeta'),
(5,25,'2026-01-14',15,3,18,'tarjeta'),
(6,25,'2026-01-15',80,17,97,'transferencia'),
(7,25,'2026-01-16',22,5,27,'efectivo'),
(8,25,'2026-01-17',12,3,15,'tarjeta'),
(9,25,'2026-01-18',60,13,73,'tarjeta'),
(10,25,'2026-01-19',100,21,121,'transferencia');

/* =========================
   LINEAS
========================= */
CREATE TABLE compra_lineas (
  cod_compra_linea INT(10) NOT NULL,
  cod_compra INT(10) NOT NULL,
  cod_producto INT(10) NOT NULL,
  orden INT(10) NOT NULL,
  unidades INT(20) NOT NULL,
  precio_unidad INT(20) NOT NULL,
  iva INT(20) NOT NULL,
  importe_base INT(20) NOT NULL,
  importe_iva INT(10) NOT NULL,
  importe_total INT(20) NOT NULL,
  PRIMARY KEY (cod_compra_linea)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO compra_lineas VALUES
(1,1,1,1,10,1,21,11,2,13),
(2,2,5,1,3,7,21,20,4,24),
(3,3,13,1,3,12,21,36,8,44),
(4,4,9,1,20,1,21,29,6,35),
(5,5,17,1,30,0,10,13,1,15),
(6,6,6,1,10,8,21,85,18,102),
(7,7,3,1,20,1,21,21,4,26),
(8,8,10,1,10,1,21,13,3,16),
(9,9,15,1,5,11,21,54,11,65),
(10,10,14,1,8,12,21,92,19,111);

/* =========================
   VISTAS
========================= */

CREATE VIEW cons_compra_lineas AS
SELECT c.*, p.nombre AS nombre_producto, p.fabricante
FROM compra_lineas c
JOIN productos p ON c.cod_producto = p.cod_producto;

CREATE VIEW cons_productos AS
SELECT p.*, cat.descripcion AS categoria
FROM productos p
JOIN categorias cat ON p.cod_categoria = cat.cod_categoria;

COMMIT;
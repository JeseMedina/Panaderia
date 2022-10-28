-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-10-2022 a las 00:30:39
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `panaderia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja`
--

CREATE TABLE `caja` (
  `idcaja` int(11) NOT NULL,
  `fecha_hora` date NOT NULL,
  `inicio` decimal(11,2) NOT NULL,
  `ingreso` decimal(11,2) NOT NULL,
  `egreso` decimal(11,2) NOT NULL,
  `total` decimal(11,2) NOT NULL,
  `estado` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Volcado de datos para la tabla `caja`
--

INSERT INTO `caja` (`idcaja`, `fecha_hora`, `inicio`, `ingreso`, `egreso`, `total`, `estado`) VALUES
(2, '2022-10-21', '11.00', '649.00', '619.00', '500.00', 'Cerrada'),
(14, '2022-10-22', '800.00', '0.00', '0.00', '0.00', 'Cerrada'),
(15, '2022-10-23', '600.00', '700.00', '200.00', '500.00', 'Cerrada'),
(16, '2022-10-24', '1000.00', '1800.00', '2201.50', '-401.50', 'Cerrada'),
(17, '2022-10-27', '1000.00', '0.00', '0.00', '0.00', 'Abierta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja_retiro`
--

CREATE TABLE `caja_retiro` (
  `idcaja_retiro` int(11) NOT NULL,
  `idcaja` int(11) NOT NULL,
  `retiro` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Volcado de datos para la tabla `caja_retiro`
--

INSERT INTO `caja_retiro` (`idcaja_retiro`, `idcaja`, `retiro`) VALUES
(2, 2, '29.00'),
(3, 15, '200.00');

--
-- Disparadores `caja_retiro`
--
DELIMITER $$
CREATE TRIGGER `tr_updCaja_Retiro` BEFORE INSERT ON `caja_retiro` FOR EACH ROW BEGIN
 UPDATE caja SET egreso = egreso + NEW.retiro,total = total - NEW.retiro
 WHERE caja.idcaja = NEW.idcaja;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `idcompra` int(11) NOT NULL,
  `idproveedor` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `tipo_comprobante` varchar(20) NOT NULL,
  `serie_comprobante` varchar(7) DEFAULT NULL,
  `num_comprobante` varchar(10) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `impuesto` decimal(4,2) NOT NULL,
  `total_compra` decimal(11,2) NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`idcompra`, `idproveedor`, `idusuario`, `tipo_comprobante`, `serie_comprobante`, `num_comprobante`, `fecha_hora`, `impuesto`, `total_compra`, `estado`) VALUES
(20, 26, 1, 'Boleta', '', '78', '2022-10-24 00:00:00', '0.00', '1.50', 'Aceptado'),
(21, 27, 1, 'Boleta', '', '123', '2022-10-27 00:00:00', '0.00', '2200.00', 'Aceptado'),
(22, 28, 1, 'Boleta', '', '89654', '2022-10-27 00:00:00', '0.00', '8800.00', 'Anulado');

--
-- Disparadores `compra`
--
DELIMITER $$
CREATE TRIGGER `tr_desCajaCompra` AFTER UPDATE ON `compra` FOR EACH ROW BEGIN
 UPDATE caja SET egreso = egreso - NEW.total_compra,total = total + NEW.total_compra
 WHERE caja.estado = "Abierta";
 UPDATE detalle_compra SET precio_compra=0,precio_venta=0 WHERE detalle_compra.idcompra = NEW.idcompra;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tr_updCajaCompra` AFTER INSERT ON `compra` FOR EACH ROW BEGIN
 UPDATE caja SET egreso = egreso + NEW.total_compra,total = total - NEW.total_compra
 WHERE caja.estado = "Abierta";
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra`
--

CREATE TABLE `detalle_compra` (
  `iddetalle_compra` int(11) NOT NULL,
  `idcompra` int(11) NOT NULL,
  `idproducto` int(11) NOT NULL,
  `cantidad` decimal(11,2) NOT NULL,
  `precio_compra` decimal(11,2) NOT NULL,
  `precio_venta` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `detalle_compra`
--

INSERT INTO `detalle_compra` (`iddetalle_compra`, `idcompra`, `idproducto`, `cantidad`, `precio_compra`, `precio_venta`) VALUES
(16, 20, 22, '1.50', '1.00', '1.00'),
(17, 21, 52, '100.00', '10.00', '15.00'),
(18, 21, 53, '20.00', '60.00', '78.00'),
(19, 22, 29, '55.00', '0.00', '0.00');

--
-- Disparadores `detalle_compra`
--
DELIMITER $$
CREATE TRIGGER `tr_desStockCompra` BEFORE UPDATE ON `detalle_compra` FOR EACH ROW BEGIN
 UPDATE producto SET stock = stock - NEW.cantidad 
 WHERE producto.idproducto = NEW.idproducto;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tr_updStockcompra` AFTER INSERT ON `detalle_compra` FOR EACH ROW BEGIN
 UPDATE producto SET stock = stock + NEW.cantidad 
 WHERE producto.idproducto = NEW.idproducto;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_produccion`
--

CREATE TABLE `detalle_produccion` (
  `iddetalle_produccion` int(11) NOT NULL,
  `idproduccion` int(11) NOT NULL,
  `idproducto` int(11) NOT NULL,
  `cantidad` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `detalle_produccion`
--

INSERT INTO `detalle_produccion` (`iddetalle_produccion`, `idproduccion`, `idproducto`, `cantidad`) VALUES
(15, 28, 13, '1.80'),
(16, 28, 16, '3.00');

--
-- Disparadores `detalle_produccion`
--
DELIMITER $$
CREATE TRIGGER `tr_updStockProduccion` AFTER INSERT ON `detalle_produccion` FOR EACH ROW BEGIN
UPDATE producto SET stock = stock - NEW.cantidad
WHERE producto.idproducto = NEW.idproducto;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_reparto`
--

CREATE TABLE `detalle_reparto` (
  `iddetalle_reparto` int(11) NOT NULL,
  `idreparto` int(11) NOT NULL,
  `idproducto` int(11) NOT NULL,
  `cantidad` decimal(11,2) NOT NULL,
  `precio_venta` decimal(11,2) NOT NULL,
  `descuento` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `detalle_reparto`
--

INSERT INTO `detalle_reparto` (`iddetalle_reparto`, `idreparto`, `idproducto`, `cantidad`, `precio_venta`, `descuento`) VALUES
(8, 27, 19, '1.50', '20.00', '0.00');

--
-- Disparadores `detalle_reparto`
--
DELIMITER $$
CREATE TRIGGER `tr_updStockReparto` AFTER INSERT ON `detalle_reparto` FOR EACH ROW BEGIN
UPDATE producto SET stock = stock - NEW.cantidad
WHERE producto.idproducto = NEW.idproducto;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `iddetalle_venta` int(11) NOT NULL,
  `idventa` int(11) NOT NULL,
  `idproducto` int(11) NOT NULL,
  `cantidad` decimal(11,2) NOT NULL,
  `precio_venta` decimal(11,2) NOT NULL,
  `descuento` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `detalle_venta`
--

INSERT INTO `detalle_venta` (`iddetalle_venta`, `idventa`, `idproducto`, `cantidad`, `precio_venta`, `descuento`) VALUES
(46, 38, 22, '2.00', '800.00', '0.00'),
(47, 39, 27, '1.50', '400.00', '0.00'),
(48, 40, 26, '18.00', '0.00', '0.00');

--
-- Disparadores `detalle_venta`
--
DELIMITER $$
CREATE TRIGGER `tr_desStockVenta` BEFORE UPDATE ON `detalle_venta` FOR EACH ROW BEGIN
 UPDATE producto SET stock = stock + NEW.cantidad 
 WHERE producto.idproducto = NEW.idproducto;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tr_updStockVenta` AFTER INSERT ON `detalle_venta` FOR EACH ROW BEGIN
 UPDATE producto SET stock = stock - NEW.cantidad 
 WHERE producto.idproducto = NEW.idproducto;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `idpermiso` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `permiso`
--

INSERT INTO `permiso` (`idpermiso`, `nombre`) VALUES
(1, 'Escritorio'),
(2, 'Almacen'),
(3, 'Compras'),
(4, 'Ventas'),
(5, 'Personas'),
(6, 'Consulta'),
(7, 'Produccion'),
(8, 'Reparto'),
(9, 'Caja');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `idpersona` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `tipo_persona` varchar(20) NOT NULL,
  `num_documento` varchar(20) NOT NULL,
  `provincia` varchar(20) NOT NULL,
  `direccion` varchar(70) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`idpersona`, `nombre`, `tipo_persona`, `num_documento`, `provincia`, `direccion`, `telefono`, `email`, `condicion`) VALUES
(14, 'Consumidor Final', 'Cliente', '0', 'Chaco', '0', '0', '0@gmail.com', 1),
(16, 'Distribuidora del Norte', 'Proveedor', '3245231412', 'Santa Fe', 'San Lorenzo 999', '53463425', 'omg@gmail.com', 1),
(17, 'Doña Pocha', 'Cliente', '43643135', 'Chaco', 'esrsedf', '3644000000', 'pocha@hotmail.com', 1),
(21, 'jese', 'Cliente', '45643', 'Chaco', 'San Lorenzo 534', '233', '', 1),
(22, 'Emanuel', 'Repartidor', '89898989', 'Chaco', 'San Martín 666', '3644222222', 'emarepartos@gmail.com', 1),
(23, 'David Fernández', 'Panadero', '32532645', 'Chaco', 'Calle 30 entre 11 y 13 Barrio Nuevo', '3644314566', 'davidfernadnez@yahoo.com', 1),
(24, 'Ramón Castro', 'Panadero', '19456234', 'Chaco', 'Mz 4 Pc 5 713 Viviendas', '3644561234', 'rc_2018@gmail.com', 1),
(25, 'Tubito SRL', 'Proveedor', '21456734', 'Chaco', 'Calle 0 entre 17 y 19 Reserva Este', '3644764398', '', 1),
(26, 'Manaos', 'Proveedor', '12567553', 'Chaco', 'Calle 9 y ruta 95', '3644545675', '', 1),
(27, 'Don Emilio', 'Proveedor', '2146785454', 'Chaco', 'Calle 18 entre 1 y 3 Ensanche Sur', '364422343546', '', 1),
(28, 'Cabalgata', 'Proveedor', '324354546', 'Chaco', 'Calle 14 entre 9 y 7 Centro', '3644567890', '', 1),
(29, 'Calsa', 'Proveedor', '2145465657', 'Chaco', 'Calle 51 esquina 8', '3644556654', '', 1),
(30, 'Nardelli y CIA', 'Proveedor', '3122323232', 'Chaco', 'Calle 14 entre 13 y 15 Ensanche Sur', '+543644358340', 'ema92.1995@gmail.com', 1),
(31, 'David Fernández', 'Repartidor', '29767523', 'Chaco', 'Calle 30 entre 11 y 13 Barrio Nuevo', '3644324598', '', 1),
(32, 'Javier Casco', 'Repartidor', '33456129', 'Chaco', 'Calle 15 entre 34 y 36 Bº Ginés Benitez', '364456123', '', 1),
(33, 'Emanuel', 'Cliente', '234234', 'Chaco', 'San Lorenzo 534', '3644222222', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `produccion`
--

CREATE TABLE `produccion` (
  `idproduccion` int(11) NOT NULL,
  `idpanadero` int(11) NOT NULL,
  `idproductoproducido` int(11) NOT NULL,
  `cantidadproducida` decimal(11,2) NOT NULL,
  `fecha_hora` date NOT NULL,
  `preciomayorista` decimal(11,2) NOT NULL,
  `preciominorista` decimal(11,2) NOT NULL,
  `estado` varchar(25) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `produccion`
--

INSERT INTO `produccion` (`idproduccion`, `idpanadero`, `idproductoproducido`, `cantidadproducida`, `fecha_hora`, `preciomayorista`, `preciominorista`, `estado`) VALUES
(28, 24, 12, '12.50', '2022-10-24', '60.00', '80.00', 'Finalizado');

--
-- Disparadores `produccion`
--
DELIMITER $$
CREATE TRIGGER `tr_updStockProducto` AFTER UPDATE ON `produccion` FOR EACH ROW BEGIN
UPDATE producto SET stock = stock + NEW.cantidadproducida
WHERE producto.idproducto = NEW.idproductoproducido;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idproducto` int(11) NOT NULL,
  `idrubro` int(11) NOT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `stock` decimal(11,2) NOT NULL,
  `uMedida` varchar(20) NOT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`idproducto`, `idrubro`, `codigo`, `nombre`, `stock`, `uMedida`, `condicion`) VALUES
(11, 33, '', 'Pan Comun', '86.00', 'Kilogramo', 1),
(12, 33, '', 'Pan de leche', '56.50', 'Docena', 1),
(13, 37, '', 'Levadura', '277.20', 'Unidad', 1),
(14, 33, 'anizado', 'Anizado', '20.00', 'Kilogramo', 1),
(15, 33, 'prepizza', 'Prepizza', '100.00', 'Unidad', 1),
(16, 37, '', 'Harina', '57.00', 'Unidad', 1),
(17, 33, 'Hamburguesa', 'Pan de Hamburguesa', '30.00', 'Docena', 1),
(18, 33, 'Empanadas', 'Tapa de Empanada', '30.00', 'Unidad', 1),
(19, 33, 'Pascualina', 'Pascualina', '28.50', 'Unidad', 1),
(20, 33, 'Salvado', 'Grisines de Salvado', '30.00', 'Unidad', 1),
(21, 33, 'Tortitas', 'Tortitas Saladas', '30.00', 'Unidad', 1),
(22, 36, 'Torta', 'Torta de Cumpleaños', '2.50', 'Kilogramo', 1),
(23, 33, 'Panchos', 'Pan de Panchos', '30.00', 'Docena', 1),
(24, 33, 'Grisin', 'Grisines Comunes', '30.00', 'Unidad', 1),
(25, 33, 'Frances', 'Pan Francès', '60.00', 'Kilogramo', 1),
(26, 36, 'Masas', 'Masas Secas', '18.00', 'Kilogramo', 1),
(27, 36, 'Pastafrola', 'Pastafrola', '16.00', 'Kilogramo', 1),
(28, 36, 'Manaos3l', 'Gaseosas Manaos 3L', '87.00', 'Unidad', 1),
(29, 34, 'Cabalgata3l', 'Gaseosa Cabalgata 3L', '45.00', 'Unidad', 1),
(30, 34, 'Toro3/4', 'Vino Toro 3/4', '28.00', 'Unidad', 1),
(31, 34, 'Soda2l', 'Soda Tubito 2L', '45.00', 'Unidad', 1),
(32, 34, 'Soda1l', 'Soda Tubito 1L', '25.00', 'Unidad', 1),
(33, 34, 'Puré', 'Puré de Tomate Huerta', '60.00', 'Unidad', 1),
(34, 34, 'Brahama', 'Cerveza Brahama', '60.00', 'Litro', 1),
(35, 34, 'Quilmes', 'Cerveza Quilmes', '60.00', 'Litro', 1),
(36, 34, 'Brahama Lata', 'Cerveza Brahama Lata', '90.00', 'Unidad', 1),
(37, 34, 'Quilmes Lata', 'Cerveza Quilmes Lata', '90.00', 'Unidad', 1),
(38, 34, 'JLiquido', 'Jabón Liquido', '30.00', 'Unidad', 1),
(39, 34, 'JTocador', 'Jabón Tocador', '45.00', 'Unidad', 1),
(40, 33, 'Bizcocho Grasa', 'Bizcochos De Grasa', '30.00', 'Kilogramo', 1),
(41, 33, 'Bizcocho Queso', 'Bizcocho Queso', '30.00', 'Unidad', 1),
(42, 33, '', 'Pan Corona', '20.00', 'Kilogramo', 1),
(43, 33, '', 'Pan Trenzado', '30.00', 'Kilogramo', 1),
(44, 33, 'Fideo', 'Fideos Caseros', '20.00', 'Kilogramo', 1),
(45, 34, 'Moñito', 'Fideo Moñito', '20.00', 'Unidad', 1),
(46, 34, 'Tirabuzon', 'Fideo Tirabuzón', '40.00', 'Unidad', 1),
(47, 34, '', 'Picadillo', '60.00', 'Unidad', 1),
(48, 34, '', 'Lata de Sardina', '30.00', 'Unidad', 1),
(49, 34, 'Arroz', 'Arroz Amanda 1k', '30.00', 'Unidad', 1),
(50, 34, 'Magistral', 'Detergente Magistral', '20.00', 'Unidad', 1),
(51, 34, '', 'Esponja', '30.00', 'Unidad', 1),
(52, 34, '', 'Caramelos', '500.00', 'Unidad', 1),
(53, 34, 'Alfajor', 'Alfajores Tatín', '80.00', 'Unidad', 1),
(54, 34, 'Milka', 'Alfajor Milka', '30.00', 'Unidad', 1),
(55, 34, '', 'Jugo Baggio 1L', '30.00', 'Unidad', 1),
(56, 34, '', 'Jugo Baggio Chico', '30.00', 'Unidad', 1),
(57, 34, '', 'Agua Saborizada VIda', '60.00', 'Unidad', 1),
(58, 34, '', 'Papel Higiénico', '60.00', 'Unidad', 1),
(59, 33, '', 'Levadura Calsa', '0.00', 'Unidad', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reparto`
--

CREATE TABLE `reparto` (
  `idreparto` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idrepartidor` int(11) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `total_venta` decimal(11,2) NOT NULL,
  `estado` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `reparto`
--

INSERT INTO `reparto` (`idreparto`, `idcliente`, `idusuario`, `idrepartidor`, `fecha_hora`, `total_venta`, `estado`) VALUES
(27, 21, 1, 22, '2022-10-24 00:00:00', '30.00', 'Iniciado');

--
-- Disparadores `reparto`
--
DELIMITER $$
CREATE TRIGGER `tr_updCajaReparto` AFTER UPDATE ON `reparto` FOR EACH ROW BEGIN
 UPDATE caja SET ingreso = ingreso + NEW.total_venta,total = total +NEW.total_venta
 WHERE caja.estado = "Abierta";
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rubro`
--

CREATE TABLE `rubro` (
  `idrubro` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(256) DEFAULT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rubro`
--

INSERT INTO `rubro` (`idrubro`, `nombre`, `descripcion`, `condicion`) VALUES
(33, 'Panadería', '', 1),
(34, 'Mercadería', '', 1),
(36, 'Confitería', '', 1),
(37, 'Materia Prima', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `tipo_documento` varchar(20) DEFAULT NULL,
  `num_documento` varchar(20) NOT NULL,
  `direccion` varchar(70) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `cargo` varchar(20) DEFAULT NULL,
  `login` varchar(20) NOT NULL,
  `clave` varchar(64) NOT NULL,
  `imagen` varchar(50) NOT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nombre`, `tipo_documento`, `num_documento`, `direccion`, `telefono`, `email`, `cargo`, `login`, `clave`, `imagen`, `condicion`) VALUES
(1, 'La dueña', NULL, '00000000', 'San Martín 666', '3644000000', 'ladueña@yahoo.com.ar', 'Admin', 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', '1547756796.jpg', 1),
(14, 'Jese Medina', NULL, '43643135', 'jrt', '3644222222', 'skajese@gmail.com', 'panadero', 'jese', '8b8b9fc58e7bd145267721e97fb869a259d6769bd093dfd15ca657ab7ee2a6e8', '', 1),
(15, 'Emanuel', NULL, '00000000', 'San Lorenzo 999', '3644000000', 'ema@gmail.com', 'Repartidor', 'ema', '8c15a763882d486210de3f51de73ac159cf8b451a220d206bdeb7f2578878369', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_permiso`
--

CREATE TABLE `usuario_permiso` (
  `idusuario_permiso` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idpermiso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario_permiso`
--

INSERT INTO `usuario_permiso` (`idusuario_permiso`, `idusuario`, `idpermiso`) VALUES
(128, 1, 1),
(129, 1, 2),
(130, 1, 4),
(131, 1, 3),
(132, 1, 5),
(133, 1, 6),
(134, 1, 7),
(135, 1, 8),
(136, 1, 7),
(137, 1, 8),
(138, 15, 8),
(141, 1, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `idventa` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `tipo_comprobante` varchar(20) NOT NULL,
  `serie_comprobante` varchar(7) DEFAULT NULL,
  `num_comprobante` varchar(10) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `impuesto` decimal(4,2) NOT NULL,
  `total_venta` decimal(11,2) NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`idventa`, `idcliente`, `idusuario`, `tipo_comprobante`, `serie_comprobante`, `num_comprobante`, `fecha_hora`, `impuesto`, `total_venta`, `estado`) VALUES
(38, 21, 1, 'Boleta', '', '999', '2022-10-24 00:00:00', '0.00', '1200.00', 'Aceptado'),
(39, 21, 1, 'Boleta', '', '7899', '2022-10-24 00:00:00', '0.00', '600.00', 'Anulado'),
(40, 21, 1, 'Boleta', '', '23756', '2022-10-27 00:00:00', '0.00', '5400.00', 'Anulado');

--
-- Disparadores `venta`
--
DELIMITER $$
CREATE TRIGGER `tr_desCajaVenta` AFTER UPDATE ON `venta` FOR EACH ROW BEGIN
	UPDATE caja SET ingreso = ingreso - new.total_venta, total = total - new.total_venta WHERE caja.estado="Abierta";
UPDATE detalle_venta SET descuento=0,precio_venta=0 WHERE detalle_venta.idventa = NEW.idventa;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tr_updCajaVenta` AFTER INSERT ON `venta` FOR EACH ROW BEGIN
 UPDATE caja SET ingreso = ingreso + NEW.total_venta,total = total +NEW.total_venta
 WHERE caja.estado = "Abierta";
END
$$
DELIMITER ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `caja`
--
ALTER TABLE `caja`
  ADD PRIMARY KEY (`idcaja`);

--
-- Indices de la tabla `caja_retiro`
--
ALTER TABLE `caja_retiro`
  ADD PRIMARY KEY (`idcaja_retiro`),
  ADD KEY `idcaja` (`idcaja`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`idcompra`),
  ADD KEY `fk_compra_persona_idx` (`idproveedor`),
  ADD KEY `fk_compra_usuario_idx` (`idusuario`);

--
-- Indices de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD PRIMARY KEY (`iddetalle_compra`),
  ADD KEY `fk_detalle_compra_compra_idx` (`idcompra`),
  ADD KEY `fk_detalle_compra_producto_idx` (`idproducto`);

--
-- Indices de la tabla `detalle_produccion`
--
ALTER TABLE `detalle_produccion`
  ADD PRIMARY KEY (`iddetalle_produccion`),
  ADD KEY `idproduccion` (`idproduccion`),
  ADD KEY `idproducto` (`idproducto`);

--
-- Indices de la tabla `detalle_reparto`
--
ALTER TABLE `detalle_reparto`
  ADD PRIMARY KEY (`iddetalle_reparto`),
  ADD KEY `idreparto` (`idreparto`),
  ADD KEY `idproducto` (`idproducto`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`iddetalle_venta`),
  ADD KEY `fk_detalle_venta_venta_idx` (`idventa`),
  ADD KEY `fk_detalle_venta_producto_idx` (`idproducto`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`idpermiso`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`idpersona`);

--
-- Indices de la tabla `produccion`
--
ALTER TABLE `produccion`
  ADD PRIMARY KEY (`idproduccion`),
  ADD KEY `idpanadero` (`idpanadero`),
  ADD KEY `idproducto` (`idproductoproducido`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idproducto`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`),
  ADD KEY `fk_producto_categoria_idx` (`idrubro`);

--
-- Indices de la tabla `reparto`
--
ALTER TABLE `reparto`
  ADD PRIMARY KEY (`idreparto`),
  ADD KEY `idrepartidor` (`idrepartidor`),
  ADD KEY `idusuario` (`idusuario`),
  ADD KEY `idcliente` (`idcliente`) USING BTREE;

--
-- Indices de la tabla `rubro`
--
ALTER TABLE `rubro`
  ADD PRIMARY KEY (`idrubro`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`),
  ADD UNIQUE KEY `login_UNIQUE` (`login`);

--
-- Indices de la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  ADD PRIMARY KEY (`idusuario_permiso`),
  ADD KEY `fk_usuario_permiso_permiso_idx` (`idpermiso`),
  ADD KEY `fk_usuario_permiso_usuario_idx` (`idusuario`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`idventa`),
  ADD KEY `fk_venta_persona` (`idcliente`) USING BTREE,
  ADD KEY `fk_venta_usuario` (`idusuario`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `caja`
--
ALTER TABLE `caja`
  MODIFY `idcaja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `caja_retiro`
--
ALTER TABLE `caja_retiro`
  MODIFY `idcaja_retiro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `idcompra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  MODIFY `iddetalle_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `detalle_produccion`
--
ALTER TABLE `detalle_produccion`
  MODIFY `iddetalle_produccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `detalle_reparto`
--
ALTER TABLE `detalle_reparto`
  MODIFY `iddetalle_reparto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `iddetalle_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `idpermiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `idpersona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `produccion`
--
ALTER TABLE `produccion`
  MODIFY `idproduccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idproducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT de la tabla `reparto`
--
ALTER TABLE `reparto`
  MODIFY `idreparto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `rubro`
--
ALTER TABLE `rubro`
  MODIFY `idrubro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  MODIFY `idusuario_permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `idventa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `fk_compra_persona` FOREIGN KEY (`idproveedor`) REFERENCES `persona` (`idpersona`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_compra_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD CONSTRAINT `fk_detalle_compra_compra` FOREIGN KEY (`idcompra`) REFERENCES `compra` (`idcompra`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_detalle_compra_producto` FOREIGN KEY (`idproducto`) REFERENCES `producto` (`idproducto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_produccion`
--
ALTER TABLE `detalle_produccion`
  ADD CONSTRAINT `detalle_produccion_ibfk_1` FOREIGN KEY (`idproducto`) REFERENCES `producto` (`idproducto`),
  ADD CONSTRAINT `detalle_produccion_ibfk_2` FOREIGN KEY (`idproduccion`) REFERENCES `produccion` (`idproduccion`);

--
-- Filtros para la tabla `detalle_reparto`
--
ALTER TABLE `detalle_reparto`
  ADD CONSTRAINT `detalle_reparto_ibfk_1` FOREIGN KEY (`idproducto`) REFERENCES `producto` (`idproducto`),
  ADD CONSTRAINT `detalle_reparto_ibfk_2` FOREIGN KEY (`idreparto`) REFERENCES `reparto` (`idreparto`);

--
-- Filtros para la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD CONSTRAINT `fk_detalle_venta_producto` FOREIGN KEY (`idproducto`) REFERENCES `producto` (`idproducto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_detalle_venta_venta` FOREIGN KEY (`idventa`) REFERENCES `venta` (`idventa`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `produccion`
--
ALTER TABLE `produccion`
  ADD CONSTRAINT `produccion_ibfk_1` FOREIGN KEY (`idpanadero`) REFERENCES `persona` (`idpersona`),
  ADD CONSTRAINT `produccion_ibfk_3` FOREIGN KEY (`idproductoproducido`) REFERENCES `producto` (`idproducto`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`idrubro`) REFERENCES `rubro` (`idrubro`);

--
-- Filtros para la tabla `reparto`
--
ALTER TABLE `reparto`
  ADD CONSTRAINT `reparto_ibfk_1` FOREIGN KEY (`idrepartidor`) REFERENCES `persona` (`idpersona`),
  ADD CONSTRAINT `reparto_ibfk_2` FOREIGN KEY (`idcliente`) REFERENCES `persona` (`idpersona`),
  ADD CONSTRAINT `reparto_ibfk_3` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`);

--
-- Filtros para la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  ADD CONSTRAINT `fk_usuario_permiso_permiso` FOREIGN KEY (`idpermiso`) REFERENCES `permiso` (`idpermiso`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario_permiso_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `fk_venta_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `venta_ibfk_1` FOREIGN KEY (`idcliente`) REFERENCES `persona` (`idpersona`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

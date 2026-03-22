-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-03-2026 a las 02:40:31
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
-- Base de datos: `tienda_tecnologia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `descripcion`, `estado`, `creado_en`) VALUES
(1, 'Laptop', NULL, 'Activo', '2026-03-17 01:32:12'),
(2, 'PC Escritorio', NULL, 'Activo', '2026-03-17 01:32:12'),
(3, 'Monitor', NULL, 'Activo', '2026-03-17 01:32:12'),
(4, 'Smartphone', NULL, 'Activo', '2026-03-17 01:32:12'),
(5, 'Tablet', NULL, 'Activo', '2026-03-17 01:32:12'),
(6, 'Periférico', NULL, 'Activo', '2026-03-17 01:32:12'),
(7, 'Almacenamiento', NULL, 'Activo', '2026-03-17 01:32:12'),
(8, 'Redes', NULL, 'Activo', '2026-03-17 01:32:12'),
(9, 'Audio', NULL, 'Activo', '2026-03-17 01:32:12'),
(10, 'Gaming', NULL, 'Activo', '2026-03-17 01:32:12'),
(11, 'Impresión', NULL, 'Activo', '2026-03-17 01:32:12'),
(12, 'Accesorio', NULL, 'Activo', '2026-03-17 01:32:12'),
(13, 'Componentes', NULL, 'Activo', '2026-03-17 01:32:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_tecnologia`
--

CREATE TABLE `productos_tecnologia` (
  `id` int(10) UNSIGNED NOT NULL,
  `sku` varchar(30) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `marca` varchar(60) NOT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `garantia_meses` int(11) NOT NULL DEFAULT 12,
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  `actualizado_en` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos_tecnologia`
--

INSERT INTO `productos_tecnologia` (`id`, `sku`, `nombre`, `marca`, `categoria_id`, `descripcion`, `precio`, `stock`, `garantia_meses`, `estado`, `creado_en`, `actualizado_en`) VALUES
(1, 'LT-DELL-5430', 'Laptop Dell Latitude 5430 14\" i5 16GB 512GB SSD', 'Dell', 1, 'Laptop empresarial con SSD NVMe y 16GB RAM. Pantalla 14\" FHD.', 3899.90, 12, 24, 'Activo', '2026-02-24 05:10:46', '2026-03-17 01:32:25'),
(2, 'LT-HP-15S', 'Laptop HP 15s 15.6\" Ryzen 5 8GB 512GB SSD', 'HP', 1, 'Equipo de uso general con SSD 512GB, pantalla 15.6\" Full HD.', 2599.00, 18, 12, 'Activo', '2026-02-24 05:10:46', '2026-03-17 01:32:25'),
(3, 'PC-LEN-M70T', 'PC Lenovo ThinkCentre M70t i7 16GB 1TB SSD', 'Lenovo', 2, 'Torre para oficina con procesador i7 y almacenamiento SSD 1TB.', 4290.00, 6, 24, 'Activo', '2026-02-24 05:10:46', '2026-03-17 01:32:25'),
(4, 'MN-LG-27UL', 'Monitor LG 27\" 4K IPS (27UL500)', 'LG', 3, 'Monitor 27\" UHD 4K, panel IPS, ideal para diseño y productividad.', 1399.90, 20, 12, 'Activo', '2026-02-24 05:10:46', '2026-03-17 01:32:25'),
(5, 'MN-SAM-ODYS', 'Monitor Samsung Odyssey G5 32\" 144Hz', 'Samsung', 3, 'Monitor curvo 32\" QHD con 144Hz, orientado a gaming.', 1799.00, 9, 12, 'Activo', '2026-02-24 05:10:46', '2026-03-17 01:32:25'),
(6, 'SP-APL-IP14', 'iPhone 14 128GB', 'Apple', 4, 'Smartphone con 128GB de almacenamiento y cámara avanzada.', 3999.00, 10, 12, 'Activo', '2026-02-24 05:10:46', '2026-03-17 01:32:25'),
(7, 'SP-SAM-A55', 'Samsung Galaxy A55 256GB', 'Samsung', 4, 'Gama media alta, 256GB, buena batería y pantalla AMOLED.', 1799.90, 25, 12, 'Activo', '2026-02-24 05:10:46', '2026-03-17 01:32:25'),
(8, 'TB-XIA-PAD6', 'Xiaomi Pad 6 128GB 11\"', 'Xiaomi', 5, 'Tablet 11\" para productividad y multimedia, 128GB.', 1399.00, 14, 12, 'Activo', '2026-02-24 05:10:46', '2026-03-17 01:32:25'),
(9, 'AL-SAM-980P1', 'SSD NVMe Samsung 980 PRO 1TB', 'Samsung', 7, 'SSD NVMe PCIe 4.0, altas velocidades de lectura/escritura.', 499.90, 40, 36, 'Activo', '2026-02-24 05:10:46', '2026-03-17 01:32:25'),
(10, 'AL-KIN-XS2', 'SSD Kingston A400 480GB', 'Kingston', 7, 'SSD SATA 2.5\" para actualización de equipos.', 169.90, 55, 12, 'Activo', '2026-02-24 05:10:46', '2026-03-17 01:32:25'),
(11, 'NET-TP-AX55', 'Router TP-Link Archer AX55 Wi-Fi 6', 'TP-Link', 8, 'Router Wi-Fi 6 AX3000, mejor cobertura y rendimiento.', 329.90, 30, 24, 'Activo', '2026-02-24 05:10:46', '2026-03-17 01:32:25'),
(12, 'NET-MIK-HAPAX2', 'Router MikroTik hAP ax²', 'MikroTik', 8, 'Router avanzado con Wi-Fi 6 y funciones de red profesionales.', 459.00, 11, 24, 'Activo', '2026-02-24 05:10:46', '2026-03-17 01:32:25'),
(13, 'AUD-LOG-H390', 'Audífonos Logitech H390 USB', 'Logitech', 9, 'Diadema USB con micrófono, ideal para llamadas y clases.', 129.90, 70, 12, 'Activo', '2026-02-24 05:10:46', '2026-03-17 01:32:25'),
(14, 'GAME-LOG-G502X', 'Mouse Logitech G502 X', 'Logitech', 10, 'Mouse gaming con sensor de alta precisión y botones programables.', 219.90, 22, 24, 'Activo', '2026-02-24 05:10:46', '2026-03-17 01:32:25'),
(15, 'PER-RZR-BLK', 'Teclado Mecánico Razer BlackWidow V3', 'Razer', 6, 'Teclado mecánico con switches para escritura y gaming.', 399.90, 8, 24, 'Activo', '2026-02-24 05:10:46', '2026-03-17 01:32:25'),
(16, 'IMP-HP-2775', 'Impresora HP DeskJet 2775 Multifunción Wi-Fi', 'HP', 11, 'Impresora con escáner/copias, conectividad Wi-Fi.', 289.90, 16, 12, 'Activo', '2026-02-24 05:10:46', '2026-03-17 01:32:25'),
(17, 'ACC-ANK-65W', 'Cargador Anker 65W USB-C', 'Anker', 12, 'Cargador rápido USB-C 65W para laptop y smartphone.', 159.90, 35, 18, 'Activo', '2026-02-24 05:10:46', '2026-03-17 01:32:25'),
(18, 'COMP-COR-I513', 'Procesador Intel Core i5 (13ª Gen) - Serie escritorio', 'Intel', 13, 'CPU de escritorio, ideal para productividad y gaming moderado.', 999.90, 7, 12, 'Activo', '2026-02-24 05:10:46', '2026-03-17 01:32:25'),
(19, 'COMP-NVD-4060', 'Tarjeta Gráfica NVIDIA GeForce RTX 4060 8GB', 'NVIDIA', 13, 'GPU para gaming 1080p/1440p con buen rendimiento y eficiencia.', 1599.00, 5, 24, 'Activo', '2026-02-24 05:10:46', '2026-03-17 01:32:25'),
(20, 'ACC-SAN-128', 'Memoria USB SanDisk 128GB 3.2', 'SanDisk', 12, 'USB 3.2 de 128GB para transferencia rápida de archivos.', 69.90, 120, 12, 'Activo', '2026-02-24 05:10:46', '2026-03-17 01:32:25');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos_tecnologia`
--
ALTER TABLE `productos_tecnologia`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sku` (`sku`),
  ADD KEY `idx_marca` (`marca`),
  ADD KEY `idx_precio` (`precio`),
  ADD KEY `fk_producto_categoria` (`categoria_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `productos_tecnologia`
--
ALTER TABLE `productos_tecnologia`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `productos_tecnologia`
--
ALTER TABLE `productos_tecnologia`
  ADD CONSTRAINT `fk_producto_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

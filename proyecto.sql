-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-12-2024 a las 06:21:19
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
-- Base de datos: `proyecto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `usuario` varchar(30) NOT NULL,
  `contraseña` varchar(120) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `sexo` bit(2) DEFAULT b'1',
  `email` varchar(50) NOT NULL,
  `token_contraseña` varchar(40) DEFAULT NULL,
  `contraseña_solicitada` tinyint(4) NOT NULL DEFAULT 0,
  `activo` tinyint(4) NOT NULL,
  `fecha_alta` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`id`, `usuario`, `contraseña`, `nombre`, `sexo`, `email`, `token_contraseña`, `contraseña_solicitada`, `activo`, `fecha_alta`) VALUES
(1, 'admin4', '22222', '', b'01', 'oko@gmail.com', NULL, 0, 1, '2024-12-02 02:29:04'),
(3, 'admin', '$2y$10$taG11ee46X0Eib31sUOxsueQZzb1lMatiKArEcJl2FDpdUm1CLXGy', 'Administrador', b'00', 'contacto@codigosdeprogramacion.com', NULL, 0, 1, '2024-11-17 23:54:25'),
(4, 'admin2', '204240', 'Jesus', b'00', 'alu.22130835@correo.com', NULL, 0, 1, '2024-11-18 07:21:16'),
(5, 'admin3', '300505', 'Yessenia', b'01', 'alu.22130839@gmail.com', NULL, 0, 1, '2024-11-30 20:07:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombres` varchar(80) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `identificador` varchar(20) NOT NULL,
  `estado` tinyint(4) NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `fecha_modifica` datetime DEFAULT NULL,
  `fecha_baja` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombres`, `apellidos`, `email`, `telefono`, `identificador`, `estado`, `fecha_alta`, `fecha_modifica`, `fecha_baja`) VALUES
(1, 'Yessenia', 'Morones', 'alu05@correo.com', '8714848154', '101510012', 1, '2024-12-15 22:40:17', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `id` int(11) NOT NULL,
  `id_transaccion` varchar(20) NOT NULL,
  `fecha` datetime NOT NULL,
  `estado` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `id_cliente` varchar(20) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra`
--

CREATE TABLE `detalle_compra` (
  `id` int(11) NOT NULL,
  `id_compra` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `descripcion` text NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `activo` int(11) NOT NULL,
  `descuento` tinyint(3) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `imagen`, `precio`, `id_categoria`, `cantidad`, `activo`, `descuento`) VALUES
(2, 'Comida Premium', 'Alimento balanceado para perros adultos y razas pequeñas. Sabor a carne y vegetales.', '../imagen/2.webp', 20.00, 1, 7, 1, 127),
(3, 'Galletas Saludables', 'Galletas horneadas con ingredientes naturales. Ideal para premios.', '../imagen/3.jpg', 13.00, 1, 12, 1, 0),
(4, 'Croquetas de Pollo y Arroz', 'Perfectas para cachorros en crecimiento.', '../imagen/4.jpeg', 16.75, 1, 9, 1, 0),
(6, 'Pony', 'Juguete de Pony flexible y duradero.', NULL, 13.00, 0, 0, 1, 0),
(7, 'Colorin Coloron', 'Tinte apto para animales con todos los colores que quieras y necesites. Que tu cachorro se vea divino.', NULL, 10.75, 0, 0, 1, 0),
(9, 'Pitbull Dolly', 'Dolly la muñeca amable, que es un pitbull.', NULL, 60.30, 0, 0, 1, 0),
(10, 'JAJAJAJA FOOD', 'La panzita que da risa con este increible producto que hará a tu can el más feliz de todos.', NULL, 20.99, 0, 0, 1, 0),
(11, 'Sopas de atún', 'Ricos para tus canes de paladar gatuno.', NULL, 20.99, 0, 0, 1, 0),
(12, 'Jarra de dulce organico', 'qw', NULL, 10.00, 0, 0, 0, 0),
(13, 'Noga Bola', 'La favorita de tus mascotas', NULL, 25.00, 0, 0, 0, 0),
(15, 'Labrador Plus - Croqueta', 'Croqueta perfecta para tu can', NULL, 30.60, 0, 0, 1, 0),
(18, 'Venti Lador', 'Ventila y da Amor', NULL, 60.00, 0, 0, 1, 0),
(19, 'Dolphin Molvin', 'El juguete más espectacular del mercado', NULL, 8.99, 0, 0, 0, 0),
(20, 'Mimo el juguete que mima', 'momi', NULL, 829.00, 0, 0, 1, 0),
(21, 'Chuuu', 'CHUUUUU', '../imagen/21.jpeg', 5000.00, 0, 0, 1, 0),
(22, 'Dulce de marfil', 'sopas', '../imagen/22.jpeg', 6.22, 0, 0, 1, 0),
(23, 'Altos', 'sopas', NULL, 9.30, 0, 0, 1, 0),
(24, 'Bajo', 'sopas', NULL, 60.22, 0, 0, 1, 0),
(25, 'Julion Alvarez', 'hyyyynjin', '../imagen/25.jpeg', 300.00, 0, 0, 1, 0),
(26, 'Collar para perros', 'Collar ajustable perfecto', '../imagen/26.jpeg', 30.00, 0, 0, 0, 0),
(27, 'Cuella nueva', 'Cuellos de pollo para la pancita de tu can', '../imagen/27.jpeg', 30.00, 0, 0, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(30) NOT NULL,
  `contraseña` varchar(120) NOT NULL,
  `activacion` int(11) NOT NULL DEFAULT 0,
  `token` varchar(40) NOT NULL,
  `token_constraseña` varchar(40) DEFAULT NULL,
  `contraseña_solicita` int(11) NOT NULL DEFAULT 0,
  `id_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `contraseña`, `activacion`, `token`, `token_constraseña`, `contraseña_solicita`, `id_cliente`) VALUES
(1, 'yessenia', '300505', 1, '442e293bc28146be1bd7864578a8cc26', NULL, 0, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

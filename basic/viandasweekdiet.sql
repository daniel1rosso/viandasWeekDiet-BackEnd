-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-10-2020 a las 00:15:19
-- Versión del servidor: 10.1.33-MariaDB
-- Versión de PHP: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `viandasweekdiet`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comida`
--

CREATE TABLE `comida` (
  `idComida` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `eliminado` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `comida`
--

INSERT INTO `comida` (`idComida`, `nombre`, `descripcion`, `eliminado`) VALUES
(1, 'sin modificar el negross22', 'imagen negrass22daasdasd', 0),
(2, 'Comida 2 test 22ewweq', 'test imagen celeste     weewqw                   \n', 0),
(3, 'sadas', '                        dasdad        \n           ', 0),
(4, 'sdasassd', '12313                                \n            ', 0),
(5, 'Comida 35', '23215                                \n            ', 0),
(6, 'dsdsaads', 'dsdsaaddas                                \n       ', 0),
(7, 'sdadasda', '    adsdasads                            \n        ', 1),
(8, 'fffddds', '                dsadasds                \n         ', 1),
(9, 'saadsdas', '          dsasaddasda                      \n      ', 1),
(10, '3131', 'sadsa                                \n            ', 1),
(11, 'wdsdasa', '         3231232                       \n          ', 1),
(12, 'Comida 21', '12345                                \n            ', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comida_x_vianda`
--

CREATE TABLE `comida_x_vianda` (
  `idComidaXVianda` int(11) NOT NULL,
  `idVianda` int(11) NOT NULL,
  `idComida` int(11) NOT NULL,
  `cantidad` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `idEstado` int(11) NOT NULL,
  `nombre` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `eliminado` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`idEstado`, `nombre`, `eliminado`) VALUES
(1, 'Habilitado', 0),
(2, 'Deshabilitado', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingrediente`
--

CREATE TABLE `ingrediente` (
  `idIngrediente` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `idTipoIngrediente` int(11) NOT NULL,
  `eliminado` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ingrediente`
--

INSERT INTO `ingrediente` (`idIngrediente`, `nombre`, `idTipoIngrediente`, `eliminado`) VALUES
(1, 'Test', 0, 1),
(2, 'Masasa', 0, 1),
(3, 'mesa de nada 2', 0, 1),
(4, 'sal', 0, 1),
(5, 'Masa de pizza', 0, 0),
(6, 'Ingrediente 1', 0, 0),
(7, 'ddaada', 0, 1),
(8, 'd222', 0, 1),
(9, 'Ingrediente 2', 0, 0),
(10, 'Ingrediente 4', 0, 0),
(11, 'Ingrediente 5', 132456, 0),
(12, '12398877', 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingrediente_x_comida`
--

CREATE TABLE `ingrediente_x_comida` (
  `idIngredienteComida` int(11) NOT NULL,
  `idIngrediente` int(11) NOT NULL,
  `idComida` int(11) NOT NULL,
  `idUnidad` int(11) NOT NULL,
  `cantidad` double NOT NULL,
  `eliminado` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ingrediente_x_comida`
--

INSERT INTO `ingrediente_x_comida` (`idIngredienteComida`, `idIngrediente`, `idComida`, `idUnidad`, `cantidad`, `eliminado`) VALUES
(1, 5, 1, 0, 0, 1),
(2, 6, 1, 0, 0, 1),
(3, 6, 1, 0, 0, 1),
(4, 6, 2, 0, 0, 1),
(5, 5, 2, 0, 0, 1),
(6, 6, 2, 0, 0, 1),
(7, 5, 1, 0, 0, 1),
(8, 6, 1, 0, 0, 1),
(9, 5, 1, 0, 0, 1),
(10, 5, 1, 0, 0, 1),
(11, 5, 1, 0, 0, 1),
(12, 5, 1, 0, 0, 1),
(13, 5, 1, 0, 0, 1),
(14, 6, 3, 0, 0, 1),
(15, 5, 1, 0, 0, 1),
(16, 6, 1, 0, 0, 1),
(17, 5, 1, 0, 0, 1),
(18, 6, 1, 0, 0, 1),
(19, 5, 4, 0, 0, 1),
(20, 6, 4, 0, 0, 1),
(21, 5, 1, 0, 0, 1),
(22, 6, 1, 0, 0, 1),
(23, 5, 1, 0, 0, 1),
(24, 6, 1, 0, 0, 1),
(25, 6, 2, 0, 0, 1),
(26, 6, 5, 0, 0, 1),
(27, 7, 5, 0, 0, 1),
(28, 6, 6, 0, 0, 1),
(29, 7, 6, 0, 0, 1),
(30, 8, 6, 0, 0, 1),
(31, 7, 7, 0, 0, 1),
(32, 8, 7, 0, 0, 1),
(33, 7, 8, 0, 0, 1),
(34, 6, 9, 0, 0, 1),
(35, 7, 9, 0, 0, 1),
(36, 7, 10, 0, 0, 1),
(37, 8, 10, 0, 0, 1),
(38, 7, 11, 0, 0, 1),
(39, 8, 11, 0, 0, 1),
(40, 6, 12, 0, 0, 0),
(41, 9, 12, 0, 0, 0),
(42, 10, 12, 0, 0, 0),
(43, 6, 5, 0, 0, 1),
(44, 6, 5, 0, 0, 1),
(45, 9, 5, 0, 0, 1),
(46, 10, 5, 0, 0, 1),
(47, 6, 5, 0, 0, 0),
(48, 9, 5, 0, 0, 0),
(49, 10, 5, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `session_logs`
--

CREATE TABLE `session_logs` (
  `idSession` int(11) NOT NULL,
  `idUsuarioLog` int(11) NOT NULL DEFAULT '0',
  `usuarioLog` varchar(150) NOT NULL DEFAULT '0',
  `idNivel` int(11) NOT NULL DEFAULT '0',
  `fechaCreacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_ingrediente`
--

CREATE TABLE `tipo_ingrediente` (
  `idTipoIngrediente` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `eliminado` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipo_ingrediente`
--

INSERT INTO `tipo_ingrediente` (`idTipoIngrediente`, `nombre`, `eliminado`) VALUES
(1, 'harina', 1),
(2, 'Sal de mesa fina', 1),
(3, 'azucar', 1),
(4, 'Sal marina gruesa', 1),
(5, 'Azúcar', 1),
(6, 'Harina', 1),
(7, 'ssssssss', 1),
(8, 'Ingrediente 3', 1),
(9, 'edulcorante', 1),
(10, 'levaduras', 1),
(11, 'levaduras para pizza', 1),
(12, 'rossitoingredient', 1),
(13, 'nuevo tipo ingrediente', 1),
(14, 'nuevo', 1),
(15, 'carne', 1),
(16, 'ingrediente prueba 2', 1),
(17, 'condimentos', 1),
(18, 'condimentos', 1),
(19, 'ing1', 1),
(20, 'hola actualizado', 0),
(21, 'asjdasod', 1),
(22, 'hola', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad`
--

CREATE TABLE `unidad` (
  `idUnidad` int(11) NOT NULL,
  `nombre` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `eliminado` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `unidad`
--

INSERT INTO `unidad` (`idUnidad`, `nombre`, `eliminado`) VALUES
(1, 'Kilogramo', 0),
(2, 'Gramo', 0),
(3, 'Mililitro', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL,
  `idGenUsuario` varchar(150) NOT NULL,
  `nombreCompleto` varchar(150) NOT NULL,
  `apellido` varchar(55) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `eliminado` int(11) NOT NULL DEFAULT '0',
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `idGenUsuario`, `nombreCompleto`, `apellido`, `password`, `email`, `telefono`, `direccion`, `eliminado`, `fecha`) VALUES
(747, 'Whj95bYJVX7p8nR', 'Root', 'Admin', '25f9e794323b453885f5181f1b624d0b', 'test@test.com', '3333333333', 'Mexico 217', 0, '2020-07-27 22:29:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vianda`
--

CREATE TABLE `vianda` (
  `idVianda` int(11) NOT NULL,
  `nombre` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `idEstado` int(11) NOT NULL,
  `fechaHoraAlta` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `eliminado` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comida`
--
ALTER TABLE `comida`
  ADD PRIMARY KEY (`idComida`);

--
-- Indices de la tabla `comida_x_vianda`
--
ALTER TABLE `comida_x_vianda`
  ADD PRIMARY KEY (`idComidaXVianda`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`idEstado`);

--
-- Indices de la tabla `ingrediente`
--
ALTER TABLE `ingrediente`
  ADD PRIMARY KEY (`idIngrediente`);

--
-- Indices de la tabla `ingrediente_x_comida`
--
ALTER TABLE `ingrediente_x_comida`
  ADD PRIMARY KEY (`idIngredienteComida`);

--
-- Indices de la tabla `session_logs`
--
ALTER TABLE `session_logs`
  ADD PRIMARY KEY (`idSession`);

--
-- Indices de la tabla `tipo_ingrediente`
--
ALTER TABLE `tipo_ingrediente`
  ADD PRIMARY KEY (`idTipoIngrediente`);

--
-- Indices de la tabla `unidad`
--
ALTER TABLE `unidad`
  ADD PRIMARY KEY (`idUnidad`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`);

--
-- Indices de la tabla `vianda`
--
ALTER TABLE `vianda`
  ADD PRIMARY KEY (`idVianda`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comida`
--
ALTER TABLE `comida`
  MODIFY `idComida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `comida_x_vianda`
--
ALTER TABLE `comida_x_vianda`
  MODIFY `idComidaXVianda` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `idEstado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ingrediente`
--
ALTER TABLE `ingrediente`
  MODIFY `idIngrediente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `ingrediente_x_comida`
--
ALTER TABLE `ingrediente_x_comida`
  MODIFY `idIngredienteComida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `session_logs`
--
ALTER TABLE `session_logs`
  MODIFY `idSession` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_ingrediente`
--
ALTER TABLE `tipo_ingrediente`
  MODIFY `idTipoIngrediente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `unidad`
--
ALTER TABLE `unidad`
  MODIFY `idUnidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=748;

--
-- AUTO_INCREMENT de la tabla `vianda`
--
ALTER TABLE `vianda`
  MODIFY `idVianda` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

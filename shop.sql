-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-06-2023 a las 15:25:37
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `shop`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `active` bit(1) NOT NULL DEFAULT b'1',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `name`, `active`, `created_at`, `updated_at`) VALUES
(6, 'Ropas', b'1', '2023-06-05 05:41:28', '2023-06-05 05:41:28'),
(7, 'Tenis', b'1', '2023-06-04 23:44:44', '2023-06-05 05:44:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `id_category` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `stock` int(11) NOT NULL,
  `url` varchar(2000) NOT NULL,
  `active` bit(1) NOT NULL DEFAULT b'1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `id_category`, `price`, `stock`, `url`, `active`, `created_at`, `updated_at`) VALUES
(11, 'Naranja Adidas', 'Bonitos', 7, '250.00', 12, 'https://assets.adidas.com/images/h_840,f_auto,q_auto,fl_lossy,c_fill,g_auto/932db787a2b94b919aa5ae9900cecc55_9366/Zapatilla_adidas_4DFWD_2_Running_Naranja_GY8421_01_standard.jpg', b'0', '2023-06-05 05:51:35', '2023-06-06 18:54:35'),
(17, 'Tenis Blancos', 'MODELO IE1644', 7, '2378.00', 10, 'https://www.innvictus.com/medias/IN-IE1644-1.jpg?context=bWFzdGVyfGltYWdlc3w4NTM1MnxpbWFnZS9qcGVnfGltYWdlcy9oMzkvaDUwLzExNTI1OTIyMzU3Mjc4LmpwZ3wwMTM2YzA1YjVmMzNjYTk2NmVlZWEwODI0MTM1M2JmZmU5NDhmY2M4N2NhZjRmYTVkZjEwY2Q0ZjNiYThmYTcx', b'1', '2023-06-06 17:30:17', '2023-06-06 17:30:45'),
(18, 'Tenis adidas Ozelia', 'MODELO GV7685', 7, '2079.00', 4, 'https://www.innvictus.com/medias/IN-GV7685-1.jpg?context=bWFzdGVyfGltYWdlc3w5NTY5OXxpbWFnZS9qcGVnfGltYWdlcy9oNjIvaDM2LzExMDI1MjYwNTc2Nzk4LmpwZ3w1MDU4ZDQ3NDIyZmM1ZjFlMzMyMTI3N2MwYWQzZjMyMmU5YzM2YzUzNmIxMWUyYjAwZWQwMzVkMzI3MjZlMmZi', b'1', '2023-06-06 17:31:20', '2023-06-06 18:53:39'),
(19, 'Tenis Air Jordan', 'MODELO CD7069-004', 7, '2378.00', 10, 'https://www.innvictus.com/medias/IN-CD7069-004-1.jpg?context=bWFzdGVyfGltYWdlc3wxMTczNTB8aW1hZ2UvanBlZ3xpbWFnZXMvaGE4L2gyMC8xMDgzMjA4NjY2MzE5OC5qcGd8OGMwYzUxZjI2OWQ1ZTA2MTQwOGNlNDIyNDQ3NDhkMGY0NmFmNDAxYjBhYmRkYTdhYTQ4NmZkMGE3OGM2MmIxYQ', b'1', '2023-06-06 17:32:34', '2023-06-06 17:33:58'),
(20, 'Tenis Jordan Legacy 312', 'MODELO CD7069-071', 7, '1849.00', 7, 'https://www.innvictus.com/medias/IN-CD7069-071-1.jpg?context=bWFzdGVyfGltYWdlc3w4OTcwMHxpbWFnZS9qcGVnfGltYWdlcy9oMjIvaDUzLzExMTA3NzE4NDk2Mjg2LmpwZ3xjNTY3YjAzYjc3N2JjNTBkM2EzZDAwZTUzOTZmYTViMmYxNzU3ODUwZWFhOTk1NWNjYjhhNDM1OTUzZGJhODMy', b'1', '2023-06-06 17:33:20', '2023-06-06 17:33:20'),
(21, 'Tenis 312 Low', 'MODELO CD7069-130', 7, '3500.00', 5, 'https://www.innvictus.com/medias/IN-CD7069-130-1.jpg?context=bWFzdGVyfGltYWdlc3w5NDIwNXxpbWFnZS9qcGVnfGltYWdlcy9oYjYvaGNkLzExMjA2Mjg3MDMyMzUwLmpwZ3w1YmU4OTg1OTkxYmYwZTQxZTAwYTliN2UyOTg5YzQxYTViNTllN2M0ZDRlMjU0YmE0ZmZjNGRhNGFjMGUxYTVm', b'1', '2023-06-06 17:34:27', '2023-06-06 17:34:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profiles`
--

CREATE TABLE `profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `profiles`
--

INSERT INTO `profiles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Administrador', '2022-12-18 09:06:54', '2022-12-18 09:06:54'),
(2, 'Cliente', '2022-12-18 09:06:54', '2022-12-18 09:06:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `id_profile` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `nick` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `active` bit(1) NOT NULL DEFAULT b'1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `id_profile`, `name`, `last_name`, `nick`, `email`, `password`, `active`, `created_at`, `updated_at`) VALUES
(1, 1, 'Jonathan','Sabido', 'jonaSabido', 'jonathan_sabido@hotmail.com', '$2y$10$aVAFpbSJcstdmVNUrhi9W.qW8LLu/QhAMFLqaC8s504/8Zla1s47W', b'1', '2023-06-05 11:42:26', '2023-06-06 15:45:41'),
(14, 2, 'Abraham','Quintero', 'abrahamQuin', 'abraham123@hotmail.com', '$2y$10$aVAFpbSJcstdmVNUrhi9W.qW8LLu/QhAMFLqaC8s504/8Zla1s47W', b'1', '2023-06-05 11:42:26', '2023-06-06 15:45:41');

--
-- Estructura de tabla para la tabla `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `sale_date` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `sales`
--

INSERT INTO `sales` (`id`, `id_user`, `total`, `sale_date`, `created_at`, `updated_at`) VALUES
(6, 14, '1039.50', '2023-06-06 00:00:00', '2023-06-06 18:53:39', '2023-06-06 18:53:39'),
(7, 14, '1000.00', '2023-06-06 00:00:00', '2023-06-06 18:54:35', '2023-06-06 18:54:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sale_details`
--

CREATE TABLE `sale_details` (
  `id` int(11) NOT NULL,
  `id_sale` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `sale_details`
--

INSERT INTO `sale_details` (`id`, `id_sale`, `id_product`, `amount`, `total`, `created_at`, `updated_at`) VALUES
(6, 6, 18, 1, '2079.00', '2023-06-06 18:53:39', '2023-06-06 18:53:39'),
(7, 7, 11, 8, '2000.00', '2023-06-06 18:54:35', '2023-06-06 18:54:35');

-- --------------------------------------------------------


--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_idcategoria` (`id_category`);

--
-- Indices de la tabla `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sale_details`
--
ALTER TABLE `sale_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_sale` (`id_sale`),
  ADD KEY `id_product` (`id_product`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_profile` (`id_profile`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `sale_details`
--
ALTER TABLE `sale_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_idcategoria` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id`);

--
-- Filtros para la tabla `sale_details`
--
ALTER TABLE `sale_details`
  ADD CONSTRAINT `sale_details_ibfk_1` FOREIGN KEY (`id_sale`) REFERENCES `sales` (`id`),
  ADD CONSTRAINT `sale_details_ibfk_2` FOREIGN KEY (`id_product`) REFERENCES `products` (`id`);

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_profile`) REFERENCES `profiles` (`id`);
COMMIT;


ALTER TABLE sales ADD COLUMN subtotal decimal(10,2) NULL after total;
ALTER TABLE sales ADD COLUMN discount_rate int(11) NULL after subtotal; 

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-05-2025 a las 23:45:43
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
-- Base de datos: `laravel`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `abogados`
--

CREATE TABLE `abogados` (
  `idAbogado` int(11) NOT NULL,
  `nombres` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `primer_apellido` varchar(60) NOT NULL,
  `segundo_apellido` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `email` varchar(40) NOT NULL,
  `ine` text CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `cedula` text CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL COMMENT 'Anexo 2',
  `anexo` text DEFAULT NULL,
  `representacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `fechaRegistro` date NOT NULL,
  `fechaVigencia` date NOT NULL,
  `empresa` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `eliminado` bit(1) NOT NULL DEFAULT b'0',
  `curp` varchar(18) NOT NULL,
  `domicilio` varchar(80) NOT NULL,
  `rfc` varchar(13) DEFAULT NULL,
  `industria` varchar(50) NOT NULL,
  `poder` text NOT NULL,
  `regionMorelia` enum('Si','No') NOT NULL COMMENT '0 para si  No para NO',
  `regionUruapan` enum('Si','No') NOT NULL,
  `regionZamora` enum('Si','No') NOT NULL,
  `estatus` enum('Pendiente','Validado') NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `abogados`
--

INSERT INTO `abogados` (`idAbogado`, `nombres`, `primer_apellido`, `segundo_apellido`, `telefono`, `email`, `ine`, `cedula`, `anexo`, `representacion`, `fechaRegistro`, `fechaVigencia`, `empresa`, `eliminado`, `curp`, `domicilio`, `rfc`, `industria`, `poder`, `regionMorelia`, `regionUruapan`, `regionZamora`, `estatus`, `updated_at`, `created_at`) VALUES
(1, 'ARMANDO', 'GONZALES', 'RODRIGEZ', '4431326920', 'sam_8929@gmail.com', 'ARMANDOGONZALESRODRIGEZ-GRUPO BIMBO SA DE CV_IDENTIFICACION.pdf', 'Sin carta poder', 'ARMANDOGONZALESRODRIGEZ-GRUPO BIMBO SA DE CV_ANEXO.pdf', 'ARMANDOGONZALESRODRIGEZ-GRUPO BIMBO SA DE CV_REPRESENTACION.pdf', '2025-05-12', '2025-05-31', 'GRUPO BIMBO SA DE CV', b'0', 'BEMI890329HMNDTR02', 'CALLE JOSE MARIA MORELOS #35 COLONIA CENTRO', 'BEMI890329S49', 'VENTA DE NEUMATICOS', 'DESCRIPCION DE PODER', 'Si', 'Si', 'Si', 'Pendiente', '2025-05-12 19:36:01', '2025-05-12 19:36:01'),
(2, 'JUAN', 'ROSALES', 'GARIBAY', '4436891557', 'juan@gmail.com', 'JUANROSALESGARIBAY-GRUPO PEPSI_IDENTIFICACION.pdf', 'Sin carta poder', 'Sin anexo', 'JUANROSALESGARIBAY-GRUPO PEPSI_REPRESENTACION.pdf', '2025-05-21', '2025-07-25', 'GRUPO PEPSI', b'0', 'BEMI890329HMNDTR02', 'BULEBART GARCIA DE LEON #24 COLONIA VENTURA PUENTE', 'BEMI890329S49', 'Atención ciudadana', 'La descripcion del poder', 'Si', 'No', 'No', 'Pendiente', '2025-05-21 21:21:05', '2025-05-21 21:21:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `capacitaciones`
--

CREATE TABLE `capacitaciones` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `modulos` int(11) NOT NULL,
  `inicio` date NOT NULL,
  `fin` date NOT NULL,
  `estatus` enum('En curso','Cerrado','Cancelado','Terminado') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `capacitaciones`
--

INSERT INTO `capacitaciones` (`id`, `nombre`, `modulos`, `inicio`, `fin`, `estatus`, `created_at`, `updated_at`) VALUES
(1, 'Sistema Integral', 2, '2024-12-12', '2024-12-19', 'Terminado', '2024-12-05 16:59:20', '2024-12-05 21:57:31'),
(2, 'Sistema Integral2', 2, '2024-12-12', '2024-12-20', 'En curso', '2024-12-05 17:01:50', '2024-12-05 17:01:50'),
(3, 'Lenjuage y resolucion de conflicto', 4, '2024-11-01', '2024-12-31', 'En curso', '2024-12-06 19:10:19', '2024-12-06 19:10:19'),
(11, 'Primera capacitacion del centro de conciliacion laboral del estado de michoacan.', 4, '2025-01-06', '2025-03-31', 'Terminado', '2024-12-04 16:51:05', '2024-12-05 21:29:43'),
(12, 'Prueba de tercera capacitacion', 4, '2024-12-04', '2024-12-31', 'Terminado', '2024-12-04 19:03:55', '2025-03-14 18:13:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `capacitaciones_calificacion`
--

CREATE TABLE `capacitaciones_calificacion` (
  `id` int(11) NOT NULL,
  `capacitacion` int(11) NOT NULL,
  `persona` int(11) NOT NULL,
  `calificacion` float NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `capacitaciones_calificacion`
--

INSERT INTO `capacitaciones_calificacion` (`id`, `capacitacion`, `persona`, `calificacion`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 0, '2024-12-05 17:35:52', '2024-12-05 17:51:51'),
(2, 2, 1, 0, '2024-12-05 17:49:06', '2024-12-05 17:49:06'),
(3, 2, 2, 100, '2024-12-05 18:04:05', '2024-12-05 18:04:05'),
(4, 1, 3, 0, '2024-12-06 19:13:20', '2024-12-06 19:13:20'),
(9, 9, 11, 0, '2024-07-09 05:09:18', '2024-07-09 05:09:18'),
(10, 9, 15, 50, '2024-09-02 22:34:37', '2024-09-02 22:38:22'),
(11, 12, 15, 0, '2024-12-04 20:52:54', '2024-12-04 20:59:53'),
(12, 1, 18, 0, '2025-03-14 18:55:50', '2025-03-14 18:55:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `capacitaciones_encuesta`
--

CREATE TABLE `capacitaciones_encuesta` (
  `id` int(11) NOT NULL,
  `id_cap` int(11) NOT NULL,
  `id_modulo` int(11) NOT NULL,
  `pregunta` varchar(50) NOT NULL,
  `respuesta1` varchar(50) NOT NULL,
  `respuesta2` varchar(50) NOT NULL,
  `respuesta3` varchar(50) NOT NULL,
  `respuesta4` varchar(50) NOT NULL,
  `correcta` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `capacitaciones_encuesta`
--

INSERT INTO `capacitaciones_encuesta` (`id`, `id_cap`, `id_modulo`, `pregunta`, `respuesta1`, `respuesta2`, `respuesta3`, `respuesta4`, `correcta`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '¿Que aprendiste?', 'Respuesta', 'respuesta 2', 'sistema integral', 'respuesta 4', 1, '2024-12-05 17:29:31', '2024-12-05 17:29:31'),
(4, 2, 1, '¿Quien eres?', 'Respuesta', 'respuesta 2', 'sistema integral', 'respuesta 4', 1, '2024-12-05 17:45:32', '2024-12-05 17:45:32'),
(5, 3, 1, 'Que opinas de la pregunta 1', 'res 1', 'rews 2', 'res 3', 'negro', 2, '2024-12-06 19:11:33', '2024-12-06 19:11:33'),
(24, 5, 1, '1.	¿Qué cambios ha generado la globalización?', 'Apoyos sociales.', 'Modificación en instituciones económico-financiera', 'Un fortalecimiento de las instituciones.', 'Emociones', 2, '2024-06-21 00:15:13', '2024-06-21 00:15:13'),
(25, 5, 1, '2.	¿De acuerdo con el autor, la reducción de carác', 'Apoyos sociales.', 'Desregularización de la economía, privatización y ', 'Un fortalecimiento de las instituciones.', 'El conflicto', 2, '2024-06-21 00:15:13', '2024-06-21 00:15:13'),
(33, 11, 1, 'Que opinas de la pregunta 1', 'res 1', 'rews 2', 'res 3', 'res 4', 2, '2024-12-04 18:45:36', '2024-12-04 18:45:36'),
(35, 11, 2, 'Que opinas de la pregunta 1', 'res 1', 'rews 2', 'res 3', 'res 4', 2, '2024-12-04 18:55:41', '2024-12-04 18:55:41'),
(36, 12, 1, 'Que opinas de la pregunta 1', 'uyg', 'yg', 'yg', 'ugyuyg', 1, '2024-12-04 19:08:38', '2024-12-04 19:08:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `capacitaciones_modulo`
--

CREATE TABLE `capacitaciones_modulo` (
  `id` int(11) NOT NULL,
  `id_cap` int(11) NOT NULL,
  `id_modulo` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `introduccion` text NOT NULL,
  `desarrollo` text NOT NULL,
  `estatus` enum('Pendiente','Termiando','Activo') NOT NULL DEFAULT 'Pendiente',
  `anexo1` text DEFAULT NULL,
  `anexo2` text DEFAULT NULL,
  `anexo3` text DEFAULT NULL,
  `anexo4` text DEFAULT NULL,
  `anexo5` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `capacitaciones_modulo`
--

INSERT INTO `capacitaciones_modulo` (`id`, `id_cap`, `id_modulo`, `nombre`, `introduccion`, `desarrollo`, `estatus`, `anexo1`, `anexo2`, `anexo3`, `anexo4`, `anexo5`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Turnos1', 'wefsdv', 'rdfv', 'Pendiente', 'Turnos1_Anexo1.pdf', NULL, NULL, NULL, 'Turnos1_Anexo5.mp4', '2024-12-05 17:29:31', '2024-12-05 17:29:31'),
(2, 2, 1, 'seer2', 'ewdscx', 'rfdvc', 'Pendiente', NULL, NULL, NULL, NULL, NULL, '2024-12-05 17:30:42', '2024-12-05 17:30:42'),
(4, 1, 2, 'prueba', 'gvutavxash', 'sdkhcvaosuj', 'Pendiente', 'prueba_Anexo1.pdf', NULL, NULL, NULL, NULL, '2024-12-05 21:56:39', '2024-12-05 21:56:39'),
(5, 3, 1, 'Modulo1', 'dasjhdakjhdksaj', 'sduhfuisdhfiuhds', 'Pendiente', 'Modulo1_Anexo1.pdf', NULL, NULL, NULL, NULL, '2024-12-06 19:11:33', '2024-12-06 19:11:33'),
(13, 5, 1, 'Módulo I: Antecedentes y Generalidades de la Reforma al Sistema de Justicia Laboral', 'La justicia cotidiana es la justicia más cercana a las personas. La que vivimos día a día en nuestras interacciones ordinarias, la que facilita la convivencia armónica y la paz social. Es la que reclaman vecinos, trabajadores, padres de familia y la que se vive en las escuelas. Por décadas, la justicia cotidiana ha estado lejos de ser una prioridad en nuestro país. Nos hemos concentrado en la justicia penal que, aunque sin duda importante, atiende conflictos menos frecuentes. A uno de los próceres de la patria, José María Morelos y Pavón, se le atribuye una frase que por más de dos siglos ha sido una aspiración para los mexicanos: “Que todo el que se queje con justicia tenga un tribunal que lo escuche, lo ampare y lo defienda contra el fuerte y el arbitrario.” Hoy, tener acceso a un tribunal para resolver los conflictos más comunes no es suficiente en México. Estos Diálogos por la Justicia Cotidiana ilustran bien que aún hay más por hacer. Actualmente, las injusticias se asoman en lo ordinario. Requerimos no sólo que los tribunales protejan al indefenso, sino que lo hagan de manera expedita y, principalmente, que nuestros conflictos se resuelvan de fondo y todos tengan certeza sobre sus derechos.', 'Desde hace más de tres décadas, la globalización ha generado cambios significativos en las estructuras e instituciones económico-financieras, sociales, laborales, educativas y políticas; transformaciones marcadas, al menos, por tres fenómenos:\r\n1.	La reducción del carácter social del Estado que implicó la desregulación de la economía, el redimensionamiento del sector público, la privatización y la “extranjerización” de las empresas estatales y los recursos naturales.\r\n2.	La apertura e integración de los aparatos productivos y los mercados a instancias multinacionales de diversa dimensión; y\r\n3.	La recomposición de los procesos de trabajo y la flexibilización de las relaciones laborales asociadas a la intensa innovación tecnológica.', 'Pendiente', 'Módulo I: Antecedentes y Generalidades de la Reforma al Sistema de Justicia Laboral_Anexo1.pdf', NULL, NULL, NULL, NULL, '2024-06-21 00:08:55', '2024-06-21 00:08:55'),
(19, 11, 1, 'LIZBETH ALEJANDRA', 'asddasdasdsada', 'sdasdasdasd', 'Pendiente', 'LIZBETH ALEJANDRA_Anexo1.mp4', 'LIZBETH ALEJANDRA_Anexo2.pdf', NULL, NULL, NULL, '2024-12-04 18:45:36', '2024-12-04 18:45:36'),
(21, 11, 2, 'Modulo 2', 'Introduccion al modulo 2', 'desarrollo del modulo 2', 'Pendiente', 'Modulo 2_Anexo1.pdf', NULL, NULL, 'Modulo 2_Anexo4.mp4', NULL, '2024-12-04 18:55:41', '2024-12-04 18:55:41'),
(22, 12, 1, 'Prueba 4', 'sdfsd', 'huuih', 'Pendiente', NULL, NULL, NULL, NULL, NULL, '2024-12-04 19:08:38', '2024-12-04 19:08:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `capacitaciones_persona`
--

CREATE TABLE `capacitaciones_persona` (
  `id` int(11) NOT NULL,
  `capacitacion` int(11) NOT NULL,
  `persona` int(11) NOT NULL,
  `modulo` int(11) NOT NULL,
  `estatus` enum('En curso','Terminado','Cancelado','En prueba') NOT NULL DEFAULT 'En curso',
  `calificacion` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `capacitaciones_persona`
--

INSERT INTO `capacitaciones_persona` (`id`, `capacitacion`, `persona`, `modulo`, `estatus`, `calificacion`, `created_at`, `updated_at`) VALUES
(6, 2, 1, 1, 'En prueba', NULL, '2024-12-05 17:50:56', '2024-12-05 17:50:56'),
(7, 2, 2, 1, 'Terminado', 100, '2024-12-05 17:55:38', '2024-12-05 17:55:38'),
(71, 9, 11, 1, 'Terminado', 0, '2024-07-09 05:04:34', '2024-07-09 05:04:34'),
(72, 9, 12, 1, 'En curso', NULL, '2024-07-09 05:04:35', '2024-07-09 05:04:35'),
(73, 9, 13, 1, 'En curso', NULL, '2024-07-09 05:04:36', '2024-07-09 05:04:36'),
(74, 10, 11, 1, 'En curso', NULL, '2024-08-31 01:07:39', '2024-08-31 01:07:39'),
(79, 10, 12, 1, 'En curso', NULL, '2024-09-02 22:09:36', '2024-09-02 22:09:36'),
(80, 9, 15, 1, 'En curso', 50, '2024-09-02 22:13:55', '2024-09-02 22:13:55'),
(83, 12, 16, 1, 'En curso', NULL, '2024-12-04 19:35:12', '2024-12-04 19:35:12'),
(84, 11, 11, 1, 'En curso', NULL, '2025-01-13 17:42:48', '2025-01-13 17:42:48'),
(85, 11, 11, 2, 'En curso', NULL, '2025-01-13 17:42:48', '2025-01-13 17:42:48'),
(95, 1, 2, 1, 'En curso', NULL, '2025-03-14 18:42:15', '2025-03-14 18:42:15'),
(96, 1, 2, 2, 'En curso', NULL, '2025-03-14 18:42:15', '2025-03-14 18:42:15'),
(101, 1, 11, 1, 'En curso', NULL, '2025-03-14 18:51:17', '2025-03-14 18:51:17'),
(102, 1, 11, 2, 'En curso', NULL, '2025-03-14 18:51:17', '2025-03-14 18:51:17'),
(103, 1, 16, 1, 'En curso', NULL, '2025-03-14 18:51:21', '2025-03-14 18:51:21'),
(104, 1, 16, 2, 'En curso', NULL, '2025-03-14 18:51:21', '2025-03-14 18:51:21'),
(105, 1, 18, 1, 'Terminado', 0, '2025-03-14 18:53:39', '2025-03-14 18:53:39'),
(106, 1, 18, 2, 'En prueba', NULL, '2025-03-14 18:53:39', '2025-03-14 18:53:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalogo_actividad`
--

CREATE TABLE `catalogo_actividad` (
  `id` int(11) NOT NULL,
  `act_economica` text NOT NULL,
  `id_rama` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `catalogo_actividad`
--

INSERT INTO `catalogo_actividad` (`id`, `act_economica`, `id_rama`, `created_at`, `updated_at`) VALUES
(1, 'Agricultura', 2, '2025-04-09 17:38:14', '2025-04-09 17:38:14'),
(2, 'Cultivo en invernaderos y otras estructuras agrícolas protegidas, y floricultura', 2, '2025-04-09 17:38:14', '2025-04-09 17:38:14'),
(3, 'Cultivo de productos alimenticios en invernaderos y otras estructuras agrícolas protegidas', 2, '2025-04-09 17:39:29', '2025-04-09 17:39:29'),
(4, 'Cultivo de jitomate en invernaderos y otras estructuras agrícolas protegidas', 2, '2025-04-09 17:39:29', '2025-04-09 17:39:29'),
(5, 'Cultivo de fresa en invernaderos y otras estructuras agrícolas protegidas', 2, '2025-04-09 17:40:00', '2025-04-09 17:40:00'),
(6, 'Cultivo de chile en invernaderos y otras estructuras agrícolas protegidas', 2, '2025-04-09 17:40:00', '2025-04-09 17:40:00'),
(7, 'Cultivo de manzana en invernaderos y otras estructuras agrícolas protegidas', 2, '2025-04-09 17:40:29', '2025-04-09 17:40:29'),
(8, 'Cultivo de pepino en invernaderos y otras estructuras agrícolas protegidas', 2, '2025-04-09 17:40:29', '2025-04-09 17:40:29'),
(9, 'Cultivo de otros productos alimenticios en invernaderos y otras estructuras agrícolas protegidas', 2, '2025-04-09 17:41:00', '2025-04-09 17:41:00'),
(10, 'Cultivo de bayas (berries) en invernaderos y otras estructuras agrícolas protegidas, excepto fresas', 2, '2025-04-09 17:41:00', '2025-04-09 17:41:00'),
(11, 'Floricultura, y otros cultivos de productos no alimenticios en invernaderos y otras estructuras agrícolas protegidas', 2, '2025-04-09 17:42:26', '2025-04-09 17:42:26'),
(12, 'Floricultura en invernaderos y otras estructuras agrícolas protegidas', 2, '2025-04-09 17:42:26', '2025-04-09 17:42:26'),
(13, 'Otros cultivos no alimenticios en invernaderos y otras estructuras agrícolas protegidas', 2, '2025-04-09 17:46:22', '2025-04-09 17:46:22'),
(14, 'Actividades agrícolas combinadas con explotación de animales', 2, '2025-04-09 17:46:22', '2025-04-09 17:46:22'),
(15, 'Actividades agrícolas combinadas con aprovechamiento forestal', 2, '2025-04-09 17:47:49', '2025-04-09 17:47:49'),
(16, 'Actividades agrícolas combinadas con explotación de animales y aprovechamiento forestal', 2, '2025-04-09 17:47:49', '2025-04-09 17:47:49'),
(17, 'Servicios relacionados con la agricultura', 2, '2025-04-09 17:49:32', '2025-04-09 17:49:32'),
(18, 'Servicios de fumigación agricultura', 2, '2025-04-09 17:49:32', '2025-04-09 17:49:32'),
(19, 'Beneficio de productos agrícolas', 2, '2025-04-09 17:50:36', '2025-04-09 17:50:36'),
(20, 'Otros servicios relacionados con la agricultura', 2, '2025-04-09 17:50:36', '2025-04-09 17:50:36'),
(21, 'Actividades legislativas, gubernamentales y de impartición de justicia', 1, '2025-04-09 17:53:42', '2025-04-09 17:53:42'),
(22, 'Regulación y fomento de actividades para mejorar y preservar el medio ambiente', 1, '2025-04-09 17:53:42', '2025-04-09 17:53:42'),
(23, 'Actividades administrativas de instituciones de bienestar social', 1, '2025-04-09 17:54:43', '2025-04-09 17:54:43'),
(24, 'Actividades de seguridad nacional', 1, '2025-04-09 17:54:43', '2025-04-09 17:54:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalogo_motivos`
--

CREATE TABLE `catalogo_motivos` (
  `id` int(11) NOT NULL,
  `motivo` text NOT NULL,
  `tipo_solicitud` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `catalogo_motivos`
--

INSERT INTO `catalogo_motivos` (`id`, `motivo`, `tipo_solicitud`, `created_at`, `updated_at`) VALUES
(1, 'Despido', 1, '2025-04-09 15:36:59', '2025-04-09 15:37:26'),
(2, 'Pago de prestaciones', 0, '2025-04-09 15:36:59', '2025-04-09 15:37:26'),
(3, 'Rescisión de la relación de trabajo', 0, '2025-04-09 15:36:59', '2025-04-09 15:37:26'),
(4, 'Derecho de preferencia', 0, '2025-04-09 15:36:59', '2025-04-09 15:37:26'),
(5, 'Derecho de antigüedad', 0, '2025-04-09 15:36:59', '2025-04-09 15:37:26'),
(6, 'Derecho de ascenso', 0, '2025-04-09 15:36:59', '2025-04-09 15:37:26'),
(7, 'Terminación voluntaria de la relación de trabajo', 0, '2025-04-09 15:36:59', '2025-04-09 15:37:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalogo_rama`
--

CREATE TABLE `catalogo_rama` (
  `id` int(11) NOT NULL,
  `rama_industrial` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `catalogo_rama`
--

INSERT INTO `catalogo_rama` (`id`, `rama_industrial`, `created_at`, `updated_at`) VALUES
(1, 'Actividades legislativas, gubernamentales, de impartición de justicia y de organismos internacionales y extraterritoriales', '2025-04-09 15:43:39', '2025-04-09 15:44:03'),
(2, 'Agricultura, cría y explotación de animales, aprovechamiento forestal, pesca y caza', '2025-04-09 15:43:39', '2025-04-09 15:44:03'),
(3, 'Comercio al por mayor', '2025-04-09 15:43:39', '2025-04-09 15:44:03'),
(4, 'Comercio al por menor', '2025-04-09 15:43:39', '2025-04-09 15:44:03'),
(5, 'Construcción', '2025-04-09 15:43:39', '2025-04-09 15:44:03'),
(6, 'Corporativos', '2025-04-09 15:43:39', '2025-04-09 15:44:03'),
(7, 'Correos y almacenamiento', '2025-04-09 15:43:39', '2025-04-09 15:44:03'),
(8, 'Generación, transmisión, distribución y comercialización de energía eléctrica, suministro de agua y gas natural por ductos al consumidor final', '2025-04-09 15:43:39', '2025-04-09 15:44:03'),
(9, 'Industrias manufactureras (Alimentos y bebidas, textiles y ropa, cuero y piel)', '2025-04-09 15:43:39', '2025-04-09 15:44:03'),
(10, 'Industrias manufactureras (madera, papel, impresión, productos petróleo y carbón, química, plástico, hule, minerales no metálicos)', '2025-04-09 15:43:39', '2025-04-09 15:44:03'),
(11, 'Industrias manufactureras (metálicas, maquinaria, fabricación equipo de computación, comunicación, eléctrico, transporte, muebles, equipo generación electricidad)', '2025-04-09 15:43:39', '2025-04-09 15:44:03'),
(12, 'Información en medios masivos', '2025-04-09 15:43:39', '2025-04-09 15:44:03'),
(13, 'Minería', '2025-04-09 15:43:39', '2025-04-09 15:44:03'),
(14, 'Otros servicios excepto actividades gubernamentales', '2025-04-09 15:43:39', '2025-04-09 15:44:03'),
(15, 'Servicios de alojamiento temporal y de preparación de alimentos y bebidas', '2025-04-09 15:43:39', '2025-04-09 15:44:03'),
(16, 'Servicios de apoyo a los negocios y manejo de residuos, y servicios de remediación', '2025-04-09 15:43:39', '2025-04-09 15:44:03'),
(17, 'Servicios de esparcimiento culturales y deportivos, y otros servicios recreativos', '2025-04-09 15:43:39', '2025-04-09 15:44:03'),
(18, 'Servicios de salud y de asistencia social', '2025-04-09 15:43:39', '2025-04-09 15:44:03'),
(19, 'Servicios educativos', '2025-04-09 15:43:39', '2025-04-09 15:44:03'),
(20, 'Servicios financieros y de seguros', '2025-04-09 15:43:39', '2025-04-09 15:44:03'),
(21, 'Servicios inmobiliarios y de alquiler de bienes muebles e intangibles', '2025-04-09 15:43:39', '2025-04-09 15:44:03'),
(22, 'Servicios profesionales, científicos y técnicos', '2025-04-09 15:43:39', '2025-04-09 15:44:03'),
(23, 'Transportes', '2025-04-09 15:43:39', '2025-04-09 15:44:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chat_preguntas`
--

CREATE TABLE `chat_preguntas` (
  `id` int(11) NOT NULL,
  `pregunta` varchar(300) NOT NULL,
  `respuesta` varchar(1500) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `chat_preguntas`
--

INSERT INTO `chat_preguntas` (`id`, `pregunta`, `respuesta`, `created_at`, `updated_at`) VALUES
(1, '¿Cuál es el procedimiento de conciliación prejudicial?', 'El procedimiento de conciliación prejudicial se encuentra previsto en la Constitución Política de los Estados Unidos Mexicanos, así como en la Ley Federal del Trabajo. Es un procedimiento de carácter extrajudicial por medio del cual las partes en conflicto (trabajadores y patrones) pueden llegar a un convenio para dar solución a la controversia.\r\nLa interposición del procedimiento de conciliación prejudicial es obligatoria (salvo las excepciones establecidas por la ley) para poder acceder a la vía jurisdiccional ante los tribunales laborales.', '2025-03-27 18:49:56', '2025-02-27 22:44:12'),
(2, '¿Cuáles son las etapas del procedimiento de conciliación?', 'Las etapas del procedimiento de conciliación prejudicial son las siguientes:\r\n	Presentación de la solicitud de conciliación a solicitud de parte o de las partes\r\n	Audiencia de conciliación\r\n	Celebración de convenio (que adquiere la categoría de cosa juzgada)\r\n	Ejecución o cumplimiento del convenio', '2025-03-27 18:50:31', '2025-02-27 22:44:12'),
(3, '¿Quién es la autoridad conciliadora?', 'El Centro Federal de Conciliación y Registro Laboral o los Centros de Conciliación de las entidades federativas según corresponda, serán autoridades conciliadoras en el procedimiento de conciliación prejudicial.\r\n', '2025-03-27 18:50:53', '2025-02-27 22:44:12'),
(4, '¿Cuál deberá ser el contenido de la solicitud de conciliación laboral?', 'La solicitud de conciliación laboral deberá contener:\r\n	Nombre, CURP, identificación oficial del solicitante y domicilio para recibir notificaciones en el lugar de residencia del Centro de Conciliación al que se acuda\r\n	Nombre de la persona, sindicato o empresa que se citará para la conciliación prejudicial\r\n	Domicilio para notificar a la persona, sindicato o empresa que se citará\r\n	Objeto de la cita', '2025-03-27 18:51:29', '2025-02-27 22:44:12'),
(5, '¿Qué pasa si el trabajador que presenta la solicitud de conciliación laboral y no sabe el nombre de su patrón o de la empresa respecto de la cual solicita conciliación?', 'Si el solicitante de la conciliación es el trabajador y desconoce el nombre del patrón o empresa de la cual solicita la conciliación, bastará que en la solicitud de conciliación laboral señale el domicilio donde prestó sus servicios y la actividad comercial de su patrón.', '2025-03-27 18:52:42', '2025-02-27 22:44:12'),
(6, '¿Cuál deberá ser el plazo de duración del procedimiento de conciliación?', 'El procedimiento de conciliación no podrá exceder de 45 días naturales.', '2025-03-27 18:53:04', '2025-02-27 22:44:12'),
(7, '¿Qué pasa si la autoridad conciliadora ante la que se presentó la solicitud de conciliación no es la competente para conocer del asunto?', 'En caso de no ser competente, la autoridad conciliadora deberá remitir la solicitud al Centro de Conciliación competente vía electrónica, dentro de las 24 horas siguientes de recibida la solicitud, lo cual deberá notificar al solicitante para que acuda ante la autoridad competente a continuar el procedimiento.', '2025-03-27 18:53:31', '2025-02-27 22:44:12'),
(8, '¿En qué consiste la audiencia de conciliación laboral?', 'En la audiencia de conciliación laboral:\r\n	Las partes narran sus versiones del conflicto y expresan sus pretensiones\r\n	La autoridad conciliadora, conoce, analiza e identifica el conflicto entre las partes, y mediante técnicas de comunicación y el uso de métodos de conciliación propone una solución al conflicto entre las partes. La autoridad conciliadora deberá tomar en cuenta las necesidades de las partes, salvaguardando los derechos fundamentales y las premisas establecidas en la Ley Federal del Trabajo.\r\n	Puede suceder que:\r\n	Las partes se niegan a llegar a un acuerdo conciliatorio y en este caso la autoridad conciliadora da por agotada la etapa de conciliación prejudicial y expide la constancia de no conciliación para que las partes acudan a los Tribunales Laborales.\r\n	Las partes no llegan a una conciliación pero sí desean realizarla en una nueva audiencia.\r\n	Las partes aceptan la propuesta de conciliación, se eleva a grado de convenio y adquiere la condición de cosa juzgada y cualquiera de las partes podrá promover su cumplimiento ante el Tribunal Laboral especializado mediante el procedimiento de ejecución de sentencia que establece la Ley Federal del Trabajo.', '2025-03-27 18:54:28', '2025-02-27 22:44:12'),
(9, '¿Qué pasa si el solicitante de la conciliación o el citado o ambos no se presentan a la audiencia de conciliación por causa justificada?', 'Si alguna de las partes o ambas no comparecen a la audiencia de conciliación por causa justificada, se señalará nueva fecha y hora para la celebración de la audiencia.', '2025-03-27 18:54:59', '2025-02-27 22:44:12'),
(10, '¿Qué pasa si el solicitante de la conciliación no se presenta a la audiencia de conciliación?', 'Si a la audiencia de conciliación no se presenta el solicitante de la audiencia, se archivará el expediente por falta de interés del solicitante.', '2025-03-27 18:55:23', '2025-02-27 22:44:12'),
(11, '¿Qué pasa si a la audiencia de conciliación sólo se presenta el solicitante de la conciliación?', 'Si a la audiencia de conciliación sólo comparece el solicitante, la autoridad conciliadora emitirá la constancia de haber agotado la etapa de conciliación prejudicial obligatoria.', '2025-03-27 18:56:06', '2025-03-27 18:56:06'),
(12, '¿Qué pasa si a la audiencia de conciliación solo se presenta el citado?', 'Si a la audiencia de conciliación sólo comparece el citado, se archivará el expediente por falta de interés del solicitante.', '2025-03-27 18:56:06', '2025-03-27 18:56:06'),
(13, '¿Qué es el convenio de conciliación?', 'El convenio de conciliación es el acuerdo o arreglo al cual llegan las partes (trabajador y patrón) para dar por terminada la controversia entre ellas. El convenio se celebra por escrito y se ratifica por las partes ante la autoridad conciliadora.\r\nUna vez que se celebre el convenio de conciliación, este adquirirá la condición de cosa juzgada, teniendo la calidad de un título para iniciar acciones ejecutivas.', '2025-03-27 18:56:41', '2025-03-27 18:56:41'),
(14, '¿A qué se refiere que el convenio de conciliación adquiera la condición de cosa juzgada?', 'Si bien el convenio de conciliación no resulta propiamente de un juicio, adquiere la condición de cosa juzgada, es decir, el convenio podrá ser exigible ante la autoridad jurisdiccional en caso de incumplimiento.', '2025-03-27 18:56:41', '2025-03-27 18:56:41'),
(15, '¿Qué es la constancia de no conciliación?', 'La constancia de no conciliación es el documento en el cual la autoridad conciliadora hace constar que se agotó la instancia de conciliación prejudicial y que las partes (trabajador y patrón) no llegaron a un acuerdo o bien que se trata de un caso de excepción de conciliación.', '2025-03-27 18:57:13', '2025-03-27 18:57:13'),
(16, '¿Qué requisitos debe tener una persona para desempeñar el cargo de conciliador en el Centro de Conciliación?', 'La Ley Federal del Trabajo establece los requisitos para que una persona pueda desempeñar el cargo de conciliador:\r\n	Gozar del pleno ejercicio de sus derechos políticos y civiles\r\n	Tener experiencia de por lo menos tres años en áreas del derecho del trabajo\r\n	Contar con título profesional a nivel licenciatura en una carrera afín a la función del centro\r\n	Contar con certificación en conciliación laboral o mediación y mecanismos alternativos de solución de controversias\r\n	Tener conocimientos sobre derechos humanos y perspectiva de género\r\n	Aprobar el procedimiento de selección\r\n	No estar inhabilitado para desempeñar empleo, cargo o comisión en el servicio público', '2025-03-27 18:57:13', '2025-03-27 18:57:13'),
(17, '¿Cuáles son las atribuciones y obligaciones de los conciliadores?', 'Los conciliadores tienen las siguientes atribuciones y facultades:\r\n	Emitir el citatorio a la audiencia de conciliación\r\n	Aprobar o desestimar las causas de justificación para la inasistencia de las partes a la audiencia de conciliación\r\n	Comunicar a las partes el objeto y alcance de la conciliación\r\n	Exhortar a las partes para llegar a un arreglo\r\n	Evaluar las solicitudes de los interesados para determinar la forma más adecuada para llegar a un arreglo\r\n	Redactar, revisar y sancionar los acuerdos a que lleguen las partes\r\n	Elaborar el acta en la que se certificará la celebración de las audiencias de conciliación y dar fe en su caso de la entrega al trabajador de las cantidades o prestaciones convenidas\r\n	Expedir las actas de las audiencias de conciliación a su cargo, autorizar los convenios a que lleguen las partes\r\n	Cuidar que los acuerdos a que lleguen las partes no vulneren los derechos de los trabajadores\r\n	Cuidar que los procesos de conciliación en que intervenga no vulneren los derechos de terceros ni disposiciones de orden público\r\n', '2025-03-27 18:57:45', '2025-03-27 18:57:45'),
(18, '¿Cuáles son las obligaciones de los conciliadores en el desempeño de sus atribuciones?', 'De conformidad con la Ley Federal del Trabajo, los conciliadores tendrán las siguientes obligaciones:\r\n	Salvaguardar los derechos del trabajador\r\n	Tratar con equidad y respeto a los interesados\r\n	Observar los principios de conciliación, imparcialidad, neutralidad, flexibilidad, legalidad, equidad, buena fe, información, honestidad y confidencialidad\r\n	Abstenerse de fungir como testigos, representantes jurídicos o abogados de los asuntos relativos a los mecanismos alternativos en los que participen posteriormente en juicio\r\n	Ser proactivo para lograr la conciliación entre las partes\r\n	Procurar el equilibrio entre los factores de la producción y la justicia social, y del trabajo digno y decente\r\n	Cumplir con los programas de capacitación y actualización para la renovación de la certificación', '2025-03-27 18:57:45', '2025-03-27 18:57:45'),
(19, '¿Para qué tendrán fe pública los conciliadores?', 'Los conciliadores tendrán fe pública para certificar:\r\n	Los instrumentos con los que las partes acrediten la personalidad e identidad con la que comparecen\r\n	La información que asienten en las actuaciones del procedimiento de conciliación\r\n	Los convenios a los que lleguen las partes (en su caso)\r\n	Copias de los convenios que se celebren ante su presencia', '2025-03-27 18:58:10', '2025-03-27 18:58:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chat_registro`
--

CREATE TABLE `chat_registro` (
  `id` int(11) NOT NULL,
  `nombre_completo` varchar(200) NOT NULL,
  `ciudad` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` time NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `chat_registro`
--

INSERT INTO `chat_registro` (`id`, `nombre_completo`, `ciudad`, `created_at`, `updated_at`) VALUES
(130, 'LAURA', 'MORELIA', '2025-03-07 19:25:25', '13:25:25'),
(131, '1234', 'MORELIA', '2025-03-07 19:33:04', '13:33:04'),
(132, 'LAURA', 'MORELIA', '2025-03-07 19:52:06', '13:52:06'),
(133, 'LAURA', 'MORELIA', '2025-03-07 19:53:28', '13:53:28'),
(134, 'PRUEBA 1', 'MORELIA', '2025-03-07 20:10:08', '14:10:08'),
(135, 'CAFE', 'MORELIA', '2025-03-07 21:24:04', '15:24:04'),
(136, 'HOLA', 'MORELIA', '2025-03-07 21:27:01', '15:27:01'),
(137, 'HJFSDHJSDF', 'MORELIA', '2025-03-07 21:28:44', '15:28:44'),
(138, 'LAURA', 'MORELIA', '2025-03-10 16:34:53', '10:34:53'),
(139, 'LAURA', 'MORELIA', '2025-03-10 16:38:51', '10:38:51'),
(140, 'LAURA', 'MORELIA', '2025-03-10 16:47:33', '10:47:33'),
(141, 'SDFSDF', 'ZAMORA', '2025-03-10 20:25:05', '14:25:05'),
(142, 'OFE', 'URUAPAN', '2025-03-10 21:50:51', '15:50:51'),
(143, 'VANESSA', 'ZAMORA', '2025-03-10 22:36:42', '16:36:42'),
(144, 'VICTORIA', 'MORELIA', '2025-03-10 22:38:48', '16:38:48'),
(145, 'VICTORIA', 'MORELIA', '2025-03-10 22:38:54', '16:38:54'),
(146, 'DANIELA', 'URUAPAN', '2025-03-10 22:41:40', '16:41:40'),
(147, 'SDFSDF', 'SDFSD', '2025-03-10 22:45:22', '16:45:22'),
(148, 'IRVIN SAMUEL', 'MORELIA', '2025-03-10 22:59:27', '16:59:27'),
(149, 'IRVIN SAMUEL BEDOLLA MOTA', 'MORELIA', '2025-03-27 03:16:53', '21:16:53'),
(150, 'IRVIN SAMUEL BEDOLLA MOTA', 'MORELIA', '2025-03-27 03:17:28', '21:17:28'),
(151, 'IRVIN SAMUEL BEDOLLA MOTA', 'MORELIA', '2025-03-27 04:00:09', '22:00:09'),
(152, 'IRVIN SAMUEL BEDOLLA MOTA', 'MORELIA', '2025-03-27 04:09:36', '22:09:36'),
(153, 'ANA', 'URIAPAN', '2025-04-28 09:23:06', '11:23:06'),
(154, 'ANA', 'URUAPAN', '2025-04-28 09:28:36', '11:28:36'),
(155, 'IRVIN SAMUEL BEDOLLA MOTA', 'MORELIA 2', '2025-04-28 09:30:00', '11:30:00'),
(156, 'IRVIN SAMUEL BEDOLLA MOTA', 'MORELIA 2', '2025-04-28 09:30:16', '11:30:16'),
(157, 'ANA', 'MORELIA', '2025-04-28 09:33:32', '11:33:32'),
(158, 'IRVIN SAMUEL BEDOLLA MOTA', 'URIAPAN', '2025-04-28 09:37:35', '11:37:35'),
(159, 'QWDDQW', 'MORELIA 2', '2025-04-28 09:39:55', '11:39:55'),
(160, 'QWDDQW', 'MORELIA 2', '2025-04-28 09:40:25', '11:40:25'),
(161, 'QWDDQW', 'MORELIA 2', '2025-04-28 09:41:59', '11:41:59'),
(162, 'QWDDQW', 'MORELIA 2', '2025-04-28 09:42:10', '11:42:10'),
(163, 'QWDDQW', 'MORELIA 2', '2025-04-28 09:43:52', '11:43:52'),
(164, 'QWDDQW', 'MORELIA 2', '2025-04-28 09:45:09', '11:45:09'),
(165, 'QWDDQW', 'MORELIA 2', '2025-04-28 09:46:51', '11:46:51'),
(166, 'QWDDQW', 'MORELIA 2', '2025-04-28 09:47:17', '11:47:17'),
(167, 'QWDDQW', 'MORELIA 2', '2025-04-28 09:47:32', '11:47:32'),
(168, '34 WTE4WT4', 'MORELIA', '2025-04-28 09:47:59', '11:47:59'),
(169, '34 WTE4WT4', 'MORELIA', '2025-04-28 09:48:25', '11:48:25'),
(170, 'ANA ROSA', 'MOR', '2025-04-28 09:50:53', '11:50:53');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chat_rp`
--

CREATE TABLE `chat_rp` (
  `id` int(11) NOT NULL,
  `id_registro` int(11) NOT NULL,
  `id_pregunta` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `chat_rp`
--

INSERT INTO `chat_rp` (`id`, `id_registro`, `id_pregunta`, `created_at`, `updated_at`) VALUES
(25, 130, 2, '2025-03-07 19:25:25', '2025-03-07 19:25:25'),
(26, 131, 4, '2025-03-07 19:33:04', '2025-03-07 19:33:04'),
(27, 132, 4, '2025-03-07 19:52:06', '2025-03-07 19:52:06'),
(28, 133, 4, '2025-03-07 19:53:28', '2025-03-07 19:53:28'),
(29, 133, 4, '2025-03-07 20:00:13', '2025-03-07 20:00:13'),
(30, 133, 4, '2025-03-07 20:01:18', '2025-03-07 20:01:18'),
(31, 133, 4, '2025-03-07 20:01:43', '2025-03-07 20:01:43'),
(32, 133, 4, '2025-03-07 20:02:22', '2025-03-07 20:02:22'),
(33, 133, 9, '2025-03-07 20:02:41', '2025-03-07 20:02:41'),
(34, 133, 5, '2025-03-07 20:03:00', '2025-03-07 20:03:00'),
(35, 133, 8, '2025-03-07 20:07:16', '2025-03-07 20:07:16'),
(36, 133, 8, '2025-03-07 20:08:06', '2025-03-07 20:08:06'),
(37, 133, 8, '2025-03-07 20:09:12', '2025-03-07 20:09:12'),
(38, 134, 1, '2025-03-07 20:10:08', '2025-03-07 20:10:08'),
(39, 134, 2, '2025-03-07 20:10:28', '2025-03-07 20:10:28'),
(40, 134, 5, '2025-03-07 20:10:47', '2025-03-07 20:10:47'),
(41, 134, 5, '2025-03-07 20:11:25', '2025-03-07 20:11:25'),
(42, 134, 5, '2025-03-07 20:25:26', '2025-03-07 20:25:26'),
(43, 134, 5, '2025-03-07 20:26:14', '2025-03-07 20:26:14'),
(44, 134, 5, '2025-03-07 20:29:17', '2025-03-07 20:29:17'),
(45, 134, 5, '2025-03-07 20:31:51', '2025-03-07 20:31:51'),
(46, 134, 5, '2025-03-07 20:33:11', '2025-03-07 20:33:11'),
(47, 134, 5, '2025-03-07 20:37:12', '2025-03-07 20:37:12'),
(48, 134, 5, '2025-03-07 20:38:22', '2025-03-07 20:38:22'),
(49, 134, 5, '2025-03-07 20:38:43', '2025-03-07 20:38:43'),
(50, 134, 5, '2025-03-07 20:39:19', '2025-03-07 20:39:19'),
(51, 134, 5, '2025-03-07 21:18:07', '2025-03-07 21:18:07'),
(52, 134, 5, '2025-03-07 21:21:10', '2025-03-07 21:21:10'),
(53, 134, 5, '2025-03-07 21:22:17', '2025-03-07 21:22:17'),
(54, 134, 5, '2025-03-07 21:22:55', '2025-03-07 21:22:55'),
(55, 135, 3, '2025-03-07 21:24:04', '2025-03-07 21:24:04'),
(56, 135, 3, '2025-03-07 21:24:24', '2025-03-07 21:24:24'),
(57, 135, 3, '2025-03-07 21:24:45', '2025-03-07 21:24:45'),
(58, 136, 5, '2025-03-07 21:27:01', '2025-03-07 21:27:01'),
(59, 136, 3, '2025-03-07 21:27:29', '2025-03-07 21:27:29'),
(60, 137, 2, '2025-03-07 21:28:44', '2025-03-07 21:28:44'),
(61, 137, 4, '2025-03-07 21:29:05', '2025-03-07 21:29:05'),
(62, 137, 4, '2025-03-07 21:30:05', '2025-03-07 21:30:05'),
(63, 137, 4, '2025-03-07 21:30:40', '2025-03-07 21:30:40'),
(64, 137, 4, '2025-03-07 21:31:38', '2025-03-07 21:31:38'),
(65, 138, 3, '2025-03-10 16:34:53', '2025-03-10 16:34:53'),
(66, 139, 3, '2025-03-10 16:38:51', '2025-03-10 16:38:51'),
(67, 140, 3, '2025-03-10 16:47:33', '2025-03-10 16:47:33'),
(68, 141, 2, '2025-03-10 20:25:05', '2025-03-10 20:25:05'),
(69, 142, 9, '2025-03-10 21:50:51', '2025-03-10 21:50:51'),
(70, 143, 10, '2025-03-10 22:36:42', '2025-03-10 22:36:42'),
(71, 144, 9, '2025-03-10 22:38:48', '2025-03-10 22:38:48'),
(72, 145, 9, '2025-03-10 22:38:54', '2025-03-10 22:38:54'),
(73, 145, 6, '2025-03-10 22:39:25', '2025-03-10 22:39:25'),
(74, 145, 3, '2025-03-10 22:40:00', '2025-03-10 22:40:00'),
(75, 146, 7, '2025-03-10 22:41:40', '2025-03-10 22:41:40'),
(76, 146, 7, '2025-03-10 22:42:06', '2025-03-10 22:42:06'),
(77, 146, 5, '2025-03-10 22:42:31', '2025-03-10 22:42:31'),
(78, 146, 4, '2025-03-10 22:42:57', '2025-03-10 22:42:57'),
(79, 147, 10, '2025-03-10 22:45:22', '2025-03-10 22:45:22'),
(80, 147, 6, '2025-03-10 22:46:06', '2025-03-10 22:46:06'),
(81, 148, 2, '2025-03-10 22:59:27', '2025-03-10 22:59:27'),
(82, 148, 7, '2025-03-10 22:59:33', '2025-03-10 22:59:33'),
(83, 148, 9, '2025-03-10 22:59:40', '2025-03-10 22:59:40'),
(84, 150, 3, '2025-03-27 03:17:28', '2025-03-27 03:17:28'),
(85, 151, 6, '2025-03-27 04:00:09', '2025-03-27 04:00:09'),
(86, 152, 3, '2025-03-27 04:09:36', '2025-03-27 04:09:36'),
(87, 152, 5, '2025-03-27 04:09:39', '2025-03-27 04:09:39'),
(88, 152, 7, '2025-03-27 04:09:41', '2025-03-27 04:09:41'),
(89, 153, 19, '2025-04-28 09:23:06', '2025-04-28 09:23:06'),
(90, 153, 8, '2025-04-28 09:24:02', '2025-04-28 09:24:02'),
(91, 153, 1, '2025-04-28 09:25:14', '2025-04-28 09:25:14'),
(92, 154, 1, '2025-04-28 09:28:36', '2025-04-28 09:28:36'),
(93, 154, 1, '2025-04-28 09:28:48', '2025-04-28 09:28:48'),
(94, 154, 15, '2025-04-28 09:28:53', '2025-04-28 09:28:53'),
(95, 156, 8, '2025-04-28 09:30:16', '2025-04-28 09:30:16'),
(96, 156, 1, '2025-04-28 09:30:50', '2025-04-28 09:30:50'),
(97, 157, 1, '2025-04-28 09:33:32', '2025-04-28 09:33:32'),
(98, 157, 14, '2025-04-28 09:33:35', '2025-04-28 09:33:35'),
(99, 157, 14, '2025-04-28 09:34:22', '2025-04-28 09:34:22'),
(100, 157, 14, '2025-04-28 09:35:37', '2025-04-28 09:35:37'),
(101, 158, 13, '2025-04-28 09:37:35', '2025-04-28 09:37:35'),
(102, 159, 13, '2025-04-28 09:39:55', '2025-04-28 09:39:55'),
(103, 160, 13, '2025-04-28 09:40:25', '2025-04-28 09:40:25'),
(104, 161, 13, '2025-04-28 09:41:59', '2025-04-28 09:41:59'),
(105, 162, 13, '2025-04-28 09:42:10', '2025-04-28 09:42:10'),
(106, 163, 13, '2025-04-28 09:43:52', '2025-04-28 09:43:52'),
(107, 164, 13, '2025-04-28 09:45:09', '2025-04-28 09:45:09'),
(108, 165, 13, '2025-04-28 09:46:51', '2025-04-28 09:46:51'),
(109, 166, 13, '2025-04-28 09:47:17', '2025-04-28 09:47:17'),
(110, 167, 13, '2025-04-28 09:47:32', '2025-04-28 09:47:32'),
(111, 167, 12, '2025-04-28 09:47:39', '2025-04-28 09:47:39'),
(112, 167, 5, '2025-04-28 09:47:42', '2025-04-28 09:47:42'),
(113, 167, 18, '2025-04-28 09:47:46', '2025-04-28 09:47:46'),
(114, 168, 14, '2025-04-28 09:47:59', '2025-04-28 09:47:59'),
(115, 169, 14, '2025-04-28 09:48:25', '2025-04-28 09:48:25'),
(116, 169, 1, '2025-04-28 09:48:30', '2025-04-28 09:48:30'),
(117, 169, 1, '2025-04-28 09:49:20', '2025-04-28 09:49:20'),
(118, 169, 1, '2025-04-28 09:49:50', '2025-04-28 09:49:50'),
(119, 169, 19, '2025-04-28 09:49:56', '2025-04-28 09:49:56'),
(120, 169, 13, '2025-04-28 09:50:09', '2025-04-28 09:50:09'),
(121, 169, 8, '2025-04-28 09:50:22', '2025-04-28 09:50:22'),
(122, 170, 3, '2025-04-28 09:50:53', '2025-04-28 09:50:53'),
(123, 170, 13, '2025-04-28 09:51:00', '2025-04-28 09:51:00'),
(124, 170, 18, '2025-04-28 09:51:04', '2025-04-28 09:51:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `concepto_pago`
--

CREATE TABLE `concepto_pago` (
  `id` int(11) NOT NULL,
  `id_solicitud` int(11) NOT NULL,
  `monto` float NOT NULL,
  `descripcion` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `concepto_pago`
--

INSERT INTO `concepto_pago` (`id`, `id_solicitud`, `monto`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 51, 5851, 'ASDADDSA', '2025-05-12 16:13:01', '2025-05-12 16:13:01'),
(2, 51, 2323, 'DWADWADAWDAW', '2025-05-12 16:16:58', '2025-05-12 16:16:58'),
(3, 53, 953, 'CFECFEC', '2025-05-12 20:48:32', '2025-05-12 20:48:32'),
(4, 53, 1458, 'XFECF', '2025-05-12 20:48:32', '2025-05-12 20:48:32'),
(5, 58, 234, 'Fisica', '2025-05-15 15:25:33', '2025-05-15 15:25:33'),
(6, 58, 2343, 'Moral', '2025-05-15 15:25:33', '2025-05-15 15:25:33'),
(7, 58, 234, 'Fisica', '2025-05-15 15:26:36', '2025-05-15 15:26:36'),
(8, 58, 2343, 'Moral', '2025-05-15 15:26:36', '2025-05-15 15:26:36'),
(9, 58, 432423, 'Fisica', '2025-05-15 17:17:35', '2025-05-15 17:17:35'),
(10, 58, 234234, 'Moral', '2025-05-15 17:17:35', '2025-05-15 17:17:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentacion_persona`
--

CREATE TABLE `documentacion_persona` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nombre` text DEFAULT NULL,
  `documento` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `documentacion_persona`
--

INSERT INTO `documentacion_persona` (`id`, `id_usuario`, `nombre`, `documento`, `updated_at`, `created_at`) VALUES
(29, 28, 'Ingenieria en computacion', '478877_3_0734_GAGJ781011S51_CIRCULAR SFA-DGGD-002-2025 A CIBERSEGURIDAD.pdf', '2025-03-14 17:32:58', '2025-03-14 17:32:58'),
(30, 3, 'Titulo', '478877_3_0734_GAGJ781011S51_CIRCULAR SFA-DGGD-002-2025 A CIBERSEGURIDAD.pdf', '2025-03-14 17:34:06', '2025-03-14 17:34:06'),
(31, 3, 'INE', 'RECIBO TERRENO LOTE 12 MANZANA D RINCONADA DEL SUR.pdf', '2025-03-14 17:49:48', '2025-03-14 17:49:48'),
(32, 7, 'INE', '62781f75-919d-48f1-a937-a1a00563a292.pdf', '2025-04-07 18:31:14', '2025-04-07 18:31:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `id` int(4) NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `pais` int(3) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`id`, `nombre`, `pais`) VALUES
(1, 'Aguascalientes', 1),
(2, 'Baja California', 1),
(3, 'Baja California Sur', 1),
(4, 'Campeche', 1),
(5, 'Chiapas', 1),
(6, 'Chihuahua', 1),
(7, 'Coahuila', 1),
(8, 'Colima', 1),
(9, 'Ciudad de México', 1),
(10, 'Durango', 1),
(11, 'Estado de México', 1),
(12, 'Guanajuato', 1),
(13, 'Guerrero', 1),
(14, 'Hidalgo', 1),
(15, 'Jalisco', 1),
(16, 'Michoacán', 1),
(17, 'Morelos', 1),
(18, 'Nayarit', 1),
(19, 'Nuevo León', 1),
(20, 'Oaxaca', 1),
(21, 'Puebla', 1),
(22, 'Querétaro', 1),
(23, 'Quintana Roo', 1),
(24, 'San Luis Potosí', 1),
(25, 'Sinaloa', 1),
(26, 'Sonora', 1),
(27, 'Tabasco', 1),
(28, 'Tamaulipas', 1),
(29, 'Tlaxcala', 1),
(30, 'Veracruz', 1),
(31, 'Yucatán', 1),
(32, 'Zacatecas', 1),
(1, 'Aguascalientes', 1),
(2, 'Baja California', 1),
(3, 'Baja California Sur', 1),
(4, 'Campeche', 1),
(5, 'Chiapas', 1),
(6, 'Chihuahua', 1),
(7, 'Coahuila', 1),
(8, 'Colima', 1),
(9, 'Ciudad de México', 1),
(10, 'Durango', 1),
(11, 'Estado de México', 1),
(12, 'Guanajuato', 1),
(13, 'Guerrero', 1),
(14, 'Hidalgo', 1),
(15, 'Jalisco', 1),
(16, 'Michoacán', 1),
(17, 'Morelos', 1),
(18, 'Nayarit', 1),
(19, 'Nuevo León', 1),
(20, 'Oaxaca', 1),
(21, 'Puebla', 1),
(22, 'Querétaro', 1),
(23, 'Quintana Roo', 1),
(24, 'San Luis Potosí', 1),
(25, 'Sinaloa', 1),
(26, 'Sonora', 1),
(27, 'Tabasco', 1),
(28, 'Tamaulipas', 1),
(29, 'Tlaxcala', 1),
(30, 'Veracruz', 1),
(31, 'Yucatán', 1),
(32, 'Zacatecas', 1),
(1, 'Aguascalientes', 1),
(2, 'Baja California', 1),
(3, 'Baja California Sur', 1),
(4, 'Campeche', 1),
(5, 'Chiapas', 1),
(6, 'Chihuahua', 1),
(7, 'Coahuila', 1),
(8, 'Colima', 1),
(9, 'Ciudad de México', 1),
(10, 'Durango', 1),
(11, 'Estado de México', 1),
(12, 'Guanajuato', 1),
(13, 'Guerrero', 1),
(14, 'Hidalgo', 1),
(15, 'Jalisco', 1),
(16, 'Michoacán', 1),
(17, 'Morelos', 1),
(18, 'Nayarit', 1),
(19, 'Nuevo León', 1),
(20, 'Oaxaca', 1),
(21, 'Puebla', 1),
(22, 'Querétaro', 1),
(23, 'Quintana Roo', 1),
(24, 'San Luis Potosí', 1),
(25, 'Sinaloa', 1),
(26, 'Sonora', 1),
(27, 'Tabasco', 1),
(28, 'Tamaulipas', 1),
(29, 'Tlaxcala', 1),
(30, 'Veracruz', 1),
(31, 'Yucatán', 1),
(32, 'Zacatecas', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_05_28_090500_add_login_fields_to_users_table', 1),
(6, '2023_06_12_013333_add_profile_photo_path_column_to_users_table', 1),
(7, '2023_10_09_041104_create_addresses_table', 1),
(8, '2024_07_01_100049_create_permission_tables', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(16, 'App\\Models\\User', 1),
(18, 'App\\Models\\User', 26),
(20, 'App\\Models\\User', 7),
(20, 'App\\Models\\User', 9),
(20, 'App\\Models\\User', 13),
(20, 'App\\Models\\User', 17),
(20, 'App\\Models\\User', 20),
(20, 'App\\Models\\User', 21),
(21, 'App\\Models\\User', 8),
(21, 'App\\Models\\User', 10),
(21, 'App\\Models\\User', 14),
(21, 'App\\Models\\User', 18),
(21, 'App\\Models\\User', 19),
(21, 'App\\Models\\User', 22),
(22, 'App\\Models\\User', 24),
(23, 'App\\Models\\User', 6),
(23, 'App\\Models\\User', 12),
(23, 'App\\Models\\User', 15),
(27, 'App\\Models\\User', 23),
(28, 'App\\Models\\User', 4),
(30, 'App\\Models\\User', 3),
(30, 'App\\Models\\User', 27),
(31, 'App\\Models\\User', 5),
(31, 'App\\Models\\User', 11),
(31, 'App\\Models\\User', 16),
(32, 'App\\Models\\User', 25),
(35, 'App\\Models\\User', 26),
(35, 'App\\Models\\User', 27),
(35, 'App\\Models\\User', 28),
(35, 'App\\Models\\User', 29),
(35, 'App\\Models\\User', 30),
(35, 'App\\Models\\User', 31),
(35, 'App\\Models\\User', 32),
(35, 'App\\Models\\User', 33),
(35, 'App\\Models\\User', 34),
(35, 'App\\Models\\User', 35),
(35, 'App\\Models\\User', 36),
(35, 'App\\Models\\User', 37),
(35, 'App\\Models\\User', 38),
(35, 'App\\Models\\User', 39),
(35, 'App\\Models\\User', 40),
(35, 'App\\Models\\User', 41);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipios`
--

CREATE TABLE `municipios` (
  `id` int(6) NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `estado` int(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `municipios`
--

INSERT INTO `municipios` (`id`, `nombre`, `estado`) VALUES
(1001, 'Aguascalientes', 1),
(1002, 'Asientos', 1),
(1003, 'Calvillo', 1),
(1004, 'Cosío', 1),
(1005, 'Jesús María', 1),
(1006, 'Pabellón de Arteaga', 1),
(1007, 'Rincón de Romos', 1),
(1008, 'San José de Gracia', 1),
(1009, 'Tepezalá', 1),
(1010, 'El Llano', 1),
(1011, 'San Francisco de los Romo', 1),
(2001, 'Ensenada', 2),
(2002, 'Mexicali', 2),
(2003, 'Tecate', 2),
(2004, 'Tijuana', 2),
(2005, 'Playas de Rosarito', 2),
(3001, 'Comondú', 3),
(3002, 'Mulegé', 3),
(3003, 'La Paz', 3),
(3008, 'Los Cabos', 3),
(3009, 'Loreto', 3),
(4001, 'Calkiní', 4),
(4002, 'Campeche', 4),
(4003, 'Carmen', 4),
(4004, 'Champotón', 4),
(4005, 'Hecelchakán', 4),
(4006, 'Hopelchén', 4),
(4007, 'Palizada', 4),
(4008, 'Tenabo', 4),
(4009, 'Escárcega', 4),
(4010, 'Calakmul', 4),
(4011, 'Candelaria', 4),
(5001, 'Abasolo', 5),
(5002, 'Acuña', 5),
(5003, 'Allende', 5),
(5004, 'Arteaga', 5),
(5005, 'Candela', 5),
(5006, 'Castaños', 5),
(5007, 'Cuatro Ciénegas', 5),
(5008, 'Escobedo', 5),
(5009, 'Francisco I. Madero', 5),
(5010, 'Frontera', 5),
(5011, 'General Cepeda', 5),
(5012, 'Guerrero', 5),
(5013, 'Hidalgo', 5),
(5014, 'Jiménez', 5),
(5015, 'Juárez', 5),
(5016, 'Lamadrid', 5),
(5017, 'Matamoros', 5),
(5018, 'Monclova', 5),
(5019, 'Morelos', 5),
(5020, 'Múzquiz', 5),
(5021, 'Nadadores', 5),
(5022, 'Nava', 5),
(5023, 'Ocampo', 5),
(5024, 'Parras', 5),
(5025, 'Piedras Negras', 5),
(5026, 'Progreso', 5),
(5027, 'Ramos Arizpe', 5),
(5028, 'Sabinas', 5),
(5029, 'Sacramento', 5),
(5030, 'Saltillo', 5),
(5031, 'San Buenaventura', 5),
(5032, 'San Juan de Sabinas', 5),
(5033, 'San Pedro', 5),
(5034, 'Sierra Mojada', 5),
(5035, 'Torreón', 5),
(5036, 'Viesca', 5),
(5037, 'Villa Unión', 5),
(5038, 'Zaragoza', 5),
(6001, 'Armería', 6),
(6002, 'Colima', 6),
(6003, 'Comala', 6),
(6004, 'Coquimatlán', 6),
(6005, 'Cuauhtémoc', 6),
(6006, 'Ixtlahuacán', 6),
(6007, 'Manzanillo', 6),
(6008, 'Minatitlán', 6),
(6009, 'Tecomán', 6),
(6010, 'Villa de Álvarez', 6),
(7001, 'Acacoyagua', 7),
(7002, 'Acala', 7),
(7003, 'Acapetahua', 7),
(7004, 'Altamirano', 7),
(7005, 'Amatán', 7),
(7006, 'Amatenango de la Frontera', 7),
(7007, 'Amatenango del Valle', 7),
(7008, 'Angel Albino Corzo', 7),
(7009, 'Arriaga', 7),
(7010, 'Bejucal de Ocampo', 7),
(7011, 'Bella Vista', 7),
(7012, 'Berriozábal', 7),
(7013, 'Bochil', 7),
(7014, 'El Bosque', 7),
(7015, 'Cacahoatán', 7),
(7016, 'Catazajá', 7),
(7017, 'Cintalapa', 7),
(7018, 'Coapilla', 7),
(7019, 'Comitán de Domínguez', 7),
(7020, 'La Concordia', 7),
(7021, 'Copainalá', 7),
(7022, 'Chalchihuitán', 7),
(7023, 'Chamula', 7),
(7024, 'Chanal', 7),
(7025, 'Chapultenango', 7),
(7026, 'Chenalhó', 7),
(7027, 'Chiapa de Corzo', 7),
(7028, 'Chiapilla', 7),
(7029, 'Chicoasén', 7),
(7030, 'Chicomuselo', 7),
(7031, 'Chilón', 7),
(7032, 'Escuintla', 7),
(7033, 'Francisco León', 7),
(7034, 'Frontera Comalapa', 7),
(7035, 'Frontera Hidalgo', 7),
(7036, 'La Grandeza', 7),
(7037, 'Huehuetán', 7),
(7038, 'Huixtán', 7),
(7039, 'Huitiupán', 7),
(7040, 'Huixtla', 7),
(7041, 'La Independencia', 7),
(7042, 'Ixhuatán', 7),
(7043, 'Ixtacomitán', 7),
(7044, 'Ixtapa', 7),
(7045, 'Ixtapangajoya', 7),
(7046, 'Jiquipilas', 7),
(7047, 'Jitotol', 7),
(7048, 'Juárez', 7),
(7049, 'Larráinzar', 7),
(7050, 'La Libertad', 7),
(7051, 'Mapastepec', 7),
(7052, 'Las Margaritas', 7),
(7053, 'Mazapa de Madero', 7),
(7054, 'Mazatán', 7),
(7055, 'Metapa', 7),
(7056, 'Mitontic', 7),
(7057, 'Motozintla', 7),
(7058, 'Nicolás Ruíz', 7),
(7059, 'Ocosingo', 7),
(7060, 'Ocotepec', 7),
(7061, 'Ocozocoautla de Espinosa', 7),
(7062, 'Ostuacán', 7),
(7063, 'Osumacinta', 7),
(7064, 'Oxchuc', 7),
(7065, 'Palenque', 7),
(7066, 'Pantelhó', 7),
(7067, 'Pantepec', 7),
(7068, 'Pichucalco', 7),
(7069, 'Pijijiapan', 7),
(7070, 'El Porvenir', 7),
(7071, 'Villa Comaltitlán', 7),
(7072, 'Pueblo Nuevo Solistahuacán', 7),
(7073, 'Rayón', 7),
(7074, 'Reforma', 7),
(7075, 'Las Rosas', 7),
(7076, 'Sabanilla', 7),
(7077, 'Salto de Agua', 7),
(7078, 'San Cristóbal de las Casas', 7),
(7079, 'San Fernando', 7),
(7080, 'Siltepec', 7),
(7081, 'Simojovel', 7),
(7082, 'Sitalá', 7),
(7083, 'Socoltenango', 7),
(7084, 'Solosuchiapa', 7),
(7085, 'Soyaló', 7),
(7086, 'Suchiapa', 7),
(7087, 'Suchiate', 7),
(7088, 'Sunuapa', 7),
(7089, 'Tapachula', 7),
(7090, 'Tapalapa', 7),
(7091, 'Tapilula', 7),
(7092, 'Tecpatán', 7),
(7093, 'Tenejapa', 7),
(7094, 'Teopisca', 7),
(7096, 'Tila', 7),
(7097, 'Tonalá', 7),
(7098, 'Totolapa', 7),
(7099, 'La Trinitaria', 7),
(7100, 'Tumbalá', 7),
(7101, 'Tuxtla Gutiérrez', 7),
(7102, 'Tuxtla Chico', 7),
(7103, 'Tuzantán', 7),
(7104, 'Tzimol', 7),
(7105, 'Unión Juárez', 7),
(7106, 'Venustiano Carranza', 7),
(7107, 'Villa Corzo', 7),
(7108, 'Villaflores', 7),
(7109, 'Yajalón', 7),
(7110, 'San Lucas', 7),
(7111, 'Zinacantán', 7),
(7112, 'San Juan Cancuc', 7),
(7113, 'Aldama', 7),
(7114, 'Benemérito de las Américas', 7),
(7115, 'Maravilla Tenejapa', 7),
(7116, 'Marqués de Comillas', 7),
(7117, 'Montecristo de Guerrero', 7),
(7118, 'San Andrés Duraznal', 7),
(7119, 'Santiago el Pinar', 7),
(7120, 'Capitán Luis Ángel Vidal', 7),
(7121, 'Rincón Chamula San Pedro', 7),
(7122, 'El Parral', 7),
(7123, 'Emiliano Zapata', 7),
(7124, 'Mezcalapa', 7),
(8001, 'Ahumada', 8),
(8002, 'Aldama', 8),
(8003, 'Allende', 8),
(8004, 'Aquiles Serdán', 8),
(8005, 'Ascensión', 8),
(8006, 'Bachíniva', 8),
(8007, 'Balleza', 8),
(8008, 'Batopilas de Manuel Gómez Morín', 8),
(8009, 'Bocoyna', 8),
(8010, 'Buenaventura', 8),
(8011, 'Camargo', 8),
(8012, 'Carichí', 8),
(8013, 'Casas Grandes', 8),
(8014, 'Coronado', 8),
(8015, 'Coyame del Sotol', 8),
(8016, 'La Cruz', 8),
(8017, 'Cuauhtémoc', 8),
(8018, 'Cusihuiriachi', 8),
(8019, 'Chihuahua', 8),
(8020, 'Chínipas', 8),
(8021, 'Delicias', 8),
(8022, 'Dr. Belisario Domínguez', 8),
(8023, 'Galeana', 8),
(8024, 'Santa Isabel', 8),
(8025, 'Gómez Farías', 8),
(8026, 'Gran Morelos', 8),
(8027, 'Guachochi', 8),
(8028, 'Guadalupe', 8),
(8029, 'Guadalupe y Calvo', 8),
(8030, 'Guazapares', 8),
(8031, 'Guerrero', 8),
(8032, 'Hidalgo del Parral', 8),
(8033, 'Huejotitán', 8),
(8034, 'Ignacio Zaragoza', 8),
(8035, 'Janos', 8),
(8036, 'Jiménez', 8),
(8037, 'Juárez', 8),
(8038, 'Julimes', 8),
(8039, 'López', 8),
(8040, 'Madera', 8),
(8041, 'Maguarichi', 8),
(8042, 'Manuel Benavides', 8),
(8043, 'Matachí', 8),
(8044, 'Matamoros', 8),
(8045, 'Meoqui', 8),
(8046, 'Morelos', 8),
(8047, 'Moris', 8),
(8048, 'Namiquipa', 8),
(8049, 'Nonoava', 8),
(8050, 'Nuevo Casas Grandes', 8),
(8051, 'Ocampo', 8),
(8052, 'Ojinaga', 8),
(8053, 'Praxedis G. Guerrero', 8),
(8054, 'Riva Palacio', 8),
(8055, 'Rosales', 8),
(8056, 'Rosario', 8),
(8057, 'San Francisco de Borja', 8),
(8058, 'San Francisco de Conchos', 8),
(8059, 'San Francisco del Oro', 8),
(8060, 'Santa Bárbara', 8),
(8061, 'Satevó', 8),
(8062, 'Saucillo', 8),
(8063, 'Temósachic', 8),
(8064, 'El Tule', 8),
(8065, 'Urique', 8),
(8066, 'Uruachi', 8),
(8067, 'Valle de Zaragoza', 8),
(9002, 'Azcapotzalco', 9),
(9003, 'Coyoacán', 9),
(9004, 'Cuajimalpa de Morelos', 9),
(9005, 'Gustavo A. Madero', 9),
(9006, 'Iztacalco', 9),
(9007, 'Iztapalapa', 9),
(9008, 'La Magdalena Contreras', 9),
(9009, 'Milpa Alta', 9),
(9010, 'Álvaro Obregón', 9),
(9011, 'Tláhuac', 9),
(9012, 'Tlalpan', 9),
(9013, 'Xochimilco', 9),
(9014, 'Benito Juárez', 9),
(9015, 'Cuauhtémoc', 9),
(9016, 'Miguel Hidalgo', 9),
(9017, 'Venustiano Carranza', 9),
(10001, 'Canatlán', 10),
(10002, 'Canelas', 10),
(10003, 'Coneto de Comonfort', 10),
(10004, 'Cuencamé', 10),
(10005, 'Durango', 10),
(10006, 'General Simón Bolívar', 10),
(10007, 'Gómez Palacio', 10),
(10008, 'Guadalupe Victoria', 10),
(10009, 'Guanaceví', 10),
(10010, 'Hidalgo', 10),
(10011, 'Indé', 10),
(10012, 'Lerdo', 10),
(10013, 'Mapimí', 10),
(10014, 'Mezquital', 10),
(10015, 'Nazas', 10),
(10016, 'Nombre de Dios', 10),
(10017, 'Ocampo', 10),
(10018, 'El Oro', 10),
(10019, 'Otáez', 10),
(10020, 'Pánuco de Coronado', 10),
(10021, 'Peñón Blanco', 10),
(10022, 'Poanas', 10),
(10023, 'Pueblo Nuevo', 10),
(10024, 'Rodeo', 10),
(10025, 'San Bernardo', 10),
(10026, 'San Dimas', 10),
(10027, 'San Juan de Guadalupe', 10),
(10028, 'San Juan del Río', 10),
(10029, 'San Luis del Cordero', 10),
(10030, 'San Pedro del Gallo', 10),
(10031, 'Santa Clara', 10),
(10032, 'Santiago Papasquiaro', 10),
(10033, 'Súchil', 10),
(10034, 'Tamazula', 10),
(10035, 'Tepehuanes', 10),
(10036, 'Tlahualilo', 10),
(10037, 'Topia', 10),
(10038, 'Vicente Guerrero', 10),
(10039, 'Nuevo Ideal', 10),
(11001, 'Abasolo', 11),
(11002, 'Acámbaro', 11),
(11003, 'San Miguel de Allende', 11),
(11004, 'Apaseo el Alto', 11),
(11005, 'Apaseo el Grande', 11),
(11006, 'Atarjea', 11),
(11007, 'Celaya', 11),
(11008, 'Manuel Doblado', 11),
(11009, 'Comonfort', 11),
(11010, 'Coroneo', 11),
(11011, 'Cortazar', 11),
(11012, 'Cuerámaro', 11),
(11013, 'Doctor Mora', 11),
(11014, 'Dolores Hidalgo Cuna de la Independencia Nacional', 11),
(11015, 'Guanajuato', 11),
(11016, 'Huanímaro', 11),
(11017, 'Irapuato', 11),
(11018, 'Jaral del Progreso', 11),
(11019, 'Jerécuaro', 11),
(11020, 'León', 11),
(11021, 'Moroleón', 11),
(11022, 'Ocampo', 11),
(11023, 'Pénjamo', 11),
(11024, 'Pueblo Nuevo', 11),
(11025, 'Purísima del Rincón', 11),
(11026, 'Romita', 11),
(11027, 'Salamanca', 11),
(11028, 'Salvatierra', 11),
(11029, 'San Diego de la Unión', 11),
(11030, 'San Felipe', 11),
(11031, 'San Francisco del Rincón', 11),
(11032, 'San José Iturbide', 11),
(11033, 'San Luis de la Paz', 11),
(11034, 'Santa Catarina', 11),
(11035, 'Santa Cruz de Juventino Rosas', 11),
(11036, 'Santiago Maravatío', 11),
(11037, 'Silao de la Victoria', 11),
(11038, 'Tarandacuao', 11),
(11039, 'Tarimoro', 11),
(11040, 'Tierra Blanca', 11),
(11041, 'Uriangato', 11),
(11042, 'Valle de Santiago', 11),
(11043, 'Victoria', 11),
(11044, 'Villagrán', 11),
(11045, 'Xichú', 11),
(11046, 'Yuriria', 11),
(12001, 'Acapulco de Juárez', 12),
(12002, 'Ahuacuotzingo', 12),
(12003, 'Ajuchitlán del Progreso', 12),
(12004, 'Alcozauca de Guerrero', 12),
(12005, 'Alpoyeca', 12),
(12006, 'Apaxtla', 12),
(12007, 'Arcelia', 12),
(12008, 'Atenango del Río', 12),
(12009, 'Atlamajalcingo del Monte', 12),
(12010, 'Atlixtac', 12),
(12011, 'Atoyac de Álvarez', 12),
(12012, 'Ayutla de los Libres', 12),
(12013, 'Azoyú', 12),
(12014, 'Benito Juárez', 12),
(12015, 'Buenavista de Cuéllar', 12),
(12016, 'Coahuayutla de José María Izazaga', 12),
(12017, 'Cocula', 12),
(12018, 'Copala', 12),
(12019, 'Copalillo', 12),
(12020, 'Copanatoyac', 12),
(12021, 'Coyuca de Benítez', 12),
(12022, 'Coyuca de Catalán', 12),
(12023, 'Cuajinicuilapa', 12),
(12024, 'Cualác', 12),
(12025, 'Cuautepec', 12),
(12026, 'Cuetzala del Progreso', 12),
(12027, 'Cutzamala de Pinzón', 12),
(12028, 'Chilapa de Álvarez', 12),
(12029, 'Chilpancingo de los Bravo', 12),
(12030, 'Florencio Villarreal', 12),
(12031, 'General Canuto A. Neri', 12),
(12032, 'General Heliodoro Castillo', 12),
(12033, 'Huamuxtitlán', 12),
(12034, 'Huitzuco de los Figueroa', 12),
(12035, 'Iguala de la Independencia', 12),
(12036, 'Igualapa', 12),
(12037, 'Ixcateopan de Cuauhtémoc', 12),
(12038, 'Zihuatanejo de Azueta', 12),
(12039, 'Juan R. Escudero', 12),
(12040, 'Leonardo Bravo', 12),
(12041, 'Malinaltepec', 12),
(12042, 'Mártir de Cuilapan', 12),
(12043, 'Metlatónoc', 12),
(12044, 'Mochitlán', 12),
(12045, 'Olinalá', 12),
(12046, 'Ometepec', 12),
(12047, 'Pedro Ascencio Alquisiras', 12),
(12048, 'Petatlán', 12),
(12049, 'Pilcaya', 12),
(12050, 'Pungarabato', 12),
(12051, 'Quechultenango', 12),
(12052, 'San Luis Acatlán', 12),
(12053, 'San Marcos', 12),
(12054, 'San Miguel Totolapan', 12),
(12055, 'Taxco de Alarcón', 12),
(12056, 'Tecoanapa', 12),
(12057, 'Técpan de Galeana', 12),
(12058, 'Teloloapan', 12),
(12059, 'Tepecoacuilco de Trujano', 12),
(12060, 'Tetipac', 12),
(12061, 'Tixtla de Guerrero', 12),
(12062, 'Tlacoachistlahuaca', 12),
(12063, 'Tlacoapa', 12),
(12064, 'Tlalchapa', 12),
(12065, 'Tlalixtaquilla de Maldonado', 12),
(12066, 'Tlapa de Comonfort', 12),
(12067, 'Tlapehuala', 12),
(12068, 'La Unión de Isidoro Montes de Oca', 12),
(12069, 'Xalpatláhuac', 12),
(12070, 'Xochihuehuetlán', 12),
(12071, 'Xochistlahuaca', 12),
(12072, 'Zapotitlán Tablas', 12),
(12073, 'Zirándaro', 12),
(12074, 'Zitlala', 12),
(12075, 'Eduardo Neri', 12),
(12076, 'Acatepec', 12),
(12077, 'Marquelia', 12),
(12078, 'Cochoapa el Grande', 12),
(12079, 'José Joaquín de Herrera', 12),
(12080, 'Juchitán', 12),
(12081, 'Iliatenco', 12),
(13001, 'Acatlán', 13),
(13002, 'Acaxochitlán', 13),
(13003, 'Actopan', 13),
(13004, 'Agua Blanca de Iturbide', 13),
(13005, 'Ajacuba', 13),
(13006, 'Alfajayucan', 13),
(13007, 'Almoloya', 13),
(13008, 'Apan', 13),
(13009, 'El Arenal', 13),
(13010, 'Atitalaquia', 13),
(13011, 'Atlapexco', 13),
(13012, 'Atotonilco el Grande', 13),
(13013, 'Atotonilco de Tula', 13),
(13014, 'Calnali', 13),
(13015, 'Cardonal', 13),
(13016, 'Cuautepec de Hinojosa', 13),
(13017, 'Chapantongo', 13),
(13018, 'Chapulhuacán', 13),
(13019, 'Chilcuautla', 13),
(13020, 'Eloxochitlán', 13),
(13021, 'Emiliano Zapata', 13),
(13022, 'Epazoyucan', 13),
(13023, 'Francisco I. Madero', 13),
(13024, 'Huasca de Ocampo', 13),
(13025, 'Huautla', 13),
(13026, 'Huazalingo', 13),
(13027, 'Huehuetla', 13),
(13028, 'Huejutla de Reyes', 13),
(13029, 'Huichapan', 13),
(13030, 'Ixmiquilpan', 13),
(13031, 'Jacala de Ledezma', 13),
(13032, 'Jaltocán', 13),
(13033, 'Juárez Hidalgo', 13),
(13034, 'Lolotla', 13),
(13035, 'Metepec', 13),
(13036, 'San Agustín Metzquititlán', 13),
(13037, 'Metztitlán', 13),
(13038, 'Mineral del Chico', 13),
(13039, 'Mineral del Monte', 13),
(13040, 'La Misión', 13),
(13041, 'Mixquiahuala de Juárez', 13),
(13042, 'Molango de Escamilla', 13),
(13043, 'Nicolás Flores', 13),
(13044, 'Nopala de Villagrán', 13),
(13045, 'Omitlán de Juárez', 13),
(13046, 'San Felipe Orizatlán', 13),
(13047, 'Pacula', 13),
(13048, 'Pachuca de Soto', 13),
(13049, 'Pisaflores', 13),
(13050, 'Progreso de Obregón', 13),
(13051, 'Mineral de la Reforma', 13),
(13052, 'San Agustín Tlaxiaca', 13),
(13053, 'San Bartolo Tutotepec', 13),
(13054, 'San Salvador', 13),
(13055, 'Santiago de Anaya', 13),
(13056, 'Santiago Tulantepec de Lugo Guerrero', 13),
(13057, 'Singuilucan', 13),
(13058, 'Tasquillo', 13),
(13059, 'Tecozautla', 13),
(13060, 'Tenango de Doria', 13),
(13061, 'Tepeapulco', 13),
(13062, 'Tepehuacán de Guerrero', 13),
(13063, 'Tepeji del Río de Ocampo', 13),
(13064, 'Tepetitlán', 13),
(13065, 'Tetepango', 13),
(13066, 'Villa de Tezontepec', 13),
(13067, 'Tezontepec de Aldama', 13),
(13068, 'Tianguistengo', 13),
(13069, 'Tizayuca', 13),
(13070, 'Tlahuelilpan', 13),
(13071, 'Tlahuiltepa', 13),
(13072, 'Tlanalapa', 13),
(13073, 'Tlanchinol', 13),
(13074, 'Tlaxcoapan', 13),
(13075, 'Tolcayuca', 13),
(13076, 'Tula de Allende', 13),
(13077, 'Tulancingo de Bravo', 13),
(13078, 'Xochiatipan', 13),
(13079, 'Xochicoatlán', 13),
(13080, 'Yahualica', 13),
(13081, 'Zacualtipán de Ángeles', 13),
(13082, 'Zapotlán de Juárez', 13),
(13083, 'Zempoala', 13),
(13084, 'Zimapán', 13),
(14001, 'Acatic', 14),
(14002, 'Acatlán de Juárez', 14),
(14003, 'Ahualulco de Mercado', 14),
(14004, 'Amacueca', 14),
(14005, 'Amatitán', 14),
(14006, 'Ameca', 14),
(14007, 'San Juanito de Escobedo', 14),
(14008, 'Arandas', 14),
(14009, 'El Arenal', 14),
(14010, 'Atemajac de Brizuela', 14),
(14011, 'Atengo', 14),
(14012, 'Atenguillo', 14),
(14013, 'Atotonilco el Alto', 14),
(14014, 'Atoyac', 14),
(14015, 'Autlán de Navarro', 14),
(14016, 'Ayotlán', 14),
(14017, 'Ayutla', 14),
(14018, 'La Barca', 14),
(14019, 'Bolaños', 14),
(14020, 'Cabo Corrientes', 14),
(14021, 'Casimiro Castillo', 14),
(14022, 'Cihuatlán', 14),
(14023, 'Zapotlán el Grande', 14),
(14024, 'Cocula', 14),
(14025, 'Colotlán', 14),
(14026, 'Concepción de Buenos Aires', 14),
(14027, 'Cuautitlán de García Barragán', 14),
(14028, 'Cuautla', 14),
(14029, 'Cuquío', 14),
(14030, 'Chapala', 14),
(14031, 'Chimaltitán', 14),
(14032, 'Chiquilistlán', 14),
(14033, 'Degollado', 14),
(14034, 'Ejutla', 14),
(14035, 'Encarnación de Díaz', 14),
(14036, 'Etzatlán', 14),
(14037, 'El Grullo', 14),
(14038, 'Guachinango', 14),
(14039, 'Guadalajara', 14),
(14040, 'Hostotipaquillo', 14),
(14041, 'Huejúcar', 14),
(14042, 'Huejuquilla el Alto', 14),
(14043, 'La Huerta', 14),
(14044, 'Ixtlahuacán de los Membrillos', 14),
(14045, 'Ixtlahuacán del Río', 14),
(14046, 'Jalostotitlán', 14),
(14047, 'Jamay', 14),
(14048, 'Jesús María', 14),
(14049, 'Jilotlán de los Dolores', 14),
(14050, 'Jocotepec', 14),
(14051, 'Juanacatlán', 14),
(14052, 'Juchitlán', 14),
(14053, 'Lagos de Moreno', 14),
(14054, 'El Limón', 14),
(14055, 'Magdalena', 14),
(14056, 'Santa María del Oro', 14),
(14057, 'La Manzanilla de la Paz', 14),
(14058, 'Mascota', 14),
(14059, 'Mazamitla', 14),
(14060, 'Mexticacán', 14),
(14061, 'Mezquitic', 14),
(14062, 'Mixtlán', 14),
(14063, 'Ocotlán', 14),
(14064, 'Ojuelos de Jalisco', 14),
(14065, 'Pihuamo', 14),
(14066, 'Poncitlán', 14),
(14067, 'Puerto Vallarta', 14),
(14068, 'Villa Purificación', 14),
(14069, 'Quitupan', 14),
(14070, 'El Salto', 14),
(14071, 'San Cristóbal de la Barranca', 14),
(14072, 'San Diego de Alejandría', 14),
(14073, 'San Juan de los Lagos', 14),
(14074, 'San Julián', 14),
(14075, 'San Marcos', 14),
(14076, 'San Martín de Bolaños', 14),
(14077, 'San Martín Hidalgo', 14),
(14078, 'San Miguel el Alto', 14),
(14079, 'Gómez Farías', 14),
(14080, 'San Sebastián del Oeste', 14),
(14081, 'Santa María de los Ángeles', 14),
(14082, 'Sayula', 14),
(14083, 'Tala', 14),
(14084, 'Talpa de Allende', 14),
(14085, 'Tamazula de Gordiano', 14),
(14086, 'Tapalpa', 14),
(14087, 'Tecalitlán', 14),
(14088, 'Tecolotlán', 14),
(14089, 'Techaluta de Montenegro', 14),
(14090, 'Tenamaxtlán', 14),
(14091, 'Teocaltiche', 14),
(14092, 'Teocuitatlán de Corona', 14),
(14093, 'Tepatitlán de Morelos', 14),
(14094, 'Tequila', 14),
(14095, 'Teuchitlán', 14),
(14096, 'Tizapán el Alto', 14),
(14097, 'Tlajomulco de Zúñiga', 14),
(14098, 'San Pedro Tlaquepaque', 14),
(14099, 'Tolimán', 14),
(14100, 'Tomatlán', 14),
(14101, 'Tonalá', 14),
(14102, 'Tonaya', 14),
(14103, 'Tonila', 14),
(14104, 'Totatiche', 14),
(14105, 'Tototlán', 14),
(14106, 'Tuxcacuesco', 14),
(14107, 'Tuxcueca', 14),
(14108, 'Tuxpan', 14),
(14109, 'Unión de San Antonio', 14),
(14110, 'Unión de Tula', 14),
(14111, 'Valle de Guadalupe', 14),
(14112, 'Valle de Juárez', 14),
(14113, 'San Gabriel', 14),
(14114, 'Villa Corona', 14),
(14115, 'Villa Guerrero', 14),
(14116, 'Villa Hidalgo', 14),
(14117, 'Cañadas de Obregón', 14),
(14118, 'Yahualica de González Gallo', 14),
(14119, 'Zacoalco de Torres', 14),
(14120, 'Zapopan', 14),
(14121, 'Zapotiltic', 14),
(14122, 'Zapotitlán de Vadillo', 14),
(14123, 'Zapotlán del Rey', 14),
(14124, 'Zapotlanejo', 14),
(14125, 'San Ignacio Cerro Gordo', 14),
(15001, 'Acambay de Ruíz Castañeda', 15),
(15002, 'Acolman', 15),
(15003, 'Aculco', 15),
(15004, 'Almoloya de Alquisiras', 15),
(15005, 'Almoloya de Juárez', 15),
(15006, 'Almoloya del Río', 15),
(15007, 'Amanalco', 15),
(15008, 'Amatepec', 15),
(15009, 'Amecameca', 15),
(15010, 'Apaxco', 15),
(15011, 'Atenco', 15),
(15012, 'Atizapán', 15),
(15013, 'Atizapán de Zaragoza', 15),
(15014, 'Atlacomulco', 15),
(15015, 'Atlautla', 15),
(15016, 'Axapusco', 15),
(15017, 'Ayapango', 15),
(15018, 'Calimaya', 15),
(15019, 'Capulhuac', 15),
(15020, 'Coacalco de Berriozábal', 15),
(15021, 'Coatepec Harinas', 15),
(15022, 'Cocotitlán', 15),
(15023, 'Coyotepec', 15),
(15024, 'Cuautitlán', 15),
(15025, 'Chalco', 15),
(15026, 'Chapa de Mota', 15),
(15027, 'Chapultepec', 15),
(15028, 'Chiautla', 15),
(15029, 'Chicoloapan', 15),
(15030, 'Chiconcuac', 15),
(15031, 'Chimalhuacán', 15),
(15032, 'Donato Guerra', 15),
(15033, 'Ecatepec de Morelos', 15),
(15034, 'Ecatzingo', 15),
(15035, 'Huehuetoca', 15),
(15036, 'Hueypoxtla', 15),
(15037, 'Huixquilucan', 15),
(15038, 'Isidro Fabela', 15),
(15039, 'Ixtapaluca', 15),
(15040, 'Ixtapan de la Sal', 15),
(15041, 'Ixtapan del Oro', 15),
(15042, 'Ixtlahuaca', 15),
(15043, 'Xalatlaco', 15),
(15044, 'Jaltenco', 15),
(15045, 'Jilotepec', 15),
(15046, 'Jilotzingo', 15),
(15047, 'Jiquipilco', 15),
(15048, 'Jocotitlán', 15),
(15049, 'Joquicingo', 15),
(15050, 'Juchitepec', 15),
(15051, 'Lerma', 15),
(15052, 'Malinalco', 15),
(15053, 'Melchor Ocampo', 15),
(15054, 'Metepec', 15),
(15055, 'Mexicaltzingo', 15),
(15056, 'Morelos', 15),
(15057, 'Naucalpan de Juárez', 15),
(15058, 'Nezahualcóyotl', 15),
(15059, 'Nextlalpan', 15),
(15060, 'Nicolás Romero', 15),
(15061, 'Nopaltepec', 15),
(15062, 'Ocoyoacac', 15),
(15063, 'Ocuilan', 15),
(15064, 'El Oro', 15),
(15065, 'Otumba', 15),
(15066, 'Otzoloapan', 15),
(15067, 'Otzolotepec', 15),
(15068, 'Ozumba', 15),
(15069, 'Papalotla', 15),
(15070, 'La Paz', 15),
(15071, 'Polotitlán', 15),
(15072, 'Rayón', 15),
(15073, 'San Antonio la Isla', 15),
(15074, 'San Felipe del Progreso', 15),
(15075, 'San Martín de las Pirámides', 15),
(15076, 'San Mateo Atenco', 15),
(15077, 'San Simón de Guerrero', 15),
(15078, 'Santo Tomás', 15),
(15079, 'Soyaniquilpan de Juárez', 15),
(15080, 'Sultepec', 15),
(15081, 'Tecámac', 15),
(15082, 'Tejupilco', 15),
(15083, 'Temamatla', 15),
(15084, 'Temascalapa', 15),
(15085, 'Temascalcingo', 15),
(15086, 'Temascaltepec', 15),
(15087, 'Temoaya', 15),
(15088, 'Tenancingo', 15),
(15089, 'Tenango del Aire', 15),
(15090, 'Tenango del Valle', 15),
(15091, 'Teoloyucan', 15),
(15092, 'Teotihuacán', 15),
(15093, 'Tepetlaoxtoc', 15),
(15094, 'Tepetlixpa', 15),
(15095, 'Tepotzotlán', 15),
(15096, 'Tequixquiac', 15),
(15097, 'Texcaltitlán', 15),
(15098, 'Texcalyacac', 15),
(15099, 'Texcoco', 15),
(15100, 'Tezoyuca', 15),
(15101, 'Tianguistenco', 15),
(15102, 'Timilpan', 15),
(15103, 'Tlalmanalco', 15),
(15104, 'Tlalnepantla de Baz', 15),
(15105, 'Tlatlaya', 15),
(15106, 'Toluca', 15),
(15107, 'Tonatico', 15),
(15108, 'Tultepec', 15),
(15109, 'Tultitlán', 15),
(15110, 'Valle de Bravo', 15),
(15111, 'Villa de Allende', 15),
(15112, 'Villa del Carbón', 15),
(15113, 'Villa Guerrero', 15),
(15114, 'Villa Victoria', 15),
(15115, 'Xonacatlán', 15),
(15116, 'Zacazonapan', 15),
(15117, 'Zacualpan', 15),
(15118, 'Zinacantepec', 15),
(15119, 'Zumpahuacán', 15),
(15120, 'Zumpango', 15),
(15121, 'Cuautitlán Izcalli', 15),
(15122, 'Valle de Chalco Solidaridad', 15),
(15123, 'Luvianos', 15),
(15124, 'San José del Rincón', 15),
(15125, 'Tonanitla', 15),
(16001, 'Acuitzio', 16),
(16002, 'Aguililla', 16),
(16003, 'Álvaro Obregón', 16),
(16004, 'Angamacutiro', 16),
(16005, 'Angangueo', 16),
(16006, 'Apatzingán', 16),
(16007, 'Aporo', 16),
(16008, 'Aquila', 16),
(16009, 'Ario', 16),
(16010, 'Arteaga', 16),
(16011, 'Briseñas', 16),
(16012, 'Buenavista', 16),
(16013, 'Carácuaro', 16),
(16014, 'Coahuayana', 16),
(16015, 'Coalcomán de Vázquez Pallares', 16),
(16016, 'Coeneo', 16),
(16017, 'Contepec', 16),
(16018, 'Copándaro', 16),
(16019, 'Cotija', 16),
(16020, 'Cuitzeo', 16),
(16021, 'Charapan', 16),
(16022, 'Charo', 16),
(16023, 'Chavinda', 16),
(16024, 'Cherán', 16),
(16025, 'Chilchota', 16),
(16026, 'Chinicuila', 16),
(16027, 'Chucándiro', 16),
(16028, 'Churintzio', 16),
(16029, 'Churumuco', 16),
(16030, 'Ecuandureo', 16),
(16031, 'Epitacio Huerta', 16),
(16032, 'Erongarícuaro', 16),
(16033, 'Gabriel Zamora', 16),
(16034, 'Hidalgo', 16),
(16035, 'La Huacana', 16),
(16036, 'Huandacareo', 16),
(16037, 'Huaniqueo', 16),
(16038, 'Huetamo', 16),
(16039, 'Huiramba', 16),
(16040, 'Indaparapeo', 16),
(16041, 'Irimbo', 16),
(16042, 'Ixtlán', 16),
(16043, 'Jacona', 16),
(16044, 'Jiménez', 16),
(16045, 'Jiquilpan', 16),
(16046, 'Juárez', 16),
(16047, 'Jungapeo', 16),
(16048, 'Lagunillas', 16),
(16049, 'Madero', 16),
(16050, 'Maravatío', 16),
(16051, 'Marcos Castellanos', 16),
(16052, 'Lázaro Cárdenas', 16),
(16053, 'Morelia', 16),
(16054, 'Morelos', 16),
(16055, 'Múgica', 16),
(16056, 'Nahuatzen', 16),
(16057, 'Nocupétaro', 16),
(16058, 'Nuevo Parangaricutiro', 16),
(16059, 'Nuevo Urecho', 16),
(16060, 'Numarán', 16),
(16061, 'Ocampo', 16),
(16062, 'Pajacuarán', 16),
(16063, 'Panindícuaro', 16),
(16064, 'Parácuaro', 16),
(16065, 'Paracho', 16),
(16066, 'Pátzcuaro', 16),
(16067, 'Penjamillo', 16),
(16068, 'Peribán', 16),
(16069, 'La Piedad', 16),
(16070, 'Purépero', 16),
(16071, 'Puruándiro', 16),
(16072, 'Queréndaro', 16),
(16073, 'Quiroga', 16),
(16074, 'Cojumatlán de Régules', 16),
(16075, 'Los Reyes', 16),
(16076, 'Sahuayo', 16),
(16077, 'San Lucas', 16),
(16078, 'Santa Ana Maya', 16),
(16079, 'Salvador Escalante', 16),
(16080, 'Senguio', 16),
(16081, 'Susupuato', 16),
(16082, 'Tacámbaro', 16),
(16083, 'Tancítaro', 16),
(16084, 'Tangamandapio', 16),
(16085, 'Tangancícuaro', 16),
(16086, 'Tanhuato', 16),
(16087, 'Taretan', 16),
(16088, 'Tarímbaro', 16),
(16089, 'Tepalcatepec', 16),
(16090, 'Tingambato', 16),
(16091, 'Tingüindín', 16),
(16092, 'Tiquicheo de Nicolás Romero', 16),
(16093, 'Tlalpujahua', 16),
(16094, 'Tlazazalca', 16),
(16095, 'Tocumbo', 16),
(16096, 'Tumbiscatío', 16),
(16097, 'Turicato', 16),
(16098, 'Tuxpan', 16),
(16099, 'Tuzantla', 16),
(16100, 'Tzintzuntzan', 16),
(16101, 'Tzitzio', 16),
(16102, 'Uruapan', 16),
(16103, 'Venustiano Carranza', 16),
(16104, 'Villamar', 16),
(16105, 'Vista Hermosa', 16),
(16106, 'Yurécuaro', 16),
(16107, 'Zacapu', 16),
(16108, 'Zamora', 16),
(16109, 'Zináparo', 16),
(16110, 'Zinapécuaro', 16),
(16111, 'Ziracuaretiro', 16),
(16112, 'Zitácuaro', 16),
(16113, 'José Sixto Verduzco', 16),
(17001, 'Amacuzac', 17),
(17002, 'Atlatlahucan', 17),
(17003, 'Axochiapan', 17),
(17004, 'Ayala', 17),
(17005, 'Coatlán del Río', 17),
(17006, 'Cuautla', 17),
(17007, 'Cuernavaca', 17),
(17008, 'Emiliano Zapata', 17),
(17009, 'Huitzilac', 17),
(17010, 'Jantetelco', 17),
(17011, 'Jiutepec', 17),
(17012, 'Jojutla', 17),
(17013, 'Jonacatepec de Leandro Valle', 17),
(17014, 'Mazatepec', 17),
(17015, 'Miacatlán', 17),
(17016, 'Ocuituco', 17),
(17017, 'Puente de Ixtla', 17),
(17018, 'Temixco', 17),
(17019, 'Tepalcingo', 17),
(17020, 'Tepoztlán', 17),
(17021, 'Tetecala', 17),
(17022, 'Tetela del Volcán', 17),
(17023, 'Tlalnepantla', 17),
(17024, 'Tlaltizapán de Zapata', 17),
(17025, 'Tlaquiltenango', 17),
(17026, 'Tlayacapan', 17),
(17027, 'Totolapan', 17),
(17028, 'Xochitepec', 17),
(17029, 'Yautepec', 17),
(17030, 'Yecapixtla', 17),
(17031, 'Zacatepec', 17),
(17032, 'Zacualpan de Amilpas', 17),
(17033, 'Temoac', 17),
(17034, 'Coatetelco', 17),
(17035, 'Xoxocotla', 17),
(18001, 'Acaponeta', 18),
(18002, 'Ahuacatlán', 18),
(18003, 'Amatlán de Cañas', 18),
(18004, 'Compostela', 18),
(18005, 'Huajicori', 18),
(18006, 'Ixtlán del Río', 18),
(18007, 'Jala', 18),
(18008, 'Xalisco', 18),
(18009, 'Del Nayar', 18),
(18010, 'Rosamorada', 18),
(18011, 'Ruíz', 18),
(18012, 'San Blas', 18),
(18013, 'San Pedro Lagunillas', 18),
(18014, 'Santa María del Oro', 18),
(18015, 'Santiago Ixcuintla', 18),
(18016, 'Tecuala', 18),
(18017, 'Tepic', 18),
(18018, 'Tuxpan', 18),
(18019, 'La Yesca', 18),
(18020, 'Bahía de Banderas', 18),
(19001, 'Abasolo', 19),
(19002, 'Agualeguas', 19),
(19003, 'Los Aldamas', 19),
(19004, 'Allende', 19),
(19005, 'Anáhuac', 19),
(19006, 'Apodaca', 19),
(19007, 'Aramberri', 19),
(19008, 'Bustamante', 19),
(19009, 'Cadereyta Jiménez', 19),
(19010, 'El Carmen', 19),
(19011, 'Cerralvo', 19),
(19012, 'Ciénega de Flores', 19),
(19013, 'China', 19),
(19014, 'Doctor Arroyo', 19),
(19015, 'Doctor Coss', 19),
(19016, 'Doctor González', 19),
(19017, 'Galeana', 19),
(19018, 'García', 19),
(19019, 'San Pedro Garza García', 19),
(19020, 'General Bravo', 19),
(19021, 'General Escobedo', 19),
(19022, 'General Terán', 19),
(19023, 'General Treviño', 19),
(19024, 'General Zaragoza', 19),
(19025, 'General Zuazua', 19),
(19026, 'Guadalupe', 19),
(19027, 'Los Herreras', 19),
(19028, 'Higueras', 19),
(19029, 'Hualahuises', 19),
(19030, 'Iturbide', 19),
(19031, 'Juárez', 19),
(19032, 'Lampazos de Naranjo', 19),
(19033, 'Linares', 19),
(19034, 'Marín', 19),
(19035, 'Melchor Ocampo', 19),
(19036, 'Mier y Noriega', 19),
(19037, 'Mina', 19),
(19038, 'Montemorelos', 19),
(19039, 'Monterrey', 19),
(19040, 'Parás', 19),
(19041, 'Pesquería', 19),
(19042, 'Los Ramones', 19),
(19043, 'Rayones', 19),
(19044, 'Sabinas Hidalgo', 19),
(19045, 'Salinas Victoria', 19),
(19046, 'San Nicolás de los Garza', 19),
(19047, 'Hidalgo', 19),
(19048, 'Santa Catarina', 19),
(19049, 'Santiago', 19),
(19050, 'Vallecillo', 19),
(19051, 'Villaldama', 19),
(20001, 'Abejones', 20),
(20002, 'Acatlán de Pérez Figueroa', 20),
(20003, 'Asunción Cacalotepec', 20),
(20004, 'Asunción Cuyotepeji', 20),
(20005, 'Asunción Ixtaltepec', 20),
(20006, 'Asunción Nochixtlán', 20),
(20007, 'Asunción Ocotlán', 20),
(20008, 'Asunción Tlacolulita', 20),
(20009, 'Ayotzintepec', 20),
(20010, 'El Barrio de la Soledad', 20),
(20011, 'Calihualá', 20),
(20012, 'Candelaria Loxicha', 20),
(20013, 'Ciénega de Zimatlán', 20),
(20014, 'Ciudad Ixtepec', 20),
(20015, 'Coatecas Altas', 20),
(20016, 'Coicoyán de las Flores', 20),
(20017, 'La Compañía', 20),
(20018, 'Concepción Buenavista', 20),
(20019, 'Concepción Pápalo', 20),
(20020, 'Constancia del Rosario', 20),
(20021, 'Cosolapa', 20),
(20022, 'Cosoltepec', 20),
(20023, 'Cuilápam de Guerrero', 20),
(20024, 'Cuyamecalco Villa de Zaragoza', 20),
(20025, 'Chahuites', 20),
(20026, 'Chalcatongo de Hidalgo', 20),
(20027, 'Chiquihuitlán de Benito Juárez', 20),
(20028, 'Heroica Ciudad de Ejutla de Crespo', 20),
(20029, 'Eloxochitlán de Flores Magón', 20),
(20030, 'El Espinal', 20),
(20031, 'Tamazulápam del Espíritu Santo', 20),
(20032, 'Fresnillo de Trujano', 20),
(20033, 'Guadalupe Etla', 20),
(20034, 'Guadalupe de Ramírez', 20),
(20035, 'Guelatao de Juárez', 20),
(20036, 'Guevea de Humboldt', 20),
(20037, 'Mesones Hidalgo', 20),
(20038, 'Villa Hidalgo', 20),
(20039, 'Heroica Ciudad de Huajuapan de León', 20),
(20040, 'Huautepec', 20),
(20041, 'Huautla de Jiménez', 20),
(20042, 'Ixtlán de Juárez', 20),
(20043, 'Heroica Ciudad de Juchitán de Zaragoza', 20),
(20044, 'Loma Bonita', 20),
(20045, 'Magdalena Apasco', 20),
(20046, 'Magdalena Jaltepec', 20),
(20047, 'Santa Magdalena Jicotlán', 20),
(20048, 'Magdalena Mixtepec', 20),
(20049, 'Magdalena Ocotlán', 20),
(20050, 'Magdalena Peñasco', 20),
(20051, 'Magdalena Teitipac', 20),
(20052, 'Magdalena Tequisistlán', 20),
(20053, 'Magdalena Tlacotepec', 20),
(20054, 'Magdalena Zahuatlán', 20),
(20055, 'Mariscala de Juárez', 20),
(20056, 'Mártires de Tacubaya', 20),
(20057, 'Matías Romero Avendaño', 20),
(20058, 'Mazatlán Villa de Flores', 20),
(20059, 'Miahuatlán de Porfirio Díaz', 20),
(20060, 'Mixistlán de la Reforma', 20),
(20061, 'Monjas', 20),
(20062, 'Natividad', 20),
(20063, 'Nazareno Etla', 20),
(20064, 'Nejapa de Madero', 20),
(20065, 'Ixpantepec Nieves', 20),
(20066, 'Santiago Niltepec', 20),
(20067, 'Oaxaca de Juárez', 20),
(20068, 'Ocotlán de Morelos', 20),
(20069, 'La Pe', 20),
(20070, 'Pinotepa de Don Luis', 20),
(20071, 'Pluma Hidalgo', 20),
(20072, 'San José del Progreso', 20),
(20073, 'Putla Villa de Guerrero', 20),
(20074, 'Santa Catarina Quioquitani', 20),
(20075, 'Reforma de Pineda', 20),
(20076, 'La Reforma', 20),
(20077, 'Reyes Etla', 20),
(20078, 'Rojas de Cuauhtémoc', 20),
(20079, 'Salina Cruz', 20),
(20080, 'San Agustín Amatengo', 20),
(20081, 'San Agustín Atenango', 20),
(20082, 'San Agustín Chayuco', 20),
(20083, 'San Agustín de las Juntas', 20),
(20084, 'San Agustín Etla', 20),
(20085, 'San Agustín Loxicha', 20),
(20086, 'San Agustín Tlacotepec', 20),
(20087, 'San Agustín Yatareni', 20),
(20088, 'San Andrés Cabecera Nueva', 20),
(20089, 'San Andrés Dinicuiti', 20),
(20090, 'San Andrés Huaxpaltepec', 20),
(20091, 'San Andrés Huayápam', 20),
(20092, 'San Andrés Ixtlahuaca', 20),
(20093, 'San Andrés Lagunas', 20),
(20094, 'San Andrés Nuxiño', 20),
(20095, 'San Andrés Paxtlán', 20),
(20096, 'San Andrés Sinaxtla', 20),
(20097, 'San Andrés Solaga', 20),
(20098, 'San Andrés Teotilálpam', 20),
(20099, 'San Andrés Tepetlapa', 20),
(20100, 'San Andrés Yaá', 20),
(20101, 'San Andrés Zabache', 20),
(20102, 'San Andrés Zautla', 20),
(20103, 'San Antonino Castillo Velasco', 20),
(20104, 'San Antonino el Alto', 20),
(20105, 'San Antonino Monte Verde', 20),
(20106, 'San Antonio Acutla', 20),
(20107, 'San Antonio de la Cal', 20),
(20108, 'San Antonio Huitepec', 20),
(20109, 'San Antonio Nanahuatípam', 20),
(20110, 'San Antonio Sinicahua', 20),
(20111, 'San Antonio Tepetlapa', 20),
(20112, 'San Baltazar Chichicápam', 20),
(20113, 'San Baltazar Loxicha', 20),
(20114, 'San Baltazar Yatzachi el Bajo', 20),
(20115, 'San Bartolo Coyotepec', 20),
(20116, 'San Bartolomé Ayautla', 20),
(20117, 'San Bartolomé Loxicha', 20),
(20118, 'San Bartolomé Quialana', 20),
(20119, 'San Bartolomé Yucuañe', 20),
(20120, 'San Bartolomé Zoogocho', 20),
(20121, 'San Bartolo Soyaltepec', 20),
(20122, 'San Bartolo Yautepec', 20),
(20123, 'San Bernardo Mixtepec', 20),
(20124, 'San Blas Atempa', 20),
(20125, 'San Carlos Yautepec', 20),
(20126, 'San Cristóbal Amatlán', 20),
(20127, 'San Cristóbal Amoltepec', 20),
(20128, 'San Cristóbal Lachirioag', 20),
(20129, 'San Cristóbal Suchixtlahuaca', 20),
(20130, 'San Dionisio del Mar', 20),
(20131, 'San Dionisio Ocotepec', 20),
(20132, 'San Dionisio Ocotlán', 20),
(20133, 'San Esteban Atatlahuca', 20),
(20134, 'San Felipe Jalapa de Díaz', 20),
(20135, 'San Felipe Tejalápam', 20),
(20136, 'San Felipe Usila', 20),
(20137, 'San Francisco Cahuacuá', 20),
(20138, 'San Francisco Cajonos', 20),
(20139, 'San Francisco Chapulapa', 20),
(20140, 'San Francisco Chindúa', 20),
(20141, 'San Francisco del Mar', 20),
(20142, 'San Francisco Huehuetlán', 20),
(20143, 'San Francisco Ixhuatán', 20),
(20144, 'San Francisco Jaltepetongo', 20),
(20145, 'San Francisco Lachigoló', 20),
(20146, 'San Francisco Logueche', 20),
(20147, 'San Francisco Nuxaño', 20),
(20148, 'San Francisco Ozolotepec', 20),
(20149, 'San Francisco Sola', 20),
(20150, 'San Francisco Telixtlahuaca', 20),
(20151, 'San Francisco Teopan', 20),
(20152, 'San Francisco Tlapancingo', 20),
(20153, 'San Gabriel Mixtepec', 20),
(20154, 'San Ildefonso Amatlán', 20),
(20155, 'San Ildefonso Sola', 20),
(20156, 'San Ildefonso Villa Alta', 20),
(20157, 'San Jacinto Amilpas', 20),
(20158, 'San Jacinto Tlacotepec', 20),
(20159, 'San Jerónimo Coatlán', 20),
(20160, 'San Jerónimo Silacayoapilla', 20),
(20161, 'San Jerónimo Sosola', 20),
(20162, 'San Jerónimo Taviche', 20),
(20163, 'San Jerónimo Tecóatl', 20),
(20164, 'San Jorge Nuchita', 20),
(20165, 'San José Ayuquila', 20),
(20166, 'San José Chiltepec', 20),
(20167, 'San José del Peñasco', 20),
(20168, 'San José Estancia Grande', 20),
(20169, 'San José Independencia', 20),
(20170, 'San José Lachiguiri', 20),
(20171, 'San José Tenango', 20),
(20172, 'San Juan Achiutla', 20),
(20173, 'San Juan Atepec', 20),
(20174, 'Ánimas Trujano', 20),
(20175, 'San Juan Bautista Atatlahuca', 20),
(20176, 'San Juan Bautista Coixtlahuaca', 20),
(20177, 'San Juan Bautista Cuicatlán', 20),
(20178, 'San Juan Bautista Guelache', 20),
(20179, 'San Juan Bautista Jayacatlán', 20),
(20180, 'San Juan Bautista Lo de Soto', 20),
(20181, 'San Juan Bautista Suchitepec', 20),
(20182, 'San Juan Bautista Tlacoatzintepec', 20),
(20183, 'San Juan Bautista Tlachichilco', 20),
(20184, 'San Juan Bautista Tuxtepec', 20),
(20185, 'San Juan Cacahuatepec', 20),
(20186, 'San Juan Cieneguilla', 20),
(20187, 'San Juan Coatzóspam', 20),
(20188, 'San Juan Colorado', 20),
(20189, 'San Juan Comaltepec', 20),
(20190, 'San Juan Cotzocón', 20),
(20191, 'San Juan Chicomezúchil', 20),
(20192, 'San Juan Chilateca', 20),
(20193, 'San Juan del Estado', 20),
(20194, 'San Juan del Río', 20),
(20195, 'San Juan Diuxi', 20),
(20196, 'San Juan Evangelista Analco', 20),
(20197, 'San Juan Guelavía', 20),
(20198, 'San Juan Guichicovi', 20),
(20199, 'San Juan Ihualtepec', 20),
(20200, 'San Juan Juquila Mixes', 20),
(20201, 'San Juan Juquila Vijanos', 20),
(20202, 'San Juan Lachao', 20),
(20203, 'San Juan Lachigalla', 20),
(20204, 'San Juan Lajarcia', 20),
(20205, 'San Juan Lalana', 20),
(20206, 'San Juan de los Cués', 20),
(20207, 'San Juan Mazatlán', 20),
(20208, 'San Juan Mixtepec -Dto. 08 -', 20),
(20209, 'San Juan Mixtepec -Dto. 26 -', 20),
(20210, 'San Juan Ñumí', 20),
(20211, 'San Juan Ozolotepec', 20),
(20212, 'San Juan Petlapa', 20),
(20213, 'San Juan Quiahije', 20),
(20214, 'San Juan Quiotepec', 20),
(20215, 'San Juan Sayultepec', 20),
(20216, 'San Juan Tabaá', 20),
(20217, 'San Juan Tamazola', 20),
(20218, 'San Juan Teita', 20),
(20219, 'San Juan Teitipac', 20),
(20220, 'San Juan Tepeuxila', 20),
(20221, 'San Juan Teposcolula', 20),
(20222, 'San Juan Yaeé', 20),
(20223, 'San Juan Yatzona', 20),
(20224, 'San Juan Yucuita', 20),
(20225, 'San Lorenzo', 20),
(20226, 'San Lorenzo Albarradas', 20),
(20227, 'San Lorenzo Cacaotepec', 20),
(20228, 'San Lorenzo Cuaunecuiltitla', 20),
(20229, 'San Lorenzo Texmelúcan', 20),
(20230, 'San Lorenzo Victoria', 20),
(20231, 'San Lucas Camotlán', 20),
(20232, 'San Lucas Ojitlán', 20),
(20233, 'San Lucas Quiaviní', 20),
(20234, 'San Lucas Zoquiápam', 20),
(20235, 'San Luis Amatlán', 20),
(20236, 'San Marcial Ozolotepec', 20),
(20237, 'San Marcos Arteaga', 20),
(20238, 'San Martín de los Cansecos', 20),
(20239, 'San Martín Huamelúlpam', 20),
(20240, 'San Martín Itunyoso', 20),
(20241, 'San Martín Lachilá', 20),
(20242, 'San Martín Peras', 20),
(20243, 'San Martín Tilcajete', 20),
(20244, 'San Martín Toxpalan', 20),
(20245, 'San Martín Zacatepec', 20),
(20246, 'San Mateo Cajonos', 20),
(20247, 'Capulálpam de Méndez', 20),
(20248, 'San Mateo del Mar', 20),
(20249, 'San Mateo Yoloxochitlán', 20),
(20250, 'San Mateo Etlatongo', 20),
(20251, 'San Mateo Nejápam', 20),
(20252, 'San Mateo Peñasco', 20),
(20253, 'San Mateo Piñas', 20),
(20254, 'San Mateo Río Hondo', 20),
(20255, 'San Mateo Sindihui', 20),
(20256, 'San Mateo Tlapiltepec', 20),
(20257, 'San Melchor Betaza', 20),
(20258, 'San Miguel Achiutla', 20),
(20259, 'San Miguel Ahuehuetitlán', 20),
(20260, 'San Miguel Aloápam', 20),
(20261, 'San Miguel Amatitlán', 20),
(20262, 'San Miguel Amatlán', 20),
(20263, 'San Miguel Coatlán', 20),
(20264, 'San Miguel Chicahua', 20),
(20265, 'San Miguel Chimalapa', 20),
(20266, 'San Miguel del Puerto', 20),
(20267, 'San Miguel del Río', 20),
(20268, 'San Miguel Ejutla', 20),
(20269, 'San Miguel el Grande', 20),
(20270, 'San Miguel Huautla', 20),
(20271, 'San Miguel Mixtepec', 20),
(20272, 'San Miguel Panixtlahuaca', 20),
(20273, 'San Miguel Peras', 20),
(20274, 'San Miguel Piedras', 20),
(20275, 'San Miguel Quetzaltepec', 20),
(20276, 'San Miguel Santa Flor', 20),
(20277, 'Villa Sola de Vega', 20),
(20278, 'San Miguel Soyaltepec', 20),
(20279, 'San Miguel Suchixtepec', 20),
(20280, 'Villa Talea de Castro', 20),
(20281, 'San Miguel Tecomatlán', 20),
(20282, 'San Miguel Tenango', 20),
(20283, 'San Miguel Tequixtepec', 20),
(20284, 'San Miguel Tilquiápam', 20),
(20285, 'San Miguel Tlacamama', 20),
(20286, 'San Miguel Tlacotepec', 20),
(20287, 'San Miguel Tulancingo', 20),
(20288, 'San Miguel Yotao', 20),
(20289, 'San Nicolás', 20),
(20290, 'San Nicolás Hidalgo', 20),
(20291, 'San Pablo Coatlán', 20),
(20292, 'San Pablo Cuatro Venados', 20),
(20293, 'San Pablo Etla', 20),
(20294, 'San Pablo Huitzo', 20),
(20295, 'San Pablo Huixtepec', 20),
(20296, 'San Pablo Macuiltianguis', 20),
(20297, 'San Pablo Tijaltepec', 20),
(20298, 'San Pablo Villa de Mitla', 20),
(20299, 'San Pablo Yaganiza', 20),
(20300, 'San Pedro Amuzgos', 20),
(20301, 'San Pedro Apóstol', 20),
(20302, 'San Pedro Atoyac', 20),
(20303, 'San Pedro Cajonos', 20),
(20304, 'San Pedro Coxcaltepec Cántaros', 20),
(20305, 'San Pedro Comitancillo', 20),
(20306, 'San Pedro el Alto', 20),
(20307, 'San Pedro Huamelula', 20),
(20308, 'San Pedro Huilotepec', 20),
(20309, 'San Pedro Ixcatlán', 20),
(20310, 'San Pedro Ixtlahuaca', 20),
(20311, 'San Pedro Jaltepetongo', 20),
(20312, 'San Pedro Jicayán', 20),
(20313, 'San Pedro Jocotipac', 20),
(20314, 'San Pedro Juchatengo', 20),
(20315, 'San Pedro Mártir', 20),
(20316, 'San Pedro Mártir Quiechapa', 20),
(20317, 'San Pedro Mártir Yucuxaco', 20),
(20318, 'San Pedro Mixtepec -Dto. 22 -', 20),
(20319, 'San Pedro Mixtepec -Dto. 26 -', 20),
(20320, 'San Pedro Molinos', 20),
(20321, 'San Pedro Nopala', 20),
(20322, 'San Pedro Ocopetatillo', 20),
(20323, 'San Pedro Ocotepec', 20),
(20324, 'San Pedro Pochutla', 20),
(20325, 'San Pedro Quiatoni', 20),
(20326, 'San Pedro Sochiápam', 20),
(20327, 'San Pedro Tapanatepec', 20),
(20328, 'San Pedro Taviche', 20),
(20329, 'San Pedro Teozacoalco', 20),
(20330, 'San Pedro Teutila', 20),
(20331, 'San Pedro Tidaá', 20),
(20332, 'San Pedro Topiltepec', 20),
(20333, 'San Pedro Totolápam', 20),
(20334, 'Villa de Tututepec', 20),
(20335, 'San Pedro Yaneri', 20),
(20336, 'San Pedro Yólox', 20),
(20337, 'San Pedro y San Pablo Ayutla', 20),
(20338, 'Villa de Etla', 20),
(20339, 'San Pedro y San Pablo Teposcolula', 20),
(20340, 'San Pedro y San Pablo Tequixtepec', 20),
(20341, 'San Pedro Yucunama', 20),
(20342, 'San Raymundo Jalpan', 20),
(20343, 'San Sebastián Abasolo', 20),
(20344, 'San Sebastián Coatlán', 20),
(20345, 'San Sebastián Ixcapa', 20),
(20346, 'San Sebastián Nicananduta', 20),
(20347, 'San Sebastián Río Hondo', 20),
(20348, 'San Sebastián Tecomaxtlahuaca', 20),
(20349, 'San Sebastián Teitipac', 20),
(20350, 'San Sebastián Tutla', 20),
(20351, 'San Simón Almolongas', 20),
(20352, 'San Simón Zahuatlán', 20),
(20353, 'Santa Ana', 20),
(20354, 'Santa Ana Ateixtlahuaca', 20),
(20355, 'Santa Ana Cuauhtémoc', 20),
(20356, 'Santa Ana del Valle', 20),
(20357, 'Santa Ana Tavela', 20),
(20358, 'Santa Ana Tlapacoyan', 20),
(20359, 'Santa Ana Yareni', 20),
(20360, 'Santa Ana Zegache', 20),
(20361, 'Santa Catalina Quierí', 20),
(20362, 'Santa Catarina Cuixtla', 20),
(20363, 'Santa Catarina Ixtepeji', 20),
(20364, 'Santa Catarina Juquila', 20),
(20365, 'Santa Catarina Lachatao', 20),
(20366, 'Santa Catarina Loxicha', 20),
(20367, 'Santa Catarina Mechoacán', 20),
(20368, 'Santa Catarina Minas', 20),
(20369, 'Santa Catarina Quiané', 20),
(20370, 'Santa Catarina Tayata', 20),
(20371, 'Santa Catarina Ticuá', 20),
(20372, 'Santa Catarina Yosonotú', 20),
(20373, 'Santa Catarina Zapoquila', 20),
(20374, 'Santa Cruz Acatepec', 20),
(20375, 'Santa Cruz Amilpas', 20),
(20376, 'Santa Cruz de Bravo', 20),
(20377, 'Santa Cruz Itundujia', 20),
(20378, 'Santa Cruz Mixtepec', 20),
(20379, 'Santa Cruz Nundaco', 20),
(20380, 'Santa Cruz Papalutla', 20),
(20381, 'Santa Cruz Tacache de Mina', 20),
(20382, 'Santa Cruz Tacahua', 20),
(20383, 'Santa Cruz Tayata', 20),
(20384, 'Santa Cruz Xitla', 20),
(20385, 'Santa Cruz Xoxocotlán', 20),
(20386, 'Santa Cruz Zenzontepec', 20),
(20387, 'Santa Gertrudis', 20),
(20388, 'Santa Inés del Monte', 20),
(20389, 'Santa Inés Yatzeche', 20),
(20390, 'Santa Lucía del Camino', 20),
(20391, 'Santa Lucía Miahuatlán', 20),
(20392, 'Santa Lucía Monteverde', 20),
(20393, 'Santa Lucía Ocotlán', 20),
(20394, 'Santa María Alotepec', 20),
(20395, 'Santa María Apazco', 20),
(20396, 'Santa María la Asunción', 20),
(20397, 'Heroica Ciudad de Tlaxiaco', 20),
(20398, 'Ayoquezco de Aldama', 20),
(20399, 'Santa María Atzompa', 20),
(20400, 'Santa María Camotlán', 20),
(20401, 'Santa María Colotepec', 20),
(20402, 'Santa María Cortijo', 20),
(20403, 'Santa María Coyotepec', 20),
(20404, 'Santa María Chachoápam', 20),
(20405, 'Villa de Chilapa de Díaz', 20),
(20406, 'Santa María Chilchotla', 20),
(20407, 'Santa María Chimalapa', 20),
(20408, 'Santa María del Rosario', 20),
(20409, 'Santa María del Tule', 20),
(20410, 'Santa María Ecatepec', 20),
(20411, 'Santa María Guelacé', 20),
(20412, 'Santa María Guienagati', 20),
(20413, 'Santa María Huatulco', 20),
(20414, 'Santa María Huazolotitlán', 20),
(20415, 'Santa María Ipalapa', 20),
(20416, 'Santa María Ixcatlán', 20),
(20417, 'Santa María Jacatepec', 20),
(20418, 'Santa María Jalapa del Marqués', 20),
(20419, 'Santa María Jaltianguis', 20),
(20420, 'Santa María Lachixío', 20),
(20421, 'Santa María Mixtequilla', 20),
(20422, 'Santa María Nativitas', 20),
(20423, 'Santa María Nduayaco', 20),
(20424, 'Santa María Ozolotepec', 20),
(20425, 'Santa María Pápalo', 20),
(20426, 'Santa María Peñoles', 20),
(20427, 'Santa María Petapa', 20),
(20428, 'Santa María Quiegolani', 20),
(20429, 'Santa María Sola', 20),
(20430, 'Santa María Tataltepec', 20),
(20431, 'Santa María Tecomavaca', 20),
(20432, 'Santa María Temaxcalapa', 20),
(20433, 'Santa María Temaxcaltepec', 20),
(20434, 'Santa María Teopoxco', 20),
(20435, 'Santa María Tepantlali', 20),
(20436, 'Santa María Texcatitlán', 20),
(20437, 'Santa María Tlahuitoltepec', 20),
(20438, 'Santa María Tlalixtac', 20),
(20439, 'Santa María Tonameca', 20),
(20440, 'Santa María Totolapilla', 20),
(20441, 'Santa María Xadani', 20),
(20442, 'Santa María Yalina', 20),
(20443, 'Santa María Yavesía', 20),
(20444, 'Santa María Yolotepec', 20),
(20445, 'Santa María Yosoyúa', 20),
(20446, 'Santa María Yucuhiti', 20),
(20447, 'Santa María Zacatepec', 20),
(20448, 'Santa María Zaniza', 20),
(20449, 'Santa María Zoquitlán', 20),
(20450, 'Santiago Amoltepec', 20),
(20451, 'Santiago Apoala', 20),
(20452, 'Santiago Apóstol', 20),
(20453, 'Santiago Astata', 20),
(20454, 'Santiago Atitlán', 20),
(20455, 'Santiago Ayuquililla', 20),
(20456, 'Santiago Cacaloxtepec', 20),
(20457, 'Santiago Camotlán', 20),
(20458, 'Santiago Comaltepec', 20),
(20459, 'Santiago Chazumba', 20),
(20460, 'Santiago Choápam', 20),
(20461, 'Santiago del Río', 20),
(20462, 'Santiago Huajolotitlán', 20),
(20463, 'Santiago Huauclilla', 20),
(20464, 'Santiago Ihuitlán Plumas', 20),
(20465, 'Santiago Ixcuintepec', 20),
(20466, 'Santiago Ixtayutla', 20),
(20467, 'Santiago Jamiltepec', 20),
(20468, 'Santiago Jocotepec', 20),
(20469, 'Santiago Juxtlahuaca', 20),
(20470, 'Santiago Lachiguiri', 20),
(20471, 'Santiago Lalopa', 20),
(20472, 'Santiago Laollaga', 20),
(20473, 'Santiago Laxopa', 20),
(20474, 'Santiago Llano Grande', 20),
(20475, 'Santiago Matatlán', 20),
(20476, 'Santiago Miltepec', 20),
(20477, 'Santiago Minas', 20),
(20478, 'Santiago Nacaltepec', 20),
(20479, 'Santiago Nejapilla', 20),
(20480, 'Santiago Nundiche', 20),
(20481, 'Santiago Nuyoó', 20),
(20482, 'Santiago Pinotepa Nacional', 20),
(20483, 'Santiago Suchilquitongo', 20),
(20484, 'Santiago Tamazola', 20),
(20485, 'Santiago Tapextla', 20),
(20486, 'Villa Tejúpam de la Unión', 20),
(20487, 'Santiago Tenango', 20),
(20488, 'Santiago Tepetlapa', 20),
(20489, 'Santiago Tetepec', 20),
(20490, 'Santiago Texcalcingo', 20),
(20491, 'Santiago Textitlán', 20),
(20492, 'Santiago Tilantongo', 20),
(20493, 'Santiago Tillo', 20),
(20494, 'Santiago Tlazoyaltepec', 20),
(20495, 'Santiago Xanica', 20),
(20496, 'Santiago Xiacuí', 20),
(20497, 'Santiago Yaitepec', 20),
(20498, 'Santiago Yaveo', 20),
(20499, 'Santiago Yolomécatl', 20),
(20500, 'Santiago Yosondúa', 20),
(20501, 'Santiago Yucuyachi', 20),
(20502, 'Santiago Zacatepec', 20),
(20503, 'Santiago Zoochila', 20),
(20504, 'Nuevo Zoquiápam', 20),
(20505, 'Santo Domingo Ingenio', 20),
(20506, 'Santo Domingo Albarradas', 20),
(20507, 'Santo Domingo Armenta', 20),
(20508, 'Santo Domingo Chihuitán', 20),
(20509, 'Santo Domingo de Morelos', 20),
(20510, 'Santo Domingo Ixcatlán', 20),
(20511, 'Santo Domingo Nuxaá', 20),
(20512, 'Santo Domingo Ozolotepec', 20),
(20513, 'Santo Domingo Petapa', 20),
(20514, 'Santo Domingo Roayaga', 20),
(20515, 'Santo Domingo Tehuantepec', 20),
(20516, 'Santo Domingo Teojomulco', 20),
(20517, 'Santo Domingo Tepuxtepec', 20),
(20518, 'Santo Domingo Tlatayápam', 20),
(20519, 'Santo Domingo Tomaltepec', 20),
(20520, 'Santo Domingo Tonalá', 20),
(20521, 'Santo Domingo Tonaltepec', 20),
(20522, 'Santo Domingo Xagacía', 20),
(20523, 'Santo Domingo Yanhuitlán', 20),
(20524, 'Santo Domingo Yodohino', 20),
(20525, 'Santo Domingo Zanatepec', 20),
(20526, 'Santos Reyes Nopala', 20),
(20527, 'Santos Reyes Pápalo', 20),
(20528, 'Santos Reyes Tepejillo', 20),
(20529, 'Santos Reyes Yucuná', 20),
(20530, 'Santo Tomás Jalieza', 20),
(20531, 'Santo Tomás Mazaltepec', 20),
(20532, 'Santo Tomás Ocotepec', 20),
(20533, 'Santo Tomás Tamazulapan', 20),
(20534, 'San Vicente Coatlán', 20),
(20535, 'San Vicente Lachixío', 20),
(20536, 'San Vicente Nuñú', 20),
(20537, 'Silacayoápam', 20),
(20538, 'Sitio de Xitlapehua', 20),
(20539, 'Soledad Etla', 20),
(20540, 'Villa de Tamazulápam del Progreso', 20),
(20541, 'Tanetze de Zaragoza', 20),
(20542, 'Taniche', 20),
(20543, 'Tataltepec de Valdés', 20),
(20544, 'Teococuilco de Marcos Pérez', 20),
(20545, 'Teotitlán de Flores Magón', 20),
(20546, 'Teotitlán del Valle', 20),
(20547, 'Teotongo', 20),
(20548, 'Tepelmeme Villa de Morelos', 20),
(20549, 'Tezoatlán de Segura y Luna', 20),
(20550, 'San Jerónimo Tlacochahuaya', 20),
(20551, 'Tlacolula de Matamoros', 20),
(20552, 'Tlacotepec Plumas', 20),
(20553, 'Tlalixtac de Cabrera', 20),
(20554, 'Totontepec Villa de Morelos', 20),
(20555, 'Trinidad Zaachila', 20),
(20556, 'La Trinidad Vista Hermosa', 20),
(20557, 'Unión Hidalgo', 20),
(20558, 'Valerio Trujano', 20),
(20559, 'San Juan Bautista Valle Nacional', 20),
(20560, 'Villa Díaz Ordaz', 20),
(20561, 'Yaxe', 20),
(20562, 'Magdalena Yodocono de Porfirio Díaz', 20),
(20563, 'Yogana', 20),
(20564, 'Yutanduchi de Guerrero', 20),
(20565, 'Villa de Zaachila', 20),
(20566, 'San Mateo Yucutindoo', 20),
(20567, 'Zapotitlán Lagunas', 20),
(20568, 'Zapotitlán Palmas', 20),
(20569, 'Santa Inés de Zaragoza', 20),
(20570, 'Zimatlán de Álvarez', 20),
(21001, 'Acajete', 21),
(21002, 'Acateno', 21),
(21003, 'Acatlán', 21),
(21004, 'Acatzingo', 21),
(21005, 'Acteopan', 21),
(21006, 'Ahuacatlán', 21),
(21007, 'Ahuatlán', 21),
(21008, 'Ahuazotepec', 21),
(21009, 'Ahuehuetitla', 21),
(21010, 'Ajalpan', 21),
(21011, 'Albino Zertuche', 21),
(21012, 'Aljojuca', 21),
(21013, 'Altepexi', 21),
(21014, 'Amixtlán', 21),
(21015, 'Amozoc', 21),
(21016, 'Aquixtla', 21),
(21017, 'Atempan', 21),
(21018, 'Atexcal', 21),
(21019, 'Atlixco', 21),
(21020, 'Atoyatempan', 21),
(21021, 'Atzala', 21),
(21022, 'Atzitzihuacán', 21),
(21023, 'Atzitzintla', 21),
(21024, 'Axutla', 21),
(21025, 'Ayotoxco de Guerrero', 21),
(21026, 'Calpan', 21),
(21027, 'Caltepec', 21),
(21028, 'Camocuautla', 21),
(21029, 'Caxhuacan', 21),
(21030, 'Coatepec', 21),
(21031, 'Coatzingo', 21),
(21032, 'Cohetzala', 21),
(21033, 'Cohuecan', 21),
(21034, 'Coronango', 21),
(21035, 'Coxcatlán', 21),
(21036, 'Coyomeapan', 21),
(21037, 'Coyotepec', 21),
(21038, 'Cuapiaxtla de Madero', 21),
(21039, 'Cuautempan', 21),
(21040, 'Cuautinchán', 21),
(21041, 'Cuautlancingo', 21),
(21042, 'Cuayuca de Andrade', 21),
(21043, 'Cuetzalan del Progreso', 21),
(21044, 'Cuyoaco', 21),
(21045, 'Chalchicomula de Sesma', 21),
(21046, 'Chapulco', 21),
(21047, 'Chiautla', 21),
(21048, 'Chiautzingo', 21),
(21049, 'Chiconcuautla', 21),
(21050, 'Chichiquila', 21),
(21051, 'Chietla', 21),
(21052, 'Chigmecatitlán', 21),
(21053, 'Chignahuapan', 21),
(21054, 'Chignautla', 21),
(21055, 'Chila', 21),
(21056, 'Chila de la Sal', 21),
(21057, 'Honey', 21),
(21058, 'Chilchotla', 21),
(21059, 'Chinantla', 21),
(21060, 'Domingo Arenas', 21),
(21061, 'Eloxochitlán', 21),
(21062, 'Epatlán', 21),
(21063, 'Esperanza', 21),
(21064, 'Francisco Z. Mena', 21),
(21065, 'General Felipe Ángeles', 21),
(21066, 'Guadalupe', 21),
(21067, 'Guadalupe Victoria', 21),
(21068, 'Hermenegildo Galeana', 21),
(21069, 'Huaquechula', 21),
(21070, 'Huatlatlauca', 21),
(21071, 'Huauchinango', 21),
(21072, 'Huehuetla', 21),
(21073, 'Huehuetlán el Chico', 21),
(21074, 'Huejotzingo', 21),
(21075, 'Hueyapan', 21),
(21076, 'Hueytamalco', 21),
(21077, 'Hueytlalpan', 21),
(21078, 'Huitzilan de Serdán', 21),
(21079, 'Huitziltepec', 21),
(21080, 'Atlequizayan', 21),
(21081, 'Ixcamilpa de Guerrero', 21),
(21082, 'Ixcaquixtla', 21),
(21083, 'Ixtacamaxtitlán', 21),
(21084, 'Ixtepec', 21),
(21085, 'Izúcar de Matamoros', 21),
(21086, 'Jalpan', 21),
(21087, 'Jolalpan', 21),
(21088, 'Jonotla', 21),
(21089, 'Jopala', 21),
(21090, 'Juan C. Bonilla', 21),
(21091, 'Juan Galindo', 21),
(21092, 'Juan N. Méndez', 21),
(21093, 'Lafragua', 21),
(21094, 'Libres', 21),
(21095, 'La Magdalena Tlatlauquitepec', 21),
(21096, 'Mazapiltepec de Juárez', 21),
(21097, 'Mixtla', 21),
(21098, 'Molcaxac', 21),
(21099, 'Cañada Morelos', 21),
(21100, 'Naupan', 21),
(21101, 'Nauzontla', 21),
(21102, 'Nealtican', 21),
(21103, 'Nicolás Bravo', 21),
(21104, 'Nopalucan', 21),
(21105, 'Ocotepec', 21),
(21106, 'Ocoyucan', 21),
(21107, 'Olintla', 21),
(21108, 'Oriental', 21),
(21109, 'Pahuatlán', 21),
(21110, 'Palmar de Bravo', 21),
(21111, 'Pantepec', 21),
(21112, 'Petlalcingo', 21),
(21113, 'Piaxtla', 21),
(21114, 'Puebla', 21),
(21115, 'Quecholac', 21),
(21116, 'Quimixtlán', 21),
(21117, 'Rafael Lara Grajales', 21),
(21118, 'Los Reyes de Juárez', 21),
(21119, 'San Andrés Cholula', 21),
(21120, 'San Antonio Cañada', 21),
(21121, 'San Diego la Mesa Tochimiltzingo', 21),
(21122, 'San Felipe Teotlalcingo', 21),
(21123, 'San Felipe Tepatlán', 21),
(21124, 'San Gabriel Chilac', 21),
(21125, 'San Gregorio Atzompa', 21),
(21126, 'San Jerónimo Tecuanipan', 21),
(21127, 'San Jerónimo Xayacatlán', 21),
(21128, 'San José Chiapa', 21),
(21129, 'San José Miahuatlán', 21),
(21130, 'San Juan Atenco', 21),
(21131, 'San Juan Atzompa', 21),
(21132, 'San Martín Texmelucan', 21),
(21133, 'San Martín Totoltepec', 21),
(21134, 'San Matías Tlalancaleca', 21),
(21135, 'San Miguel Ixitlán', 21),
(21136, 'San Miguel Xoxtla', 21),
(21137, 'San Nicolás Buenos Aires', 21),
(21138, 'San Nicolás de los Ranchos', 21),
(21139, 'San Pablo Anicano', 21),
(21140, 'San Pedro Cholula', 21),
(21141, 'San Pedro Yeloixtlahuaca', 21);
INSERT INTO `municipios` (`id`, `nombre`, `estado`) VALUES
(21142, 'San Salvador el Seco', 21),
(21143, 'San Salvador el Verde', 21),
(21144, 'San Salvador Huixcolotla', 21),
(21145, 'San Sebastián Tlacotepec', 21),
(21146, 'Santa Catarina Tlaltempan', 21),
(21147, 'Santa Inés Ahuatempan', 21),
(21148, 'Santa Isabel Cholula', 21),
(21149, 'Santiago Miahuatlán', 21),
(21150, 'Huehuetlán el Grande', 21),
(21151, 'Santo Tomás Hueyotlipan', 21),
(21152, 'Soltepec', 21),
(21153, 'Tecali de Herrera', 21),
(21154, 'Tecamachalco', 21),
(21155, 'Tecomatlán', 21),
(21156, 'Tehuacán', 21),
(21157, 'Tehuitzingo', 21),
(21158, 'Tenampulco', 21),
(21159, 'Teopantlán', 21),
(21160, 'Teotlalco', 21),
(21161, 'Tepanco de López', 21),
(21162, 'Tepango de Rodríguez', 21),
(21163, 'Tepatlaxco de Hidalgo', 21),
(21164, 'Tepeaca', 21),
(21165, 'Tepemaxalco', 21),
(21166, 'Tepeojuma', 21),
(21167, 'Tepetzintla', 21),
(21168, 'Tepexco', 21),
(21169, 'Tepexi de Rodríguez', 21),
(21170, 'Tepeyahualco', 21),
(21171, 'Tepeyahualco de Cuauhtémoc', 21),
(21172, 'Tetela de Ocampo', 21),
(21173, 'Teteles de Avila Castillo', 21),
(21174, 'Teziutlán', 21),
(21175, 'Tianguismanalco', 21),
(21176, 'Tilapa', 21),
(21177, 'Tlacotepec de Benito Juárez', 21),
(21178, 'Tlacuilotepec', 21),
(21179, 'Tlachichuca', 21),
(21180, 'Tlahuapan', 21),
(21181, 'Tlaltenango', 21),
(21182, 'Tlanepantla', 21),
(21183, 'Tlaola', 21),
(21184, 'Tlapacoya', 21),
(21185, 'Tlapanalá', 21),
(21186, 'Tlatlauquitepec', 21),
(21187, 'Tlaxco', 21),
(21188, 'Tochimilco', 21),
(21189, 'Tochtepec', 21),
(21190, 'Totoltepec de Guerrero', 21),
(21191, 'Tulcingo', 21),
(21192, 'Tuzamapan de Galeana', 21),
(21193, 'Tzicatlacoyan', 21),
(21194, 'Venustiano Carranza', 21),
(21195, 'Vicente Guerrero', 21),
(21196, 'Xayacatlán de Bravo', 21),
(21197, 'Xicotepec', 21),
(21198, 'Xicotlán', 21),
(21199, 'Xiutetelco', 21),
(21200, 'Xochiapulco', 21),
(21201, 'Xochiltepec', 21),
(21202, 'Xochitlán de Vicente Suárez', 21),
(21203, 'Xochitlán Todos Santos', 21),
(21204, 'Yaonáhuac', 21),
(21205, 'Yehualtepec', 21),
(21206, 'Zacapala', 21),
(21207, 'Zacapoaxtla', 21),
(21208, 'Zacatlán', 21),
(21209, 'Zapotitlán', 21),
(21210, 'Zapotitlán de Méndez', 21),
(21211, 'Zaragoza', 21),
(21212, 'Zautla', 21),
(21213, 'Zihuateutla', 21),
(21214, 'Zinacatepec', 21),
(21215, 'Zongozotla', 21),
(21216, 'Zoquiapan', 21),
(21217, 'Zoquitlán', 21),
(22001, 'Amealco de Bonfil', 22),
(22002, 'Pinal de Amoles', 22),
(22003, 'Arroyo Seco', 22),
(22004, 'Cadereyta de Montes', 22),
(22005, 'Colón', 22),
(22006, 'Corregidora', 22),
(22007, 'Ezequiel Montes', 22),
(22008, 'Huimilpan', 22),
(22009, 'Jalpan de Serra', 22),
(22010, 'Landa de Matamoros', 22),
(22011, 'El Marqués', 22),
(22012, 'Pedro Escobedo', 22),
(22013, 'Peñamiller', 22),
(22014, 'Querétaro', 22),
(22015, 'San Joaquín', 22),
(22016, 'San Juan del Río', 22),
(22017, 'Tequisquiapan', 22),
(22018, 'Tolimán', 22),
(23001, 'Cozumel', 23),
(23002, 'Felipe Carrillo Puerto', 23),
(23003, 'Isla Mujeres', 23),
(23004, 'Othón P. Blanco', 23),
(23005, 'Benito Juárez', 23),
(23006, 'José María Morelos', 23),
(23007, 'Lázaro Cárdenas', 23),
(23008, 'Solidaridad', 23),
(23009, 'Tulum', 23),
(23010, 'Bacalar', 23),
(23011, 'Puerto Morelos', 23),
(24001, 'Ahualulco', 24),
(24002, 'Alaquines', 24),
(24003, 'Aquismón', 24),
(24004, 'Armadillo de los Infante', 24),
(24005, 'Cárdenas', 24),
(24006, 'Catorce', 24),
(24007, 'Cedral', 24),
(24008, 'Cerritos', 24),
(24009, 'Cerro de San Pedro', 24),
(24010, 'Ciudad del Maíz', 24),
(24011, 'Ciudad Fernández', 24),
(24012, 'Tancanhuitz', 24),
(24013, 'Ciudad Valles', 24),
(24014, 'Coxcatlán', 24),
(24015, 'Charcas', 24),
(24016, 'Ebano', 24),
(24017, 'Guadalcázar', 24),
(24018, 'Huehuetlán', 24),
(24019, 'Lagunillas', 24),
(24020, 'Matehuala', 24),
(24021, 'Mexquitic de Carmona', 24),
(24022, 'Moctezuma', 24),
(24023, 'Rayón', 24),
(24024, 'Rioverde', 24),
(24025, 'Salinas', 24),
(24026, 'San Antonio', 24),
(24027, 'San Ciro de Acosta', 24),
(24028, 'San Luis Potosí', 24),
(24029, 'San Martín Chalchicuautla', 24),
(24030, 'San Nicolás Tolentino', 24),
(24031, 'Santa Catarina', 24),
(24032, 'Santa María del Río', 24),
(24033, 'Santo Domingo', 24),
(24034, 'San Vicente Tancuayalab', 24),
(24035, 'Soledad de Graciano Sánchez', 24),
(24036, 'Tamasopo', 24),
(24037, 'Tamazunchale', 24),
(24038, 'Tampacán', 24),
(24039, 'Tampamolón Corona', 24),
(24040, 'Tamuín', 24),
(24041, 'Tanlajás', 24),
(24042, 'Tanquián de Escobedo', 24),
(24043, 'Tierra Nueva', 24),
(24044, 'Vanegas', 24),
(24045, 'Venado', 24),
(24046, 'Villa de Arriaga', 24),
(24047, 'Villa de Guadalupe', 24),
(24048, 'Villa de la Paz', 24),
(24049, 'Villa de Ramos', 24),
(24050, 'Villa de Reyes', 24),
(24051, 'Villa Hidalgo', 24),
(24052, 'Villa Juárez', 24),
(24053, 'Axtla de Terrazas', 24),
(24054, 'Xilitla', 24),
(24055, 'Zaragoza', 24),
(24056, 'Villa de Arista', 24),
(24057, 'Matlapa', 24),
(24058, 'El Naranjo', 24),
(25001, 'Ahome', 25),
(25002, 'Angostura', 25),
(25003, 'Badiraguato', 25),
(25004, 'Concordia', 25),
(25005, 'Cosalá', 25),
(25006, 'Culiacán', 25),
(25007, 'Choix', 25),
(25008, 'Elota', 25),
(25009, 'Escuinapa', 25),
(25010, 'El Fuerte', 25),
(25011, 'Guasave', 25),
(25012, 'Mazatlán', 25),
(25013, 'Mocorito', 25),
(25014, 'Rosario', 25),
(25015, 'Salvador Alvarado', 25),
(25016, 'San Ignacio', 25),
(25017, 'Sinaloa', 25),
(25018, 'Navolato', 25),
(26001, 'Aconchi', 26),
(26002, 'Agua Prieta', 26),
(26003, 'Alamos', 26),
(26004, 'Altar', 26),
(26005, 'Arivechi', 26),
(26006, 'Arizpe', 26),
(26007, 'Atil', 26),
(26008, 'Bacadéhuachi', 26),
(26009, 'Bacanora', 26),
(26010, 'Bacerac', 26),
(26011, 'Bacoachi', 26),
(26012, 'Bácum', 26),
(26013, 'Banámichi', 26),
(26014, 'Baviácora', 26),
(26015, 'Bavispe', 26),
(26016, 'Benjamín Hill', 26),
(26017, 'Caborca', 26),
(26018, 'Cajeme', 26),
(26019, 'Cananea', 26),
(26020, 'Carbó', 26),
(26021, 'La Colorada', 26),
(26022, 'Cucurpe', 26),
(26023, 'Cumpas', 26),
(26024, 'Divisaderos', 26),
(26025, 'Empalme', 26),
(26026, 'Etchojoa', 26),
(26027, 'Fronteras', 26),
(26028, 'Granados', 26),
(26029, 'Guaymas', 26),
(26030, 'Hermosillo', 26),
(26031, 'Huachinera', 26),
(26032, 'Huásabas', 26),
(26033, 'Huatabampo', 26),
(26034, 'Huépac', 26),
(26035, 'Imuris', 26),
(26036, 'Magdalena', 26),
(26037, 'Mazatán', 26),
(26038, 'Moctezuma', 26),
(26039, 'Naco', 26),
(26040, 'Nácori Chico', 26),
(26041, 'Nacozari de García', 26),
(26042, 'Navojoa', 26),
(26043, 'Nogales', 26),
(26044, 'Onavas', 26),
(26045, 'Opodepe', 26),
(26046, 'Oquitoa', 26),
(26047, 'Pitiquito', 26),
(26048, 'Puerto Peñasco', 26),
(26049, 'Quiriego', 26),
(26050, 'Rayón', 26),
(26051, 'Rosario', 26),
(26052, 'Sahuaripa', 26),
(26053, 'San Felipe de Jesús', 26),
(26054, 'San Javier', 26),
(26055, 'San Luis Río Colorado', 26),
(26056, 'San Miguel de Horcasitas', 26),
(26057, 'San Pedro de la Cueva', 26),
(26058, 'Santa Ana', 26),
(26059, 'Santa Cruz', 26),
(26060, 'Sáric', 26),
(26061, 'Soyopa', 26),
(26062, 'Suaqui Grande', 26),
(26063, 'Tepache', 26),
(26064, 'Trincheras', 26),
(26065, 'Tubutama', 26),
(26066, 'Ures', 26),
(26067, 'Villa Hidalgo', 26),
(26068, 'Villa Pesqueira', 26),
(26069, 'Yécora', 26),
(26070, 'General Plutarco Elías Calles', 26),
(26071, 'Benito Juárez', 26),
(26072, 'San Ignacio Río Muerto', 26),
(27001, 'Balancán', 27),
(27002, 'Cárdenas', 27),
(27003, 'Centla', 27),
(27004, 'Centro', 27),
(27005, 'Comalcalco', 27),
(27006, 'Cunduacán', 27),
(27007, 'Emiliano Zapata', 27),
(27008, 'Huimanguillo', 27),
(27009, 'Jalapa', 27),
(27010, 'Jalpa de Méndez', 27),
(27011, 'Jonuta', 27),
(27012, 'Macuspana', 27),
(27013, 'Nacajuca', 27),
(27014, 'Paraíso', 27),
(27015, 'Tacotalpa', 27),
(27016, 'Teapa', 27),
(27017, 'Tenosique', 27),
(28001, 'Abasolo', 28),
(28002, 'Aldama', 28),
(28003, 'Altamira', 28),
(28004, 'Antiguo Morelos', 28),
(28005, 'Burgos', 28),
(28006, 'Bustamante', 28),
(28007, 'Camargo', 28),
(28008, 'Casas', 28),
(28009, 'Ciudad Madero', 28),
(28010, 'Cruillas', 28),
(28011, 'Gómez Farías', 28),
(28012, 'González', 28),
(28013, 'Güémez', 28),
(28014, 'Guerrero', 28),
(28015, 'Gustavo Díaz Ordaz', 28),
(28016, 'Hidalgo', 28),
(28017, 'Jaumave', 28),
(28018, 'Jiménez', 28),
(28019, 'Llera', 28),
(28020, 'Mainero', 28),
(28021, 'El Mante', 28),
(28022, 'Matamoros', 28),
(28023, 'Méndez', 28),
(28024, 'Mier', 28),
(28025, 'Miguel Alemán', 28),
(28026, 'Miquihuana', 28),
(28027, 'Nuevo Laredo', 28),
(28028, 'Nuevo Morelos', 28),
(28029, 'Ocampo', 28),
(28030, 'Padilla', 28),
(28031, 'Palmillas', 28),
(28032, 'Reynosa', 28),
(28033, 'Río Bravo', 28),
(28034, 'San Carlos', 28),
(28035, 'San Fernando', 28),
(28036, 'San Nicolás', 28),
(28037, 'Soto la Marina', 28),
(28038, 'Tampico', 28),
(28039, 'Tula', 28),
(28040, 'Valle Hermoso', 28),
(28041, 'Victoria', 28),
(28042, 'Villagrán', 28),
(28043, 'Xicoténcatl', 28),
(29001, 'Amaxac de Guerrero', 29),
(29002, 'Apetatitlán de Antonio Carvajal', 29),
(29003, 'Atlangatepec', 29),
(29004, 'Atltzayanca', 29),
(29005, 'Apizaco', 29),
(29006, 'Calpulalpan', 29),
(29007, 'El Carmen Tequexquitla', 29),
(29008, 'Cuapiaxtla', 29),
(29009, 'Cuaxomulco', 29),
(29010, 'Chiautempan', 29),
(29011, 'Muñoz de Domingo Arenas', 29),
(29012, 'Españita', 29),
(29013, 'Huamantla', 29),
(29014, 'Hueyotlipan', 29),
(29015, 'Ixtacuixtla de Mariano Matamoros', 29),
(29016, 'Ixtenco', 29),
(29017, 'Mazatecochco de José María Morelos', 29),
(29018, 'Contla de Juan Cuamatzi', 29),
(29019, 'Tepetitla de Lardizábal', 29),
(29020, 'Sanctórum de Lázaro Cárdenas', 29),
(29021, 'Nanacamilpa de Mariano Arista', 29),
(29022, 'Acuamanala de Miguel Hidalgo', 29),
(29023, 'Natívitas', 29),
(29024, 'Panotla', 29),
(29025, 'San Pablo del Monte', 29),
(29026, 'Santa Cruz Tlaxcala', 29),
(29027, 'Tenancingo', 29),
(29028, 'Teolocholco', 29),
(29029, 'Tepeyanco', 29),
(29030, 'Terrenate', 29),
(29031, 'Tetla de la Solidaridad', 29),
(29032, 'Tetlatlahuca', 29),
(29033, 'Tlaxcala', 29),
(29034, 'Tlaxco', 29),
(29035, 'Tocatlán', 29),
(29036, 'Totolac', 29),
(29037, 'Ziltlaltépec de Trinidad Sánchez Santos', 29),
(29038, 'Tzompantepec', 29),
(29039, 'Xaloztoc', 29),
(29040, 'Xaltocan', 29),
(29041, 'Papalotla de Xicohténcatl', 29),
(29042, 'Xicohtzinco', 29),
(29043, 'Yauhquemehcan', 29),
(29044, 'Zacatelco', 29),
(29045, 'Benito Juárez', 29),
(29046, 'Emiliano Zapata', 29),
(29047, 'Lázaro Cárdenas', 29),
(29048, 'La Magdalena Tlaltelulco', 29),
(29049, 'San Damián Texóloc', 29),
(29050, 'San Francisco Tetlanohcan', 29),
(29051, 'San Jerónimo Zacualpan', 29),
(29052, 'San José Teacalco', 29),
(29053, 'San Juan Huactzinco', 29),
(29054, 'San Lorenzo Axocomanitla', 29),
(29055, 'San Lucas Tecopilco', 29),
(29056, 'Santa Ana Nopalucan', 29),
(29057, 'Santa Apolonia Teacalco', 29),
(29058, 'Santa Catarina Ayometla', 29),
(29059, 'Santa Cruz Quilehtla', 29),
(29060, 'Santa Isabel Xiloxoxtla', 29),
(30001, 'Acajete', 30),
(30002, 'Acatlán', 30),
(30003, 'Acayucan', 30),
(30004, 'Actopan', 30),
(30005, 'Acula', 30),
(30006, 'Acultzingo', 30),
(30007, 'Camarón de Tejeda', 30),
(30008, 'Alpatláhuac', 30),
(30009, 'Alto Lucero de Gutiérrez Barrios', 30),
(30010, 'Altotonga', 30),
(30011, 'Alvarado', 30),
(30012, 'Amatitlán', 30),
(30013, 'Naranjos Amatlán', 30),
(30014, 'Amatlán de los Reyes', 30),
(30015, 'Angel R. Cabada', 30),
(30016, 'La Antigua', 30),
(30017, 'Apazapan', 30),
(30018, 'Aquila', 30),
(30019, 'Astacinga', 30),
(30020, 'Atlahuilco', 30),
(30021, 'Atoyac', 30),
(30022, 'Atzacan', 30),
(30023, 'Atzalan', 30),
(30024, 'Tlaltetela', 30),
(30025, 'Ayahualulco', 30),
(30026, 'Banderilla', 30),
(30027, 'Benito Juárez', 30),
(30028, 'Boca del Río', 30),
(30029, 'Calcahualco', 30),
(30030, 'Camerino Z. Mendoza', 30),
(30031, 'Carrillo Puerto', 30),
(30032, 'Catemaco', 30),
(30033, 'Cazones de Herrera', 30),
(30034, 'Cerro Azul', 30),
(30035, 'Citlaltépetl', 30),
(30036, 'Coacoatzintla', 30),
(30037, 'Coahuitlán', 30),
(30038, 'Coatepec', 30),
(30039, 'Coatzacoalcos', 30),
(30040, 'Coatzintla', 30),
(30041, 'Coetzala', 30),
(30042, 'Colipa', 30),
(30043, 'Comapa', 30),
(30044, 'Córdoba', 30),
(30045, 'Cosamaloapan de Carpio', 30),
(30046, 'Cosautlán de Carvajal', 30),
(30047, 'Coscomatepec', 30),
(30048, 'Cosoleacaque', 30),
(30049, 'Cotaxtla', 30),
(30050, 'Coxquihui', 30),
(30051, 'Coyutla', 30),
(30052, 'Cuichapa', 30),
(30053, 'Cuitláhuac', 30),
(30054, 'Chacaltianguis', 30),
(30055, 'Chalma', 30),
(30056, 'Chiconamel', 30),
(30057, 'Chiconquiaco', 30),
(30058, 'Chicontepec', 30),
(30059, 'Chinameca', 30),
(30060, 'Chinampa de Gorostiza', 30),
(30061, 'Las Choapas', 30),
(30062, 'Chocamán', 30),
(30063, 'Chontla', 30),
(30064, 'Chumatlán', 30),
(30065, 'Emiliano Zapata', 30),
(30066, 'Espinal', 30),
(30067, 'Filomeno Mata', 30),
(30068, 'Fortín', 30),
(30069, 'Gutiérrez Zamora', 30),
(30070, 'Hidalgotitlán', 30),
(30071, 'Huatusco', 30),
(30072, 'Huayacocotla', 30),
(30073, 'Hueyapan de Ocampo', 30),
(30074, 'Huiloapan de Cuauhtémoc', 30),
(30075, 'Ignacio de la Llave', 30),
(30076, 'Ilamatlán', 30),
(30077, 'Isla', 30),
(30078, 'Ixcatepec', 30),
(30079, 'Ixhuacán de los Reyes', 30),
(30080, 'Ixhuatlán del Café', 30),
(30081, 'Ixhuatlancillo', 30),
(30082, 'Ixhuatlán del Sureste', 30),
(30083, 'Ixhuatlán de Madero', 30),
(30084, 'Ixmatlahuacan', 30),
(30085, 'Ixtaczoquitlán', 30),
(30086, 'Jalacingo', 30),
(30087, 'Xalapa', 30),
(30088, 'Jalcomulco', 30),
(30089, 'Jáltipan', 30),
(30090, 'Jamapa', 30),
(30091, 'Jesús Carranza', 30),
(30092, 'Xico', 30),
(30093, 'Jilotepec', 30),
(30094, 'Juan Rodríguez Clara', 30),
(30095, 'Juchique de Ferrer', 30),
(30096, 'Landero y Coss', 30),
(30097, 'Lerdo de Tejada', 30),
(30098, 'Magdalena', 30),
(30099, 'Maltrata', 30),
(30100, 'Manlio Fabio Altamirano', 30),
(30101, 'Mariano Escobedo', 30),
(30102, 'Martínez de la Torre', 30),
(30103, 'Mecatlán', 30),
(30104, 'Mecayapan', 30),
(30105, 'Medellín de Bravo', 30),
(30106, 'Miahuatlán', 30),
(30107, 'Las Minas', 30),
(30108, 'Minatitlán', 30),
(30109, 'Misantla', 30),
(30110, 'Mixtla de Altamirano', 30),
(30111, 'Moloacán', 30),
(30112, 'Naolinco', 30),
(30113, 'Naranjal', 30),
(30114, 'Nautla', 30),
(30115, 'Nogales', 30),
(30116, 'Oluta', 30),
(30117, 'Omealca', 30),
(30118, 'Orizaba', 30),
(30119, 'Otatitlán', 30),
(30120, 'Oteapan', 30),
(30121, 'Ozuluama de Mascareñas', 30),
(30122, 'Pajapan', 30),
(30123, 'Pánuco', 30),
(30124, 'Papantla', 30),
(30125, 'Paso del Macho', 30),
(30126, 'Paso de Ovejas', 30),
(30127, 'La Perla', 30),
(30128, 'Perote', 30),
(30129, 'Platón Sánchez', 30),
(30130, 'Playa Vicente', 30),
(30131, 'Poza Rica de Hidalgo', 30),
(30132, 'Las Vigas de Ramírez', 30),
(30133, 'Pueblo Viejo', 30),
(30134, 'Puente Nacional', 30),
(30135, 'Rafael Delgado', 30),
(30136, 'Rafael Lucio', 30),
(30137, 'Los Reyes', 30),
(30138, 'Río Blanco', 30),
(30139, 'Saltabarranca', 30),
(30140, 'San Andrés Tenejapan', 30),
(30141, 'San Andrés Tuxtla', 30),
(30142, 'San Juan Evangelista', 30),
(30143, 'Santiago Tuxtla', 30),
(30144, 'Sayula de Alemán', 30),
(30145, 'Soconusco', 30),
(30146, 'Sochiapa', 30),
(30147, 'Soledad Atzompa', 30),
(30148, 'Soledad de Doblado', 30),
(30149, 'Soteapan', 30),
(30150, 'Tamalín', 30),
(30151, 'Tamiahua', 30),
(30152, 'Tampico Alto', 30),
(30153, 'Tancoco', 30),
(30154, 'Tantima', 30),
(30155, 'Tantoyuca', 30),
(30156, 'Tatatila', 30),
(30157, 'Castillo de Teayo', 30),
(30158, 'Tecolutla', 30),
(30159, 'Tehuipango', 30),
(30160, 'Álamo Temapache', 30),
(30161, 'Tempoal', 30),
(30162, 'Tenampa', 30),
(30163, 'Tenochtitlán', 30),
(30164, 'Teocelo', 30),
(30165, 'Tepatlaxco', 30),
(30166, 'Tepetlán', 30),
(30167, 'Tepetzintla', 30),
(30168, 'Tequila', 30),
(30169, 'José Azueta', 30),
(30170, 'Texcatepec', 30),
(30171, 'Texhuacán', 30),
(30172, 'Texistepec', 30),
(30173, 'Tezonapa', 30),
(30174, 'Tierra Blanca', 30),
(30175, 'Tihuatlán', 30),
(30176, 'Tlacojalpan', 30),
(30177, 'Tlacolulan', 30),
(30178, 'Tlacotalpan', 30),
(30179, 'Tlacotepec de Mejía', 30),
(30180, 'Tlachichilco', 30),
(30181, 'Tlalixcoyan', 30),
(30182, 'Tlalnelhuayocan', 30),
(30183, 'Tlapacoyan', 30),
(30184, 'Tlaquilpa', 30),
(30185, 'Tlilapan', 30),
(30186, 'Tomatlán', 30),
(30187, 'Tonayán', 30),
(30188, 'Totutla', 30),
(30189, 'Tuxpan', 30),
(30190, 'Tuxtilla', 30),
(30191, 'Ursulo Galván', 30),
(30192, 'Vega de Alatorre', 30),
(30193, 'Veracruz', 30),
(30194, 'Villa Aldama', 30),
(30195, 'Xoxocotla', 30),
(30196, 'Yanga', 30),
(30197, 'Yecuatla', 30),
(30198, 'Zacualpan', 30),
(30199, 'Zaragoza', 30),
(30200, 'Zentla', 30),
(30201, 'Zongolica', 30),
(30202, 'Zontecomatlán de López y Fuentes', 30),
(30203, 'Zozocolco de Hidalgo', 30),
(30204, 'Agua Dulce', 30),
(30205, 'El Higo', 30),
(30206, 'Nanchital de Lázaro Cárdenas del Río', 30),
(30207, 'Tres Valles', 30),
(30208, 'Carlos A. Carrillo', 30),
(30209, 'Tatahuicapan de Juárez', 30),
(30210, 'Uxpanapa', 30),
(30211, 'San Rafael', 30),
(30212, 'Santiago Sochiapan', 30),
(31001, 'Abalá', 31),
(31002, 'Acanceh', 31),
(31003, 'Akil', 31),
(31004, 'Baca', 31),
(31005, 'Bokobá', 31),
(31006, 'Buctzotz', 31),
(31007, 'Cacalchén', 31),
(31008, 'Calotmul', 31),
(31009, 'Cansahcab', 31),
(31010, 'Cantamayec', 31),
(31011, 'Celestún', 31),
(31012, 'Cenotillo', 31),
(31013, 'Conkal', 31),
(31014, 'Cuncunul', 31),
(31015, 'Cuzamá', 31),
(31016, 'Chacsinkín', 31),
(31017, 'Chankom', 31),
(31018, 'Chapab', 31),
(31019, 'Chemax', 31),
(31020, 'Chicxulub Pueblo', 31),
(31021, 'Chichimilá', 31),
(31022, 'Chikindzonot', 31),
(31023, 'Chocholá', 31),
(31024, 'Chumayel', 31),
(31025, 'Dzán', 31),
(31026, 'Dzemul', 31),
(31027, 'Dzidzantún', 31),
(31028, 'Dzilam de Bravo', 31),
(31029, 'Dzilam González', 31),
(31030, 'Dzitás', 31),
(31031, 'Dzoncauich', 31),
(31032, 'Espita', 31),
(31033, 'Halachó', 31),
(31034, 'Hocabá', 31),
(31035, 'Hoctún', 31),
(31036, 'Homún', 31),
(31037, 'Huhí', 31),
(31038, 'Hunucmá', 31),
(31039, 'Ixil', 31),
(31040, 'Izamal', 31),
(31041, 'Kanasín', 31),
(31042, 'Kantunil', 31),
(31043, 'Kaua', 31),
(31044, 'Kinchil', 31),
(31045, 'Kopomá', 31),
(31046, 'Mama', 31),
(31047, 'Maní', 31),
(31048, 'Maxcanú', 31),
(31049, 'Mayapán', 31),
(31050, 'Mérida', 31),
(31051, 'Mocochá', 31),
(31052, 'Motul', 31),
(31053, 'Muna', 31),
(31054, 'Muxupip', 31),
(31055, 'Opichén', 31),
(31056, 'Oxkutzcab', 31),
(31057, 'Panabá', 31),
(31058, 'Peto', 31),
(31059, 'Progreso', 31),
(31060, 'Quintana Roo', 31),
(31061, 'Río Lagartos', 31),
(31062, 'Sacalum', 31),
(31063, 'Samahil', 31),
(31064, 'Sanahcat', 31),
(31065, 'San Felipe', 31),
(31066, 'Santa Elena', 31),
(31067, 'Seyé', 31),
(31068, 'Sinanché', 31),
(31069, 'Sotuta', 31),
(31070, 'Sucilá', 31),
(31071, 'Sudzal', 31),
(31072, 'Suma', 31),
(31073, 'Tahdziú', 31),
(31074, 'Tahmek', 31),
(31075, 'Teabo', 31),
(31076, 'Tecoh', 31),
(31077, 'Tekal de Venegas', 31),
(31078, 'Tekantó', 31),
(31079, 'Tekax', 31),
(31080, 'Tekit', 31),
(31081, 'Tekom', 31),
(31082, 'Telchac Pueblo', 31),
(31083, 'Telchac Puerto', 31),
(31084, 'Temax', 31),
(31085, 'Temozón', 31),
(31086, 'Tepakán', 31),
(31087, 'Tetiz', 31),
(31088, 'Teya', 31),
(31089, 'Ticul', 31),
(31090, 'Timucuy', 31),
(31091, 'Tinum', 31),
(31092, 'Tixcacalcupul', 31),
(31093, 'Tixkokob', 31),
(31094, 'Tixmehuac', 31),
(31095, 'Tixpéhual', 31),
(31096, 'Tizimín', 31),
(31097, 'Tunkás', 31),
(31098, 'Tzucacab', 31),
(31099, 'Uayma', 31),
(31100, 'Ucú', 31),
(31101, 'Umán', 31),
(31102, 'Valladolid', 31),
(31103, 'Xocchel', 31),
(31104, 'Yaxcabá', 31),
(31105, 'Yaxkukul', 31),
(31106, 'Yobaín', 31),
(32001, 'Apozol', 32),
(32002, 'Apulco', 32),
(32003, 'Atolinga', 32),
(32004, 'Benito Juárez', 32),
(32005, 'Calera', 32),
(32006, 'Cañitas de Felipe Pescador', 32),
(32007, 'Concepción del Oro', 32),
(32008, 'Cuauhtémoc', 32),
(32009, 'Chalchihuites', 32),
(32010, 'Fresnillo', 32),
(32011, 'Trinidad García de la Cadena', 32),
(32012, 'Genaro Codina', 32),
(32013, 'General Enrique Estrada', 32),
(32014, 'General Francisco R. Murguía', 32),
(32015, 'El Plateado de Joaquín Amaro', 32),
(32016, 'General Pánfilo Natera', 32),
(32017, 'Guadalupe', 32),
(32018, 'Huanusco', 32),
(32019, 'Jalpa', 32),
(32020, 'Jerez', 32),
(32021, 'Jiménez del Teul', 32),
(32022, 'Juan Aldama', 32),
(32023, 'Juchipila', 32),
(32024, 'Loreto', 32),
(32025, 'Luis Moya', 32),
(32026, 'Mazapil', 32),
(32027, 'Melchor Ocampo', 32),
(32028, 'Mezquital del Oro', 32),
(32029, 'Miguel Auza', 32),
(32030, 'Momax', 32),
(32031, 'Monte Escobedo', 32),
(32032, 'Morelos', 32),
(32033, 'Moyahua de Estrada', 32),
(32034, 'Nochistlán de Mejía', 32),
(32035, 'Noria de Ángeles', 32),
(32036, 'Ojocaliente', 32),
(32037, 'Pánuco', 32),
(32038, 'Pinos', 32),
(32039, 'Río Grande', 32),
(32040, 'Sain Alto', 32),
(32041, 'El Salvador', 32),
(32042, 'Sombrerete', 32),
(32043, 'Susticacán', 32),
(32044, 'Tabasco', 32),
(32045, 'Tepechitlán', 32),
(32046, 'Tepetongo', 32),
(32047, 'Teúl de González Ortega', 32),
(32048, 'Tlaltenango de Sánchez Román', 32),
(32049, 'Valparaíso', 32),
(32050, 'Vetagrande', 32),
(32051, 'Villa de Cos', 32),
(32052, 'Villa García', 32),
(32053, 'Villa González Ortega', 32),
(32054, 'Villa Hidalgo', 32),
(32055, 'Villanueva', 32),
(32056, 'Zacatecas', 32),
(32057, 'Trancoso', 32),
(32058, 'Santa María de la Paz', 32);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago_solicitud`
--

CREATE TABLE `pago_solicitud` (
  `id` int(11) NOT NULL,
  `id_solicitud` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` varchar(20) NOT NULL,
  `monto` float NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `observaciones` text DEFAULT NULL,
  `estatus` enum('Pendiente','Pagado','No pagado') NOT NULL DEFAULT 'Pendiente',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pago_solicitud`
--

INSERT INTO `pago_solicitud` (`id`, `id_solicitud`, `fecha`, `hora`, `monto`, `descripcion`, `observaciones`, `estatus`, `created_at`, `updated_at`) VALUES
(9, 58, '2025-05-16', '10:00', 23423, 'PRIMER PAGO', 'Pagado', 'Pagado', '2025-05-15 15:23:28', '2025-05-15 15:38:51'),
(10, 58, '2025-05-30', '10:00', 65456, 'SEGUNDO PAGO', 'sadasdasdas', 'Pagado', '2025-05-15 15:23:28', '2025-05-22 19:47:55'),
(11, 58, '2025-05-16', '10:00', 23423, 'PRIMER PAGO', 'pagado', 'Pagado', '2025-05-15 15:25:33', '2025-05-22 20:18:37'),
(12, 58, '2025-05-30', '10:00', 65456, 'SEGUNDO PAGO', 'pagado', 'Pagado', '2025-05-15 15:25:33', '2025-05-22 20:19:08'),
(13, 58, '2025-05-16', '10:00', 23423, 'PRIMER PAGO', 'asdasd', 'Pagado', '2025-05-15 15:26:36', '2025-05-22 20:19:14'),
(14, 58, '2025-05-30', '10:00', 65456, 'SEGUNDO PAGO', 'asdasdasd', 'Pagado', '2025-05-15 15:26:36', '2025-05-22 20:19:18'),
(15, 58, '2025-05-16', '10:00', 21312, 'PRIMER PAGO', 'asdasdas', 'Pagado', '2025-05-15 17:17:35', '2025-05-22 20:19:23'),
(16, 58, '2025-05-31', '10:00', 32423, 'SEGUNDO PAGO', 'asdasd', 'Pagado', '2025-05-15 17:17:35', '2025-05-22 20:19:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paises`
--

CREATE TABLE `paises` (
  `id` int(3) NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `paises`
--

INSERT INTO `paises` (`id`, `nombre`) VALUES
(1, 'México'),
(1, 'México'),
(1, 'México');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `guard_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'ver-rol', 'web', '2023-05-10 20:28:26', '2023-05-10 20:28:26'),
(2, 'crear-rol', 'web', '2023-05-10 20:28:26', '2023-05-10 20:28:26'),
(3, 'editar-rol', 'web', '2023-05-10 20:28:26', '2023-05-10 20:28:26'),
(4, 'borrar-rol', 'web', '2023-05-10 20:28:26', '2023-05-10 20:28:26'),
(5, 'ver-abogado', 'web', '2023-05-10 20:28:26', '2023-05-10 20:28:26'),
(6, 'crear-abogado', 'web', '2023-05-10 20:28:26', '2023-05-10 20:28:26'),
(7, 'editar-abogado', 'web', '2023-05-10 20:28:26', '2023-05-10 20:28:26'),
(8, 'borrar-abogado', 'web', '2023-05-10 20:28:26', '2023-05-10 20:28:26'),
(9, 'ver-usuario', 'web', '2023-05-10 20:28:26', '2023-05-10 20:28:26'),
(10, 'crear-usuario', 'web', '2023-05-10 20:28:26', '2023-05-10 20:28:26'),
(11, 'editar-usuario', 'web', '2023-05-10 20:28:26', '2023-05-10 20:28:26'),
(12, 'borrar-usuario', 'web', '2023-05-10 20:28:26', '2023-05-10 20:28:26'),
(13, 'ver-curso', 'web', '2024-06-06 03:38:07', '2024-06-06 03:38:11'),
(14, 'crear-curso', 'web', '2024-06-06 03:38:24', '2024-06-06 03:38:24'),
(15, 'editar-curso', 'web', '2024-06-06 03:38:24', '2024-06-06 03:38:24'),
(16, 'borrar-curso', 'web', '2024-06-06 03:38:24', '2024-06-06 03:38:24'),
(17, 'aceptar-persona', 'web', '2024-06-06 03:38:24', '2024-06-06 03:38:24'),
(18, 'ver-miscapacitaciones', 'web', '2024-06-12 22:42:28', '2024-06-12 22:42:29'),
(19, 'crear-miscapacitaciones', 'web', '2024-06-12 22:43:03', '2024-06-12 22:43:03'),
(20, 'ver-seer', 'web', '2024-08-29 22:53:14', '2024-08-29 22:53:21'),
(21, 'crear-seer', 'web', '2024-08-29 22:53:26', '2024-08-29 22:53:26'),
(22, 'editar-seer', 'web', '2024-08-29 22:53:48', '2024-08-29 22:53:48'),
(23, 'ver-estaditica', 'web', '2024-09-02 22:46:16', '2024-09-24 00:46:24'),
(24, 'crear-turnos', 'web', '2024-10-05 03:22:36', '2024-10-05 03:22:36'),
(25, 'ver-turno', 'web', '2024-10-05 03:22:36', '2024-10-05 03:22:36'),
(26, 'ver-reporte-estadistica', 'web', '2024-11-21 23:46:49', '2024-11-21 23:46:49'),
(27, 'ver-estadistica', 'web', '2024-11-21 23:47:01', '2024-11-21 23:47:02'),
(28, 'ver-registro', 'web', '2024-11-23 02:03:19', '2024-11-23 02:03:19'),
(29, 'crear-registro', 'web', '2024-11-23 03:03:18', '2024-11-23 02:05:18'),
(30, 'editar-registro', 'web', '2024-11-23 02:04:29', '2024-11-23 02:04:52'),
(31, 'ver_solicitante', 'web', '2025-04-30 08:53:36', '2025-04-30 08:53:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `email` varchar(25) NOT NULL,
  `cargo` varchar(50) NOT NULL,
  `area_adcripcion` varchar(50) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `estudio_maximo` text NOT NULL,
  `tilulo_universitario` text NOT NULL,
  `especialidades` text DEFAULT NULL,
  `diplomados` text DEFAULT NULL,
  `seminarios` text DEFAULT NULL,
  `cursos` text DEFAULT NULL,
  `acciones_desarrollo` text DEFAULT NULL,
  `estatus` enum('Aceptado','Rechazado','Pendiente') NOT NULL DEFAULT 'Pendiente',
  `observaciones` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pre_registro`
--

CREATE TABLE `pre_registro` (
  `id` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `rfc` varchar(13) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pre_registro`
--

INSERT INTO `pre_registro` (`id`, `nombre`, `rfc`, `telefono`, `created_at`, `updated_at`) VALUES
(1, 'INTRODUCCIÓN A EXCEL', 'SOVG800112J64', '0', '2025-05-12 17:04:46', '2025-05-12 17:04:46'),
(2, 'ZXC,M,ZXMC,MZXC ZXC,MNZMXCNM', 'SDFSDFSDFSDFS', '0', '2025-05-12 19:16:17', '2025-05-12 19:16:17'),
(3, 'SALVADOR GONZALEZ ROBLES', 'SOVG800112J64', '4431124578', '2025-05-12 19:24:25', '2025-05-12 19:24:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `guard_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(16, 'Super Usuario', 'web', '2024-06-04 07:08:30', '2024-06-04 07:08:30'),
(17, 'Administrador', 'web', '2024-06-04 07:31:03', '2024-06-04 07:31:03'),
(18, 'Capacitacion Admin', 'web', '2024-06-06 09:40:13', '2024-06-06 09:40:13'),
(19, 'Capacitacion Usuario', 'web', '2024-06-06 09:40:31', '2024-06-06 09:40:31'),
(20, 'Auxiliar', 'web', '2024-06-06 10:36:06', '2024-06-06 10:36:06'),
(21, 'Conciliador', 'web', '2024-08-30 04:55:33', '2024-08-30 05:07:33'),
(22, 'Notificador', 'web', '2024-08-30 05:12:23', '2024-08-30 05:12:23'),
(23, 'Delegado', 'web', '2024-08-30 05:17:22', '2024-08-30 05:17:22'),
(27, 'Estadistica', 'web', '2024-09-03 06:46:57', '2024-09-03 06:46:57'),
(28, 'Turnos', 'web', '2024-10-16 00:50:17', '2024-10-16 00:50:17'),
(29, 'Registro', 'web', '2024-11-23 02:04:55', '2024-11-23 02:04:55'),
(30, 'Administrador Solicitante', 'web', '2024-12-24 07:32:32', '2025-05-07 17:11:36'),
(31, 'Excepcion', 'web', '2025-01-24 22:38:05', '2025-01-24 22:38:05'),
(32, 'Enlace', 'web', '2025-02-14 04:48:16', '2025-02-14 04:48:16'),
(35, 'Solicitante', 'web', '2025-04-30 08:52:37', '2025-04-30 08:52:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 16),
(1, 17),
(2, 16),
(2, 17),
(3, 16),
(4, 16),
(5, 16),
(5, 17),
(5, 20),
(5, 21),
(5, 22),
(5, 31),
(5, 32),
(6, 16),
(6, 17),
(6, 20),
(6, 21),
(6, 22),
(6, 31),
(6, 32),
(7, 16),
(7, 20),
(7, 21),
(7, 22),
(7, 31),
(7, 32),
(8, 16),
(8, 20),
(8, 21),
(8, 22),
(8, 31),
(9, 16),
(9, 17),
(10, 16),
(10, 17),
(11, 16),
(12, 16),
(13, 16),
(13, 18),
(13, 19),
(13, 20),
(14, 16),
(14, 18),
(15, 16),
(15, 18),
(16, 16),
(16, 18),
(17, 16),
(17, 18),
(18, 16),
(18, 18),
(18, 20),
(18, 31),
(19, 16),
(19, 18),
(19, 20),
(19, 31),
(20, 16),
(20, 20),
(20, 21),
(20, 22),
(20, 23),
(20, 31),
(20, 32),
(21, 16),
(21, 20),
(21, 21),
(21, 22),
(21, 23),
(21, 31),
(21, 32),
(22, 16),
(22, 20),
(22, 21),
(22, 22),
(22, 23),
(22, 31),
(22, 32),
(23, 16),
(23, 27),
(23, 32),
(24, 16),
(24, 28),
(25, 16),
(25, 28),
(25, 32),
(26, 16),
(26, 32),
(27, 16),
(27, 32),
(28, 16),
(28, 29),
(28, 32),
(29, 16),
(29, 29),
(30, 16),
(30, 29),
(31, 30),
(31, 35);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sedes`
--

CREATE TABLE `sedes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `oficina_apoyo` int(11) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sedes`
--

INSERT INTO `sedes` (`id`, `nombre`, `oficina_apoyo`, `create_at`, `update_at`) VALUES
(1, 'Morelia', 0, '2024-09-02 19:22:28', '2024-09-02 19:22:28'),
(2, 'Zitácuaro', 1, '2024-09-02 19:22:28', '2024-09-02 19:22:28'),
(3, 'Uruapan', 0, '2024-09-02 20:06:48', '2024-09-02 20:06:48'),
(4, 'Lázaro Cárdenas', 3, '2024-09-02 20:06:48', '2024-09-02 20:06:48'),
(5, 'Zamora', 0, '2024-09-02 20:07:20', '2024-09-02 20:07:20'),
(6, 'Sahuayo', 5, '2024-09-02 20:07:20', '2024-09-02 20:07:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seer_asesorias`
--

CREATE TABLE `seer_asesorias` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `fecha` date NOT NULL,
  `sexo` varchar(10) NOT NULL,
  `delegacion` varchar(30) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `seer_asesorias`
--

INSERT INTO `seer_asesorias` (`id`, `id_usuario`, `nombre`, `fecha`, `sexo`, `delegacion`, `created_at`, `updated_at`) VALUES
(1, 3, 'Irvin Samuel Bedoll Mota', '2025-02-21', 'Hombre', 'Morelia', '2025-02-21 17:51:59', '2025-02-21 17:51:59'),
(2, 3, 'irvin samuel bedolla mota', '2025-04-04', 'Mujer', 'Morelia', '2025-04-04 23:48:38', '2025-04-04 23:48:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seer_auxiliares`
--

CREATE TABLE `seer_auxiliares` (
  `id` int(11) NOT NULL,
  `id_solicitud` int(11) NOT NULL,
  `sexo` enum('H','M','No Binario','Prefiero no decir','Otro') NOT NULL,
  `tipo_persona` enum('Fisica','Moral') DEFAULT NULL,
  `motivo` enum('Despido','Pago de prestaciones','Recision de la relación laboral','Derecho de preferencia','Derecho de antiguedad','Derecho de ascesnso','Terminación voluntaria de relación laboral','Supuestos de Excepción 685-Ter LFT','Otros') NOT NULL,
  `monto` float DEFAULT NULL,
  `actividad_economica` varchar(100) NOT NULL,
  `estatus` enum('Pendiente','Parcial','Cumplido') NOT NULL,
  `notificacion` enum('Centro','Trabajador','Ambos','Exhorto') NOT NULL,
  `tipo_solicitud` enum('Solicitud','Ratificación') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `seer_auxiliares`
--

INSERT INTO `seer_auxiliares` (`id`, `id_solicitud`, `sexo`, `tipo_persona`, `motivo`, `monto`, `actividad_economica`, `estatus`, `notificacion`, `tipo_solicitud`, `created_at`, `updated_at`) VALUES
(22, 24, 'H', NULL, 'Despido', NULL, 'DESARROLLADOR', 'Pendiente', 'Trabajador', 'Solicitud', '2025-02-14 15:51:59', '2025-02-26 16:13:07'),
(23, 25, 'H', NULL, 'Despido', NULL, 'DESARROLLADOR', 'Pendiente', 'Centro', 'Solicitud', '2025-02-14 16:07:33', '2025-02-14 16:07:33'),
(24, 26, 'H', NULL, 'Despido', NULL, 'DESARROLLADOR', 'Pendiente', 'Trabajador', 'Solicitud', '2025-02-14 16:19:00', '2025-02-14 16:19:00'),
(25, 27, 'M', NULL, 'Recision de la relación laboral', NULL, 'DESARROLLADOR', 'Pendiente', 'Trabajador', 'Solicitud', '2025-02-19 20:45:54', '2025-02-19 20:45:54'),
(26, 28, 'H', NULL, 'Despido', NULL, 'DESARROLLADOR', 'Pendiente', 'Centro', 'Solicitud', '2025-02-19 21:01:08', '2025-02-19 21:01:08'),
(27, 30, 'H', NULL, 'Terminación voluntaria de relación laboral', NULL, 'ABOGADO', 'Cumplido', 'Centro', 'Ratificación', '2025-02-21 17:57:43', '2025-02-21 17:57:43'),
(28, 31, 'H', NULL, 'Despido', NULL, 'DESARROLLADOR', 'Pendiente', 'Centro', 'Solicitud', '2025-02-26 16:10:37', '2025-02-26 16:10:37'),
(29, 32, 'H', NULL, 'Terminación voluntaria de relación laboral', NULL, 'EAWE2AE2', 'Pendiente', 'Centro', 'Ratificación', '2025-03-03 19:49:01', '2025-03-03 19:49:01'),
(32, 35, 'H', NULL, 'Despido', NULL, 'DESARROLLADOR', 'Pendiente', 'Centro', 'Solicitud', '2025-03-05 20:31:00', '2025-03-05 20:31:00'),
(33, 36, 'M', NULL, 'Despido', NULL, 'ABOGADO', 'Pendiente', 'Centro', 'Solicitud', '2025-03-14 19:48:13', '2025-03-14 19:48:13'),
(34, 1228, 'M', NULL, 'Pago de prestaciones', NULL, 'COMERCIO', 'Pendiente', 'Centro', 'Solicitud', '2025-04-02 22:13:02', '2025-04-02 22:13:02'),
(35, 37, 'H', NULL, 'Pago de prestaciones', 0, 'COMERCIO', 'Pendiente', 'Centro', 'Solicitud', '2025-04-03 00:29:29', '2025-04-03 00:29:29'),
(36, 38, 'H', NULL, 'Pago de prestaciones', 0, 'COMERCIO1', 'Pendiente', 'Trabajador', 'Solicitud', '2025-04-03 01:38:27', '2025-04-03 02:29:30'),
(37, 39, 'H', NULL, 'Recision de la relación laboral', 0, 'COMERCIO Y REPOSTERIA', 'Pendiente', 'Centro', 'Solicitud', '2025-04-03 22:01:25', '2025-04-03 22:09:23'),
(38, 40, 'M', NULL, 'Terminación voluntaria de relación laboral', 23.34, 'COMERCIO', 'Pendiente', 'Centro', 'Ratificación', '2025-04-04 23:13:16', '2025-04-04 23:13:16'),
(39, 41, 'M', NULL, 'Terminación voluntaria de relación laboral', 65234.2, 'COMERCIO', 'Pendiente', 'Centro', 'Ratificación', '2025-04-05 00:49:01', '2025-04-05 00:49:01'),
(40, 42, 'H', NULL, 'Despido', 0, 'ADMINISTRATIVO', 'Pendiente', 'Trabajador', 'Ratificación', '2025-04-05 00:52:49', '2025-04-05 00:52:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seer_citados`
--

CREATE TABLE `seer_citados` (
  `id` int(11) NOT NULL,
  `id_solicitud` int(11) NOT NULL,
  `tipo_persona` enum('Fisica','Moral') DEFAULT NULL,
  `curp` varchar(18) DEFAULT NULL,
  `rfc` varchar(13) DEFAULT NULL,
  `nombre` text DEFAULT NULL,
  `primer_apellido` varchar(50) DEFAULT NULL,
  `segundo_apellido` varchar(50) DEFAULT '0',
  `fecha_nacimiento` date DEFAULT NULL,
  `estatus` enum('Notificada','No notificada','Pendiente','Exhorto','Juez') NOT NULL DEFAULT 'Pendiente',
  `edad` int(11) DEFAULT NULL,
  `sexo` enum('H','M','NB','LGBTTTIQ') DEFAULT NULL,
  `nacionalidad` enum('Mexicana','Otra') DEFAULT NULL,
  `estado_solicitante` int(11) DEFAULT NULL,
  `traductor` int(11) DEFAULT 0 COMMENT '1 es Si y 0 no',
  `lenguaje` text DEFAULT NULL,
  `colonia` varchar(50) NOT NULL,
  `cp` int(11) NOT NULL,
  `calle1` varchar(50) DEFAULT NULL,
  `calle2` varchar(50) DEFAULT NULL,
  `n_ext` varchar(10) NOT NULL,
  `n_int` varchar(10) DEFAULT NULL,
  `calle` varchar(50) NOT NULL,
  `tipo_vialidad` varchar(40) NOT NULL,
  `referencia` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `seer_citados`
--

INSERT INTO `seer_citados` (`id`, `id_solicitud`, `tipo_persona`, `curp`, `rfc`, `nombre`, `primer_apellido`, `segundo_apellido`, `fecha_nacimiento`, `estatus`, `edad`, `sexo`, `nacionalidad`, `estado_solicitante`, `traductor`, `lenguaje`, `colonia`, `cp`, `calle1`, `calle2`, `n_ext`, `n_int`, `calle`, `tipo_vialidad`, `referencia`, `created_at`, `updated_at`) VALUES
(88, 138, NULL, 'GUML660823MMNRNR07', NULL, NULL, 'SAMUEL', 'IRVIN', NULL, 'Pendiente', NULL, NULL, NULL, 1, 0, NULL, 'Lomas del durazno', 58090, NULL, NULL, '208', NULL, 'Combate de Peñuelas', 'Calle', 'cseadaec', '2025-05-27 16:42:01', '2025-05-27 16:42:01'),
(91, 140, NULL, NULL, NULL, NULL, NULL, '0', NULL, 'Pendiente', NULL, NULL, NULL, 1, 0, NULL, 'Lomas del durazno', 58090, NULL, NULL, '208', NULL, 'Combate de Peñuelas', 'Calle', 'dwqdwq', '2025-05-27 17:09:55', '2025-05-27 17:09:55'),
(92, 140, NULL, NULL, NULL, NULL, NULL, '0', NULL, 'Pendiente', NULL, NULL, NULL, 6, 0, NULL, 'Lomas del durazno', 58090, NULL, NULL, '208', NULL, 'Combate de Peñuelas', 'Calzada', 'dwqdwq', '2025-05-27 17:09:55', '2025-05-27 17:09:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seer_colectivas`
--

CREATE TABLE `seer_colectivas` (
  `id` int(11) NOT NULL,
  `conciliador` int(11) NOT NULL,
  `solicitante` varchar(40) NOT NULL,
  `fecha` date NOT NULL,
  `NUE` varchar(18) NOT NULL,
  `citado` varchar(30) NOT NULL,
  `juzgado` varchar(40) NOT NULL,
  `estado` varchar(40) NOT NULL,
  `delegacion` varchar(10) NOT NULL DEFAULT 'Morelia',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seer_conciliadores`
--

CREATE TABLE `seer_conciliadores` (
  `id` int(11) NOT NULL,
  `id_solicitud` int(11) NOT NULL,
  `numero_audiencia` varchar(10) DEFAULT NULL,
  `estatus_conciliacion` enum('Conciliacion','No conciliacion','Archivado por incomparecencia','Regenerada','Incompetencia') CHARACTER SET utf8mb4 COLLATE utf8mb4_estonian_ci NOT NULL,
  `numero_audiencias` int(11) NOT NULL,
  `monto` float NOT NULL,
  `cumplimiento_pago` text DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `multa` enum('Si','No') NOT NULL,
  `monto_multa` float DEFAULT NULL,
  `rfc` varchar(13) NOT NULL,
  `NSS` varchar(18) NOT NULL,
  `tipo` enum('Presencial','Virtual') NOT NULL,
  `motivo_archivo` enum('Incompetencia','Falta de interes') NOT NULL,
  `fecha_reprogracion` date DEFAULT NULL,
  `fecha_conclucion` date DEFAULT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `updated_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `seer_conciliadores`
--

INSERT INTO `seer_conciliadores` (`id`, `id_solicitud`, `numero_audiencia`, `estatus_conciliacion`, `numero_audiencias`, `monto`, `cumplimiento_pago`, `observaciones`, `multa`, `monto_multa`, `rfc`, `NSS`, `tipo`, `motivo_archivo`, `fecha_reprogracion`, `fecha_conclucion`, `created_at`, `updated_at`) VALUES
(9, 24, '5201/2024', 'Conciliacion', 2, 23434, '', NULL, 'No', NULL, 'AAAA000000AAA', 'Si', 'Presencial', 'Falta de interes', '0000-00-00', '2025-02-26', '2025-02-26', '2025-02-26'),
(10, 39, NULL, 'Archivado por incomparecencia', 1, 2332.44, NULL, NULL, 'No', NULL, 'BEMI890329S49', 'Si', 'Presencial', 'Falta de interes', NULL, '2025-04-03', '2025-04-03', '2025-04-03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seer_convenios`
--

CREATE TABLE `seer_convenios` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `NUE` varchar(18) NOT NULL,
  `monto` float NOT NULL,
  `tipo_pago` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `seer_convenios`
--

INSERT INTO `seer_convenios` (`id`, `user_id`, `fecha`, `NUE`, `monto`, `tipo_pago`, `created_at`, `updated_at`) VALUES
(3, 3, '2025-02-21', 'MOR/CI/2025/000111', 10000, 'Efectivo', '2025-02-21 21:31:49', '2025-02-21 21:31:49'),
(4, 3, '2025-04-04', 'MOR/CI/2025/000111', 2000.23, 'Efectivo', '2025-04-04 23:46:14', '2025-04-04 23:46:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seer_general`
--

CREATE TABLE `seer_general` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL DEFAULT current_timestamp(),
  `fecha_conflicto` date DEFAULT NULL,
  `fecha_confirmacion` date DEFAULT NULL,
  `fecha_terminacion` date DEFAULT NULL,
  `NUE` varchar(18) DEFAULT NULL,
  `id_rama` int(11) NOT NULL,
  `actividad` text NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `conciliador_id` int(11) DEFAULT NULL,
  `validado_conciliador` enum('Pendiente','Guardado') NOT NULL DEFAULT 'Pendiente',
  `delegacion` varchar(20) NOT NULL,
  `curp` varchar(18) DEFAULT NULL,
  `tipo` enum('Presencial','Virtual') NOT NULL,
  `tipo_solicitud` enum('1','2','3','') DEFAULT NULL,
  `validacion` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `seer_general`
--

INSERT INTO `seer_general` (`id`, `fecha`, `fecha_conflicto`, `fecha_confirmacion`, `fecha_terminacion`, `NUE`, `id_rama`, `actividad`, `user_id`, `conciliador_id`, `validado_conciliador`, `delegacion`, `curp`, `tipo`, `tipo_solicitud`, `validacion`, `created_at`, `updated_at`) VALUES
(126, '2025-04-28', NULL, NULL, NULL, NULL, 1, 'VENTA DE FARMACEUTICOS', NULL, NULL, 'Pendiente', '16006', NULL, 'Presencial', NULL, 0, '2025-04-28 17:28:59', '2025-04-28 17:28:59'),
(127, '2025-04-28', NULL, NULL, NULL, NULL, 4, 'VENTA DE FARMACEUTICOS', NULL, NULL, 'Pendiente', '16004', NULL, 'Presencial', NULL, 0, '2025-04-28 18:08:49', '2025-04-28 18:08:49'),
(128, '2025-05-06', NULL, NULL, NULL, NULL, 10, 'ABOGADO', NULL, NULL, 'Pendiente', '16002', NULL, 'Presencial', NULL, 0, '2025-05-06 17:44:19', '2025-05-06 17:44:19'),
(129, '2025-05-07', NULL, NULL, NULL, NULL, 16, 'ABOGADO', NULL, NULL, 'Pendiente', '16004', NULL, 'Presencial', '1', 0, '2025-05-07 20:22:57', '2025-05-07 20:22:57'),
(130, '2025-05-07', NULL, NULL, NULL, NULL, 16, 'ABOGADO', NULL, NULL, 'Pendiente', '16004', NULL, 'Presencial', '1', 0, '2025-05-07 20:23:31', '2025-05-07 20:23:31'),
(131, '2025-05-07', NULL, NULL, NULL, NULL, 16, 'ABOGADO', NULL, NULL, 'Pendiente', '16004', NULL, 'Presencial', '1', 0, '2025-05-07 20:27:28', '2025-05-07 20:27:28'),
(132, '2025-05-07', NULL, NULL, NULL, NULL, 16, 'ABOGADO', NULL, NULL, 'Pendiente', '16004', NULL, 'Presencial', '1', 0, '2025-05-07 20:28:43', '2025-05-07 20:28:43'),
(133, '2025-05-07', NULL, NULL, NULL, NULL, 16, 'ABOGADO', NULL, NULL, 'Pendiente', '16004', NULL, 'Presencial', '1', 0, '2025-05-07 20:29:43', '2025-05-07 20:29:43'),
(134, '2025-05-07', NULL, NULL, NULL, NULL, 16, 'ABOGADO', NULL, NULL, 'Pendiente', '16004', NULL, 'Presencial', '1', 0, '2025-05-07 20:31:15', '2025-05-07 20:31:15'),
(135, '2025-05-07', NULL, NULL, NULL, NULL, 16, 'ABOGADO', NULL, NULL, 'Pendiente', '16004', NULL, 'Presencial', '1', 0, '2025-05-07 20:32:09', '2025-05-07 20:32:09'),
(136, '2025-05-07', NULL, NULL, NULL, NULL, 16, 'ABOGADO', NULL, NULL, 'Pendiente', '16004', NULL, 'Presencial', '1', 0, '2025-05-07 20:32:51', '2025-05-07 20:32:51'),
(137, '2025-05-07', NULL, NULL, NULL, NULL, 16, 'ABOGADO', NULL, NULL, 'Pendiente', '16004', NULL, 'Presencial', '1', 0, '2025-05-07 20:36:10', '2025-05-07 20:36:10'),
(138, '2025-05-07', NULL, NULL, NULL, 'MOR/SOL/2025/00143', 16, 'ABOGADO', NULL, NULL, 'Pendiente', 'Morelia', NULL, 'Presencial', '1', 0, '2025-05-07 20:40:33', '2025-05-27 16:42:01'),
(139, '2025-05-07', NULL, NULL, NULL, NULL, 16, 'ABOGADO', NULL, NULL, 'Pendiente', '16004', NULL, 'Presencial', '1', 0, '2025-05-07 20:41:19', '2025-05-07 20:41:19'),
(140, '2025-05-07', NULL, NULL, NULL, 'MOR/SOL/2025/00143', 13, 'ABOGADO', NULL, NULL, 'Pendiente', 'Morelia', NULL, 'Presencial', '1', 0, '2025-05-07 21:24:16', '2025-05-27 17:09:55'),
(141, '2025-05-09', NULL, NULL, NULL, NULL, 12, 'COMERCIO', NULL, NULL, 'Pendiente', 'Morelia', NULL, 'Presencial', '1', 0, '2025-05-09 16:56:48', '2025-05-09 16:56:48'),
(142, '2025-05-21', NULL, NULL, NULL, NULL, 13, 'ABOGADO', NULL, NULL, 'Pendiente', 'Morelia', NULL, 'Presencial', '1', 0, '2025-05-21 21:37:33', '2025-05-21 21:37:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seer_motivos`
--

CREATE TABLE `seer_motivos` (
  `id` int(11) NOT NULL,
  `id_solicitud` int(11) NOT NULL,
  `id_motivo` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `seer_motivos`
--

INSERT INTO `seer_motivos` (`id`, `id_solicitud`, `id_motivo`, `created_at`, `updated_at`) VALUES
(1, 43, 1, '2025-04-15 20:00:08', '2025-04-15 20:00:08'),
(2, 44, 1, '2025-04-15 20:04:03', '2025-04-15 20:04:03'),
(3, 45, 3, '2025-04-15 20:06:37', '2025-04-15 20:06:37'),
(4, 45, 5, '2025-04-15 20:06:37', '2025-04-15 20:06:37'),
(5, 46, 1, '2025-04-21 15:13:16', '2025-04-21 15:13:16'),
(6, 46, 4, '2025-04-21 15:13:16', '2025-04-21 15:13:16'),
(7, 47, 1, '2025-04-21 15:26:12', '2025-04-21 15:26:12'),
(8, 47, 4, '2025-04-21 15:26:12', '2025-04-21 15:26:12'),
(9, 48, 1, '2025-04-21 15:27:25', '2025-04-21 15:27:25'),
(10, 48, 4, '2025-04-21 15:27:25', '2025-04-21 15:27:25'),
(11, 49, 1, '2025-04-21 15:37:39', '2025-04-21 15:37:39'),
(12, 49, 4, '2025-04-21 15:37:39', '2025-04-21 15:37:39'),
(13, 50, 4, '2025-04-21 15:51:16', '2025-04-21 15:51:16'),
(14, 51, 4, '2025-04-21 15:51:50', '2025-04-21 15:51:50'),
(15, 52, 4, '2025-04-21 15:58:30', '2025-04-21 15:58:30'),
(16, 53, 4, '2025-04-21 16:02:33', '2025-04-21 16:02:33'),
(17, 54, 4, '2025-04-21 16:02:38', '2025-04-21 16:02:38'),
(18, 55, 4, '2025-04-21 16:03:02', '2025-04-21 16:03:02'),
(19, 56, 4, '2025-04-21 16:03:35', '2025-04-21 16:03:35'),
(20, 57, 4, '2025-04-21 16:04:34', '2025-04-21 16:04:34'),
(21, 58, 4, '2025-04-21 16:21:44', '2025-04-21 16:21:44'),
(22, 59, 3, '2025-04-21 16:38:25', '2025-04-21 16:38:25'),
(23, 60, 3, '2025-04-21 16:52:21', '2025-04-21 16:52:21'),
(24, 61, 6, '2025-04-21 16:54:47', '2025-04-21 16:54:47'),
(25, 62, 1, '2025-04-21 17:42:42', '2025-04-21 17:42:42'),
(26, 62, 5, '2025-04-21 17:42:42', '2025-04-21 17:42:42'),
(27, 62, 6, '2025-04-21 17:42:42', '2025-04-21 17:42:42'),
(28, 63, 1, '2025-04-21 17:51:41', '2025-04-21 17:51:41'),
(29, 63, 5, '2025-04-21 17:51:41', '2025-04-21 17:51:41'),
(30, 64, 1, '2025-04-21 17:52:30', '2025-04-21 17:52:30'),
(31, 64, 5, '2025-04-21 17:52:30', '2025-04-21 17:52:30'),
(32, 65, 1, '2025-04-21 17:53:54', '2025-04-21 17:53:54'),
(33, 65, 5, '2025-04-21 17:53:54', '2025-04-21 17:53:54'),
(34, 66, 1, '2025-04-21 17:54:07', '2025-04-21 17:54:07'),
(35, 66, 5, '2025-04-21 17:54:07', '2025-04-21 17:54:07'),
(36, 67, 1, '2025-04-21 17:55:25', '2025-04-21 17:55:25'),
(37, 67, 5, '2025-04-21 17:55:25', '2025-04-21 17:55:25'),
(38, 68, 1, '2025-04-21 17:55:41', '2025-04-21 17:55:41'),
(39, 68, 5, '2025-04-21 17:55:41', '2025-04-21 17:55:41'),
(40, 69, 1, '2025-04-21 17:56:04', '2025-04-21 17:56:04'),
(41, 69, 5, '2025-04-21 17:56:04', '2025-04-21 17:56:04'),
(42, 70, 1, '2025-04-21 17:56:46', '2025-04-21 17:56:46'),
(43, 70, 5, '2025-04-21 17:56:46', '2025-04-21 17:56:46'),
(44, 71, 1, '2025-04-21 17:58:34', '2025-04-21 17:58:34'),
(45, 72, 1, '2025-04-21 18:02:16', '2025-04-21 18:02:16'),
(46, 73, 1, '2025-04-21 18:02:24', '2025-04-21 18:02:24'),
(47, 74, 1, '2025-04-21 18:04:42', '2025-04-21 18:04:42'),
(48, 75, 1, '2025-04-21 20:37:11', '2025-04-21 20:37:11'),
(49, 75, 2, '2025-04-21 20:37:11', '2025-04-21 20:37:11'),
(50, 75, 5, '2025-04-21 20:37:11', '2025-04-21 20:37:11'),
(51, 76, 1, '2025-04-21 20:43:29', '2025-04-21 20:43:29'),
(52, 76, 3, '2025-04-21 20:43:29', '2025-04-21 20:43:29'),
(53, 76, 7, '2025-04-21 20:43:29', '2025-04-21 20:43:29'),
(54, 77, 1, '2025-04-21 22:58:05', '2025-04-21 22:58:05'),
(55, 77, 5, '2025-04-21 22:58:05', '2025-04-21 22:58:05'),
(56, 78, 1, '2025-04-22 19:37:51', '2025-04-22 19:37:51'),
(57, 78, 6, '2025-04-22 19:37:51', '2025-04-22 19:37:51'),
(58, 79, 1, '2025-04-22 21:08:35', '2025-04-22 21:08:35'),
(59, 79, 6, '2025-04-22 21:08:35', '2025-04-22 21:08:35'),
(60, 80, 1, '2025-04-22 22:03:44', '2025-04-22 22:03:44'),
(61, 80, 3, '2025-04-22 22:03:44', '2025-04-22 22:03:44'),
(62, 81, 1, '2025-04-23 16:50:14', '2025-04-23 16:50:14'),
(63, 82, 2, '2025-04-24 18:16:19', '2025-04-24 18:16:19'),
(64, 82, 3, '2025-04-24 18:16:19', '2025-04-24 18:16:19'),
(65, 129, 1, '2025-05-07 20:22:57', '2025-05-07 20:22:57'),
(66, 130, 1, '2025-05-07 20:23:31', '2025-05-07 20:23:31'),
(67, 131, 1, '2025-05-07 20:27:28', '2025-05-07 20:27:28'),
(68, 132, 1, '2025-05-07 20:28:43', '2025-05-07 20:28:43'),
(69, 133, 1, '2025-05-07 20:29:43', '2025-05-07 20:29:43'),
(70, 134, 1, '2025-05-07 20:31:15', '2025-05-07 20:31:15'),
(71, 135, 1, '2025-05-07 20:32:09', '2025-05-07 20:32:09'),
(72, 136, 1, '2025-05-07 20:32:51', '2025-05-07 20:32:51'),
(73, 137, 1, '2025-05-07 20:36:10', '2025-05-07 20:36:10'),
(75, 139, 1, '2025-05-07 20:41:19', '2025-05-07 20:41:19'),
(77, 141, 1, '2025-05-09 16:56:48', '2025-05-09 16:56:48'),
(78, 142, 1, '2025-05-21 21:37:33', '2025-05-21 21:37:33'),
(102, 140, 1, '2025-05-26 21:47:47', '2025-05-26 21:47:47'),
(103, 140, 6, '2025-05-26 21:47:47', '2025-05-26 21:47:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seer_solicitante`
--

CREATE TABLE `seer_solicitante` (
  `id` int(11) NOT NULL,
  `id_solicitud` int(11) NOT NULL,
  `tipo_persona` enum('Fisica','Moral') NOT NULL,
  `curp` varchar(18) NOT NULL,
  `nombre` varchar(65) NOT NULL,
  `rfc` varchar(13) NOT NULL,
  `sexo` enum('H','M','NC') NOT NULL,
  `nacionalidad` enum('Mexicana','Otra') NOT NULL,
  `estado` int(11) NOT NULL,
  `traductor` enum('Si','No') DEFAULT 'No',
  `lenguaje` varchar(40) DEFAULT NULL,
  `discapacidad` enum('Si','No') NOT NULL DEFAULT 'No',
  `tipo_discapacidad` varchar(50) DEFAULT NULL,
  `fecha_nacimiento` date NOT NULL,
  `edad` int(11) NOT NULL,
  `telefono1` varchar(10) NOT NULL,
  `telefono2` varchar(10) DEFAULT NULL,
  `email` varchar(30) NOT NULL,
  `estado_domicilio` int(11) NOT NULL,
  `tipo_vialidad` varchar(20) NOT NULL,
  `calle` varchar(50) NOT NULL,
  `num_ext` varchar(10) NOT NULL,
  `num_int` varchar(10) DEFAULT NULL,
  `colonia` varchar(50) NOT NULL,
  `municipio_domicilio` int(11) NOT NULL,
  `codigo_postal` varchar(5) NOT NULL,
  `referencia` text NOT NULL,
  `calle2` varchar(30) NOT NULL,
  `calle3` varchar(30) NOT NULL,
  `nss` varchar(12) DEFAULT NULL,
  `puesto` varchar(50) NOT NULL,
  `pago` float NOT NULL,
  `periodo_pago` enum('Semana','Mensual','Quincenal','Diario') DEFAULT NULL,
  `horas_semana` int(11) NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `fecha_salida` date DEFAULT NULL,
  `jornada` enum('Diurna','Nocturna','Mixta') NOT NULL,
  `documentoCurp` text NOT NULL,
  `documentoIdentificacion` text NOT NULL,
  `identificacion` enum('ine','pasaporte','cedula','licencia','otros') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `seer_solicitante`
--

INSERT INTO `seer_solicitante` (`id`, `id_solicitud`, `tipo_persona`, `curp`, `nombre`, `rfc`, `sexo`, `nacionalidad`, `estado`, `traductor`, `lenguaje`, `discapacidad`, `tipo_discapacidad`, `fecha_nacimiento`, `edad`, `telefono1`, `telefono2`, `email`, `estado_domicilio`, `tipo_vialidad`, `calle`, `num_ext`, `num_int`, `colonia`, `municipio_domicilio`, `codigo_postal`, `referencia`, `calle2`, `calle3`, `nss`, `puesto`, `pago`, `periodo_pago`, `horas_semana`, `fecha_ingreso`, `fecha_salida`, `jornada`, `documentoCurp`, `documentoIdentificacion`, `identificacion`, `created_at`, `updated_at`) VALUES
(1, 138, 'Moral', 'lema900830mmnlnn04', 'MICROSOFT OFFICE HOGAR Y EMPRESAS 2021', 'TARO9104025M6', 'H', 'Mexicana', 11, 'Si', NULL, 'No', NULL, '2000-02-16', 25, '4431885588', NULL, 'asdasd@gmail.com', 11, 'Calle', 'sdfsdf', '15', '1', 'sdfsdf', 1010, '58847', 'sdfsdf', 'sdfsdfsdf', 'sdfsdf', '554477', 'Comercio', 4500, 'Semana', 30, '2025-01-01', '2025-04-01', 'Diurna', '0', '', 'ine', '2025-04-15 22:45:40', '2025-05-27 16:42:01'),
(2, 61, 'Fisica', 'BEMI890329HMNDTR02', 'prueba banco', 'AAAA000000AAA', 'H', 'Mexicana', 2, NULL, NULL, 'No', NULL, '2025-04-23', 23, '3322332233', NULL, 'irvinsbm@gmail.com', 1, 'Call', 'primo tapia', '208', '23', 'Lomas del durazno', 1009, '58090', 'wfe3 ws', 'aw3cd3wsdw3', 'dw3d3', '22222222', 'cesces', 8, 'Semana', 5845, '2025-04-23', '2025-04-16', 'Diurna', '0', '', 'ine', '2025-04-21 17:08:22', '2025-04-21 17:08:22'),
(3, 61, 'Fisica', 'BEMI890329HMNDTR02', 'NAYELI', 'GUML660823V17', 'H', 'Mexicana', 13, NULL, NULL, 'No', NULL, '2025-04-08', 23, '4433132692', NULL, 'irvinsbm@gmail.com', 9, 'CAlle', 'primo tapia', '208', '12', 'Lomas del durazno', 1011, '58090', 'wfe3 ws', 'aw3cd3wsdw3', 'BLVD. GARCIA DE LEON', '3333333', 'Ingeniero', 234234, 'Semana', 34, '2025-04-03', '2025-04-15', 'Diurna', '0', '', 'ine', '2025-04-21 17:22:44', '2025-04-21 17:22:44'),
(4, 62, 'Fisica', 'BEMI890329HMNDTR02', 'VERONICA', 'BEMI890329', 'H', 'Mexicana', 10, 'Si', 'OPTOMNUI', 'No', NULL, '2025-04-23', 23, '3322332233', NULL, 'irvinsbm@gmail.com', 1, 'CAlle', 'primo tapia', '208', '23', 'Lomas del durazno', 2002, '58090', 'wfe3 ws', 'aw3cd3wsdw3', 'dw3d3', '22222222', 'cesces', 345345, 'Semana', 4, '2025-04-02', '2025-04-24', 'Diurna', '0', '', 'ine', '2025-04-21 17:46:01', '2025-04-21 17:46:01'),
(5, 74, 'Fisica', 'BEMI890329HMNDTR02', 'prueba banco', 'AAAA000000AAA', 'H', 'Mexicana', 1, 'Si', 'OPTOMNUI', 'No', NULL, '2025-04-23', 23, '3322332233', NULL, 'irvinsbm@gmail.com', 2, 'CAlle', 'primo tapia', '208', NULL, 'Lomas del durazno', 1005, '58090', 'wfe3 ws', 'aw3cd3wsdw3', 'dw3d3', '22222222', 'Ingeniero', 2234230, 'Semana', 34, '2025-04-16', '2025-04-19', 'Diurna', '0', '', 'ine', '2025-04-21 18:06:07', '2025-04-21 18:06:07'),
(6, 76, 'Fisica', 'BEMI890329HMNDTR02', 'IRVIN', 'AAAA000000AAA', 'H', 'Mexicana', 9, 'No', NULL, 'No', NULL, '2025-04-09', 23, '3322332233', NULL, 'irvinsbm@gmail.com', 3, 'CAlle', 'primo tapia', '208', NULL, 'Lomas del durazno', 2002, '58090', 'dawd', 'aw3cd3wsdw3', 'dw3d3', '22222222', 'Ingeniero', 23423400, 'Semana', 34, '2025-04-07', '2025-04-23', 'Diurna', '0', '', 'ine', '2025-04-21 20:47:25', '2025-04-21 20:47:25'),
(7, 77, 'Fisica', 'BEMI890329HMNDTR02', 'VERONICA', 'GUML660823V17', 'H', 'Mexicana', 15, 'No', NULL, 'No', NULL, '2025-04-17', 23, '4433132692', NULL, 'irvinsbm@gmail.com', 11, 'CAlle', 'primo tapia', '208', NULL, 'Lomas del durazno', 2002, '58090', 'wfe3 ws', 'lomas del durazmo', 'Calle Arcoíris', '22222222', 'cesces', 233, 'Semana', 3, '2025-04-17', '2025-04-08', 'Diurna', '0', '', 'ine', '2025-04-21 22:59:10', '2025-04-21 22:59:10'),
(8, 79, 'Fisica', 'BEMI890329HMNDTR02', 'CENTRO DE CONCILIACION LABORAL DEL ESTADO DE MICHOACAN DE OCAMPO', 'AAAA000000AAA', 'H', 'Mexicana', 17, 'No', NULL, 'No', NULL, '1989-04-17', 35, '6543456786', '546789876', 'irvinsbm@gmail.com', 4, 'Avenida', 'PRIMO TAPIA', '208', NULL, 'LOMAS DEL DURAZNO', 2003, '58090', 'WFE3 WS', 'AW3CD3WSDW3', 'BLVD. GARCIA DE LEON', '22222222', 'INGENIERO', 324234, 'Semana', 34, '2025-04-17', NULL, 'Diurna', '0', '', 'ine', '2025-04-22 21:12:14', '2025-04-22 21:12:14'),
(9, 80, 'Fisica', 'GUML660823MMNRNR07', 'IRVIN SAMUEL BEDOLLA', 'GUML660823V17', 'H', 'Mexicana', 11, 'No', NULL, 'No', NULL, '2005-01-21', 20, '4431326920', '4432445566', 'irvinsbm@gmail.com', 10, 'Calle', 'PRIMO TAPIA', '208', NULL, 'LOMAS DEL DURAZNO', 2002, '58090', 'WFE3 WS', 'AW3CD3WSDW3', 'BLVD. GARCIA DE LEON', '22222222', 'INGENIERO', 576, 'Semana', 45, '2025-04-08', NULL, 'Diurna', '0', '', 'ine', '2025-04-22 22:16:20', '2025-04-22 22:16:20'),
(10, 81, 'Fisica', 'BEMI890329HMNDTR02', 'CENTRO DE CONCILIACION LABORAL DEL ESTADO DE MICHOACAN DE OCAMPO', 'AAAA000000AAA', 'H', 'Mexicana', 16, 'No', NULL, 'No', NULL, '1993-06-16', 31, '6545645454', NULL, 'irvinsbm@gmail.com', 16, 'Calle', 'PRIMO TAPIA', '208', NULL, 'LOMAS DEL DURAZNO', 5018, '58090', 'DAWD', 'AW3CD3WSDW3', 'BLVD. GARCIA DE LEON', '333333384484', 'INGENIERO', 84512, 'Semana', 51, '2025-03-01', NULL, 'Diurna', '0', '', 'ine', '2025-04-23 16:52:33', '2025-04-23 16:52:33'),
(11, 82, 'Fisica', 'GUML660823MMNRNR07', 'IRVIN', 'AAAA000000AAA', 'H', 'Mexicana', 16, 'No', NULL, 'No', NULL, '2002-02-12', 23, '6545645454', '2132345345', 'irvinsbm@gmail.com', 1, 'Calle', 'PRIMO TAPIA', '208', NULL, 'LOMAS DEL DURAZNO', 2003, '58090', 'TRDTRDTRDTRDTRD', 'LOMAS DEL DURAZMO', 'BLVD. GARCIA DE LEON', '333333384484', 'INGENIERO', 45345300, 'Semana', 4, '2025-03-31', NULL, 'Diurna', '0', '', 'ine', '2025-04-24 18:22:24', '2025-04-24 18:22:24'),
(14, 140, 'Fisica', 'GUML660823MMNRNR07', 'IRVIN', 'BEMI890329S49', 'H', 'Mexicana', 16, 'No', NULL, 'No', NULL, '1997-06-10', 27, '6545645454', NULL, 'irvinsbm@gmail.com', 16, 'Calle', 'PRIMO TAPIA', '208', NULL, 'LOMAS DEL DURAZNO', 1005, '58090', 'WFE3 WS', 'LOMAS DEL DURAZMO', 'DW3D3', '333333384484', 'INGENIERO', 234, 'Semana', 34, '2025-05-07', NULL, 'Diurna', '0', '', 'ine', '2025-05-07 21:34:17', '2025-05-27 17:09:55'),
(15, 146, 'Fisica', 'TARO910402MMNPDF01', 'CENTRO DE CONCILIACION LABORAL DEL ESTADO DE MICHOACAN DE OCAMPO', 'FDFASDFSDGFDF', 'H', 'Mexicana', 16, 'No', NULL, 'No', NULL, '1991-04-02', 34, '4435555869', '4432586914', 'otapiarodrigue@gmail.com', 16, 'Calle', 'RAFAEL GARCÍA DE LEÓN', '1575', '233', 'CHAPULTEPEC ORIENTE', 16053, '58260', 'EDIFICIO CCL', 'UNA CALLE', 'OTRA CALLE', '66335522111', 'EMPLEADA', 1800, 'Semana', 48, '2023-02-15', NULL, 'Diurna', '0', '', 'ine', '2025-05-19 18:07:22', '2025-05-19 18:07:22'),
(16, 146, 'Fisica', 'TARO910402MMNPDF01', 'CENTRO DE CONCILIACION LABORAL DEL ESTADO DE MICHOACAN DE OCAMPO', 'FDFASDFSDGFDF', 'H', 'Mexicana', 16, 'No', NULL, 'No', NULL, '1991-04-02', 34, '4435555869', '4432586914', 'otapiarodrigue@gmail.com', 16, 'Calle', 'RAFAEL GARCÍA DE LEÓN', '1575', '233', 'CHAPULTEPEC ORIENTE', 16053, '58260', 'EDIFICIO CCL', 'UNA CALLE', 'OTRA CALLE', '66335522111', 'EMPLEADA', 1800, 'Semana', 48, '2023-02-15', NULL, 'Diurna', '0', '', 'ine', '2025-05-19 18:09:01', '2025-05-19 18:09:01'),
(17, 146, 'Fisica', 'TARO910402MMNPDF01', 'CENTRO DE CONCILIACION LABORAL DEL ESTADO DE MICHOACAN DE OCAMPO', 'FDFASDFSDGFDF', 'H', 'Mexicana', 16, 'No', NULL, 'No', NULL, '1991-04-02', 34, '4435555869', '4432586914', 'otapiarodrigue@gmail.com', 16, 'Calle', 'RAFAEL GARCÍA DE LEÓN', '1575', '233', 'CHAPULTEPEC ORIENTE', 16053, '58260', 'EDIFICIO CCL', 'UNA CALLE', 'OTRA CALLE', '66335522111', 'EMPLEADA', 1800, 'Semana', 48, '2023-02-15', NULL, 'Diurna', '0', '', 'ine', '2025-05-19 18:09:23', '2025-05-19 18:09:23'),
(18, 146, 'Fisica', 'TARO910402MMNPDF01', 'CENTRO DE CONCILIACION LABORAL DEL ESTADO DE MICHOACAN DE OCAMPO', 'FDFASDFSDGFDF', 'H', 'Mexicana', 16, 'No', NULL, 'No', NULL, '1991-04-02', 34, '4435555869', '4432586914', 'otapiarodrigue@gmail.com', 16, 'Calle', 'RAFAEL GARCÍA DE LEÓN', '1575', '233', 'CHAPULTEPEC ORIENTE', 16053, '58260', 'EDIFICIO CCL', 'UNA CALLE', 'OTRA CALLE', '66335522111', 'EMPLEADA', 1800, 'Semana', 48, '2023-02-15', NULL, 'Diurna', '0', '', 'ine', '2025-05-19 18:10:10', '2025-05-19 18:10:10'),
(19, 146, 'Fisica', 'TARO910402MMNPDF01', 'CENTRO DE CONCILIACION LABORAL DEL ESTADO DE MICHOACAN DE OCAMPO', 'FDFASDFSDGFDF', 'H', 'Mexicana', 16, 'No', NULL, 'No', NULL, '1991-04-02', 34, '4435555869', '4432586914', 'otapiarodrigue@gmail.com', 16, 'Calle', 'RAFAEL GARCÍA DE LEÓN', '1575', '233', 'CHAPULTEPEC ORIENTE', 16053, '58260', 'EDIFICIO CCL', 'UNA CALLE', 'OTRA CALLE', '66335522111', 'EMPLEADA', 1800, 'Semana', 48, '2023-02-15', NULL, 'Diurna', '0', '', 'ine', '2025-05-19 18:10:44', '2025-05-19 18:10:44'),
(20, 151, 'Fisica', 'TARO910402MMNPDF01', 'OFELIA TAPIA RODRIGUEZ', 'TARO910402MMN', 'M', 'Mexicana', 16, 'No', NULL, 'No', NULL, '1991-04-02', 34, '4435555869', '4431086439', 'otapiarodriguez@gmail.com', 16, 'Calle', 'RAFAEL GARCÍA DE LEÓN', '1575', '261', 'CHAPULTEPEC ORIENTE', 16053, '58260', 'EDIFICIO CCL', 'UNA CALLE', 'OTRA CALLE', '66335522111', 'EMPLEADA', 1800, 'Semana', 48, '2023-01-30', NULL, 'Diurna', '0', '', 'ine', '2025-05-19 21:23:33', '2025-05-19 21:23:33'),
(21, 151, 'Fisica', 'TARO910402MMNPDF01', 'OFELIA TAPIA RODRIGUEZ', 'TARO910402MMN', 'M', 'Mexicana', 16, 'No', NULL, 'No', NULL, '1991-04-02', 34, '4435555869', '4431086439', 'otapiarodriguez@gmail.com', 16, 'Calle', 'RAFAEL GARCÍA DE LEÓN', '1575', '261', 'CHAPULTEPEC ORIENTE', 16053, '58260', 'EDIFICIO CCL', 'UNA CALLE', 'OTRA CALLE', '66335522111', 'EMPLEADA', 1800, 'Semana', 48, '2023-01-30', NULL, 'Diurna', '0', '', 'ine', '2025-05-19 21:41:25', '2025-05-19 21:41:25'),
(22, 164, 'Fisica', 'AALI860714MMNLMR06', 'KARINA GUEVARA SOTO', 'FDFASDFSDGFDF', 'M', 'Mexicana', 16, 'No', NULL, 'No', NULL, '1991-04-02', 34, '4435555869', NULL, 'otapiarodriguez@gmail.com', 16, 'Calle', 'RAFAEL GARCÍA DE LEÓN', '1575', '34', 'CHAPULTEPEC ORIENTE', 16053, '58260', 'EDIFICIO CCL', 'UNA CALLE', 'OTRA CALLE', NULL, 'EMPLEADA', 1800, 'Semana', 48, '2024-06-07', NULL, 'Diurna', '0', '', 'ine', '2025-05-19 22:36:01', '2025-05-19 22:36:01'),
(23, 168, 'Fisica', 'TARO910402MMNPDF01', 'CENTRO DE CONCILIACION LABORAL DEL ESTADO DE MICHOACAN DE OCAMPO', 'FDFASDFSDGFDF', 'M', 'Mexicana', 16, 'No', NULL, 'No', NULL, '1991-04-02', 34, '4435555869', '4432586914', 'otapiarodriguez@gmail.com', 16, 'Calle', 'RAFAEL GARCÍA DE LEÓN', '1575', '261', 'CHAPULTEPEC ORIENTE', 16053, '58260', 'EDIFICIO CCL', 'UNA CALLE', 'OTRA CALLE', '66335522111', 'EMPLEADA', 1800, 'Semana', 48, '2023-02-10', NULL, 'Diurna', '0', '', 'ine', '2025-05-19 23:05:19', '2025-05-19 23:05:19'),
(24, 169, 'Fisica', 'AALI860714MMNLMR06', 'FRANCISCO JAVIER MARCELO OROZCO', 'XAXX010101000', 'H', 'Mexicana', 16, 'No', NULL, 'No', NULL, '1985-11-14', 34, '4435555869', '4431086439', 'frank-marcelo@gmail.com', 16, 'Calle', 'ARBOL DEL TULE', '91', '14', 'VILLA NATURA', 16053, '61510', 'ESTRELLA AMARILLA', 'UNA CALLE', 'OTRA CALLE', '66335522111', 'EMPLEADA', 1800, 'Semana', 48, '2023-01-01', NULL, 'Diurna', '0', '', 'ine', '2025-05-19 23:20:04', '2025-05-19 23:20:04'),
(25, 170, 'Fisica', 'TARO910402MMNPDF01', 'KARINA GUEVARA SOTO', 'XAXX010101000', 'M', 'Mexicana', 16, 'No', NULL, 'No', NULL, '1991-04-02', 34, '4435555869', '4431086439', 'otapiarodriguez@gmail.com', 16, 'Calle', 'RAFAEL GARCÍA DE LEÓN', '1575', '12', 'CHAPULTEPEC ORIENTE', 16053, '58260', 'EDIFICIO CCL', 'UNA CALLE', 'OTRA CALLE', '12345678911', 'EMPLEADA', 1800, 'Semana', 48, '2023-02-02', NULL, 'Diurna', '0', '', 'ine', '2025-05-20 17:56:28', '2025-05-20 17:56:28'),
(26, 172, 'Fisica', 'TARO910402MMNPDF01', 'KARINA GUEVARA SOTO', 'TARO910402MMN', 'M', 'Mexicana', 16, 'No', NULL, 'No', NULL, '1991-04-02', 34, '4435555869', '4431086439', 'otapiarodriguez@gmail.com', 16, 'Calle', 'RAFAEL GARCÍA DE LEÓN', '1575', '34', 'CHAPULTEPEC ORIENTE', 16053, '58260', 'EDIFICIO CCL', 'UNA CALLE', 'OTRA CALLE', '12345678911', 'EMPLEADA', 1800, 'Semana', 48, '2023-01-30', NULL, 'Diurna', '0', '', 'ine', '2025-05-20 18:05:15', '2025-05-20 18:05:15'),
(27, 172, 'Fisica', 'TARO910402MMNPDF01', 'KARINA GUEVARA SOTO', 'TARO910402MMN', 'M', 'Mexicana', 16, 'No', NULL, 'No', NULL, '1991-04-02', 34, '4435555869', '4431086439', 'otapiarodriguez@gmail.com', 16, 'Calle', 'RAFAEL GARCÍA DE LEÓN', '1575', '34', 'CHAPULTEPEC ORIENTE', 16053, '58260', 'EDIFICIO CCL', 'UNA CALLE', 'OTRA CALLE', '12345678911', 'EMPLEADA', 1800, 'Semana', 48, '2023-01-30', NULL, 'Diurna', '0', '', 'ine', '2025-05-20 18:09:21', '2025-05-20 18:09:21'),
(28, 173, 'Fisica', 'AALI860714MMNLMR06', 'JOSE CARLOS ESTRADA CAMACHO', 'TARO910402MMN', 'H', 'Mexicana', 16, 'No', NULL, 'No', NULL, '1991-04-02', 34, '4435555869', '4431086439', 'otapiarodriguez@gmail.com', 16, 'Calle', 'RAFAEL GARCÍA DE LEÓN', '1575', '12', 'CHAPULTEPEC ORIENTE', 16053, '58260', 'EDIFICIO CCL', 'UNA CALLE', 'OTRA CALLE', '66335522111', 'EMPLEADA', 1800, 'Semana', 48, '2023-02-20', NULL, 'Diurna', '0', '', 'ine', '2025-05-20 19:04:02', '2025-05-20 19:04:02'),
(29, 174, 'Fisica', 'AALI860714MMNLMR06', 'MATILDE HERNANDEZ GARCIA', 'TARO910402MMN', 'M', 'Mexicana', 16, 'No', NULL, 'No', NULL, '2023-01-30', 34, '4435555869', '4431086439', 'otapiarodriguez@gmail.com', 16, 'Calle', 'RAFAEL GARCÍA DE LEÓN', '1575', '12', 'CHAPULTEPEC ORIENTE', 16053, '58260', 'EDIFICIO CCL', 'ZACAN', 'OTRA CALLE MAS', '12345678911', 'EMPLEADA', 2500, 'Semana', 51, '2023-01-30', NULL, 'Diurna', '0', '', 'ine', '2025-05-20 19:08:55', '2025-05-20 19:08:55'),
(30, 174, 'Fisica', 'AALI860714MMNLMR06', 'MATILDE HERNANDEZ GARCIA', 'TARO910402MMN', 'M', 'Mexicana', 16, 'No', NULL, 'No', NULL, '2023-01-30', 34, '4435555869', '4431086439', 'otapiarodriguez@gmail.com', 16, 'Calle', 'RAFAEL GARCÍA DE LEÓN', '1575', '12', 'CHAPULTEPEC ORIENTE', 16053, '58260', 'EDIFICIO CCL', 'ZACAN', 'OTRA CALLE MAS', '12345678911', 'EMPLEADA', 2500, 'Semana', 51, '2023-01-30', NULL, 'Diurna', '0', '', 'ine', '2025-05-20 19:09:07', '2025-05-20 19:09:07'),
(31, 174, 'Fisica', 'AALI860714MMNLMR06', 'MATILDE HERNANDEZ GARCIA', 'TARO910402MMN', 'M', 'Mexicana', 16, 'No', NULL, 'No', NULL, '2023-01-30', 34, '4435555869', '4431086439', 'otapiarodriguez@gmail.com', 16, 'Calle', 'RAFAEL GARCÍA DE LEÓN', '1575', '12', 'CHAPULTEPEC ORIENTE', 16053, '58260', 'EDIFICIO CCL', 'ZACAN', 'OTRA CALLE MAS', '12345678911', 'EMPLEADA', 2500, 'Semana', 51, '2023-01-30', NULL, 'Diurna', '0', '', 'ine', '2025-05-20 19:09:55', '2025-05-20 19:09:55'),
(32, 174, 'Fisica', 'AALI860714MMNLMR06', 'MATILDE HERNANDEZ GARCIA', 'TARO910402MMN', 'M', 'Mexicana', 16, 'No', NULL, 'No', NULL, '2023-01-30', 34, '4435555869', '4431086439', 'otapiarodriguez@gmail.com', 16, 'Calle', 'RAFAEL GARCÍA DE LEÓN', '1575', '12', 'CHAPULTEPEC ORIENTE', 16053, '58260', 'EDIFICIO CCL', 'ZACAN', 'OTRA CALLE MAS', '12345678911', 'EMPLEADA', 2500, 'Semana', 51, '2023-01-30', NULL, 'Diurna', '0', '', 'ine', '2025-05-20 19:14:43', '2025-05-20 19:14:43'),
(33, 174, 'Fisica', 'AALI860714MMNLMR06', 'MATILDE HERNANDEZ GARCIA', 'TARO910402MMN', 'M', 'Mexicana', 16, 'No', NULL, 'No', NULL, '2023-01-30', 34, '4435555869', '4431086439', 'otapiarodriguez@gmail.com', 16, 'Calle', 'RAFAEL GARCÍA DE LEÓN', '1575', '12', 'CHAPULTEPEC ORIENTE', 16053, '58260', 'EDIFICIO CCL', 'ZACAN', 'OTRA CALLE MAS', '12345678911', 'EMPLEADA', 2500, 'Semana', 51, '2023-01-30', NULL, 'Diurna', '0', '', 'ine', '2025-05-20 19:15:17', '2025-05-20 19:15:17'),
(34, 204, 'Fisica', 'GUML660823MMNRNR07', 'IRVING CESAR TAPIA RODRIGUEZ', 'TARO910402MMN', 'M', 'Mexicana', 16, 'No', NULL, 'No', NULL, '1994-08-09', 30, '4435555839', '4431086439', 'otapiarodriguez@gmail.com', 16, 'Calle', 'PRIMO TAPIA', '208', '23', 'LOMAS DEL DURAZNO', 16053, '58090', 'ESCUELA IGNACIO ZARAGOZA', 'UNA CALLE', 'OTRA CALLE', '234679734522', 'EMPLEADA', 1800, 'Diario', 48, '2023-01-30', NULL, 'Diurna', '0', '', 'ine', '2025-05-20 22:10:01', '2025-05-20 22:10:01'),
(35, 208, 'Fisica', 'TARO910402MMNPDF01', 'TOMAS VENCES CALVILLO', 'TOVC911105MMN', 'H', 'Mexicana', 16, 'Si', 'SEÑAS', 'No', NULL, '1991-11-05', 33, '4435555869', '4431086439', 'otapiarodriguez@gmail.com', 16, 'Calle', 'SALVADOR AZUELA', '555', NULL, 'ELIAS PEREZ ALVAREZ', 16053, '58215', 'BASE DE COMBI CORAL 2A', 'DR. JESUS GONZÁLEZ GARZA', 'ROQUE GONZALEZ GARZA', '66335522111', 'EMPLEADO', 3800, 'Semana', 54, '2018-05-24', NULL, 'Diurna', '0', '', 'ine', '2025-05-23 15:58:48', '2025-05-23 15:58:48'),
(36, 214, 'Fisica', 'AALI860714MMNLMR06', 'ANA KAREN PLANCARTE GUZMAN', 'TARO910402MMN', 'M', 'Mexicana', 16, 'No', NULL, 'No', NULL, '1991-02-01', 34, '4435555869', '4432586914', 'otapiarodriguez@gmail.com', 16, 'Calle', 'MARTIN CASTREJON', '273', NULL, 'FELICITAS DEL RIO', 16053, '58040', 'FRENTE A LA VIOLETA', 'UNA CALLE', 'OTRA CALLE', '12345678911', 'EMPLEADA', 2500, 'Semana', 54, '2024-02-12', NULL, 'Diurna', '0', '', 'ine', '2025-05-23 16:50:51', '2025-05-23 16:50:51'),
(37, 214, 'Fisica', 'AALI860714MMNLMR06', 'ANA KAREN PLANCARTE GUZMAN', 'TARO910402MMN', 'M', 'Mexicana', 16, 'No', NULL, 'No', NULL, '1991-02-01', 34, '4435555869', '4432586914', 'otapiarodriguez@gmail.com', 16, 'Calle', 'MARTIN CASTREJON', '273', NULL, 'FELICITAS DEL RIO', 16053, '58040', 'FRENTE A LA VIOLETA', 'UNA CALLE', 'OTRA CALLE', '12345678911', 'EMPLEADA', 2500, 'Semana', 54, '2024-02-12', NULL, 'Diurna', '0', '', 'ine', '2025-05-23 16:51:38', '2025-05-23 16:51:38'),
(38, 222, 'Fisica', 'TARO910402MMNPDF01', 'J GUADALUPE LOPEZ LOPEZ', 'HDFSLKDFJSD52', 'H', 'Mexicana', 16, 'No', NULL, 'No', NULL, '1992-05-05', 32, '4435555869', '4431086439', 'ota', 16, 'Calle', 'RAFAEL GARCÍA DE LEÓN', '1575', '23', 'CHAPULTEPEC ORIENTE', 16053, '58260', 'EDIFICIO CCL', 'UNA CALLE', 'OTRA CALLE', '66335522111', 'EMPLEADO', 2500, 'Semana', 54, '2023-04-07', NULL, 'Diurna', 'TARO910402MMNPDF01_CURP.pdf', 'TARO910402MMNPDF01_Identificacion.pdf', 'ine', '2025-05-23 18:29:30', '2025-05-23 18:29:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `segundo_encuentro`
--

CREATE TABLE `segundo_encuentro` (
  `id` int(11) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `estado` varchar(30) NOT NULL,
  `celular` varchar(14) NOT NULL,
  `genero` enum('Hombre','Mujer') NOT NULL,
  `estatus` enum('Validado','Pendiente') NOT NULL DEFAULT 'Pendiente',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `segundo_encuentro`
--

INSERT INTO `segundo_encuentro` (`id`, `correo`, `nombre`, `estado`, `celular`, `genero`, `estatus`, `created_at`, `updated_at`) VALUES
(2, 'licleoa@gmail.com', 'Hector Leonardo Avalos Mota Velasco ', 'Michoacán', '4431285879', '', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'lalo.themis8@gmail.com', 'Eduardo Vargas Rodríguez', 'Michoacan', '4431220018', '', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'lic.jorgerocha@hotmail.com', 'Jorge Humberto Rocha anguiano ', 'Michoacán', '3332342406', '', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'licvalente_aguilar@hotmail.com', 'VALENTE AGUILAR GUTIÉRREZ', 'Michoacán', '4434385972', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 16:01:19'),
(6, 'panchokandela@gmail.com', 'Elmer Francisco Blanco González', 'Michoacán', '4436870950', '', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'lic.georginagarra0714@gmail.com', 'Georgina Guadalupe García Rangel', 'Michoacán', '4435356590', '', 'Validado', '0000-00-00 00:00:00', '2024-11-28 16:58:59'),
(8, 'estrelladostar@gmail.com', 'Alfredo Ezequiel Estrella Cháve', 'Michoacan', '4434713496', '', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 'mariarendon2908@gmail.com', 'Maria del Socorro Rendón Urriet', 'Michoacan ', '4433738524', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 'arauci.lopez@umich.mx', 'Arauci Siloe López Huéramo Martín', 'Michoacán', '4433424819', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 16:34:49'),
(11, 'chagollagp13@gmail.com', 'María Guadalupe Chagolla Alons', 'Michoacá', '4434007023', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 'sonia.lopez@umich.mx', 'Sonia López Ortiz', 'Michoacán', '4432195612', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 'licaalexis@gmail.com', 'Alexis Moreno Lica', 'Michoacán', '4431578163', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 'eugeconthacuna@gmail.com', 'Eugenio Jesahel Acuña Garcí', 'Michoacán de Ocampo', '4432211450', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 14:42:24'),
(15, 'ascela097@gmail.com', 'Mary Ascela Torres Benitez ', 'Michoacán', '4521820972', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 15:42:45'),
(16, 'olivomorenog@gmail.com', 'Giselle Olivo Moreno ', 'Michoacan ', '4521134003', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 15:42:59'),
(17, 'brenda.lizeth.anaya.diaz@gmail.com', 'Brenda Lizeth Anaya Diaz ', 'Michoacán', '452 219 3510 ', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 14:55:13'),
(18, 'victoraboyteslegales@gmail.com', 'Victor Hugo Aboytes Arce ', 'Michoacán', '4522853120', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 15:42:26'),
(19, 'angye130284@gmail.com', 'Angélica Yaneth Torres Rodrígue', 'Michoacán', '4521288336', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 14:56:25'),
(20, 'luismanuelrojasm@gmail.com', 'Luis Manuel Rojas Murillo', 'Michoacán', '4433482131', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, 'uribeliz86@gmail.com', 'Yahaira Lizeth Medina Uribe ', 'Michoacán', '4437222260', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 'ruizmorenoconsultores@gmail.com', 'ANGEL EDOARDO RUIZ BUENROSTRO', 'JALISCO', '3338099485', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, '02despachojuridico@gmail.com', 'Eréndira Cedillo Nieto', 'Michoacán', '4431614055', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 19:43:05'),
(24, 'numerosocial65@gmail.com', 'Arturo Sánchez Castr', 'Michoacán', '4431852915', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 19:44:17'),
(25, 'alexiaaferrer7@gmail.com', 'Alejandra Ferrer Rangel', 'Michoacán', '4433922540', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 19:43:20'),
(26, '1630110f@umich.mx', 'Víctor Hugo Mora Ortega', 'Michoacán', '4431103969', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 15:45:22'),
(27, 'jisiilver9250@gmail.com', 'Elvia Sánchez Jiméne', 'Michoacán', '5514747789', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(28, 'tutorpymecetis52@gmail.com', 'Manuel Garcia Chavez', 'Michoacan', '4434773614', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(29, 'diananegrete706@gmail.com', 'Diana Guadalupe Negrete Ramírez', 'Michoacán', '452-521-2012 ', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 14:28:29'),
(30, 'sanchezilse69@gmail.com', 'Ilse Denisse Sánchez Hernánde', 'Michoacán', '4435145896', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(31, 'lic.derecho.iop@gmail.com', 'irais', 'michoacá', '4432584957', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(32, 'alexiara.lopez@cclsinaloa.gob.mx', 'Beatriz Jiménez Celis', 'Sinaloa', '667 197 2792', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(33, 'emilio.rangel@umich.mx', 'Emilio Yamel Rangel Leal ', 'Michoacán', '4432731101', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(34, 'angelica.inca@autocom.mx', 'Yacqueline Angelica Inca Calderon ', 'Quereraro', '4433366564', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(35, 'lic.luz.ireri.gonzalez.hernandez@gmail.com', 'Luz ireri González Hernánde', 'Michoacán', '4433857772', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 14:28:11'),
(36, 'lizetmfarfana@gmail.com', 'Matilde Lizet Farfan Angeles ', 'Michoacán', '4435868558', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(37, 'abogado992@gmail.com', 'Gonzalo Alfredo Rosas García', 'Michoacán', '452 505 68 48 ', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 15:38:18'),
(38, '2121913h@umich.mx', 'Sandra Yadira Mesa Acosta ', 'Morelia Michoacán', '4432680622', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(39, 'keniaguadalupeavila@gmail.com', 'Kenia Guadalupe Avila Vargas ', 'Michoacan ', '4435692756', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(40, '2406269g@umich.mx', 'José Luis Leyva Ángele', 'Michoacán', '4432135354', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(41, 'fernandamiroslavareyes@gmail.com', 'Fernanda Miroslava Reyes Reyes ', 'Michoacán', '434-106-3682', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(42, 'ranferiaburto20@gmail.com', 'Ranferi Aburto Rodriguez', 'Michoacan ', '443212177', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(43, 'geraguzm4n@gmail.com', 'Gerardo Guzmán Rodriguez', 'Morelia Michoacán', '4433661873', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(44, 'jbcoppor@gmail.com', 'Juan Bernardo Corona Portillo ', 'Michoacan', '4434026972', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(45, 'garciadalia073@gmail.com', 'Dalia Garcia Nieto', 'Michoacá', '4471458006', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(46, 'michellearroyotellez54@gmail.com', 'Michelle Arroyo Tellez ', 'Michoacan ', '436 124 3978 ', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(47, 'msanchez@cclqueretaro.gob.mx', 'MARCO ANTONIO SANCHEZ MANDUJANO', 'QUERETARO', '4421523673', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(48, 'luisheb33@gmail.com', 'Luis Humberto Espinoza Betancourt ', 'Michoacán', '4522180934', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 15:08:34'),
(49, '1911409g@umich.mx', 'Medina Flores Erick Fernando ', 'Michoacán', '4437083654', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(50, 'fhercitomanmed@gmail.com', 'MEDINA CABEZAS FERNANDO', 'Michoacan', '4431606334', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(51, 'yesenyasierra27@gmail.com', 'Yesenia Velázquez Sierra', 'Michoacán', '4433020417', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(52, 'rosymtzjasso69@gmail.com', 'Rosa María María Martínez Jas', 'Michoacan', '4522036079', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(53, 'huberturicato@gmail.com', 'Huber Joel Zepeda Cañas', 'Michoacán', '4591203969', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(54, 'serranoalexa2456@gmail.com', 'Alexa Serrano', 'Michoacán', '443 946 451', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(55, 'emiliocendejas3@gmail.com', 'Emilio Cendejas Arévalo', '', '4431106485', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(56, 'laurosa1965@gmail.com', 'Laura Olivia Sánchez Aguirre', 'Michoacá', '4524439018', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(57, 'felipemd481@gmail.com', 'Felipe Moreno Día', 'Michoacá', '4431918863', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 14:30:58'),
(58, 'ady_208@hotmail.com', 'Beatriz Adriana Torres González', 'Michoacán', '4431855308', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(59, 'garciajonathanpro@gmail.com', 'Jonathan Jesús García Alcara', 'Michoacán', '9615760580', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(60, 'lixijetsemanymartinezdiaz@gmail.com', 'Lixi Jetsemany Martinez Díaz', 'Michoacán', '4434820674', '', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(61, 'vazquezmancerajorgeluis18@gmail.com', 'Jorge Luis ', 'Michoacan ', '7862266928', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(62, '2405896c@umich.mx', 'Dioselin García Martíne', 'Michoacán', '4522024167', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(63, 'greciaayalavilla2@gmail.com', 'Grecia Ayala Villa ', 'Michoacán ,Morelia', '4431032140', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(64, '2403331j@umich.mx', 'Luis Ángel Ramírez coron', 'Michoacán', '4434055219', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(65, '2150496x@umich.mx', 'Mayra Luz Lara Nava', 'Michoacan', '7531682298', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(66, 'danielchagolla52@gmail.com', 'Daniel Garcia Chagolla', 'Michoacan', '4436166356', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(67, 'lic.adriangapa@hotmail.com', 'Adrian Mizraim García Páram', 'Michoacan ', '4431864648', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 15:35:56'),
(68, 'silviasosa399@gmail.com', 'Carlos Sosa Pedraza ', 'Michoacán', '4525447989', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(69, 'yam.me171105@gmail.com', 'Adialeda Yamilet Molina Escutia ', 'Michoacán', '4432613020', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(70, 'licenciadaruizmoreno@gmail.com', 'María de Lourdes Ruiz Moreno', 'Michoacán.', '7531536444', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(71, 'racoba07@gmail.com', 'Raúl Cortés Barrig', 'Michoacán', '7531413328', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(72, 'andreacortezangeles@gmail.com', 'Andrea Cortez Angeles ', 'Morelia ', '771 190 5094 ', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(73, 'sharaimorgar78@gmail.com', 'Francis sharai moreno garcia', 'Michoscan', '4521056332', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(74, 'citlalithanairyvelasquezsolis@gmail.com', 'Citlali Thanairy Velasques solis', '', '4431158429', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(75, 'degolladonacho@gmail.com', 'IGNACIO DE JESUS DEGOLLADO NUÑE', 'MICHOACAN', '3531089301', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 14:25:05'),
(76, '2406646g@umich.mx', 'Maria Guadalupe Figueroa Borjas ', 'Morelia Michoacán', '7551433617', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(77, 'karsanca88@gmail.com', 'KARLA GUADALUPE SÁNCHEZ CALDERO', 'MICHOACAN', '4531220833', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 15:43:10'),
(78, 'campuzanomiriam5@gmail.com', 'Miriam Campuzano Peña', 'Michoacán', '4431394977', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 19:44:03'),
(79, 'mondragon.eleida@gmail.com', 'Eleida Estela', 'Mondragon Solis', '4434022219', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-29 15:31:33'),
(80, 'licmarioguillencasillas@gmail.com', 'Mario Alejandro Guillén Casillas', 'Michoacán', '3511459154', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(81, 'arelireyess@gmail.com', 'Susy Areli Reyes Santoyo ', 'Michoacán', '', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(82, 'juanfrrod@gmail.com', 'Juan Francisco Rojas Rodríguez', 'Michoacá', '4431029378', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 14:44:08'),
(83, 'fernandaalfarogaona@gmail.com', 'Maria Fernanda Alfaro Gaona ', 'Michoacán', '4431684597', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(84, 'lf289239@gmail.com', 'Luis Fernando Anita Hernandez', 'Michoacan', '4432069673', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 16:29:48'),
(85, '2015462e@umich.mx', 'Monserrat Guerrero Tapia ', 'Michoacán', '4432850990', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(86, 'josephmiguelfuertefarias@gmail.com', 'Joseph Miguel fuerte farias ', 'Morelia, mich', '4434084880', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(87, 'roxsley01@gmail.com', 'Rosalinda Ortiz Martínez', 'Michoacán', '4432002598', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(88, 'germaanmedina@gmail.com', 'Germán', 'Michoacán', '4434748650', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(89, '2146287a@umich.mx', 'Anahi Yetlanezi Pérez Gonzále', 'Michoacán', '4434650495', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(90, 'magalyguzman411@gmail.com', 'Yenifer Magali Guzmán Reynoso', 'Michoacán', '4523436846', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(91, '1911625k@umich.mx', 'Alberto Espinoza Equihua ', 'Michoacán de Ocampo', '4435945611', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(92, 'lopezgabrielmariaguadalupe501@gmail.com', 'Maria Guadalupe López Gabriel', 'Michoacán', '4362022642', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(93, 'yepezsma@gmail.com', 'Marcelo Yepez Salinas ', 'Michoacan', '5590182438', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(94, 'lupita.equihua9609@hotmail.com', 'Brenda Guadalupe Equihua Pérez', 'Michoacán', '4531447741', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(95, 'miguelangelmagana38@gmail.com', 'Miguel Angel Magaña Ovand', 'Michoacán', '6643524507', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(96, '2108102j@umich.mx', 'René Alvarez Sauced', 'Michoacá', '4433316801', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(97, 'armandyalgo@gmail.com', 'Armando Ayala Gonzále', 'michoacá', '4434861696', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 15:17:33'),
(98, 'jenevievett@gmail.com', 'Marilyn jenevievett Rodríguez Lópe', 'Michoacán', '4361041367', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 15:17:48'),
(99, 'licenciado.miranda84@gmail.com', 'Ricardo Arellano Miranda', 'Michoacán', '4432643751', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(100, 'hayalarrr@gmail.com', 'Haydee Alcantar Arizmendi', 'Michoacá', '4431300557', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 15:12:24'),
(101, 'ramirezhiginio432@gmail.com', 'Salvador Duran Muño', 'Michoacan', '4434918147', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 15:13:11'),
(102, 'karlaolivo2017@gmail.com', 'Karla Georgina Olivo Bernal', 'Michoacá', '3539637716', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 16:33:19'),
(103, 'mquiroz70886@gmail.com', 'Fermín maya quiro', 'Michoacan ', '4433364589', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(104, 'reyna.santoyo88@gmail.com', 'Reyna Miranda Martínez', 'Michoacan', '4431660967', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(105, 'alfonsovile@gmail.com', 'Alfonso Villagomez Leó', 'Michoacá', '4431806365', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(106, 'francisco94av@gmail.com', 'Francisco Adán Anguiano Villa', 'Michoacán', '4471263177', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(107, 'lizzie.villago@gmail.com', 'Elizabeth Villagómez Pantoj', '', '4431977164', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(108, 'rosaliomancoss@gmail.com', 'Rosalío Manriquez Coss', 'Michoacán', '4433450488', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 15:16:14'),
(109, 'yunuennegrete38@gmail.com', 'Julissa Yunuen Martinez Negrete ', '', '3512953937', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(110, 'lunam9304@gmail.com', 'Miguel Ángel Luna García', 'Michoacán ', '4436869158', 'Hombre', 'Pendiente', '2024-11-27 20:49:41', '2024-11-27 20:49:41'),
(111, 'giovanniatletico13@gmail.com', 'Giovanni Antonio Guerrero Robles ', 'Michoacán', '4437235368', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(112, 'calderonyare38@gmail.com', 'Yareslie Vega Calderón', 'Michoacán', '4435072898', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 22:49:10'),
(113, 'oswaldo.ponce.ruiz@gmail.com', 'Oswaldo Ponce Ruiz', 'Michoacán de Ocamp', '4434034675', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 14:58:26'),
(114, 'dariomadriga@gmail.com', 'SERGIO DARÍO MADRIGAL ESTRADA', 'Michoacán', '4433856841', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(115, '2008078e@umich.mx', 'María de la Luz Jaimes Sauced', 'Michoacán', '4591100076', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(116, 'temoghin@gmail.com', 'Cuauhtémoc Ramírez Durán ', 'Michoacán ', '4431333959', 'Hombre', 'Pendiente', '2024-11-27 20:53:08', '2024-11-27 20:53:08'),
(117, 'arreolakaris@gmail.com', 'KAREN MENDOZA ARREOLA ', 'Michoacan ', '443 107 0551 ', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(118, 'neycupa@gmail.com', 'Jose Artemio Romero Pañed', 'Michoáca', '4334007023', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(119, 'sonia.retiz@umich.mx', 'Sonia Jerusalén Retiz Mot', 'Michoacán', '4431405208', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(120, 'sidtmich@gmail.com', 'Miguel Ángel Magaña Ovan', 'Michoacán', '4522828657', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(121, '2204063k@umich.mx', 'Jaime Adair Corona Avalos ', 'Michoacán', '4438011470', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 15:35:38'),
(122, 'roxanatorresh7@gmail.com', 'Roxana Torres Herrera', 'Michoacan ', '4431711040', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(123, 'abogado.roberto.ma@gmail.com', 'ROBERTO MARTINEZ AGUILAR', 'MICHOACAN', '4434423108', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(124, 'camisaroja514@gmail.com', 'Arnoldo Pérez Cabrer', 'Michoacá', '3131132666', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(125, 'marinely.bg@huetamo.tecnm.mx', 'Marinely Betancourt Gutiérre', 'Michoacán', '4351123599', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 16:12:54'),
(126, 'magdalena.rg@huetamo.tecnm.mx', 'Ma. Magdalena Román García', 'Michoacán ', '4351032799', 'Mujer', 'Validado', '2024-11-27 20:53:55', '2024-11-28 16:23:01'),
(127, 'carmen.lr@huetamo.tecnm.mx', 'Ma del Carmen López Rodrígu', 'Michoacá', '4351060838', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(128, 'arturotorres027@gmail.com', 'Arturo Torres Campos ', 'Michoacán', '4434107828', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 14:21:02'),
(129, 'r.francisco1270@gmail.com', 'Francisco Ramirez Arreola', 'Michoacan', '4437253929', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 14:46:16'),
(130, 'emigdio18almazan@gmail.com', 'Emigdio Molina Almazán', 'Michoacán', '4433738186', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(131, 'cinci212@gmail.com', 'Rogelio cincire serrato', 'Morelia michoacan', '44 34 63 03 63', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 15:18:33'),
(132, 'normabenus1971@gmail.com', 'Norma Leticia Uribe alvarez', 'Michoacan', '4435270706', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 15:12:30'),
(133, 'anesca164@gmail.com', 'Antonio Espinosa Calvillo ', 'Michoacan ', '4434608065', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 15:31:45'),
(134, 'alonsoisidro862@gmail.com', 'Isidro Alonso Gaona ', '', '4433096959', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-12-03 19:27:47'),
(135, '1702736k@umich.mx', 'Sandra Paola Paramo Ruiz', 'Michoacan ', '4434954531', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 19:16:08'),
(136, '1701485d@umich.mx', 'Alondra Alexandra Gutiérrez Aréval', 'Michoacán de Ocampo', '4431585815', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(137, 'akarsa.03e@gmail.com', 'Gloria Espinoza Ruiz ', 'Michoacán', '4434755916', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 15:27:48'),
(138, 'jalexisacug@gmail.com', 'José Alexis Acuña García ', 'Michoacán ', '4433484826', 'Hombre', 'Validado', '2024-11-27 20:54:52', '2024-11-28 15:44:48'),
(139, 'lolmp29@gmail.com', 'MA ', 'Ma. Dolores Maldonado Pineda', '435 103 588 ', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(140, 'patyalaniscor@gmail.com', 'Ana Patricia ', 'Morelia Michoacán', '7861595595', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(141, 'edgarfelix1019@gmail.com', 'Edgar Félix García Dí', 'Michoacán', '4431372625', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(142, 'sanrusy@gmail.com', 'SANDRA ROCIO VARELA CORTÉS', 'Michoacán', '5516180608', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 14:29:43'),
(143, 'luis.razocr@gmail.com', 'Luis Razo Cornejo ', 'Michoacán', '4361489371', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(144, 'luisricot7@gmail.com', 'Luis Rico Tinoco ', 'Michoacán', '4433776457', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(145, 'mariamcazarezs@gmail.com', 'Mariam Samantha Cazarez Sanchez ', 'Michoacan ', '4522038410', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 15:43:51'),
(146, 'rodrigoreyescampos19@gmail.com', 'Rodrigo Reyes Campos ', 'Michoacan', '4432185773', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 17:06:58'),
(147, 'reyes.campos.abogados@gmail.com', 'JOSÉ RODRIGO REYES PERE', 'Michoacán', '4431614277', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 17:07:50'),
(148, 'cpimeldag@gmail.com', 'Natalia Itzel Estrada Guzmán', 'Michoacán', '4431061235', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 14:27:48'),
(149, 'carohern1013@gmail.com', 'Carolina Calderón Hernánde', 'Michoacán', '4434844004', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 15:28:39'),
(150, 'borismargot@gmail.com', 'Margarita Campos Estrada', 'Michoacan', '4431328598', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 17:08:26'),
(151, 'rosariocastellanos8279@gmail.com', 'Marìa Del Rosario Valle Garcì', 'Michoacán', '4431873273', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(152, 'bustosmartin8701@gmail.com', 'Martin Bustos Solano ', 'Michoacán', '4434835946', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 23:54:00'),
(153, 'arminortiz581@gmail.com', 'Armin Ortiz Esquivel ', 'Michoacán', '4433494125', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(154, 'prettylorezita@gmail.com', 'Lorena Lachino Barboza ', 'Michoacán', '4432608284', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 14:28:02'),
(155, 'arturo.luz19@gmail.com', 'Carlos Arturo Saavedra Chavez', 'Michoacan', '4433857776', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(156, 'gerardopt43@gmail.com', 'GERARDO PEDRAZA TORRES', 'MICHOACÁN', '4431464616', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(157, 'emcer2016@gmail.com', 'Eduardo Montaño Calvillo', 'Michoacán', '4433509586', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(158, 'enriqueguzman3670@gmail.com', 'Luis Enrique Guzmán Martín', 'Michoacá', '4433549200', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 14:47:02'),
(159, 'desaillyn21@gmail.com', 'Chris Desaillyn Madrigal Cerda ', 'Michoacán', '4432712079', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-29 00:12:29'),
(160, 'yamel0295@gmail.com', 'Yamel Maria Anastacio de Jesus ', 'Michoacán', '443 409 6618 ', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 18:53:16'),
(161, 'gracielaperezromero11@gmail.com', 'Graciela Pérez Romero', 'Michoacán', '4435764377', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(162, 'maribelgonzalezcornejo@gmail.com', 'Maribel González Cornejo', 'Michoacán', '44 32 28 07 30', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(163, 'gabrielaggg.sj@gmail.com', 'Gabriela Guadalupe Gonzalez Gutierrez', 'Morelia michoacan ', '4437297215', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(164, 'miguelplancarte189@gmail.com', 'Miguel Plancarte Hermandez ', 'Q.roo', '5578430288', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(165, 'juan89ortiiz@gmail.com', 'Juan Manuel Ortiz Gómez', 'Michoacán', '4431114965', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(166, 'sof971mt1@gmail.com', 'Diana Sofia Muñoz Tapi', 'Michoacán', '4434921366', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(167, 'marielacclzitacuaro01@gmail.com', 'Mariela Zavala Blancas ', 'Michoacan ', '7151469373', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(168, 'juanjesusdg111@gmail.com', 'Juan Jesus Delgado Guzman ', 'Michoacan ', '4435502149', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(169, 'jose.sr@huetamo.tecnm.mx', 'José Alberto Soto Rodrígue', 'Michoacán', '4351054562', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 16:13:22'),
(170, 'tutor17301@univim.edu.mx', 'Enrique Arellano Villagómez', 'Michoacán', '4431665789', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(171, 'analuisasoriano1@gmail.com', 'Ana Luisa Soriano Virrueta ', 'Michoacán', '4433787778', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 14:47:06'),
(172, 'licyedid2010@gmail.com', 'YEDID GUADALUPE  GARCÍA', 'Michoacán', '4431776911', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(173, 'corporativovillanuevaasociados@gmail.com', 'Víctor Villanueva Hernánde', 'Michoacán', '3521135210', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(174, 'hugoame70@gmail.com', 'Hugo Armando Pérez Ventura', 'Michoacán', '3521463056', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(175, 'guadalupemata935@gmail.com', 'María Guadalupe Mata Ponce', 'Michoacán', '4431588400', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 14:55:27'),
(176, '0101889b@umich.mx', 'Adriana Garcia Rodriguez', 'Michoacan', '4434622572', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 15:43:40'),
(177, 'abogacalder@gmail.com', 'Hugo Calderon Sánchez', 'Michoacan ', '4521237882', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 14:56:13'),
(178, 'liceduardoisrael04@gmail.com', 'EDUARDO ISRAEL CONTRERAS RAMIREZ', 'MICHOACÁN DE OCAMP', '4531090110', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 15:27:08'),
(179, 'mayedi.loga96@gmail.com', 'MAYRA EDITH LÓPEZ GARCÍA', 'Michoacán ', '4432651582', 'Mujer', 'Validado', '2024-11-27 20:55:43', '2024-11-28 14:36:34'),
(180, 'setisai.sanchez.g@gmail.com', 'Set Isai Sanchez Garcia ', 'Michoacan', '4431292806', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(181, 'lilianahdz.hh@gmail.com', 'LILIANA HERNANDEZ HERNANDEZ', 'MICHOACÁN', '7713303299', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(182, 'jairosalazar5876@gmail.com', 'Jairo Julian Salazar Esquivel ', 'Michoacán', '4433484522', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 16:01:10'),
(183, 'adisaucedo25@gmail.com', 'Adriana Saucedo Torres', 'Michoacán', '4431423460', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 15:34:28'),
(184, 'alejandra.villa.alubh@gmail.com', 'Alejandra Villa Hernández', 'Michoacán', '4433301849', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(185, 'canoquinterosandy@gmail.com', 'Sandra Citlalli Cano Quintero ', 'Michoacan ', '4435647755', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(186, 'roxycerv23@gmail.com', 'Rosa María Cervantes Tapia', 'Mchoacan', '4532709151', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(187, 'sduquesosa@gmail.com', 'Sebastián duque sosa', 'Michoacán', '443 9359667', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 15:39:59'),
(188, '1836194k@umich.mx', 'Monica soto Calderon ', 'Michoacán', '7531180828', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 14:52:33'),
(189, 'licemmanuelnavarro@gmail.com', 'Emmanuel Navarro Higareda ', 'Michoacán', '4431 367181 ', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 14:28:34'),
(190, 'ernesto.zuniga@umich.mx', 'Ernesto Alino Zuñiga Guerrero', 'Michoacan ', '4432077651', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 16:42:18'),
(191, 'campuzanomiriam5@gmail.com', 'Miriam Campuzano Peña', 'Michoacán', '4431394977', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 19:43:34'),
(192, 'lic_ramirez_lft@hotmail.com', 'Rocio Estefanía Ramírez Sot', 'Michoacán', '4433069420', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 14:27:52'),
(193, 'fernandafloresgomez1986@gmail.com', 'Claudia fernanda flores gomez', 'MICHOACAN', '443 185 4483 ', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(194, 'psicbrendaangel@gmail.com', 'BRENDA BERENICE ANGEL GARCIA', 'Michoacán', '4437357371', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(195, 'jrosalesgaribay@gmail.com', 'Juan Rosales Garibay ', 'MICHOACAN', '4434917884', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(196, 'erandi-martinez2015@outlook.com', 'ERANDI MARTINEZ BARAJAS', 'Michoacán', '4433641162', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 14:42:27'),
(197, 'yspe2828@gmail.com', 'Yareli Sarahí Padilla Espinosa', 'Michoacan', '4431671474', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 14:56:58'),
(198, 'garamolina159@gmail.com', 'Gerardo Molina Mercado ', 'Michoacán', '4432365407', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(199, 'obcjorge99@gmail.com', 'Jorge Martínez Medina', 'Michoacán', '4521447085', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 16:25:08'),
(200, 'rosauroarriaga13@gmail.com', 'Rosario Arriaga Soriano ', 'Michoacán', '4433517044', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(201, 'sarabelenveganegrete33@gmail.com', 'Sara Belén Vega Negrete', 'Michoacán', '436-116-80-68', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 15:07:31'),
(202, 'capiortizmariel@gmail.com', 'Mariel Esperanza Capi Ortiz ', 'Michoacan ', '7531424668', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 14:57:14'),
(203, 'joselincuevas2804@gmail.com', 'Joselin Magaña Faburrieta', 'Michoacan ', '4251396359', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 14:59:23'),
(204, 'franciscomartinezcamacho2a@gmail.com', 'Francisco Martinez Camacho ', 'Morelia mich', '417 180 6575', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(205, '2122210g@umich.mx', 'Lesly Paola Hernadez Guerrero', 'Michoacá', '4439353281', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 15:03:48'),
(206, '2121739d@umich.mx', 'Daniela Jazmín Amado Garcia', 'Soltera ', '4433094822', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 14:57:08'),
(207, 'pukibol10@gmail.com', 'Naomi Celic Campos Ignacio ', 'Morelia ', '7151340415', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 15:07:32'),
(208, '2406122x@umich.mx', 'Sofía Sarahí Manzo Manríqu', 'Michoacán', '4431838525', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 14:57:25'),
(209, 'erhduardo3@gmail.com', 'Eduardo Hipólito Reyes', 'Michoacán', '443 371 7308', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(210, 'y.susana.ms@gmail.com', 'Yaritza Susana Moreno Salazar', 'Michoacán', '4431665854', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(211, '2122946j@umich.mx', 'Alisson Naomi Calderón Hernánde', 'Michoacán', '4433831191', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 14:58:25'),
(212, '2405672j@umich.mx', 'Abraham Gudiño Morfin', 'Michoacán', '4437073713', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 14:59:28'),
(213, '2226609x@umich.mx', 'Laura Juanita García Valle', 'Michoacán', '4439400554', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 15:18:24'),
(214, 'maricarment144@gmail.com', 'Maria del Carmen Torres Villagomez ', 'Michoacán', '4433541082', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 14:57:00'),
(215, 'esteban1233819@gmail.com', 'Esteban Infante González', 'Michoacan', '4437078530', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 14:59:44'),
(216, 'jairogarciayzy@gmail.com', 'Jairo César García Mo', 'Michoacán', '4171029250', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 14:58:56'),
(217, 'david.hdez077@gmail.com', 'Zoé David Hernández Lóp', 'Michoacan', '4436345146', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(218, 'raulitofam@gmail.com', 'Raúl Díaz Caballe', 'Michoacan ', '4433869096', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(219, 'aguilarmarcodaniel@gmail.com', 'Marco Daniel Aguilar ', 'Michoacán', '459 121 9458', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 15:04:09'),
(220, 'luisgarciaalt792@gmail.com', 'Luis Gabriel Aguilar García', 'Michoacá', '4341165424', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 14:59:30'),
(221, 'lu_ric_oce@hotmail.com', 'Luis Ricardo Ocegueda Gonzále', 'Michoacán', '4432141981', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(222, 'saavedraceleste036@gmail.com', 'Celeste Saavedra Rivera ', 'Michoacán', '4432237452', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(223, 'rivelaz24@gmail.com', 'Lic. Juan Velázquez Río', 'Michoacán', '4471147207', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(224, 'cmedinaurtiz@gmail.com', 'Carlos Alberto Medina Urtiz ', 'Michoacán De Ocampo', '4521206836', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(225, 'mariaguadalupevegapatino59@gmail.com', 'María Guadalupe Vega Patiñ', 'Michoacán', '4439387583', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(226, 'vudumetalico23@gmail.com', 'Luis Angel García Fernánde', 'Michoacán', '4521072730', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(227, 'diegoarreola189@gmail.com', 'DIEGO BALTAZAR ARREOLA LINARES ', 'Michoacán', '4436913532', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 15:35:21'),
(228, 'sergio.a.guzman2001@gmail.com', 'Sergio Alfonso Guzmán Barajas', 'Michoacán', '4171196041', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 15:39:51'),
(229, 'patyvences1684@gmail.com', 'Patricia Vences Padilla', 'Michoacán', '4431985985', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 15:09:41'),
(230, '0687583a@umich.mx', 'Frank Joseph Pfister González', 'Michoacán', '4432026312', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 14:51:11'),
(231, 'carmentecario@gmail.com', 'María del Carmen García Rodrígu', 'Michoacan', '4431345219', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 14:51:54'),
(232, '9923093g@umich.mx', 'Miguel de Jesus Sanchez Perez', 'Michoacán', '753 110 8309 ', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(233, 'an804925@gmail.com', 'Alondra', 'Morelia Michoacan ', '4431699282', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(234, 'cobarrubiasavalosirisvaleria6@gmail.com', 'Iris Valeria Cobarrubias Avalos', 'Michoacan', '4472035918', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 15:09:30'),
(235, 'eduardo555muter@gmail.com', 'Jose Guadalupe Garcia Chavez', 'Michoacán', '4434006023', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(236, 'andradeesmeralda90@gmail.com', 'Esmeralda Andrade Tovar', 'Michoacán', '4432273055', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(237, 'jgch.200942@gmail.com', 'José Eduardo Garcia Calzada', 'Michoacán', '4434006023', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 15:34:51'),
(238, 'sanchezmontesevelin@gmail.com', 'Evelin Mireille Montiel Sánchez', 'Michoacán', '4531442129', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 15:18:15'),
(239, 'jorgeoratoria@gmail.com', 'Jorge Ibarra Aguilar', 'Michoacan ', '3541091782', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(240, 'ius.abogadosj@gmail.com', 'Jonathan Gulialo Mendoza Campos', 'MICHOACÁ', '4521535664', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 15:42:08'),
(241, 'manelopez076@gmail.com', 'JOSE MANUEL LOPEZ LOPEZ', 'Michoacan ', '3111224065', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(242, 'omendoza.geovani@gmail.com', 'Geovani Aldahir Mendoza Pureco ', 'MICHOACAN', '4341046493', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(243, 'opedrazat8@gmail.com', 'OLIVIA PEDRAZA TORRES', 'MICHOACÁ', '4591118177', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 17:08:21'),
(244, 'iselabarrera25@gmail.com', 'ROSA ISELA BARRERA VALDÉ', 'Michoacan de ocampo ', '4431101372', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 17:07:55'),
(245, '1925809g@umich.mx', 'Karla Lizbeth Antonio Garcia ', 'MICHOACÁN', '7531644729', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(246, 'zunomanuel@gmail.com', 'MANUEL ZUNO RAMÍREZ', 'Michoacán', '4434223679', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(247, '1911648f@umich.mx', 'Edgar Iván Martínez Barrer', 'Michoacán', '4436938395', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(248, 'kafer0699@gmail.com', 'Karla Fernanda González Gonzále', 'Sinaloa ', '4434921269', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 14:29:20'),
(249, 'kariizn2@gmail.com', 'Karina Zamudio Núñe', 'Michoacán', '6672342382', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 14:57:47'),
(250, 'cardellina.rubra@gmail.com', 'Nelida Velázquez Río', 'Michoacan ', '4471111526', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(251, 'mariamcazarez@hotmail.com', 'Aram Eliud Diaz Delgado ', 'Michoacán', '443 273 6901', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(252, 'c.alejandro.h.p@gmail.com', 'Emmanuel Alejandro Hernández Pére', 'Michoacan', '4436424564', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(253, 'rmargarito@hotmail.com', 'Margarito Rosales Garibay ', 'Michoacán', '4435592359', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(254, 'leislievelasco@gmail.com', 'Leislie Melina Velasco Cortea', 'Michoacán', '4433886633', 'Mujer', 'Validado', '0000-00-00 00:00:00', '2024-11-28 14:21:30'),
(255, '1590195h@umich.mx', 'Ana Victoria Villegas Díaz', 'MICHOACÁ', '4431458622', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(256, 'hectorruelitas666@gmail.com', 'HECTOR GARCIA RUELAS', 'Michoacán', '4435293934', 'Hombre', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(257, 'aurarreygue@gmail.com', 'AURA MONSERRAT ARREYGUE MORENO', 'Michoacán', '4432350701', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(258, 'yadhiraramirez319@gmail.com', 'Yadhira Ramírez Carrillo', 'Sinaloa ', '443 161 0040 ', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(259, 'quinterobeltran150302@gmail.com', 'Guadalupe Quintero Beltrán', 'Michoacán', '6644948144', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(260, 'evaluacion.coepredv@gmail.com', 'Carlos Alberto Mendoza Madrigal', 'Michoacán', '4431826020', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 15:08:55'),
(261, '1912426g@umich.mx', 'Diana Arrellano Zavala ', 'Michoacán', '4433580244', 'Mujer', 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(262, 'lic.tribunoramirez@gmail.com', 'Ivan Ruben Ramirez Mendoza', 'Michoacán ', '4433952136', 'Hombre', 'Validado', '2024-11-27 21:00:21', '2024-11-28 15:12:43'),
(263, 'nunoleslye@gmail.com', 'Leslye Natalia Nuño Zazueta', 'Sinaloa', '6675137764', 'Mujer', 'Validado', '2024-11-27 21:00:21', '2024-11-28 14:58:12'),
(500, 'badruch39@gmail.com', 'Hernan de Jesus Hernández Herrer', 'Michoacán', '4431119973', 'Hombre', 'Validado', '0000-00-00 00:00:00', '2024-11-28 15:17:43'),
(501, 'amedina@cclmichoacan.gob.mx', 'Andrés Medina Guzmán', 'Michoacán ', '5585460679', 'Hombre', 'Validado', '2024-11-27 20:56:51', '2024-11-27 22:11:01'),
(502, '2216478b@umich.mx', 'Luciana Flores Arreola', 'Michoacán', '4438451305', 'Mujer', 'Validado', '2024-12-02 16:12:38', '2024-12-02 16:12:38'),
(503, 'prdalejandra9@xn--gmail-sta.com', 'Alejandra Cortés Zambrano', 'Michoacán', '4434032818', 'Mujer', 'Validado', '2024-12-02 16:12:52', '2024-12-02 16:12:52'),
(504, '2254528e@umich.mx', 'Macias Ruiz Natalia', 'Michoacán', '4434510396', 'Mujer', 'Validado', '2024-12-02 16:18:00', '2024-12-02 16:18:00'),
(505, 'poncedeLeonf99@gmail.com', 'Fabricio Ponce de Leon', 'Michoacán', '4432398318', 'Hombre', 'Validado', '2024-12-02 16:19:08', '2024-12-02 16:19:08'),
(506, 'gabyhdez@hotmail.com', 'Gabriela Hernandez', 'Michoacán', '4439157512', 'Mujer', 'Validado', '2024-12-02 16:20:27', '2024-12-02 16:20:27'),
(507, 'alberto_mtz88@gmail.com', 'Luis Alberto Martinez', 'Michoacán', '4434503443', 'Hombre', 'Validado', '2024-12-02 16:22:34', '2024-12-02 16:22:34'),
(508, '2216649g@umich.mx', 'Abraham Sanchez Arroyo', 'Michoacán', '443372225', 'Hombre', 'Validado', '2024-12-02 16:27:18', '2024-12-02 16:27:18'),
(509, '2215967h@umich.mx', 'Pedro Alvarez Corrillo', 'Michoacán', '4438384723', 'Hombre', 'Validado', '2024-12-02 16:33:20', '2024-12-02 16:33:20'),
(510, 'Leticiaaldes@gmail.com', 'Leticia Espino Valdes', 'Michoacán', '4432256027', 'Mujer', 'Validado', '2024-12-02 16:37:27', '2024-12-02 16:37:27'),
(511, 'Lopzmendes@gmail.com', 'Elvia Lopez Mendes', 'Michoacán', '4431980222', 'Mujer', 'Validado', '2024-12-02 16:39:39', '2024-12-02 16:39:39'),
(512, '2216626a@umich.mx', 'Valeria Ochoa Zamudio', 'Michoacán', '4439355058', 'Mujer', 'Validado', '2024-12-02 16:39:45', '2024-12-02 16:39:45'),
(513, '2123354f@umich.mx', 'Ashley Elizabeth Cortes', 'Michoacán', '4436397347', 'Mujer', 'Validado', '2024-12-02 16:41:20', '2024-12-02 16:41:20'),
(514, 'Lopes@gmail.com', 'Baneza Sanches Lopes', 'Michoacán', '4431980222', 'Mujer', 'Validado', '2024-12-02 16:42:29', '2024-12-02 16:42:29'),
(515, '2215573k@umich.mx', 'Juan Carlos Arroyo Mdz', 'Michoacán', '4431674944', 'Hombre', 'Validado', '2024-12-02 16:42:58', '2024-12-02 16:42:58'),
(516, 'Valdez@gmail.com', 'Ana Maria Espino Valdez', 'Michoacán', '4431114336', 'Mujer', 'Validado', '2024-12-02 16:44:05', '2024-12-02 16:44:05'),
(517, '2216202@umich.mx', 'Josselyne Paulina Maldonado Ramirez', 'Michoacán', '4431817857', 'Mujer', 'Validado', '2024-12-02 16:44:59', '2024-12-02 16:44:59'),
(518, 'Valdez@gmail.com', 'Salvador Espino Valdez', 'Michoacán', '4431114336', 'Hombre', 'Validado', '2024-12-02 16:45:35', '2024-12-02 16:45:35'),
(519, '2215711c@umich.mx', 'Cintia Quintana Santillan', 'Michoacán', '4433775295', 'Mujer', 'Validado', '2024-12-02 16:46:03', '2024-12-02 16:46:03'),
(520, '2215679k@umich.mx', 'Esmeralda Arreola Suarez', 'Michoacán', '4433938530', 'Mujer', 'Validado', '2024-12-02 16:47:23', '2024-12-02 16:47:23'),
(521, '2216186h@umich.mx', 'Frida Paola Rodriguez', 'Michoacán', '4431919563', 'Mujer', 'Validado', '2024-12-02 16:49:27', '2024-12-02 16:49:27'),
(522, 'Andres@gmail.com', 'Juan Andres Reyn', 'Quintanaroo', '9983370217', 'Hombre', 'Validado', '2024-12-02 16:50:29', '2024-12-02 16:50:29'),
(523, 'aliciagarcia@gmail.com', 'Alicia Garcia', 'Michoacán', '-', 'Mujer', 'Validado', '2024-12-02 16:51:28', '2024-12-02 16:51:28'),
(524, '2216508b@umich.mx', 'Armando Joshua Alvarado Soto', 'Michoacán', '4432284489', 'Hombre', 'Validado', '2024-12-02 16:51:59', '2024-12-02 16:51:59'),
(525, 'ayalacorreoa@gmail.com', 'Alberto Ayala Correa', 'Michoacán', '4434409405', 'Hombre', 'Validado', '2024-12-02 16:53:11', '2024-12-02 16:53:11'),
(526, '2216079e@umich.mx', 'Jackeline Ventura Candelario', 'Michoacán', '4434386014', 'Mujer', 'Validado', '2024-12-02 16:53:15', '2024-12-02 16:53:15'),
(527, 'Ramirez@gmail.com', 'Ramirez', 'Michoacán', '443221309', 'Hombre', 'Validado', '2024-12-02 16:55:17', '2024-12-02 16:55:17'),
(528, 'Veronica@gmail.com', 'Veronica Morales Ruiz', 'Michoacán', '44432667682', 'Mujer', 'Validado', '2024-12-02 16:57:20', '2024-12-02 16:57:20'),
(529, 'Cham_12_12@gmail.com', 'Juan Carlos Higuera Alvarado', 'Michoacán', '6672094567', 'Hombre', 'Validado', '2024-12-02 16:59:07', '2024-12-02 16:59:07'),
(530, 'jca8596@gmail.com', 'Julieta Cuevas Arroyo', 'Michoacán', '3329739949', 'Mujer', 'Validado', '2024-12-02 17:00:52', '2024-12-02 17:00:52'),
(531, '2216710x@umich.mx', 'Ximena Montserrat Merino Toledo', 'Michoacán', '4436867373', 'Mujer', 'Validado', '2024-12-02 17:02:22', '2024-12-02 17:02:22'),
(532, '2216684j@umich.mx', 'Miranda Garcia Casillas', 'Michoacán', '4531195483', 'Mujer', 'Validado', '2024-12-02 17:03:23', '2024-12-02 17:03:23'),
(533, '2215875j@umich.mx', 'Valeria Ayala Ortiz', 'Michoacán', '4432180381', 'Mujer', 'Validado', '2024-12-02 17:04:09', '2024-12-02 17:04:09'),
(534, 'gaviaute200@gmail.com', 'Isidro Alonso Garcia', 'Michoacán', '33096959', 'Hombre', 'Validado', '2024-12-02 17:04:28', '2024-12-02 17:04:28'),
(535, 'elizabeth_chacas8@gmail.com', 'Elizabeth Chavez', 'Michoacán', '4431836603', 'Mujer', 'Validado', '2024-12-02 17:06:43', '2024-12-02 17:06:43'),
(536, '2217872k@umich.mx', 'Agilar Sanchez Rogelio', 'Michoacán', '4431165724', 'Hombre', 'Validado', '2024-12-02 17:07:29', '2024-12-02 17:07:29'),
(537, '2216073h@umich.mx', 'Jessica Valdovinos Corona', 'Michoacán', '4432594203', 'Mujer', 'Validado', '2024-12-02 17:08:19', '2024-12-02 17:08:19'),
(538, 'Sol1985-cos@hotmail.com', 'Ma. del Sol Contreras', 'Michoacán', '4431266921', 'Mujer', 'Validado', '2024-12-02 17:08:31', '2024-12-02 17:08:31'),
(539, '2223370f@umich.mx', 'Gloria Jocelyn Equihua Moreles', 'Michoacán', '4438585001', 'Mujer', 'Validado', '2024-12-02 17:09:14', '2024-12-02 17:09:14'),
(540, '2216259f@umich.mx', 'Genesis Vazquez Peguero', 'Michoacán', '4435926891', 'Mujer', 'Validado', '2024-12-02 17:10:30', '2024-12-02 17:10:30'),
(541, '2216329k@umich.mx', 'Pamela Wendoli Calderon Calderon', 'Michoacán', '4431062417', 'Mujer', 'Validado', '2024-12-02 17:11:59', '2024-12-02 17:11:59'),
(542, 'eduardoil.@gmail.com', 'Eduardo Reyes', 'Michoacán', '4433717308', 'Hombre', 'Validado', '2024-12-02 17:12:29', '2024-12-02 17:12:29'),
(543, '2216465h@umich.mx', 'Tristan Alexander Hernandez Sarabia', 'Michoacán', '4432062829', 'Mujer', 'Validado', '2024-12-02 17:13:05', '2024-12-02 17:13:05'),
(544, 'derechovi.rocio@gmail.com', 'Rocio Camacho Jose', 'Michoacán', '4431612685', 'Mujer', 'Validado', '2024-12-02 17:14:07', '2024-12-02 17:14:07'),
(545, '2218312c@umich.mx', 'Fernanda Isabel Tapia Luna', 'Michoacán', '4434490479', 'Mujer', 'Validado', '2024-12-02 17:14:21', '2024-12-02 17:14:21'),
(546, '2216086c@gmail.com', 'Iker Ignacio Lopez', 'Michoacán', '4434924695', 'Hombre', 'Validado', '2024-12-02 17:15:21', '2024-12-02 17:15:21'),
(547, '2217674e@umich.mx', 'Axel Andre Abrego Vazquez', 'Michoacán', '4432707167', 'Hombre', 'Validado', '2024-12-02 17:15:30', '2024-12-02 17:15:30'),
(548, '2216261x@umich.mx', 'Senifer Isbem Garcia Garcia', 'Michoacán', '4436272754', 'Mujer', 'Validado', '2024-12-02 17:16:53', '2024-12-02 17:16:53'),
(549, '2223318e@umich.mx', 'Yaretzi Linares', 'Michoacán', '4433457635', 'Mujer', 'Validado', '2024-12-02 17:17:00', '2024-12-02 17:17:00'),
(550, '2217887d@umich.mx', 'Daira Isabel Tapia Mtz', 'Michoacán', '4436110687', 'Mujer', 'Validado', '2024-12-02 17:18:08', '2024-12-02 17:18:08'),
(551, 'Despachojuridicolopez@hotmail.com', 'Edder Lopez Gonzales', 'Michoacán', '4361118985', 'Hombre', 'Validado', '2024-12-02 17:19:59', '2024-12-02 17:19:59'),
(552, '2216428d@umich.mx', 'Alan Giovanny Celaya', 'Michoacán', '4438329118', 'Hombre', 'Validado', '2024-12-02 17:20:06', '2024-12-02 17:20:06'),
(553, '3203256g@umich.mx', 'German Vasquez', 'Michoacán', '4431646618', 'Hombre', 'Validado', '2024-12-02 17:21:24', '2024-12-02 17:21:24'),
(554, 'sectecnica.ccl@michoacan.gob.mx', 'Alexa Lopez Gonzalez', 'Michoacán', '4431337135', 'Mujer', 'Validado', '2024-12-02 17:23:05', '2024-12-02 17:23:05'),
(555, 'sectecnica.ccl@michoacan.gob.mx', 'Victor Hugo Villagomez Ortiz', 'Michoacán', '4431381264', 'Hombre', 'Validado', '2024-12-02 17:23:44', '2024-12-02 17:23:44'),
(556, 'alejandro71@hotmail.com', 'Alejandro Aviles', 'Michoacán', '5518532280', '', 'Validado', '2024-12-02 17:23:59', '2024-12-02 17:23:59'),
(557, 'jdjmenez_95@gmail.com', 'Jose Daniel Jimenez Orozco', 'Michoacán', '4432143263', 'Hombre', 'Validado', '2024-12-02 17:24:43', '2024-12-02 17:24:43');
INSERT INTO `segundo_encuentro` (`id`, `correo`, `nombre`, `estado`, `celular`, `genero`, `estatus`, `created_at`, `updated_at`) VALUES
(558, 'Saul@gmail.com', 'Saul Acosta', 'Michoacán', '4439444006', 'Hombre', 'Validado', '2024-12-02 17:25:07', '2024-12-02 17:25:07'),
(559, 'michael.perea05@gmail.com', 'Michael Emmanuel Perea Garcia', 'Michoacán', '7221045490', 'Hombre', 'Validado', '2024-12-02 17:25:51', '2024-12-02 17:25:51'),
(560, 'cnv.72cn@gmail.com', 'Claudia Moteras Velazquez', 'Michoacán', '4431280098', 'Mujer', 'Validado', '2024-12-02 17:27:14', '2024-12-02 17:27:14'),
(561, 'juliovazquez79340@gmail.com', 'Julio Vazquez', 'Michoacán', '4432622924', 'Hombre', 'Validado', '2024-12-02 17:28:28', '2024-12-02 17:28:28'),
(562, 'Gabriela@gmail.cojm', 'Gabriela Caballero', 'Michoacán', '4591661515', 'Mujer', 'Validado', '2024-12-02 17:30:00', '2024-12-02 17:30:00'),
(563, 'marielazb240490@gmail.com', 'Mariela Zavala Blanca', 'Michoacán', '715146370', 'Mujer', 'Validado', '2024-12-02 17:31:01', '2024-12-02 17:31:01'),
(564, 'Mcossilva@outlook.com', 'Miguel Silva', 'Michoacán', '4434359182', 'Hombre', 'Validado', '2024-12-02 17:31:39', '2024-12-02 17:31:39'),
(565, 'candY@gmail.com', 'Candy Rodriguez', 'Michoacán', '4432649531', 'Mujer', 'Validado', '2024-12-02 17:33:13', '2024-12-02 17:33:13'),
(566, 'epigv2094@gmail.com', 'Epifanio Gonzalesz Vanegas', 'Michoacán', '7151203417', 'Hombre', 'Validado', '2024-12-02 17:33:28', '2024-12-02 17:33:28'),
(567, 'mifraxiii@gmail.com', 'Miranda Franco', 'Michoacán', '4434765313', 'Mujer', 'Validado', '2024-12-02 17:34:34', '2024-12-02 17:34:34'),
(568, '221632aA@umich.mx', 'Pamela Wendeli Calderon Calderon', 'Michoacán', '4431062417', 'Mujer', 'Validado', '2024-12-02 17:36:27', '2024-12-02 17:36:27'),
(569, 'viriguillen12@hotmail.com', 'Viridiana Sarahi Guillen Correa', 'Michoacán', '4431903851', 'Mujer', 'Validado', '2024-12-02 17:38:04', '2024-12-02 17:38:04'),
(570, 'carolgpeFernandez@hotmail.com', 'Carol Fernandez', 'Michoacán', '4439240024', 'Mujer', 'Validado', '2024-12-02 17:39:26', '2024-12-02 17:39:26'),
(571, 'Arturo@gmail.com', 'Arturo Adalid Sanchez Sanchez', 'Michoacán', '7531211766', 'Hombre', 'Validado', '2024-12-02 17:40:38', '2024-12-02 17:40:38'),
(572, 'emonrdaz24@hotmail.com', 'Emmanuel Ordaz Duelos', 'Michoacán', '4361040068', 'Hombre', 'Validado', '2024-12-02 17:43:07', '2024-12-02 17:43:07'),
(573, 'fernando761001@gmail.com', 'Marlene del Carmen Rofrigez Huerta', 'Michoacán', '4535157713', 'Mujer', 'Validado', '2024-12-02 17:43:24', '2024-12-02 17:43:24'),
(574, '199@umich.mx', 'Hector Garcia', 'Michoacán', '443457910', 'Hombre', 'Validado', '2024-12-02 17:44:04', '2024-12-02 17:44:04'),
(575, 'fernando761001@gmail.com', 'Fabiola Guerra Alvarez', 'Michoacán', '4535157713', 'Mujer', 'Validado', '2024-12-02 17:44:17', '2024-12-02 17:44:17'),
(576, 'Slayer66655@hotmail.com', 'Emmanuel Rojas Martinez', 'Michoacán', '4591332491', 'Hombre', 'Validado', '2024-12-02 17:45:27', '2024-12-02 17:45:27'),
(577, '2125035k@gmail.com', 'Gerardo Guerrero', 'Michoacán', '4251052064', 'Hombre', 'Validado', '2024-12-02 17:46:53', '2024-12-02 17:46:53'),
(578, '1834632k@umich.mx', 'Angel Medrano Campos', 'Michoacán', '4351155777', 'Hombre', 'Validado', '2024-12-02 17:48:06', '2024-12-02 17:48:06'),
(579, 'martha.hernandez@umich.mx', 'Martha Rocio Hernandez Martinez', 'Michoacán', '4433026612', 'Mujer', 'Validado', '2024-12-02 17:49:16', '2024-12-02 17:49:16'),
(580, 'nutis@hotmail.com', 'Maria Villegas', 'Michoacán', '4433761995', 'Mujer', 'Validado', '2024-12-02 17:52:12', '2024-12-02 17:52:12'),
(581, 'fernando761001@gmail.com', 'Fernando Fernandez Castañeda', 'Michoacán', '4535157713', 'Hombre', 'Validado', '2024-12-02 17:53:09', '2024-12-02 17:53:09'),
(582, 'titavargas@gmail.com', 'Martha Vargas', 'Michoacán', '4433022802', 'Mujer', 'Validado', '2024-12-02 17:53:31', '2024-12-02 17:53:31'),
(583, 'vinculacioncceprediv@gmail.com', 'Martha', 'Michoacán', '3511144057', 'Mujer', 'Validado', '2024-12-02 17:55:10', '2024-12-02 17:55:10'),
(584, 'YanayEcheverria@gmail.com', 'Yanay Echeverria', 'Quintanaroo', '9832100414', 'Mujer', 'Validado', '2024-12-02 17:57:24', '2024-12-02 17:57:24'),
(585, 'lic.lopezmon76@hotmail.com', 'Jose Manuel Lopez Lopez', 'Michoacán', '3111224065', 'Hombre', 'Validado', '2024-12-02 17:58:38', '2024-12-02 17:58:38'),
(586, 'maggaly.bautista@umich.mx', 'Maggaly Bautista Chavez', 'Michoacán', '4433693767', 'Mujer', 'Validado', '2024-12-02 18:00:03', '2024-12-02 18:00:03'),
(587, 'tego_13calderon@hotmail.com', 'Hector Diaz Calderon', 'Michoacán', '4433952557', 'Hombre', 'Validado', '2024-12-02 18:01:27', '2024-12-02 18:01:27'),
(588, 'avy.yesenia@gmail.com', 'Yesenia Arteaga Vences', 'Michoacán', '4431370661', 'Mujer', 'Validado', '2024-12-02 18:02:11', '2024-12-02 18:02:11'),
(589, 'MENKVILLA@gmail.com', 'Guillermo Villaverde', 'Sinaloa', '6679237265', 'Hombre', 'Validado', '2024-12-02 18:02:22', '2024-12-02 18:02:22'),
(590, 'samuel_concinos@outlook.com', 'Samuel Eneinos Lopes', 'Michoacán', '4435460850', 'Hombre', 'Validado', '2024-12-02 18:03:18', '2024-12-02 18:03:18'),
(591, 'irais1977yunuen@gmail.com', 'Irais Yunuen Rangel Duran', 'Michoacán', '4435661514', 'Mujer', 'Validado', '2024-12-02 18:04:00', '2024-12-02 18:04:00'),
(592, 'lic.jgmartinez@gmail.com', 'Jose Guadalupe Martinez', 'Guanajuato', '4561235645', 'Hombre', 'Validado', '2024-12-02 18:06:26', '2024-12-02 18:06:26'),
(593, 'isuikos@gmail.com', 'Luis Angel Rayon Alvarez', 'Michoacán', '4432401551', 'Hombre', 'Validado', '2024-12-02 18:08:11', '2024-12-02 18:08:11'),
(594, 'mike-marco55@hotmail.com', 'Marco Arturo Rangel', 'Michoacán', '4431035490', 'Hombre', 'Validado', '2024-12-02 18:08:20', '2024-12-02 18:08:20'),
(595, 'perezvillak4@k4.com', 'Kimberly Daniela Perez', 'Michoacán', '4434057021', 'Mujer', 'Validado', '2024-12-02 18:10:32', '2024-12-02 18:10:32'),
(596, 'Alexis904060@gmail.com', 'Alexis Martinez Rangel', 'Michoacán', '4431806040', 'Hombre', 'Validado', '2024-12-02 18:13:13', '2024-12-02 18:13:13'),
(597, 'Victorp1@gmail.com', 'Victor Manuel Morales', 'Michoacán', '4431857076', 'Hombre', 'Validado', '2024-12-02 18:14:24', '2024-12-02 18:14:24'),
(598, 'payvb74@hotmail.com', 'Paola Villa', 'Michoacán', '4431368079', 'Mujer', 'Validado', '2024-12-02 18:15:39', '2024-12-02 18:15:39'),
(599, 'rosariocastelbnos@gmail.com', 'Maria del Rosario Valles', 'Michoacán', '4431873273', 'Mujer', 'Validado', '2024-12-02 18:16:52', '2024-12-02 18:16:52'),
(600, 'cristophermendedoza97@gmail.com', 'Cristhpher Mendoza Rangel', 'Michoacán', '443227517', 'Hombre', 'Validado', '2024-12-02 18:18:05', '2024-12-02 18:18:05'),
(601, '1701531F@umich.mx', 'Jesús Manuel Correa', 'Michoacán', '4431909696', 'Hombre', 'Validado', '2024-12-02 18:18:56', '2024-12-02 18:18:56'),
(602, 'cesara_23@hotmail.com', 'Josue Gabriel Maldonado Prado', 'Michoacán', '4434871732', 'Hombre', 'Validado', '2024-12-02 18:20:14', '2024-12-02 18:20:14'),
(603, 'xavier.ironx@umich.mx', 'Xavier Garcia Escobedo', 'Michoacán', '4432632355', 'Hombre', 'Validado', '2024-12-02 18:21:21', '2024-12-02 18:21:21'),
(604, 'ornelia.duarte@umich.mx', 'Ornelia Duarte Duarte', 'Michoacán', '4432167304', 'Mujer', 'Validado', '2024-12-02 18:22:14', '2024-12-02 18:22:14'),
(605, 'Ruth@gmail.com', 'Ruth Jaramillo', '-', '-', '', 'Validado', '2024-12-02 18:23:15', '2024-12-02 18:23:15'),
(606, 'svarela@cclmichoacan.gob.mx', 'SANDRA ROCÍO VARELA CORTÉS', 'Michoacán', '5516180608', 'Mujer', 'Validado', '2024-12-02 18:27:41', '2024-12-02 18:27:41'),
(607, 'matse.meza.96@gmail.com', 'Montserrat Meza De la Cruz', 'Michoacán', '3511111041', 'Mujer', 'Validado', '2024-12-02 18:29:00', '2024-12-02 18:29:00'),
(608, 'andres_carrillod@umich.mx', 'Victor Andres Carrillo', 'Michoacán', '4431201696', 'Hombre', 'Validado', '2024-12-02 18:30:13', '2024-12-02 18:30:13'),
(609, '2215982b@umich.mx', 'Iris Mariana Soto', 'Michoacán', '4431942926', 'Mujer', 'Validado', '2024-12-02 18:31:10', '2024-12-02 18:31:10'),
(610, 'gaspar.lg@tacambaro.tecmo.mx', 'Gasper Leon Gil', 'Michoacán', '4431748037', 'Hombre', 'Validado', '2024-12-02 18:32:04', '2024-12-02 18:32:04'),
(611, '2216259f@umich.mx', 'Genesis Vazquez', 'Michoacán', '4435926891', 'Mujer', 'Validado', '2024-12-02 18:32:36', '2024-12-02 18:32:36'),
(612, 'victorhertiz07@gmail.com', 'Victor HErnandez Ortiz', 'Edo. Mex', '7223463447', 'Hombre', 'Validado', '2024-12-02 18:33:16', '2024-12-02 18:33:16'),
(613, 'auralyst_1@hotmail.com', 'Laura Rosa Torres Paz', 'Michoacán', '4439241871', 'Mujer', 'Validado', '2024-12-02 18:33:39', '2024-12-02 18:33:39'),
(614, 'marthaleticiacastrolopez@gmaol.com', 'Martha Leticia Castro Lopez', 'Michoacán', '4431374411', 'Mujer', 'Validado', '2024-12-02 18:34:00', '2024-12-02 18:34:00'),
(615, 'sonia.lopez@umich.mx', 'Sonia Loipez Ortiz', 'Michoacán', '4432185612', 'Mujer', 'Validado', '2024-12-02 18:34:30', '2024-12-02 18:34:30'),
(616, 'IL39355K@umic.mx', 'Ibarra Hernandez', 'Michoacán', '4439126660', 'Hombre', 'Validado', '2024-12-02 18:35:17', '2024-12-02 18:35:17'),
(617, 'Pineda@gmail.com', 'Ma. Dolores Maldonado Pineda', 'Michoacán', '4521778570', 'Mujer', 'Validado', '2024-12-02 18:36:33', '2024-12-02 18:36:33'),
(618, 'marisollopezfigueroa@gmail.com', 'Marisol Lopez Figueroa', 'Michoacán', '4521778570', 'Mujer', 'Validado', '2024-12-02 18:37:46', '2024-12-02 18:37:46'),
(619, 'Luisbc770727@gmail.com', 'Luis Angel Benitez', 'Michoacán', '443865', 'Hombre', 'Validado', '2024-12-02 18:39:11', '2024-12-02 18:39:11'),
(620, '17012476@umich.mx', 'Jorge Arturo', 'Michoacán', '4431644007', 'Hombre', 'Validado', '2024-12-02 18:40:10', '2024-12-02 18:40:10'),
(621, 'chekovargas@gmail.com', 'Sergio Antonio Vargtas Chavez', 'Michoacán', '4436549665', 'Mujer', 'Validado', '2024-12-02 18:41:27', '2024-12-02 18:41:27'),
(622, 'gladys_vega17@hotmail.com', 'Gladys Vega Villareal', 'Michoacán', '4361006158', 'Mujer', 'Validado', '2024-12-02 18:46:02', '2024-12-02 18:46:02'),
(623, '2123193@gmail.com', 'Araceli Castellanos Rosales', 'Michoacán', '4431925207', 'Mujer', 'Validado', '2024-12-02 18:51:41', '2024-12-02 18:51:41'),
(624, '2209275c@umich.mx', 'Diego Emilio Garcia Martinez', 'Michoacán', '5625127539', 'Hombre', 'Validado', '2024-12-02 18:52:42', '2024-12-02 18:52:42'),
(625, '2008186F@umich.mx', 'Itzel Rodriguez Garcia', 'Michoacán', '3511227514', 'Mujer', 'Validado', '2024-12-02 18:52:53', '2024-12-02 18:52:53'),
(626, '0101889b@umich.mx', 'Adriana Garcia Rodriguez', 'Michoacán', '4434622572', 'Mujer', 'Validado', '2024-12-02 18:53:57', '2024-12-02 18:53:57'),
(627, 'josuedarogriguezcor@gmail.com', 'Josue Daniel Rodriguez Correa', 'Michoacán', '4438011923', 'Hombre', 'Validado', '2024-12-02 18:54:06', '2024-12-02 18:54:06'),
(628, '17032756@umich.mx', 'Angelica Jimenez', 'Michoacán', '4438609393', 'Mujer', 'Validado', '2024-12-02 18:54:48', '2024-12-02 18:54:48'),
(629, 'ferservin.145@gmail.com', 'Maria Fernanda Servin Anita', 'Michoacán', '4437218047', 'Mujer', 'Validado', '2024-12-02 18:54:51', '2024-12-02 18:54:51'),
(630, 'MonseP649@gmail.com', 'Monserrat Piña', 'Michoacán', '4437348660', 'Mujer', 'Validado', '2024-12-02 18:55:46', '2024-12-02 18:55:46'),
(631, 'asoralesi@live.com.mx', 'Rosa Iseala Arzite Quevedo', 'Michoacán', '3513139977', 'Mujer', 'Validado', '2024-12-02 18:55:47', '2024-12-02 18:55:47'),
(632, 'monicaf@live.com.mx', 'Monica Fabiola Vasquez Mota Velasco', 'Michoacán', '4431437259', 'Mujer', 'Validado', '2024-12-02 18:56:53', '2024-12-02 18:56:53'),
(633, 'caled_rodriguez@meconmich', 'Caled Rodrigez R.', 'Michoacán', '4433864687', 'Hombre', 'Validado', '2024-12-02 18:59:56', '2024-12-02 18:59:56'),
(634, '1132689x@umich.mx', 'Alexa Fernanda Tovar Barron', 'Michoacán', '4431570267', 'Mujer', 'Validado', '2024-12-02 19:05:03', '2024-12-02 19:05:03'),
(635, 'iris1977yunuen@gmail.com', 'Iris Yunuen Rangel', 'Michoacán', '-', 'Mujer', 'Validado', '2024-12-02 19:05:27', '2024-12-02 19:05:27'),
(636, '191154A@umich.mx', 'Allison Itzel Cortes Delgado', 'Michoacán', '4436167327', 'Mujer', 'Validado', '2024-12-02 19:06:27', '2024-12-02 19:06:27'),
(637, 'peterstyssoon@gmail.com', 'Pedro Chavez Guzman', 'Michoacán', '4433362924', 'Hombre', 'Validado', '2024-12-02 19:06:29', '2024-12-02 19:06:29'),
(638, 'mayedi.loga96@gmail.com', 'Mayra Farth Lopez Garcia', 'Michoacán', '4432651582', 'Mujer', 'Validado', '2024-12-02 19:07:57', '2024-12-02 19:07:57'),
(639, 'renatakiler@gmail.com', 'Renata Bargas', 'Michoacán', '4438421232', 'Mujer', 'Validado', '2024-12-02 19:08:06', '2024-12-02 19:08:06'),
(640, 'geral32692@gmail.com', 'Gerardo Calderon Lopez', 'Michoacán', '4432658919', 'Mujer', 'Validado', '2024-12-02 19:09:08', '2024-12-02 19:09:08'),
(641, 'yspe@gmail.com', 'Yareli Sarahi Padillla Espinosa', 'Michoacán', '4431671474', 'Mujer', 'Validado', '2024-12-02 19:10:10', '2024-12-02 19:10:10'),
(642, 'desaillyn21@gmail.com', 'Chis Desaillyn Madrigal Cerda', 'Michoacán', '4432712079', 'Mujer', 'Validado', '2024-12-02 19:10:38', '2024-12-02 19:10:38'),
(643, 'lupitaequihua@gmail.com', 'Lupita Equihua', 'Michoacán', '4531447741', 'Mujer', 'Validado', '2024-12-02 19:11:55', '2024-12-02 19:11:55'),
(644, 'prettyaime040@hotmail.com', 'Lorena Lachino Baneza', 'Michoacán', '4432608284', 'Mujer', 'Validado', '2024-12-02 19:12:25', '2024-12-02 19:12:25'),
(645, 'cecay@gmail.com', 'Jaime Alejandro Hernandez Castillo', 'Michoacán', '4434119983', 'Hombre', 'Validado', '2024-12-02 19:13:10', '2024-12-02 19:13:10'),
(646, '2215938a@umich.mx', 'Valentina Morelia Placencia Cervantes', 'Michoacán', '4431406944', 'Mujer', 'Validado', '2024-12-02 19:13:22', '2024-12-02 19:13:22'),
(647, '2716775b@umich.mx', 'Jose Roberto Reyes', 'Michoacán', '4432453207', 'Hombre', 'Validado', '2024-12-02 19:14:32', '2024-12-02 19:14:32'),
(648, '2216641c@umich.mx', 'Gisleinne Dilva', 'Michoacán', '4432450146', 'Mujer', 'Validado', '2024-12-02 19:15:32', '2024-12-02 19:15:32'),
(649, 'derechocuirrocha@gmqail.com', 'Rocio Camacho Jose', 'Michoacán', '4451612685', 'Hombre', 'Validado', '2024-12-02 19:15:55', '2024-12-02 19:15:55'),
(650, '221770ik@umich.mx', 'Gina Solorio Montero', 'Michoacán', '4435008550', 'Mujer', 'Validado', '2024-12-02 19:16:37', '2024-12-02 19:16:37'),
(651, '2218477h@umich.mx', 'Yaretzi Bashira Villarino', 'Michoacán', '4434141829', 'Mujer', 'Validado', '2024-12-02 19:17:46', '2024-12-02 19:17:46'),
(652, '2218477h@umich.mx', 'Cortes Vega', 'Michoacán', '4341200112', 'Mujer', 'Validado', '2024-12-02 19:18:43', '2024-12-02 19:18:43'),
(653, '2405732G@umich.mx', 'Julian Maciel Garcia', 'Michoacán', '4251628515', 'Hombre', 'Validado', '2024-12-02 19:19:47', '2024-12-02 19:19:47'),
(654, 'rjiescas@gmail.com', 'Raul Javier Gimenez', 'Michoacán', '4437348310', 'Hombre', 'Validado', '2024-12-02 19:20:57', '2024-12-02 19:20:57'),
(655, 'rjiescas@gmail.com', 'José Alfredo Pérez Ferrer', 'Michoacán', '4361160271', 'Hombre', 'Validado', '2024-12-02 19:22:09', '2024-12-02 19:22:09'),
(656, 'rossariocaste@gmail.com', 'Maria del Rosario Valle Garcia', 'Michoacán', '4431875273', 'Mujer', 'Validado', '2024-12-02 19:22:37', '2024-12-02 19:22:37'),
(657, 'prettyaime040@hotmail.com', 'Lorena Lachino Barboza', 'Michoacán', '4432608284', 'Mujer', 'Validado', '2024-12-02 19:24:11', '2024-12-02 19:24:11'),
(658, 'licarturocl@hotmail.com', 'Arturo Castro', 'Michoacán', '4431280565', 'Hombre', 'Validado', '2024-12-02 19:25:47', '2024-12-02 19:25:47'),
(659, 'juliovazqes79340@gmail.com', 'Julio Vazquez Peñaloza', 'Michoacán', '4432622924', 'Hombre', 'Validado', '2024-12-02 19:26:09', '2024-12-02 19:26:09'),
(660, 'mvveronica_pc@hotmail.com', 'Veronica Villa', 'Michoacán', '4432762711', 'Mujer', 'Validado', '2024-12-02 19:27:09', '2024-12-02 19:27:09'),
(661, 'vrodriguez010@uvaq.edu.mx', 'Victor Manuel Rodriguez Ramirez', 'Michoacán', '4431939447', 'Hombre', 'Validado', '2024-12-02 19:28:32', '2024-12-02 19:28:32'),
(662, 'danielaorizmedi54s@gmail.com', 'Daniea Arizmedi Torres', 'Michoacán', '4433653442', 'Mujer', 'Validado', '2024-12-02 19:29:51', '2024-12-02 19:29:51'),
(663, '2216241H@gmail.com', 'Miguel Angel', 'Michoacán', '4435134072', 'Hombre', 'Validado', '2024-12-02 19:30:51', '2024-12-02 19:30:51'),
(664, '2355863H@gmail.com', 'Daniela Miranda  Velazquez', 'Michoacán', '4434429717', 'Mujer', 'Validado', '2024-12-02 19:32:04', '2024-12-02 19:32:04'),
(665, '2215985E@umich.mx', 'Emilia de La Luz Ruiz', 'Michoacán', '4435140104', 'Mujer', 'Validado', '2024-12-02 19:33:56', '2024-12-02 19:33:56'),
(666, 'reginatejeda@outlook.es', 'Abril Regina Tejeda Aguilar', 'Michoacán', '443610018', 'Mujer', 'Validado', '2024-12-02 19:35:12', '2024-12-02 19:35:12'),
(667, 'liber80@gmail.com', 'LIBERIANA HERNÁNDEZ VALENTÍN', 'Michoacán', '3511566105', 'Mujer', 'Validado', '2024-12-02 19:40:48', '2024-12-02 19:40:48'),
(668, 'racemy@hotmail.com', 'Celeste Saavedra Rivera', 'Michoacán', '4432237452', 'Mujer', 'Validado', '2024-12-02 19:42:06', '2024-12-02 19:42:06'),
(669, 'marioacm199@gmail.com', 'Mario Alberto Ceja', 'Michoacán', '4434903357', 'Hombre', 'Validado', '2024-12-02 19:42:57', '2024-12-02 19:42:57'),
(670, 'fridasofiasanchezortiz@gmail.com', 'Frida Sofia Sanchez Ortiz', 'Michoacán', '4436167246', 'Mujer', 'Validado', '2024-12-02 19:44:21', '2024-12-02 19:44:21'),
(671, 'badruch39@gmail.com', 'Hernan de Jesus Hernandez', 'Michoacán', '4431119973', 'Hombre', 'Validado', '2024-12-02 19:47:07', '2024-12-02 19:47:07'),
(672, '2125114e@umich.mx', 'Marla Rangel', 'Michoacán', '-', 'Mujer', 'Validado', '2024-12-02 19:47:58', '2024-12-02 19:47:58'),
(673, 'hectorvelitos666@gmail.com', 'Hector Garcia', 'Michoacán', '443521313', 'Hombre', 'Validado', '2024-12-02 19:49:05', '2024-12-02 19:49:05'),
(674, 'SKary@gmail.com', 'Karina Guadaluoe Aguilar', 'Michoacán', '7151463369', 'Mujer', 'Validado', '2024-12-02 19:50:13', '2024-12-02 19:50:13'),
(675, 'Cortes.d.f.6968@gmail.com', 'Carlos Delgado Ferreyra', 'Michoacán', '191113114', 'Hombre', 'Validado', '2024-12-02 19:51:29', '2024-12-02 19:51:29'),
(676, 'luisrobertorosiles@otmail.com', 'Luis Roberto Rosiles Saberanis', 'Michoacán', '4532281734', 'Hombre', 'Validado', '2024-12-02 19:52:09', '2024-12-02 19:52:09'),
(677, 'Ana@gmail.com', 'Ana Villegas Diaz', 'Michoacán', '4431458622', 'Mujer', 'Validado', '2024-12-02 19:52:39', '2024-12-02 19:52:39'),
(678, 'gracielasoriano697@gmail.com', 'Graciela Soriano Vargas', 'Michoacán', '4532281734', 'Mujer', 'Validado', '2024-12-02 19:53:47', '2024-12-02 19:53:47'),
(679, 'jose@gmail.com', 'José de Jesús Juarez', 'Michoacán', '4431552480', 'Hombre', 'Validado', '2024-12-02 19:54:42', '2024-12-02 19:54:42'),
(680, 'Alitzamezar@gmail.com', 'Alitza Rocio Meza', 'Michoacán', '4591086213', 'Mujer', 'Validado', '2024-12-02 19:56:21', '2024-12-02 19:56:21'),
(681, 'jaimestareal@itscamocreo.edo.mx', 'Jose Mauel Jimes G', 'Michoacán', '4437334305', 'Hombre', 'Validado', '2024-12-02 19:56:38', '2024-12-02 19:56:38'),
(682, 'gracielaperezmromero11@gmail.com', 'Graciela Pérez Romero', 'Michoacán', '4435764377', 'Mujer', 'Validado', '2024-12-02 19:57:25', '2024-12-02 19:57:25'),
(683, 'sonia.rubio@umich.mx', 'Sonia Rubio Olvera', 'Michoacán', '4431893042', 'Mujer', 'Validado', '2024-12-02 19:58:36', '2024-12-02 19:58:36'),
(684, 'clemencia45@hotmail.com', 'Clemencia Ochoa Cabrera', 'Michoacán', '4431027264', 'Mujer', 'Validado', '2024-12-02 19:59:15', '2024-12-02 19:59:15'),
(685, 'Oropezagal7e@gmail.com', 'Karina Oropeza G.', 'Michoacán', '4434107872', 'Mujer', 'Validado', '2024-12-02 19:59:24', '2024-12-02 19:59:24'),
(686, '1701485d@umich.mx', 'Alondra Alexandra Gutierrez Alvarado', 'Michoacán', '4431585815', 'Mujer', 'Validado', '2024-12-02 20:00:07', '2024-12-02 20:00:07'),
(687, 'anubis_527@hotmail.com', 'Joesan Garcia Paramo', 'Michoacán', '4434825534', 'Hombre', 'Validado', '2024-12-02 20:00:37', '2024-12-02 20:00:37'),
(688, 'rommelin847@gmail.com', 'Rommel Gonzalez Diaz', 'Michoacán', '4434707305', 'Hombre', 'Validado', '2024-12-02 20:01:07', '2024-12-02 20:01:07'),
(689, 'aguirrenato@gmail.com', 'Fortunato Aguirre Pineda', 'Michoacán', '443896349', 'Hombre', 'Validado', '2024-12-02 20:14:22', '2024-12-02 20:14:22'),
(690, 'auralysto@hotmail.com', 'Laura Rosa Torres', 'Michoacán', '443400476', 'Mujer', 'Validado', '2024-12-02 20:15:36', '2024-12-02 20:15:36'),
(691, 'Rosalinda@gmail.com', 'Rosalinda Poliz Vallejo', 'Michoacán', '4434047525', 'Mujer', 'Validado', '2024-12-02 20:16:36', '2024-12-02 20:16:36'),
(692, 'Emilianoja@outlook.es', 'Emiliano Jaime Avilés', 'Michoacán', '417083223', 'Mujer', 'Validado', '2024-12-02 20:17:42', '2024-12-02 20:17:42'),
(693, 'diego88@gmail.com', 'Diego Reserndiz', 'Michoacán', '4433008804', 'Hombre', 'Validado', '2024-12-02 20:18:47', '2024-12-02 20:18:47'),
(694, 'lillian.elena@gmail.com', 'Lillian Elena Nueñez Chavez', 'Michoacán', '4432271750', 'Mujer', 'Validado', '2024-12-02 20:20:09', '2024-12-02 20:20:09'),
(695, 'Cpena2828@gmail.com', 'Cesar Peña Cediño', 'Michoacán', '9933968341', 'Hombre', 'Validado', '2024-12-02 20:21:17', '2024-12-02 20:21:17'),
(696, 'maricruzplaza4@gmail.com', 'Maricruz Plaza Garcia', 'Michoacán', '4434396627', 'Mujer', 'Validado', '2024-12-02 20:22:09', '2024-12-02 20:22:09'),
(697, '2216633c@gmail.com', 'Patricia Vazquez', 'Michoacán', '4438640377', 'Mujer', 'Validado', '2024-12-02 20:24:14', '2024-12-02 20:24:14'),
(698, '2215836D@umich.mx', 'Martha Elizabeth Tapia', 'Michoacán', '4433543422', 'Mujer', 'Validado', '2024-12-02 20:25:17', '2024-12-02 20:25:17'),
(699, 'luisrobertorosales@outlook.com', 'Luis Roberto Rosales', 'Michoacán', '7551406777', 'Hombre', 'Validado', '2024-12-02 20:27:27', '2024-12-02 20:27:27'),
(700, 'bmartinez78@gmail.com', 'Blanca Rosa Martinez', 'Michoacán', '4436349106', 'Mujer', 'Validado', '2024-12-02 20:28:53', '2024-12-02 20:28:53'),
(701, '2216684j@umich.mx', 'Miranda Garcia Casillas', 'Michoacán', '4531195483', 'Mujer', 'Validado', '2024-12-02 20:30:00', '2024-12-02 20:30:00'),
(702, 'sahoriolo@hotmail.com', 'Ma. Lourdes Fernandez', 'Michoacán', '4431236852', 'Mujer', 'Validado', '2024-12-02 20:30:58', '2024-12-02 20:30:58'),
(703, 'miguelmartinezrios@gmail.com', 'Miguel Mrtinez Rios', 'Michoacán', '4431236852', 'Hombre', 'Validado', '2024-12-02 20:31:50', '2024-12-02 20:31:50'),
(704, 'ptto_32@hotmail.com', 'Patricia Torres Contreras', 'Michoacán', '4432423922', 'Mujer', 'Validado', '2024-12-02 20:32:47', '2024-12-02 20:32:47'),
(705, 'leyendadelbox@gmail.com', 'Kevin Mejia Garcia', 'Michoacán', '4431094352', 'Hombre', 'Validado', '2024-12-02 20:33:51', '2024-12-02 20:33:51'),
(706, 'mechemrquz78202@gmail.com', 'Mercades Marquez', 'Michoacán', '4431094352', 'Mujer', 'Validado', '2024-12-02 20:35:39', '2024-12-02 20:35:39'),
(707, 'danitmoz12@gmail.com', 'Daniela Téllez Marin', 'Michoacán', '7861308432', 'Mujer', 'Validado', '2024-12-02 20:36:39', '2024-12-02 20:36:39'),
(708, 'oscar@gmail.com', 'Oscar', 'Michoacán', '4591097791', 'Hombre', 'Validado', '2024-12-02 20:37:34', '2024-12-02 20:37:34'),
(709, 'luis@gmail.com', 'Luis Yoan', 'Michoacán', '4521834911', 'Hombre', 'Validado', '2024-12-02 20:38:39', '2024-12-02 20:38:39'),
(710, 'luis@gmail.com', 'Luis Alberto', 'Michoacán', '4439103805', 'Hombre', 'Validado', '2024-12-02 20:39:48', '2024-12-02 20:39:48'),
(711, 'lidianoemi80@hotmail.com', 'Lidia Noemi', 'Michoacán', '4431816562', 'Mujer', 'Validado', '2024-12-02 20:40:59', '2024-12-02 20:40:59'),
(712, 'cpladem.cardenaz@gmail.com', 'Alfonso Cárdenaz Oseguera', 'Michoacán', '4431301535', 'Hombre', 'Validado', '2024-12-02 20:42:29', '2024-12-02 20:42:29'),
(713, 'epigonzales4@gmail.com', 'EPIFANIO GONZÁLEZ', 'Michoacán', '7151203417', 'Hombre', 'Validado', '2024-12-02 20:44:53', '2024-12-02 20:44:53'),
(714, '1546016@UMICH.MX', 'José Enrique', 'Michoacán', '4437212860', 'Hombre', 'Validado', '2024-12-02 20:48:31', '2024-12-02 20:48:31'),
(715, 'Izcor.252@hotmail.com', 'Iram Coria Ortiz', 'Michoacán', '4435411815', 'Hombre', 'Validado', '2024-12-02 20:49:33', '2024-12-02 20:49:33'),
(716, '2146593@umich.mx', 'Diego Armando Bazo Romero', 'Michoacán', '448587627', 'Hombre', 'Validado', '2024-12-02 20:50:41', '2024-12-02 20:50:41'),
(717, 'gerardoot32@yahoo.com.mx', 'GERARDO PEDRAZA TORRES', 'Michoacán', '4431464616', 'Hombre', 'Validado', '2024-12-02 20:53:56', '2024-12-02 20:53:56'),
(718, 'maldokattia553@gmail.com', 'Katia Esmeralda Piña', 'Michoacán', '4439693113', 'Mujer', 'Validado', '2024-12-02 20:56:30', '2024-12-02 20:56:30'),
(719, '1911141f@umich.mx', 'Damaris Berenice Aguilar', 'Michoacán', '4432232231', 'Mujer', 'Validado', '2024-12-02 20:57:38', '2024-12-02 20:57:38'),
(720, '22dg148@umich.mx', 'Ronaldo Márquez', 'Michoacán', '35123510436', 'Hombre', 'Validado', '2024-12-02 20:58:58', '2024-12-02 20:58:58'),
(721, '2204041@umic.mx', 'Jazmin Guzman Hernandez', 'Michoacán', '4662038322', 'Mujer', 'Validado', '2024-12-02 21:00:13', '2024-12-02 21:00:13'),
(722, '223148@umich.mx', 'Jesus Perez', 'Michoacán', '4433925101', 'Hombre', 'Validado', '2024-12-02 21:01:29', '2024-12-02 21:01:29'),
(723, '1700872x@umich.mx', 'Neyder Tadeo Aguilar', 'Michoacán', '4435289676', 'Hombre', 'Validado', '2024-12-02 21:02:26', '2024-12-02 21:02:26'),
(724, 'hmundoramos@gmail.com', 'Hugo Mundo Ramos', 'Michoacán', '4434321301', 'Hombre', 'Validado', '2024-12-02 21:10:04', '2024-12-02 21:10:04'),
(725, 'areli06suarez@gmail.com', 'Mariana Areli Suarez', 'Michoacán', '4434659509', 'Mujer', 'Validado', '2024-12-02 21:11:44', '2024-12-02 21:11:44'),
(726, 'molina-aereos@hotmail.com', 'Molina', 'Michoacán', '4433838787', 'Mujer', 'Validado', '2024-12-02 21:12:41', '2024-12-02 21:12:41'),
(727, 'marianavazquez@gmail.com', 'Laura Mariana Vazquez', 'Michoacán', '443400945', 'Mujer', 'Validado', '2024-12-02 21:14:07', '2024-12-02 21:14:07'),
(728, 'alexandro1922001@gmail.com', 'Alejandro Núñez López', 'Michoacán', '4439241474', 'Hombre', 'Validado', '2024-12-02 21:15:49', '2024-12-02 21:15:49'),
(729, 'luisgarcia@gmail.com', 'Luis Gabriel Aguilar Garcia', 'Michoacán', '4341165424', 'Hombre', 'Validado', '2024-12-02 21:17:17', '2024-12-02 21:17:17'),
(730, 'choquis052531@gmail.com', 'Sofia Sarahi Manzo', 'Michoacán', '4431838525', 'Mujer', 'Validado', '2024-12-02 21:18:47', '2024-12-02 21:18:47'),
(731, 'checopiufierlaex@gmail.com', 'Sergio Ruiz Vazquez', 'Michoacán', '443511604', 'Hombre', 'Validado', '2024-12-02 21:19:45', '2024-12-02 21:19:45'),
(732, '22158406@umich.mx', 'Diana Lucia', 'Michoacán', '4439496979', 'Mujer', 'Validado', '2024-12-02 21:20:35', '2024-12-02 21:20:35'),
(733, '22158406@umich.mx', 'Katya Grissel Becerra', 'Michoacán', '4432218207', 'Mujer', 'Validado', '2024-12-02 21:21:47', '2024-12-02 21:21:47'),
(734, '2121876D@umich.mx', 'Dulce Maria  Costra Morena', 'Michoacán', '4434122497', 'Mujer', 'Validado', '2024-12-02 21:22:41', '2024-12-02 21:22:41'),
(735, '221638th@umich.mx', 'Sofia Perez Hernandez', 'Michoacán', '4433230362', 'Mujer', 'Validado', '2024-12-02 21:23:29', '2024-12-02 21:23:29'),
(736, 'jocelynlz400@gmail.com', 'Jocelyn López Zavala', 'Michoacán', '4437307148', 'Mujer', 'Validado', '2024-12-02 21:24:43', '2024-12-02 21:24:43'),
(737, 'felipevillanueva@gmail.com', 'Felipe Villanueva', 'Michoacán', '455061846', 'Hombre', 'Validado', '2024-12-02 21:26:00', '2024-12-02 21:26:00'),
(738, '2216274j@umich.mx', 'Nicole Chavez', 'Michoacán', '4433940210', 'Mujer', 'Validado', '2024-12-02 21:26:53', '2024-12-02 21:26:53'),
(739, '2215943@umich.mx', 'Diego Gaspar', 'Michoacán', '4431559745', 'Hombre', 'Validado', '2024-12-02 21:27:39', '2024-12-02 21:27:39'),
(740, 'jacibe_1967@yahoo.com', 'Jacinto Cisneros', 'Michoacán', '4438012758', 'Hombre', 'Validado', '2024-12-02 21:28:40', '2024-12-02 21:28:40'),
(741, 'sinisinai@gmail.com', 'Javier Maldonado Prado', 'Michoacán', '4433970225', 'Hombre', 'Validado', '2024-12-02 21:29:39', '2024-12-02 21:29:39'),
(742, 'ea64580@gmail.com', 'Elias Yael Jimenez Ayala', 'Michoacán', '4433365369', 'Hombre', 'Validado', '2024-12-02 21:30:38', '2024-12-02 21:30:38'),
(743, 'arem05@hotmail.com', 'Esmeralda', 'Michoacán', '443227305', 'Mujer', 'Validado', '2024-12-02 21:33:06', '2024-12-02 21:33:06'),
(744, 'Reyna@gmail.com', 'Reyna Aguirre Virrueta', 'Michoacán', '4434817061', 'Mujer', 'Validado', '2024-12-02 21:34:16', '2024-12-02 21:34:16'),
(745, 'Joanaitzelvargas@gmail.com', 'Joana Itzel Vargas Valencia', 'Michoacán', '4436864494', 'Mujer', 'Validado', '2024-12-02 21:35:22', '2024-12-02 21:35:22'),
(746, 'asoralesi@live.com.cm', 'Rosa Isela Arzate Quevedo', 'Michoacán', '3513139976', 'Mujer', 'Validado', '2024-12-02 21:36:58', '2024-12-02 21:36:58'),
(747, 'Mendez123@hotmail.com', 'Ma. Fernanda Mendez', 'Michoacán', '9431026325', 'Mujer', 'Validado', '2024-12-02 21:37:58', '2024-12-02 21:37:58'),
(748, 'ramos653@uaquedo.mx', 'Roberto Antonio Ramos', 'Michoacán', '4433609266', 'Hombre', 'Validado', '2024-12-02 21:39:10', '2024-12-02 21:39:10'),
(749, 'antoniarojas@outlook.com', 'Maria Antonia Lopez Rojas', 'Michoacán', '4431423273', 'Mujer', 'Validado', '2024-12-02 21:40:05', '2024-12-02 21:40:05'),
(750, '2348425h@umich.mx', 'Guadalupe Garcia', 'Michoacán', '4433706554', 'Mujer', 'Validado', '2024-12-02 21:40:51', '2024-12-02 21:40:51'),
(751, 'hele.bautista101@gmail.com', 'Maria Elena Bautista', 'Michoacán', '4433026477', 'Mujer', 'Validado', '2024-12-02 21:41:53', '2024-12-02 21:41:53'),
(752, '2204121e@umich.mx', 'Dulce Montserrat Parrales', 'Michoacán', '4436933005', 'Mujer', 'Validado', '2024-12-02 21:42:55', '2024-12-02 21:42:55'),
(753, '19272426g@umich.mx', 'Gael Moreno', 'Michoacán', '4434640689', 'Hombre', 'Validado', '2024-12-02 21:43:53', '2024-12-02 21:43:53'),
(754, '1911254d@umich.mx', 'Diana Arellano Zavala', 'Michoacán', '4433580244', 'Mujer', 'Validado', '2024-12-02 21:44:44', '2024-12-02 21:44:44'),
(755, 'eliphad.at@gmail.com', 'Alfonso Torres', 'Michoacán', '4433253424', 'Hombre', 'Validado', '2024-12-02 21:45:56', '2024-12-02 21:45:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turnos`
--

CREATE TABLE `turnos` (
  `id` int(11) NOT NULL,
  `consecutivo` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `hora_fin` time DEFAULT NULL,
  `auxiliar` int(11) NOT NULL,
  `tipo` enum('Solicitud','Ratificación') NOT NULL DEFAULT 'Ratificación',
  `lugar_auxiliar` varchar(50) NOT NULL,
  `exepcion` enum('Si','No') NOT NULL DEFAULT 'No',
  `edad` int(11) DEFAULT NULL,
  `sexo` enum('H','M','NB','LGBTTTIQ') NOT NULL,
  `vulnerables` enum('Discapacidad','Mayores','Indigena','Violencia') DEFAULT NULL,
  `salario` float NOT NULL,
  `monto` float DEFAULT NULL,
  `empresa` varchar(50) NOT NULL,
  `primero_empresa` varchar(50) NOT NULL,
  `segundo_empresa` varchar(50) NOT NULL,
  `nombre_empresa` varchar(50) NOT NULL,
  `trabajador` varchar(100) NOT NULL,
  `primero_trabajador` varchar(50) NOT NULL,
  `segundo_trabajador` varchar(50) NOT NULL,
  `frecuencia` varchar(15) NOT NULL,
  `dias` int(11) NOT NULL,
  `estatus` enum('Rechazado','Pendiente','atendido','no atendido','Aceptado','Confirmado','Conluida','Concluida Pagos','Incumplimiento','Archivada') NOT NULL DEFAULT 'Pendiente',
  `delegacion` varchar(30) NOT NULL,
  `ine` text NOT NULL,
  `representacion` text NOT NULL,
  `email` varchar(50) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `JLCA` enum('Si','No') NOT NULL,
  `motivo` varchar(48) NOT NULL,
  `trabajador_curp` varchar(18) NOT NULL,
  `documentoCurp` text NOT NULL,
  `tipo_identificacion` varchar(20) NOT NULL,
  `documentoidentificacion` text DEFAULT NULL,
  `PrimaVacacional` varchar(2) DEFAULT NULL,
  `fecha_inicio` date NOT NULL DEFAULT current_timestamp(),
  `fecha_termino` date DEFAULT NULL,
  `categoria` varchar(20) NOT NULL,
  `tipo_pago` varchar(50) DEFAULT NULL,
  `Aguinaldo` varchar(2) DEFAULT NULL,
  `Vacaciones` varchar(2) DEFAULT NULL,
  `PagoPTU` varchar(2) DEFAULT NULL,
  `Gratificación` varchar(2) DEFAULT NULL,
  `PrimaAntigüedad` varchar(2) DEFAULT NULL,
  `Otras` varchar(2) DEFAULT NULL,
  `Especifique` varchar(50) DEFAULT NULL,
  `documentoCuanti` text DEFAULT NULL,
  `tipo_otros` text DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `curp_solicitante` varchar(18) NOT NULL,
  `resolucion_primera` text DEFAULT NULL,
  `resolucion_trabajadores` text DEFAULT NULL,
  `resolucion_justificacion` text DEFAULT NULL,
  `resolucion_segunda` text DEFAULT NULL,
  `vacaciones_dias` int(11) DEFAULT NULL,
  `aguinaldo_dias` int(11) DEFAULT NULL,
  `otros_dias` int(11) DEFAULT NULL,
  `horario` varchar(50) DEFAULT NULL,
  `comida` varchar(50) DEFAULT NULL,
  `domicilio` varchar(100) DEFAULT NULL,
  `NUE` varchar(18) DEFAULT NULL,
  `id_conciliador` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `turnos`
--

INSERT INTO `turnos` (`id`, `consecutivo`, `fecha`, `hora`, `hora_fin`, `auxiliar`, `tipo`, `lugar_auxiliar`, `exepcion`, `edad`, `sexo`, `vulnerables`, `salario`, `monto`, `empresa`, `primero_empresa`, `segundo_empresa`, `nombre_empresa`, `trabajador`, `primero_trabajador`, `segundo_trabajador`, `frecuencia`, `dias`, `estatus`, `delegacion`, `ine`, `representacion`, `email`, `telefono`, `JLCA`, `motivo`, `trabajador_curp`, `documentoCurp`, `tipo_identificacion`, `documentoidentificacion`, `PrimaVacacional`, `fecha_inicio`, `fecha_termino`, `categoria`, `tipo_pago`, `Aguinaldo`, `Vacaciones`, `PagoPTU`, `Gratificación`, `PrimaAntigüedad`, `Otras`, `Especifique`, `documentoCuanti`, `tipo_otros`, `observaciones`, `curp_solicitante`, `resolucion_primera`, `resolucion_trabajadores`, `resolucion_justificacion`, `resolucion_segunda`, `vacaciones_dias`, `aguinaldo_dias`, `otros_dias`, `horario`, `comida`, `domicilio`, `NUE`, `id_conciliador`, `created_at`, `updated_at`) VALUES
(58, 1, '2025-05-30', '12:00:00', '12:00:00', 9, 'Ratificación', 'Luis Rico', 'No', 23, 'H', NULL, 10000, 123123, 'GRUPO BIMBO SA DE CV', 'GONZALES', 'RODRIGEZ', 'ARMANDO', 'CLERAR', 'BEDOLLA', 'VLEVE', 'Quincenal', 4, 'Conluida', 'Morelia', 'ARMANDOGONZALESRODRIGEZ-GRUPO BIMBO SA DE CV_IDENTIFICACION.pdf', 'ARMANDOGONZALESRODRIGEZ-GRUPO BIMBO SA DE CV_REPRESENTACION.pdf', 'sam_8929@gmail.com', '4431326920', 'Si', 'Terminación voluntaria de la relación de trabajo', 'BEMI890329H085AS1D', 'BEMI890329H085AS1D.pdf', 'Ine', 'BEMI890329H085AS1D_IDENTIFICACION.pdf', NULL, '2025-05-01', '2025-05-15', 'cominucado', 'Efectivo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'BEMI890329H085AS1D_CUANTIFICACION.pdf', NULL, 'No cuenta con RFC', 'BEMI890329HMNDTR02', 'asghdiuashiduhasiudhasiudhiuh', 'idushaiudhesiedhisehdfiseuh', 'icusehicsehicshiechiu', 'iuchesichesichischiush', 34, 34, 344, 'esfes', 'efsef', 'sdfsdfsdfsd', 'MOR/RAT/2025/00059', NULL, '2025-05-15 15:16:53', '2025-05-22 20:20:00'),
(59, 1, '2025-05-22', '11:00:00', '11:00:00', 9, 'Ratificación', 'Luis Rico', 'No', 36, 'M', NULL, 300, 12598, 'GRUPO PEPSI', 'ROSALES', 'GARIBAY', 'JUAN', 'CAROLINA', 'GONZALES', 'IÑARITU', 'Diario', 5, 'Archivada', 'Morelia', 'JUANROSALESGARIBAY-GRUPO PEPSI_IDENTIFICACION.pdf', 'JUANROSALESGARIBAY-GRUPO PEPSI_REPRESENTACION.pdf', 'juan@gmail.com', '4436891557', 'No', 'Terminación voluntaria de la relación de trabajo', 'BEMI890329HMNDTR02', 'BEMI890329HMNDTR02.pdf', 'Ine', 'BEMI890329HMNDTR02_IDENTIFICACION.pdf', '0', '2025-04-01', '2025-05-21', 'Programador', 'Efectivo', '0', '0', '0', '0', '0', '0', '0', NULL, NULL, 'No vine el solicitante', 'BEMI890329HMNDTR02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-21 21:23:29', '2025-05-22 19:12:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turno_disponible`
--

CREATE TABLE `turno_disponible` (
  `id` int(11) NOT NULL,
  `id_auxiliar` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `estatus` enum('Disponible','Ocupado') NOT NULL,
  `delegacion_turno` varchar(30) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `turno_disponible`
--

INSERT INTO `turno_disponible` (`id`, `id_auxiliar`, `fecha`, `hora`, `estatus`, `delegacion_turno`, `created_at`, `updated_at`) VALUES
(74, 5, '2025-02-26', '15:29:19', 'Ocupado', 'Morelia', '2025-02-26 21:29:19', '2025-02-26 21:29:19'),
(75, 5, '2025-02-27', '09:00:00', 'Ocupado', 'Morelia', '2025-02-27 15:26:24', '2025-02-27 15:26:24'),
(76, 5, '2025-02-27', '09:00:00', 'Ocupado', 'Morelia', '2025-02-27 15:27:16', '2025-02-27 15:27:16'),
(77, 3, '2025-02-28', '10:50:20', 'Disponible', 'Morelia', '2025-02-28 16:50:20', '2025-02-28 16:50:20'),
(78, 3, '2025-02-28', '10:51:23', 'Disponible', 'Morelia', '2025-02-28 16:51:23', '2025-02-28 16:51:23'),
(79, 3, '2025-02-28', '10:52:18', 'Disponible', 'Morelia', '2025-02-28 16:52:18', '2025-02-28 16:52:18'),
(80, 3, '2025-02-28', '11:11:49', 'Disponible', 'Morelia', '2025-02-28 17:11:49', '2025-02-28 17:11:49'),
(81, 3, '2025-02-28', '11:12:43', 'Disponible', 'Morelia', '2025-02-28 17:12:43', '2025-02-28 17:12:43'),
(82, 3, '2025-02-28', '11:27:51', 'Disponible', 'Morelia', '2025-02-28 17:27:51', '2025-02-28 17:27:51'),
(83, 3, '2025-02-28', '11:27:51', 'Disponible', 'Morelia', '2025-02-28 17:27:51', '2025-02-28 17:27:51'),
(84, 3, '2025-02-28', '12:22:37', 'Disponible', 'Morelia', '2025-02-28 18:22:37', '2025-02-28 18:22:37'),
(85, 3, '2025-02-28', '12:22:37', 'Disponible', 'Morelia', '2025-02-28 18:22:37', '2025-02-28 18:22:37'),
(86, 3, '2025-02-28', '12:22:37', 'Disponible', 'Morelia', '2025-02-28 18:22:37', '2025-02-28 18:22:37'),
(87, 3, '2025-02-28', '12:22:37', 'Disponible', 'Morelia', '2025-02-28 18:22:37', '2025-02-28 18:22:37'),
(88, 3, '2025-02-28', '12:23:25', 'Disponible', 'Morelia', '2025-02-28 18:23:25', '2025-02-28 18:23:25'),
(89, 3, '2025-02-28', '12:23:25', 'Disponible', 'Morelia', '2025-02-28 18:23:25', '2025-02-28 18:23:25'),
(90, 3, '2025-02-28', '12:23:25', 'Disponible', 'Morelia', '2025-02-28 18:23:25', '2025-02-28 18:23:25'),
(91, 3, '2025-02-28', '12:23:25', 'Disponible', 'Morelia', '2025-02-28 18:23:25', '2025-02-28 18:23:25'),
(92, 3, '2025-02-28', '12:23:25', 'Disponible', 'Morelia', '2025-02-28 18:23:25', '2025-02-28 18:23:25'),
(93, 3, '2025-02-28', '12:23:45', 'Disponible', 'Morelia', '2025-02-28 18:23:46', '2025-02-28 18:23:46'),
(94, 3, '2025-02-28', '12:23:45', 'Disponible', 'Morelia', '2025-02-28 18:23:46', '2025-02-28 18:23:46'),
(95, 3, '2025-02-28', '12:23:45', 'Disponible', 'Morelia', '2025-02-28 18:23:46', '2025-02-28 18:23:46'),
(96, 3, '2025-02-28', '12:23:45', 'Disponible', 'Morelia', '2025-02-28 18:23:46', '2025-02-28 18:23:46'),
(97, 3, '2025-02-28', '12:23:45', 'Disponible', 'Morelia', '2025-02-28 18:23:46', '2025-02-28 18:23:46'),
(98, 3, '2025-03-01', '12:24:23', 'Disponible', 'Morelia', '2025-02-28 18:24:23', '2025-02-28 18:24:23'),
(99, 3, '2025-03-01', '12:24:23', 'Disponible', 'Morelia', '2025-02-28 18:24:23', '2025-02-28 18:24:23'),
(100, 3, '2025-03-01', '12:24:23', 'Disponible', 'Morelia', '2025-02-28 18:24:23', '2025-02-28 18:24:23'),
(101, 3, '2025-03-01', '12:24:23', 'Disponible', 'Morelia', '2025-02-28 18:24:23', '2025-02-28 18:24:23'),
(102, 3, '2025-03-01', '12:24:23', 'Disponible', 'Morelia', '2025-02-28 18:24:23', '2025-02-28 18:24:23'),
(103, 3, '2025-03-01', '12:34:02', 'Disponible', 'Morelia', '2025-02-28 18:34:02', '2025-02-28 18:34:02'),
(104, 3, '2025-03-01', '12:34:02', 'Disponible', 'Morelia', '2025-02-28 18:34:02', '2025-02-28 18:34:02'),
(105, 3, '2025-03-01', '12:34:02', 'Disponible', 'Morelia', '2025-02-28 18:34:02', '2025-02-28 18:34:02'),
(106, 3, '2025-03-01', '12:34:02', 'Disponible', 'Morelia', '2025-02-28 18:34:02', '2025-02-28 18:34:02'),
(107, 3, '2025-03-01', '12:34:02', 'Disponible', 'Morelia', '2025-02-28 18:34:02', '2025-02-28 18:34:02'),
(108, 3, '2025-03-01', '12:44:56', 'Disponible', 'Morelia', '2025-02-28 18:44:56', '2025-02-28 18:44:56'),
(109, 3, '2025-03-02', '12:44:56', 'Disponible', 'Morelia', '2025-02-28 18:44:56', '2025-02-28 18:44:56'),
(110, 3, '2025-03-01', '12:44:56', 'Disponible', 'Morelia', '2025-02-28 18:44:56', '2025-02-28 18:44:56'),
(111, 3, '2025-03-02', '12:44:56', 'Disponible', 'Morelia', '2025-02-28 18:44:56', '2025-02-28 18:44:56'),
(112, 3, '2025-03-01', '12:44:56', 'Disponible', 'Morelia', '2025-02-28 18:44:56', '2025-02-28 18:44:56'),
(113, 3, '2025-03-01', '12:46:13', 'Disponible', 'Morelia', '2025-02-28 18:46:13', '2025-02-28 18:46:13'),
(114, 3, '2025-03-02', '12:46:13', 'Disponible', 'Morelia', '2025-02-28 18:46:13', '2025-02-28 18:46:13'),
(115, 3, '2025-03-01', '12:46:13', 'Disponible', 'Morelia', '2025-02-28 18:46:13', '2025-02-28 18:46:13'),
(116, 3, '2025-03-02', '12:46:13', 'Disponible', 'Morelia', '2025-02-28 18:46:13', '2025-02-28 18:46:13'),
(117, 3, '2025-03-01', '12:46:13', 'Disponible', 'Morelia', '2025-02-28 18:46:13', '2025-02-28 18:46:13'),
(118, 3, '2025-03-01', '12:47:53', 'Disponible', 'Morelia', '2025-02-28 18:47:53', '2025-02-28 18:47:53'),
(119, 3, '2025-03-02', '12:47:53', 'Disponible', 'Morelia', '2025-02-28 18:47:53', '2025-02-28 18:47:53'),
(120, 3, '2025-03-01', '12:47:53', 'Disponible', 'Morelia', '2025-02-28 18:47:53', '2025-02-28 18:47:53'),
(121, 3, '2025-03-02', '12:47:53', 'Disponible', 'Morelia', '2025-02-28 18:47:53', '2025-02-28 18:47:53'),
(122, 3, '2025-03-01', '12:47:53', 'Disponible', 'Morelia', '2025-02-28 18:47:53', '2025-02-28 18:47:53'),
(123, 3, '2025-03-01', '12:49:35', 'Disponible', 'Morelia', '2025-02-28 18:49:35', '2025-02-28 18:49:35'),
(124, 3, '2025-03-01', '12:50:59', 'Disponible', 'Morelia', '2025-02-28 18:50:59', '2025-02-28 18:50:59'),
(125, 3, '2025-03-01', '12:51:13', 'Disponible', 'Morelia', '2025-02-28 18:51:13', '2025-02-28 18:51:13'),
(126, 3, '2025-03-01', '12:53:37', 'Disponible', 'Morelia', '2025-02-28 18:53:37', '2025-02-28 18:53:37'),
(127, 3, '2025-03-01', '12:54:36', 'Disponible', 'Morelia', '2025-02-28 18:54:36', '2025-02-28 18:54:36'),
(128, 3, '2025-03-03', '12:54:36', 'Disponible', 'Morelia', '2025-02-28 18:54:36', '2025-02-28 18:54:36'),
(129, 3, '2025-03-04', '12:54:36', 'Disponible', 'Morelia', '2025-02-28 18:54:36', '2025-02-28 18:54:36'),
(130, 3, '2025-03-05', '12:54:36', 'Disponible', 'Morelia', '2025-02-28 18:54:36', '2025-02-28 18:54:36'),
(131, 3, '2025-03-06', '12:54:36', 'Disponible', 'Morelia', '2025-02-28 18:54:36', '2025-02-28 18:54:36'),
(132, 3, '2025-03-01', '12:55:08', 'Disponible', 'Morelia', '2025-02-28 18:55:08', '2025-02-28 18:55:08'),
(133, 3, '2025-03-03', '12:55:08', 'Disponible', 'Morelia', '2025-02-28 18:55:08', '2025-02-28 18:55:08'),
(134, 3, '2025-03-04', '12:55:08', 'Disponible', 'Morelia', '2025-02-28 18:55:08', '2025-02-28 18:55:08'),
(135, 3, '2025-03-05', '12:55:08', 'Disponible', 'Morelia', '2025-02-28 18:55:08', '2025-02-28 18:55:08'),
(136, 3, '2025-03-06', '12:55:08', 'Disponible', 'Morelia', '2025-02-28 18:55:08', '2025-02-28 18:55:08'),
(137, 3, '2025-03-01', '12:57:00', 'Disponible', 'Morelia', '2025-02-28 18:57:00', '2025-02-28 18:57:00'),
(138, 3, '2025-03-03', '12:57:00', 'Disponible', 'Morelia', '2025-02-28 18:57:00', '2025-02-28 18:57:00'),
(139, 3, '2025-03-04', '12:57:00', 'Disponible', 'Morelia', '2025-02-28 18:57:00', '2025-02-28 18:57:00'),
(140, 3, '2025-03-05', '12:57:00', 'Disponible', 'Morelia', '2025-02-28 18:57:00', '2025-02-28 18:57:00'),
(141, 3, '2025-03-06', '12:57:00', 'Disponible', 'Morelia', '2025-02-28 18:57:00', '2025-02-28 18:57:00'),
(142, 3, '2025-03-01', '12:57:18', 'Disponible', 'Morelia', '2025-02-28 18:57:18', '2025-02-28 18:57:18'),
(143, 3, '2025-03-03', '12:57:18', 'Disponible', 'Morelia', '2025-02-28 18:57:18', '2025-02-28 18:57:18'),
(144, 3, '2025-03-04', '12:57:18', 'Disponible', 'Morelia', '2025-02-28 18:57:18', '2025-02-28 18:57:18'),
(145, 3, '2025-03-05', '12:57:18', 'Disponible', 'Morelia', '2025-02-28 18:57:18', '2025-02-28 18:57:18'),
(146, 3, '2025-03-06', '12:57:18', 'Disponible', 'Morelia', '2025-02-28 18:57:18', '2025-02-28 18:57:18'),
(147, 3, '2025-03-01', '13:02:07', 'Disponible', 'Morelia', '2025-02-28 19:02:07', '2025-02-28 19:02:07'),
(148, 3, '2025-03-01', '13:07:42', 'Disponible', 'Morelia', '2025-02-28 19:07:42', '2025-02-28 19:07:42'),
(149, 3, '2025-03-01', '13:08:32', 'Disponible', 'Morelia', '2025-02-28 19:08:32', '2025-02-28 19:08:32'),
(150, 3, '2025-03-01', '13:09:22', 'Disponible', 'Morelia', '2025-02-28 19:09:23', '2025-02-28 19:09:23'),
(151, 3, '2025-03-01', '13:10:15', 'Disponible', 'Morelia', '2025-02-28 19:10:15', '2025-02-28 19:10:15'),
(152, 3, '2025-03-01', '13:11:02', 'Disponible', 'Morelia', '2025-02-28 19:11:02', '2025-02-28 19:11:02'),
(153, 3, '2025-03-01', '13:16:00', 'Disponible', 'Morelia', '2025-02-28 19:16:00', '2025-02-28 19:16:00'),
(154, 3, '2025-03-01', '13:16:39', 'Disponible', 'Morelia', '2025-02-28 19:16:39', '2025-02-28 19:16:39'),
(155, 3, '2025-04-07', '15:55:29', 'Disponible', NULL, '2025-04-07 21:55:29', '2025-04-07 21:55:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `type` enum('Seer','Si concilio','Ambos') NOT NULL,
  `delegacion` enum('Morelia','Uruapan','Zamora','Zitacuaro','Sahuayo','Lárazo Cárdenas') NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_login_at` datetime DEFAULT current_timestamp(),
  `last_login_ip` varchar(191) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `profile_photo_path`, `password`, `type`, `delegacion`, `remember_token`, `created_at`, `updated_at`, `last_login_at`, `last_login_ip`) VALUES
(1, 'Irvin Bedola', 'irvinsbm@gmail.com', '2025-03-27 21:23:04', NULL, '$2y$10$5bfqReacDvnE0xoK17iYUO09b1GAgtT4rF5EyDqU6oDjmz1qPj5vO', 'Ambos', 'Morelia', NULL, '2023-05-10 20:23:04', '2025-05-27 16:49:43', '2025-05-27 10:49:43', '::1'),
(3, 'Yesenia Arteaga Vences', 'avy.yesenia@gmail.com', NULL, NULL, '$2y$10$3mdUGCQvZD.SgkNxfGnk6.jF9tBvStOvywYAoTHiV0jZ9./hDFVeq', 'Seer', 'Morelia', NULL, '2024-10-17 01:33:17', '2025-05-21 21:26:38', '2025-05-21 15:26:38', '::1'),
(4, 'Ana soriano', 'analuisasoriano1@gmail.com', NULL, NULL, '$2y$10$gQGNTymmUHDsR6iQVwkhjO/1sPOaF.nFd.v/hK5BWGhzP/d8qFmqG', 'Si concilio', 'Morelia', NULL, '2024-10-17 01:36:45', '2024-10-17 21:42:41', '2025-03-31 15:25:57', ''),
(5, 'Sandra Rocio Varela Cortés', 'sanrusy@gmail.com', NULL, NULL, '$2y$10$QrN5Mt2gtma3/oGosgV7AuiB8jj5Y5CO6RxP0iehmL3PMdXFBmfV2', 'Si concilio', 'Morelia', 'Hombre', '2024-10-17 01:40:27', '2025-02-07 22:00:45', '2025-03-31 15:25:57', ''),
(6, 'Erandi Martinez barajas', 'erandi-martinez2015@outlook.com', NULL, NULL, '$2y$10$WAJyFWY7cOOC3CTeLk1kKuYdVZreGh2fwMmHC4ZZnNfgwXcs8JaGW', 'Si concilio', 'Morelia', NULL, '2024-10-17 01:44:15', '2025-02-07 22:02:17', '2025-03-31 15:25:57', ''),
(7, 'Clever Cortes Salas', 'clevercortes35@gmail.com', NULL, NULL, '$2y$10$ZZ0tA9wmhYb14oEI3Ogkd.UAsrja81gfGavHu65gpNO59GRPNvnXu', 'Si concilio', 'Uruapan', NULL, '2024-10-17 01:45:57', '2025-02-07 22:03:24', '2025-03-31 15:25:57', ''),
(8, 'Mayra Edith López García', 'mayedi.loga96@gmail.com', NULL, NULL, '$2y$10$d.sPfSDkRdZNd53nRdxsB.eVkXrj0dy4ztl9JDzL3xVS6/Ahb1Cm6', 'Si concilio', 'Uruapan', NULL, '2024-10-17 03:45:51', '2025-02-07 22:07:07', '2025-03-31 15:25:57', ''),
(9, 'Luis Rico', 'luisricot7@gmail.com', NULL, NULL, '$2y$10$r4/LL5UGWhfYtYmGtyjzQOEGgTXdh4ChtAKUwp3cwFt2DTnSJ/zC2', 'Si concilio', 'Morelia', NULL, '2024-10-17 03:46:50', '2025-05-27 16:59:45', '2025-05-27 10:59:45', '::1'),
(10, 'Maria Del Rosario Valle Garcia', 'rosariocastellanos8279@gmail.com', NULL, NULL, '$2y$10$KjrbVn/G//bg6eajngoSfO2iOjtGMh8HpKX2rX91RIss8BJc2HC9m', 'Si concilio', 'Morelia', 'Mujer', '2024-10-17 04:19:14', '2025-04-05 02:54:56', '2025-04-04 20:54:56', '::1'),
(11, 'Susy Areli Reyes Santoyo', 'susyS@gmail.com', NULL, NULL, '$2y$10$ObvwX4RR3GEJQlmFWCXNiO6yDd.nPX.4p0ZJTCwdXlg/fdUw.3eCa', 'Ambos', 'Uruapan', NULL, '2024-11-20 04:19:45', '2025-02-07 22:09:11', '2025-03-31 15:25:57', ''),
(12, 'Delegada Uruapan', 'delegadauruapan@gmail.com', NULL, NULL, '$2y$10$q.0YI38M.oFAhD.rtN79uOHSeqrNgwa7VSBMBKAi/28OWKlxpbLhq', 'Seer', 'Morelia', NULL, '2024-11-26 00:34:12', '2025-02-07 22:11:13', '2025-03-31 15:25:57', ''),
(13, 'Natalia Itzel', 'naty@gmail.com', NULL, NULL, '$2y$10$yzZsnZwyASVk4sCfByTnjO4dRo1aRuAQ1ixi2EgVbr2nBIUZ7Rsm.', 'Seer', 'Zamora', 'Mujer', '2024-12-19 01:38:55', '2025-02-07 22:12:29', '2025-03-31 15:25:57', ''),
(14, 'Conciliador Uruapan', 'conciliadoruruapan@gmail.com', NULL, NULL, '$2y$10$7t4UgccQF03lIHsOQ057huB5U4GcjvrvrLJb3N8X4cOo7kdLimfy2', 'Seer', 'Zamora', NULL, '2024-12-24 07:33:23', '2025-02-07 22:40:13', '2025-03-31 15:25:57', ''),
(15, 'Delegada Zamora', 'delegadazamora@gmail.com', NULL, NULL, '$2y$10$j7.RWj/IpwHClBJlABHY3ecqw32uNwDYUPkD4jxKnYjWm6sO2fL06', 'Seer', 'Zamora', NULL, '2025-01-24 22:40:38', '2025-03-03 22:57:15', '2025-03-31 15:25:57', ''),
(16, 'usuario exepcion', 'exepcion@gmail.com', NULL, NULL, '$2y$10$jm71TjkU5q7w3XVtuSBck.S3sQKG0HhuDMjBnDg/FFuOFd9Wby/9C', 'Seer', 'Morelia', NULL, '2025-01-28 02:32:43', '2025-01-28 02:32:43', '2025-03-31 15:25:57', ''),
(17, 'Epifanio', 'auxiliarzitacuaro@gmail.com', NULL, NULL, '$2y$10$l5KvYjRzggpvvjdxmCQiFOqivpZgI0bjgZfE8TlaoCOYxAngiX7Y6', 'Seer', 'Zitacuaro', NULL, '2025-02-07 22:45:02', '2025-02-07 22:45:02', '2025-03-31 15:25:57', ''),
(18, 'Mariela', 'conciliadorzitacuaro@gmail.com', NULL, NULL, '$2y$10$z86KTZaViRSmks9ffhLI8umt/fDvhqp3.ILcnKlgXxDYsnvbC3L5W', 'Seer', 'Zitacuaro', NULL, '2025-02-07 22:46:26', '2025-02-07 22:46:26', '2025-03-31 15:25:57', ''),
(19, 'Guadalupe Equihua', 'lupitaequihua@gmail.com', NULL, NULL, '$2y$10$UH7IUl/Kr4ImX7yIX2I6rusfT9JWMP9sIBx7p0Wv4fwgFB3mmahWC', 'Seer', 'Lárazo Cárdenas', NULL, '2025-02-07 22:56:20', '2025-02-07 22:59:41', '2025-03-31 15:25:57', ''),
(20, 'Joel Alonso', 'joel@gmail.com', NULL, NULL, '$2y$10$GXUwKtoAYFXW4U9LPTdc2u/t8YmdaBkreUDojWO8Wm0eoNoczavru', 'Seer', 'Lárazo Cárdenas', NULL, '2025-02-07 22:57:03', '2025-02-07 23:02:56', '2025-03-31 15:25:57', ''),
(21, 'Auxiliar Sahuayo', 'auxiliarsahuayo@gmail.com', NULL, NULL, '$2y$10$aasmIH2hAeBCD0horzZtPutpYAneFHzYPGtHZ7sMbpcOJv5Ld2obi', 'Seer', 'Sahuayo', NULL, '2025-02-07 23:04:34', '2025-02-07 23:04:34', '2025-03-31 15:25:57', ''),
(22, 'Conciliador Sahuayo', 'consiliadorsahuayo@gmail.com', NULL, NULL, '$2y$10$VjCZD/y7UwoK6GHm23qhc.whN4Zn8of5LKn37dKJWIEEOi2t2c3v6', 'Seer', 'Sahuayo', NULL, '2025-02-07 23:05:13', '2025-02-07 23:05:13', '2025-03-31 15:25:57', ''),
(23, 'Victor Tecnico', 'tecnico@gmail.com', NULL, NULL, '$2y$10$5WnEY1K6woBuL41tuSWOpOZZSoKyJ7QQ.0OEC7.U70lCa6Zr.YQyu', 'Seer', 'Morelia', NULL, '2025-02-07 23:06:09', '2025-02-07 23:06:09', '2025-03-31 15:25:57', ''),
(24, 'Notificador Morelia', 'notificadormorelia@gmail.com', NULL, NULL, '$2y$10$T3LcTgWQ5AchD8SrGJZU6uBkklVNQipudCtR/nTTk6cAMFCs59ir.', 'Seer', 'Morelia', NULL, '2025-02-12 22:14:04', '2025-04-08 17:07:14', '2025-04-08 11:07:14', '::1'),
(25, 'Enlace morelia', 'enlacemorelia@gmail.com', NULL, NULL, '$2y$10$.LWDENZBwErM./l3UEzpNeUc4lXX1R/FjLCHAIZzqYBGYEVVJEimu', 'Seer', 'Morelia', NULL, '2025-02-14 04:49:05', '2025-04-08 17:06:54', '2025-04-08 11:06:54', '::1'),
(41, 'CAROLINA', 'juan@gmail.com', NULL, 'BEMI890329HMNDTR02', '$2y$10$mhGi4GRLsUz4utJLzIoL/ei793b8UwZY.X3L6fUJ7JqlFdRIHS7UW', 'Seer', 'Morelia', 'BEMI890329HMNDTR02', '2025-05-21 21:23:30', '2025-05-21 21:25:21', '2025-05-21 15:25:21', '::1');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `abogados`
--
ALTER TABLE `abogados`
  ADD PRIMARY KEY (`idAbogado`);

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `capacitaciones`
--
ALTER TABLE `capacitaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `capacitaciones_calificacion`
--
ALTER TABLE `capacitaciones_calificacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `capacitaciones_encuesta`
--
ALTER TABLE `capacitaciones_encuesta`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `capacitaciones_modulo`
--
ALTER TABLE `capacitaciones_modulo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `capacitaciones_persona`
--
ALTER TABLE `capacitaciones_persona`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `catalogo_actividad`
--
ALTER TABLE `catalogo_actividad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `catalogo_motivos`
--
ALTER TABLE `catalogo_motivos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `catalogo_rama`
--
ALTER TABLE `catalogo_rama`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `chat_preguntas`
--
ALTER TABLE `chat_preguntas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `chat_registro`
--
ALTER TABLE `chat_registro`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `chat_rp`
--
ALTER TABLE `chat_rp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_preguntas_id_pregunta_chat_rp` (`id_pregunta`) USING BTREE,
  ADD KEY `chat_registro_id_registro_chat_rp` (`id_registro`) USING BTREE;

--
-- Indices de la tabla `concepto_pago`
--
ALTER TABLE `concepto_pago`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `documentacion_persona`
--
ALTER TABLE `documentacion_persona`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `municipios`
--
ALTER TABLE `municipios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pago_solicitud`
--
ALTER TABLE `pago_solicitud`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `pre_registro`
--
ALTER TABLE `pre_registro`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indices de la tabla `sedes`
--
ALTER TABLE `sedes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `seer_asesorias`
--
ALTER TABLE `seer_asesorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `seer_auxiliares`
--
ALTER TABLE `seer_auxiliares`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `seer_citados`
--
ALTER TABLE `seer_citados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `seer_colectivas`
--
ALTER TABLE `seer_colectivas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `seer_conciliadores`
--
ALTER TABLE `seer_conciliadores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `seer_convenios`
--
ALTER TABLE `seer_convenios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `seer_general`
--
ALTER TABLE `seer_general`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `seer_motivos`
--
ALTER TABLE `seer_motivos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `seer_solicitante`
--
ALTER TABLE `seer_solicitante`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `segundo_encuentro`
--
ALTER TABLE `segundo_encuentro`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `turnos`
--
ALTER TABLE `turnos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `turno_disponible`
--
ALTER TABLE `turno_disponible`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`),
  ADD UNIQUE KEY `email_3` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `abogados`
--
ALTER TABLE `abogados`
  MODIFY `idAbogado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `capacitaciones`
--
ALTER TABLE `capacitaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `catalogo_actividad`
--
ALTER TABLE `catalogo_actividad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `catalogo_motivos`
--
ALTER TABLE `catalogo_motivos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `catalogo_rama`
--
ALTER TABLE `catalogo_rama`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `chat_preguntas`
--
ALTER TABLE `chat_preguntas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `chat_registro`
--
ALTER TABLE `chat_registro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;

--
-- AUTO_INCREMENT de la tabla `chat_rp`
--
ALTER TABLE `chat_rp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT de la tabla `concepto_pago`
--
ALTER TABLE `concepto_pago`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `documentacion_persona`
--
ALTER TABLE `documentacion_persona`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `pago_solicitud`
--
ALTER TABLE `pago_solicitud`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pre_registro`
--
ALTER TABLE `pre_registro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `seer_asesorias`
--
ALTER TABLE `seer_asesorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `seer_auxiliares`
--
ALTER TABLE `seer_auxiliares`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `seer_citados`
--
ALTER TABLE `seer_citados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT de la tabla `seer_colectivas`
--
ALTER TABLE `seer_colectivas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `seer_conciliadores`
--
ALTER TABLE `seer_conciliadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `seer_convenios`
--
ALTER TABLE `seer_convenios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `seer_general`
--
ALTER TABLE `seer_general`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT de la tabla `seer_motivos`
--
ALTER TABLE `seer_motivos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT de la tabla `seer_solicitante`
--
ALTER TABLE `seer_solicitante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `turnos`
--
ALTER TABLE `turnos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT de la tabla `turno_disponible`
--
ALTER TABLE `turno_disponible`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

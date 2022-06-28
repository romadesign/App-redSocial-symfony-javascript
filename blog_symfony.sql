-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 28-06-2022 a las 09:35:18
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
-- Base de datos: `blog_symfony`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `category`
--

INSERT INTO `category` (`id`, `name`, `description`) VALUES
(1, 'Front-end', 'Front-end'),
(7, 'Back-end', 'Back-end'),
(12, 'Full Stack', 'Full Stack');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220530072058', '2022-05-30 09:21:12', 83),
('DoctrineMigrations\\Version20220607132728', '2022-06-07 15:41:30', 41);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `following`
--

CREATE TABLE `following` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `followed_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `following`
--

INSERT INTO `following` (`id`, `user_id`, `followed_id`) VALUES
(143, 10, 8),
(183, 12, 5),
(184, 12, 7),
(185, 12, 8),
(187, 9, 5),
(192, 10, 6),
(196, 13, 5),
(199, 9, 6),
(201, 9, 8),
(202, 9, 9),
(203, 9, 10),
(207, 10, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `publication_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `publication_id`) VALUES
(268, 9, 2),
(269, 9, 6),
(271, 9, 148),
(276, 10, 8),
(277, 6, 2),
(278, 6, 1),
(279, 8, 152);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type_not` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_id` int(11) NOT NULL,
  `readed` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `extra` varchar(110) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `post`
--

INSERT INTO `post` (`id`, `user_id`, `categoria_id`, `title`, `text`, `date`, `image`, `status`) VALUES
(1, 9, 1, 'Javascript', '¿Sabías que en JavaScript puedes usar la desestructuración en Arrays apuntando directamente a los índices?\r\n\r\nEs bastante útil cuando quieres recuperar más de una posición a la vez.', '2022-06-28 07:26:01', '24bf93bf9af5cd75efcea1bfdba858bf.jpg', 'public'),
(2, 9, 1, 'Front', 'A veces, al hacer una serie de proyectos ordinarios, trato de desafiar mis habilidades html y css. Esta vez fui a WhatsApp, pero hice un poco de tiempo, lo que pensé que sería bueno.', '2022-06-28 07:36:55', '05685264a7364d1613985c415690b4b9.jpg', 'public'),
(6, 9, 12, 'El enfoque', 'El enfoque de DevOps tiene como objetivo eliminar la estructura tradicionalmente aislada para los equipos de desarrollo y operaciones para mejorar la colaboración entre ellos. Como resultado, DevOps tiene muchas ventajas comerciales y tecnológicas, incluidos ciclos de desarrollo más cortos, mayor velocidad de implementación, menor tiempo de comercialización y más.', '2022-06-28 07:46:46', 'de21e2ca80f1aadfdafea7a00d6cfc56.jpg', 'public'),
(8, 9, 7, 'Hello', 'Hola 👋 Hoy hablamos un poco sobre cripto-pagos usando tus bitcoins, permitiendo hacer pagos inmediatos y con comosiones ínfimas. Durante 2022 se estará hablando mucho sobre lightning-network y como se podría masificar BTC como medio de pago diario. ¿Querés conocer el ABC sobre LN? 👇', '2022-06-28 07:49:25', '7cc5ae56eff6f8c7e93044200540a68f.jpg', 'public'),
(86, 10, 12, 'Python', 'En AntPack estamos en búsqueda de un desarrollador Python con experiencia en Django, pruebas unitarias y DRF.', '2022-06-28 07:51:12', '03999c086388f7ff1fd68fcf033b57a9.jpg', 'public'),
(93, 9, 7, 'Http', '🌐𝐂𝐎𝐃𝐈𝐆𝐎𝐒 𝐇𝐓𝐓𝐏: 𝒽𝓉𝓉𝓅 𝓈𝓉𝒶𝓉𝓊𝓈 𝒸𝑜𝒹𝑒\r\n\r\n💡𝘓𝘰𝘴 𝘏𝘛𝘛𝘗 𝘴𝘵𝘢𝘵𝘶𝘴 𝘤𝘰𝘥𝘦 𝘴𝘰𝘯 𝘤ó𝘥𝘪𝘨𝘰𝘴 𝘥𝘦 3 𝘥í𝘨𝘪𝘵𝘰𝘴 𝘦𝘯𝘷𝘪𝘢𝘥𝘰𝘴 𝘥𝘦𝘭 𝘴𝘦𝘳𝘷𝘪𝘥𝘰𝘳 𝘢𝘭 𝘤𝘭𝘪𝘦𝘯𝘵𝘦 𝘲𝘶𝘦 𝘪𝘯𝘥𝘪𝘤𝘢 𝘴𝘪 𝘭𝘢 𝘴𝘰𝘭𝘪𝘤𝘪𝘵𝘶𝘥 𝘧𝘶𝘦 𝘦𝘹𝘪𝘵𝘰𝘴𝘢 𝘰 𝘯𝘰\r\n\r\n1XX: Codigos de información\r\n2XX: Codigos exitosos\r\n3XX: Codigos de redirección\r\n4XX: Errores HTTP de Cliente\r\n5XX: Errores de Servidor\r\n\r\n👇🏻¡Aprendelos o guardalos para cuando los necesites!👇🏻', '2022-06-28 07:33:33', 'b3301e56d4e57cd475cb747fa971a57e.jpg', 'public'),
(148, 10, 1, 'Linux', 'Saludos y gracias por permitirme ingresar a la comunidad, hoy 25 de agosto, se está celebrando el 29 aniversario del proyecto Linux habiendo iniciado el 25 de agosto de 1991, siendo vanguardista en la red como uno de los proyectos opensource más legendarios de la historia y lider en los servicios de internet, predominando en los servidores', '2022-06-28 07:54:11', '0ba35a6c440eba4ad05c84162c0755e8.jpg', 'public'),
(150, 5, 12, 'Dynamic programming', 'Dynamic programming, or DP, is an optimization technique. It is used in several fields, though this article focuses on its applications in the field of algorithms and computer programming. Its a topic often asked in algorithmic interviews.', '2022-06-28 08:06:31', 'ffeb3379f00d3e890ecc3ecb70bd3a2e.png', 'public'),
(151, 6, 1, 'Consejos SEO para posicionar un podcast', 'Principalmente hay que tener claro que es SEO y cómo ayuda a posicionar un podcast. Pues bien, SEO significa (optimización de motores de búsqueda). Mientras que el podcast, es un formato digital de audio o video, el cual contendrá una serie de episodios descargables para un dispositivo móvil.', '2022-06-28 08:10:02', '6405362c44a91bb32f70ba9d92c25566.jpg', 'public'),
(152, 7, 1, '5 Formas de mejorar el SEO en los vídeos', 'El propósito de SEO (optimización de motores de búsqueda) es, como sus siglas lo indican, optimizar los resultados de búsqueda.', '2022-06-28 08:12:35', '7a832f571ea9185d058a8e6e7f023d98.jpg', 'public');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `post_tag`
--

CREATE TABLE `post_tag` (
  `post_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `post_tag`
--

INSERT INTO `post_tag` (`post_id`, `tag_id`) VALUES
(2, 187),
(6, 189),
(8, 190),
(86, 193),
(93, 186),
(148, 194),
(150, 195),
(151, 196),
(152, 197);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tag`
--

CREATE TABLE `tag` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tag`
--

INSERT INTO `tag` (`id`, `name`, `description`) VALUES
(186, 'Mysql', 'Mysql'),
(187, 'Html', 'Html'),
(189, 'Full Stack', 'Full Stack'),
(190, 'React Js', 'React Js'),
(193, 'Python', 'Python'),
(194, 'Php', 'Php'),
(195, 'Full Stack', 'Full Stack'),
(196, 'Seo', 'Seo'),
(197, 'Seo', 'Seo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `subname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `name`, `img`, `active`, `subname`, `date`) VALUES
(5, 'favian@gmail.com', '[\"ROLE_USER\"]', '$2y$13$UaOXWw8bhmb7aKcxZVbOperFJ9Oa46aAPIdeGrU4syXiw2ivFVah2', 'Fabian', 'perfil.png', 1, '2', '2022-05-30 12:07:35'),
(6, 'alex@gmail.com', '[\"ROLE_USER\"]', '$2y$13$UaOXWw8bhmb7aKcxZVbOperFJ9Oa46aAPIdeGrU4syXiw2ivFVah2', 'Alex', 'perfil.png', 1, 'gom', '2022-05-30 12:11:54'),
(7, 'martin@gmail.com', '[\"ROLE_USER\"]', '$2y$13$UaOXWw8bhmb7aKcxZVbOperFJ9Oa46aAPIdeGrU4syXiw2ivFVah2', 'Martin', 'perfil.png', 1, '23', '2022-05-30 12:13:05'),
(8, 'dani@gmail.com', '[\"ROLE_USER\"]', '$2y$13$UaOXWw8bhmb7aKcxZVbOperFJ9Oa46aAPIdeGrU4syXiw2ivFVah2', 'Danitza', 'perfil.png', 1, 'we', '2022-05-30 12:57:12'),
(9, 'urzula@gmail.com', '[\"ROLE_USER\"]', '$2y$13$d/1Spa.wC3gIP6BPlkRTret7oEmFLeqsT20RKfClfhgMNu8/aTWA.', 'Urzula', '4d19b7c101457bb250b0a1a80f2722f1.png', 1, 'roma', '2022-05-30 13:58:58'),
(10, 'admin@gmail.com', '[\"ROLE_USER\",\"ROLE_ADMIN\"]', '$2y$13$UaOXWw8bhmb7aKcxZVbOperFJ9Oa46aAPIdeGrU4syXiw2ivFVah2', 'Romacode', 'ed332176e2039180011699cb1aa55b5b.jpg', 1, 'edits', '2022-05-30 14:02:53'),
(11, 'camila@gmail.com', '[\"ROLE_USER\"]', '$2y$13$4wr8vpQ/EeU0uGTkQwWpKezltPCK/TRPwUULwDFZecySuCL4USbIC', 'Camila', 'perfil.png', 1, 'nal', '2022-06-17 20:45:22'),
(12, 'oscar@gmail.com', '[\"ROLE_USER\"]', '$2y$13$LMpHHF4/Gugehnr0gW9RgOL8g1s./SwLXXeTyF9/HUzjjDl9o2h7C', 'Oscar', 'perfil.png', 1, 'asdsad', '2022-06-27 08:40:19'),
(13, 'roman@gmail.com', '[\"ROLE_USER\"]', '$2y$13$3cZHptlus0z5pLGOgmkTZuJCH9uH5UbLBPubZaVAXL9VEQkRvf.Za', 'Roman', 'perfil.png', 1, 'asdsa', '2022-06-28 02:44:08');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indices de la tabla `following`
--
ALTER TABLE `following`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_71BF8DE3A76ED395` (`user_id`),
  ADD KEY `IDX_71BF8DE3D956F010` (`followed_id`);

--
-- Indices de la tabla `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_49CA4E7DA76ED395` (`user_id`),
  ADD KEY `IDX_49CA4E7D38B217A7` (`publication_id`);

--
-- Indices de la tabla `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6000B0D3A76ED395` (`user_id`);

--
-- Indices de la tabla `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5A8A6C8DA76ED395` (`user_id`),
  ADD KEY `IDX_5A8A6C8D3397707A` (`categoria_id`);

--
-- Indices de la tabla `post_tag`
--
ALTER TABLE `post_tag`
  ADD PRIMARY KEY (`post_id`,`tag_id`),
  ADD KEY `IDX_5ACE3AF04B89032C` (`post_id`),
  ADD KEY `IDX_5ACE3AF0BAD26311` (`tag_id`);

--
-- Indices de la tabla `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `following`
--
ALTER TABLE `following`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=208;

--
-- AUTO_INCREMENT de la tabla `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=280;

--
-- AUTO_INCREMENT de la tabla `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT de la tabla `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=198;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `following`
--
ALTER TABLE `following`
  ADD CONSTRAINT `FK_71BF8DE3A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_71BF8DE3D956F010` FOREIGN KEY (`followed_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `FK_49CA4E7D38B217A7` FOREIGN KEY (`publication_id`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `FK_49CA4E7DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `FK_6000B0D3A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `FK_5A8A6C8D3397707A` FOREIGN KEY (`categoria_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `FK_5A8A6C8DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `post_tag`
--
ALTER TABLE `post_tag`
  ADD CONSTRAINT `FK_5ACE3AF04B89032C` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_5ACE3AF0BAD26311` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

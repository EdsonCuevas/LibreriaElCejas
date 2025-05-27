CREATE TABLE `libros` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `titulo` varchar(255),
  `sinopsis` varchar(255),
  `isbn` varchar(255),
  `imagen` varchar(255),
  `autor_id` integer,
  `categoria_id` integer,
  `fecha_publicacion` date,
  `numero_paginas` integer,
  `idioma` varchar(255),
  `created_at` timestamp,
  `updated_at` timestamp
);

CREATE TABLE `autores` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `nombre_completo` varchar(255),
  `nacionalidad` varchar(255),
  `created_at` timestamp,
  `updated_at` timestamp
);

CREATE TABLE `categorias` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `nombre_categoria` varchar(255),
  `descripcion` text,
  `created_at` timestamp,
  `updated_at` timestamp
);

ALTER TABLE `libros` ADD FOREIGN KEY (`autor_id`) REFERENCES `autores` (`id`);

ALTER TABLE `libros` ADD FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);

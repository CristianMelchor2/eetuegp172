-- SQL para crear la tabla language_list básica para evitar error 500
CREATE TABLE IF NOT EXISTS `language_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `code` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insertar idioma por defecto (opcional)
INSERT INTO `language_list` (`name`, `code`) VALUES ('Español', 'es');

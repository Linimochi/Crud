
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `formulario` (
  `id` int NOT NULL auto_increment,
  `email` varchar(45) NOT NULL,
  `senha` varchar(45) NOT NULL,
  `endereco` varchar(45) NOT NULL,
  `datan` date NOT NULL,
  PRIMARY KEY(id)
);

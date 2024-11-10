
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `formulario` (
  `id` int NOT NULL auto_increment,
  `email` varchar(45) NOT NULL,
  `senha` varchar(45) NOT NULL,
  `endereco` varchar(45) NOT NULL,
  `datan` date NOT NULL,
  PRIMARY KEY("id")
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `formulario`
--

INSERT INTO `formulario` (`id`, `email`, `senha`, `endereco`, `datan`) VALUES
(0, 'ana@clara.gmail.com', 'anananana', 'sabia 26 ', '2006-04-14'),
(0, 'ana@clara.gmail.com', 'anananana', 'sabia 26 ', '2006-04-14'),
(0, 'ana@clara.gmail.com', 'anananana', 'sabia 26 ', '2006-04-14'),
(0, 'ana@gmail.com', 'aaaa', 'sabia', '0555-05-04'),
(0, 'ana@gmail.com', 'aaaa', 'sabia', '0555-05-04'),
(0, 'ana@clara.gmail.com', 'aaa', 'aaaaa', '0000-00-00');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 07-Dez-2023 às 04:20
-- Versão do servidor: 10.4.17-MariaDB
-- versão do PHP: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `ags`
--
CREATE DATABASE IF NOT EXISTS `ags` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `ags`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `adm`
--

CREATE TABLE `adm` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `adm`
--

INSERT INTO `adm` (`id`, `nome`, `email`, `senha`) VALUES
(1, 'Administrador', 'adminfit@ags.com', 'admin123');

-- --------------------------------------------------------

--
-- Estrutura da tabela `aluno`
--

CREATE TABLE `aluno` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(50) NOT NULL,
  `sexo` varchar(10) NOT NULL,
  `dataNascimento` date DEFAULT NULL,
  `cpf` varchar(15) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `cep` varchar(15) NOT NULL,
  `endereco` varchar(60) NOT NULL,
  `numero` varchar(6) NOT NULL,
  `bairro` varchar(45) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `estado` varchar(20) NOT NULL,
  `avaliacao` varchar(20) NOT NULL,
  `observacao` varchar(500) NOT NULL,
  `dataCadastro` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `aluno`
--

INSERT INTO `aluno` (`id`, `nome`, `email`, `senha`, `sexo`, `dataNascimento`, `cpf`, `telefone`, `cep`, `endereco`, `numero`, `bairro`, `cidade`, `estado`, `avaliacao`, `observacao`, `dataCadastro`) VALUES
(1, 'Adrian Kauan', 'kauan.melo2013@hotmail.com', '123456789', 'Masculino', '2000-10-11', '14990855914', '44997643857', '87565000', 'Rua Suica', '564', 'Centro', 'Cafezal do Sul', 'PR', '', 'testador', '2023-11-23 00:08:36'),
(2, 'Jhimy Ferrari', 'jferrari@gmail.com', '874021', 'Masculino', '2005-05-02', '14484508028', '6767676453', '87570000', 'Rua Londres', '90', 'Centro', 'Perobal', 'PR', '', 'a', '2023-11-29 09:33:09'),
(6, 'Ivanildo Rocha de Melo', 'ivanildorochademelo@gmail.com', '9080', 'Masculino', '0000-00-00', '58923292915', '44999968305', '87565000', 'Rodovia PR 485 Italo Orcelli', '445C', 'Santa Maria', 'Cafezal do Sul', 'Pa', '', 'aa', '2023-10-06 15:36:38'),
(9, 'Adrian Kauan Aquino de Melo', 'kauan.melo2013@hotmail.com', 'satrsrtut', 'Masculino', '0000-00-00', '149.908.559', '44997643857', '87565-000', 'Rua Suíça', '564', 'Centro ', 'Cafezal do Sul', 'Pa', '', 'ikh', '2023-10-06 15:56:05'),
(10, 'Adrian Kauan Melo', 'kauan.melo2013@hotmail.com', 'asdewq', 'Masculino', '2023-10-03', '149.908.559', '44997643857', '87565-000', 'Rua Suíça', '564', 'Centro ', 'Cafezal do Sul', 'PR', '', 'afa', '2023-10-06 15:58:42'),
(11, 'Borth Teste', 'borthtest@gmail.com', '123456', 'Masculino', '1988-06-20', '16711001907', '4498613378', '87540000', 'Avenida Paraná', '408', 'Centro', 'Umuarama', 'PR', '', 'testador', '2023-11-10 10:49:08'),
(12, 'Marcos Rezende', 'rezende@adr.com', 'rezende123', '', NULL, '', '', '', '', '', '', '', '', '', '', '2023-11-22 12:18:12'),
(13, 'Lucas Fontana', 'fontana@autosuper.com', 'lucassuper478', '', NULL, '', '', '', '', '', '', '', '', '', '', '2023-11-22 12:19:13'),
(14, 'Daniele Aquino', 'dani.melo@gmail.com', 'dani2025', '', NULL, '', '', '', '', '', '', '', '', '', '', '2023-11-22 12:20:35'),
(16, 'Lucas Teste', 'lucas21@gmail.com', 'lucas213', 'Masculino', '2005-11-09', '58923298', '44997643857', '8757000', 'Rua Jorge ', '456', 'Centro', 'Francisco Alves', 'PR', '', 'teste', '2023-11-23 10:46:33'),
(17, 'Gabriel Bortoloto', 'gabrielbortoloto0@gmail.com', '1234', 'Masculino', '2004-05-10', '13262180939', '44984468514', '87538000', 'Rua Alecrim', '1406', 'Centro', 'Perobal', 'Pa', '', 'zzzz', '2023-11-23 10:54:12'),
(18, 'João Gabriel', 'joaog@gmail.com', '987654321', '', NULL, '', '', '', '', '', '', '', '', '', '', '2023-11-24 11:02:28'),
(20, 'Daniele Melo', 'dani.melo2@gmail.com', 'teste123', 'Feminino', '1998-03-29', '85582760059', '4498390614', '87560-970', 'Rua Ary Barroso', '345', 'Centro', 'Iporã', 'PR', '', 'abc', '2023-12-07 00:18:43');

-- --------------------------------------------------------

--
-- Estrutura da tabela `exercicio`
--

CREATE TABLE `exercicio` (
  `id` int(11) NOT NULL,
  `nome` varchar(40) NOT NULL,
  `imagem` varchar(30) NOT NULL,
  `descricao` varchar(500) NOT NULL,
  `grupomuscular_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `exercicio`
--

INSERT INTO `exercicio` (`id`, `nome`, `imagem`, `descricao`, `grupomuscular_id`) VALUES
(4, 'Supino Reto', 'Design_sem_nome__32_.jpg', 'teste', 2),
(5, 'Leg Press 90', 'leg90.png', 'teste', 1),
(6, 'Leg 45', 'lg-45.png', 'leg ', 5);

-- --------------------------------------------------------

--
-- Estrutura da tabela `exercicio_treino`
--

CREATE TABLE `exercicio_treino` (
  `id` int(11) NOT NULL,
  `ficha_treino_id` int(11) NOT NULL,
  `treino_id` int(11) NOT NULL,
  `exercicio_id` int(11) NOT NULL,
  `series` int(11) NOT NULL,
  `repeticoes` int(11) NOT NULL,
  `carga_velocidade` varchar(255) NOT NULL,
  `tempo_descanso` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `exercicio_treino`
--

INSERT INTO `exercicio_treino` (`id`, `ficha_treino_id`, `treino_id`, `exercicio_id`, `series`, `repeticoes`, `carga_velocidade`, `tempo_descanso`) VALUES
(224, 87, 1, 4, 3, 12, '50kg', '1min'),
(225, 87, 2, 5, 3, 10, '110kg', '2min'),
(226, 87, 2, 4, 4, 10, '40kg', '40s'),
(227, 87, 2, 6, 4, 10, '200kg', '2min'),
(245, 94, 0, 5, 1, 1, '1', '1'),
(246, 94, 0, 6, 2, 2, '2', '2'),
(247, 94, 0, 4, 3, 3, '3', '3'),
(248, 95, 0, 6, 1, 1, '1', '1'),
(249, 95, 0, 5, 2, 2, '2', '2'),
(250, 95, 0, 4, 3, 3, '3', '3'),
(251, 96, 1, 6, 1, 1, '1', '1'),
(252, 96, 2, 5, 2, 2, '2', '2'),
(253, 96, 2, 4, 3, 3, '3', '3'),
(257, 99, 0, 4, 4, 4, '44', '4'),
(258, 99, 0, 6, 5, 5, '5', '5'),
(259, 99, 0, 5, 6, 6, '6', '6'),
(268, 102, 1, 4, 3, 12, '50kg', '1min'),
(269, 102, 1, 6, 4, 12, '220kg', '2min'),
(270, 102, 2, 4, 4, 10, '40kg', '40s'),
(271, 102, 2, 5, 3, 10, '140kg', '2min'),
(272, 103, 1, 4, 3, 10, '50kg', '1min'),
(273, 103, 1, 5, 4, 12, '50kg', '1min'),
(274, 103, 2, 4, 1, 1, '1', '1'),
(275, 103, 2, 6, 2, 2, '2', '2'),
(276, 104, 1, 5, 1, 1, '1', '1'),
(277, 104, 2, 4, 2, 2, '2', '2'),
(278, 105, 1, 4, 1, 1, '1', '1'),
(279, 105, 1, 5, 2, 2, '2', '2'),
(280, 105, 2, 4, 3, 3, '3', '3'),
(281, 105, 2, 6, 4, 4, '4', '4'),
(282, 105, 3, 4, 5, 5, '5', '5'),
(283, 105, 3, 4, 6, 6, '6', '6');

-- --------------------------------------------------------

--
-- Estrutura da tabela `ficha_treino`
--

CREATE TABLE `ficha_treino` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `aluno_id` int(11) NOT NULL,
  `personal_id` int(11) DEFAULT NULL,
  `num_treinos` int(11) NOT NULL,
  `descricao` text NOT NULL,
  `dataCadastro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `ficha_treino`
--

INSERT INTO `ficha_treino` (`id`, `nome`, `aluno_id`, `personal_id`, `num_treinos`, `descricao`, `dataCadastro`) VALUES
(87, 'Hipertrofia', 9, NULL, 2, 'teste', '2023-11-30 10:21:36'),
(94, 'Olimpia', 17, 6, 2, 'teste', '2023-11-24 11:31:26'),
(95, 'Olimpia Win', 9, 6, 2, 'ae', '2023-11-30 11:43:49'),
(96, 'Olimpia Win', 9, 6, 2, 'ae', '2023-11-24 11:46:32'),
(99, 'chegaa', 1, 6, 2, 'a', '2023-11-29 12:00:46'),
(102, 'Aeróbico Teste', 9, 6, 2, 'teste de treino', '2023-11-29 09:08:00'),
(103, 'Hipertrofia', 9, 6, 2, 'afa', '2023-12-03 09:59:09'),
(104, 'teste', 2, 7, 2, 'a', '2023-12-04 21:09:39'),
(105, 'ada', 20, 6, 3, 'aa', '2023-12-07 00:06:02');

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupomuscular`
--

CREATE TABLE `grupomuscular` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `imagem` varchar(20) NOT NULL,
  `descricao` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `grupomuscular`
--

INSERT INTO `grupomuscular` (`id`, `nome`, `imagem`, `descricao`) VALUES
(1, 'Braço', '6147326.png', 'teste'),
(2, 'Peito', '6583972.png', 'bora bill'),
(5, 'Perna', 'treino-de-perna.jpeg', 'Pernaa');

-- --------------------------------------------------------

--
-- Estrutura da tabela `personal`
--

CREATE TABLE `personal` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(50) NOT NULL,
  `sexo` varchar(10) NOT NULL,
  `dataNascimento` date DEFAULT NULL,
  `cref` varchar(15) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `cnpj` varchar(20) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `cep` varchar(15) NOT NULL,
  `endereco` varchar(100) NOT NULL,
  `numero` varchar(6) NOT NULL,
  `bairro` varchar(45) NOT NULL,
  `cidade` varchar(50) NOT NULL,
  `estado` varchar(20) NOT NULL,
  `observacao` varchar(500) NOT NULL,
  `estatus` varchar(10) NOT NULL DEFAULT 'ativo',
  `dataCadastro` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `personal`
--

INSERT INTO `personal` (`id`, `nome`, `email`, `senha`, `sexo`, `dataNascimento`, `cref`, `cpf`, `cnpj`, `telefone`, `cep`, `endereco`, `numero`, `bairro`, `cidade`, `estado`, `observacao`, `estatus`, `dataCadastro`) VALUES
(2, 'Juliano Ferreira', 'ferreiraj@gmail.com', 'juferreira20', 'Ma', '0000-00-00', '676131546133', '9713165', '', '8746513231', '87570000', 'Rua Londres', '87', 'Centro', 'Iporã', 'PR', '', 'ativo', '2023-09-29 10:33:15'),
(3, 'Juliano Ferreira 2', 'ferreiraj2@gmail.com', '98762914', 'Ma', '0000-00-00', '216871231987', '97746513', '', '874651323', '87570000', 'Rua Londres', '87', 'Centro', 'Iporã', 'PR', 'afaga', 'ativo', '2023-09-29 10:33:15'),
(4, 'Ricardo Rosa 2', 'ricarosa@nrsports.com', 'ricarosa20', 'Masculino', '1987-11-22', '09896180', '64196514928', '84767440000169', '44997643857', '87565000', 'Rua Suíça', '564', 'Centro ', 'Cafezal do Sul', 'Parana', 'nada', 'ativo', '2023-11-19 21:13:33'),
(5, 'Daniele Aquino', 'dani.melo@gmail.com', 'dani2025', '', '0000-00-00', '', '', '', '', '', '', '', '', '', '', '', 'ativo', '2023-11-22 12:21:41'),
(6, 'Julio Cocielo', 'cocielo@gmail.com', 'juliococielo2', 'Masculino', '1980-12-25', '9875321464', '96969938034', '27355653000140', '449786568165', '86055660', 'Rua Agostinho Hass', '980', 'Gleba Palhano', 'Londrina', 'Paraná', 'Julio Cocielo é um personal trainer renomado que se destaca no mundo do fitness e bem-estar. Com uma paixão pela saúde física e mental, Julio dedicou sua carreira a inspirar e motivar pessoas a atingirem seus objetivos de condicionamento físico.\r\n\r\nSua abordagem única e inovadora para o treinamento personalizado o tornou uma figura respeitada na indústria do fitness. Julio acredita que a jornada para uma vida saudável vai além do físico, integrando aspectos mentais e emocionais para alcançar um ', 'ativo', '2023-11-24 10:58:38'),
(7, 'Amanda Aquino', 'amanda@gmail.com', 'amanda28i1', '', '0000-00-00', '', '', '', '', '', '', '', '', '', '', '', 'ativo', '2023-11-22 12:28:07'),
(10, 'Julio Ballestrin', 'jballestrin@gmail.com', 'af24354aga', '', NULL, '', '', '', '', '', '', '', '', '', '', '', 'ativo', '2023-12-06 22:56:14'),
(12, 'Renato Cariani', 'cariani@gmail.com', 'maxtitanium2', '', NULL, '', '', '', '', '', '', '', '', '', '', '', 'ativo', '2023-12-06 22:59:40');

-- --------------------------------------------------------

--
-- Estrutura da tabela `treino`
--

CREATE TABLE `treino` (
  `id` int(11) NOT NULL,
  `ficha_treino_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `treino`
--

INSERT INTO `treino` (`id`, `ficha_treino_id`) VALUES
(8, 49),
(9, 49),
(16, 53),
(17, 53),
(20, 55),
(21, 55),
(22, 56),
(23, 56),
(24, 57),
(25, 57),
(26, 58),
(27, 59),
(28, 60),
(29, 60),
(30, 61),
(31, 61),
(32, 62),
(33, 62),
(34, 63),
(35, 63),
(36, 64),
(37, 65),
(38, 65);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `adm`
--
ALTER TABLE `adm`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `aluno`
--
ALTER TABLE `aluno`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `exercicio`
--
ALTER TABLE `exercicio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_exercicio_grupomuscular` (`grupomuscular_id`);

--
-- Índices para tabela `exercicio_treino`
--
ALTER TABLE `exercicio_treino`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_exercicio_treino_treino` (`ficha_treino_id`),
  ADD KEY `fk_exercicio_treino_exercicio` (`exercicio_id`);

--
-- Índices para tabela `ficha_treino`
--
ALTER TABLE `ficha_treino`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ficha_treino_aluno` (`aluno_id`),
  ADD KEY `fk_ficha_treino_personal` (`personal_id`);

--
-- Índices para tabela `grupomuscular`
--
ALTER TABLE `grupomuscular`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `treino`
--
ALTER TABLE `treino`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_treino_ficha_treino` (`ficha_treino_id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `adm`
--
ALTER TABLE `adm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `aluno`
--
ALTER TABLE `aluno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de tabela `exercicio`
--
ALTER TABLE `exercicio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `exercicio_treino`
--
ALTER TABLE `exercicio_treino`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=284;

--
-- AUTO_INCREMENT de tabela `ficha_treino`
--
ALTER TABLE `ficha_treino`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT de tabela `grupomuscular`
--
ALTER TABLE `grupomuscular`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `personal`
--
ALTER TABLE `personal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de tabela `treino`
--
ALTER TABLE `treino`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `exercicio`
--
ALTER TABLE `exercicio`
  ADD CONSTRAINT `fk_exercicio_grupomuscular` FOREIGN KEY (`grupomuscular_id`) REFERENCES `grupomuscular` (`id`);

--
-- Limitadores para a tabela `exercicio_treino`
--
ALTER TABLE `exercicio_treino`
  ADD CONSTRAINT `fk_exercicio_treino_exercicio` FOREIGN KEY (`exercicio_id`) REFERENCES `exercicio` (`id`),
  ADD CONSTRAINT `fk_exercicio_treino_ficha_treino` FOREIGN KEY (`ficha_treino_id`) REFERENCES `ficha_treino` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `ficha_treino`
--
ALTER TABLE `ficha_treino`
  ADD CONSTRAINT `fk_ficha_treino_aluno` FOREIGN KEY (`aluno_id`) REFERENCES `aluno` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ficha_treino_personal` FOREIGN KEY (`personal_id`) REFERENCES `personal` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

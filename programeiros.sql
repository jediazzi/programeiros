-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Tempo de geração: 01/11/2016 às 13:24
-- Versão do servidor: 5.5.52-0+deb8u1
-- Versão do PHP: 5.6.27-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de dados: `programeiros`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `login`
--

CREATE TABLE IF NOT EXISTS `login` (
`id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `data` date NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Fazendo dump de dados para tabela `login`
--

INSERT INTO `login` (`id`, `nome`, `email`, `usuario`, `senha`, `data`) VALUES
(13, 'Jefferson A. Diazzi', 'jefferson_diazzi@hotmail.com', 'jediazzi', 'ae5fa580277c9087bd2f0d784dfbc6f6', '2016-08-18'),
(15, 'admin', 'admin@admin.com', 'admin', 'ee10c315eba2c75b403ea99136f5b48d', '2016-11-01');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_postagens`
--

CREATE TABLE IF NOT EXISTS `tb_postagens` (
`id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `conteudo` text NOT NULL,
  `categoria` varchar(55) NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `usuario` varchar(255) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Fazendo dump de dados para tabela `tb_postagens`
--

INSERT INTO `tb_postagens` (`id`, `titulo`, `conteudo`, `categoria`, `imagem`, `data`, `hora`, `usuario`) VALUES
(27, 'teste1', 'teste', 'teste', '1311441068.jpg', '2016-11-01', '02:10:07', 'Jefferson A. Diazzi'),
(28, 'teste23', 'teste12', 'teste', '1807624847.jpg', '2016-11-01', '02:10:15', 'Jefferson A. Diazzi');

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `login`
--
ALTER TABLE `login`
 ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tb_postagens`
--
ALTER TABLE `tb_postagens`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `login`
--
ALTER TABLE `login`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT de tabela `tb_postagens`
--
ALTER TABLE `tb_postagens`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

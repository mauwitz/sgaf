-- phpMyAdmin SQL Dump
-- version 3.4.10.2deb1.precise~ppa.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de GeraÁ„o: 07/12/2012 √†s 16h52min
-- Vers„o do Servidor: 5.5.28
-- Vers„o do PHP: 5.3.10-1ubuntu3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `sgaf`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `acertos`
--

CREATE TABLE IF NOT EXISTS `acertos` (
  `ace_codigo` bigint(18) NOT NULL AUTO_INCREMENT,
  `ace_data` date NOT NULL,
  `ace_hora` time NOT NULL,
  `ace_supervisor` int(11) NOT NULL,
  `ace_fornecedor` int(11) NOT NULL,
  `ace_valorbruto` float NOT NULL,
  `ace_valortaxas` float NOT NULL,
  `ace_valorpendente` float NOT NULL,
  `ace_valorpendenteanterior` float NOT NULL,
  `ace_valortotal` float NOT NULL,
  `ace_valorpago` float NOT NULL,
  `ace_trocodevolvido` float NOT NULL,
  `ace_quiosque` bigint(18) NOT NULL,
  PRIMARY KEY (`ace_codigo`),
  KEY `ace_quiosque` (`ace_quiosque`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `acertos_taxas`
--

CREATE TABLE IF NOT EXISTS `acertos_taxas` (
  `acetax_acerto` bigint(18) NOT NULL,
  `acetax_taxa` smallint(4) NOT NULL,
  `acetax_referencia` float NOT NULL,
  `acetax_valor` float NOT NULL,
  PRIMARY KEY (`acetax_acerto`,`acetax_taxa`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cidades`
--

CREATE TABLE IF NOT EXISTS `cidades` (
  `cid_codigo` smallint(4) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `cid_estado` tinyint(2) unsigned zerofill NOT NULL DEFAULT '00',
  `cid_nome` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`cid_codigo`),
  KEY `cid_estado` (`cid_estado`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9751 ;

--
-- Extraindo dados da tabela `cidades`
--

INSERT INTO `cidades` (`cid_codigo`, `cid_estado`, `cid_nome`) VALUES
(9719, 07, 'Bras√≠lia'),
(9718, 23, 'Santa Maria'),
(9717, 24, 'FlorianÛpolis'),
(9716, 23, 'Porto Alegre'),
(9715, 23, 'Salvador das Miss√µes'),
(9722, 23, 'Marcelino Ramos'),
(9723, 23, 'Erechim'),
(9724, 23, 'Rio Grande'),
(9727, 30, 'La Plata'),
(9729, 30, 'Buenos Aires'),
(9730, 26, 'S„o Paulo'),
(9743, 23, 'Roque Gonzales'),
(9733, 23, 'S„o Paulo Das Miss√µes'),
(9734, 23, 'Ivoti'),
(9737, 23, 'Dois Irm„os'),
(9739, 41, 'La Paz'),
(9740, 42, 'Morioka'),
(9741, 23, 'Campina das Miss√µes'),
(9742, 23, 'Cerro Largo'),
(9744, 23, 'S„o Pedro do Buti·'),
(9745, 23, 'C√¢ndido GodÛi'),
(9747, 23, 'S„o Luiz Gonzaga'),
(9748, 23, 'Porto Xavier'),
(9749, 23, 'Santo √Çngelo'),
(9750, 23, 'Santa Rosa');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cooperativas`
--

CREATE TABLE IF NOT EXISTS `cooperativas` (
  `coo_codigo` smallint(4) NOT NULL AUTO_INCREMENT,
  `coo_nomecompleto` varchar(70) NOT NULL,
  `coo_abreviacao` varchar(30) DEFAULT NULL,
  `coo_presidente` int(11) NOT NULL,
  PRIMARY KEY (`coo_codigo`),
  KEY `coo_presidente` (`coo_presidente`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `entradas`
--

CREATE TABLE IF NOT EXISTS `entradas` (
  `ent_codigo` bigint(20) NOT NULL AUTO_INCREMENT,
  `ent_quiosque` bigint(20) NOT NULL,
  `ent_fornecedor` bigint(20) NOT NULL,
  `ent_supervisor` bigint(20) NOT NULL,
  `ent_datacadastro` date NOT NULL,
  `ent_horacadastro` time NOT NULL,
  `ent_tipo` bigint(20) NOT NULL,
  `ent_status` tinyint(4) NOT NULL,
  `ent_valortotal` float DEFAULT NULL,
  PRIMARY KEY (`ent_codigo`),
  KEY `ent_tipo` (`ent_tipo`),
  KEY `ent_fornecedor` (`ent_fornecedor`),
  KEY `ent_vendedor` (`ent_supervisor`),
  KEY `ent_quiosque` (`ent_quiosque`),
  KEY `ent_status` (`ent_status`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `entradas_produtos`
--

CREATE TABLE IF NOT EXISTS `entradas_produtos` (
  `entpro_entrada` bigint(20) NOT NULL,
  `entpro_numero` smallint(4) NOT NULL AUTO_INCREMENT,
  `entpro_produto` bigint(20) NOT NULL,
  `entpro_quantidade` float NOT NULL,
  `entpro_valorunitario` float NOT NULL,
  `entpro_validade` date DEFAULT NULL,
  `entpro_local` varchar(40) DEFAULT NULL,
  `entpro_valtot` float NOT NULL,
  `entpro_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`entpro_entrada`,`entpro_numero`),
  KEY `entpro_entrada` (`entpro_entrada`),
  KEY `entpro_produto` (`entpro_produto`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `entradas_tipo`
--

CREATE TABLE IF NOT EXISTS `entradas_tipo` (
  `enttip_codigo` tinyint(4) NOT NULL AUTO_INCREMENT,
  `enttip_nome` varchar(70) NOT NULL,
  `enttip_descricao` text NOT NULL,
  PRIMARY KEY (`enttip_codigo`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `entradas_tipo`
--

INSERT INTO `entradas_tipo` (`enttip_codigo`, `enttip_nome`, `enttip_descricao`) VALUES
(1, 'Normal', ''),
(2, 'DoaÁ„o', 'Para produtos que s„o doados ao quiosque'),
(3, 'Ajuste', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `estados`
--

CREATE TABLE IF NOT EXISTS `estados` (
  `est_codigo` tinyint(2) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `est_sigla` varchar(10) NOT NULL DEFAULT '',
  `est_pais` smallint(4) NOT NULL,
  `est_nome` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`est_codigo`),
  KEY `est_pais` (`est_pais`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

--
-- Extraindo dados da tabela `estados`
--

INSERT INTO `estados` (`est_codigo`, `est_sigla`, `est_pais`, `est_nome`) VALUES
(01, 'AC', 1, 'Acre'),
(02, 'AL', 1, 'Alagoas'),
(03, 'AM', 1, 'Amazonas'),
(38, 'BN', 9, 'Beni'),
(05, 'BA', 1, 'Bahia'),
(06, 'CE', 1, 'Cear·'),
(07, 'DF', 1, 'Distrito Federal'),
(08, 'ES', 1, 'Esp√≠rito Santo'),
(09, 'GO', 1, 'Goi·s'),
(10, 'MA', 1, 'Maranh„o'),
(11, 'MG', 1, 'Minas Gerais'),
(12, 'MS', 1, 'Mato Grosso do Sul'),
(13, 'MT', 1, 'Mato Grosso'),
(14, 'PA', 1, 'Par·'),
(15, 'PB', 1, 'Para√≠ba'),
(16, 'PE', 1, 'Pernambuco'),
(17, 'PI', 1, 'Piau√≠'),
(18, 'PR', 1, 'Paran·'),
(19, 'RJ', 1, 'Rio de Janeiro'),
(20, 'RN', 1, 'Rio Grande do Norte'),
(21, 'RO', 1, 'Rond√¥nia'),
(22, 'RR', 1, 'Roraima'),
(23, 'RS', 1, 'Rio Grande do Sul'),
(24, 'SC', 1, 'Santa Catarina'),
(25, 'SE', 1, 'Sergipe'),
(26, 'SP', 1, 'S„o Paulo'),
(27, 'TO', 1, 'Tocantins'),
(34, 'MS', 2, 'Missiones'),
(39, 'CO', 9, 'Cochabamba'),
(30, 'PB', 2, 'Prov√≠ncia De Buenos '),
(40, 'PE', 9, 'Peni'),
(41, 'LP', 9, 'La Paz Estado'),
(42, 'IW', 10, 'Iwate');

-- --------------------------------------------------------

--
-- Estrutura da tabela `estoque`
--

CREATE TABLE IF NOT EXISTS `estoque` (
  `etq_quiosque` tinyint(2) NOT NULL,
  `etq_produto` bigint(20) NOT NULL,
  `etq_fornecedor` int(11) NOT NULL,
  `etq_lote` bigint(20) NOT NULL,
  `etq_quantidade` float NOT NULL,
  `etq_valorunitario` float DEFAULT NULL,
  `etq_validade` date DEFAULT NULL,
  PRIMARY KEY (`etq_quiosque`,`etq_produto`,`etq_fornecedor`,`etq_lote`),
  KEY `etqpro_quiosque` (`etq_quiosque`),
  KEY `etqpro_produto` (`etq_produto`),
  KEY `etqpro_fornecedor` (`etq_fornecedor`),
  KEY `etq_lote` (`etq_lote`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupo_permissoes`
--

CREATE TABLE IF NOT EXISTS `grupo_permissoes` (
  `gruper_codigo` tinyint(2) NOT NULL AUTO_INCREMENT,
  `gruper_nome` varchar(70) NOT NULL,
  `gruper_cooperativa_ver` tinyint(1) NOT NULL,
  `gruper_cooperativa_cadastrar` tinyint(1) NOT NULL,
  `gruper_cooperativa_editar` tinyint(1) NOT NULL,
  `gruper_cooperativa_excluir` tinyint(1) NOT NULL,
  `gruper_quiosque_ver` tinyint(1) NOT NULL,
  `gruper_quiosque_cadastrar` tinyint(1) NOT NULL,
  `gruper_quiosque_editar` tinyint(1) NOT NULL,
  `gruper_quiosque_excluir` tinyint(1) NOT NULL,
  `gruper_quiosque_definirsupervisores` tinyint(1) NOT NULL,
  `gruper_quiosque_definirvendedores` tinyint(1) NOT NULL,
  `gruper_quiosque_versupervisores` tinyint(1) NOT NULL,
  `gruper_quiosque_vervendedores` tinyint(1) NOT NULL,
  `gruper_quiosque_vertaxas` tinyint(1) NOT NULL,
  `gruper_quiosque_definircooperativa` tinyint(1) NOT NULL,
  `gruper_pessoas_alterar_cooperativa` tinyint(1) NOT NULL,
  `gruper_pessoas_cadastrar` tinyint(1) NOT NULL,
  `gruper_pessoas_cadastrar_administradores` tinyint(1) NOT NULL,
  `gruper_pessoas_cadastrar_presidentes` tinyint(1) NOT NULL,
  `gruper_pessoas_cadastrar_supervisores` tinyint(1) NOT NULL,
  `gruper_pessoas_cadastrar_vendedores` tinyint(1) NOT NULL,
  `gruper_pessoas_cadastrar_fornecedores` tinyint(1) NOT NULL,
  `gruper_pessoas_cadastrar_consumidores` tinyint(1) NOT NULL,
  `gruper_pessoas_excluir` tinyint(1) NOT NULL,
  `gruper_pessoas_ver` tinyint(1) NOT NULL,
  `gruper_pessoas_ver_presidentes` tinyint(1) NOT NULL,
  `gruper_pessoas_ver_supervisores` tinyint(1) NOT NULL,
  `gruper_pessoas_ver_vendedores` tinyint(1) NOT NULL,
  `gruper_pessoas_ver_fornecedores` tinyint(1) NOT NULL,
  `gruper_pessoas_ver_consumidores` tinyint(1) NOT NULL,
  `gruper_pessoas_ver_administradores` tinyint(1) NOT NULL,
  `gruper_pessoas_criarusuarios` tinyint(1) NOT NULL,
  `gruper_pessoas_definir_grupo_administradores` tinyint(1) NOT NULL,
  `gruper_pessoas_definir_grupo_presidentes` tinyint(1) NOT NULL,
  `gruper_pessoas_definir_grupo_supervisores` tinyint(1) NOT NULL,
  `gruper_pessoas_definir_grupo_vendedores` tinyint(1) NOT NULL,
  `gruper_pessoas_definir_grupo_fornecedores` tinyint(1) NOT NULL,
  `gruper_pessoas_definir_grupo_consumidores` tinyint(1) NOT NULL,
  `gruper_pessoas_definir_quiosqueusuario` tinyint(1) NOT NULL,
  `gruper_produtos_ver` tinyint(1) NOT NULL,
  `gruper_produtos_cadastrar` tinyint(1) NOT NULL,
  `gruper_produtos_editar` tinyint(1) NOT NULL,
  `gruper_produtos_excluir` tinyint(1) NOT NULL,
  `gruper_paises_ver` tinyint(1) NOT NULL,
  `gruper_paises_cadastrar` tinyint(1) NOT NULL,
  `gruper_paises_editar` tinyint(1) NOT NULL,
  `gruper_paises_excluir` tinyint(1) NOT NULL,
  `gruper_estados_ver` tinyint(1) NOT NULL,
  `gruper_estados_cadastrar` tinyint(1) NOT NULL,
  `gruper_estados_editar` tinyint(1) NOT NULL,
  `gruper_estados_excluir` tinyint(1) NOT NULL,
  `gruper_cidades_ver` tinyint(1) NOT NULL,
  `gruper_cidades_cadastrar` tinyint(1) NOT NULL,
  `gruper_cidades_editar` tinyint(1) NOT NULL,
  `gruper_cidades_excluir` tinyint(1) NOT NULL,
  `gruper_categorias_ver` tinyint(1) NOT NULL,
  `gruper_categorias_cadastrar` tinyint(1) NOT NULL,
  `gruper_categorias_editar` tinyint(1) NOT NULL,
  `gruper_categorias_excluir` tinyint(1) NOT NULL,
  `gruper_tipocontagem_ver` tinyint(1) NOT NULL,
  `gruper_tipocontagem_cadastrar` tinyint(1) NOT NULL,
  `gruper_tipocontagem_editar` tinyint(1) NOT NULL,
  `gruper_tipocontagem_excluir` tinyint(1) NOT NULL,
  `gruper_estoque_ver` tinyint(1) NOT NULL,
  `gruper_estoque_qtdide_definir` tinyint(1) NOT NULL,
  `gruper_entradas_ver` tinyint(1) NOT NULL,
  `gruper_entradas_cadastrar` tinyint(1) NOT NULL,
  `gruper_entradas_editar` tinyint(1) NOT NULL,
  `gruper_entradas_excluir` tinyint(1) NOT NULL,
  `gruper_entradas_etiquetas` tinyint(1) NOT NULL,
  `gruper_entradas_cancelar` tinyint(1) NOT NULL,
  `gruper_saidas_ver` tinyint(1) NOT NULL,
  `gruper_saidas_cadastrar` tinyint(1) NOT NULL,
  `gruper_saidas_excluir` tinyint(1) NOT NULL,
  `gruper_saidas_editar` tinyint(1) NOT NULL,
  `gruper_saidas_cadastrar_devolucao` tinyint(1) NOT NULL,
  `gruper_saidas_editar_devolucao` tinyint(1) NOT NULL,
  `gruper_saidas_excluir_devolucao` tinyint(1) NOT NULL,
  `gruper_saidas_ver_devolucao` tinyint(1) NOT NULL,
  `gruper_relatorios_ver` tinyint(1) NOT NULL,
  `gruper_relatorios_cadastrar` tinyint(1) NOT NULL,
  `gruper_relatorios_editar` tinyint(1) NOT NULL,
  `gruper_relatorios_excluir` tinyint(1) NOT NULL,
  `gruper_acertos_cadastrar` tinyint(1) NOT NULL,
  `gruper_acertos_editar` tinyint(1) NOT NULL,
  `gruper_acertos_excluir` tinyint(1) NOT NULL,
  `gruper_acertos_ver` tinyint(1) NOT NULL,
  `gruper_taxas_cadastrar` tinyint(1) NOT NULL,
  `gruper_taxas_editar` tinyint(1) NOT NULL,
  `gruper_taxas_excluir` tinyint(1) NOT NULL,
  `gruper_taxas_ver` tinyint(1) NOT NULL,
  `gruper_taxas_aplicar` tinyint(1) NOT NULL,
  PRIMARY KEY (`gruper_codigo`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Extraindo dados da tabela `grupo_permissoes`
--

INSERT INTO `grupo_permissoes` (`gruper_codigo`, `gruper_nome`, `gruper_cooperativa_ver`, `gruper_cooperativa_cadastrar`, `gruper_cooperativa_editar`, `gruper_cooperativa_excluir`, `gruper_quiosque_ver`, `gruper_quiosque_cadastrar`, `gruper_quiosque_editar`, `gruper_quiosque_excluir`, `gruper_quiosque_definirsupervisores`, `gruper_quiosque_definirvendedores`, `gruper_quiosque_versupervisores`, `gruper_quiosque_vervendedores`, `gruper_quiosque_vertaxas`, `gruper_quiosque_definircooperativa`, `gruper_pessoas_alterar_cooperativa`, `gruper_pessoas_cadastrar`, `gruper_pessoas_cadastrar_administradores`, `gruper_pessoas_cadastrar_presidentes`, `gruper_pessoas_cadastrar_supervisores`, `gruper_pessoas_cadastrar_vendedores`, `gruper_pessoas_cadastrar_fornecedores`, `gruper_pessoas_cadastrar_consumidores`, `gruper_pessoas_excluir`, `gruper_pessoas_ver`, `gruper_pessoas_ver_presidentes`, `gruper_pessoas_ver_supervisores`, `gruper_pessoas_ver_vendedores`, `gruper_pessoas_ver_fornecedores`, `gruper_pessoas_ver_consumidores`, `gruper_pessoas_ver_administradores`, `gruper_pessoas_criarusuarios`, `gruper_pessoas_definir_grupo_administradores`, `gruper_pessoas_definir_grupo_presidentes`, `gruper_pessoas_definir_grupo_supervisores`, `gruper_pessoas_definir_grupo_vendedores`, `gruper_pessoas_definir_grupo_fornecedores`, `gruper_pessoas_definir_grupo_consumidores`, `gruper_pessoas_definir_quiosqueusuario`, `gruper_produtos_ver`, `gruper_produtos_cadastrar`, `gruper_produtos_editar`, `gruper_produtos_excluir`, `gruper_paises_ver`, `gruper_paises_cadastrar`, `gruper_paises_editar`, `gruper_paises_excluir`, `gruper_estados_ver`, `gruper_estados_cadastrar`, `gruper_estados_editar`, `gruper_estados_excluir`, `gruper_cidades_ver`, `gruper_cidades_cadastrar`, `gruper_cidades_editar`, `gruper_cidades_excluir`, `gruper_categorias_ver`, `gruper_categorias_cadastrar`, `gruper_categorias_editar`, `gruper_categorias_excluir`, `gruper_tipocontagem_ver`, `gruper_tipocontagem_cadastrar`, `gruper_tipocontagem_editar`, `gruper_tipocontagem_excluir`, `gruper_estoque_ver`, `gruper_estoque_qtdide_definir`, `gruper_entradas_ver`, `gruper_entradas_cadastrar`, `gruper_entradas_editar`, `gruper_entradas_excluir`, `gruper_entradas_etiquetas`, `gruper_entradas_cancelar`, `gruper_saidas_ver`, `gruper_saidas_cadastrar`, `gruper_saidas_excluir`, `gruper_saidas_editar`, `gruper_saidas_cadastrar_devolucao`, `gruper_saidas_editar_devolucao`, `gruper_saidas_excluir_devolucao`, `gruper_saidas_ver_devolucao`, `gruper_relatorios_ver`, `gruper_relatorios_cadastrar`, `gruper_relatorios_editar`, `gruper_relatorios_excluir`, `gruper_acertos_cadastrar`, `gruper_acertos_editar`, `gruper_acertos_excluir`, `gruper_acertos_ver`, `gruper_taxas_cadastrar`, `gruper_taxas_editar`, `gruper_taxas_excluir`, `gruper_taxas_ver`, `gruper_taxas_aplicar`) VALUES
(1, 'Administrador', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(2, 'Presidente', 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 1, 0, 0, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 0, 0, 0, 1, 0, 1, 0, 0, 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1),
(3, 'Supervisor', 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 1, 0, 0, 1, 1, 1, 0, 1, 0, 0, 0, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 1, 1, 1, 1, 0, 0, 0, 1, 0),
(4, 'Vendedor', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(5, 'Fornecedor', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0),
(7, 'Root', 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `mestre_pessoas_tipo`
--

CREATE TABLE IF NOT EXISTS `mestre_pessoas_tipo` (
  `mespestip_pessoa` int(11) NOT NULL,
  `mespestip_tipo` tinyint(2) NOT NULL,
  PRIMARY KEY (`mespestip_pessoa`,`mespestip_tipo`),
  KEY `mespestip_pessoa` (`mespestip_pessoa`),
  KEY `mespestip_tipo` (`mespestip_tipo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `paises`
--

CREATE TABLE IF NOT EXISTS `paises` (
  `pai_codigo` smallint(6) NOT NULL AUTO_INCREMENT,
  `pai_sigla` char(3) NOT NULL,
  `pai_nome` varchar(50) NOT NULL,
  PRIMARY KEY (`pai_codigo`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Extraindo dados da tabela `paises`
--

INSERT INTO `paises` (`pai_codigo`, `pai_sigla`, `pai_nome`) VALUES
(1, 'BR', 'Brasil'),
(2, 'ARG', 'Argentina'),
(3, 'CHL', 'Chile'),
(5, 'PY', 'Paraguai'),
(9, 'BL', 'Bol√≠via'),
(10, 'JP', 'Jap„o');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pessoas`
--

CREATE TABLE IF NOT EXISTS `pessoas` (
  `pes_codigo` int(11) NOT NULL AUTO_INCREMENT,
  `pes_id` int(8) DEFAULT NULL,
  `pes_nome` varchar(70) NOT NULL,
  `pes_cidade` mediumint(11) NOT NULL,
  `pes_cep` varchar(9) DEFAULT NULL,
  `pes_bairro` varchar(70) DEFAULT NULL,
  `pes_vila` varchar(70) DEFAULT NULL,
  `pes_endereco` varchar(70) DEFAULT NULL,
  `pes_complemento` varchar(70) DEFAULT NULL,
  `pes_referencia` varchar(70) DEFAULT NULL,
  `pes_numero` varchar(11) DEFAULT NULL,
  `pes_fone1` varchar(13) DEFAULT NULL,
  `pes_fone2` varchar(13) DEFAULT NULL,
  `pes_email` varchar(70) DEFAULT NULL,
  `pes_datacadastro` date DEFAULT NULL,
  `pes_horacadastro` time DEFAULT NULL,
  `pes_dataedicao` date DEFAULT NULL,
  `pes_horaedicao` time DEFAULT NULL,
  `pes_obs` text,
  `pes_chat` varchar(70) DEFAULT NULL,
  `pes_cooperativa` tinyint(2) NOT NULL,
  `pes_possuiacesso` tinyint(1) NOT NULL,
  `pes_senha` text,
  `pes_grupopermissoes` tinyint(2) DEFAULT NULL,
  `pes_quiosqueusuario` bigint(18) DEFAULT NULL,
  PRIMARY KEY (`pes_codigo`),
  KEY `usu_cidade` (`pes_cidade`),
  KEY `pes_quiosque` (`pes_cooperativa`),
  KEY `pes_quiosqueusuario` (`pes_quiosqueusuario`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=252 ;

--
-- Extraindo dados da tabela `pessoas`
--

INSERT INTO `pessoas` (`pes_codigo`, `pes_id`, `pes_nome`, `pes_cidade`, `pes_cep`, `pes_bairro`, `pes_vila`, `pes_endereco`, `pes_complemento`, `pes_referencia`, `pes_numero`, `pes_fone1`, `pes_fone2`, `pes_email`, `pes_datacadastro`, `pes_horacadastro`, `pes_dataedicao`, `pes_horaedicao`, `pes_obs`, `pes_chat`, `pes_cooperativa`, `pes_possuiacesso`, `pes_senha`, `pes_grupopermissoes`, `pes_quiosqueusuario`) VALUES
(1, 1, 'Usu·rio Root', 0, '', '', '', '', '', '', '', '', '', '', '2012-03-27', '06:50:12', '2012-03-27', '06:51:08', 'Usu·rio padr„o do sistema, n„o pode ser exclu√≠do nunca.', '', 0, 1, '4b0daceccf8aef63c93aca5d5b228d31', 7, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pessoas_tipo`
--

CREATE TABLE IF NOT EXISTS `pessoas_tipo` (
  `pestip_codigo` tinyint(2) NOT NULL AUTO_INCREMENT,
  `pestip_nome` varchar(30) NOT NULL,
  PRIMARY KEY (`pestip_codigo`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=56 ;

--
-- Extraindo dados da tabela `pessoas_tipo`
--

INSERT INTO `pessoas_tipo` (`pestip_codigo`, `pestip_nome`) VALUES
(1, 'Administrador'),
(4, 'Vendedor'),
(5, 'Fornecedor'),
(6, 'Consumidor'),
(2, 'Presidente'),
(3, 'Supervisor');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE IF NOT EXISTS `produtos` (
  `pro_codigo` bigint(20) NOT NULL AUTO_INCREMENT,
  `pro_nome` varchar(70) NOT NULL,
  `pro_tipocontagem` tinyint(4) NOT NULL,
  `pro_categoria` mediumint(11) NOT NULL,
  `pro_datacriacao` date NOT NULL,
  `pro_horacriacao` time NOT NULL,
  `pro_dataedicao` date DEFAULT NULL,
  `pro_horaedicao` time DEFAULT NULL,
  `pro_descricao` text,
  `pro_obs` text,
  `pro_cooperativa` smallint(4) NOT NULL,
  `pro_estoqueminimo` float DEFAULT NULL,
  PRIMARY KEY (`pro_codigo`),
  KEY `pro_categoria` (`pro_categoria`),
  KEY `pro_tipocontagem` (`pro_tipocontagem`),
  KEY `pro_quiosque` (`pro_cooperativa`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos_categorias`
--

CREATE TABLE IF NOT EXISTS `produtos_categorias` (
  `cat_codigo` mediumint(9) NOT NULL AUTO_INCREMENT,
  `cat_nome` varchar(70) NOT NULL,
  `cat_cooperativa` smallint(4) NOT NULL,
  `cat_obs` text,
  PRIMARY KEY (`cat_codigo`),
  KEY `cat_quiosque` (`cat_cooperativa`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos_tipo`
--

CREATE TABLE IF NOT EXISTS `produtos_tipo` (
  `protip_codigo` tinyint(4) NOT NULL AUTO_INCREMENT,
  `protip_nome` varchar(70) NOT NULL,
  `protip_sigla` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`protip_codigo`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Extraindo dados da tabela `produtos_tipo`
--

INSERT INTO `produtos_tipo` (`protip_codigo`, `protip_nome`, `protip_sigla`) VALUES
(1, 'Unidade(s)', 'un.'),
(2, 'Quilo(s)', 'kg.');

-- --------------------------------------------------------

--
-- Estrutura da tabela `quantidade_ideal`
--

CREATE TABLE IF NOT EXISTS `quantidade_ideal` (
  `qtdide_quiosque` smallint(4) NOT NULL,
  `qtdide_produto` mediumint(6) NOT NULL,
  `qtdide_quantidade` float NOT NULL,
  PRIMARY KEY (`qtdide_quiosque`,`qtdide_produto`),
  KEY `qtdide_quiosque` (`qtdide_quiosque`),
  KEY `qtdide_produto` (`qtdide_produto`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `quiosques`
--

CREATE TABLE IF NOT EXISTS `quiosques` (
  `qui_codigo` bigint(18) NOT NULL AUTO_INCREMENT,
  `qui_nome` varchar(70) NOT NULL,
  `qui_cidade` int(11) NOT NULL,
  `qui_cep` varchar(9) DEFAULT NULL,
  `qui_bairro` varchar(70) DEFAULT NULL,
  `qui_vila` varchar(70) DEFAULT NULL,
  `qui_endereco` varchar(70) DEFAULT NULL,
  `qui_numero` varchar(10) DEFAULT NULL,
  `qui_complemento` varchar(70) DEFAULT NULL,
  `qui_referencia` varchar(70) DEFAULT NULL,
  `qui_fone1` varchar(13) DEFAULT NULL,
  `qui_fone2` varchar(13) NOT NULL,
  `qui_email` varchar(70) DEFAULT NULL,
  `qui_obs` text,
  `qui_datacadastro` date NOT NULL,
  `qui_horacadastro` time NOT NULL,
  `qui_dataedicao` date DEFAULT NULL,
  `qui_horaedicao` time DEFAULT NULL,
  `qui_cooperativa` int(8) NOT NULL,
  `qui_usuario` int(11) NOT NULL,
  PRIMARY KEY (`qui_codigo`),
  KEY `qui_cidade` (`qui_cidade`),
  KEY `qui_cooperativa` (`qui_cooperativa`),
  KEY `qui_usuario` (`qui_usuario`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `quiosques_supervisores`
--

CREATE TABLE IF NOT EXISTS `quiosques_supervisores` (
  `quisup_quiosque` tinyint(2) NOT NULL,
  `quisup_supervisor` int(11) NOT NULL,
  `quisup_datafuncao` date DEFAULT NULL,
  PRIMARY KEY (`quisup_quiosque`,`quisup_supervisor`),
  KEY `quisup_quiosque` (`quisup_quiosque`),
  KEY `quisup_supervisor` (`quisup_supervisor`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `quiosques_taxas`
--

CREATE TABLE IF NOT EXISTS `quiosques_taxas` (
  `quitax_quiosque` bigint(18) NOT NULL,
  `quitax_taxa` smallint(4) NOT NULL,
  `quitax_valor` float NOT NULL,
  PRIMARY KEY (`quitax_quiosque`,`quitax_taxa`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `quiosques_vendedores`
--

CREATE TABLE IF NOT EXISTS `quiosques_vendedores` (
  `quiven_quiosque` tinyint(4) NOT NULL,
  `quiven_vendedor` bigint(20) NOT NULL,
  `quiven_datafuncao` date DEFAULT NULL,
  PRIMARY KEY (`quiven_quiosque`,`quiven_vendedor`),
  KEY `ven_vendedor` (`quiven_vendedor`),
  KEY `ven_quiosque` (`quiven_quiosque`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `relatorios`
--

CREATE TABLE IF NOT EXISTS `relatorios` (
  `rel_codigo` bigint(20) NOT NULL AUTO_INCREMENT,
  `rel_nome` varchar(100) NOT NULL,
  `rel_descricao` text,
  `rel_datacadastro` date NOT NULL,
  `rel_horacadastro` time NOT NULL,
  PRIMARY KEY (`rel_codigo`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Extraindo dados da tabela `relatorios`
--

INSERT INTO `relatorios` (`rel_codigo`, `rel_nome`, `rel_descricao`, `rel_datacadastro`, `rel_horacadastro`) VALUES
(1, 'Vendas por Fornecedor (resumido)', 'Este relatÛrio mostra o valor total das vendas de todos os produtos pertencentes a um ou mais fornecedores em um per√≠odo espec√≠fico', '2012-07-04', '22:13:25'),
(12, 'Vendas por Produto (resumido)', '', '2012-07-31', '07:31:56');

-- --------------------------------------------------------

--
-- Estrutura da tabela `relatorios_permissao`
--

CREATE TABLE IF NOT EXISTS `relatorios_permissao` (
  `relper_relatorio` bigint(20) NOT NULL,
  `relper_grupo` tinyint(2) NOT NULL,
  PRIMARY KEY (`relper_relatorio`,`relper_grupo`),
  KEY `relper_relatorio` (`relper_relatorio`),
  KEY `relper_grupo` (`relper_grupo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `relatorios_permissao`
--

INSERT INTO `relatorios_permissao` (`relper_relatorio`, `relper_grupo`) VALUES
(1, 3),
(1, 5),
(12, 2),
(12, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `saidas`
--

CREATE TABLE IF NOT EXISTS `saidas` (
  `sai_codigo` bigint(20) NOT NULL AUTO_INCREMENT,
  `sai_quiosque` bigint(20) NOT NULL,
  `sai_vendedor` bigint(20) NOT NULL,
  `sai_consumidor` bigint(20) NOT NULL,
  `sai_tipo` tinyint(4) NOT NULL,
  `sai_saidajustificada` tinyint(4) DEFAULT NULL,
  `sai_descricao` text,
  `sai_datacadastro` date NOT NULL,
  `sai_horacadastro` time NOT NULL,
  `sai_status` tinyint(1) NOT NULL,
  `sai_totalbruto` float DEFAULT NULL,
  `sai_descontopercentual` float DEFAULT NULL,
  `sai_descontovalor` float DEFAULT NULL,
  `sai_totalcomdesconto` float DEFAULT NULL,
  `sai_valorecebido` float DEFAULT NULL,
  `sai_troco` float DEFAULT NULL,
  `sai_trocodevolvido` float DEFAULT NULL,
  `sai_descontoforcado` float DEFAULT NULL,
  `sai_acrescimoforcado` float DEFAULT NULL,
  `sai_totalliquido` float NOT NULL,
  PRIMARY KEY (`sai_codigo`),
  KEY `sai_quiosque` (`sai_quiosque`),
  KEY `sai_vendedor` (`sai_vendedor`),
  KEY `sai_cliente` (`sai_consumidor`),
  KEY `sai_tipo` (`sai_tipo`),
  KEY `sai_justificativa` (`sai_saidajustificada`),
  KEY `sai_status` (`sai_status`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `saidas_motivo`
--

CREATE TABLE IF NOT EXISTS `saidas_motivo` (
  `saimot_codigo` tinyint(4) NOT NULL AUTO_INCREMENT,
  `saimot_nome` varchar(70) NOT NULL,
  PRIMARY KEY (`saimot_codigo`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `saidas_motivo`
--

INSERT INTO `saidas_motivo` (`saimot_codigo`, `saimot_nome`) VALUES
(1, 'Vencimento'),
(2, 'Fornecedor Pediu'),
(3, 'Extravio'),
(4, 'Outro'),
(5, 'Ajuste');

-- --------------------------------------------------------

--
-- Estrutura da tabela `saidas_produtos`
--

CREATE TABLE IF NOT EXISTS `saidas_produtos` (
  `saipro_saida` bigint(20) NOT NULL,
  `saipro_codigo` bigint(20) NOT NULL AUTO_INCREMENT,
  `saipro_lote` bigint(20) NOT NULL,
  `saipro_produto` bigint(20) NOT NULL,
  `saipro_quantidade` float NOT NULL,
  `saipro_valorunitario` float NOT NULL,
  `saipro_valortotal` float NOT NULL,
  `saipro_acertado` bigint(20) NOT NULL,
  PRIMARY KEY (`saipro_saida`,`saipro_codigo`),
  KEY `saipro_lote` (`saipro_lote`),
  KEY `saipro_produto` (`saipro_produto`),
  KEY `saipro_saida` (`saipro_saida`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `saidas_tipo`
--

CREATE TABLE IF NOT EXISTS `saidas_tipo` (
  `saitip_codigo` tinyint(4) NOT NULL AUTO_INCREMENT,
  `saitip_nome` varchar(70) NOT NULL,
  PRIMARY KEY (`saitip_codigo`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `saidas_tipo`
--

INSERT INTO `saidas_tipo` (`saitip_codigo`, `saitip_nome`) VALUES
(1, 'Venda'),
(3, 'DevoluÁ„o');

-- --------------------------------------------------------

--
-- Estrutura da tabela `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `sta_codigo` int(11) NOT NULL AUTO_INCREMENT,
  `sta_nome` varchar(70) NOT NULL,
  PRIMARY KEY (`sta_codigo`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `status`
--

INSERT INTO `status` (`sta_codigo`, `sta_nome`) VALUES
(1, 'V·lido'),
(2, 'Incompleto');

-- --------------------------------------------------------

--
-- Estrutura da tabela `taxas`
--

CREATE TABLE IF NOT EXISTS `taxas` (
  `tax_codigo` smallint(4) NOT NULL AUTO_INCREMENT,
  `tax_nome` varchar(70) NOT NULL,
  `tax_descricao` text,
  `tax_cooperativa` smallint(4) DEFAULT NULL,
  `tax_quiosque` bigint(18) DEFAULT NULL,
  PRIMARY KEY (`tax_codigo`),
  KEY `tax_cooperativa` (`tax_cooperativa`,`tax_quiosque`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

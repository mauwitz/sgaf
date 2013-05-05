# Versão 1.1 - Módulo entidades


/*  ENTIDADE CATEGORIA, USADO QUANDO CRIA-SE UMA PESSOA JURÍDICA*/
CREATE TABLE IF NOT EXISTS `pessoas_categoria` (
  `pescat_codigo` smallint(6) NOT NULL AUTO_INCREMENT,
  `pescat_nome` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`pescat_codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;
INSERT INTO `pessoas_categoria` (`pescat_codigo`, `pescat_nome`) VALUES
(1, 'Agro-indústria'),
(2, 'Empresa'),
(3, 'Distribuidora'),
(4, 'Orgão Público'),
(5, 'Outro');


/*  TIPO DE PESSOA, AGORA NO CADASTRO TEM 2 TIPOS, FÍSICA E JURÍDICA */
CREATE TABLE IF NOT EXISTS `pessoas_tipopessoa` (
  `pestippes_codigo` tinyint(4) NOT NULL,
  `pestippes_nome` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`pestippes_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
INSERT INTO `pessoas_tipopessoa` (`pestippes_codigo`, `pestippes_nome`) VALUES
(1, 'Pessoa Física'),
(2, 'Pessoa Jurídica');


/*  ATRIBUTOS NOVOS EM PESSOAS PARA CONTEMPLAR DADOS QUE FALTAM NO TIPO DE PESSOA 'PESSOA JURÍDICA'*/
ALTER TABLE  pessoas ADD  pes_cnpj VARCHAR( 14 ) NULL ,
ADD  pes_fone1ramal INT( 9 ) NULL ,
ADD  pes_fone2ramal VARCHAR( 9 ) NULL ,
ADD  pes_categoria MEDIUMINT NULL ,
ADD  pes_tipopessoa INT NULL ,
ADD  pes_pessoacontato VARCHAR( 70 ) NULL ,
ADD INDEX (  pes_categoria ,  pes_tipopessoa );

exportar grupo_permissoes



# Versão 1.2
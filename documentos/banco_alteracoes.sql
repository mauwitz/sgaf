
# Versão 1.1 - Módulo entidades


/*  ENTIDADE CATEGORIA, USADO QUANDO CRIA-SE UMA PESSOA JURÍDICA*/
CREATE TABLE IF NOT EXISTS pessoas_categoria (
  pescat_codigo smallint(6) NOT NULL AUTO_INCREMENT,
  pescat_nome varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (pescat_codigo)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;
INSERT INTO pessoas_categoria (pescat_codigo, pescat_nome) VALUES
(1, 'Agro-indústria'),
(2, 'Empresa'),
(3, 'Distribuidora'),
(4, 'Orgão Público'),
(5, 'Outro');


/*  TIPO DE PESSOA, AGORA NO CADASTRO TEM 2 TIPOS, FÍSICA E JURÍDICA */
CREATE TABLE IF NOT EXISTS pessoas_tipopessoa (
  pestippes_codigo tinyint(4) NOT NULL,
  pestippes_nome varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (pestippes_codigo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
INSERT INTO pessoas_tipopessoa (pestippes_codigo, pestippes_nome) VALUES
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


# -----------------------------------------------------------------------
# Versão 1.2 Modulo misto

# Atributo ent_tiponegociacao em ENTRADAS
ALTER TABLE  entradas ADD  ent_tiponegociacao TINYINT NOT NULL ,
ADD INDEX (  ent_tiponegociacao );

# Entidade tipo_negociacao
CREATE TABLE IF NOT EXISTS tipo_negociacao (
  tipneg_codigo tinyint(4) NOT NULL,
  tipneg_nome varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (tipneg_codigo)
);
INSERT INTO tipo_negociacao (tipneg_codigo, tipneg_nome) VALUES
(1, 'Consignação'),
(2, 'Revenda');


# Entidade mestre_produtos_tipo
CREATE TABLE IF NOT EXISTS mestre_produtos_tipo (
  mesprotip_produto bigint(20) NOT NULL,
  mesprotip_tipo tinyint(4) NOT NULL,
  PRIMARY KEY (mesprotip_produto,mesprotip_tipo),
  KEY mesprotip_produto (mesprotip_produto),
  KEY mesprotip_tipo (mesprotip_tipo)
);


# Entidade fornecedores_tiponegociacao
CREATE TABLE IF NOT EXISTS fornecedores_tiponegociacao (
  fortipneg_pessoa bigint(20) NOT NULL,
  fortipneg_tiponegociacao tinyint(4) NOT NULL,
  PRIMARY KEY (fortipneg_pessoa,fortipneg_tiponegociacao)
);


# Entidade quiosque_tiponegociacao
CREATE TABLE IF NOT EXISTS quiosques_tiponegociacao (
  quitipneg_quiosque int(11) NOT NULL,
  quitipneg_tipo tinyint(4) NOT NULL,
  PRIMARY KEY (quitipneg_quiosque,quitipneg_tipo),
  KEY quitipneg_tipo (quitipneg_tipo),
  KEY quitipneg_quiosque (quitipneg_quiosque)
);


# Entidade fechamentos
CREATE TABLE IF NOT EXISTS fechamentos (
  fch_codigo bigint(20) NOT NULL AUTO_INCREMENT,
  fch_datacadastro date NOT NULL,
  fch_horacadastro time NOT NULL,
  fch_dataini date NOT NULL,
  fch_horaini time NOT NULL,
  fch_datafim date NOT NULL,
  fch_horafim time NOT NULL,
  fch_supervisor bigint(20) NOT NULL,
  fch_totalvenda float NOT NULL,
  fch_totalcusto float NOT NULL,
  fch_totallucro float NOT NULL,
  fch_totaltaxas float NOT NULL,
  fch_totaltaxaquiosque float NOT NULL,
  fch_qtdvendas int(11) NOT NULL,
  fch_qtdprodutos int(11) NOT NULL,
  fch_qtdfornecedores int(11) NOT NULL,
  fch_qtdlotes int(11) NOT NULL,
  PRIMARY KEY (fch_codigo),
  KEY fch_supervisor (fch_supervisor)
) ;


# Entidade fechamentos taxas
CREATE TABLE IF NOT EXISTS fechamentos_taxas (
  fchtax_fechamento bigint(20) NOT NULL,
  fchtax_taxa int(11) NOT NULL,
  fchtax_referencia float NOT NULL,
  fchtax_valor float NOT NULL,
  PRIMARY KEY (fchtax_fechamento,fchtax_taxa),
  KEY fchtax_fechamento (fchtax_fechamento),
  KEY fchtax_taxa (fchtax_taxa)
);


# Alterações na entidade taxas
ALTER TABLE  taxas ADD  tax_tiponegociacao TINYINT NOT NULL ,
ADD INDEX (  tax_tiponegociacao );


# Alterações na entidade entradas_produtos
ALTER TABLE  entradas_produtos ADD  entpro_valunicusto FLOAT NULL;
ALTER TABLE  entradas_produtos ADD  entpro_valtotcusto FLOAT NULL;


# Alterações na entidade entradas
ALTER TABLE  entradas ADD  ent_valortotalcusto FLOAT NULL;


# Alterações na entidade saidas_produtos
ALTER TABLE  saidas_produtos ADD  saipro_fechado BIGINT NULL ,
ADD INDEX (  saipro_fechado );

# ------foi executado na base quente até aqui -----

# Alteração na entidade fechamentos
ALTER TABLE  fechamentos ADD  fch_quiosque INT NOT NULL ,
ADD INDEX (  fch_quiosque );

ALTER TABLE fechamentos
  DROP fch_horaini,
  DROP fch_horafim;

# alterado de date para datetime o atributo fch_dataini e fch_datafim
# ATENCAO


ALTER TABLE  saidas ADD  sai_datahoracadastro DATETIME NOT NULL;


ALTER TABLE  produtos ADD  pro_volume VARCHAR( 70 ) NULL ,
ADD  pro_recipiente VARCHAR( 70 ) NULL ,
ADD  pro_marca VARCHAR( 70 ) NULL ,
ADD  pro_composicao TEXT NULL



CREATE TABLE IF NOT EXISTS produtos_recipientes (
  prorec_codigo tinyint(4) NOT NULL AUTO_INCREMENT,
  prorec_nome varchar(70) NOT NULL,
  prorec_sigla varchar(10) DEFAULT NULL,
  PRIMARY KEY (prorec_codigo)
); 
INSERT INTO produtos_recipientes (prorec_codigo, prorec_nome, prorec_sigla) VALUES
(1, 'Pote', NULL),
(2, 'Caixa', NULL),
(3, 'Kit', NULL),
(4, 'Pacote', NULL),
(5, 'Saca', NULL),
(6, 'Peti', NULL),
(7, 'Fardo', NULL);


ALTER TABLE  produtos ADD  pro_codigounico BIGINT( 12 ) NULL
ALTER TABLE  produtos CHANGE  pro_codigounico  pro_codigounico BIGINT( 13 ) NULL DEFAULT NULL

ALTER TABLE  produtos CHANGE  pro_marca  pro_marca VARCHAR( 70 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL

Novo campo no banco 'qui_disponivelnobusca'

CREATE TABLE IF NOT EXISTS metodos_pagamento (
  metpag_codigo tinyint(4) NOT NULL AUTO_INCREMENT,
  metpag_nome varchar(45) NOT NULL,
  PRIMARY KEY (metpag_codigo)
);
INSERT INTO metodos_pagamento (metpag_codigo, metpag_nome) VALUES
(1, 'Dinheiro'),
(2, 'Cartão Crédito'),
(3, 'Cartão Débito'),
(4, 'Cheque'),
(5, 'Outro');

ALTER TABLE  saidas ADD  sai_areceber BOOLEAN NOT NULL ,
ADD  sai_metpag TINYINT NOT NULL ,
ADD INDEX (  sai_metpag );
-----------------------

DROP table grupo_permissoes;

CREATE TABLE IF NOT EXISTS grupo_permissoes (
  gruper_codigo tinyint(2) NOT NULL AUTO_INCREMENT,
  gruper_nome varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  gruper_cooperativa_ver tinyint(1) NOT NULL,
  gruper_cooperativa_cadastrar tinyint(1) NOT NULL,
  gruper_cooperativa_editar tinyint(1) NOT NULL,
  gruper_cooperativa_excluir tinyint(1) NOT NULL,
  gruper_quiosque_ver tinyint(1) NOT NULL,
  gruper_quiosque_cadastrar tinyint(1) NOT NULL,
  gruper_quiosque_editar tinyint(1) NOT NULL,
  gruper_quiosque_excluir tinyint(1) NOT NULL,
  gruper_quiosque_definirsupervisores tinyint(1) NOT NULL,
  gruper_quiosque_definirvendedores tinyint(1) NOT NULL,
  gruper_quiosque_versupervisores tinyint(1) NOT NULL,
  gruper_quiosque_vervendedores tinyint(1) NOT NULL,
  gruper_quiosque_vertaxas tinyint(1) NOT NULL,
  gruper_quiosque_definircooperativa tinyint(1) NOT NULL,
  gruper_pessoas_alterar_cooperativa tinyint(1) NOT NULL,
  gruper_pessoas_cadastrar tinyint(1) NOT NULL,
  gruper_pessoas_cadastrar_administradores tinyint(1) NOT NULL,
  gruper_pessoas_cadastrar_presidentes tinyint(1) NOT NULL,
  gruper_pessoas_cadastrar_supervisores tinyint(1) NOT NULL,
  gruper_pessoas_cadastrar_vendedores tinyint(1) NOT NULL,
  gruper_pessoas_cadastrar_fornecedores tinyint(1) NOT NULL,
  gruper_pessoas_cadastrar_consumidores tinyint(1) NOT NULL,
  gruper_pessoas_excluir tinyint(1) NOT NULL,
  gruper_pessoas_ver tinyint(1) NOT NULL,
  gruper_pessoas_ver_presidentes tinyint(1) NOT NULL,
  gruper_pessoas_ver_supervisores tinyint(1) NOT NULL,
  gruper_pessoas_ver_vendedores tinyint(1) NOT NULL,
  gruper_pessoas_ver_fornecedores tinyint(1) NOT NULL,
  gruper_pessoas_ver_consumidores tinyint(1) NOT NULL,
  gruper_pessoas_ver_administradores tinyint(1) NOT NULL,
  gruper_pessoas_criarusuarios tinyint(1) NOT NULL,
  gruper_pessoas_definir_grupo_administradores tinyint(1) NOT NULL,
  gruper_pessoas_definir_grupo_presidentes tinyint(1) NOT NULL,
  gruper_pessoas_definir_grupo_supervisores tinyint(1) NOT NULL,
  gruper_pessoas_definir_grupo_vendedores tinyint(1) NOT NULL,
  gruper_pessoas_definir_grupo_fornecedores tinyint(1) NOT NULL,
  gruper_pessoas_definir_grupo_consumidores tinyint(1) NOT NULL,
  gruper_pessoas_definir_quiosqueusuario tinyint(1) NOT NULL,
  gruper_produtos_ver tinyint(1) NOT NULL,
  gruper_produtos_cadastrar tinyint(1) NOT NULL,
  gruper_produtos_editar tinyint(1) NOT NULL,
  gruper_produtos_excluir tinyint(1) NOT NULL,
  gruper_paises_ver tinyint(1) NOT NULL,
  gruper_paises_cadastrar tinyint(1) NOT NULL,
  gruper_paises_editar tinyint(1) NOT NULL,
  gruper_paises_excluir tinyint(1) NOT NULL,
  gruper_estados_ver tinyint(1) NOT NULL,
  gruper_estados_cadastrar tinyint(1) NOT NULL,
  gruper_estados_editar tinyint(1) NOT NULL,
  gruper_estados_excluir tinyint(1) NOT NULL,
  gruper_cidades_ver tinyint(1) NOT NULL,
  gruper_cidades_cadastrar tinyint(1) NOT NULL,
  gruper_cidades_editar tinyint(1) NOT NULL,
  gruper_cidades_excluir tinyint(1) NOT NULL,
  gruper_categorias_ver tinyint(1) NOT NULL,
  gruper_categorias_cadastrar tinyint(1) NOT NULL,
  gruper_categorias_editar tinyint(1) NOT NULL,
  gruper_categorias_excluir tinyint(1) NOT NULL,
  gruper_tipocontagem_ver tinyint(1) NOT NULL,
  gruper_tipocontagem_cadastrar tinyint(1) NOT NULL,
  gruper_tipocontagem_editar tinyint(1) NOT NULL,
  gruper_tipocontagem_excluir tinyint(1) NOT NULL,
  gruper_estoque_ver tinyint(1) NOT NULL,
  gruper_estoque_qtdide_definir tinyint(1) NOT NULL,
  gruper_entradas_ver tinyint(1) NOT NULL,
  gruper_entradas_cadastrar tinyint(1) NOT NULL,
  gruper_entradas_editar tinyint(1) NOT NULL,
  gruper_entradas_excluir tinyint(1) NOT NULL,
  gruper_entradas_etiquetas tinyint(1) NOT NULL,
  gruper_entradas_cancelar tinyint(1) NOT NULL,
  gruper_saidas_ver tinyint(1) NOT NULL,
  gruper_saidas_cadastrar tinyint(1) NOT NULL,
  gruper_saidas_excluir tinyint(1) NOT NULL,
  gruper_saidas_editar tinyint(1) NOT NULL,
  gruper_saidas_cadastrar_devolucao tinyint(1) NOT NULL,
  gruper_saidas_editar_devolucao tinyint(1) NOT NULL,
  gruper_saidas_excluir_devolucao tinyint(1) NOT NULL,
  gruper_saidas_ver_devolucao tinyint(1) NOT NULL,
  gruper_relatorios_ver tinyint(1) NOT NULL,
  gruper_relatorios_cadastrar tinyint(1) NOT NULL,
  gruper_relatorios_editar tinyint(1) NOT NULL,
  gruper_relatorios_excluir tinyint(1) NOT NULL,
  gruper_acertos_cadastrar tinyint(1) NOT NULL,
  gruper_acertos_editar tinyint(1) NOT NULL,
  gruper_acertos_excluir tinyint(1) NOT NULL,
  gruper_acertos_ver tinyint(1) NOT NULL,
  gruper_taxas_cadastrar tinyint(1) NOT NULL,
  gruper_taxas_editar tinyint(1) NOT NULL,
  gruper_taxas_excluir tinyint(1) NOT NULL,
  gruper_taxas_ver tinyint(1) NOT NULL,
  gruper_taxas_aplicar tinyint(1) NOT NULL,
  gruper_quiosque_definircaixas tinyint(1) NOT NULL,
  gruper_quiosque_vercaixas tinyint(1) NOT NULL,
  gruper_pessoas_cadastrar_caixas tinyint(1) NOT NULL,
  gruper_pessoas_ver_caixas tinyint(1) NOT NULL,
  gruper_pessoas_definir_grupo_caixas tinyint(1) NOT NULL,
  PRIMARY KEY (gruper_codigo)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;



INSERT INTO grupo_permissoes (gruper_codigo, gruper_nome, gruper_cooperativa_ver, gruper_cooperativa_cadastrar, gruper_cooperativa_editar, gruper_cooperativa_excluir, gruper_quiosque_ver, gruper_quiosque_cadastrar, gruper_quiosque_editar, gruper_quiosque_excluir, gruper_quiosque_definirsupervisores, gruper_quiosque_definirvendedores, gruper_quiosque_versupervisores, gruper_quiosque_vervendedores, gruper_quiosque_vertaxas, gruper_quiosque_definircooperativa, gruper_pessoas_alterar_cooperativa, gruper_pessoas_cadastrar, gruper_pessoas_cadastrar_administradores, gruper_pessoas_cadastrar_presidentes, gruper_pessoas_cadastrar_supervisores, gruper_pessoas_cadastrar_vendedores, gruper_pessoas_cadastrar_fornecedores, gruper_pessoas_cadastrar_consumidores, gruper_pessoas_excluir, gruper_pessoas_ver, gruper_pessoas_ver_presidentes, gruper_pessoas_ver_supervisores, gruper_pessoas_ver_vendedores, gruper_pessoas_ver_fornecedores, gruper_pessoas_ver_consumidores, gruper_pessoas_ver_administradores, gruper_pessoas_criarusuarios, gruper_pessoas_definir_grupo_administradores, gruper_pessoas_definir_grupo_presidentes, gruper_pessoas_definir_grupo_supervisores, gruper_pessoas_definir_grupo_vendedores, gruper_pessoas_definir_grupo_fornecedores, gruper_pessoas_definir_grupo_consumidores, gruper_pessoas_definir_quiosqueusuario, gruper_produtos_ver, gruper_produtos_cadastrar, gruper_produtos_editar, gruper_produtos_excluir, gruper_paises_ver, gruper_paises_cadastrar, gruper_paises_editar, gruper_paises_excluir, gruper_estados_ver, gruper_estados_cadastrar, gruper_estados_editar, gruper_estados_excluir, gruper_cidades_ver, gruper_cidades_cadastrar, gruper_cidades_editar, gruper_cidades_excluir, gruper_categorias_ver, gruper_categorias_cadastrar, gruper_categorias_editar, gruper_categorias_excluir, gruper_tipocontagem_ver, gruper_tipocontagem_cadastrar, gruper_tipocontagem_editar, gruper_tipocontagem_excluir, gruper_estoque_ver, gruper_estoque_qtdide_definir, gruper_entradas_ver, gruper_entradas_cadastrar, gruper_entradas_editar, gruper_entradas_excluir, gruper_entradas_etiquetas, gruper_entradas_cancelar, gruper_saidas_ver, gruper_saidas_cadastrar, gruper_saidas_excluir, gruper_saidas_editar, gruper_saidas_cadastrar_devolucao, gruper_saidas_editar_devolucao, gruper_saidas_excluir_devolucao, gruper_saidas_ver_devolucao, gruper_relatorios_ver, gruper_relatorios_cadastrar, gruper_relatorios_editar, gruper_relatorios_excluir, gruper_acertos_cadastrar, gruper_acertos_editar, gruper_acertos_excluir, gruper_acertos_ver, gruper_taxas_cadastrar, gruper_taxas_editar, gruper_taxas_excluir, gruper_taxas_ver, gruper_taxas_aplicar, gruper_quiosque_definircaixas, gruper_quiosque_vercaixas, gruper_pessoas_cadastrar_caixas, gruper_pessoas_ver_caixas, gruper_pessoas_definir_grupo_caixas) VALUES
(1, 'Administrador', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(2, 'Presidente', 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 1, 0, 0, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 0, 0, 0, 1, 0, 1, 0, 0, 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1),
(3, 'Supervisor', 0, 0, 0, 0, 1, 0, 1, 0, 0, 1, 1, 1, 1, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 1, 0, 0, 1, 1, 1, 0, 1, 0, 0, 0, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(4, 'Caixa', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(5, 'Fornecedor', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(7, 'Root', 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

RENAME TABLE  cooesperanca.quiosques_vendedores TO  cooesperanca.quiosques_caixas ;

ALTER TABLE  quiosques_caixas CHANGE  quiven_quiosque  quicai_quiosque TINYINT( 4 ) NOT NULL ,
CHANGE  quiven_vendedor  quicai_vendedor BIGINT( 20 ) NOT NULL ,
CHANGE  quiven_datafuncao  quicai_datafuncao DATE NULL DEFAULT NULL;

ALTER TABLE  saidas CHANGE  sai_vendedor  sai_caixa BIGINT( 20 ) NOT NULL;

ALTER TABLE  quiosques_caixas CHANGE  quicai_vendedor  quicai_caixa BIGINT( 20 ) NOT NULL;

ALTER TABLE  acertos ADD  ace_dataini DATE NOT NULL ,
ADD  ace_datafim DATE NOT NULL;


ALTER TABLE  cooperativas ADD  coo_versaosistema VARCHAR( 8 ) NOT NULL;

# -----------------------------------------------------
# Versão 1.3



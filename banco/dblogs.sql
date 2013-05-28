/*
CONTROLE DE ALTERA��ES NO BANCO DE DADOS
*/

/*
Numero: 1
Desenvolvedor: Mauricio Witzgall
Data: 07/12/2012
Hora: 16:53
T�tulo: Banco importado
Descri��o: Criado o banco com dados de estrutura e importado para o netbeans
*/

/*
Numero: 2
Desenvolvedor: Mauricio Witzgall
Data: 09/12/2012
Hora: 18:51
T�tulo: Nova entidade tblcusos (ISSO � APENAS UM EXEMPLO)
Descri��o: Criado uma nova entidade 'tblcursos' no banco de dados com os seguintes atributos
*/

CREATE TABLE tblcursos 
(codcurso INTEGER CONSTRAINT  primarykey PRIMARY KEY,
nomecurso TEXT (15),
codprofessor INTEGER CONSTRAINT tblprofessorFK REFERENCES tblprofessor);

/*
Numero: 3
Desenvolvedor: Mauricio
Data: 19/03/2013
Hora: 21:21
T�tulo: Novos atributos em quiosque,pessoas
Descri��o: Necess�rio para fazer a vers�o SGAF online
*/
ALTER TABLE  quiosques ADD  qui_fone1ramal VARCHAR( 10 ) NULL AFTER  qui_fone1;
ALTER TABLE  quiosques ADD  qui_fone2ramal VARCHAR( 10 ) NULL AFTER  qui_fone2;
ALTER TABLE  pessoas ADD  pes_cpf VARCHAR( 11 ) NOT NULL

/*
Numero: 4
Desenvolvedor: Mauricio
Data: 
Hora: 
Título: 
Descrição: 
*/

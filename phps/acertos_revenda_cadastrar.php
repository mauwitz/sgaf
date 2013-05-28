<?php

//Verifica se o usu�rio tem permiss�o para acessar este conte�do
require "login_verifica.php";
if ($quiosque_revenda <> 1) {
    header("Location: permissoes_semacesso.php");
    exit;
}

$tipopagina = "negociacoes";
include "includes.php";
include "controller/classes.php";

$passo = $_REQUEST["passo"];
if (!$passo)
    $passo = 1;
$dataini = $_REQUEST["dataini"];
$horaini = $_REQUEST["horaini"];
$datafim = $_REQUEST["datafim"];
$horafim = $_REQUEST["horafim"];
$detprodutos = $_REQUEST["detprodutos"];
$detfornecedores = $_REQUEST["detfornecedores"];


//TÍTULO PRINCIPAL
$tpl_titulo = new Template("templates/titulos.html");
$tpl_titulo->TITULO = "FECHAMENTO DE REVENDAS";
$tpl_titulo->SUBTITULO = "CADASTRO DE FECHAMENTOS DE REVENDAS";
$tpl_titulo->ICONES_CAMINHO = "$icones";
$tpl_titulo->NOME_ARQUIVO_ICONE = "revenda.png";
$tpl_titulo->show();

$tpl = new Template("templates/cadastro1.html");
$tpl->FORM_NOME = "form1";
$tpl->FORM_TARGET = "";
$tpl->FORM_LINK = "acertos_revenda_cadastrar.php?passo=2";
$tpl->block("BLOCK_FORM");

$tpl->block("BLOCK_QUEBRA");


//Período
//Pegar data e hora inicial
//O sistema sempre pega a data e hora do ultimo fechamento, caso não tenha nenhum efetuado, pega-se a data e hora da primeira venda
$obj = new banco();
$dados = $obj->dados("
    SELECT min(sai_codigo) as primeirasaida
    FROM saidas
    WHERE sai_quiosque=$usuario_quiosque
");
$primeirasaida = $dados['primeirasaida'];
$dados2 = $obj->dados("
    SELECT sai_datacadastro,sai_horacadastro
    FROM saidas
    WHERE sai_codigo=$primeirasaida
");
$dataini = converte_data($dados2['sai_datacadastro']);
$horaini = converte_hora($dados2['sai_horacadastro']);
//Pegar data e hora final
//O sistema pega data atual como referencia para autopreencher os campos.
$datafim = date("Y-m-d");
$horafim = date("h:i");

//De
$tpl->COLUNA_ALINHAMENTO = "right";
$tpl->COLUNA_TAMANHO = "200px";
$tpl->TITULO = "De";
$tpl->block("BLOCK_TITULO");
$tpl->block("BLOCK_CONTEUDO");
$tpl->block("BLOCK_COLUNA");
//Data inicial
$tpl->COLUNA_ALINHAMENTO = "";
$tpl->COLUNA_TAMANHO = "";
$tpl->CAMPO_TIPO = "text";
$tpl->CAMPO_DICA = "";
$tpl->CAMPO_NOME = "dataini";
$tpl->CAMPO_ID = "dataini";
$tpl->CAMPO_AOCLICAR = "";
$tpl->CAMPO_ONKEYUP = "";
$tpl->CAMPO_ONBLUR = "";
$tpl->CAMPO_VALOR = "$dataini";
$tpl->CAMPO_TAMANHO = "8";
//$tpl->block("BLOCK_CAMPO_OBRIGATORIO");
$tpl->block("BLOCK_CAMPO_DESABILITADO");
$tpl->block("BLOCK_CAMPO_PADRAO");
$tpl->block("BLOCK_CAMPO");
$tpl->block("BLOCK_CONTEUDO");
$tpl->block("BLOCK_COLUNA");
//Hora inicial
$tpl->COLUNA_ALINHAMENTO = "";
$tpl->COLUNA_TAMANHO = "";
$tpl->CAMPO_TIPO = "";
$tpl->CAMPO_DICA = "";
$tpl->CAMPO_NOME = "horaini";
$tpl->CAMPO_ID = "horaini";
$tpl->CAMPO_AOCLICAR = "";
$tpl->CAMPO_ONKEYUP = "";
$tpl->CAMPO_ONBLUR = "";
$tpl->CAMPO_VALOR = "$horaini";
$tpl->CAMPO_TAMANHO = "6";
//$tpl->block("BLOCK_CAMPO_OBRIGATORIO");
$tpl->block("BLOCK_CAMPO_DESABILITADO");
$tpl->block("BLOCK_CAMPO_PADRAO");
$tpl->block("BLOCK_CAMPO");
$tpl->block("BLOCK_CONTEUDO");
$tpl->block("BLOCK_COLUNA");
//$tpl->block("BLOCK_LINHA");
//Até
$tpl->COLUNA_ALINHAMENTO = "right";
$tpl->COLUNA_TAMANHO = "30px";
$tpl->TITULO = "Até";
$tpl->block("BLOCK_TITULO");
$tpl->block("BLOCK_CONTEUDO");
$tpl->block("BLOCK_COLUNA");
//Data final
$tpl->COLUNA_ALINHAMENTO = "";
$tpl->COLUNA_TAMANHO = "";
if ($passo==2) {
    $tpl->CAMPO_TIPO = "text";
    $tpl->CAMPO_VALOR = converte_data($datafim);
} else {
    $tpl->CAMPO_TIPO = "date";
    $tpl->CAMPO_VALOR = "$datafim";
    $tpl->block("BLOCK_CAMPO_OBRIGATORIO");
}
$tpl->CAMPO_DICA = "";
$tpl->CAMPO_NOME = "datafim";
$tpl->CAMPO_ID = "datafim";
$tpl->CAMPO_AOCLICAR = "";
$tpl->CAMPO_ONKEYUP = "";
$tpl->CAMPO_ONBLUR = "";
$tpl->CAMPO_TAMANHO = "8";
if ($passo == 2)
    $tpl->block("BLOCK_CAMPO_DESABILITADO");
$tpl->block("BLOCK_CAMPO_PADRAO");
$tpl->block("BLOCK_CAMPO");
$tpl->block("BLOCK_CONTEUDO");
$tpl->block("BLOCK_COLUNA");
//Hora final
$tpl->COLUNA_ALINHAMENTO = "";
$tpl->COLUNA_TAMANHO = "";
if ($passo==2) {
    $tpl->CAMPO_TIPO = "text";
    $tpl->CAMPO_VALOR = converte_hora($horafim);
} else {
    $tpl->CAMPO_TIPO = "time";
    $tpl->CAMPO_VALOR = "$horafim";
    $tpl->block("BLOCK_CAMPO_OBRIGATORIO");
}

$tpl->CAMPO_DICA = "";
$tpl->CAMPO_NOME = "horafim";
$tpl->CAMPO_ID = "horafim";
$tpl->CAMPO_AOCLICAR = "";
$tpl->CAMPO_ONKEYUP = "";
$tpl->CAMPO_ONBLUR = "";
$tpl->CAMPO_TAMANHO = "8";
if ($passo == 2)
    $tpl->block("BLOCK_CAMPO_DESABILITADO");
$tpl->block("BLOCK_CAMPO_PADRAO");
$tpl->block("BLOCK_CAMPO");
$tpl->block("BLOCK_CONTEUDO");
$tpl->block("BLOCK_COLUNA");
$tpl->block("BLOCK_LINHA");

if ($passo == 1) {

//Detalhes produtos (Sim ou Não)
    $tpl->COLUNA_ALINHAMENTO = "right";
    $tpl->COLUNA_TAMANHO = "";
    $tpl->TITULO = "Detalhes Produtos";
    $tpl->block("BLOCK_TITULO");
    $tpl->block("BLOCK_CONTEUDO");
    $tpl->block("BLOCK_COLUNA");
    $tpl->COLUNA_ALINHAMENTO = "";
    $tpl->COLUNA_TAMANHO = "";
    $tpl->SELECT_NOME = "detprodutos";
    $tpl->SELECT_ID = "detprodutos";
    $tpl->SELECT_TAMANHO = "";
//$tpl->SELECT_AOCLICAR="";
//$tpl->block("BLOCK_SELECT_AUTOFOCO");
//$tpl->block("BLOCK_SELECT_DESABILITADO");
    $tpl->block("BLOCK_SELECT_OBRIGATORIO");
    $tpl->block("BLOCK_SELECT_PADRAO");
    $tpl->OPTION_VALOR = "0";
    $tpl->OPTION_TEXTO = "Não";
    $tpl->block("BLOCK_OPTION");
    $tpl->OPTION_VALOR = "1";
    $tpl->OPTION_TEXTO = "Sim";
    $tpl->block("BLOCK_OPTION_SELECIONADO");
    $tpl->block("BLOCK_OPTION");
    $tpl->block("BLOCK_SELECT");
    $tpl->block("BLOCK_CONTEUDO");
    $tpl->block("BLOCK_COLUNA");
    $tpl->block("BLOCK_LINHA");

//Detalhes Fornecedores (SIM ou NAO)
    $tpl->COLUNA_ALINHAMENTO = "right";
    $tpl->COLUNA_TAMANHO = "";
    $tpl->TITULO = "Detalhes Fornecedores";
    $tpl->block("BLOCK_TITULO");
    $tpl->block("BLOCK_CONTEUDO");
    $tpl->block("BLOCK_COLUNA");
    $tpl->COLUNA_ALINHAMENTO = "";
    $tpl->COLUNA_TAMANHO = "";
    $tpl->SELECT_NOME = "detfornecedores";
    $tpl->SELECT_ID = "detfornecedores";
    $tpl->SELECT_TAMANHO = "";
//$tpl->SELECT_AOCLICAR="";
//$tpl->block("BLOCK_SELECT_AUTOFOCO");
//$tpl->block("BLOCK_SELECT_DESABILITADO");
    $tpl->block("BLOCK_SELECT_OBRIGATORIO");
    $tpl->block("BLOCK_SELECT_PADRAO");
    $tpl->OPTION_VALOR = "0";
    $tpl->OPTION_TEXTO = "Não";
    $tpl->block("BLOCK_OPTION");
    $tpl->OPTION_VALOR = "1";
    $tpl->OPTION_TEXTO = "Sim";
    $tpl->block("BLOCK_OPTION_SELECIONADO");
    $tpl->block("BLOCK_OPTION");
    $tpl->block("BLOCK_SELECT");
    $tpl->block("BLOCK_CONTEUDO");
    $tpl->block("BLOCK_COLUNA");
    $tpl->block("BLOCK_LINHA");


//Botão Continuar
    $tpl->COLUNA_ALINHAMENTO = "right";
    $tpl->COLUNA_TAMANHO = "";
    $tpl->COLUNA_ROWSPAN = "";
    $tpl->block("BLOCK_COLUNA");
//$tpl->BOTAO_TECLA = "";
    $tpl->COLUNA_ALINHAMENTO = "left";
    $tpl->COLUNA_TAMANHO = "";
    $tpl->COLUNA_ROWSPAN = "";
    $tpl->BOTAO_TIPO = "submit";
    $tpl->BOTAO_VALOR = "CONTINUAR";
//$tpl->BOTAO_NOME = "";
//$tpl->BOTAO_ID = "";
//$tpl->BOTAO_DICA = "";
//$tpl->BOTAO_ONCLICK = "";
//$tpl->BOTAO_CLASSE = "";
    $tpl->block("BLOCK_BOTAO_PADRAO");
//$tpl->BOTAO_CLASSE = "";
//$tpl->block("BLOCK_BOTAO_DINAMICO");
//$tpl->block("BLOCK_BOTAO_DESABILITADO");
//$tpl->block("BLOCK_BOTAO_AUTOFOCO");
    $tpl->block("BLOCK_BOTAO");
//$tpl->block("BLOCK_BR");
    $tpl->block("BLOCK_CONTEUDO");
    $tpl->block("BLOCK_COLUNA");
    $tpl->block("BLOCK_LINHA");
}
$tpl->show();
echo "<br>";
if ($passo == 2) {
    //Resumo
    $tpl = new Template("templates/tituloemlinha_2.html");
    $tpl->block("BLOCK_TITULO");
    $tpl->LISTA_TITULO = "RESUMO";
    //$tpl->block("BLOCK_QUEBRA2");
    $tpl->show();
    $tpl2 = new Template("templates/lista2.html");
    $tpl2->block("BLOCK_TABELA_CHEIA");
    $tpl2->CABECALHO_COLUNA_COLSPAN = "";
    $tpl2->CABECALHO_COLUNA_TAMANHO = "";
    $tpl2->CABECALHO_COLUNA_NOME = "TOTAL VENDA";
    $tpl2->block("BLOCK_CABECALHO_COLUNA");
    $tpl2->CABECALHO_COLUNA_COLSPAN = "";
    $tpl2->CABECALHO_COLUNA_TAMANHO = "";
    $tpl2->CABECALHO_COLUNA_NOME = "TOTAL CUSTO";
    $tpl2->block("BLOCK_CABECALHO_COLUNA");
    $tpl2->CABECALHO_COLUNA_COLSPAN = "";
    $tpl2->CABECALHO_COLUNA_TAMANHO = "";
    $tpl2->CABECALHO_COLUNA_NOME = "TOTAL LUCRO";
    $tpl2->block("BLOCK_CABECALHO_COLUNA");
    $tpl2->CABECALHO_COLUNA_COLSPAN = "";
    $tpl2->CABECALHO_COLUNA_TAMANHO = "";
    $tpl2->CABECALHO_COLUNA_NOME = "QTD. VENDAS";
    $tpl2->block("BLOCK_CABECALHO_COLUNA");
    $tpl2->CABECALHO_COLUNA_COLSPAN = "";
    $tpl2->CABECALHO_COLUNA_TAMANHO = "";
    $tpl2->CABECALHO_COLUNA_NOME = "QTD. PRODUTOS";
    $tpl2->block("BLOCK_CABECALHO_COLUNA");
    $tpl2->CABECALHO_COLUNA_COLSPAN = "";
    $tpl2->CABECALHO_COLUNA_TAMANHO = "";
    $tpl2->CABECALHO_COLUNA_NOME = "QTD. LOTES";
    $tpl2->block("BLOCK_CABECALHO_COLUNA");
    $tpl2->block("BLOCK_CABECALHO_LINHA");
    $tpl2->block("BLOCK_CABECALHO");
    $tpl2->COLUNA_TAMANHO = "";
    $tpl2->COLUNA_ALINHAMENTO = "";
    $tpl2->TEXTO = "";
    $tpl2->block("BLOCK_TEXTO");
    $tpl2->block("BLOCK_CONTEUDO");
    $tpl2->block("BLOCK_COLUNA");
    $tpl2->COLUNA_TAMANHO = "";
    $tpl2->COLUNA_ALINHAMENTO = "";
    $tpl2->TEXTO = "";
    $tpl2->block("BLOCK_TEXTO");
    $tpl2->block("BLOCK_CONTEUDO");
    $tpl2->block("BLOCK_COLUNA");
    $tpl2->COLUNA_TAMANHO = "";
    $tpl2->COLUNA_ALINHAMENTO = "";
    $tpl2->TEXTO = "";
    $tpl2->block("BLOCK_TEXTO");
    $tpl2->block("BLOCK_CONTEUDO");
    $tpl2->block("BLOCK_COLUNA");
    $tpl2->COLUNA_TAMANHO = "";
    $tpl2->COLUNA_ALINHAMENTO = "";
    $tpl2->TEXTO = "";
    $tpl2->block("BLOCK_TEXTO");
    $tpl2->block("BLOCK_CONTEUDO");
    $tpl2->block("BLOCK_COLUNA");
    $tpl2->COLUNA_TAMANHO = "";
    $tpl2->COLUNA_ALINHAMENTO = "";
    $tpl2->TEXTO = "";
    $tpl2->block("BLOCK_TEXTO");
    $tpl2->block("BLOCK_CONTEUDO");
    $tpl2->block("BLOCK_COLUNA");
    $tpl2->COLUNA_TAMANHO = "";
    $tpl2->COLUNA_ALINHAMENTO = "";
    $tpl2->TEXTO = "";
    $tpl2->block("BLOCK_TEXTO");
    $tpl2->block("BLOCK_CONTEUDO");
    $tpl2->block("BLOCK_COLUNA");
    $tpl2->block("BLOCK_LINHA");
    $tpl2->block("BLOCK_CORPO");
    $tpl2->block("BLOCK_LISTAGEM");
    $tpl2->show();

    echo "<br>";


//Taxas
    $tpl = new Template("templates/tituloemlinha_2.html");
    $tpl->block("BLOCK_TITULO");
    $tpl->LISTA_TITULO = "TAXAS";
//$tpl->block("BLOCK_QUEBRA2");
    $tpl->show();
    $tpl = new Template("templates/cadastro1.html");
    $tpl->COLUNA_ALINHAMENTO = "right";
    $tpl->COLUNA_TAMANHO = "";
    $tpl->TITULO = "Lucro/Taxa Administrativa";
    $tpl->block("BLOCK_TITULO");
    $tpl->block("BLOCK_CONTEUDO");
    $tpl->block("BLOCK_COLUNA");
    $tpl->COLUNA_ALINHAMENTO = "";
    $tpl->COLUNA_TAMANHO = "";
    $tpl->CAMPO_TIPO = "text";
    $tpl->CAMPO_DICA = "";
    $tpl->CAMPO_NOME = "lucro";
    $tpl->CAMPO_ID = "lucro";
    $tpl->CAMPO_AOCLICAR = "";
    $tpl->CAMPO_ONKEYUP = "";
    $tpl->CAMPO_ONBLUR = "";
    $tpl->CAMPO_VALOR = "$lucro";
    $tpl->CAMPO_TAMANHO = "8";
//$tpl->block("BLOCK_CAMPO_OBRIGATORIO");
    $tpl->block("BLOCK_CAMPO_DESABILITADO");
    $tpl->block("BLOCK_CAMPO_PADRAO");
    $tpl->block("BLOCK_CAMPO");
    $tpl->block("BLOCK_CONTEUDO");
    $tpl->block("BLOCK_COLUNA");
    $tpl->block("BLOCK_LINHA");
    $tpl->show();
    $tpl2 = new Template("templates/lista2.html");
//$tpl2->block("BLOCK_TABELA_CHEIA");
    $tpl2->CABECALHO_COLUNA_COLSPAN = "";
    $tpl2->CABECALHO_COLUNA_TAMANHO = "";
    $tpl2->CABECALHO_COLUNA_NOME = "NOME DA TAXA";
    $tpl2->block("BLOCK_CABECALHO_COLUNA");
    $tpl2->CABECALHO_COLUNA_COLSPAN = "";
    $tpl2->CABECALHO_COLUNA_TAMANHO = "";
    $tpl2->CABECALHO_COLUNA_NOME = "%";
    $tpl2->block("BLOCK_CABECALHO_COLUNA");
    $tpl2->CABECALHO_COLUNA_COLSPAN = "";
    $tpl2->CABECALHO_COLUNA_TAMANHO = "";
    $tpl2->CABECALHO_COLUNA_NOME = "TOTAL";
    $tpl2->block("BLOCK_CABECALHO_COLUNA");
    $tpl2->block("BLOCK_CABECALHO_LINHA");
    $tpl2->block("BLOCK_CABECALHO");
    $tpl2->COLUNA_TAMANHO = "";
    $tpl2->COLUNA_ALINHAMENTO = "";
    $tpl2->TEXTO = "";
    $tpl2->block("BLOCK_TEXTO");
    $tpl2->block("BLOCK_CONTEUDO");
    $tpl2->block("BLOCK_COLUNA");
    $tpl2->COLUNA_TAMANHO = "";
    $tpl2->COLUNA_ALINHAMENTO = "";
    $tpl2->TEXTO = "";
    $tpl2->block("BLOCK_TEXTO");
    $tpl2->block("BLOCK_CONTEUDO");
    $tpl2->block("BLOCK_COLUNA");
    $tpl2->COLUNA_TAMANHO = "";
    $tpl2->COLUNA_ALINHAMENTO = "";
    $tpl2->TEXTO = "";
    $tpl2->block("BLOCK_TEXTO");
    $tpl2->block("BLOCK_CONTEUDO");
    $tpl2->block("BLOCK_COLUNA");
    $tpl2->block("BLOCK_LINHA");
    $tpl2->block("BLOCK_CORPO");
    $tpl2->block("BLOCK_LISTAGEM");
    $tpl2->show();




    //Detalhes Produtos
    if ($detprodutos == 1) {

        echo "<br>";
        $tpl = new Template("templates/tituloemlinha_2.html");
        $tpl->block("BLOCK_TITULO");
        $tpl->LISTA_TITULO = "DETALHES PRODUTOS";
//$tpl->block("BLOCK_QUEBRA2");
        $tpl->show();
        $tpl2 = new Template("templates/lista2.html");
//$tpl2->block("BLOCK_TABELA_CHEIA");
        $tpl2->CABECALHO_COLUNA_COLSPAN = "2";
        $tpl2->CABECALHO_COLUNA_TAMANHO = "";
        $tpl2->CABECALHO_COLUNA_NOME = "PRODUTO";
        $tpl2->block("BLOCK_CABECALHO_COLUNA");
        $tpl2->CABECALHO_COLUNA_COLSPAN = "2";
        $tpl2->CABECALHO_COLUNA_TAMANHO = "";
        $tpl2->CABECALHO_COLUNA_NOME = "QUANTIDADE";
        $tpl2->block("BLOCK_CABECALHO_COLUNA");
        $tpl2->CABECALHO_COLUNA_COLSPAN = "";
        $tpl2->CABECALHO_COLUNA_TAMANHO = "";
        $tpl2->CABECALHO_COLUNA_NOME = "TOTAL VENDA";
        $tpl2->block("BLOCK_CABECALHO_COLUNA");
        $tpl2->CABECALHO_COLUNA_COLSPAN = "";
        $tpl2->CABECALHO_COLUNA_TAMANHO = "";
        $tpl2->CABECALHO_COLUNA_NOME = "TOTAL CUSTO";
        $tpl2->block("BLOCK_CABECALHO_COLUNA");
        $tpl2->CABECALHO_COLUNA_COLSPAN = "2";
        $tpl2->CABECALHO_COLUNA_TAMANHO = "";
        $tpl2->CABECALHO_COLUNA_NOME = "TOTAL LUCRO";
        $tpl2->block("BLOCK_CABECALHO_COLUNA");
        $tpl2->block("BLOCK_CABECALHO_LINHA");
        $tpl2->block("BLOCK_CABECALHO");
        $tpl2->COLUNA_TAMANHO = "";
        $tpl2->COLUNA_ALINHAMENTO = "";
        $tpl2->TEXTO = "";
        $tpl2->block("BLOCK_TEXTO");
        $tpl2->block("BLOCK_CONTEUDO");
        $tpl2->block("BLOCK_COLUNA");
        $tpl2->COLUNA_TAMANHO = "";
        $tpl2->COLUNA_ALINHAMENTO = "";
        $tpl2->TEXTO = "";
        $tpl2->block("BLOCK_TEXTO");
        $tpl2->block("BLOCK_CONTEUDO");
        $tpl2->block("BLOCK_COLUNA");
        $tpl2->COLUNA_TAMANHO = "";
        $tpl2->COLUNA_ALINHAMENTO = "";
        $tpl2->TEXTO = "";
        $tpl2->block("BLOCK_TEXTO");
        $tpl2->block("BLOCK_CONTEUDO");
        $tpl2->block("BLOCK_COLUNA");
        $tpl2->COLUNA_TAMANHO = "";
        $tpl2->COLUNA_ALINHAMENTO = "";
        $tpl2->TEXTO = "";
        $tpl2->block("BLOCK_TEXTO");
        $tpl2->block("BLOCK_CONTEUDO");
        $tpl2->block("BLOCK_COLUNA");
        $tpl2->COLUNA_TAMANHO = "";
        $tpl2->COLUNA_ALINHAMENTO = "";
        $tpl2->TEXTO = "";
        $tpl2->block("BLOCK_TEXTO");
        $tpl2->block("BLOCK_CONTEUDO");
        $tpl2->block("BLOCK_COLUNA");
        $tpl2->COLUNA_TAMANHO = "";
        $tpl2->COLUNA_ALINHAMENTO = "";
        $tpl2->TEXTO = "";
        $tpl2->block("BLOCK_TEXTO");
        $tpl2->block("BLOCK_CONTEUDO");
        $tpl2->block("BLOCK_COLUNA");
        $tpl2->COLUNA_TAMANHO = "";
        $tpl2->COLUNA_ALINHAMENTO = "";
        $tpl2->TEXTO = "";
        $tpl2->block("BLOCK_TEXTO");
        $tpl2->block("BLOCK_CONTEUDO");
        $tpl2->block("BLOCK_COLUNA");
        $tpl2->COLUNA_TAMANHO = "";
        $tpl2->COLUNA_ALINHAMENTO = "";
        $tpl2->TEXTO = "";
        $tpl2->block("BLOCK_TEXTO");
        $tpl2->block("BLOCK_CONTEUDO");
        $tpl2->block("BLOCK_COLUNA");
        $tpl2->block("BLOCK_LINHA");
        $tpl2->block("BLOCK_CORPO");
        $tpl2->block("BLOCK_LISTAGEM");
        $tpl2->show();
    }



//Detalhes Fornecedor
    if ($detfornecedores == 1) {
        echo "<br>";
        $tpl = new Template("templates/tituloemlinha_2.html");
        $tpl->block("BLOCK_TITULO");
        $tpl->LISTA_TITULO = "DETALHES FORNECEDORES";
//$tpl->block("BLOCK_QUEBRA2");
        $tpl->show();
        $tpl2 = new Template("templates/lista2.html");
//$tpl2->block("BLOCK_TABELA_CHEIA");
        $tpl2->CABECALHO_COLUNA_COLSPAN = "2";
        $tpl2->CABECALHO_COLUNA_TAMANHO = "";
        $tpl2->CABECALHO_COLUNA_NOME = "FORNECEDOR";
        $tpl2->block("BLOCK_CABECALHO_COLUNA");
        $tpl2->CABECALHO_COLUNA_COLSPAN = "";
        $tpl2->CABECALHO_COLUNA_TAMANHO = "";
        $tpl2->CABECALHO_COLUNA_NOME = "TOTAL VENDA";
        $tpl2->block("BLOCK_CABECALHO_COLUNA");
        $tpl2->CABECALHO_COLUNA_COLSPAN = "";
        $tpl2->CABECALHO_COLUNA_TAMANHO = "";
        $tpl2->CABECALHO_COLUNA_NOME = "TOTAL CUSTO";
        $tpl2->block("BLOCK_CABECALHO_COLUNA");
        $tpl2->CABECALHO_COLUNA_COLSPAN = "2";
        $tpl2->CABECALHO_COLUNA_TAMANHO = "";
        $tpl2->CABECALHO_COLUNA_NOME = "TOTAL LUCRO";
        $tpl2->block("BLOCK_CABECALHO_COLUNA");
        $tpl2->block("BLOCK_CABECALHO_LINHA");
        $tpl2->block("BLOCK_CABECALHO");
        $tpl2->COLUNA_TAMANHO = "";
        $tpl2->COLUNA_ALINHAMENTO = "";
        $tpl2->TEXTO = "";
        $tpl2->block("BLOCK_TEXTO");
        $tpl2->block("BLOCK_CONTEUDO");
        $tpl2->block("BLOCK_COLUNA");
        $tpl2->COLUNA_TAMANHO = "";
        $tpl2->COLUNA_ALINHAMENTO = "";
        $tpl2->TEXTO = "";
        $tpl2->block("BLOCK_TEXTO");
        $tpl2->block("BLOCK_CONTEUDO");
        $tpl2->block("BLOCK_COLUNA");
        $tpl2->COLUNA_TAMANHO = "";
        $tpl2->COLUNA_ALINHAMENTO = "";
        $tpl2->TEXTO = "";
        $tpl2->block("BLOCK_TEXTO");
        $tpl2->block("BLOCK_CONTEUDO");
        $tpl2->block("BLOCK_COLUNA");
        $tpl2->COLUNA_TAMANHO = "";
        $tpl2->COLUNA_ALINHAMENTO = "";
        $tpl2->TEXTO = "";
        $tpl2->block("BLOCK_TEXTO");
        $tpl2->block("BLOCK_CONTEUDO");
        $tpl2->block("BLOCK_COLUNA");
        $tpl2->COLUNA_TAMANHO = "";
        $tpl2->COLUNA_ALINHAMENTO = "";
        $tpl2->TEXTO = "";
        $tpl2->block("BLOCK_TEXTO");
        $tpl2->block("BLOCK_CONTEUDO");
        $tpl2->block("BLOCK_COLUNA");
        $tpl2->COLUNA_TAMANHO = "";
        $tpl2->COLUNA_ALINHAMENTO = "";
        $tpl2->TEXTO = "";
        $tpl2->block("BLOCK_TEXTO");
        $tpl2->block("BLOCK_CONTEUDO");
        $tpl2->block("BLOCK_COLUNA");
        $tpl2->block("BLOCK_LINHA");
        $tpl2->block("BLOCK_CORPO");
        $tpl2->block("BLOCK_LISTAGEM");
        $tpl2->show();
    }
}


//Botão Voltar
$tpl = new Template("templates/botoes1.html");
$tpl->block("BLOCK_LINHAHORIZONTAL_EMCIMA");
$tpl->COLUNA_LINK_ARQUIVO = "acertos_revenda.php";
$tpl->block("BLOCK_COLUNA_LINK");
$tpl->block("BLOCK_BOTAOPADRAO_SIMPLES");
$tpl->block("BLOCK_BOTAOPADRAO_VOLTAR");
$tpl->block("BLOCK_BOTAOPADRAO");
$tpl->block("BLOCK_COLUNA");
$tpl->block("BLOCK_LINHA");
$tpl->block("BLOCK_BOTOES");
$tpl->show();

include "rodape.php";
?>

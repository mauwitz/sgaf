<?php

//Verifica se o usu�rio tem permiss�o para acessar este conte�do
require "login_verifica.php";
if ($permissao_quiosque_vertaxas <> 1) {
    header("Location: permissoes_semacesso.php");
    exit;
}

$tipopagina = "cooperativas";
include "includes.php";
include "controller/classes.php";

$quiosque = $_GET["quiosque"];


//TÍTULO PRINCIPAL
$tpl_titulo = new Template("templates/titulos.html");
$tpl_titulo->TITULO = "TAXAS";
$tpl_titulo->SUBTITULO = "LISTA DE TAXAS DO QUIOSQUE";
$tpl_titulo->ICONES_CAMINHO = "$icones";
$tpl_titulo->NOME_ARQUIVO_ICONE = "taxas.png";
$tpl_titulo->show();

$tpl = new Template("templates/cadastro1.html");
$tpl->FORM_NOME = "form1";
//$tpl->FORM_TARGET = "";
//$tpl->FORM_LINK = "";
//$tpl->block("BLOCK_FORM");
//Filtro Quiosque Desabilitado
$obj = new banco();
$dados = $obj->dados("select qui_nome from quiosques where qui_codigo=$quiosque");
$quiosque_nome = $dados["qui_nome"];
$tpl->COLUNA_ALINHAMENTO = "right";
$tpl->COLUNA_TAMANHO = "100px";
$tpl->TITULO = "Quiosque";
$tpl->block("BLOCK_TITULO");
$tpl->block("BLOCK_CONTEUDO");
$tpl->block("BLOCK_COLUNA");
$tpl->COLUNA_ALINHAMENTO = "";
$tpl->COLUNA_TAMANHO = "";
$tpl->CAMPO_TIPO = "text";
$tpl->CAMPO_DICA = "";
$tpl->CAMPO_NOME = "quiosque";
$tpl->CAMPO_ID = "quiosque";
$tpl->CAMPO_AOCLICAR = "";
$tpl->CAMPO_ONKEYUP = "";
$tpl->CAMPO_ONBLUR = "";
$tpl->CAMPO_VALOR = "$quiosque_nome";
$tpl->CAMPO_TAMANHO = "35";
//$tpl->block("BLOCK_CAMPO_OBRIGATORIO");
$tpl->block("BLOCK_CAMPO_DESABILITADO");
$tpl->block("BLOCK_CAMPO_PADRAO");
$tpl->block("BLOCK_CAMPO");
$tpl->block("BLOCK_CONTEUDO");
$tpl->TEXTO_NOME = "";
$tpl->TEXTO_ID = "";
$tpl->TEXTO_CLASSE = "dicacampo";
$tpl->TEXTO_VALOR = "";
$tpl->block("BLOCK_TEXTO");
$tpl->block("BLOCK_CONTEUDO");
$tpl->block("BLOCK_COLUNA");
$tpl->block("BLOCK_LINHA");
$tpl->show();
echo "<br>";


//Título Consignação
$tpl = new Template("templates/tituloemlinha_2.html");
$tpl->block("BLOCK_TITULO");
$tpl->LISTA_TITULO = "CONSIGNAÇÃO";
$tpl->block("BLOCK_QUEBRA2");
$tpl->show();


//Texto descritivo Dados
$tpl = new Template("templates/cadastro1.html");
$tpl->FORM_NOME = "form1";
$tpl->COLUNA_COLSPAN = "2";
$tpl->TEXTO_NOME = "";
$tpl->TEXTO_ID = "";
$tpl->TEXTO_CLASSE = "";
$tpl->TEXTO_VALOR = "Neste modelo, o fornecedor deixa o produto para vender no quiosque. Em um dia específico do mês o fornecedor vai ao quiosque para realizar um acerto, que nada mais é, do que contar todos os produtos que foram vendidos desde o ultimo acerto, onde um percentual desse valor é descontado. Aqui abaixo é possível incluir quantas taxas forem desejadas afim de no momento do acerto o sistema realizar tais descontos";
$tpl->block("BLOCK_TEXTO");
$tpl->block("BLOCK_CONTEUDO");
$tpl->block("BLOCK_COLUNA");
$tpl->block("BLOCK_LINHA");
$tpl->show();



//Lista Consinação
$tpl2 = new Template("templates/lista2.html");
$tpl2->block("BLOCK_TABELA_CHEIA");

$tpl2->CABECALHO_COLUNA_COLSPAN = "";
$tpl2->CABECALHO_COLUNA_TAMANHO = "";
$tpl2->CABECALHO_COLUNA_NOME = "TAXA";
$tpl2->block("BLOCK_CABECALHO_COLUNA");
$tpl2->CABECALHO_COLUNA_COLSPAN = "";
$tpl2->CABECALHO_COLUNA_TAMANHO = "";
$tpl2->CABECALHO_COLUNA_NOME = "TIPO";
$tpl2->block("BLOCK_CABECALHO_COLUNA");
$tpl2->CABECALHO_COLUNA_COLSPAN = "";
$tpl2->CABECALHO_COLUNA_TAMANHO = "";
$tpl2->CABECALHO_COLUNA_NOME = "% DESCONTADO";
$tpl2->block("BLOCK_CABECALHO_COLUNA");
$tpl2->CABECALHO_COLUNA_COLSPAN = "2";
$tpl2->CABECALHO_COLUNA_TAMANHO = "";
$tpl2->CABECALHO_COLUNA_NOME = "OPERAÇÕES";
$tpl2->block("BLOCK_CABECALHO_COLUNA");

$tpl2->block("BLOCK_CABECALHO_LINHA");
$tpl2->block("BLOCK_CABECALHO");

$obj = new banco();
$sql="
    SELECT *
    FROM quiosques_taxas
    JOIN taxas ON (tax_codigo=quitax_taxa)
    WHERE quitax_quiosque=$quiosque
    ORDER BY tax_quiosque
";
$dados = $obj->dados($sql);

while ($dados) {
    echo "1";
    
    /*$codigo_produto = $dados["pro_codigo"];
    $nome_produto = $dados["pro_nome"];
    $qtd = $dados["qtd"];
    $qtdide = $dados["qtdide"];
    $sigla = $dados["protip_sigla"];
    $saldo = $dados["saldo"];
    $tipocontagem = $dados["protip_codigo"];



    //Produto
    $tpl2->COLUNA_TAMANHO = "";
    $tpl2->COLUNA_ALINHAMENTO = "";
    $tpl2->TEXTO = "$codigo_produto";
    $tpl2->block("BLOCK_TEXTO");
    $tpl2->block("BLOCK_CONTEUDO");
    $tpl2->block("BLOCK_COLUNA");
    $tpl2->COLUNA_TAMANHO = "";
    $tpl2->COLUNA_ALINHAMENTO = "";
    $tpl2->TEXTO = "$nome_produto";
    $tpl2->block("BLOCK_TEXTO");
    $tpl2->block("BLOCK_CONTEUDO");
    $tpl2->block("BLOCK_COLUNA");

    //Saldo
    $tpl2->COLUNA_TAMANHO = "";
    $tpl2->COLUNA_ALINHAMENTO = "right";
    if (($qtd != 0) && ($qtdide != 0))
        $saldo = $qtd / $qtdide * 100;
    else
        $saldo = 0;
    $tpl2->TEXTO = number_format($saldo, 2, ',', '.') . "%";
    $tpl2->block("BLOCK_TEXTO");
    $tpl2->block("BLOCK_CONTEUDO");
    $tpl2->block("BLOCK_COLUNA");


    $tpl2->block("BLOCK_LINHA");*/
}
if (empty($dados))
    echo "3";


$tpl2->block("BLOCK_CORPO");
$tpl2->block("BLOCK_LISTAGEM");

$tpl2->show();


include "rodape.php";
?>

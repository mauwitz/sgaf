<?php

//Verifica se o usu�rio tem permiss�o para acessar este conte�do
require "login_verifica.php";
if ($permissao_quiosque_vertaxas <> 1) {
    header("Location: permissoes_semacesso.php");
    exit;
}

$tipopagina = "cooperativas";
include "includes.php";



//TÍTULO PRINCIPAL
$tpl_titulo = new Template("templates/titulos.html");
$tpl_titulo->TITULO = "TAXAS";
$tpl_titulo->SUBTITULO = "LISTA DE TAXAS DO QUIOSQUE";
$tpl_titulo->ICONES_CAMINHO = "$icones";
$tpl_titulo->NOME_ARQUIVO_ICONE = "taxas.png";
$tpl_titulo->show();

$tpl = new Template("templates/listagem_2.html");
$tpl->ICONE_ARQUIVO = $icones;
$quiosque = $_GET['quiosque'];


//Campo Quiosque no Topo
$tpl->CAMPO_TITULO = "Quiosque";
$sql = "SELECT qui_nome FROM quiosques WHERE qui_codigo=$quiosque";
$query = mysql_query($sql);
if (!$query)
    die("Erro1: " . mysql_error());
$dados = mysql_fetch_assoc($query);
$tpl->CAMPO_VALOR = $dados['qui_nome'];
$tpl->CAMPO_TAMANHO = "";
$tpl->block("BLOCK_FILTRO_CAMPO_DESABILITADO");
$tpl->block("BLOCK_FILTRO_CAMPO");
$tpl->block("BLOCK_FILTRO_COLUNA");

//Bot�o Incluir
IF (($permissao_taxas_aplicar == 1) && ($usuario_quiosque == $quiosque)) {
    $tpl->LINK = "quiosque_taxas_cadastrar.php?quiosque=$quiosque&operacao=cadastrar";
    $tpl->BOTAO_NOME = "INCLUIR TAXA";
    $tpl->block("BLOCK_RODAPE_BOTAO_MODELO");
}

$tpl->block("BLOCK_FILTRO_COLUNA");

$tpl->block("BLOCK_FILTRO");

//LISTAGEM INICIO
//Cabe�alho
$tpl->CABECALHO_COLUNA_TAMANHO = "";
$tpl->CABECALHO_COLUNA_COLSPAN = "2";
$tpl->CABECALHO_COLUNA_NOME = "TAXA";
$tpl->block("BLOCK_LISTA_CABECALHO");

$tpl->CABECALHO_COLUNA_TAMANHO = "";
$tpl->CABECALHO_COLUNA_COLSPAN = "";
$tpl->CABECALHO_COLUNA_NOME = "TIPO";
$tpl->block("BLOCK_LISTA_CABECALHO");

$tpl->CABECALHO_COLUNA_TAMANHO = "";
$tpl->CABECALHO_COLUNA_COLSPAN = "";
$tpl->CABECALHO_COLUNA_NOME = "DESCRIÇÃO";
$tpl->block("BLOCK_LISTA_CABECALHO");


$tpl->CABECALHO_COLUNA_TAMANHO = "";
$tpl->CABECALHO_COLUNA_COLSPAN = "";
$tpl->CABECALHO_COLUNA_NOME = "VALOR / REF.";
$tpl->block("BLOCK_LISTA_CABECALHO");

IF ($permissao_taxas_aplicar == 1) {
    $tpl->CABECALHO_COLUNA_COLSPAN = "2";
    $tpl->CABECALHO_COLUNA_TAMANHO = "";
    $tpl->CABECALHO_COLUNA_NOME = "OPERAÇÕES";
    $tpl->block("BLOCK_LISTA_CABECALHO");
}



//LISTAGEM
$sql = "
 SELECT DISTINCT
    tax_codigo,tax_nome,tax_descricao,quitax_valor,quitax_taxa,quitax_quiosque,tax_quiosque
FROM
    quiosques_taxas
    JOIN taxas on (quitax_taxa=tax_codigo)
WHERE    
    quitax_quiosque=$quiosque
ORDER BY
    tax_nome";

//Pagina��o
$query = mysql_query($sql);
if (!$query)
    die("Erro SQL Principal Paginação:" . mysql_error());
$linhas = mysql_num_rows($query);
$por_pagina = $usuario_paginacao;
$paginaatual = $_POST["paginaatual"];
$paginas = ceil($linhas / $por_pagina);
//Se � a primeira vez que acessa a pagina ent�o come�ar na pagina 1
if (($paginaatual == "") || ($paginas < $paginaatual) || ($paginaatual <= 0)) {
    $paginaatual = 1;
}
$comeco = ($paginaatual - 1) * $por_pagina;
$tpl->PAGINAS = "$paginas";
$tpl->PAGINAATUAL = "$paginaatual";
$tpl->PASTA_ICONES = "$icones";
$tpl->block("BLOCK_PAGINACAO");
$sql = $sql . " LIMIT $comeco,$por_pagina ";



$query = mysql_query($sql);
if (!$query)
    die("Erro: " . mysql_error());
while ($dados = mysql_fetch_assoc($query)) {

    //Coluna C�digo
    $tpl->LISTA_COLUNA_ALINHAMENTO = "right";
    $tpl->LISTA_COLUNA_TAMANHO = "40px";
    $tpl->LISTA_COLUNA_VALOR = $dados["tax_codigo"];
    $tpl->block("BLOCK_LISTA_COLUNA");

    //Coluna Nome
    $tpl->LISTA_COLUNA_ALINHAMENTO = "";
    $tpl->LISTA_COLUNA_TAMANHO = "200px";
    $tpl->LISTA_COLUNA_VALOR = $dados["tax_nome"];
    $tpl->block("BLOCK_LISTA_COLUNA");

    //Coluna Tipo
    $tpl->LISTA_COLUNA_ALINHAMENTO = "";
    $tpl->LISTA_COLUNA_TAMANHO = "";
    $qui = $dados["tax_quiosque"];
    if ($qui == "0")
        $tipo = "Global (Todos quiosques)";
    else
        $tipo = "Exclusiva (Apenas deste quiosque)";
    $tpl->LISTA_COLUNA_VALOR = $tipo;
    $tpl->block("BLOCK_LISTA_COLUNA");

    //Coluna Descri��o
    $tpl->LISTA_COLUNA_ALINHAMENTO = "";
    $tpl->LISTA_COLUNA_TAMANHO = "200px";
    $tpl->LISTA_COLUNA_VALOR = $dados["tax_descricao"];
    $tpl->block("BLOCK_LISTA_COLUNA");

    //Coluna Valor Referência
    $tpl->LISTA_COLUNA_ALINHAMENTO = "right";
    $tpl->LISTA_COLUNA_TAMANHO = "100px";
    $tpl->LISTA_COLUNA_VALOR = number_format($dados["quitax_valor"], 2, ',', '.') . " %";
    $tpl->block("BLOCK_LISTA_COLUNA");

    //Opera�ões
    $taxa = $dados["quitax_taxa"];
    $tpl->CODIGO = $taxa;
    IF ((($permissao_taxas_aplicar == 1) && ($usuario_quiosque == $quiosque)) && ((($usuario_grupo == 2) && ($qui == 0)) || (($usuario_grupo == 3) && ($qui != 0))||($usuario_grupo==1))) {
        //echo "$usuario_grupo ($qui)";
        //editar    
        $tpl->LINK = "quiosque_taxas_cadastrar.php";
        $tpl->LINK_COMPLEMENTO = "taxa=$taxa&quiosque=$quiosque&operacao=editar";
        $tpl->block("BLOCK_LISTA_COLUNA_OPERACAO_EDITAR");

        //excluir
        $tpl->LINK = "quiosque_taxas_deletar.php";
        $tpl->LINK_COMPLEMENTO = "taxa=$taxa&quiosque=$quiosque&operacao=excluir";
        $tpl->block("BLOCK_LISTA_COLUNA_OPERACAO_EXCLUIR");
    } else {
        //editar    
        $tpl->LINK = "";
        $tpl->LINK_COMPLEMENTO = "";
        $tpl->block("BLOCK_LISTA_COLUNA_OPERACAO_EDITAR_DESABILITADO");

        //excluir
        $tpl->LINK = "";
        $tpl->LINK_COMPLEMENTO = "";
        $tpl->block("BLOCK_LISTA_COLUNA_OPERACAO_EXCLUIR_DESABILITADO");
    }
    $tpl->block("BLOCK_LISTA");
}

//Se n�o tem tuplas ent�o mostrar a frase padr�o cujo informa que n�o h� registros
if (mysql_num_rows($query) == 0) {
    $tpl->block("BLOCK_LISTA_NADA");
}

//BOTÕES    
$tpl->LINK_VOLTAR = "quiosques.php";
$tpl->block("BLOCK_RODAPE_BOTAO_VOLTAR");
$tpl->block("BLOCK_RODAPE_BOTAO");

$tpl->block("BLOCK_RODAPE_BOTOES");

$tpl->show();
include "rodape.php";
?>

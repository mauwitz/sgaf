
<?php

//Verifica se o usu�rio tem permiss�o para acessar este conte�do
require "login_verifica.php";
if ($permissao_taxas_aplicar <> 1) {
    header("Location: permissoes_semacesso.php");
    exit;
}

$tipopagina = "cooperativas";
include "includes.php";

$taxa = $_POST['taxa'];
$quiosque = $_POST['quiosque'];
$operacao = $_POST['operacao'];
$taxavalor = dinheirosemcrifrao_para_numero($_POST['taxavalor']);


//TÍTULO PRINCIPAL
$tpl_titulo = new Template("templates/titulos.html");
$tpl_titulo->TITULO = "TAXAS";
$tpl_titulo->SUBTITULO = "CADASTRO/EDI��O DE TAXAS DO QUIOSQUE";
$tpl_titulo->ICONES_CAMINHO = "$icones";
$tpl_titulo->NOME_ARQUIVO_ICONE = "taxas.png";
$tpl_titulo->show();

//Estrutura da notifica��o
$tpl_notificacao = new Template("templates/notificacao.html");
$tpl_notificacao->ICONES = $icones;
$tpl_notificacao->DESTINO = "quiosque_taxas.php?quiosque=$quiosque";


//Se a opera��o for cadastro ent�o
if ($operacao=='cadastrar') {
    //Verifica se a taxa j� est� na lista de taxas do quiosque
    $sql = "SELECT * FROM quiosques_taxas WHERE quitax_taxa=$taxa and quitax_quiosque=$quiosque";
    $query = mysql_query($sql);
    if (!$query)
        die("Erro de SQL1:" . mysql_error());
    //$dados=  mysql_fetch_assoc($query);
    $linhas = mysql_num_rows($query);
    if ($linhas > 0) {
        $tpl_notificacao->MOTIVO_COMPLEMENTO = "Esta taxa j� est� na lista!";
        $tpl_notificacao->block("BLOCK_ERRO");
        $tpl_notificacao->block("BLOCK_NAOEDITADO");
        $tpl_notificacao->block("BLOCK_MOTIVO_FALTADADOS");
        $tpl_notificacao->block("BLOCK_BOTAO_VOLTAR");
        $tpl_notificacao->show();
        exit;
    } else {
        //Insere novo registro
        $sql = "
        INSERT INTO 
            quiosques_taxas (
                quitax_quiosque,
                quitax_taxa,
                quitax_valor
            )
        VALUES (
            '$quiosque',
            '$taxa',
            '$taxavalor'
        )";
        $query = mysql_query($sql);
        if (!$query)
            die("Erro de SQL:" . mysql_error());
        $tpl_notificacao->MOTIVO_COMPLEMENTO = "";
        $tpl_notificacao->block("BLOCK_CONFIRMAR");
        $tpl_notificacao->block("BLOCK_CADASTRADO");
        $tpl_notificacao->block("BLOCK_BOTAO");
        $tpl_notificacao->show();    
    }
} else { //Se for uma edi��o
    $sql = "
    UPDATE
        quiosques_taxas
    SET            
        quitax_valor='$taxavalor'
    WHERE
        quitax_quiosque=$quiosque and
        quitax_taxa=$taxa
    ";
    if (!mysql_query($sql))
        die("Erro: " . mysql_error());
    $tpl_notificacao->MOTIVO_COMPLEMENTO = "";
    $tpl_notificacao->block("BLOCK_CONFIRMAR");
    $tpl_notificacao->block("BLOCK_EDITADO");
    $tpl_notificacao->block("BLOCK_BOTAO");
    $tpl_notificacao->show();    
}


include "rodape.php";
?>


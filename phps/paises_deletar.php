<?php
//Verifica se o usu�rio tem permiss�o para acessar este conte�do
require "login_verifica.php";
if ($permissao_paises_excluir <> 1) {
    header("Location: permissoes_semacesso.php");
    exit;
}

$tipopagina = "locais";
include "includes.php";

//Template de Título e Sub-título
$tpl_titulo = new Template("templates/titulos.html");
$tpl_titulo->TITULO = "PAISES";
$tpl_titulo->SUBTITULO = "DELETAR/APAGAR";
$tpl_titulo->ICONES_CAMINHO = "$icones";
$tpl_titulo->NOME_ARQUIVO_ICONE = "locais.png";
$tpl_titulo->show();

//Inicio da exclus�o de entradas
$codigo = $_GET["codigo"];

$tpl_notificacao = new Template("templates/notificacao.html");
$tpl_notificacao->ICONES = $icones;
$tpl_notificacao->DESTINO = "paises.php";

//Verifica se o pais esta sendo usado em algum estado
$sql = "SELECT * FROM estados WHERE est_pais=$codigo";
$query = mysql_query($sql);
if (!$query) {
    die("Erro SQL: " . mysql_error());
}
$linhas = mysql_num_rows($query);
if ($linhas > 0) { // Exitem estados com esse pais
    $tpl_notificacao->MOTIVO_COMPLEMENTO = "estados";
    $tpl_notificacao->block("BLOCK_ERRO");
    $tpl_notificacao->block("BLOCK_NAOAPAGADO");
    $tpl_notificacao->block("BLOCK_MOTIVO_EMUSO");
    $tpl_notificacao->block("BLOCK_BOTAO_VOLTAR");
    $tpl_notificacao->show();
} else { //Pode excluir    
    $sql2 = "DELETE FROM paises WHERE pai_codigo='$codigo'";
    $query2 = mysql_query($sql2);
    if (!$query2) {
        die("Erro SQL: " . mysql_error());
    }
    $tpl_notificacao->MOTIVO_COMPLEMENTO = "";
    $tpl_notificacao->block("BLOCK_CONFIRMAR");
    $tpl_notificacao->block("BLOCK_APAGADO");
    $tpl_notificacao->block("BLOCK_BOTAO");
    $tpl_notificacao->show();
}
include "rodape.php";
?>

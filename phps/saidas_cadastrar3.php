<?php
require "login_verifica.php";
if ($permissao_saidas_cadastrar <> 1) {
    header("Location: permissoes_semacesso.php"); 
    exit;
}

$tipopagina = "saidas";
include "includes.php";

$tiposai=$_REQUEST["tiposai"];
$passo = $_REQUEST["passo"];
$saida = $_REQUEST["saida"];
$valbru = $_REQUEST["valbru2"];
$descper = $_REQUEST["descper2"];
$descval = $_REQUEST["descval2"];
$total = $_REQUEST["total2"];
$metodopag = $_REQUEST["metodopag2"];
$areceber = $_REQUEST["areceber2"];
$dinheiro = $_REQUEST["dinheiro2"];
if ($areceber==1)
    $troco = 0;
else
    $troco = $_REQUEST["troco2"];
$troco_devolvido = number_format(dinheiro_para_numero($_REQUEST["troco_devolvido"]),2,'.','');

//print_r($_REQUEST);



//Calcula o valor do desconto ou acr�scimo for�ado
if ($troco_devolvido=="")
    $troco_devolvido=0;
if ($troco=="")
    $troco=0;
if ($total=="")
    $total=0;

$forcado=$troco-$troco_devolvido;
if ($forcado>0) {
    $forcadodesc=0;
    $forcadoacre=$forcado;
} else {
    $forcadodesc=$forcado*-1;     
    $forcadoacre=0;
}
//Calcula o valor liquido total da Sa�da
$totalliq=$total+$forcado;


/*
echo "<br>valbru=$valbru<br>";
echo "descper=$descper<br>";
echo "descval=$descval<br>";
echo "total=$total<br>";
echo "dinheiro=$dinheiro<br>";
echo "troco=$troco<br>";

echo "trocodevolvido=$troco_devolvido<br>";
echo "forcado=$forcado<br>";
echo "totalliq=$totalliq<br>";
*/





//Template de Título e Sub-título
$tpl_titulo = new Template("templates/titulos.html");
$tpl_titulo->TITULO = "SAIDAS";
$tpl_titulo->SUBTITULO = "CADASTRO/EDIÇÃO";
$tpl_titulo->ICONES_CAMINHO = "$icones";
$tpl_titulo->NOME_ARQUIVO_ICONE = "saidas.png";
$tpl_titulo->show();

//
//echo "saida: $saida <br>";
//echo "passo: $passo <br><br>";  
//echo "Valor Bruto: $valbru <br>";  
//echo "Desconto Percentual: $descper <br>";
//echo "Desconto Valor: $descval <br>";  
//echo "Total com Desconto: $total <br>";
//echo "Valor Recebido: $dinheiro <br>";
//echo "Troco: $troco <br>";
//echo "Troco Devolvido: $troco_devolvido <br>";
//echo "Acrescimo For�ado: $forcadoacre <br>";
//echo "Desconto For�ado: $forcadodesc <br>";
//echo "Total Liquido: $totalliq <br>";
  
//Estrutura da notifica��o
$tpl_notificacao = new Template("templates/notificacao.html");
$tpl_notificacao->ICONES = $icones;
if ($tiposai=="3") 
    $tpl_notificacao->DESTINO = "saidas_devolucao.php";
else
   $tpl_notificacao->DESTINO = "saidas.php";

$sql = "
UPDATE
    saidas
SET
    sai_totalbruto='$valbru',
    sai_descontopercentual='$descper',
    sai_descontovalor='$descval',
    sai_totalcomdesconto='$total',
    sai_valorecebido='$dinheiro',
    sai_troco='$troco',
    sai_trocodevolvido='$troco_devolvido',
    sai_descontoforcado='$forcadodesc',
    sai_acrescimoforcado='$forcadoacre',
    sai_totalliquido='$totalliq',
    sai_status=1,
    sai_areceber=$areceber,
    sai_metpag='$metodopag'
WHERE
    sai_codigo=$saida
";
if (!mysql_query($sql))
    die("Erro: " . mysql_error());

$tpl_notificacao->block("BLOCK_CONFIRMAR");
$tpl_notificacao->block("BLOCK_CADASTRADO");
$tpl_notificacao->block("BLOCK_BOTAO");
$tpl_notificacao->show();
?>

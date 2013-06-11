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
$dinheiro = $_REQUEST["dinheiro2"];
$troco = $_REQUEST["troco2"];
$troco_devolvido = $_REQUEST["troco_devolvido"];
$metodopag = $_REQUEST["metodopag2"];
$areceber = $_REQUEST["areceber2"];

//print_r($_REQUEST);


//Elimina os cifões de dinheiro e troca as , por .
$valbru = dinheiro_para_numero($valbru);
$descper = dinheiro_para_numero($descper);
$descval = dinheiro_para_numero($descval);
$total = dinheiro_para_numero($total);
$dinheiro = dinheiro_para_numero($dinheiro);
$troco = dinheiro_para_numero($troco);
$troco_devolvido = dinheiro_para_numero($troco_devolvido);



//Calcula o valor do desconto ou acr�scimo for�ado
if ($troco_devolvido<0) {
    $troco_devolvido=0;
}
$forcado=$troco-$troco_devolvido;
if ($forcado>0) {
    $forcadodesc=0;
    $forcadoacre=$forcado;
} else {
    $forcadodesc=$forcado*-1;     
    $forcadoacre=0;
}
//Calcula o valor liquido total da Sa�da
$totalliq=$total+$forcadoacre-$forcadodesc;


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

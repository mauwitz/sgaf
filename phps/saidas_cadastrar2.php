<?php

require "login_verifica.php";
if ($permissao_saidas_cadastrar <> 1) {
    header("Location: permissoes_semacesso.php");
    exit;
}

$tipopagina = "saidas";
include "includes.php";


$saida = $_POST["saida"];
$passo = $_POST["passo"];
$descper = $_POST["descper"];
$descval = $_POST["descval"];
$total = $_POST["total2"];
$dinheiro = $_POST["dinheiro"];
$dinheiro2 = dinheiro_para_numero($dinheiro);
$total2 = dinheiro_para_numero($total);
$troco = $dinheiro - $total;
$troco = number_format($troco, 2, ',', '.');

if (($dinheiro2 <= $total2)&&($passo==2)) {
    echo "<script language='javaScript'>window.location.href='saidas_cadastrar3.php?troco_devolvido=0&passo=2&saida=$saida&total2=$total2&descper2=$descper&descval2=$descval&dinheiro2=$dinheiro2&troco2=$troco&troco_devolvido2=$troco_devolvido&valbru2=$total'</script>";
}

//Template de Título e Sub-título
$tpl_titulo = new Template("templates/titulos.html");
$tpl_titulo->TITULO = "SAÍDAS";
$tpl_titulo->SUBTITULO = "CADASTRO/EDIÇÃO";
$tpl_titulo->ICONES_CAMINHO = "$icones";
$tpl_titulo->NOME_ARQUIVO_ICONE = "saidas.png";
$tpl_titulo->show();

//Inicio do Template Principal
$tpl = new Template("saidas_cadastrar2.html");




//Pega e Preenche o valor bruto
$sql = "SELECT * FROM saidas JOIN saidas_produtos ON (saipro_saida=sai_codigo) WHERE sai_codigo=$saida";
$query = mysql_query($sql);
if (!$query) {
    die("Erro de SQL: " . mysql_error());
}
$valbru = 0;
while ($dados = mysql_fetch_assoc($query)) {
    $total_item = $dados["saipro_valortotal"];
    $valbru = $valbru + $total_item;
}
$tpl->VALBRU_VALOR = "R$ " . number_format($valbru, 2, ',', '.');


//Contra o passo, inicialmente come�a no 1
switch ($passo) {
    case '1':
        $tpl->LINK = "saidas_cadastrar2.php";
        $tpl->DESCPER_VALOR = "0,00";
        $tpl->DESCVAL_VALOR = "R$ 0,00";
        $tpl->TOTAL_VALOR = "R$ " . number_format($valbru, 2, ',', '.');
        //$tpl->DINHEIRO_VALOR = "R$ " . number_format($valbru, 2, ',', '.');
        $tpl->DINHEIRO_VALOR = "";
        $passo = 2;
        break;
    case '2':
        $tpl->LINK = "saidas_cadastrar3.php";
        $tpl->block("BLOCK_PASSO2");
        $tpl->block("BLOCK_OCULTOS2");
        $tpl->DESCPER_VALOR = $descper;
        $tpl->DESCPER_DESABILITADO = "disabled";
        $tpl->DESCVAL_VALOR = $descval;
        $tpl->DESCVAL_DESABILITADO = "disabled";
        $tpl->TOTAL_VALOR = "R$ ".number_format($total2,2,',','.');
        $tpl->DINHEIRO_VALOR = "R$ ".number_format($dinheiro2,2,',','.');
        $tpl->DINHEIRO_DESABILITADO = "disabled";
        $tpl->AREC_DESABILITADO = "disabled";
        $tpl->METPAG_DESABILITADO = "disabled";
        //echo "DescPer: $descper <br>DescVal=$descval <br>Dinheiro=$dinheiro <br>Total:$total<br>Troco:$troco";
        //Calcula o troco
        $tpl->TROCO_VALOR = "R$ $troco";
        $tpl->TROCO_DEVOLVIDO_VALOR = "R$ $troco";

        if ($dinheiro <= $total) {
            //$tpl->block("BLOCK_ENVIAR_FORMULARIO");
        }


        break;
}

$tpl->PASSO = $passo;
$tpl->SAIDA = $saida;

$tpl->show();


include "rodape.php";
//Verificar se existe no estoque todas as quantidades dos produtos solicitados
//Reitar 
?>

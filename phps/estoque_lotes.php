<?php

//Verifica se o usu�rio tem permiss�o para acessar este conte�do
require "login_verifica.php";
if ($permissao_estoque_ver <> 1) {
    header("Location: permissoes_semacesso.php");
    exit;
}


$tipopagina = "estoque";
include "includes.php";

$tpl = new Template("estoque_lotes.html");
$tpl->ICONES_CAMINHO = "$icones";
$produto = $_GET["produto"];
$fornecedor = $_GET["fornecedor"];
if (($usuario_grupo==5)&&($fornecedor!=$usuario_codigo)) {
    $fornecedor=$usuario_codigo;
}

$linkanterior = $_GET["link"];
$qtd = 0;
$dataatual = date("Y-m-d");
//$dataatual = strtotime($dataatual);
$qtdtot = 0;
$valtot = 0;

$sql = "
SELECT
    etq_valorunitario,etq_quantidade,protip_codigo,pro_nome,pes_nome,etq_lote,ent_datacadastro,etq_validade
FROM
    estoque
    join produtos on (pro_codigo=etq_produto)
    join pessoas on (etq_fornecedor=pes_codigo)
    join produtos_tipo on (pro_tipocontagem=protip_codigo)
    join entradas on (ent_codigo=etq_lote)
WHERE
    etq_produto='$produto' and
    etq_fornecedor='$fornecedor' and
    ent_quiosque=$usuario_quiosque
        
ORDER BY
    etq_lote

";

//Pagina��o
$query = mysql_query($sql);
if (!$query)
    die("Erro SQL Principal Pagina��o:" . mysql_error());
$linhas = mysql_num_rows($query);
$valor_total_geral=0;
while ($dados= mysql_fetch_assoc($query)) {
    $tipocontagem=$dados['protip_codigo'];
    $valor_total_geral=$valor_total_geral+($dados["etq_valorunitario"]*$dados["etq_quantidade"]);
    $valor_total_qtd=$valor_total_qtd+$dados["etq_quantidade"];
}
$tpl->VALOR_TOTAL = "R$ ".number_format($valor_total_geral,2,',','.');            
if ($tipocontagem==2)
    $tpl->QTD_TOTAL = number_format($valor_total_qtd,3,',','.');            
else
    $tpl->QTD_TOTAL = number_format($valor_total_qtd,0,'','.');            
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
if ($paginaatual==$paginas) {
    $tpl->block("BLOCK_LISTA_RODAPE");
}


$query = mysql_query($sql);
if (!$query)
    die("Erro: " . mysql_error());
while ($dados = mysql_fetch_array($query)) {
    $tpl->PRODUTO_NOME = $dados['pro_nome'];
    $tpl->FORNECEDOR_NOME = $dados['pes_nome'];
    $tpl->LOTE = $dados['etq_lote'];
    $tpl->DATA = $dados['ent_datacadastro'];
    $tipocontagem=$dados['protip_codigo'];
    if ($tipocontagem==2)
        $tpl->QUANTIDADE = number_format($dados['etq_quantidade'], 3, ',', '.');
    else
        $tpl->QUANTIDADE = number_format($dados['etq_quantidade'], 0, '', '.');
    $tpl->SIGLA = $dados['protip_sigla'];
    $tpl->VALOR_UNIT = "R$ " . number_format($dados['etq_valorunitario'], 2, ',', '.');
    $tpl->VALOR_TOT = "R$ " . number_format($dados['etq_valorunitario'] * $dados['etq_quantidade'], 2, ',', '.');
    if ($dados['etq_validade'] == "0000-00-00")
        $tpl->VALIDADE = "";
    else
        $tpl->VALIDADE = converte_data($dados['etq_validade']);

    //Pega os totais que v�o para o rodap�
    $qtdtot = $qtdtot + $dados['etq_quantidade'];
    $valtot = $valtot + ($dados['etq_quantidade'] * $dados['etq_valorunitario']);
    $tpl->QTD_TOTAL = number_format($qtdtot, 2, ',', '.');
    $tpl->VALOR_TOTAL = "R$ " . number_format($valtot, 2, ',', '.');

    //Testa a validade do produto
    $validade = $dados['etq_validade'];
    //$validade = strtotime($validade);
    if ($validade == "0000-00-00")  {
        $tpl->VENCEU = "indefinido";
        $tpl->VALIDADE_SALDO="indefinido";
    } else {
        
        $saldo = diferenca_data($dataatual, $validade, 'D') . " dias";
        if ($saldo == 0) {
            $tpl->VALIDADE_SALDO = "hoje";
        } else if ($saldo == 1) {
            $tpl->VALIDADE_SALDO = "amanh�";
        } else if ($saldo < 0 ) {
            $tpl->VENCEU = "tabelalinhavermelha";
            $tpl->VALIDADE_SALDO = $saldo;
        } else {
           $tpl->VALIDADE_SALDO = $saldo;    
        }
    }

    //Pega a data de cadastro do lote que � a data de cadastro da entrada
    $lote = $dados["etq_lote"];
    $sql_data = "SELECT ent_datacadastro,ent_horacadastro FROM entradas WHERE ent_codigo=$lote";
    $query_data = mysql_query($sql_data);
    if (!$query_data)
        die("Erro: " . mysql_error());
    while ($dados_data = mysql_fetch_array($query_data)) {
        $tpl->DATA = converte_data($dados_data['ent_datacadastro']);
        $tpl->HORA = converte_hora($dados_data['ent_horacadastro']);
    }

    $tpl->block("BLOCK_LISTA");
}
$tpl->VOLTAR_DESTINO = $linkanterior;
$tpl->PRODUTO_CODIGO = $produto;
$tpl->FORNECEDOR_CODIGO = $fornecedor;
$tpl->show();
?>

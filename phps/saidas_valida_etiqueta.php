<?php

include "controle/conexao.php";
$etiqueta = $_POST[etiqueta];

//Divide o c�digo da etiqueta em 2 peda�os
$produto = substr($etiqueta, 0, 6); //Os 6 primeiros digitos s�o referente ao produto
$lote = substr($etiqueta, 6, 14); //Os 8 demais digitos s�o referente ao lote

//Verifica se o produto e o lote existem no banco
//Produto
$sql = "SELECT pro_codigo,pro_nome FROM produtos WHERE pro_codigo=$produto";
$query = mysql_query($sql);
if (!$query)
    die("Erro: " . mysql_error());
$linhas = mysql_num_rows($query);
//Lote
$sql2 = "SELECT ent_codigo FROM entradas WHERE ent_codigo=$lote";
$query2 = mysql_query($sql2);
if (!$query2)
    die("Erro: " . mysql_error());
$linhas2 = mysql_num_rows($query2);

//Efetua a verifica��o se os dados da estique est�o corretos
if (($linhas == 0) OR ($linhas2 == 0)) {
    echo "invalida";
} else {    
    //Verifica se o produto pertence ao lote especificado
    $sql3 = "SELECT etq_produto,etq_lote FROM estoque WHERE etq_lote=$lote and etq_produto=$produto";
    $query3 = mysql_query($sql3);
    if (!$query3)
        die("Erro: " . mysql_error());
    $linhas3 = mysql_num_rows($query3);
    if ($linhas3 == 0) {
        //echo "Este produto n�o consta no estoque do sistema. Por favor, anote o n�mero desta etiqueta para analisar depois. Etiqueta: $etiqueta";
        echo "semestoque";
    } else {        
        echo "$produto $lote";
    }
}
?>

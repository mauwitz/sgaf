<?php

include "controle/conexao.php";
$produto = $_POST[produto];
$lote = $_POST[lote];
$qtd = $_POST[qtd];

$qtd = str_replace('.', '',$qtd);
$qtd = str_replace(',', '.',$qtd);

$sql = "
SELECT DISTINCT
   entpro_valorunitario
FROM 
   entradas_produtos, entradas   
WHERE
   ent_codigo= entpro_entrada and
   ent_codigo='$lote' and
   entpro_produto='$produto'    
";
$query = mysql_query($sql);
if ($query) {
    while ($dados = mysql_fetch_array($query)) {
        $valuni = $dados['entpro_valorunitario'];        
        $valtot=$valuni*$qtd;
        $valtot = number_format($valtot,2,',','.') . "\n";
        echo "$valtot";
    }
} else {
    echo mysql_error();
}
?>

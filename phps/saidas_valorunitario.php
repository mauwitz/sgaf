<?php

include "controle/conexao.php";
$produto = $_POST[produto];
$lote = $_POST[lote];

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
        $valuni = number_format($valuni,2,',','.');
        echo "R$ $valuni";
    }
} else {
    echo mysql_error();
}
?>

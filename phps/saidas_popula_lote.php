<?php
include "controle/conexao.php";
include "conexao_tipo.php";
include "funcoes.php";

$produto = $_POST["produto"];
$fornecedor = $_POST["fornecedor"];

$sql = "
SELECT  DISTINCT
    etq_lote,entpro_local
FROM
    estoque
    JOIN pessoas ON (etq_fornecedor=pes_codigo)
    JOIN entradas ON (etq_lote=ent_codigo)
    JOIN entradas_produtos ON (entpro_entrada=ent_codigo)    
WHERE
    etq_produto=$produto and
    entpro_produto=$produto and
    ent_fornecedor=$fornecedor 
ORDER BY
    etq_lote";
$query = mysql_query($sql);
if (!$query)
    die("Erro: " . mysql_error());
if (mysql_num_rows($query) == 0) {
    echo "<option value=''>N�o h� registros</option>";
} else {
    echo "<option value='0'>Selecione</option>";
    while ($dados = mysql_fetch_assoc($query)) {
        $lote = $dados["etq_lote"];             
        $local= $dados["entpro_local"];
        if ($local!="") {
            $local="(".$local.")";
        }
        //echo "<option value='$lote'>$lote, $fornecedor_nome, $local ($data $hora)</option>";
        echo "<option value='$lote'>$lote $local</option>";
    }
}
?>

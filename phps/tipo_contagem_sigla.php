<?php

include "controle/conexao.php";

$tipo = $_POST["tipocontagem"];
$sql = "SELECT protip_sigla FROM produtos_tipo WHERE protip_codigo=$tipo";
$query = mysql_query($sql);
$dados = mysql_fetch_assoc($query);
$sigla=$dados["protip_sigla"];


echo "$sigla";
?>

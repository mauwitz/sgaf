<?php

include "controle/conexao.php";
$valbru=$_POST["valbru"];
$descper=$_POST["descper"];

$valbru=explode(" ", $valbru);
$valbru=$valbru[1];
$valbru=str_replace('.','', $valbru);
$valbru=str_replace(',','.', $valbru);

$descper=number_format($descper,2,'.',',');

$total=$valbru*(1-$descper/100);
$total=number_format($total,2,',','.');
echo $total;

?>

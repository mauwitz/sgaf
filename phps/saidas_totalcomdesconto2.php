<?php

include "controle/conexao.php";
$valbru=$_POST["valbru"];
$descval=$_POST["descval"];


$valbru=explode(" ", $valbru);
$valbru=$valbru[1];
$valbru=str_replace('.','', $valbru);
$valbru=str_replace(',','.', $valbru);

$descval=explode(" ", $descval);
$descval=$descval[1];
$descval=str_replace('.','', $descval);
$descval=str_replace(',','.', $descval);

$total=$valbru-$descval;
$total=  number_format($total,2,',','.');
//echo "$valbru e $descval";
echo $total;



?>

<?php

include "controle/conexao.php";
//require("templates/Template.class.php");
$tpl8 = new Template("relatorio_cabecalho_1.html");
$tpl8->COOPERATIVA = "$usuario_cooperativanomecompleto ($usuario_cooperativaabreviacao)";
$tpl8->QUIOSQUE = $usuario_quiosquenome;
$tpl8->show();
?>

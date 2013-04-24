<?php
include "funcoes.php";
include "controle/conexao.php";
include "controle/conexao_tipo.php";
$cpf=$_POST["cpf"];
$cpf = str_replace('_', '', $cpf);
$cpf = str_replace('.', '', $cpf);
$cpf = str_replace('-', '', $cpf);
$sql="SELECT * FROM pessoas WHERE pes_cpf like '$cpf'";
if(!$query=mysql_query($sql))
    die("ERRO SQL". mysql_error());
$linhas= mysql_num_rows($query);
echo $linhas;
?>

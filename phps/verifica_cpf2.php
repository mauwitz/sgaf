<?php
include "funcoes.php";
include "controle/conexao.php";
include "controle/conexao_tipo.php";
$cpf=$_POST["cpf"];
$cpf = str_replace('_', '', $cpf);
$cpf = str_replace('.', '', $cpf);
$cpf = str_replace('-', '', $cpf);
$sql="SELECT pes_usarperguntasecreta,pes_email_senha FROM pessoas WHERE pes_cpf like '$cpf'";
if(!$query=mysql_query($sql))
    die("ERRO SQL". mysql_error());
echo "<option value=''>Selecione</option>";
while ($dados=mysql_fetch_assoc($query)) {
    $usarpergunta=$dados["pes_usarperguntasecreta"] ;
    $pergunta=
    $email=$dados["pes_email_senha"];
    if ($usarpergunta==1) {
        echo "<option value='1'>Pergunta e Resposta Secreta</option>";
    } 
    if ($email!="") {
        echo "<option value='2'>E-mail</option>";
    }
    if (($usarpergunta==0)&&($email=="")) {
        echo "nenhum método";
    }
}
?>

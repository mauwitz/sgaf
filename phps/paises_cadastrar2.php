<?php
//Verifica se o usu�rio tem permiss�o para acessar este conte�do
require "login_verifica.php";
if ($permissao_paises_cadastrar <> 1) {
    header("Location: permissoes_semacesso.php");
    exit;
}


$tipopagina = "locais";
include "includes.php";

//Template de Título e Sub-título
$tpl_titulo = new Template("templates/titulos.html");
$tpl_titulo->TITULO = "PAISES";
$tpl_titulo->SUBTITULO = "CADASTRO/EDI��O";
$tpl_titulo->ICONES_CAMINHO = "$icones";
$tpl_titulo->NOME_ARQUIVO_ICONE = "locais.png";
$tpl_titulo->show();

$codigo = $_POST["codigo"];
$nome = ucwords(strtolower($_POST["pais"]));
$nome2 = ucwords(strtolower($_POST["nomeregistrado"]));
$sigla = strtoupper($_POST['sigla']);

//Estrutura da notifica��o
$tpl_notificacao = new Template("templates/notificacao.html");
$tpl_notificacao->ICONES = $icones;
$tpl_notificacao->DESTINO = "paises.php";


//Conforme a opera��o deve-se inserir novo registro ou atualizar os existentes
if ($codigo == "") { //Caso a opera��o seja CADASTRO    
    //Verifica se j� existe registros com o mesmo nome
    $sql = "SELECT * FROM paises WHERE pai_nome='$nome'";
    $query = mysql_query($sql);
    if (!$query)
        die("Erro: " . mysql_error());
    $linhas = mysql_num_rows($query);
    if ($linhas > 0) { //J� tem registro com mesmo nome
        $tpl_notificacao->MOTIVO_COMPLEMENTO = "nome do pais";
        $tpl_notificacao->block("BLOCK_ERRO");
        $tpl_notificacao->block("BLOCK_NAOCADASTRADO");
        $tpl_notificacao->block("BLOCK_MOTIVO_JAEXISTE");
        $tpl_notificacao->block("BLOCK_BOTAO_VOLTAR");
        $tpl_notificacao->show();
    } else { //Inserir registro
        $sql = "
        INSERT INTO
           paises (pai_nome,pai_sigla)
        VALUES 
            ('$nome','$sigla');
        ";
        if (!mysql_query($sql))
            die("Erro: " . mysql_error());
        $tpl_notificacao->MOTIVO_COMPLEMENTO = "";
        $tpl_notificacao->block("BLOCK_CONFIRMAR");
        $tpl_notificacao->block("BLOCK_CADASTRADO");        
        $tpl_notificacao->block("BLOCK_BOTAO");
        $tpl_notificacao->show();
    }
} else { //Caso a opera��o seja EDI��O
    //Verifica se j� existe registros com o mesmo nome    
    $sql = "SELECT * FROM paises WHERE pai_nome='$nome'";
    $query = mysql_query($sql);
    if (!$query)
        die("Erro: " . mysql_error());
    $linhas = mysql_num_rows($query);
    if ($nome == $nome2)
        $linhatot = 1;
    else
        $linhatot = 0;
    if ($linhas > $linhatot) {
        $tpl_notificacao->MOTIVO_COMPLEMENTO = "nome do pais";        
        $tpl_notificacao->block("BLOCK_ERRO");
        $tpl_notificacao->block("BLOCK_NAOEDITADO");
        $tpl_notificacao->block("BLOCK_MOTIVO_JAEXISTE");
        $tpl_notificacao->block("BLOCK_BOTAO_VOLTAR");
        $tpl_notificacao->show();
    } else {
        $sql = "
    UPDATE
        paises
    SET
        pai_nome='$nome',	
        pai_sigla='$sigla'
    WHERE
        pai_codigo = '$codigo'
    ";
        if (!mysql_query($sql))
            die("Erro: " . mysql_error());
        $tpl_notificacao->MOTIVO_COMPLEMENTO = "";        
        $tpl_notificacao->block("BLOCK_CONFIRMAR");
        $tpl_notificacao->block("BLOCK_EDITADO");
        $tpl_notificacao->block("BLOCK_BOTAO");
        $tpl_notificacao->show();
    }
}

include "rodape.php";
?>

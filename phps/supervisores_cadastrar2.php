
<?php

//Verifica se o usu�rio tem permiss�o para acessar este conte�do
require "login_verifica.php";
if ($permissao_quiosque_definirsupervisores <> 1) {
    header("Location: permissoes_semacesso.php");
    exit;
}

$tipopagina = "cooperativas";
include "includes.php";

$quiosque = $_POST['quiosque'];
$supervisor = $_POST['supervisor'];
$operacao = $_POST['operacao'];
$datafuncao = desconverte_data($_POST['datafuncao']);

//Template de Título e Sub-título
$tpl_titulo = new Template("templates/titulos.html");
$tpl_titulo->TITULO = "supervisorES";
$tpl_titulo->SUBTITULO = "CADASTRO DE SUPERVISORES DO QUIOSQUE";
$tpl_titulo->ICONES_CAMINHO = "$icones";
$tpl_titulo->NOME_ARQUIVO_ICONE = "../pessoas2/supervisor.png";
$tpl_titulo->show();

//Estrutura da notifica��o
$tpl_notificacao = new Template("templates/notificacao.html");
$tpl_notificacao->ICONES = $icones;
$tpl_notificacao->DESTINO = "supervisores.php?quiosque=$quiosque";


//Se a opera��o for cadastro ent�o
if ($operacao=='cadastrar') {
    //Verifica se o supervisor j� est� na lista de supervisores do quiosque
    $sql = "SELECT * FROM quiosques_supervisores WHERE quisup_supervisor=$supervisor and quisup_quiosque=$quiosque";
    $query = mysql_query($sql);
    if (!$query)
        die("Erro de SQL:" . mysql_error());
    //$dados=  mysql_fetch_assoc($query);
    $linhas = mysql_num_rows($query);
    if ($linhas > 0) {
        $tpl_notificacao->MOTIVO_COMPLEMENTO = "Este supervisor j� est� na lista!";
        $tpl_notificacao->block("BLOCK_ERRO");
        $tpl_notificacao->block("BLOCK_NAOEDITADO");
        $tpl_notificacao->block("BLOCK_MOTIVO_FALTADADOS");
        $tpl_notificacao->block("BLOCK_BOTAO_VOLTAR");
        $tpl_notificacao->show();
        exit;
    } else {
        //Insere novo registro
        $sql = "
        INSERT INTO 
            quiosques_supervisores (
                quisup_quiosque,
                quisup_supervisor,
                quisup_datafuncao
            )
        VALUES (
            '$quiosque',
            '$supervisor',
            '$datafuncao'
        )";
        $query = mysql_query($sql);
        if (!$query)
            die("Erro de SQL:" . mysql_error());
        $tpl_notificacao->MOTIVO_COMPLEMENTO = "";
        $tpl_notificacao->block("BLOCK_CONFIRMAR");
        $tpl_notificacao->block("BLOCK_CADASTRADO");
        $tpl_notificacao->block("BLOCK_BOTAO");
        $tpl_notificacao->show();    
    }
} else { //Se for uma edi��o
    $sql = "
    UPDATE
        quiosques_supervisores
    SET            
        quisup_datafuncao='$datafuncao'
    WHERE
        quisup_quiosque=$quiosque and
        quisup_supervisor=$supervisor
    ";
    if (!mysql_query($sql))
        die("Erro: " . mysql_error());
    $tpl_notificacao->MOTIVO_COMPLEMENTO = "";
    $tpl_notificacao->block("BLOCK_CONFIRMAR");
    $tpl_notificacao->block("BLOCK_EDITADO");
    $tpl_notificacao->block("BLOCK_BOTAO");
    $tpl_notificacao->show();    
}


include "rodape.php";
?>


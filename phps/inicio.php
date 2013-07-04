<?php
require "login_verifica.php";
//Executar limpeza de vendas incompletas
//include "saidas_elimina_incompletas.php";


if ($usuario_grupo == 4) {
    header("Location: saidas.php");
    exit;
}
if ($usuario_grupo == 5) {
    header("Location: estoque_porfornecedor_produto.php?fornecedor=$usuario_codigo");
    exit;
}
include "includes.php";


if (($usuario_grupo != 7) && ($usuario_grupo != 1) && ($usuario_grupo != 2)) {
    if (($usuario_quiosque == 0)||($usuario_grupo==0)) {


        $tpl = new Template("templates/notificacao.html");
        $tpl->ICONES = $icones;
        $tpl->MOTIVO_COMPLEMENTO = "Houveram alterações no perfil de seu usuario!<br>
        Isto normalmente acontece quando algum superior seu te adiciona ou remove dos seguinte cargos: presidente, supervisor, caixa ou fornecedor.<br>
        Para resolver isto, clique no icone 'Meu Perfil' que fica no cabeçalho ao lado do botão 'Sair' e altere o seu grupo de permissão.<br>
        Se mesmo assim não obter sucesso, favor contatar seu adminsitrador!";
        $tpl->block("BLOCK_ATENCAO");
        $tpl->DESTINO = "pessoas_cadastrar.php?codigo=$usuario_codigo&operacao=editar";
        $tpl->block("BLOCK_BOTAO");
        $tpl->show();
    } else {
        include "inicio.html";
        include "rodape.php";
    }
} else {
    include "inicio.html";
    include "rodape.php";
}
?>


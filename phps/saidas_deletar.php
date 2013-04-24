<?php

require "login_verifica.php";
if ($permissao_saidas_excluir <> 1) {
    header("Location: permissoes_semacesso.php");
    exit;
}

$tipopagina = "saidas";
include "includes.php";

$saida = $_GET["codigo"];

//Template de Título e Sub-título
$tpl_titulo = new Template("templates/titulos.html");
$tpl_titulo->TITULO = "SAIDAS";
$tpl_titulo->SUBTITULO = "DELETAR/APAGAR";
$tpl_titulo->ICONES_CAMINHO = "$icones";
$tpl_titulo->NOME_ARQUIVO_ICONE = "saidas.png";
$tpl_titulo->show();

//Inicio da exclus�o das saidas
$tpl = new Template("templates/notificacao.html");
$tpl->ICONES = $icones;
$tiposaida = $_GET["tiposaida"];
if ($tiposaida == 3)
    $tpl->DESTINO = "saidas_devolucao.php";
else
    $tpl->DESTINO = "saidas.php";


//Se for um vendedor s� pode deletar as vendas que ele fez 
if ($usuario_grupo == 4) {

    $sql = "SELECT sai_codigo FROM saidas WHERE sai_vendedor=$usuario_codigo and sai_codigo=$saida";
    $query = mysql_query($sql);
    if (!$query)
        die("Erro de SQL (1):" . mysql_error());
    $linhas = mysql_num_rows($query);
    if ($linhas == 0) {
        $tpl6 = new Template("templates/notificacao.html");
        $tpl6->block("BLOCK_ERRO");
        $tpl6->ICONES = $icones;
        $tpl6->block("BLOCK_NAOAPAGADO");
        $tpl6->MOTIVO = "Você n�o pode deletar uma venda que n�o tenha sido feita por você!";
        $tpl6->block("BLOCK_MOTIVO");
        $tpl6->block("BLOCK_BOTAO_VOLTAR");
        $tpl6->show();
        exit;
    }
}

if (($usuario_grupo == 1) || ($usuario_grupo == 3)) {


    //Devolve para o estoque, e excluir da saida
    //Carrega informa�ões dos produtos da Sa�da
    $sql2 = "SELECT * FROM `saidas_produtos` WHERE saipro_saida=$saida";
    $query2 = mysql_query($sql2);
    if (!$query2) {
        die("Erro de SQL (1):" . mysql_error());
    } while ($dados2 = mysql_fetch_assoc($query2)) {
        $produto = $dados2["saipro_produto"];
        $lote = $dados2["saipro_lote"];
        $qtd = $dados2["saipro_quantidade"];
        $acertado = $dados2["saipro_acertado"];
        if ($acertado != "0") {
            $tpl->block("BLOCK_ERRO");
            $tpl->block("BLOCK_NAOAPAGADO");
            $tpl->MOTIVO = "Este Sa�da possui produtos que j� foram acertados com o fornecedor!";
            $tpl->block("BLOCK_MOTIVO");
            $tpl->block("BLOCK_BOTAO");
            $tpl->show();
            exit;
        }

        //Verifica se o produto existe no estoque ou se foi eliminado por ter valor 0
        $sql9 = "
        SELECT
            *
        FROM
            estoque
        WHERE
            etq_quiosque=$usuario_quiosque and
            etq_produto=$produto and
            etq_lote=$lote
        ";
        $query9 = mysql_query($sql9);
        if (!$query9) {
            die("Erro de SQL(2):" . mysql_error());
        }
        $linhas9 = mysql_num_rows($query9);
        if ($linhas9 > 0) { //O produto existe no estoque
            //Atualiza a quantidade no estoque
            $sql_repor = "
        UPDATE
            estoque 
        SET 
            etq_quantidade=(etq_quantidade+$qtd)
        WHERE
            etq_quiosque=$usuario_quiosque and
            etq_produto=$produto and
            etq_lote=$lote 
        ";
            $query_repor = mysql_query($sql_repor);
            if (!$query_repor) {
                die("Erro de SQL(3):" . mysql_error());
            }
        } else { //O produto n�o existe mais no estoque, vamos inserir
            //Pegar os demais dados necess�rios para inserir no estoque
            $sql = "SELECT * FROM `entradas_produtos` join entradas on (entpro_entrada=ent_codigo) WHERE entpro_entrada=$lote";
            $query = mysql_query($sql);
            if (!$query) {
                die("Erro de SQL(4):" . mysql_error());
            }
            while ($dados = mysql_fetch_assoc($query)) {
                $validade = $dados["entpro_validade"];
                $valuni = $dados["entpro_valorunitario"];
                $fornecedor = $dados["ent_fornecedor"];
            }
            //Interir o produto no estoque
            $sql16 = "INSERT INTO estoque (etq_quiosque,etq_produto,etq_fornecedor,etq_lote,etq_quantidade,etq_valorunitario,etq_validade)
			VALUES ('$usuario_quiosque','$produto','$fornecedor','$lote','$qtd','$valuni','$validade')";
            $query16 = mysql_query($sql16);
            if (!$query16) {
                die("Erro de SQL (inserir no estoque): " . mysql_error());
            }
        }

        //Elimina o produto da Sa�da
        $sql_del = "DELETE FROM saidas_produtos WHERE saipro_saida=$saida and saipro_produto=$produto";
        $query_del = mysql_query($sql_del);
        if (!$query_del) {
            die("Erro de SQL(5):" . mysql_error());
        }
    }

    //Eliminar a saida
    $sql = "DELETE FROM saidas WHERE sai_codigo=$saida";
    $query = mysql_query($sql);
    if (!$query) {
        die("Erro de SQL(6):" . mysql_error());
    }
} else {
    $tpl6 = new Template("templates/notificacao.html");
    $tpl6->block("BLOCK_ERRO");
    $tpl6->ICONES = $icones;
    $tpl6->block("BLOCK_NAOAPAGADO");
    $tpl6->MOTIVO = "Você n�o tem permiss�o para excluir Sa�das!";
    $tpl6->block("BLOCK_MOTIVO");
    $tpl6->block("BLOCK_BOTAO_VOLTAR");
    $tpl6->show();
}
$tpl->block("BLOCK_CONFIRMAR");
$tpl->block("BLOCK_APAGADO");
$tpl->block("BLOCK_BOTAO");
$tpl->show();

include "rodape.php";
?>

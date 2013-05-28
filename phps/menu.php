<?php

$tpl_menu = new Template("menu.html");

//Menu Principal
//Dados principais
$tpl_menu->TABELA_TAMANHO = "100%";
$tpl_menu->TABELA_ALINHAMENTO = "center";
$tpl_menu->IMAGEM_TAMANHO = "40px";
$tpl_menu->IMAGEM_PASTA = $icones;
$tpl_menu->IMAGEM_ALTURA2 = 1.25;

$tpl_menu->TD_LARGURA = "";
$tpl_menu->block("BLOCK_MENU_ITEM");

$tpl_menu->TD_ALTURA = "72px";
$tpl_menu->TD_LARGURA = "100px";
$tpl_menu->TD_ALINHAMENTO_VERTICAL = "bottom";

//Quiosques
$tpl_menu->IMAGEM_TITULO = "Quiosques";
$tpl_menu->TITULO = "Quiosques";
if ($permissao_quiosque_ver == 1) {
    $tpl_menu->IMAGEM_ARQUIVO = "quiosques.png";
    $tpl_menu->LINK = "quiosques.php";
    $tpl_menu->block("BLOCK_MENU_ITEM_IMG");
    $tpl_menu->block("BLOCK_MENU_ITEM");
}
/*
//Locais
$tpl_menu->IMAGEM_TITULO = "Locais";
$tpl_menu->TITULO = "Locais";
if ($permissao_cidades_ver == 1) {
    $tpl_menu->IMAGEM_ARQUIVO = "locais.png";
    $tpl_menu->LINK = "cidades.php";
    $tpl_menu->block("BLOCK_MENU_ITEM_IMG");
    $tpl_menu->block("BLOCK_MENU_ITEM");
}
*/
//Pessoas
$tpl_menu->IMAGEM_TITULO = "Pessoas";
$tpl_menu->TITULO = "Pessoas";
if ($permissao_pessoas_ver == 1) {
    $tpl_menu->IMAGEM_ARQUIVO = "pessoas.png";
    $tpl_menu->LINK = "pessoas.php";
    $tpl_menu->block("BLOCK_MENU_ITEM_IMG");
    $tpl_menu->block("BLOCK_MENU_ITEM");
}

//Produtos
$tpl_menu->IMAGEM_TITULO = "Produtos";
$tpl_menu->TITULO = "Produtos";
if ($permissao_produtos_ver == 1) {
    $tpl_menu->IMAGEM_ARQUIVO = "produtos.png";
    $tpl_menu->LINK = "produtos.php";
    $tpl_menu->block("BLOCK_MENU_ITEM_IMG");
    $tpl_menu->block("BLOCK_MENU_ITEM");
}

//Estoque
$tpl_menu->IMAGEM_TITULO = "Estoque";
$tpl_menu->TITULO = "Estoque";
if ($permissao_estoque_ver == 1) {
    if ($usuario_quiosque != 0) {

        $tpl_menu->IMAGEM_ARQUIVO = "estoque.png";
        if ($usuario_grupo == 5)
            $tpl_menu->LINK = "estoque_porfornecedor_produto.php?fornecedor=$usuario_codigo";
        else
            $tpl_menu->LINK = "estoque.php";
        $tpl_menu->block("BLOCK_MENU_ITEM_IMG");
        $tpl_menu->block("BLOCK_MENU_ITEM");
    }
}


//Entradas
$tpl_menu->IMAGEM_TITULO = "Entradas";
$tpl_menu->TITULO = "Entradas";
if ($permissao_entradas_ver == 1) {
    if ($usuario_quiosque != 0) {
        $tpl_menu->IMAGEM_ARQUIVO = "entradas.png";
        $tpl_menu->LINK = "entradas.php";
        $tpl_menu->block("BLOCK_MENU_ITEM_IMG");
        $tpl_menu->block("BLOCK_MENU_ITEM");
    }
}

//Saidas
$tpl_menu->IMAGEM_TITULO = "Saídas";
$tpl_menu->TITULO = "Saídas";
if ($permissao_saidas_ver == 1) {
    if ($usuario_quiosque != 0) {
        $tpl_menu->IMAGEM_ARQUIVO = "saidas.png";
        $tpl_menu->LINK = "saidas.php";
        $tpl_menu->block("BLOCK_MENU_ITEM_IMG");
        $tpl_menu->block("BLOCK_MENU_ITEM");
    }
}

//Negociações
$tpl_menu->IMAGEM_TITULO = "Negociações";
$tpl_menu->TITULO = "Negociações";
if ($permissao_acertos_ver == 1) {
    if ($usuario_quiosque != 0) {
        $tpl_menu->IMAGEM_ARQUIVO = "acertos2.png";
        if ($quiosque_consignacao==1)
            $tpl_menu->LINK = "acertos.php";
        else
            $tpl_menu->LINK = "acertos_revenda.php";
        $tpl_menu->block("BLOCK_MENU_ITEM_IMG");
        $tpl_menu->block("BLOCK_MENU_ITEM");
    }
}

//Relatórios
$tpl_menu->IMAGEM_TITULO = "Relatórios";
$tpl_menu->TITULO = "Relatórios";
if ($permissao_relatorios_ver == 1) {
    $tpl_menu->IMAGEM_ARQUIVO = "relatorios.png";
    $tpl_menu->LINK = "relatorios.php";
    $tpl_menu->block("BLOCK_MENU_ITEM_IMG");
    $tpl_menu->block("BLOCK_MENU_ITEM");
}


//Contato
$tpl_menu->IMAGEM_TITULO = "Contato";
$tpl_menu->TITULO = "Contato";
$tpl_menu->IMAGEM_ARQUIVO = "contato.png";
$tpl_menu->LINK = "contato.php";
$tpl_menu->block("BLOCK_MENU_ITEM_IMG");
$tpl_menu->block("BLOCK_MENU_ITEM");

$tpl_menu->TD_LARGURA = "";
$tpl_menu->block("BLOCK_MENU_ITEM");

$tpl_menu->block("BLOCK_MENU");







//Sub-Menu
//Dados principais
$tpl_menu->TABELA_TAMANHO = "";
$tpl_menu->TABELA_ALINHAMENTO = "right";
$tpl_menu->TD_ALTURA = "52px";
$tpl_menu->TD_LARGURA = "110px";

$tpl_menu->IMAGEM_TAMANHO = "25px";
$tpl_menu->TD_ALINHAMENTO_VERTICAL = "bottom";
$tpl_menu->IMAGEM_PASTA = $icones;
$tpl_menu->IMAGEM_ALTURA2 = 1.3;

//Sub-menu Quiosque
if ($tipopagina == "cooperativas") {


    //Cooperativas
    if ($permissao_cooperativa_ver == 1) {
        $tpl_menu->IMAGEM_TITULO = "Cooperativas";
        $tpl_menu->TITULO = "Cooperativas";
        $tpl_menu->IMAGEM_ARQUIVO = "cooperativas.png";
        $tpl_menu->LINK = "cooperativas.php";
        $tpl_menu->block("BLOCK_MENU_ITEM_IMG");
        $tpl_menu->block("BLOCK_MENU_ITEM");
    }

    //Quiosques
    if ($permissao_quiosque_ver == 1) {
        $tpl_menu->IMAGEM_TITULO = "Quiosques";
        $tpl_menu->TITULO = "Quiosques";
        $tpl_menu->IMAGEM_ARQUIVO = "quiosques.png";
        $tpl_menu->LINK = "quiosques.php";
        $tpl_menu->block("BLOCK_MENU_ITEM_IMG");
        $tpl_menu->block("BLOCK_MENU_ITEM");
    }

    //Taxas
    if ($permissao_taxas_ver == 1) {
        $tpl_menu->IMAGEM_TITULO = "Taxas";
        $tpl_menu->TITULO = "Taxas";
        $tpl_menu->IMAGEM_ARQUIVO = "taxas.png";
        $tpl_menu->LINK = "taxas.php";
        $tpl_menu->block("BLOCK_MENU_ITEM_IMG");
        $tpl_menu->block("BLOCK_MENU_ITEM");
    }
}
//Sub-menu Locais
if ($tipopagina == "locais") {

    if ($permissao_paises_ver == 1) {
        $tpl_menu->LINK = "paises.php";
        $tpl_menu->IMAGEM_ARQUIVO = "locais.png";
        $tpl_menu->IMAGEM_TITULO = "Paises";
        $tpl_menu->TITULO = "Paises";
        $tpl_menu->block("BLOCK_MENU_ITEM_IMG");
        $tpl_menu->block("BLOCK_MENU_ITEM");
    }

    if ($permissao_estados_ver == 1) {
        $tpl_menu->LINK = "estados.php";
        $tpl_menu->IMAGEM_ARQUIVO = "locais.png";
        $tpl_menu->IMAGEM_TITULO = "Estados";
        $tpl_menu->TITULO = "Estados";
        $tpl_menu->block("BLOCK_MENU_ITEM_IMG");
        $tpl_menu->block("BLOCK_MENU_ITEM");
    }

    if ($permissao_cidades_ver == 1) {
        $tpl_menu->LINK = "cidades.php";
        $tpl_menu->IMAGEM_ARQUIVO = "locais.png";
        $tpl_menu->IMAGEM_TITULO = "Cidades";
        $tpl_menu->TITULO = "Cidades";
        $tpl_menu->block("BLOCK_MENU_ITEM_IMG");
        $tpl_menu->block("BLOCK_MENU_ITEM");
    }
}
//Sub-menu Produtos
if ($tipopagina == "produtos") {

    if ($permissao_produtos_ver == 1) {
        $tpl_menu->LINK = "produtos.php";
        $tpl_menu->IMAGEM_ARQUIVO = "produtos.png";
        $tpl_menu->IMAGEM_TITULO = "Produtos";
        $tpl_menu->TITULO = "Produtos";
        $tpl_menu->block("BLOCK_MENU_ITEM_IMG");
        $tpl_menu->block("BLOCK_MENU_ITEM");
    }

    //Categorias
    if ($permissao_categorias_ver == 1) {
        $tpl_menu->LINK = "categorias.php";
        $tpl_menu->IMAGEM_ARQUIVO = "produtos.png";
        $tpl_menu->IMAGEM_TITULO = "Categorias";
        $tpl_menu->TITULO = "Categorias";
        $tpl_menu->block("BLOCK_MENU_ITEM_IMG");
        $tpl_menu->block("BLOCK_MENU_ITEM");
    }

    //Tipo de Contagem
    /* if ($permissao_tipocontagem_ver == 1) {
      $tpl_menu->LINK = "tipo_contagem.php";
      $tpl_menu->IMAGEM_ARQUIVO = "produtos.png";
      $tpl_menu->IMAGEM_TITULO = "Tipo Contagem";
      $tpl_menu->TITULO = "Tipo Contagem";
      $tpl_menu->block("BLOCK_MENU_ITEM_IMG");
      $tpl_menu->block("BLOCK_MENU_ITEM");
      } */
}
//Sub-menu Estoque
if ($tipopagina == "estoque") {

    if ($permissao_estoque_ver == 1) {
        if ($usuario_quiosque == 0) {

            $tpl_menu->LINK = "estoque_porquiosque.php";
            $tpl_menu->IMAGEM_ARQUIVO = "estoque.png";
            $tpl_menu->IMAGEM_TITULO = "Quiosques";
            $tpl_menu->TITULO = "Quiosque";
            $tpl_menu->block("BLOCK_MENU_ITEM_IMG");
            $tpl_menu->block("BLOCK_MENU_ITEM");

            $tpl_menu->LINK = "estoque_porproduto_geral.php";
            $tpl_menu->IMAGEM_ARQUIVO = "estoque.png";
            $tpl_menu->IMAGEM_TITULO = "Produtos Geral";
            $tpl_menu->TITULO = "Produtos";
            $tpl_menu->block("BLOCK_MENU_ITEM_IMG");
            $tpl_menu->block("BLOCK_MENU_ITEM");


            $tpl_menu->LINK = "estoque_porfornecedor_geral.php";
            $tpl_menu->IMAGEM_ARQUIVO = "estoque.png";
            $tpl_menu->IMAGEM_TITULO = "Fornecedor Geral";
            $tpl_menu->TITULO = "Fornecedor";
            $tpl_menu->block("BLOCK_MENU_ITEM_IMG");
            $tpl_menu->block("BLOCK_MENU_ITEM");
        } else {

            $tpl_menu->LINK = "estoque.php";
            $tpl_menu->IMAGEM_ARQUIVO = "estoque.png";
            $tpl_menu->IMAGEM_TITULO = "Produtos";
            $tpl_menu->TITULO = "Produtos";
            $tpl_menu->block("BLOCK_MENU_ITEM_IMG");
            $tpl_menu->block("BLOCK_MENU_ITEM");

            if ($usuario_grupo == 5)
                $tpl_menu->LINK = "estoque_porfornecedor_produto.php?fornecedor=$usuario_codigo";
            else
                $tpl_menu->LINK = "estoque_porfornecedor.php";
            $tpl_menu->IMAGEM_ARQUIVO = "estoque.png";
            $tpl_menu->IMAGEM_TITULO = "Fornecedores";
            $tpl_menu->TITULO = "Fornecedores";
            $tpl_menu->block("BLOCK_MENU_ITEM_IMG");
            $tpl_menu->block("BLOCK_MENU_ITEM");

            if ($usuario_grupo != 5) {
                $tpl_menu->LINK = "estoque_validade.php";
                $tpl_menu->IMAGEM_ARQUIVO = "estoque.png";
                $tpl_menu->IMAGEM_TITULO = "Validade";
                $tpl_menu->TITULO = "Validade";
                $tpl_menu->block("BLOCK_MENU_ITEM_IMG");
                $tpl_menu->block("BLOCK_MENU_ITEM");
            }

            if ($permissao_estoque_qtdide_definir == 1) {
                $tpl_menu->LINK = "estoque_qtdideal.php";
                $tpl_menu->IMAGEM_ARQUIVO = "estoque.png";
                $tpl_menu->IMAGEM_TITULO = "Qtd. Ideal";
                $tpl_menu->TITULO = "Qtd. Ideal";
                $tpl_menu->block("BLOCK_MENU_ITEM_IMG");
                $tpl_menu->block("BLOCK_MENU_ITEM");
            }
        }
    }
}
//Sub-menu Saidas
if ($tipopagina == "saidas") {
    //Devolução
    if ($permissao_saidas_cadastrar_devolucao == 1) {
        $tpl_menu->LINK = "saidas_devolucao.php";
        $tpl_menu->IMAGEM_ARQUIVO = "saidas.png";
        $tpl_menu->IMAGEM_TITULO = "Devolução";
        $tpl_menu->TITULO = "Devolução";
        $tpl_menu->block("BLOCK_MENU_ITEM_IMG");
        $tpl_menu->block("BLOCK_MENU_ITEM");
    }
    //Vendas
    if ($usuario_grupo != 4) {

        if ($permissao_saidas_cadastrar == 1) {
            $tpl_menu->LINK = "saidas.php";
            $tpl_menu->IMAGEM_ARQUIVO = "saidas.png";
            $tpl_menu->IMAGEM_TITULO = "Vendas";
            $tpl_menu->TITULO = "Vendas";
            $tpl_menu->block("BLOCK_MENU_ITEM_IMG");
            $tpl_menu->block("BLOCK_MENU_ITEM");
        }
    }
}

//Negociações
if ($tipopagina == "negociacoes") {
    //Consignados
    if ($quiosque_consignacao == 1) {
        $tpl_menu->LINK = "acertos.php";
        $tpl_menu->IMAGEM_ARQUIVO = "consignacao.png";
        $tpl_menu->IMAGEM_TITULO = "Acertos Consignações";
        $tpl_menu->TITULO = "Acertos Consignações";
        $tpl_menu->block("BLOCK_MENU_ITEM_IMG");
        $tpl_menu->block("BLOCK_MENU_ITEM");
    }
    if ($quiosque_revenda == 1) {
        $tpl_menu->LINK = "acertos_revenda.php";
        $tpl_menu->IMAGEM_ARQUIVO = "revenda.png";
        $tpl_menu->IMAGEM_TITULO = "Fechamento Revendas";
        $tpl_menu->TITULO = "Fechamento Revendas";
        $tpl_menu->block("BLOCK_MENU_ITEM_IMG");
        $tpl_menu->block("BLOCK_MENU_ITEM");
    }
}




$tpl_menu->block("BLOCK_MENU");

$tpl_menu->show();
?>

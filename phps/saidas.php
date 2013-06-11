<?php

//Verifica se o usu�rio tem permiss�o para acessar este conte�do
require "login_verifica.php";
if ($permissao_saidas_ver <> 1) {
    header("Location: permissoes_semacesso.php");
    exit;
}


$tipopagina = "saidas";
include "includes.php";
//Template de Título e Sub-título
$tpl_titulo = new Template("templates/titulos.html");
$tpl_titulo->TITULO = "SAÍDAS";
$tpl_titulo->SUBTITULO = "LISTAGEM DE VENDAS";
$tpl_titulo->ICONES_CAMINHO = "$icones";
$tpl_titulo->NOME_ARQUIVO_ICONE = "saidas.png";
$tpl_titulo->show();

$tpl = new Template("templates/listagem.html");

//Filtro Inicio
$filtro_numero = $_POST["filtro_numero"];
$filtro_produto = $_POST["filtro_produto"];
$filtro_consumidor = $_POST["filtro_consumidor"];
$filtro_fornecedor = $_POST["filtro_fornecedor"];
$filtro_vendedor = $_POST["filtro_vendedor"];
$filtro_tipo = $_POST["filtro_tipo"];
$filtro_lote = $_POST["filtro_lote"];
$tpl->LINK_FILTRO = "saidas.php";
$tpl->FORM_ONLOAD = "valida_filtro_saidas_numero()";


//Filtro Numero da saida
$tpl->CAMPO_TITULO = "Nº Saída";
$tpl->CAMPO_TAMANHO = "15";
$tpl->CAMPO_NOME = "filtro_numero";
$tpl->CAMPO_VALOR = $filtro_numero;
$tpl->CAMPO_QTD_CARACTERES = "";
$tpl->CAMPO_ONKEYUP = "valida_filtro_saidas_numero()";
$tpl->block("BLOCK_FILTRO_CAMPO");
$tpl->block("BLOCK_FILTRO_ESPACO");
$tpl->block("BLOCK_FILTRO_COLUNA");


//Filtro Consumidor
$tpl->SELECT_TITULO = "Consumidor";
$tpl->SELECT_NOME = "filtro_consumidor";
$tpl->SELECT_OBRIGATORIO = "";
$sql = "
    SELECT DISTINCT pes_codigo, pes_nome 
    FROM mestre_pessoas_tipo 
    join pessoas on (mespestip_pessoa=pes_codigo) 
    JOIN saidas on (sai_consumidor=pes_codigo) 
    WHERE mespestip_tipo=6 
    and pes_cooperativa=$usuario_cooperativa 
    and sai_tipo=1
    ORDER BY pes_nome
";
$query = mysql_query($sql);
if (!$query)
    die("Erro SQL1" . mysql_error());
while ($dados = mysql_fetch_assoc($query)) {
    $tpl->SELECT_OPTION_CODIGO = $dados["pes_codigo"];
    $tpl->SELECT_OPTION_NOME = $dados["pes_nome"];
    if ($filtro_consumidor == $dados["pes_codigo"])
        $tpl->SELECT_OPTION_SELECIONADO = " selected ";
    else
        $tpl->SELECT_OPTION_SELECIONADO = " ";
    $tpl->block("BLOCK_FILTRO_SELECT_OPTION");
}
$tpl->block("BLOCK_FILTRO_SELECT");
$tpl->block("BLOCK_FILTRO_ESPACO");
$tpl->block("BLOCK_FILTRO_COLUNA");


//Filtro Produto
$tpl->CAMPO_TITULO = "Produto";
$tpl->CAMPO_TAMANHO = "25";
$tpl->CAMPO_NOME = "filtro_produto";
$tpl->CAMPO_VALOR = $filtro_produto;
$tpl->CAMPO_QTD_CARACTERES = "";
$tpl->CAMPO_ONKEYUP = "";
$tpl->block("BLOCK_FILTRO_CAMPO");
$tpl->block("BLOCK_FILTRO_ESPACO");
$tpl->block("BLOCK_FILTRO_COLUNA");

//Filtro Fornecedor
$tpl->SELECT_TITULO = "Fornecedor";
$tpl->SELECT_NOME = "filtro_fornecedor";
$tpl->SELECT_OBRIGATORIO = "";
$sql = "
SELECT DISTINCT pes_codigo, pes_nome 
FROM saidas_produtos
JOIN saidas on (saipro_saida=sai_codigo)
JOIN entradas on (saipro_lote=ent_codigo)
JOIN pessoas on (ent_fornecedor=pes_codigo)
WHERE pes_cooperativa=$usuario_cooperativa 
and sai_tipo=1
ORDER BY pes_nome";
$query = mysql_query($sql);
if (!$query)
    die("Erro SQL2" . mysql_error());
while ($dados = mysql_fetch_assoc($query)) {
    $tpl->SELECT_OPTION_CODIGO = $dados["pes_codigo"];
    $tpl->SELECT_OPTION_NOME = $dados["pes_nome"];
    if ($filtro_fornecedor == $dados["pes_codigo"])
        $tpl->SELECT_OPTION_SELECIONADO = " selected ";
    else
        $tpl->SELECT_OPTION_SELECIONADO = " ";
    $tpl->block("BLOCK_FILTRO_SELECT_OPTION");
}
$tpl->block("BLOCK_FILTRO_SELECT");
$tpl->block("BLOCK_FILTRO_ESPACO");
$tpl->block("BLOCK_FILTRO_COLUNA");

//Filtro Nº Lote
$tpl->CAMPO_TITULO = "Nº Lote";
$tpl->CAMPO_TAMANHO = "15";
$tpl->CAMPO_NOME = "filtro_lote";
$tpl->CAMPO_VALOR = $filtro_lote;
$tpl->CAMPO_QTD_CARACTERES = "";
$tpl->CAMPO_ONKEYUP = "";
$tpl->block("BLOCK_FILTRO_CAMPO");
$tpl->block("BLOCK_FILTRO_ESPACO");
$tpl->block("BLOCK_FILTRO_COLUNA");


//Filtro fim
$tpl->block("BLOCK_FILTRO");



//Inicio da tabela de listagem
//Cabe�alho da lista
$tpl->CABECALHO_COLUNA_TAMANHO = "";
$tpl->CABECALHO_COLUNA_COLSPAN = "";
$tpl->CABECALHO_COLUNA_NOME = "Nº";
$tpl->block("BLOCK_LISTA_CABECALHO");

$tpl->CABECALHO_COLUNA_TAMANHO = "";
$tpl->CABECALHO_COLUNA_COLSPAN = "2";
$tpl->CABECALHO_COLUNA_NOME = "DATA";
$tpl->block("BLOCK_LISTA_CABECALHO");

$tpl->CABECALHO_COLUNA_TAMANHO = "";
$tpl->CABECALHO_COLUNA_COLSPAN = "";
$tpl->CABECALHO_COLUNA_NOME = "CONSUMIDOR";
$tpl->block("BLOCK_LISTA_CABECALHO");

if ($usuario_grupo != 4) {
    $tpl->CABECALHO_COLUNA_TAMANHO = "";
    $tpl->CABECALHO_COLUNA_COLSPAN = "";
    $tpl->CABECALHO_COLUNA_NOME = "VENDEDOR";
    $tpl->block("BLOCK_LISTA_CABECALHO");
}

$tpl->CABECALHO_COLUNA_TAMANHO = "50px";
$tpl->CABECALHO_COLUNA_COLSPAN = "";
$tpl->CABECALHO_COLUNA_NOME = "QTD. PROD.";
$tpl->block("BLOCK_LISTA_CABECALHO");

$tpl->CABECALHO_COLUNA_TAMANHO = "50px";
$tpl->CABECALHO_COLUNA_COLSPAN = "";
$tpl->CABECALHO_COLUNA_NOME = "ITENS";
$tpl->block("BLOCK_LISTA_CABECALHO");

$tpl->CABECALHO_COLUNA_TAMANHO = "";
$tpl->CABECALHO_COLUNA_COLSPAN = "";
$tpl->CABECALHO_COLUNA_NOME = "TOTAL";
$tpl->block("BLOCK_LISTA_CABECALHO");

//$tpl->CABECALHO_COLUNA_TAMANHO = "";
//$tpl->CABECALHO_COLUNA_COLSPAN = "";
//$tpl->CABECALHO_COLUNA_NOME = "TOTAL BRUTO";
//$tpl->block("BLOCK_LISTA_CABECALHO");

$tpl->CABECALHO_COLUNA_TAMANHO = "";
$tpl->CABECALHO_COLUNA_COLSPAN = "";
$tpl->CABECALHO_COLUNA_NOME = "DESC.";
$tpl->block("BLOCK_LISTA_CABECALHO");

$tpl->CABECALHO_COLUNA_TAMANHO = "40 px";
$tpl->CABECALHO_COLUNA_COLSPAN = "";
$tpl->CABECALHO_COLUNA_NOME = "MET. PAG.";
$tpl->block("BLOCK_LISTA_CABECALHO");

$tpl->CABECALHO_COLUNA_TAMANHO = "";
$tpl->CABECALHO_COLUNA_COLSPAN = "";
$tpl->CABECALHO_COLUNA_NOME = "SIT.";
$tpl->block("BLOCK_LISTA_CABECALHO");

$oper = 0;
$oper_tamanho = 0;
if ($permissao_saidas_ver == 1) {
    $oper = $oper + 1;
    $oper_tamanho = $oper_tamanho + 50;
}
if ($permissao_saidas_editar == 1) {
    $oper++;
    $oper_tamanho = $oper_tamanho + 50;
}


$tpl->CABECALHO_COLUNA_TAMANHO = "$oper_tamanho";
$tpl->CABECALHO_COLUNA_COLSPAN = "$oper";
$tpl->CABECALHO_COLUNA_NOME = "OPERAÇÕES";
$tpl->block("BLOCK_LISTA_CABECALHO");

//Linhas
//Verifica quais filtros devem ser considerados no sql principal
if ($filtro_numero <> "")
    $sql_filtro_numero = " and sai_codigo = $filtro_numero ";
if ($filtro_produto <> "")
    $sql_filtro_produto = " and pro_nome like '%$filtro_produto %'";
if ($filtro_lote <> "")
    $sql_filtro_lote = " and saipro_lote = $filtro_lote ";
if ($filtro_consumidor <> "")
    $sql_filtro_consumidor = " and sai_consumidor = $filtro_consumidor ";
if ($filtro_vendedor <> "")
    $sql_filtro_vendedor = " and sai_consumidor = $filtro_vendedor ";
if ($filtro_fornecedor <> "")
    $sql_filtro_fornecedor = " and ent_fornecedor = $filtro_fornecedor ";
if ($filtro_tipo <> "")
    $sql_filtro_tipo = " and sai_tipo = $filtro_tipo ";
$sql_filtro = $sql_filtro_numero . " " . $sql_filtro_consumidor . " " . $sql_filtro_vendedor . " " . $sql_filtro_tipo . " " . $sql_filtro_produto . " " . $sql_filtro_lote . " " . $sql_filtro_fornecedor;
if ($usuario_grupo == 4) {
    $sql_filtro = $sql_filtro . " and sai_vendedor=$usuario_codigo";
}



//SQL Principal das linhas
$sql = "
SELECT DISTINCT sai_codigo,sai_datacadastro,sai_horacadastro,sai_consumidor,sai_tipo,sai_totalliquido,sai_totalbruto,sai_status,sai_vendedor,sai_metpag,sai_areceber
FROM saidas 
JOIN saidas_tipo on (sai_tipo=saitip_codigo) 
left join saidas_produtos on (saipro_saida=sai_codigo)
LEFT JOIN produtos on (saipro_produto=pro_codigo)
left join entradas on (saipro_lote=ent_codigo)
WHERE sai_quiosque=$usuario_quiosque and
sai_tipo=1 $sql_filtro 
ORDER BY sai_status DESC, sai_codigo DESC
";
//Pagina��o
$query = mysql_query($sql);
if (!$query)
    die("Erro SQL Principal Pagina��o:" . mysql_error());
$linhas = mysql_num_rows($query);
$por_pagina = $usuario_paginacao;
$paginaatual = $_POST["paginaatual"];
$paginas = ceil($linhas / $por_pagina);
//Se � a primeira vez que acessa a pagina ent�o come�ar na pagina 1
if (($paginaatual == "") || ($paginas < $paginaatual) || ($paginaatual <= 0)) {
    $paginaatual = 1;
}
$comeco = ($paginaatual - 1) * $por_pagina;
$tpl->PAGINAS = "$paginas";
$tpl->PAGINAATUAL = "$paginaatual";
$tpl->PASTA_ICONES = "$icones";
$tpl->block("BLOCK_PAGINACAO");
$sql = $sql . " LIMIT $comeco,$por_pagina ";





$query = mysql_query($sql);
if (!$query)
    die("Erro: " . mysql_error());
$linhas = mysql_num_rows($query);
if ($linhas == 0) {
    $listanada = 9;
    $tpl->LISTANADA = $listanada + $oper;
    $tpl->block("BLOCK_LISTA_NADA");
} else {
    while ($dados = mysql_fetch_array($query)) {

        $numero = $dados["sai_codigo"];
        $data = $dados["sai_datacadastro"];
        $hora = $dados["sai_horacadastro"];
        $consumidor = $dados["sai_consumidor"];
        $vendedor = $dados["sai_vendedor"];
        $tipo = $dados["sai_tipo"];
        $valorliquido = $dados["sai_totalliquido"];
        $valorbruto = $dados["sai_totalbruto"];
        $status = $dados["sai_status"];
        $metodopag = $dados["sai_metpag"];
        $areceber = $dados["sai_areceber"];


        //Cor de fundo da linha
        if ($status == 2) {
            if ($usuario_codigo == $vendedor) {
                $tpl->LISTA_LINHA_CLASSE = "tabelalinhafundovermelho negrito";
            } else {
                $dataatual = date("Y-m-d");
                $horaatual = date("H:i:s");
                $tempo1 = $data . "_" . $hora;
                $tempo2 = $dataatual . "_" . $horaatual;
                $total_segundos = diferenca_entre_datahora($tempo1, $tempo2);
                if ($total_segundos > 5400) {
                    $tpl->LISTA_LINHA_CLASSE = "tabelalinhafundovermelho negrito";
                } else {
                    $tpl->LISTA_LINHA_CLASSE = "tabelalinhafundoamarelo negrito";
                }
            }
        } else {
            $tpl->LISTA_LINHA_CLASSE = "";
        }

        //Coluna Numero
        $tpl->LISTA_COLUNA_ALINHAMENTO = "right";
        $tpl->LISTA_COLUNA_CLASSE = "";
        $tpl->LISTA_COLUNA_VALOR = $numero;
        $tpl->block("BLOCK_LISTA_COLUNA");

        //Coluna Data    
        $tpl->LISTA_COLUNA_ALINHAMENTO = "right";
        $tpl->LISTA_COLUNA_VALOR = converte_data($data);
        $tpl->LISTA_COLUNA_CLASSE = "";
        $tpl->block("BLOCK_LISTA_COLUNA");

        //Coluna Hora
        $tpl->LISTA_COLUNA_ALINHAMENTO = "";
        $tpl->LISTA_COLUNA_CLASSE = "";
        $tpl->LISTA_COLUNA_VALOR = converte_hora($hora);
        $tpl->block("BLOCK_LISTA_COLUNA");

        //Coluna Consumidor
        $tpl->LISTA_COLUNA_ALINHAMENTO = "";
        $tpl->LISTA_COLUNA_CLASSE = "";

        if ($consumidor == 0) {
            $tpl->LISTA_COLUNA_VALOR = "Cliente Geral";
        } else {
            $sql2 = "SELECT pes_nome FROM pessoas WHERE pes_codigo=$consumidor";
            $query2 = mysql_query($sql2);
            if (!$query2)
                die("Erro: " . mysql_error());
            while ($dados2 = mysql_fetch_assoc($query2)) {
                $tpl->LISTA_COLUNA_VALOR = $dados2["pes_nome"];
            }
        }
        $tpl->block("BLOCK_LISTA_COLUNA");

        if ($usuario_grupo != 4) {
            //Coluna Vendedor
            $tpl->LISTA_COLUNA_ALINHAMENTO = "";
            $tpl->LISTA_COLUNA_CLASSE = "";
            $sql2 = "SELECT pes_nome FROM pessoas WHERE pes_codigo=$vendedor";
            $query2 = mysql_query($sql2);
            if (!$query2)
                die("Erro: " . mysql_error());
            while ($dados2 = mysql_fetch_assoc($query2)) {
                $tpl->LISTA_COLUNA_VALOR = $dados2["pes_nome"];
            }
            $tpl->block("BLOCK_LISTA_COLUNA");
        }

        //Coluna Quantidade Produtos
        $tpl->LISTA_COLUNA_ALINHAMENTO = "center";
        $tpl->LISTA_COLUNA_CLASSE = "";
        $sql3 = "SELECT DISTINCT saipro_produto as qtd FROM saidas_produtos WHERE saipro_saida=$numero";
        $query3 = mysql_query($sql3);
        if (!$query3)
            die("Erro: " . mysql_error());
        $tpl->LISTA_COLUNA_VALOR = "(" . mysql_num_rows($query3) . ")";
        $tpl->block("BLOCK_LISTA_COLUNA");

        //Coluna Quantidade Itens
        $tpl->LISTA_COLUNA_ALINHAMENTO = "center";
        $tpl->LISTA_COLUNA_CLASSE = "";
        $sql3 = "SELECT DISTINCT saipro_codigo FROM saidas_produtos WHERE saipro_saida=$numero";
        $query3 = mysql_query($sql3);
        if (!$query3)
            die("Erro: " . mysql_error());
        $tpl->LISTA_COLUNA_VALOR = "(" . mysql_num_rows($query3) . ")";
        $tpl->block("BLOCK_LISTA_COLUNA");


        //Total
        $tpl->LISTA_COLUNA_ALINHAMENTO = "right";
        $tpl->LISTA_COLUNA_CLASSE = "";
        $tpl->LISTA_COLUNA_VALOR = "R$ " . number_format($valorbruto, 2, ',', '.');
        $tpl->block("BLOCK_LISTA_COLUNA");        
        

        //Coluna Valor com desconto
        $tpl->LISTA_COLUNA_ALINHAMENTO = "right";
        $desconto = $valorbruto - $desc;
        if ($desconto == 0)
            $tpl->LISTA_COLUNA_CLASSE = "";
        else if ($desconto > 0)
            $tpl->LISTA_COLUNA_CLASSE = "tabelalinhavermelha";
        else
            $tpl->LISTA_COLUNA_CLASSE = "tabelalinhaazul";
        $tpl->LISTA_COLUNA_VALOR = "R$ " . number_format(abs($desconto), 2, ',', '.');
        $tpl->block("BLOCK_LISTA_COLUNA");

        //Metodo de pagamento
        if ($metodopag == 1) {
            $tpl->ICONE_ARQUIVO = $icones . "dinheiro3.jpg";
            $tpl->OPERACAO_NOME = "Dinheiro";
            $tpl->block("BLOCK_LISTA_COLUNA_ICONE");
        } else if ($metodopag == 2) {
            $tpl->ICONE_ARQUIVO = $icones . "credit_card2.png";
            $tpl->OPERACAO_NOME = "Cartão Crédito";
            $tpl->block("BLOCK_LISTA_COLUNA_ICONE");
        } else if ($metodopag == 3) {
            $tpl->OPERACAO_NOME = "Cartão Débito";
            $tpl->ICONE_ARQUIVO = $icones . "credit_card.png";
            $tpl->block("BLOCK_LISTA_COLUNA_ICONE");
        } else {
            if ($areceber == 1) {
                $tpl->OPERACAO_NOME = "Caderninho (A Receber)";
                $tpl->ICONE_ARQUIVO = $icones . "caderninho5.png";
                $tpl->block("BLOCK_LISTA_COLUNA_ICONE");
            } else {
                $tpl->LISTA_COLUNA_ALINHAMENTO = "right";
                $tpl->LISTA_COLUNA_CLASSE = "";
                $tpl->LISTA_COLUNA_VALOR = "";
                $tpl->block("BLOCK_LISTA_COLUNA");
            }
        }






        //Situação
        if ($status == 2) {
            if ($usuario_codigo == $vendedor) {
                $tpl->ICONE_ARQUIVO = $icones . "star_empty.png";
                $tpl->OPERACAO_NOME = "Incompleta";
            } else {
                $dataatual = date("Y-m-d");
                $horaatual = date("H:i:s");
                $tempo1 = $data . "_" . $hora;
                $tempo2 = $dataatual . "_" . $horaatual;
                $total_segundos = diferenca_entre_datahora($tempo1, $tempo2);
                if ($total_segundos > 5400) {
                    $tpl->ICONE_ARQUIVO = $icones . "star_empty.png";
                    $tpl->OPERACAO_NOME = "Incompleta";
                } else {
                    $tpl->ICONE_ARQUIVO = $icones . "star_half_full.png";
                    $tpl->OPERACAO_NOME = "Esta venda está em andamento por outro vendedor!";
                    $editar_ocultar = 1;
                    $editar_ocultar_motivo = "";
                }
            }
        } else {
            $tpl->ICONE_ARQUIVO = $icones . "star_full.png";
            $tpl->OPERACAO_NOME = "Concluída";
        }
        $tpl->block("BLOCK_LISTA_COLUNA_ICONE");

        //Coluna Operações    
        $tpl->CODIGO = $numero;

        if ($permissao_saidas_ver == 1) {

            //detalhes
            $tpl->LINK = "saidas_ver.php";
            $tpl->LINK_COMPLEMENTO = "ope=3&tiposaida=1";
            $tpl->ICONE_ARQUIVO = $icones . "detalhes.png";
            $tpl->OPERACAO_NOME = "Detalhes";
            $tpl->block("BLOCK_LISTA_COLUNA_OPERACAO");
            $tpl->block("BLOCK_LISTA_COLUNA_OPERACAO_TODAS");
        }

        //Verifica se algum produto desta saida foi acertado
        $sql22 = "SELECT saipro_acertado FROM `saidas_produtos` WHERE saipro_saida=$numero and saipro_acertado !=0";
        $query22 = mysql_query($sql22);
        if (!$query22)
            die("Erro de SQL (22):" . mysql_error());
        $linhas22 = mysql_num_rows($query22);

        //Verifica se algum produto desta saida foi fechado
        $sql23 = "SELECT saipro_fechado FROM `saidas_produtos` WHERE saipro_saida=$numero and saipro_fechado !=0";
        $query23 = mysql_query($sql23);
        if (!$query23)
            die("Erro de SQL (23):" . mysql_error());
        $linhas23 = mysql_num_rows($query23);


        //editar        
        if ($permissao_saidas_editar == 1) {
            //Se algum produto ja foi acertado não pode editar
            if ($linhas22 > 0) {
                $tpl->OPERACAO_NOME = "Você não pode editar esta Saída porque algum produto desta venda já foi acertado com o fornecedor!";
                $tpl->ICONE_ARQUIVO = $icones . "editar_desabilitado.png";
                $tpl->block("BLOCK_LISTA_COLUNA_OPERACAO_DESABILITADO");
            } else if ($linhas23 > 0) {
                $tpl->OPERACAO_NOME = "Você não pode editar esta saída porque algum produto desta venda já foi fechado/acertado!";
                $tpl->ICONE_ARQUIVO = $icones . "editar_desabilitado.png";
                $tpl->block("BLOCK_LISTA_COLUNA_OPERACAO_DESABILITADO");
            } else {
                //Se for um vendedor deve permitir a edição de apenas a ultima venda realizada por ele sob algumas condições
                if ($usuario_grupo == 4) {
                    //Verifica qual foi a ultima venda realizada por este vendedor
                    $sql_ven = "SELECT max(sai_codigo) FROM saidas WHERE sai_vendedor=$usuario_codigo";
                    $query_ven = mysql_query($sql_ven);
                    if (!$query_ven)
                        die("Erro de SQL Vendedor Ultima Venda:" . mysql_error());
                    $dados_ven = mysql_fetch_array($query_ven);
                    $ultimo = $dados_ven[0];
                    //Se esta Sa�da for a ultima Saída que o vendedor efetuou                   
                    if ($numero == $ultimo) {
                        if ($status == 1) { //Se a venda ja foi concluída o vendedor tem um limite de tempo para pode editá-la
                            $dataatual = date("Y-m-d");
                            $horaatual = date("H:i:s");
                            $tempo1 = $data . "_" . $hora;
                            $tempo2 = $dataatual . "_" . $horaatual;
                            $total_segundos = diferenca_entre_datahora($tempo1, $tempo2);
                            if ($total_segundos < 900) { //O vendedor tem 15 minutos ap�s o inicio para editar esta venda j� concluida 
                                $tpl->OPERACAO_NOME = "Editar";
                                $tpl->LINK = "saidas_cadastrar.php";
                                $tpl->LINK_COMPLEMENTO = "operacao=2&tiposaida=1";
                                $tpl->ICONE_ARQUIVO = $icones . "editar.png";
                                $tpl->block("BLOCK_LISTA_COLUNA_OPERACAO");
                            } else {
                                $tpl->OPERACAO_NOME = "Você não pode editar sua última venda porque já passou 15 minutos após a finalização da venda!";
                                $tpl->ICONE_ARQUIVO = $icones . "editar_desabilitado.png";
                                $tpl->block("BLOCK_LISTA_COLUNA_OPERACAO_DESABILITADO");
                            }
                        } else { //Se for incompleta permitir que o vendedor possa continuar a venda
                            $tpl->OPERACAO_NOME = "Editar";
                            $tpl->LINK = "saidas_cadastrar.php";
                            $tpl->LINK_COMPLEMENTO = "operacao=2&tiposaida=1";
                            $tpl->ICONE_ARQUIVO = $icones . "editar.png";
                            $tpl->block("BLOCK_LISTA_COLUNA_OPERACAO");
                        }
                    } else {
                        $tpl->OPERACAO_NOME = "Você não pode editar vendas antigas! Se precisa alterar ou remover alguma venda, contate um supervisor!";
                        $tpl->ICONE_ARQUIVO = $icones . "editar_desabilitado.png";
                        $tpl->block("BLOCK_LISTA_COLUNA_OPERACAO_DESABILITADO");
                    }
                } else {
                    $tpl->OPERACAO_NOME = "Editar";
                    $tpl->LINK = "saidas_cadastrar.php";
                    $tpl->LINK_COMPLEMENTO = "operacao=2&tiposaida=1";
                    $tpl->ICONE_ARQUIVO = $icones . "editar.png";
                    $tpl->block("BLOCK_LISTA_COLUNA_OPERACAO");
                }
            }
        }
        $tpl->block("BLOCK_LISTA_COLUNA_OPERACAO_TODAS");


        $tpl->block("BLOCK_LISTA");
    }
}

if ($tipopagina == "saidas") {
    //Vendas
    if (($permissao_saidas_cadastrar == 1) && ($usuario_quiosque != 0)) {
        if ($usuario_grupo == 4) {
            //Verifica se há vendas incompletas, se sim então impedir de fazer novas vendas
            $sql8 = "
                SELECT sai_codigo 
                FROM saidas
                WHERE sai_tipo=1 
                and sai_vendedor=$usuario_codigo
                and sai_status=2
            ";
            $query8 = mysql_query($sql8);
            if (!$query8)
                die("Erro SQL Vendedor Incompletas Botão cadastrar" . mysql_error());
            $linhas8 = mysql_num_rows($query8);
            if ($linhas8 == 0) {
                $tpl->CADASTRAR_NOME = "REALIZAR VENDA";
                $tpl->LINK_CADASTRO = "saidas_cadastrar.php?tiposaida=1";
                $tpl->block("BLOCK_RODAPE_BOTOES");
            } else {
                $tpl->CADASTRAR_NOME = "REALIZAR VENDA";
                $tpl->block("BLOCK_RODAPE_BOTOES_DESABILITADOS");
                $tpl->DICA_NOME = "REALIZAR VENDA";
                $tpl->DICA = "Você precisa finalizar as vendas incompletas primeiro para pode retornar a realizar novas vendas!";
                $tpl->DICA_ARQUIVO = $icones . "recado.png";
                $tpl->block("BLOCK_RODAPE_BOTOES_DICA");
            }
        } else {
            $tpl->CADASTRAR_NOME = "REALIZAR VENDA";
            $tpl->LINK_CADASTRO = "saidas_cadastrar.php?tiposaida=1";
            $tpl->block("BLOCK_RODAPE_BOTOES");
        }
    }
}



$tpl->show();
include "rodape.php";
?>

<script type="text/javascript">
    $(document).ready(function() {
        //Ao entrar pela primeira vez na pagina j� verificar se o usu�rio tem acesso ao sistema ou n�o
        verifica_usuario ();      

    });
    
    function tipo_pessoa(valor) {
        if (valor==1) { //Pessoa Física
            $("tr[id=tr_categoria]").hide(); 
            $("select[name=categoria]").attr("required", false);            
            $("tr[id=tr_cnpj]").hide();            
            $("tr[id=tr_cnpj]").attr("required", false);
            $("tr[id=tr_pessoacontato]").hide(); 
            $("input[id=telefone1ramal]").hide(); 
            $("input[id=telefone2ramal]").hide(); 
            $("tr[id=tr_cpf]").attr("required", true);
            $("tr[id=tr_cpf]").show(); 
            $("span[id=span_administrador]").show(); 
            $("span[id=span_presidente]").show(); 
            $("span[id=span_supervisor]").show(); 
            $("span[id=span_vendedor]").show();             
        } else if (valor==2) { //Pessoa Jurídica
            //alert('2');
            $("tr[id=tr_categoria]").show(); 
            $("select[name=categoria]").attr("required", true);            
            $("tr[id=tr_cnpj]").show();            
            //$("input[name=cnpj]").attr("required", true);
            //$("input[name=cnpj]").required = true;
            $("tr[id=tr_pessoacontato]").show(); 
            $("input[id=telefone1ramal]").show(); 
            $("input[id=telefone2ramal]").show(); 
            $("tr[id=tr_cpf]").attr("required", false);
            $("tr[id=tr_cpf]").hide(); 
            $("span[id=span_administrador]").hide(); 
            $("span[id=span_presidente]").hide(); 
            $("span[id=span_supervisor]").hide(); 
            $("span[id=span_vendedor]").hide(); 
        } else {
            alert("Erro de envio de parametros para a função");
        }       
    }
    
    function aparece_tiponegociacao() {
        //alert("opa");
        var fornec= $("input[id=fornec]").val();
        if (document.form1.fornec.checked == true) {
            $("tr[id=tr_tiponegociacao]").show();
        }
        else
            $("tr[id=tr_tiponegociacao]").hide();       
    }
</script>
<style>
    .aparece {display: block;}
    .some {display: none;}
</style> 


<?php
//Verifica se o usuário tem permissão para acessar este conte�do
require "login_verifica.php";

$codigo = $_GET["codigo"];
$operacao = $_GET["operacao"];
if ($operacao == "cadastrar")
    $oper_num = 1;
if ($operacao == "editar")
    $oper_num = 2;
if ($operacao == "ver")
    $oper_num = 3;

//Se o usuario estiver alterando seu próprio cadastro passa
$cpf_desabilitado = 0;
if ($usuario_codigo != $codigo) {
    if ($operacao == "cadastrar") {
        if ($permissao_pessoas_cadastrar <> 1) {
            header("Location: permissoes_semacesso.php");
            exit;
        }
    }
    if ($operacao == "ver") {
        $sql = "SELECT mespestip_tipo FROM mestre_pessoas_tipo WHERE mespestip_pessoa=$codigo";
        $query = mysql_query($sql);
        if (!$query)
            die("Erro: 15" . mysql_error());
        while ($dados = mysql_fetch_assoc($query)) {
            $tipo = $dados["mespestip_tipo"];
            if (($tipo == 1) && ($permissao_pessoas_ver_administradores == 0)) {
                header("Location: permissoes_semacesso.php");
                exit;
            }
            if (($tipo == 2) && ($permissao_pessoas_ver_presidentes == 0)) {
                header("Location: permissoes_semacesso.php");
                exit;
            }
            if (($tipo == 3) && ($permissao_pessoas_ver_supervisores == 0)) {
                header("Location: permissoes_semacesso.php");
                exit;
            }
            if (($tipo == 4) && ($permissao_pessoas_ver_vendedores == 0)) {
                header("Location: permissoes_semacesso.php");
                exit;
            }
            if (($tipo == 5) && ($permissao_pessoas_ver_fornecedores == 0)) {
                header("Location: permissoes_semacesso.php");
                exit;
            }
            if (($tipo == 6) && ($permissao_pessoas_ver_consumidores == 0)) {
                header("Location: permissoes_semacesso.php");
                exit;
            }
        }
    }
} else {
    $cpf_desabilitado = 1;
}


$tipopagina = "pessoas";
include "includes.php";

//Verifica se alguma cooperativa cadastrada, se não tiver então o root deve cadastrar uma antes de cadastrar um administrador
$sql = "SELECT coo_codigo FROM cooperativas";
$query = mysql_query($sql);
if (!$query)
    die("Erro: " . mysql_error());
$linhas = mysql_num_rows($query);
if ($linhas == 0) {
    $tpl = new Template("templates/notificacao.html");
    $tpl->ICONES = $icones;
    $tpl->MOTIVO_COMPLEMENTO = "Você deve cadastrar uma cooperativas antes de cadastrar um administrador!";
    $tpl->block("BLOCK_ATENCAO");
    $tpl->DESTINO = "cooperativas_cadastrar.php?operacao=cadastrar";
    $tpl->block("BLOCK_BOTAO");
    $tpl->show();
    exit;
}


//Template de Título e Sub-título
$tpl_titulo = new Template("templates/titulos.html");
$tpl_titulo->TITULO = "PESSSOAS";
if ($operacao == 'ver')
    $tpl_titulo->SUBTITULO = "DETALHES";
if ($operacao == 'editar')
    $tpl_titulo->SUBTITULO = "EDIÇÃO";
if ($operacao == 'cadastrar')
    $tpl_titulo->SUBTITULO = "CADASTRO";

$tpl_titulo->ICONES_CAMINHO = "$icones";
$tpl_titulo->NOME_ARQUIVO_ICONE = "pessoas.png";
$tpl_titulo->show();

//Pega todos os dados da tabela (Necess�rio caso seja uma edi��o ou visuliza��o de detalhes)
if (($operacao == "editar") || ($operacao == 'ver')) {
    $sql = "SELECT * FROM pessoas WHERE pes_codigo='$codigo'";
    $query = mysql_query($sql);
    if (!$query)
        die("Erro: 4" . mysql_error());
    while ($array = mysql_fetch_array($query)) {
        $id = $array['pes_id'];
        $nome = $array['pes_nome'];
        $cpf = $array['pes_cpf'];
        $cidade = $array['pes_cidade'];
        $cep = $array['pes_cep'];
        $bairro = $array['pes_bairro'];
        $vila = $array['pes_vila'];
        $endereco = $array['pes_endereco'];
        $complemento = $array['pes_complemento'];
        $referencia = $array['pes_referencia'];
        $numero = $array['pes_numero'];
        $fone1 = $array['pes_fone1'];
        $fone2 = $array['pes_fone2'];
        $email = $array['pes_email'];
        $obs = $array['pes_obs'];
        $chat = $array['pes_chat'];
        $cooperativa = $array['pes_cooperativa'];
        $possiacesso = $array['pes_possuiacesso'];
        $senha = $array['pes_senha'];
        $grupopermissoes = $array['pes_grupopermissoes'];
        $quiosqueusuario = $array['pes_quiosqueusuario'];
        $cnpj = $array['pes_cnpj'];
        $ramal1 = $array['pes_fone1ramal'];
        $ramal2 = $array['pes_fone2ramal'];
        $tipopessoa = $array['pes_tipopessoa'];
        $pessoacontato = $array['pes_pessoacontato'];
        $categoria = $array['pes_categoria'];

        $sql = "SELECT * FROM cidades join estados on (cid_estado=est_codigo) WHERE cid_codigo='$cidade'";
        $query = mysql_query($sql);

        if (!$query)
            die("Erro: " . mysql_error());
        while ($dados = mysql_fetch_array($query)) {
            $estado = $dados["cid_estado"];
            $pais = $dados["est_pais"];
        }
    }
} else { //é um cadastro novo
    if ($pais == "")
        $pais = 1;
}


//Estrutura dos campos de cadastro
$tpl1 = new Template("templates/cadastro_edicao_detalhes_2.html");
$tpl1->LINK_DESTINO = "pessoas_cadastrar2.php";


$tpl1->JS_CAMINHO = "pessoas_cadastrar.js";
$tpl1->block("BLOCK_JS");

$tpl1->ONLOAD = "verifica_usuario($tipopessoa)";

//ID
$tpl1->TITULO = "ID";
$tpl1->block("BLOCK_TITULO");
$tpl1->CAMPO_QTD_CARACTERES = "";
$tpl1->CAMPO_TIPO = "number";
$tpl1->CAMPO_NOME = "id";
$tpl1->CAMPO_DICA = "";
$tpl1->CAMPO_ID = "id";
$tpl1->CAMPO_TAMANHO = "10";
if ($id == "") {
    $sql2 = "SELECT MAX(pes_id) as id FROM pessoas";
    $query2 = mysql_query($sql2);
    if (!$query2)
        die("Erro1:" . mysql_error());
    $dados2 = mysql_fetch_assoc($query2);
    $id = $dados2['id'] + 1;
}
$tpl1->CAMPO_VALOR = $id;
$tpl1->CAMPO_QTD_CARACTERES = 9;
$tpl1->block("BLOCK_CAMPO_AUTOSELECIONAR");
$tpl1->block("BLOCK_CAMPO_NORMAL");
$tpl1->block("BLOCK_CAMPO_FOCO");
$tpl1->block("BLOCK_CAMPO_OBRIGATORIO");
IF ($operacao == 'ver')
    $tpl1->block("BLOCK_CAMPO_DESABILITADO");
$tpl1->block("BLOCK_CAMPO");
$tpl1->block("BLOCK_CONTEUDO");
$tpl1->block("BLOCK_ITEM");

//Tipo de pessoa
$tpl1->TITULO = "Tipo Pessoa";
$tpl1->block("BLOCK_TITULO");
if (($operacao == 'ver') || ($operacao == 'editar')) {
    $tpl1->SELECT_NOME = "tipopessoa2";
    $tpl1->SELECT_ID = "tipopessoa2";
    $tpl1->block("BLOCK_SELECT_DESABILITADO");
    $tpl1->CAMPOOCULTO_NOME = "tipopessoa";
    $tpl1->CAMPOOCULTO_VALOR = "$tipopessoa";
    $tpl1->block("BLOCK_CAMPOSOCULTOS");
} else {
    $tpl1->SELECT_NOME = "tipopessoa";
    $tpl1->SELECT_ID = "tipopessoa";
}
$tpl1->SELECT_TAMANHO = "";
$tpl1->SELECT_ONCHANGE = "tipo_pessoa(this.value);";
$tpl1->block("BLOCK_SELECT_ONCHANGE");
$tpl1->block("BLOCK_SELECT_OBRIGATORIO");

$sql = "SELECT pestippes_codigo,pestippes_nome FROM pessoas_tipopessoa ORDER BY pestippes_nome";
$query = mysql_query($sql);
if (!$query)
    die("Erro: 0" . mysql_error());
while ($dados = mysql_fetch_array($query)) {
    $tpl1->OPTION_VALOR = $dados[0];
    $tpl1->OPTION_NOME = $dados[1];
    if ($dados[0] == $tipopessoa)
        $tpl1->block("BLOCK_SELECT_OPTION_SELECIONADO");
    $tpl1->block("BLOCK_SELECT_OPTION");
}
$tpl1->block("BLOCK_SELECT");
$tpl1->block("BLOCK_CONTEUDO");
$tpl1->block("BLOCK_ITEM");

//Categoria
$tpl1->TITULO = "Categoria";
$tpl1->block("BLOCK_TITULO");
$tpl1->SELECT_NOME = "categoria";
$tpl1->SELECT_ID = "categoria";
$tpl1->SELECT_TAMANHO = "";
//$tpl1->SELECT_ONCHANGE = "";
//$tpl1->block("BLOCK_SELECT_ONCHANGE");
$sql = "SELECT pescat_codigo,pescat_nome FROM pessoas_categoria ORDER BY pescat_nome";
$query = mysql_query($sql);
if (!$query)
    die("Erro: 0" . mysql_error());
$tpl1->block("BLOCK_SELECT_OPTION_PADRAO");
while ($dados = mysql_fetch_array($query)) {
    $tpl1->OPTION_VALOR = $dados[0];
    $tpl1->OPTION_NOME = $dados[1];
    if ($dados[0] == $categoria)
        $tpl1->block("BLOCK_SELECT_OPTION_SELECIONADO");
    $tpl1->block("BLOCK_SELECT_OPTION");
}
if ($operacao == 'ver')
    $tpl1->block("BLOCK_SELECT_DESABILITADO");
if (($tipopessoa == 1) || ($codigo == "")) {
    $tpl1->block("BLOCK_SELECT_NORMAL");
    $tpl1->LINHA_CLASSE = "some";
} else {
    $tpl1->LINHA_CLASSE = "";
    $tpl1->block("BLOCK_SELECT_OBRIGATORIO");
}
$tpl1->block("BLOCK_LINHA_CLASSE");
$tpl1->LINHA_ID = "tr_categoria";
$tpl1->block("BLOCK_LINHA_ID");
$tpl1->block("BLOCK_SELECT");
$tpl1->block("BLOCK_CONTEUDO");
$tpl1->block("BLOCK_ITEM");


//Nome 
$tpl1->TITULO = "Nome";
$tpl1->block("BLOCK_TITULO");
$tpl1->CAMPO_QTD_CARACTERES = "";
$tpl1->CAMPO_TIPO = "text";
$tpl1->CAMPO_NOME = "nome";
$tpl1->CAMPO_DICA = "";
$tpl1->CAMPO_ID = "capitalizar";
$tpl1->CAMPO_ONKEYPRESS = "";
$tpl1->CAMPO_ONCLICK = "";
$tpl1->CAMPO_TAMANHO = "35";
$tpl1->CAMPO_VALOR = $nome;
$tpl1->CAMPO_QTD_CARACTERES = 70;
$tpl1->block("BLOCK_CAMPO_AUTOSELECIONAR");
$tpl1->block("BLOCK_CAMPO_NORMAL");
//$tpl1->block("BLOCK_CAMPO_DESABILITADO");
$tpl1->block("BLOCK_CAMPO_FOCO");
$tpl1->block("BLOCK_CAMPO_OBRIGATORIO");
IF ($operacao == 'ver')
    $tpl1->block("BLOCK_CAMPO_DESABILITADO");
$tpl1->block("BLOCK_CAMPO");
$tpl1->block("BLOCK_CONTEUDO");
$tpl1->block("BLOCK_ITEM");

//CPF
$tpl1->TITULO = "CPF";
$tpl1->block("BLOCK_TITULO");
$tpl1->CAMPO_QTD_CARACTERES = "";
$tpl1->CAMPO_TIPO = "text";
$tpl1->CAMPO_NOME = "cpf";
$tpl1->CAMPO_DICA = "";
$tpl1->CAMPO_ID = "cpf";
$tpl1->CAMPO_ONKEYPRESS = "return submitenter(this,event)";
if ($codigo == "")
    $cod = 0;
else
    $cod = $codigo;
$tpl1->CAMPO_ONBLUR = "valida_cpf(this.value); verifica_cpf_cadastro(this.value,1,$cod,$oper_num);";
$tpl1->CAMPO_ONCLICK = "this.select();";
$tpl1->block("BLOCK_CAMPO_ONBLUR");
$tpl1->CAMPO_TAMANHO = "14";
$tpl1->CAMPO_VALOR = $cpf;
$tpl1->CAMPO_QTD_CARACTERES = 14;
$tpl1->block("BLOCK_CAMPO_AUTOSELECIONAR");
$tpl1->block("BLOCK_CAMPO_NORMAL");
if ($cpf_desabilitado == 1) {
    $tpl1->block("BLOCK_CAMPO_DESABILITADO");
    //$tpl1->block("BLOCK_CAMPO_SOMENTELEITURA");
    $tpl1->CAMPOOCULTO_NOME = "cpf";
    $tpl1->CAMPOOCULTO_VALOR = "$cpf";
    $tpl1->block("BLOCK_CAMPOSOCULTOS");
}
//$tpl1->block("BLOCK_CAMPO_OBRIGATORIO");
IF ($operacao == 'ver')
    $tpl1->block("BLOCK_CAMPO_DESABILITADO");
$tpl1->block("BLOCK_CAMPO");
$tpl1->block("BLOCK_CONTEUDO");
if ($tipopessoa == 2)
    $tpl1->LINHA_CLASSE = "some";
else
    $tpl1->LINHA_CLASSE = "";
$tpl1->block("BLOCK_LINHA_CLASSE");
$tpl1->LINHA_ID = "tr_cpf";
$tpl1->block("BLOCK_LINHA_ID");
$tpl1->block("BLOCK_ITEM");

//CNPJ
$tpl1->TITULO = "CNPJ";
$tpl1->block("BLOCK_TITULO");
$tpl1->CAMPO_QTD_CARACTERES = "";
$tpl1->CAMPO_TIPO = "text";
$tpl1->CAMPO_NOME = "cnpj";
$tpl1->CAMPO_DICA = "";
$tpl1->CAMPO_ID = "cnpj";
$tpl1->CAMPO_ONKEYPRESS = "return submitenter(this,event)";
if ($codigo == "")
    $cod = 0;
else
    $cod = $codigo;
$tpl1->CAMPO_ONBLUR = "valida_cnpj(this.value); verifica_cnpj_cadastro(this.value,$cod,$oper_num);";
$tpl1->CAMPO_ONCLICK = "this.select();";
$tpl1->block("BLOCK_CAMPO_ONBLUR");
$tpl1->CAMPO_TAMANHO = "14";
$tpl1->CAMPO_VALOR = $cnpj;
$tpl1->CAMPO_QTD_CARACTERES = 18;
$tpl1->block("BLOCK_CAMPO_AUTOSELECIONAR");
$tpl1->block("BLOCK_CAMPO_NORMAL");
if ($cnpj_desabilitado == 1) {
    $tpl1->block("BLOCK_CAMPO_DESABILITADO");
    //$tpl1->block("BLOCK_CAMPO_SOMENTELEITURA");
    $tpl1->CAMPOOCULTO_NOME = "cnpj";
    $tpl1->CAMPOOCULTO_VALOR = "$cnpj";
    $tpl1->block("BLOCK_CAMPOSOCULTOS");
}
//$tpl1->block("BLOCK_CAMPO_OBRIGATORIO");
IF ($operacao == 'ver')
    $tpl1->block("BLOCK_CAMPO_DESABILITADO");
$tpl1->block("BLOCK_CAMPO");
$tpl1->block("BLOCK_CONTEUDO");
if (($tipopessoa == 1) || ($codigo == ""))
    $tpl1->LINHA_CLASSE = "some";
else
    $tpl1->LINHA_CLASSE = "";
$tpl1->block("BLOCK_LINHA_CLASSE");
$tpl1->LINHA_ID = "tr_cnpj";
$tpl1->block("BLOCK_LINHA_ID");
$tpl1->block("BLOCK_ITEM");

//Pais
$tpl1->TITULO = "Pais";
$tpl1->block("BLOCK_TITULO");
$tpl1->SELECT_NOME = "pais";
$tpl1->CAMPO_DICA = "";
$tpl1->SELECT_ID = "pais";
$tpl1->SELECT_TAMANHO = "";
$tpl1->SELECT_ONCHANGE = "popula_estados();";
$tpl1->block("BLOCK_SELECT_ONCHANGE");
$tpl1->block("BLOCK_SELECT_OBRIGATORIO");
$tpl1->block("BLOCK_SELECT_OPTION_PADRAO");
$sql = "
SELECT DISTINCT
    pai_codigo,pai_nome
FROM
    paises
    join estados on (est_pais=pai_codigo)
    join cidades on (cid_estado=est_codigo)
ORDER BY
    pai_nome";
$query = mysql_query($sql);
if (!$query)
    die("Erro: 5" . mysql_error());

while ($dados = mysql_fetch_assoc($query)) {
    $tpl1->OPTION_VALOR = $dados["pai_codigo"];
    $tpl1->OPTION_NOME = $dados["pai_nome"];
    if ($pais == $dados["pai_codigo"]) {
        $tpl1->block("BLOCK_SELECT_OPTION_SELECIONADO");
    }
    $tpl1->block("BLOCK_SELECT_OPTION");
}
if ($operacao == 'ver')
    $tpl1->block("BLOCK_SELECT_DESABILITADO");
$tpl1->block("BLOCK_SELECT");
$tpl1->block("BLOCK_CONTEUDO");
$tpl1->block("BLOCK_ITEM");

//Estado
$tpl1->TITULO = "Estado";
$tpl1->block("BLOCK_TITULO");
$tpl1->SELECT_NOME = "estado";
$tpl1->SELECT_ID = "estado";
$tpl1->SELECT_TAMANHO = "";
$tpl1->SELECT_ONCHANGE = "popula_cidades();";
$tpl1->block("BLOCK_SELECT_ONCHANGE");
$tpl1->block("BLOCK_SELECT_OBRIGATORIO");
$tpl1->block("BLOCK_SELECT_OPTION_PADRAO");
//Se a operação for editar então mostrar os options, e o option em questão selecionado
if (($operacao == "editar") || ($operacao == "ver") || ($pais != "")) {
    $sql = "  SELECT DISTINCT
        est_codigo,est_nome,est_sigla
    FROM
        estados
        join paises on (est_pais=pai_codigo)
        join cidades on (cid_estado=est_codigo)
    WHERE
        est_pais=$pais
    ORDER BY
        est_nome";
    $query = mysql_query($sql);
    if (!$query)
        die("Erro: 6" . mysql_error());
    while ($dados = mysql_fetch_assoc($query)) {
        $tpl1->OPTION_VALOR = $dados["est_codigo"];
        $tpl1->OPTION_NOME = $dados["est_sigla"];
        if ($estado == "") {
            if ($usuario_estado == $dados["est_codigo"]) {
                $tpl1->block("BLOCK_SELECT_OPTION_SELECIONADO");
                $estado = $usuario_estado;
            }
        } else {
            if ($estado == $dados["est_codigo"])
                $tpl1->block("BLOCK_SELECT_OPTION_SELECIONADO");
        }
        $tpl1->block("BLOCK_SELECT_OPTION");
    }
}
if ($operacao == 'ver')
    $tpl1->block("BLOCK_SELECT_DESABILITADO");
$tpl1->block("BLOCK_SELECT");
$tpl1->block("BLOCK_CONTEUDO");
$tpl1->block("BLOCK_ITEM");

//Cidade
$tpl1->TITULO = "Cidade";
$tpl1->block("BLOCK_TITULO");
$tpl1->SELECT_NOME = "cidade";
$tpl1->SELECT_ID = "cidade";
$tpl1->SELECT_TAMANHO = "";
$tpl1->block("BLOCK_SELECT_OBRIGATORIO");
$tpl1->block("BLOCK_SELECT_OPTION_PADRAO");
//Se a opera��o for editar ent�o mostrar os options, e o option em quest�o selecionado
if (($operacao == "editar") || ($operacao == "ver") || ($estado != "")) {
    $sql = "  SELECT DISTINCT
        cid_codigo,cid_nome
    FROM
        cidades 
        join estados on (cid_estado=est_codigo)
        join paises on (est_pais=pai_codigo)
    WHERE
        cid_estado=$estado
    ORDER BY
        cid_nome";
    $query = mysql_query($sql);
    if (!$query)
        die("Erro: 7" . mysql_error());
    while ($dados = mysql_fetch_assoc($query)) {
        $tpl1->OPTION_VALOR = $dados["cid_codigo"];
        $tpl1->OPTION_NOME = $dados["cid_nome"];
        if ($cidade == $dados["cid_codigo"]) {
            $tpl1->block("BLOCK_SELECT_OPTION_SELECIONADO");
        }
        $tpl1->block("BLOCK_SELECT_OPTION");
    }
}
if ($operacao == 'ver')
    $tpl1->block("BLOCK_SELECT_DESABILITADO");
$tpl1->block("BLOCK_SELECT");
$tpl1->block("BLOCK_CONTEUDO");
$tpl1->block("BLOCK_ITEM");

//Vila
$tpl1->TITULO = "Vila";
$tpl1->block("BLOCK_TITULO");
$tpl1->CAMPO_TIPO = "text";
$tpl1->CAMPO_QTD_CARACTERES = "";
$tpl1->CAMPO_NOME = "vila";
$tpl1->CAMPO_ONCLICK = "";
$tpl1->CAMPO_DICA = "";
$tpl1->CAMPO_ID = "";
$tpl1->CAMPO_TAMANHO = "30";
$tpl1->CAMPO_VALOR = $vila;
$tpl1->CAMPO_QTD_CARACTERES = 70;
$tpl1->block("BLOCK_CAMPO_AUTOSELECIONAR");
$tpl1->block("BLOCK_CAMPO_NORMAL");
IF ($operacao == 'ver')
    $tpl1->block("BLOCK_CAMPO_DESABILITADO");
$tpl1->block("BLOCK_CAMPO");
$tpl1->block("BLOCK_CONTEUDO");
$tpl1->block("BLOCK_ITEM");

//Bairro
$tpl1->TITULO = "Bairro";
$tpl1->block("BLOCK_TITULO");
$tpl1->CAMPO_TIPO = "text";
$tpl1->CAMPO_QTD_CARACTERES = "";
$tpl1->CAMPO_NOME = "bairro";
$tpl1->CAMPO_DICA = "";
$tpl1->CAMPO_ONCLICK = "";
$tpl1->CAMPO_ID = "";
$tpl1->CAMPO_TAMANHO = "35";
$tpl1->CAMPO_VALOR = $bairro;
$tpl1->CAMPO_QTD_CARACTERES = 70;
$tpl1->block("BLOCK_CAMPO_AUTOSELECIONAR");
$tpl1->block("BLOCK_CAMPO_NORMAL");
IF ($operacao == 'ver')
    $tpl1->block("BLOCK_CAMPO_DESABILITADO");
$tpl1->block("BLOCK_CAMPO");
$tpl1->block("BLOCK_CONTEUDO");
$tpl1->block("BLOCK_ITEM");

//Endereç�o
$tpl1->TITULO = "Endereço";
$tpl1->block("BLOCK_TITULO");
$tpl1->CAMPO_TIPO = "text";
$tpl1->CAMPO_QTD_CARACTERES = "";
$tpl1->CAMPO_NOME = "endereco";
$tpl1->CAMPO_DICA = "";
$tpl1->CAMPO_ONCLICK = "";
$tpl1->CAMPO_ID = "";
$tpl1->CAMPO_TAMANHO = "45";
$tpl1->CAMPO_VALOR = $endereco;
$tpl1->CAMPO_QTD_CARACTERES = 70;
$tpl1->block("BLOCK_CAMPO_AUTOSELECIONAR");
$tpl1->block("BLOCK_CAMPO_NORMAL");
if ($operacao == 'ver')
    $tpl1->block("BLOCK_CAMPO_DESABILITADO");
$tpl1->block("BLOCK_CAMPO");
$tpl1->block("BLOCK_CONTEUDO");
$tpl1->CAMPO_QTD_CARACTERES = "";
$tpl1->CAMPO_NOME = "numero";
$tpl1->CAMPO_TIPO = "number";
$tpl1->CAMPO_ID = "";
$tpl1->CAMPO_TAMANHO = "5";
$tpl1->CAMPO_VALOR = $numero;
$tpl1->CAMPO_DICA = "Nº";
$tpl1->CAMPO_QTD_CARACTERES = 11;
$tpl1->block("BLOCK_CAMPO_AUTOSELECIONAR");
$tpl1->block("BLOCK_CAMPO_NORMAL");
if ($operacao == 'ver')
    $tpl1->block("BLOCK_CAMPO_DESABILITADO");
$tpl1->block("BLOCK_CAMPO");
$tpl1->block("BLOCK_CONTEUDO");
$tpl1->block("BLOCK_ITEM");

//Complemento do Endere�o
$tpl1->TITULO = "Complemento";
$tpl1->block("BLOCK_TITULO");
$tpl1->CAMPO_TIPO = "text";
$tpl1->CAMPO_QTD_CARACTERES = "";
$tpl1->CAMPO_NOME = "complemento";
$tpl1->CAMPO_DICA = "";
$tpl1->CAMPO_ID = "";
$tpl1->CAMPO_ONCLICK = "";
$tpl1->CAMPO_TAMANHO = "30";
$tpl1->CAMPO_VALOR = $complemento;
$tpl1->CAMPO_QTD_CARACTERES = 70;
$tpl1->block("BLOCK_CAMPO_AUTOSELECIONAR");
$tpl1->block("BLOCK_CAMPO_NORMAL");
IF ($operacao == 'ver')
    $tpl1->block("BLOCK_CAMPO_DESABILITADO");
$tpl1->block("BLOCK_CAMPO");
$tpl1->block("BLOCK_CONTEUDO");
$tpl1->block("BLOCK_ITEM");

//Referência do Endere�o
$tpl1->TITULO = "Referência";
$tpl1->block("BLOCK_TITULO");
$tpl1->CAMPO_TIPO = "text";
$tpl1->CAMPO_QTD_CARACTERES = "";
$tpl1->CAMPO_NOME = "referencia";
$tpl1->CAMPO_DICA = "";
$tpl1->CAMPO_ONCLICK = "";
$tpl1->CAMPO_ID = "";
$tpl1->CAMPO_TAMANHO = "50";
$tpl1->CAMPO_VALOR = $referencia;
$tpl1->CAMPO_QTD_CARACTERES = 70;
$tpl1->block("BLOCK_CAMPO_AUTOSELECIONAR");
$tpl1->block("BLOCK_CAMPO_NORMAL");
IF ($operacao == 'ver')
    $tpl1->block("BLOCK_CAMPO_DESABILITADO");
$tpl1->block("BLOCK_CAMPO");
$tpl1->block("BLOCK_CONTEUDO");
$tpl1->block("BLOCK_ITEM");

//CEP
$tpl1->TITULO = "CEP";
$tpl1->block("BLOCK_TITULO");
$tpl1->CAMPO_TIPO = "text";
$tpl1->CAMPO_QTD_CARACTERES = "";
$tpl1->CAMPO_NOME = "cep";
$tpl1->CAMPO_DICA = "";
$tpl1->CAMPO_ID = "cep";
$tpl1->CAMPO_ONCLICK = "";
$tpl1->CAMPO_TAMANHO = "9";
$tpl1->CAMPO_VALOR = $cep;
$tpl1->CAMPO_QTD_CARACTERES = 9;
$tpl1->block("BLOCK_CAMPO_NORMAL");
IF ($operacao == 'ver')
    $tpl1->block("BLOCK_CAMPO_DESABILITADO");
$tpl1->block("BLOCK_CAMPO");
$tpl1->block("BLOCK_CONTEUDO");
$tpl1->block("BLOCK_ITEM");

//Telefone 01
$tpl1->TITULO = "Telefone 01";
$tpl1->block("BLOCK_TITULO");
$tpl1->CAMPO_TIPO = "text";
$tpl1->CAMPO_QTD_CARACTERES = "";
$tpl1->CAMPO_DICA = "";
$tpl1->CAMPO_ONCLICK = "";
$tpl1->CAMPO_NOME = "fone1";
$tpl1->CAMPO_ID = "telefone1";
$tpl1->CAMPO_TAMANHO = "15";
$tpl1->CAMPO_VALOR = $fone1;
$tpl1->CAMPO_QTD_CARACTERES = 15;
$tpl1->block("BLOCK_CAMPO_NORMAL");
IF ($operacao == 'ver')
    $tpl1->block("BLOCK_CAMPO_DESABILITADO");
$tpl1->block("BLOCK_CAMPO");
$tpl1->block("BLOCK_CONTEUDO");
$tpl1->CAMPO_TIPO = "text";
$tpl1->CAMPO_QTD_CARACTERES = "";
$tpl1->CAMPO_DICA = "Ramal";
$tpl1->CAMPO_ONCLICK = "";
$tpl1->CAMPO_NOME = "fone1ramal";
$tpl1->CAMPO_ID = "telefone1ramal";
$tpl1->CAMPO_TAMANHO = "9";
$tpl1->CAMPO_VALOR = $ramal1;
$tpl1->CAMPO_QTD_CARACTERES = 9;
if ($tipopessoa == 1)
    $tpl1->block("BLOCK_CAMPO_NORMAL_OCULTO");
else
    $tpl1->block("BLOCK_CAMPO_NORMAL");
IF ($operacao == 'ver')
    $tpl1->block("BLOCK_CAMPO_DESABILITADO");
$tpl1->block("BLOCK_CAMPO");
$tpl1->block("BLOCK_CONTEUDO");
$tpl1->block("BLOCK_ITEM");

//Telefone 02
$tpl1->TITULO = "Telefone 02";
$tpl1->block("BLOCK_TITULO");
$tpl1->CAMPO_TIPO = "text";
$tpl1->CAMPO_QTD_CARACTERES = "";
$tpl1->CAMPO_DICA = "";
$tpl1->CAMPO_ONCLICK = "";
$tpl1->CAMPO_NOME = "fone2";
$tpl1->CAMPO_ID = "telefone2";
$tpl1->CAMPO_TAMANHO = "15";
$tpl1->CAMPO_VALOR = $fone2;
$tpl1->CAMPO_QTD_CARACTERES = 15;
$tpl1->block("BLOCK_CAMPO_NORMAL");
IF ($operacao == 'ver')
    $tpl1->block("BLOCK_CAMPO_DESABILITADO");
$tpl1->block("BLOCK_CAMPO");
$tpl1->block("BLOCK_CONTEUDO");
$tpl1->CAMPO_TIPO = "text";
$tpl1->CAMPO_QTD_CARACTERES = "";
$tpl1->CAMPO_DICA = "Ramal";
$tpl1->CAMPO_ONCLICK = "";
$tpl1->CAMPO_NOME = "fone2ramal";
$tpl1->CAMPO_ID = "telefone2ramal";
$tpl1->CAMPO_TAMANHO = "9";
$tpl1->CAMPO_VALOR = $ramal2;
$tpl1->CAMPO_QTD_CARACTERES = 9;
if ($tipopessoa == 1)
    $tpl1->block("BLOCK_CAMPO_NORMAL_OCULTO");
else
    $tpl1->block("BLOCK_CAMPO_NORMAL");
IF ($operacao == 'ver')
    $tpl1->block("BLOCK_CAMPO_DESABILITADO");
$tpl1->block("BLOCK_CAMPO");
$tpl1->block("BLOCK_CONTEUDO");
$tpl1->block("BLOCK_ITEM");

//Pessoa para contato
$tpl1->TITULO = "Pessoa para contato";
$tpl1->block("BLOCK_TITULO");
$tpl1->CAMPO_TIPO = "text";
$tpl1->CAMPO_QTD_CARACTERES = "";
$tpl1->CAMPO_NOME = "pessoacontato";
$tpl1->CAMPO_DICA = "";
$tpl1->CAMPO_ONCLICK = "";
$tpl1->CAMPO_ID = "";
$tpl1->CAMPO_TAMANHO = "30";
$tpl1->CAMPO_VALOR = $pessoacontato;
$tpl1->CAMPO_QTD_CARACTERES = 70;
$tpl1->block("BLOCK_CAMPO_AUTOSELECIONAR");
$tpl1->block("BLOCK_CAMPO_NORMAL");
if ($operacao == 'ver')
    $tpl1->block("BLOCK_CAMPO_DESABILITADO");
$tpl1->block("BLOCK_CAMPO");
$tpl1->block("BLOCK_CONTEUDO");
if (($tipopessoa == 1) || ($codigo == ""))
    $tpl1->LINHA_CLASSE = "some";
else
    $tpl1->LINHA_CLASSE = "";
$tpl1->block("BLOCK_LINHA_CLASSE");
$tpl1->LINHA_ID = "tr_pessoacontato";
$tpl1->block("BLOCK_LINHA_ID");
$tpl1->block("BLOCK_ITEM");



//E-mail
$tpl1->TITULO = "E-mail";
$tpl1->block("BLOCK_TITULO");
$tpl1->CAMPO_TIPO = "email";
$tpl1->CAMPO_QTD_CARACTERES = "";
$tpl1->CAMPO_NOME = "email";
$tpl1->CAMPO_DICA = "";
$tpl1->CAMPO_ONCLICK = "";
$tpl1->CAMPO_ID = "";
$tpl1->CAMPO_TAMANHO = "40";
$tpl1->CAMPO_VALOR = $email;
$tpl1->CAMPO_QTD_CARACTERES = 70;
$tpl1->block("BLOCK_CAMPO_AUTOSELECIONAR");
$tpl1->block("BLOCK_CAMPO_NORMAL");
IF ($operacao == 'ver')
    $tpl1->block("BLOCK_CAMPO_DESABILITADO");
$tpl1->block("BLOCK_CAMPO");
$tpl1->block("BLOCK_CONTEUDO");
$tpl1->block("BLOCK_ITEM");

//Chat
$tpl1->TITULO = "Chat";
$tpl1->block("BLOCK_TITULO");
$tpl1->CAMPO_TIPO = "text";
$tpl1->CAMPO_QTD_CARACTERES = "";
$tpl1->CAMPO_NOME = "chat";
$tpl1->CAMPO_DICA = "";
$tpl1->CAMPO_ONCLICK = "";
$tpl1->CAMPO_ID = "";
$tpl1->CAMPO_TAMANHO = "40";
$tpl1->CAMPO_VALOR = $chat;
$tpl1->CAMPO_QTD_CARACTERES = 70;
$tpl1->block("BLOCK_CAMPO_AUTOSELECIONAR");
$tpl1->block("BLOCK_CAMPO_NORMAL");
if ($operacao == 'ver')
    $tpl1->block("BLOCK_CAMPO_DESABILITADO");
$tpl1->block("BLOCK_CAMPO");
$tpl1->block("BLOCK_CONTEUDO");
$tpl1->block("BLOCK_ITEM");

//Tipo
$tpl1->TITULO = "Tipo";
$tipo_administrador = 0;
$tipo_presidente = 0;
$tipo_supervisor = 0;
$tipo_vendedor = 0;
$tipo_fornecedor = 0;
$tipo_consumidor = 0;
if (($operacao == "editar") || ($operacao == "ver")) {
    $sql = "SELECT * FROM mestre_pessoas_tipo WHERE mespestip_pessoa=$codigo";
    $query = mysql_query($sql);
    if (!$query)
        die("Erro: 8" . mysql_error());
    while ($dados = mysql_fetch_assoc($query)) {
        $tipo = $dados["mespestip_tipo"];
        if ($tipo == 1)
            $tipo_administrador = 1;
        if ($tipo == 2)
            $tipo_presidente = 1;
        if ($tipo == 3)
            $tipo_supervisor = 1;
        if ($tipo == 4)
            $tipo_vendedor = 1;
        if ($tipo == 5)
            $tipo_fornecedor = 1;
        if ($tipo == 6)
            $tipo_consumidor = 1;
    }
} else {
    $tipo_consumidor = 1;
}
//Se o usu�rio est� editando seu pr�prio cadastro ent�o ele n�o pode escolher o Tipo
if ($usuario_codigo != $codigo) {

    //Tipo Administrador
    if (($permissao_pessoas_cadastrar_administradores == 1) || (($permissao_pessoas_ver_administradores == 1) && ($operacao = 'ver'))) {
        $tpl1->CHECKBOX_NOME = "box[0]";
        $tpl1->CAMPO_ID = "admin";
        $tpl1->CHECKBOX_VALOR = "1";
        $tpl1->LABEL_NOME = "Administrador";
        if ($tipo_administrador == 1)
            $tpl1->block("BLOCK_CHECKBOX_SELECIONADO");
        if ($operacao == 'ver')
            $tpl1->block("BLOCK_CHECKBOX_DESABILITADO");
        $tpl1->CHECKBOX_SPAN_CLASSE = "";
        $tpl1->CHECKBOX_SPAN_ID = "span_administrador";
        $tpl1->block("BLOCK_CHECKBOX");
    }

    //Tipo Presidente
    if (($permissao_pessoas_cadastrar_presidentes == 1) || (($permissao_pessoas_ver_presidentes == 1) && ($operacao = 'ver'))) {
        $tpl1->CHECKBOX_NOME = "box[1]";
        $tpl1->CHECKBOX_ID = "presid";
        $tpl1->CHECKBOX_VALOR = "2";
        $tpl1->LABEL_NOME = "Presidente";
        if ($tipo_presidente == 1) {
            $tpl1->block("BLOCK_CHECKBOX_SELECIONADO");
        }
        //Se for edi��o de pessoa
        if ($operacao == "editar") {
            //Verifica se a pessoa em quest�o � presidente de alguma cooperativa, se sim ent�o desabilitar esse check
            $sql2 = "SELECT * FROM cooperativas WHERE coo_presidente=$codigo";
            $query2 = mysql_query($sql2);
            if (!$query2)
                die("Erro: 1" . mysql_error());
            $total2 = mysql_num_rows($query2);
            if ($total2 > 0) {
                $tpl1->block("BLOCK_CHECKBOX_DESABILITADO");
                $tpl1->CHECKBOX_ICONE_ARQUIVO = "../imagens/icones/geral/info.png";
                $tpl1->CHECKBOX_ICONE_MENSAGEM = "Você não pode desmarcar esta opção porque esta pessoa atualmente é presidente de alguma cooperativa. Contate os administradores para saber mais!";
                $tpl1->block("BLOCK_CHECKBOX_ICONE");
                //Chama o campo oculto caso o checkbox fique desabilitado
                $tpl1->CAMPOOCULTO_NOME = "box[1]";
                $tpl1->CAMPOOCULTO_VALOR = "2";
                $tpl1->block("BLOCK_CAMPOSOCULTOS");
            }
        }
        if ($operacao == 'ver')
            $tpl1->block("BLOCK_CHECKBOX_DESABILITADO");
        if ($tipopessoa == 2) {
            $tpl1->CHECKBOX_SPAN_CLASSE = "some";
        } else {
            $tpl1->CHECKBOX_SPAN_CLASSE = "";
        }
        $tpl1->CHECKBOX_SPAN_ID = "span_presidente";
        $tpl1->block("BLOCK_CHECKBOX");
    }

    //Tipo Supervisor
    if (($permissao_pessoas_cadastrar_supervisores == 1) || (($permissao_pessoas_ver_supervisores == 1) && ($operacao = 'ver'))) {
        $tpl1->CHECKBOX_NOME = "box[2]";
        $tpl1->CHECKBOX_ID = "super";
        $tpl1->CHECKBOX_VALOR = "3";
        $tpl1->LABEL_NOME = "Supervisor";
        if ($tipo_supervisor == 1)
            $tpl1->block("BLOCK_CHECKBOX_SELECIONADO");
        //Se for edi��o de pessoa
        if ($operacao == "editar") {
            //Verifica se a pessoa em quest�o � supervisor de algum quiosque, se sim ent�o desabilitar esse check
            $sql2 = "SELECT * FROM quiosques_supervisores WHERE quisup_supervisor=$codigo";
            $query2 = mysql_query($sql2);
            if (!$query2)
                die("Erro: 1" . mysql_error());
            $total2 = mysql_num_rows($query2);
            if ($total2 > 0) {
                $tpl1->block("BLOCK_CHECKBOX_DESABILITADO");
                $tpl1->CHECKBOX_ICONE_ARQUIVO = "../imagens/icones/geral/info.png";
                $tpl1->CHECKBOX_ICONE_MENSAGEM = "Você não pode desmarcar esta opção porque esta pessoa atualmente é supervisora de algum quiosque. ";
                $tpl1->block("BLOCK_CHECKBOX_ICONE");
                //Chama o campo oculto caso o checkbox fique desabilitado
                $tpl1->CAMPOOCULTO_NOME = "box[2]";
                $tpl1->CAMPOOCULTO_VALOR = "3";
                $tpl1->block("BLOCK_CAMPOSOCULTOS");
            }
        }
        if ($operacao == 'ver')
            $tpl1->block("BLOCK_CHECKBOX_DESABILITADO");
        if ($tipopessoa == 2) {
            $tpl1->CHECKBOX_SPAN_CLASSE = "some";
        } else {
            $tpl1->CHECKBOX_SPAN_CLASSE = "";
        }
        $tpl1->CHECKBOX_SPAN_ID = "span_supervisor";
        $tpl1->block("BLOCK_CHECKBOX");
    }

    //Tipo Vendedor
    if (($permissao_pessoas_cadastrar_vendedores == 1) || (($permissao_pessoas_ver_vendedores == 1) && ($operacao = 'ver'))) {
        $tpl1->CHECKBOX_NOME = "box[3]";
        $tpl1->CHECKBOX_ID = "vend";
        $tpl1->CHECKBOX_VALOR = "4";
        $tpl1->LABEL_NOME = "Vendedor";
        if ($tipo_vendedor == 1)
            $tpl1->block("BLOCK_CHECKBOX_SELECIONADO");
        //Se for edi��o de pessoa
        if ($operacao == "editar") {
            //Verifica se a pessoa em quest�o � supervisor de algum quiosque, se sim ent�o desabilitar esse check
            $sql2 = "SELECT * FROM quiosques_vendedores WHERE quiven_vendedor=$codigo";
            $query2 = mysql_query($sql2);
            if (!$query2)
                die("Erro: 1" . mysql_error());
            $total2 = mysql_num_rows($query2);
            if ($total2 > 0) {
                $tpl1->block("BLOCK_CHECKBOX_DESABILITADO");
                $tpl1->CHECKBOX_ICONE_ARQUIVO = "../imagens/icones/geral/info.png";
                $tpl1->CHECKBOX_ICONE_MENSAGEM = "Você não pode desmarcar esta opção porque esta pessoa atualmente é vendedora de algum quiosque";
                $tpl1->block("BLOCK_CHECKBOX_ICONE");
                //Chama o campo oculto caso o checkbox fique desabilitado
                $tpl1->CAMPOOCULTO_NOME = "box[3]";
                $tpl1->CAMPOOCULTO_VALOR = "4";
                $tpl1->block("BLOCK_CAMPOSOCULTOS");
            }
        }
        if ($operacao == 'ver')
            $tpl1->block("BLOCK_CHECKBOX_DESABILITADO");
        if ($tipopessoa == 2) {
            $tpl1->CHECKBOX_SPAN_CLASSE = "some";
        } else {
            $tpl1->CHECKBOX_SPAN_CLASSE = "";
        }
        $tpl1->CHECKBOX_SPAN_ID = "span_vendedor";
        $tpl1->block("BLOCK_CHECKBOX");
    }

    //Tipo Fornecedor

    if (($permissao_pessoas_cadastrar_fornecedores == 1) || (($permissao_pessoas_ver_fornecedores == 1) && ($operacao = 'ver'))) {
        $tpl1->CHECKBOX_NOME = "box[4]";
        $tpl1->CHECKBOX_ID = "fornec";
        $tpl1->CHECKBOX_VALOR = "5";
        $tpl1->LABEL_NOME = "Fornecedor";
        if ($tipo_fornecedor == 1)
            $tpl1->block("BLOCK_CHECKBOX_SELECIONADO");
        if ($operacao == 'ver')
            $tpl1->block("BLOCK_CHECKBOX_DESABILITADO");
        $tpl1->CHECKBOX_ONCLICK = "aparece_tiponegociacao();";
        $tpl1->block("BLOCK_CHECKBOX_ONCLICK");
        $tpl1->CHECKBOX_SPAN_CLASSE = "";
        $tpl1->CHECKBOX_SPAN_ID = "span_fornecedor";
        $tpl1->block("BLOCK_CHECKBOX");
    }

    //Tipo Consumidor
    if (($permissao_pessoas_cadastrar_consumidores == 1) || (($permissao_pessoas_ver_consumidores == 1) && ($operacao = 'ver'))) {
        $tpl1->CHECKBOX_NOME = "box[5]";
        $tpl1->CHECKBOX_ID = "consum";
        $tpl1->CHECKBOX_VALOR = "6";
        $tpl1->LABEL_NOME = "Consumidor";
        if ($tipo_consumidor == 1)
            $tpl1->block("BLOCK_CHECKBOX_SELECIONADO");
        if ($operacao == 'ver')
            $tpl1->block("BLOCK_CHECKBOX_DESABILITADO");
        $tpl1->CHECKBOX_SPAN_CLASSE = "";
        $tpl1->CHECKBOX_SPAN_ID = "span_consumidor";
        $tpl1->block("BLOCK_CHECKBOX");
    }

    $tpl1->block("BLOCK_TITULO");
    $tpl1->block("BLOCK_CONTEUDO");
    $tpl1->block("BLOCK_ITEM");
}

//Cooperativa
$tpl1->TITULO = "Cooperativa";
$tpl1->block("BLOCK_TITULO");
$tpl1->SELECT_NOME = "cooperativa";
$tpl1->SELECT_ID = "cooperativa";
$tpl1->SELECT_TAMANHO = "";
$tpl1->SELECT_ONCHANGE = "popula_quiosques();";
$tpl1->block("BLOCK_SELECT_ONCHANGE");
$tpl1->block("BLOCK_SELECT_OBRIGATORIO");

if ($codigo != "") {
    //Verifica se a pessoa � administrador ou root
    $sql8 = "SELECT * FROM mestre_pessoas_tipo WHERE mespestip_tipo=1 and mespestip_pessoa=$codigo";
    $query8 = mysql_query($sql8);
    if (!$query8)
        die("Erro 40:" . mysql_error());
    $linhas8 = mysql_num_rows($query8);
}

if (($linhas8 > 0) || ($usuario_grupo == 7))
    $sql = "SELECT * FROM cooperativas ORDER BY coo_abreviacao";
else
    $sql = "SELECT * FROM cooperativas WHERE coo_codigo=$usuario_cooperativa";
$query = mysql_query($sql);
if (!$query)
    die("Erro: 0" . mysql_error());
while ($dados = mysql_fetch_assoc($query)) {
    $tpl1->OPTION_VALOR = $dados["coo_codigo"];
    $tpl1->OPTION_NOME = $dados["coo_abreviacao"];
    $coo = $dados["coo_codigo"];
    if ($coo == $usuario_cooperativa)
        $tpl1->block("BLOCK_SELECT_OPTION_SELECIONADO");
    $tpl1->block("BLOCK_SELECT_OPTION");
}
if ($operacao == 'ver')
    $tpl1->block("BLOCK_SELECT_DESABILITADO");
$tpl1->block("BLOCK_SELECT");
$tpl1->block("BLOCK_CONTEUDO");
$tpl1->block("BLOCK_ITEM");



//Tipo de negociação
if ($operacao == 'cadastrar')
    $tpl1->LINHA_CLASSE = "some";
else
    $tpl1->LINHA_CLASSE = "";
$tpl1->block("BLOCK_LINHA_CLASSE");
$tpl1->LINHA_ID = "tr_tiponegociacao";
$tpl1->block("BLOCK_LINHA_ID");
$tpl1->TITULO = "Tipo de negociação";
$tpl1->block("BLOCK_TITULO");
if (($operacao == "editar") || ($operacao == "ver")) {
    $sql = "SELECT * FROM fornecedores_tiponegociacao WHERE fortipneg_pessoa=$codigo";
    $query = mysql_query($sql);
    if (!$query)
        die("Erro: 8" . mysql_error());
    $tipo_consignacao = 0;
    $tipo_revenda = 0;
    while ($dados = mysql_fetch_assoc($query)) {
        $tipo = $dados["fortipneg_tiponegociacao"];
        if ($tipo == 1)
            $tipo_consignacao = 1;
        if ($tipo == 2)
            $tipo_revenda = 1;
    }
}
if ($usuario_quiosque == "0")
    $sql11 = "SELECT tipneg_codigo FROM tipo_negociacao";
else
    $sql11 = "SELECT quitipneg_tipo FROM quiosques_tiponegociacao WHERE quitipneg_quiosque=$usuario_quiosque";
$query11 = mysql_query($sql11);
if (!$query11)
    die("Erro: " . mysql_error());
while ($dados11 = mysql_fetch_array($query11)) {
    $tipon = $dados11[0];
    if ($tipon == 1)
        $quiosque_consignacao = 1;
    IF ($tipon == 2)
        $quiosque_revenda = 1;
}

if ($quiosque_consignacao == 1) {
    $tpl1->CHECKBOX_NOME = "box2[1]";
    $tpl1->CHECKBOX_VALOR = "1";
    $tpl1->LABEL_NOME = "Consignação";
    if ($tipo_consignacao == 1) {
        $tpl1->block("BLOCK_CHECKBOX_SELECIONADO");
    }
    if ($operacao == 'ver')
        $tpl1->block("BLOCK_CHECKBOX_DESABILITADO");
    $tpl1->CHECKBOX_SPAN_ID = "";
    $tpl1->block("BLOCK_CHECKBOX");
}

//Tipo Revenda
if ($quiosque_revenda == 1) {
    $tpl1->CHECKBOX_NOME = "box2[2]";
    $tpl1->CHECKBOX_VALOR = "2";
    $tpl1->LABEL_NOME = "Revenda";
    if ($tipo_revenda == 1) {
        $tpl1->block("BLOCK_CHECKBOX_SELECIONADO");
    }
    if ($operacao == 'ver')
        $tpl1->block("BLOCK_CHECKBOX_DESABILITADO");
    $tpl1->CHECKBOX_SPAN_ID = "";
    $tpl1->block("BLOCK_CHECKBOX");
}

$tpl1->block("BLOCK_CONTEUDO");
$tpl1->block("BLOCK_ITEM");

//Observação
$tpl1->TITULO = "Observação";
$tpl1->block("BLOCK_TITULO");
$tpl1->TEXTAREA_TAMANHO = "65";
$tpl1->TEXTAREA_NOME = "obs";
//$tpl1->block("BLOCK_TEXTAREA_DESABILITADO");
$tpl1->TEXTAREA_TEXTO = $obs;
if ($operacao == 'ver')
    $tpl1->block("BLOCK_TEXTAREA_DESABILITADO");
$tpl1->block("BLOCK_TEXTAREA");
$tpl1->block("BLOCK_CONTEUDO");
$tpl1->block("BLOCK_ITEM");

//Verifica se o usu�rio tem permiss�o para cadastrar editar ou ver dados de usuário
if ($operacao == "editar") {
    if (($permissao_pessoas_criarusuarios == 1) || ($codigo == $usuario_codigo)) {

        //Verifica se o esta pessoa � administradora
        $sql = "SELECT * FROM mestre_pessoas_tipo WHERE mespestip_pessoa=$codigo and mespestip_tipo=1";
        $query = mysql_query($sql);
        if (!$query)
            die("Erro: 0" . mysql_error());
        $linhas = mysql_num_rows($query);


        //Verifica se o esta pessoa é vendedor de algum quiosque
        $sql2 = "SELECT qui_nome FROM quiosques JOIN quiosques_vendedores on (quiven_quiosque=qui_codigo)  WHERE quiven_vendedor=$codigo";
        $query2 = mysql_query($sql2);
        if (!$query2)
            die("Erro: 1" . mysql_error());
        $linhas2 = mysql_num_rows($query2);

        //Verifica se o esta pessoa é supervisor de algum quiosque
        $sql3 = "SELECT DISTINCT qui_nome FROM quiosques join quiosques_supervisores on (qui_codigo=quisup_quiosque) WHERE quisup_supervisor=$codigo";
        $query3 = mysql_query($sql3);
        if (!$query3)
            die("Erro: 2" . mysql_error());
        $linhas3 = mysql_num_rows($query3);

        //Verifica se o esta pessoa � fornecedor de algum quiosque
        $sql4 = "SELECT DISTINCT qui_nome FROM quiosques join entradas on (ent_quiosque=qui_codigo) WHERE ent_fornecedor=$codigo";
        $query4 = mysql_query($sql4);
        if (!$query4)
            die("Erro: 3" . mysql_error());
        $linhas4 = mysql_num_rows($query4);

        //Verifica se o esta pessoa � administradora
        $sql6 = "SELECT * FROM cooperativas WHERE coo_presidente=$codigo";
        $query6 = mysql_query($sql6);
        if (!$query6)
            die("Erro: 0" . mysql_error());
        $linhas6 = mysql_num_rows($query6);

        $linhas5 = $linhas + $linhas2 + $linhas3 + $linhas4 + $linhas6;


        //Possui Acesso?
        $tpl1->TITULO = "Possui Acesso?";
        $sql = "SELECT pes_possuiacesso FROM pessoas WHERE pes_codigo=$codigo";
        $query = mysql_query($sql);
        if (!$query)
            die("Erro: 3" . mysql_error());
        $dados = mysql_fetch_assoc($query);
        $acesso = $dados["pes_possuiacesso"];
        $tpl1->block("BLOCK_TITULO");
        $tpl1->SELECT_NOME = "possuiacesso";
        $tpl1->SELECT_ID = "possuiacesso";
        $tpl1->SELECT_TAMANHO = "";
        $tpl1->SELECT_ONCHANGE = "verifica_usuario($tipopessoa);";
        $tpl1->block("BLOCK_SELECT_ONCHANGE");
        $tpl1->OPTION_VALOR = 0;
        $tpl1->OPTION_NOME = "Não";
        if ($linhas5 == 0) {
            $tpl1->block("BLOCK_SELECT_DESABILITADO");
            $tpl1->COMPLEMENTO_ICONE_ARQUIVO = "../imagens/icones/geral/info.png";
            $tpl1->COMPLEMENTO_ICONE_MENSAGEM = "Esta pessoa não pode ter acesso ao sistema porque ela não é presidente, supervisora, vendedora ou fornecedora de algum quiosque de sua cooperativa. Para ser considerado um fornecedor, não basta apenas marcar o tipo 'Fornecedor' nesta tela, é necessário ter pelo menos uma entrada! Para ser Supervisor ou Vendedor de um quiosque, esta pessoa deve ser vinculadas a um quiosque na tela de 'Quiosques'! E para ser um presidente contatar um administrador! :)";
            $tpl1->block("BLOCK_COMPLEMENTO_ICONE");
            $tpl1->block("BLOCK_SELECT_OPTION_SELECIONADO");
        }
        if ($acesso == 0) {
            $tpl1->block("BLOCK_SELECT_OPTION_SELECIONADO");
        }
        $tpl1->block("BLOCK_SELECT_OBRIGATORIO");
        $tpl1->block("BLOCK_SELECT_OPTION");
        $tpl1->OPTION_VALOR = 1;
        $tpl1->OPTION_NOME = "Sim";
        if ($acesso == 1) {
            $tpl1->block("BLOCK_SELECT_OPTION_SELECIONADO");
        }
        $tpl1->block("BLOCK_SELECT_OPTION");
        //Verifica se o usu�rio est� editando seu pr�prio cadastro
        if ($usuario_codigo == $codigo) {

            $tpl1->block("BLOCK_SELECT_DESABILITADO");
            //Caso o campo fique desabilitado deve-se enviar o valor ocultamente
            $tpl1->CAMPOOCULTO_NOME = "possuiacesso";
            $tpl1->CAMPOOCULTO_VALOR = "$acesso";
            $tpl1->block("BLOCK_CAMPOSOCULTOS");
        }
        $tpl1->block("BLOCK_SELECT");
        $tpl1->block("BLOCK_CONTEUDO");
        //Verifica se o usu�rio est� editando seu pr�prio cadastro, se sim mostrar icone informativo ao lado
        if ($usuario_codigo == $codigo) {
            $tpl1->COMPLEMENTO_ICONE_ARQUIVO = "../imagens/icones/geral/info.png";
            $tpl1->COMPLEMENTO_ICONE_MENSAGEM = "Você não tem permissão para desativar seu próprio usuário! Contate um adminsitrador se deseja fazer isto!";
            $tpl1->block("BLOCK_COMPLEMENTO_ICONE");
        }
        $tpl1->block("BLOCK_CONTEUDO");
        $tpl1->block("BLOCK_ITEM");


        //Se a pessoa estiver setada como vendedor, supervisor ou fornecedor de algum quiosque ent�o liberar acesso ao sistema
        if ($linhas5 > 0) {

            //Senha Nova
            $tpl1->TITULO = "Nova Senha";
            $tpl1->TITULO_ID = "span_password";
            $tpl1->block("BLOCK_TITULO_ID");
            $tpl1->block("BLOCK_TITULO");
            $tpl1->CAMPO_TIPO = "password";
            $tpl1->CAMPO_QTD_CARACTERES = "";
            $tpl1->CAMPO_NOME = "senha";
            $tpl1->CAMPO_ONCLICK = "";
            $tpl1->CAMPO_ID = "password";
            $tpl1->CAMPO_TAMANHO = "20";
            $tpl1->CAMPO_VALOR = "";
            $tpl1->CAMPO_QTD_CARACTERES = 30;
            $tpl1->block("BLOCK_CAMPO_AUTOSELECIONAR");
            if ($senha == "") {
                $tpl1->block("BLOCK_CAMPO_PASSWORD_OBRIGATORIO");
            } else {
                $tpl1->block("BLOCK_CAMPO_PASSWORD");
            }
            $tpl1->block("BLOCK_CAMPO");
            $tpl1->block("BLOCK_COMPLEMENTO");
            $tpl1->block("BLOCK_CONTEUDO");
            $tpl1->block("BLOCK_ITEM");

            //Regidigite a Nova Senha
            $tpl1->TITULO = "Redigite a Nova Senha";
            $tpl1->TITULO_ID = "span_senha2";
            $tpl1->block("BLOCK_TITULO_ID");
            $tpl1->block("BLOCK_TITULO");
            $tpl1->CAMPO_TIPO = "password";
            $tpl1->CAMPO_QTD_CARACTERES = "";
            $tpl1->CAMPO_NOME = "senha2";
            $tpl1->CAMPO_ID = "senha2";
            $tpl1->CAMPO_ONCLICK = "";
            $tpl1->CAMPO_TAMANHO = "20";
            $tpl1->CAMPO_VALOR = "";
            $tpl1->CAMPO_QTD_CARACTERES = 30;
            $tpl1->block("BLOCK_CAMPO_AUTOSELECIONAR");
            if ($senha == "") {
                $tpl1->block("BLOCK_CAMPO_OBRIGATORIO");
            } else {
                $tpl1->block("BLOCK_CAMPO_NORMAL");
            }
            IF ($operacao == 'ver')
                $tpl1->block("BLOCK_CAMPO_DESABILITADO");
            $tpl1->block("BLOCK_CAMPO");
            $tpl1->block("BLOCK_CONTEUDO");
            $tpl1->block("BLOCK_ITEM");



            //Grupo de Permissões
            $tpl1->TITULO = "Grupo de Permissões";
            $tpl1->TITULO_ID = "span_grupopermissoes";
            $tpl1->block("BLOCK_TITULO_ID");
            $tpl1->block("BLOCK_TITULO");
            $tpl1->SELECT_NOME = "grupopermissoes";
            $tpl1->SELECT_ID = "grupopermissoes";
            $tpl1->SELECT_ONCHANGE = "pessoas_popula_quiosque(this.value)";
            $tpl1->block("BLOCK_SELECT_ONCHANGE");
            $tpl1->SELECT_TAMANHO = "";
            $tpl1->block("BLOCK_SELECT_OBRIGATORIO");
            $tpl1->block("BLOCK_SELECT_OPTION_PADRAO");

            $sql = "SELECT * FROM grupo_permissoes ORDER BY gruper_codigo";
            $query = mysql_query($sql);
            if (!$query)
                die("Erro: 2" . mysql_error());
            while ($dados = mysql_fetch_assoc($query)) {
                $tpl1->OPTION_VALOR = $dados["gruper_codigo"];
                $tpl1->OPTION_NOME = $dados["gruper_nome"];
                $grupo_codigo = $dados["gruper_codigo"];

                //Verifica se o esta pessoa é administrador
                if ($grupo_codigo == 1) {
                    $sql9 = "SELECT * FROM mestre_pessoas_tipo WHERE mespestip_pessoa=$codigo and mespestip_tipo=1";
                    $query9 = mysql_query($sql9);
                    if (!$query9)
                        die("Erro: 0" . mysql_error());
                    $linhas9 = mysql_num_rows($query9);
                    if ($linhas9 > 0) {
                        if ($grupopermissoes == $grupo_codigo)
                            $tpl1->block("BLOCK_SELECT_OPTION_SELECIONADO");
                        $tpl1->block("BLOCK_SELECT_OPTION");
                    }
                }

                //Verifica se o esta pessoa é presidente
                if ($grupo_codigo == 2) {
                    $sql6 = "SELECT * FROM cooperativas WHERE coo_presidente=$codigo";
                    $query6 = mysql_query($sql6);
                    if (!$query6)
                        die("Erro: 0" . mysql_error());
                    $linhas6 = mysql_num_rows($query6);
                    if ($linhas6 > 0) {
                        if ($grupopermissoes == $grupo_codigo)
                            $tpl1->block("BLOCK_SELECT_OPTION_SELECIONADO");
                        $tpl1->block("BLOCK_SELECT_OPTION");
                    }
                }

                //Verifica se o esta pessoa é supervisor de algum quiosque
                if ($grupo_codigo == 3) {
                    $sql3 = "SELECT DISTINCT qui_nome FROM quiosques join quiosques_supervisores on (qui_codigo=quisup_quiosque) WHERE quisup_supervisor=$codigo";
                    $query3 = mysql_query($sql3);
                    if (!$query3)
                        die("Erro: 2" . mysql_error());
                    $linhas3 = mysql_num_rows($query3);
                    if ($linhas3 > 0) {
                        if ($grupopermissoes == $grupo_codigo)
                            $tpl1->block("BLOCK_SELECT_OPTION_SELECIONADO");
                        $tpl1->block("BLOCK_SELECT_OPTION");
                    }
                }

                //Verifica se o esta pessoa é vendedor de algum quiosque
                if ($grupo_codigo == 4) {
                    $sql2 = "SELECT qui_nome FROM quiosques JOIN quiosques_vendedores on (quiven_quiosque=qui_codigo)  WHERE quiven_vendedor=$codigo";
                    $query2 = mysql_query($sql2);
                    if (!$query2)
                        die("Erro: 1" . mysql_error());
                    $linhas2 = mysql_num_rows($query2);
                    if ($linhas2 > 0) {
                        if ($grupopermissoes == $grupo_codigo)
                            $tpl1->block("BLOCK_SELECT_OPTION_SELECIONADO");
                        $tpl1->block("BLOCK_SELECT_OPTION");
                    }
                }

                //Verifica se o esta pessoa é fornecedor de algum quiosque
                if ($grupo_codigo == 5) {
                    $sql4 = "SELECT DISTINCT qui_nome FROM quiosques join entradas on (ent_quiosque=qui_codigo) WHERE ent_fornecedor=$codigo";
                    $query4 = mysql_query($sql4);
                    if (!$query4)
                        die("Erro: 3" . mysql_error());
                    $linhas4 = mysql_num_rows($query4);
                    if ($linhas4 > 0) {
                        if ($grupopermissoes == $grupo_codigo)
                            $tpl1->block("BLOCK_SELECT_OPTION_SELECIONADO");
                        $tpl1->block("BLOCK_SELECT_OPTION");
                    }
                }
            }
            $tpl1->block("BLOCK_SELECT");
            $tpl1->block("BLOCK_CONTEUDO");
            $tpl1->block("BLOCK_ITEM");

            //Quiosque do Usuário
            $tpl1->TITULO = "Quiosque do Usuário";
            $tpl1->TITULO_ID = "span_quiosqueusuario";
            $tpl1->block("BLOCK_TITULO_ID");
            $tpl1->block("BLOCK_TITULO");
            $tpl1->SELECT_NOME = "quiosqueusuario";
            $tpl1->SELECT_ID = "quiosqueusuario";
            $tpl1->SELECT_TAMANHO = "";
            $tpl1->block("BLOCK_SELECT_NORMAL");


            if (($usuario_grupo == 1) || ($usuario_grupo == 2)) {
                $tpl1->OPTION_VALOR = "";
                $tpl1->OPTION_NOME = "Todos";
                $tpl1->block("BLOCK_SELECT_OPTION");
                $sql = "SELECT qui_codigo,qui_nome FROM quiosques WHERE qui_cooperativa=$cooperativa";
            } else if ($usuario_grupo == 3) {
                $sql = "
            SELECT qui_codigo,qui_nome 
            FROM quiosques 
            join quiosques_supervisores on (quisup_quiosque=qui_codigo)
            WHERE qui_cooperativa=$cooperativa
            AND quisup_supervisor=$codigo
        ";
            } else IF ($usuario_grupo == 4) {
                $sql = "
            SELECT qui_codigo,qui_nome 
            FROM quiosques 
            join quiosques_vendedores on (quiven_quiosque=qui_codigo)
            WHERE qui_cooperativa=$cooperativa
            AND quiven_vendedor=$codigo
        ";
            } else IF ($usuario_grupo == 5) {
                $sql = "
                SELECT qui_codigo,qui_nome 
                FROM entradas 
                join quiosques on (ent_quiosque=qui_codigo)
                WHERE qui_cooperativa=$cooperativa
                AND ent_fornecedor=$codigo
        ";
            }


            $query = mysql_query($sql);
            if (!$query)
                die("Erro: 8" . mysql_error());

            while ($dados = mysql_fetch_assoc($query)) {
                if ($quiosqueusuario == $dados['qui_codigo'])
                    $tpl1->block("BLOCK_SELECT_OPTION_SELECIONADO");
                $tpl1->OPTION_VALOR = $dados["qui_codigo"];
                $tpl1->OPTION_NOME = $dados["qui_nome"];
                $tpl1->block("BLOCK_SELECT_OPTION");
            }

            $tpl1->block("BLOCK_SELECT");
            $tpl1->block("BLOCK_CONTEUDO");
            $tpl1->block("BLOCK_ITEM");
        }
    }
}

//Campos ocultos do formulario caso seja uma edi��o
if ($operacao == "editar") {
    //Codigo
    $tpl1->CAMPOOCULTO_NOME = "codigo";
    $tpl1->CAMPOOCULTO_VALOR = "$codigo";
    $tpl1->block("BLOCK_CAMPOSOCULTOS");

    //Nome
    $tpl1->CAMPOOCULTO_NOME = "nomenobanco";
    $tpl1->CAMPOOCULTO_VALOR = "$nome";
    $tpl1->block("BLOCK_CAMPOSOCULTOS");
}
//Operação
$tpl1->CAMPOOCULTO_NOME = "operacao";
$tpl1->CAMPOOCULTO_VALOR = "$operacao";
$tpl1->block("BLOCK_CAMPOSOCULTOS");



//BOTOES
if (($operacao == "editar") || ($operacao == "cadastrar")) {
    //Botão Salvar
    $tpl1->block("BLOCK_BOTAO_SALVAR");

    //Botão Cancelar
    if ($codigo != $usuario_codigo) {
        $tpl1->BOTAO_LINK = "pessoas.php";
        $tpl1->block("BLOCK_BOTAO_CANCELAR");
    }
} else {
    //Botão Voltar
    $tpl1->block("BLOCK_BOTAO_VOLTAR");
}
$tpl1->block("BLOCK_BOTOES");

$tpl1->show();

include "rodape.php";
?>

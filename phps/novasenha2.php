<title>SGAF Esquecí minha senha</title>
<head>
    <html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br"></html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="classes.css" />
    <link rel="stylesheet" type="text/css" href="templates/geral.css">
        <script type="text/javascript" src="controle/google_analytics.js"></script>
        <script type="text/javascript" src="js/jquery-1.3.2.js"></script>
        <script src="js/jquery.maskedinput-1.1.4.pack.js" type="text/javascript"></script>
        <script src="mascaras.js" type="text/javascript"></script>    
        <script src="funcoes.js" type="text/javascript"></script>    
</head>
<body>        
    <div class="pagina" >
        <?php
        include ("templates/Template.class.php");
        include "controle/conexao.php";
        include "funcoes.php";
        include "js/mascaras.php";
        ?>
        <div class="corpo">
            <?php
            $senha = $_POST["senha1"];
            $cpf = $_POST["cpf"];

            //Atualiza senha            
            $senha1md5 = md5($senha);
            $sql1 = "UPDATE pessoas SET pes_senha='$senha1md5' WHERE pes_cpf=$cpf";
            $query1 = mysql_query($sql1);
            if (!$query1)
                die("Erro1: " . mysql_error());
            
            $tpl = new Template("templates/tituloemlinha_2.html");
            $tpl->block("BLOCK_TITULO");
            $tpl->LISTA_TITULO = "NOVA SENHA";
            $tpl->block("BLOCK_QUEBRA2");
            $tpl->show();

            $tpl = new Template("templates/notificacao.html");
            $tpl->ICONES = "../imagens/icones/geral/";
            $tpl->TITULO = "SENHA ALTERADA";
            $tpl->ICONE_ARQUIVO = "confirmar.png";
            $tpl->block("BLOCK_TITULO");
            $tpl->MOTIVO = "Agora é só fazer login (entrar) novamente com seu CPF/CNPJ e sua senha nova! Clique no botão abaixo para ir para a pagina inicial.";
            $tpl->MOTIVO_COMPLEMENTO = "";
            $tpl->block("BLOCK_MOTIVO");
            $tpl->DESTINO = "../index.html";
            $tpl->block("BLOCK_BOTAO");
            $tpl->show();


            //BOTÕES DO FINAL DO FORMULÁRIO
            $tpl2 = new Template("templates/botoes1.html");
            $tpl2->block("BLOCK_LINHAHORIZONTAL_EMCIMA");
            //Salvar
            $tpl2->block("BLOCK_BOTAOPADRAO_SUBMIT");
            $tpl2->block("BLOCK_BOTAOPADRAO_CONTINUAR");
            $tpl2->block("BLOCK_BOTAOPADRAO");
            $tpl->block("BLOCK_CONTEUDO");
            $tpl2->block("BLOCK_COLUNA");

            $tpl2->block("BLOCK_LINHA");
            $tpl2->block("BLOCK_BOTOES");
            $tpl2->show();
            ?>
        </div>        

    </div>
</body>

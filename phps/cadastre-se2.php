<?php
include "controle/conexao.php";
include "funcoes.php";

$dataatual = date("Y-m-d");
$horaatual = date("h:i:s");

$nome = ucwords(strtolower($_POST['nome']));
$bairro = ucwords(strtolower($_POST['bairro']));
$endereco = ucwords(strtolower($_POST['endereco']));
$cpf = $_POST["cpf"];
$cpf = limpa_cpf($cpf);
//echo "CPF: $cpf";
$sigla = $_POST["sigla"];
$data_nasc = $_POST["data"];
$cep = $_POST["cep"];
$pais = $_POST["pais"];
$estado = $_POST["estado"];
$cidade = $_POST["cidade"];
$numero = $_POST["numero"];
$complemento = $_POST["complemento"];
$pontoref = $_POST["pontoref"];
$telefone1 = $_POST["telefone1"];
$telefone2 = $_POST["telefone2"];
$email = strtolower($_POST["email"]);
$nomepv = ucwords(strtolower($_POST['nomepv']));
$telefone1pv = $_POST["telefone1pv"];
$telefone1pvramal = $_POST["telefone1pvramal"];
$telefone2pv = $_POST["telefone2pv"];
$telefone2pvramal = $_POST["telefone2pvramal"];
$emailpv = strtolower($_POST["emailpv"]);
$mesmoendereco = $_POST["mesmoendereco"];
$ceppv = $_POST["ceppv"];
$cidadepv = $_POST["cidadepv"];
$bairropv = ucwords(strtolower($_POST["bairropv"]));
$enderecopv = ucwords(strtolower($_POST["enderecopv"]));
$numeropv = $_POST["numeropv"];
$complementopv = $_POST["complementopv"];
$pontorefpv = $_POST["pontorefpv"];
$possuicooperativa = $_POST["possuicooperativa"];
$cooperativa = ucwords(strtolower($_POST["cooperativa"]));
$cooperativa_sigla = strtoupper($_POST["cooperativa_sigla"]);
$senha = $_POST["senha"];
$senha2 = $_POST["senha2"];
$email_senha = $_POST["email_senha"];
$check_perguntasecreta = $_POST["check_perguntasecreta"];
$pergunta = $_POST["pergunta"];
$resposta = $_POST["resposta"];
$check_termo = $_POST["check_termo"];


//Cadastrar cooperativa
//Se o usuário não pertence a nenhuma cooperativa então criar uma cooperativa com o mesmo nome que o quiosque

if ($possuicooperativa == 0) {
    $cooperativa = $nomepv;
    $cooperativa_sigla = $nomepv;    
}
if ($mesmoendereco == 1) {
    $cidadepv = $cidade;
    $bairropv = $bairro;
    $enderecopv = $endereco;
    $numeropv = $numero;
    $complementopv = $complemento;
    $ceppv = $cep;
}



$sql = "
INSERT INTO
    cooperativas (coo_nomecompleto, coo_abreviacao)
VALUES 
    ('$cooperativa','$cooperativa_sigla');
";
if (!mysql_query($sql))
    die("Erro Cooperativa Inserir: " . mysql_error());

//Cadastrar o quiosque dentro da cooperativa
$cooperativa_ultimo = mysql_insert_id();
$sql2 = "
    INSERT INTO quiosques (
        qui_nome,
        qui_cidade,
        qui_cep,
        qui_bairro,
        qui_endereco,
        qui_numero,
        qui_complemento,
        qui_referencia,
        qui_fone1,
        qui_fone1ramal,
        qui_fone2,
        qui_fone2ramal,
        qui_email,
        qui_datacadastro,
        qui_horacadastro,
        qui_cooperativa
    ) VALUES (
        '$nomepv',
        '$cidadepv',
        '$ceppv',
        '$bairropv',
        '$enderecopv',
        '$numeropv',
        '$complementopv',
        '$pontorefpv',
        '$telefone1pv',
        '$telefone1pvramal',
        '$telefone2pv',
        '$telefone2pvramal',
        '$emailpv',
        '$dataatual',
        '$horaatual',
        '$cooperativa_ultimo'
    );
";
if (!mysql_query($sql2))
    die("Erro Quiosque Inserir: " . mysql_error());
$quiosque_ultimo=  mysql_insert_id();

//Inserir pessoa 
$senha = md5($senha);
$sql = "
INSERT INTO 
    pessoas (
        pes_nome,
        pes_cidade,
        pes_bairro,
        pes_endereco,
        pes_numero,
        pes_complemento,
        pes_referencia,
        pes_cep,
        pes_fone1,
        pes_fone2,
        pes_email,
        pes_cooperativa,
        pes_possuiacesso,        
        pes_datacadastro,
        pes_horacadastro,
        pes_senha,
        pes_cpf,
        pes_grupopermissoes,
        pes_quiosqueusuario,
        pes_email_senha,
        pes_usarperguntasecreta,
        pes_perguntasecreta,
        pes_respostasecreta
    )
VALUES (
    '$nome',
    '$cidade',
    '$bairro',
    '$endereco',
    '$numero',
    '$complemento',
    '$pontoref',
    '$cep',
    '$telefone1',
    '$telefone2',
    '$email',
    '$cooperativa_ultimo',
    '1',
    '$dataatual',
    '$horaatual',
    '$senha',
    '$cpf',
    '3',
    '$quiosque_ultimo',
    '$email_senha',
    '$check_perguntasecreta',
    '$pergunta',
    '$resposta'
     
)";
if (!mysql_query($sql))
    die("Erro6: " . mysql_error());
$pessoa_ultimo = mysql_insert_id();

//Cria o vinculo do tipo com a pessoa
//Define a pessoa com os tipos: supervisor,fornecedor e consumidor
$sql = "
INSERT INTO mestre_pessoas_tipo (
    mespestip_pessoa,
    mespestip_tipo
) VALUES (
    '$pessoa_ultimo',
    '5'
)";
if (!mysql_query($sql))
    die("Erro Pessoas Tipo 5: " . mysql_error());
$sql = "
INSERT INTO mestre_pessoas_tipo (
    mespestip_pessoa,
    mespestip_tipo
) VALUES (
    '$pessoa_ultimo',
    '6'
)";
if (!mysql_query($sql))
    die("Erro Pessoas Tipo 6: " . mysql_error());
$sql = "
INSERT INTO mestre_pessoas_tipo (
    mespestip_pessoa,
    mespestip_tipo
) VALUES (
    '$pessoa_ultimo',
    '3'
)";
if (!mysql_query($sql))
    die("Erro Pessoas Tipo 3: " . mysql_error());


//Inserir a pessoa como supervisor do quiosque
$sql = "
INSERT INTO 
    quiosques_supervisores (
        quisup_quiosque,
        quisup_supervisor,
        quisup_datafuncao
    )
VALUES (
    '$quiosque_ultimo',
    '$pessoa_ultimo',
    '$dataatual'
)";
$query = mysql_query($sql);
if (!$query)
    die("Erro Inserir Supervisor:" . mysql_error());

echo "Cadastro realizado com sucesso!<br>";
echo "<a href='../index.html'>Entrar no sistema</a>";

?>


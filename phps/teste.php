
//Cabe�alho
$tpl = new Template("../templates/cabecalho1.html");
$codigo = explode(".", end(explode("/", $_SERVER['PHP_SELF'])));
$codigo = $codigo[0];
$tpl->NUMERO = $codigo;
$data = date("d/M/Y");
$hora = date("H:i");
$tpl->DATA = "$data";
$tpl->HORA = "$hora";
$sql = "
    SELECT rel_nome
    FROM relatorios
    WHERE rel_codigo=$codigo
";
$query = mysql_query($sql);
if (!$query)
    die("Erro1: " . mysql_error());
$dados = mysql_fetch_assoc($query);
$tpl->NOME = $dados["rel_nome"];
$tpl->COOPERATIVA = $usuario_cooperativaabreviacao;
$tpl->QUIOSQUE = $usuario_quiosquenome;
$tpl->show();
<?php 
//Verifica se o usu�rio tem permiss�o para acessar este conte�do
require "login_verifica.php";
$ver=$_GET['ver'];
if ($ver==1) {
    if ($permissao_produtos_ver<>1)    
        header("Location: permissoes_semacesso.php");   
} else {
    if ($permissao_produtos_cadastrar <> 1)
        header("Location: permissoes_semacesso.php");   
}

$tipopagina = "produtos"; 
include "includes.php"; ?>

<?php 
$codigo=$_GET['codigo'];
$ver=$_GET['ver'];
$sql="SELECT * FROM produtos WHERE pro_codigo='$codigo'";
$query=mysql_query($sql);
while($array = mysql_fetch_array($query))
{
	$nome= $array['pro_nome']; 
	$tipo= $array['pro_tipocontagem'];
	$categoria= $array['pro_categoria'];
	$descricao= $array['pro_descricao'];
}

?>
<script type="text/javascript" src="js/capitular.js"></script>

<table summary="" class="" border="0">
<tr>
	<td width="35px"><img width="50px" src="<?php echo $icones;?>produtos.png" alt="" ></td>
	<td valign="bottom">
		<label class="titulo" > PRODUTOS </label><br />
		<label class="subtitulo"> CADASTRO/EDIÇÃO </label>
	</td>
</tr>
</table>
<hr align="left" class="linhacurta" >
<br />

<form action="produtos_cadastrar2.php?codigo=<?php echo"$codigo";?>" method="post" name="form1">
<table summary="" border="0" class="tabela1" cellpadding="4">
<tr>
	<td align="right" width="200px"><b>Nome: <label class="obrigatorio"></label></b></td>
	<td align="left" width=""><input  onkeypress="capitalize()"  id="capitalizar" type="text" name="nome" autofocus size="30" class="campo1" required value="<?php echo "$nome"; ?>" <?php if ($ver==1) echo" disabled ";?> ></td>
</tr>
<tr>
	<td align="right" width="200px"><b>Tipo de Contagem: <label class="obrigatorio"></label></b></td>
	<td align="left" width="">
            <select name="tipo" id="tipo" class="campo1" required="required" onchange="sigla()" 
            <?php 
            $sql8="
                SELECT entpro_produto
                FROM entradas_produtos
                WHERE entpro_produto=$codigo
            ";
            $query8=mysql_query($sql8);            
            $linhas8 =  mysql_num_rows($query8);
            if (($linhas8 > 0)||($ver==1))               
                echo " disabled ";            
            ?> >
		<option value=""></option>		
		<?php
		$sql1="SELECT * FROM produtos_tipo ";		
		$query1=mysql_query($sql1);
		while($array1 = mysql_fetch_array($query1))
		{
			?><option value="<?php echo"$array1[0]";?>" <?php if($array1[0]==$tipo) { echo "selected ";} ?> ><?php echo"$array1[1]";?></option><?php
		}
		?>
		</select>
	</td>
</tr>
<tr>
	<td align="right" width="200px"><b>Categoria: <label class="obrigatorio"></label></b></td>
	<td align="left" width="">
		<select name="categoria" class="campo1" required="required" <?php if ($ver==1) echo" disabled ";?> >
		<option value=""></option>		
		<?php
		$sql1="SELECT * FROM produtos_categorias WHERE cat_cooperativa=$usuario_cooperativa ORDER BY cat_nome";
		$query1=mysql_query($sql1);
		while($array1 = mysql_fetch_array($query1))
		{
			?><option value="<?php echo"$array1[0]";?>" <?php if($array1[0]==$categoria) { echo "selected ";} ?> ><?php echo"$array1[1]";?></option><?php
		}
		?>
		</select>
	</td>
</tr>

<tr>
	<td align="right" width="200px"><b>Descrição:</b></td>
	<td align="left" width=""><textarea class="textarea1" cols="55" name="descricao" <?php if ($ver==1) echo" disabled ";?> ><?php echo "$descricao";?></textarea></td>
</tr>
</table>

<br />
<hr align="left" >
<?php

//Verifica o link destino do bot�o voltar
$linkanterior=$_GET["link"];
$fornecedor=$_GET["fornecedor"];
if ($linkanterior=="") { $link_destino="produtos.php"; }
if ($linkanterior=="estoque.php") { $link_destino=$linkanterior; }
if ($linkanterior=="estoque_validade.php") { $link_destino=$linkanterior; }
if ($linkanterior=="estoque_porfornecedor_produto.php") { $link_destino=$linkanterior."?fornecedor=$fornecedor"; }

if ($ver==1){ ?><a href="<?php echo $link_destino; ?>" class="link">&nbsp;<input type="button" value="VOLTAR" class="botao fonte3"></a> <?php }
else { ?><input type="hidden" name="link" value="<?php echo $linkanterior; ?>">
<input type="submit" value="SALVAR" name="submit1" class="botao fonte3"> <a href="produtos.php" class="link">&nbsp;<input type="button" value="CANCELAR" class="botao fonte3"></a> <?php } ?>
<input type="hidden" name="nome2" value="<?php echo "$nome"; ?>">
<?php
if (($linhas8 > 0)||($ver==1)) {
?><input type="hidden" name="tipo" value="<?php echo "$tipo"; ?>"><?php                
} 
?>
</form>

<?php include "rodape.php"; ?>

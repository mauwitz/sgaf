<style type="text/css"><?php include "classes.css"; ?></style>
<?php
include "controle/conexao.php";
include "codigo_barras.php";

$entrada = $_POST["codigo"];
$sql2 = "
    SELECT
        *
    FROM
        entradas_produtos
        join produtos on (entpro_produto=pro_codigo)
        join produtos_tipo on (pro_tipocontagem=protip_codigo)
    WHERE
        entpro_entrada=$entrada
    ";
$query2 = mysql_query($sql2);
if (!$query2)
    die("Erro de SQL 1:" . mysql_error());

$posicao_x=0;
$x=0;
$y=0;
$posicao_y=0;

while ($dados2 = mysql_fetch_assoc($query2)) {
    $produto_nome = $dados2["pro_nome"];
    $local = $dados2["entpro_local"];
    $produto = $dados2["entpro_produto"];
    $qtd_etiquetas = $_POST["$produto"];        
    for ($i=0; $i<$qtd_etiquetas;$i++) {
        $produto_barra = str_pad($produto, 6, "0", STR_PAD_LEFT);
        $entrada_barra = str_pad($entrada, 8, "0", STR_PAD_LEFT);
        $etiqueta = $produto_barra . $entrada_barra;
        $y++;  
        
        ?>
        <div style="
            font-weight: bold;
            position: absolute;            
            left:<?php echo $posicao_x; ?>px;  
            top:<?php echo $posicao_y; ?>px;  
        ">
        <?php  echo "$produto_nome <br> $local"; fbarcode($etiqueta); ?>
        </div>

        
        <?php
        //Controla a posi��o da etiqueta
        $y_multiplo=$y/7;
        if (is_int($y_multiplo)) { //Se chegar na s�tima etiqueta ent�o imprimir a proxima no....
            $posicao_y=$posicao_y-660; //no topo da pagina
            $posicao_x=$posicao_x+175; //um poco para direita
        }
        else {
            $posicao_y= $posicao_y=$posicao_y+110; //um poco para baixo
        } 

        //Se completou uma folha de etiquetas ent�o come�ar a pr�xima
        if ($y_multiplo==3) {
            $posicao_y=$posicao_y+783;            
            $posicao_x=0; 
            $y_multiplo=0;
            $y=0;
        }
    }
}






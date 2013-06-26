<?php 
   
   $hostname = "localhost";
   $db = "cooesperanca";
   $user = "root";
   $pass = 'mautito';
   
   
   $link = mysql_connect($hostname, $user, $pass);
   if (!$link) {
       echo "N�o foi possivel conectar ao Banco de Dados! Descri�o do erro:".mysql_error();
       exit;
   }
   mysql_select_db($db, $link);
    $banco="sgaf";
 ?>

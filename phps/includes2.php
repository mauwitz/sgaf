<?php
require("templates/Template.class.php");
?>
<html>
    <head>
        <title>SGAF</title>
        <meta http-equiv="Content-Type" content="text/xhtml; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="classes.css" />
        <link rel="stylesheet" type="text/css" href="templates/geral.css" />
        <style >
            .relpagina  {
                font-family: Arial;
                font-size: 10pt;
                color: black;
                width: 800px;
                border: 1px transparent solid; 
            }

            .relcorpo  {
                padding:8px;	
            }
        </style>
        <script type="text/javascript">

            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-30181575-1']);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();

        </script>        
    </head>
    <body>        
        <div class="relpagina">
            <?php
            include "controle/conexao.php";
            include "controle/conexao_tipo.php";
            include "funcoes.php";
            ?>
            <div class="relcorpo">
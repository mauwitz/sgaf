
function valida_filtro_entradas_numero() {  
    if(document.formfiltro.filtronumero.value == "") {
        document.formfiltro.filtrofornecedor.disabled=false;
        document.formfiltro.filtrosupervisor.disabled=false;
        document.formfiltro.filtroproduto.disabled=false;
    }
    else {  
        document.formfiltro.filtrofornecedor.disabled=true;
        document.formfiltro.filtrosupervisor.disabled=true;
        document.formfiltro.filtroproduto.disabled=true;
    } 
}
function valida_filtro_saidas_numero() {  
    if(document.formfiltro.filtro_numero.value == "") {
        document.formfiltro.filtro_consumidor.disabled=false;
        document.formfiltro.filtro_produto.disabled=false;
        document.formfiltro.filtro_lote.disabled=false;
    }
    else {  
        document.formfiltro.filtro_consumidor.disabled=true;
        document.formfiltro.filtro_produto.disabled=true;
        document.formfiltro.filtro_lote.disabled=true;
    } 
}
function valida_filtro_saidas_devolucao_numero() {  
    if(document.form_filtro.filtro_numero.value == "") {
        document.form_filtro.filtro_motivo.disabled=false;
        document.form_filtro.filtro_descricao.disabled=false;
        document.form_filtro.filtro_supervisor.disabled=false;
    //document.formfiltro.filtro_fornecedor.disabled=false;
    }
    else {  
        document.form_filtro.filtro_motivo.disabled=true;
        document.form_filtro.filtro_descricao.disabled=true;
        document.form_filtro.filtro_supervisor.disabled=true;
    //document.formfiltro.filtro_fornecedor.disabled=true;
    } 
}
function valida_filtro_pessoas_id() {  
    if(document.formfiltro.filtroid.value == "") {
        document.formfiltro.filtronome.disabled=false;
        document.formfiltro.filtrotipo.disabled=false;
    }
    else {  
        document.formfiltro.filtronome.disabled=true;
        document.formfiltro.filtronome.value="";
        document.formfiltro.filtrotipo.disabled=true;
    } 
}
function validarEntero(valor){
    //intento convertir a entero. 
    //si era un entero no le afecta, si no lo era lo intenta convertir
    valor = parseInt(valor)

    //Compruebo si es un valor num�rico
    if (isNaN(valor)) {
        //entonces (no es un numero) devuelvo el valor cadena vacia
        return ""
    }else{
        //En caso contrario (Si era un n�mero) devuelvo el valor
        return valor
    }
}

function valida_entradas_qtd(){
    //extraemos el valor del campo
    textoCampo = window.document.form1.qtd.value
    //lo validamos como entero
    textoCampo = validarEntero(textoCampo)
    //colocamos el valor de nuevo
    window.document.form1.qtd.value = textoCampo
}

function valida_entradas_id(){
    //extraemos el valor del campo
    textoCampo = window.document.form1.idfornecedor.value
    //lo validamos como entero
    textoCampo = validarEntero(textoCampo)
    //colocamos el valor de nuevo
    window.document.form1.idfornecedor.value = textoCampo

    //aqui � feito o tratamento para desabilitar alguns campos do formulario ao entrar neste campo!
    if(document.form1.idfornecedor.value == "") {
        document.form1.fornecedor.disabled=false;
    }
    else {  
        document.form1.fornecedor.disabled=true;
    } 
}
//funcao que faz os iframes auto redimensionar a altura conforme o seu conteudo
function autoResize(id){
    var newheight;
    var newwidth;

    if(document.getElementById){
        newheight=document.getElementById(id).contentWindow.document .body.scrollHeight;
        newwidth=document.getElementById(id).contentWindow.document .body.scrollWidth;
    }

    document.getElementById(id).height= (newheight) + "px";
    document.getElementById(id).width= (newwidth) + "px";
}



function somente_numero(campo) {  
    var digits="0123456789.,"
    var campo_temp 
    for (var i=0;i<campo.value.length;i++){
        campo_temp=campo.value.substring(i,i+1) 
        if (digits.indexOf(campo_temp)==-1){
            campo.value = campo.value.substring(0,i);
        }
    }    
}
function mascara_quantidade() {
    $('#qtd').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
    });
    verifica_incluir();
}

function mascara_pesoqtd(){  
    $.post("entradas_qtdtipcon.php",{
        produto:$("select[name=produto]").val()
    },function(valor){
        $("span[name=qtdtipconcod]").html(valor);
        //alert (valor);
        if (valor=="<b>por un.</b>") {
            $('#qtd').priceFormat({
                prefix: '',  
                centsSeparator: '',  
                centsLimit:0,  
                thousandsSeparator: '.'  
            }); 
        //alert("qtd");
        } else {
            $('#qtd').priceFormat({
                prefix: '',  
                centsSeparator: ',',  
                centsLimit: 3,  
                thousandsSeparator: '.'  
            }); 
        //alert("peso");
        }            
    });
    verifica_incluir();
}  
function mascara_quantidade_ideal() {
    $('#qtdide').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
    });
    verifica_incluir();
}

function pessoas_filtro_id() {
    
    if(document.formfiltro.filtro_id.value == "") {
        document.formfiltro.filtro_nome.disabled=false;
        document.formfiltro.filtro_tipo.disabled=false;
        document.formfiltro.filtro_possuiacesso.disabled=false;
    }
    else {  
        document.formfiltro.filtro_nome.disabled=true;
        document.formfiltro.filtro_nome.value="";
        document.formfiltro.filtro_tipo.disabled=true;
        document.formfiltro.filtro_possuiacesso.disabled=true;
    } 
}

//FUN��S DA TELA DE PRODUTOS CADASTRAR
function sigla() {
    $.post("tipo_contagem_sigla.php", {
        tipocontagem: $("select[name=tipo]").val()
    }, function (valor) {
        $("label[name=sigla]").html(valor);        
    });
}
function etqmin() {
    $('#etqmin').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
    }); 
}
function valorpago() {                    
    $('#valpago').priceFormat({
        prefix: 'R$ ',
        centsSeparator: ',',
        thousandsSeparator: '.'
    });
} 
function estoquemin() {                    
    $('#estoqueminimo').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
    });
} 
function submitenter(myfield,e)
{
    var keycode;
    if (window.event) keycode = window.event.keyCode;
    else if (e) keycode = e.which;
    else return true;

    if (keycode == 13)
    {
        validar_usuario();                         
        return false;
    }
    else
        return true;
}
            
function valida_cpf(cpf){
    cpf = cpf.replace("-", "");
    cpf = cpf.replace(".", ""); //NAO excluir
    cpf = cpf.replace(".", ""); //tem que ser duas vezes
    cpf = cpf.replace("_", ""); 
    //alert(cpf);
    if (cpf!="99999999999") {
                    
        var numeros, digitos, soma, i, resultado, digitos_iguais;
        digitos_iguais = 1;
        if (cpf.length < 11) {                
            $("input[name=cpf]").val("");
            return false;
        }
        //alert(cpf.length);
        for (i = 0; i < cpf.length - 1; i++)
            if (cpf.charAt(i) != cpf.charAt(i + 1))
            {
                digitos_iguais = 0;
                break;
            }
        if (!digitos_iguais)
        {
            numeros = cpf.substring(0,9);
            digitos = cpf.substring(9);
            soma = 0;
            for (i = 10; i > 1; i--)
                soma += numeros.charAt(10 - i) * i;
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(0)) {
                alert('O CPF digitado não é válido! Digite novamente');
                $("select[name=metodo]").html("<option>Selecione</option>");
                $("input[name=cpf]").val("");
                $("input[name=cpf]").focus();
                $("tr[id=tr_email]").hide();            
                $("input[name=email]").attr("required", false);
                $("input[name=resposta]").attr("required", false);                
                $("tr[id=tr_pergunta]").hide(); 
                $("tr[id=tr_resposta]").hide(); 
                return false;
            }
            numeros = cpf.substring(0,10);
            soma = 0;
            for (i = 11; i > 1; i--)
                soma += numeros.charAt(11 - i) * i;
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(1)) {
                alert('O CPF digitado não é válido! Digite novamente');
                $("select[name=metodo]").html("<option>Selecione</option>");
                $("input[name=cpf]").val("");
                $("input[name=cpf]").focus();
                $("tr[id=tr_email]").hide();            
                $("input[name=email]").attr("required", false);
                $("input[name=resposta]").attr("required", false);
                $("tr[id=tr_pergunta]").hide();                 
                $("tr[id=tr_resposta]").hide();                 
                return false;
            }
            //alert('CPF Verdadeiro');
            return true;
        }
        else {
            var s= "O CPF digitado não é válido! Digite novamente";
            alert(s);
            $("select[name=metodo]").html("<option>Selecione</option>");
            $("input[name=email]").attr("required", false);
            $("input[name=resposta]").attr("required", false);            
            $("tr[id=tr_email]").hide();            
            $("tr[id=tr_pergunta]").hide();                
            $("input[name=cpf]").val("");
            $("input[name=cpf]").focus();
            return false;
        }
    }
}

function popula_estados() {
    $("select[name=estado]").html('<option>Carregando</option>');   
    $("select[name=cidade]").html('<option>Selecione</option>');    
    $.post("paisestado.php", {
        pais:$("select[name=pais]").val()
    }, function(valor) {
        $("select[name=estado]").html(valor);
    });
}
        
function popula_cidades() {            
    $("select[name=cidade]").html('<option>Carregando</option>');
    $.post("estadocidade.php", {
        estado:$("select[name=estado]").val()
    }, function(valor) {
        $("select[name=cidade]").html(valor);
    });
}

function popula_quiosques() {            
    $("select[name=quiosqueusuario]").html('<option>Carregando</option>');
    $.post("verifica_quiosqueusuario.php", {
        cooperativa:$("select[name=cooperativa]").val(),
        pessoa:$("input[name=codigo]").val()
    }, function(valor) {
        $("select[name=quiosqueusuario]").html(valor);
    });
}

function verifica_cpf_cadastro(valor,valor2,pessoa_cod,operacao) {
    valor = valor.replace("_", "");
    valor = valor.replace("_", "");
    valor = valor.replace("_", "");
    valor = valor.replace("_", "");
    valor = valor.replace("_", "");
    valor = valor.replace("_", "");
    valor = valor.replace("_", "");
    valor = valor.replace("_", "");
    valor = valor.replace("_", "");
    valor = valor.replace("_", "");
    valor = valor.replace("_", "");
    valor = valor.replace("-", "");
    valor = valor.replace(".", "");
    valor = valor.replace(".", "");
    valor = valor.replace(".", "");
    //alert(valor);
    if(valor.length==11) {
        //alert('entrou é 11')
        $.post("verifica_cpf_cadastro.php", {
            cpf:$("input[name=cpf]").val(),
            pessoa:pessoa_cod,
            oper:operacao
        }, function(valor) {
            //alert(valor);
            if (valor2==1) {
                if (valor>0) { 
                    alert("Este cpf já está cadastrado no sistema, por favor utilize os metodos de recuperação de senha!");
                    $("input[name=cpf]").val("");                    
                } else {
                //Existe uma pessoa cadastrada com esse CPF
                }
            } else if (valor2==2) { 
                if (valor>0) {
                    //CPF é valido, está sendo usado por alguém
                    $.post("verifica_cpf2.php", {
                        cpf:$("input[name=cpf]").val()
                    }, function(valor3) {
                        $("select[name=metodo]").html(valor3);
                    });
                } else {
                    alert("Não tem ninguem usando esse CPF no sistema");
                    $("select[name=metodo]").html("<option>Selecione</option>");
                    $("input[name=cpf]").val("");
                    $("input[name=cpf]").focus();
                    $("tr[id=tr_email]").hide();
                    $("input[name=email]").attr("required", false);
                    $("input[name=resposta]").attr("required", false);                    
                    $("tr[id=tr_pergunta]").hide();                     
                    $("tr[id=tr_resposta]").hide();                     
                }
            } else {
            //alert("Erro de parametro na função verifica_cpf_cadastro");
            }
            
        });
    }
}

function verifica_metodo(valor) {
    //alert(valor);
    $.post("verifica_metodo.php", {
        metodo:valor,
        cpf:$("input[name=cpf]").val()
    }, function(valor2) {    
        if (valor==1) { 
            // Pergunta e Resposta
            $("input[name=email]").attr("required", false);
            $("tr[id=tr_email]").hide();            
            $("tr[id=tr_pergunta]").show();            
            $("input[name=pergunta]").val(valor2);
            $("tr[id=tr_resposta]").show();            
            $("input[name=resposta]").attr("required", true);
        } else if (valor==2) {
            //Email
            $("input[name=email]").attr("required", true);
            $("input[name=resposta]").attr("required", false);
            //$("input[name=email]").val(valor2);
            $("tr[id=tr_email]").show();             
            $("tr[id=tr_pergunta]").hide();             
            $("tr[id=tr_resposta]").hide();             
        } else {
        //alert("Erro grave de parametro");
        }        
    }); 

}

function verifica_maioridade (valor) {    
    //alert(valor);
    var valor2=valor.replace("_","");
    valor2=valor2.replace("_","");
    valor2=valor2.replace("_","");
    valor2=valor2.replace("_","");
    valor2=valor2.replace("_","");
    valor2=valor2.replace("_","");
    valor2=valor2.replace("_","");
    valor2=valor2.replace("_","");
    var valor3 = valor2.split("/");    
    var dia=valor3[0];
    var mes=valor3[1];
    var ano=valor3[2];
    //alert(valor3);
    
    if (valor2.length==10) {       
        if((parseInt(parseInt(new Date().getMonth()+1+new Date().getDate()))<((parseInt(dia)+parseInt(mes)))))
        {
            var idade = ((parseInt(new Date().getFullYear())-(parseInt(ano))-1));
        }
        else
            var idade = ((parseInt(new Date().getFullYear())-(parseInt(ano))));
        if (idade<18) {
            
            alert('Você tem menos que 18 anos! Por favor, solicite que um adulto faça o cadastro! Não é permitido que pessoas com menos de 18 anos cadastrem-se');
            window.location.href = window.location;
        }
    }
}
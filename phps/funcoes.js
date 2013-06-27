

function valida_filtro_entradas_numero() {
    if (document.formfiltro.filtronumero.value == "") {
        document.formfiltro.filtrofornecedor.disabled = false;
        document.formfiltro.filtrosupervisor.disabled = false;
        document.formfiltro.filtroproduto.disabled = false;
    }
    else {
        document.formfiltro.filtrofornecedor.disabled = true;
        document.formfiltro.filtrosupervisor.disabled = true;
        document.formfiltro.filtroproduto.disabled = true;
    }
}
function valida_filtro_saidas_numero() {
    if (document.formfiltro.filtro_numero.value == "") {
        document.formfiltro.filtro_consumidor.disabled = false;
        document.formfiltro.filtro_produto.disabled = false;
        document.formfiltro.filtro_lote.disabled = false;
    }
    else {
        document.formfiltro.filtro_consumidor.disabled = true;
        document.formfiltro.filtro_produto.disabled = true;
        document.formfiltro.filtro_lote.disabled = true;
    }
}
function valida_filtro_saidas_devolucao_numero() {
    if (document.form_filtro.filtro_numero.value == "") {
        document.form_filtro.filtro_motivo.disabled = false;
        document.form_filtro.filtro_descricao.disabled = false;
        document.form_filtro.filtro_supervisor.disabled = false;
    //document.formfiltro.filtro_fornecedor.disabled=false;
    }
    else {
        document.form_filtro.filtro_motivo.disabled = true;
        document.form_filtro.filtro_descricao.disabled = true;
        document.form_filtro.filtro_supervisor.disabled = true;
    //document.formfiltro.filtro_fornecedor.disabled=true;
    }
}
function valida_filtro_acertos_revenda_numero() {
    if (document.form_filtro.filtro_numero.value == "") {
        document.form_filtro.filtro_supervisor.disabled = false;
        document.form_filtro.filtro_dataini.disabled = false;
        document.form_filtro.filtro_datafim.disabled = false;
        document.form_filtro.filtro_horaini.disabled = false;
        document.form_filtro.filtro_horafim.disabled = false;
    //document.formfiltro.filtro_fornecedor.disabled=false;
    }
    else {
        document.form_filtro.filtro_supervisor.disabled = true;
        document.form_filtro.filtro_dataini.disabled = true;
        document.form_filtro.filtro_datafim.disabled = true;
        document.form_filtro.filtro_horaini.disabled = true;
        document.form_filtro.filtro_horafim.disabled = true;
    }
}
function valida_filtro_acertos_revenda_datas() {
    if ((document.form_filtro.filtro_dataini.value != "") || (document.form_filtro.filtro_datafim.value != "") || (document.form_filtro.filtro_horaaini.value != "") || (document.form_filtro.filtro_horafim.value != "")) {
        document.form_filtro.filtro_supervisor.disabled = true;
        document.form_filtro.filtro_numero.disabled = true;
    }
    else {
        document.form_filtro.filtro_supervisor.disabled = false;
        document.form_filtro.filtro_numero.disabled = false;
    }
}
function valida_filtro_pessoas_id() {
    if (document.formfiltro.filtroid.value == "") {
        document.formfiltro.filtronome.disabled = false;
        document.formfiltro.filtrotipo.disabled = false;
    }
    else {
        document.formfiltro.filtronome.disabled = true;
        document.formfiltro.filtronome.value = "";
        document.formfiltro.filtrotipo.disabled = true;
    }
}
function validarEntero(valor) {
    //intento convertir a entero. 
    //si era un entero no le afecta, si no lo era lo intenta convertir
    valor = parseInt(valor)

    //Compruebo si es un valor num�rico
    if (isNaN(valor)) {
        //entonces (no es un numero) devuelvo el valor cadena vacia
        return ""
    } else {
        //En caso contrario (Si era un n�mero) devuelvo el valor
        return valor
    }
}

function valida_entradas_qtd() {
    //extraemos el valor del campo
    textoCampo = window.document.form1.qtd.value
    //lo validamos como entero
    textoCampo = validarEntero(textoCampo)
    //colocamos el valor de nuevo
    window.document.form1.qtd.value = textoCampo
}

function valida_entradas_id() {
    //extraemos el valor del campo
    textoCampo = window.document.form1.idfornecedor.value
    //lo validamos como entero
    textoCampo = validarEntero(textoCampo)
    //colocamos el valor de nuevo
    window.document.form1.idfornecedor.value = textoCampo

    //aqui � feito o tratamento para desabilitar alguns campos do formulario ao entrar neste campo!
    if (document.form1.idfornecedor.value == "") {
        document.form1.fornecedor.disabled = false;
    }
    else {
        document.form1.fornecedor.disabled = true;
    }
}
//funcao que faz os iframes auto redimensionar a altura conforme o seu conteudo
function autoResize(id) {
    var newheight;
    var newwidth;

    if (document.getElementById) {
        newheight = document.getElementById(id).contentWindow.document.body.scrollHeight;
        newwidth = document.getElementById(id).contentWindow.document.body.scrollWidth;
    }

    document.getElementById(id).height = (newheight) + "px";
    document.getElementById(id).width = (newwidth) + "px";
}



function somente_numero(campo) {
    var digits = "0123456789.,"
    var campo_temp
    for (var i = 0; i < campo.value.length; i++) {
        campo_temp = campo.value.substring(i, i + 1)
        if (digits.indexOf(campo_temp) == -1) {
            campo.value = campo.value.substring(0, i);
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

function calcula_valor2_unitario() {
    var desconto = $("input[name=percent]").val();
    desconto = desconto.replace(",", ".");
    var venda = $("input[name=valuni]").val();
    venda = venda.replace("R$ ", "");
    venda = venda.replace(",", ".");
    var custo = 0;
    custo = venda * (100 - desconto) / 100;
    custo = custo.toFixed(2);
    //alert(custo);
    var custo2 = String(custo);
    custo2 = custo2.replace(".", ",");
    custo2 = "R$ " + custo2;
    //alert(custo2);
    $("input[name=valunicusto]").val(custo2);

    //(200/260*100)-100
    var percent2 = ((venda / custo * 100) - 100);
    percent2 = percent2.toFixed(2);
    percent2 = percent2.replace(".", ",");
    $("input[name=percent2]").val(percent2);

}

function calcula_valor_percent() {
    var custo = $("input[name=valunicusto]").val();
    var venda = $("input[name=valuni]").val();
    custo = custo.replace("R$ ", "");
    custo = custo.replace(",", ".");
    custo = parseFloat(custo);
    venda = venda.replace("R$ ", "");
    venda = venda.replace(",", ".");
    venda = parseFloat(venda);

    //=(venda*100/custo)-100    
    if (venda != 0)
        percent = (venda * 100 / custo) - 100;
    else
        percent = 0;

    percent = percent.toFixed(2);
    var per = String(percent);
    per = per.replace(".", ",");
    
    //alert(custo2);
    $("input[name=percent2]").val(per);

    if (venda != 0)
        percent2 = -((custo * 100 / venda) - 100);
    else
        percent2 = 0;
    percent2 = percent2.toFixed(2);
    percent2 = percent2.replace(".", ",");
    $("input[name=percent]").val(percent2);


}

function calcula_valor_unitario() {
    var desconto = $("input[name=percent]").val();
    desconto = desconto.replace(",", ".");
    var venda = $("input[name=valuni]").val();
    venda = venda.replace("R$ ", "");
    venda = venda.replace(",", ".");
    var custo = 0;
    custo = venda * (100 - desconto) / 100;
    custo = custo.toFixed(2);
    //alert(custo);
    var custo2 = String(custo);
    custo2 = custo2.replace(".", ",");
    custo2 = "R$ " + custo2;
    //alert(custo2);
    $("input[name=valunicusto]").val(custo2);

    //(200/260*100)-100

    var percent2 = parseFloat(0);
    if ((custo != 0) && (venda != 0))
        percent2 = ((venda / custo * 100) - 100);
    else
        percent2 = 0;
    percent2 = percent2.toFixed(2);
    percent2 = percent2.replace(".", ",");
    $("input[name=percent2]").val(percent2);

}

function calcula_valor_venda() {
    var percent2 = $("input[name=percent2]").val();
    percent2 = percent2.replace(",", ".");
    var custo = $("input[name=valunicusto]").val();
    custo = custo.replace("R$ ", "");
    custo = custo.replace(",", ".");
    custo = parseFloat(custo);
    var venda = 0;
    venda = parseFloat(venda);
    percent2 = parseFloat(percent2);
    venda = (custo * (100 + percent2)) / 100;
    venda = venda.toFixed(2);
    var venda2 = String(venda);
    venda2 = venda2.replace(".", ",");
    venda2 = "R$ " + venda2;
    //alert(custo2);
    $("input[name=valuni]").val(venda2);

    //(200/260*100)-100
    var percent = parseFloat(0);
    if ((custo != 0) && (venda != 0))
        percent = -((custo / venda * 100) - 100);
    else
        percent = 0;
    percent = percent.toFixed(2);
    percent = percent.replace(".", ",");
    $("input[name=percent]").val(percent);
}

function calcula_saldovalidade(valor) {

    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!

    var yyyy = today.getFullYear();
    if (dd < 10)
        dd = '0' + dd
    if (mm < 10)
        mm = '0' + mm
    var today = yyyy + '-' + mm + '-' + dd;

    var hoje = today;
    var validade = valor;

    var dias = diasentredatas(hoje, validade);    
    if (dias >= 0) {        
        $("span[name=saldovalidade]").attr('class', "dicacampo");
        $("span[name=saldovalidade]").html("vencerá em "+dias + " dias");
    }
    else if (dias < 0) {
        $("span[name=saldovalidade]").attr('class', "dicacampo-vermelho");
        $("span[name=saldovalidade]").html("venceu a "+dias + " dias");
    }
    else
        $("span[name=saldovalidade]").html("");
}

function diasentredatas(valor1, valor2) {

    var date1 = valor2;
    var date2 = valor1;
    date1 = date1.split("-");
    date2 = date2.split("-");
    var sDate = new Date(date1[0] + "/" + date1[1] + "/" + date1[2]);
    var eDate = new Date(date2[0] + "/" + date2[1] + "/" + date2[2]);
    var daysApart = Math.round((sDate - eDate) / 86400000);
    return daysApart
}

function popula_produtos_pelamarca(valor) {

    if (valor == 'todas') {
        $.post("entradas_popula_produtos_pelamarca2.php", {
            tiponeg: $("input[name=tiponegociacao2]").val()
        }, function(valor2) {
            $("select[name=produto]").html(valor2);
        });
    } else {
        $.post("entradas_popula_produtos_pelamarca.php", {
            marca: valor
        }, function(valor2) {
            $("select[name=produto]").html(valor2);
        });
    }
}


function mascara_pesoqtd() {
    $.post("entradas_qtdtipcon.php", {
        produto: $("select[name=produto]").val()
    }, function(valor) {
        $("span[name=qtdtipconcod]").html(valor);
        //alert (valor);
        if (valor == "<b>por un.</b>") {
            $('#qtd').priceFormat({
                prefix: '',
                centsSeparator: '',
                centsLimit: 0,
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

    if (document.formfiltro.filtro_id.value == "") {
        document.formfiltro.filtro_nome.disabled = false;
        document.formfiltro.filtro_tipo.disabled = false;
        document.formfiltro.filtro_possuiacesso.disabled = false;
    }
    else {
        document.formfiltro.filtro_nome.disabled = true;
        document.formfiltro.filtro_nome.value = "";
        document.formfiltro.filtro_tipo.disabled = true;
        document.formfiltro.filtro_possuiacesso.disabled = true;
    }
}

//FUN��S DA TELA DE PRODUTOS CADASTRAR
function sigla() {
    $.post("tipo_contagem_sigla.php", {
        tipocontagem: $("select[name=tipo]").val()
    }, function(valor) {
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
function submitenter(myfield, e)
{
    var keycode;
    if (window.event)
        keycode = window.event.keyCode;
    else if (e)
        keycode = e.which;
    else
        return true;

    if (keycode == 13)
    {
        validar_usuario();
        return false;
    }
    else
        return true;
}

function valida_cpf(cpf) {
    cpf = cpf.replace("-", "");
    cpf = cpf.replace(".", ""); //NAO excluir
    cpf = cpf.replace(".", ""); //tem que ser duas vezes
    cpf = cpf.replace("_", "");
    //alert(cpf);
    if (cpf != "99999999999") {

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
            numeros = cpf.substring(0, 9);
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
            numeros = cpf.substring(0, 10);
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
            var s = "O CPF digitado não é válido! Digite novamente";
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
function valida_cnpj(cnpj) {
    cnpj = cnpj.replace(/[^\d]+/g, '');

    if (cnpj == '')
        return false;

    if (cnpj.length != 14)
        return false;

    // Elimina CNPJs invalidos conhecidos
    if (cnpj == "00000000000000" ||
        cnpj == "11111111111111" ||
        cnpj == "22222222222222" ||
        cnpj == "33333333333333" ||
        cnpj == "44444444444444" ||
        cnpj == "55555555555555" ||
        cnpj == "66666666666666" ||
        cnpj == "77777777777777" ||
        cnpj == "88888888888888" ||
        cnpj == "99999999999999") {

        alert("CNPJ Inválido");
        $("input[name=cnpj]").val("");
        $("input[name=cnpj]").focus();
        return false;
    }

    // Valida DVs
    tamanho = cnpj.length - 2
    numeros = cnpj.substring(0, tamanho);
    digitos = cnpj.substring(tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(0)) {
        alert("CNPJ Inválido");
        $("input[name=cnpj]").val("");
        $("input[name=cnpj]").focus();
        return false;
    }

    tamanho = tamanho + 1;
    numeros = cnpj.substring(0, tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(1)) {
        alert("CNPJ Inválido");
        $("input[name=cnpj]").val("");
        $("input[name=cnpj]").focus();
        return false;

    }

//alert("CNPJ Valido!");

}


function popula_estados() {
    $("select[name=estado]").html('<option>Carregando</option>');
    $("select[name=cidade]").html('<option>Selecione</option>');
    $.post("paisestado.php", {
        pais: $("select[name=pais]").val()
    }, function(valor) {
        $("select[name=estado]").html(valor);
    });
}

function popula_cidades() {
    $("select[name=cidade]").html('<option>Carregando</option>');
    $.post("estadocidade.php", {
        estado: $("select[name=estado]").val()
    }, function(valor) {
        $("select[name=cidade]").html(valor);
    });
}

function popula_quiosques() {
    $("select[name=quiosqueusuario]").html('<option>Carregando</option>');
    $.post("verifica_quiosqueusuario.php", {
        cooperativa: $("select[name=cooperativa]").val(),
        pessoa: $("input[name=codigo]").val()
    }, function(valor) {
        $("select[name=quiosqueusuario]").html(valor);
    });
}

function verifica_cpf_cadastro(valor, valor2, pessoa_cod, operacao) {
    //valor2 = 1 quando é verificação normal
    //valor2 = 2 quando é para a tela de esquecí minha senha
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
    if (valor.length == 11) {
        //alert('entrou é 11')
        $.post("verifica_cpf_cadastro.php", {
            cpf: $("input[name=cpf]").val(),
            pessoa: pessoa_cod,
            oper: operacao,
            valor2: valor2
        }, function(valor3) {
            //alert(valor3);
            if (valor2 == 1) {
                //Esta parte refere-se a tela de cadastro e edição de PESSOAS ou CADASTRE-SE
                if (valor3 > 0) {
                    alert("Este cpf já está cadastrado no sistema, por favor utilize os metodos de recuperação de senha!");
                    $("input[name=cpf]").val("");
                } else {
                //Existe uma pessoa cadastrada com esse CPF
                }
            } else if (valor2 == 2) {
                //Esta parte refere-se a tela 'Esquecí minha senha''
                if (valor3 > 0) {
                    //CPF é valido, está sendo usado por alguém
                    $.post("verifica_cpf2.php", {
                        cpf: $("input[name=cpf]").val()
                    }, function(valor4) {
                        //alert(valor4);
                        if (valor4 == 'nenhum') {
                            alert("O CPF digitado não possui nenhum método de recuperação de senha. Por favor entre em contato com os administradores para recuperar sua senha!");
                            $("select[name=metodo]").html("<option>Selecione</option");
                            $("input[name=cpf]").val("");
                            $("input[name=cpf]").focus();
                        } else if (valor4 == 'naopossuiacesso') {
                            alert("O CPF digitado está cadastrado, mas não possui acesso ao sistema!");
                            $("input[name=cpf]").val("");
                            $("input[name=cpf]").focus();
                        } else {
                            $("select[name=metodo]").html(valor4);
                        }
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
function verifica_cnpj_cadastro(valor, pessoa_cod, operacao) {
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
    valor = valor.replace("_", "");
    valor = valor.replace("_", "");
    valor = valor.replace("_", "");
    valor = valor.replace(".", "");
    valor = valor.replace(".", "");
    valor = valor.replace("-", "");
    valor = valor.replace("/", "");
    //alert(valor);
    if (valor.length == 14) {
        //alert('entrou é 14')
        $.post("verifica_cnpj_cadastro.php", {
            cnpj: $("input[name=cnpj]").val(),
            pessoa: pessoa_cod,
            oper: operacao
        }, function(valor) {
            //alert(valor);
            if (valor > 0) {
                alert("Este CNPJ já está cadastrado no sistema!");
                $("input[name=cnpj]").val("");
                $("input[name=cnpj]").focus();
            } else {
            //O CNPJ não está sendo usado por ninguém
            }
        });
    }
}

function verifica_metodo(valor) {
    //alert(valor);
    $.post("verifica_metodo.php", {
        metodo: valor,
        cpf: $("input[name=cpf]").val()
    }, function(valor2) {
        if (valor == 1) {
            // Pergunta e Resposta
            $("input[name=email]").attr("required", false);
            $("tr[id=tr_email]").hide();
            $("tr[id=tr_pergunta]").show();
            $("input[name=pergunta]").val(valor2);
            $("tr[id=tr_resposta]").show();
            $("input[name=resposta]").attr("required", true);
        } else if (valor == 2) {
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

function verifica_maioridade(valor) {
    //alert(valor);
    var valor2 = valor.replace("_", "");
    valor2 = valor2.replace("_", "");
    valor2 = valor2.replace("_", "");
    valor2 = valor2.replace("_", "");
    valor2 = valor2.replace("_", "");
    valor2 = valor2.replace("_", "");
    valor2 = valor2.replace("_", "");
    valor2 = valor2.replace("_", "");
    var valor3 = valor2.split("/");
    var dia = valor3[0];
    var mes = valor3[1];
    var ano = valor3[2];
    //alert(valor3);

    if (valor2.length == 10) {
        if ((parseInt(parseInt(new Date().getMonth() + 1 + new Date().getDate())) < ((parseInt(dia) + parseInt(mes)))))
        {
            var idade = ((parseInt(new Date().getFullYear()) - (parseInt(ano)) - 1));
        }
        else
            var idade = ((parseInt(new Date().getFullYear()) - (parseInt(ano))));
        if (idade < 18) {

            alert('Você tem menos que 18 anos! Por favor, solicite que um adulto faça o cadastro! Não é permitido que pessoas com menos de 18 anos cadastrem-se');
            window.location.href = window.location;
        }
    }
}
function popula_tipopessoa(valor) {
    //alert (valor);
    if (valor == "") {
        $("select[name=tipopessoa]").html("<option value=''>Selecione</option>");
        $("select[name=fornecedor]").html("<option value=''>Selecione</option>");
    }
    else {
        $("select[name=fornecedor]").html("<option value=''>Selecione</option>");
        $.post("entradas_popula_tipopessoa.php", {
            tiponegociacao: valor
        }, function(valor2) {
            //alert(valor2);            
            $("select[name=tipopessoa]").html(valor2);
        });
        tippes = "";
        $.post("entradas_popula_fornecedores.php", {
            tipopessoa: tippes,
            tiponegociacao: valor
        }, function(valor2) {
            //alert(valor2);
            $("select[name=fornecedor]").html(valor2);
        });
    }
}
function popula_fornecedores2(valor) {
    $.post("entradas_popula_fornecedores2.php", {
        tipopessoa: valor

    }, function(valor2) {
        //alert(valor2);
        $("select[name=fornecedor]").html(valor2);
    });
}

function popula_quiosque_tiponegociacao(valor) {
    $.post("taxas_popula_tiponegociacao.php", {
        quiosque: valor
    }, function(valor2) {
        //alert(valor2);
        $("select[name=tiponegociacao]").html(valor2);
    });
}

function valorareceber (valor) {
    if (valor==1) {
        document.form1.metodopag.disabled = true;
        $("tr[id=tr_metodopag]").hide();
        document.form1.dinheiro.disabled = true;
        $("tr[id=tr_dinheiro]").hide();
    } else {
        $("tr[id=tr_metodopag]").show();
        document.form1.metodopag.disabled = false;
        $("tr[id=tr_dinheiro]").show();
        document.form1.dinheiro.disabled = false;
    }
}
function metodopagamento(valor) {    
    var total = $("input[name=total]").val();
    if ((valor==1)||(valor==4)||(valor==5)) {
        $("input[name=dinheiro]").val("");
    } else if (valor==2) {
        $("input[name=dinheiro]").val(total);
    } else if (valor==3) {
        $("input[name=dinheiro]").val(total);
    }
}

function quiosque_taxas_popula_taxa (valor) {
    //alert(valor);
    $.post("quiosque_taxas_popula_taxa.php", {
        tiponegociacao: valor,
        quiosque: $("input[name=quiosque2]").val()
    }, function(valor2) {
        //alert(valor2);
        $("select[name=taxa]").html(valor2);
    }); 
    $.post("quiosque_taxas_popula_porcentagemmaxima.php", {
        tiponegociacao: valor,
        quiosque: $("input[name=quiosque2]").val(),
        percent: $("input[name=percent]").val()
    }, function(valor2) {
        //alert(valor2);
        $("span[id=permax]").html(valor2);
    }); 
    
    
}
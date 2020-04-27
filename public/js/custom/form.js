/*
-----------------------------------------
Declaração de Constantes
-----------------------------------------
*/
const MENSAGEM_PADRAO =                 "Insira suas Credenciais";
const MENSAGEM_VERIFICANDO =            "Verificando...";
const MENSAGEM_SUCESSO =                "Entrando...";
const FA_INFORMACAO =                   "<i class='fas fa-info-circle fa-lg'></i>&nbsp";
const FA_EXCLAMACAO =                   "<i class='fas fa-exclamation-circle fa-lg'></i>&nbsp";
const FA_CARREGANDO =                   "<i class='fas fa-circle-notch fa-spin'></i>&nbsp;";

function HelperErrors(caso) {
    //remover erros
    if (caso == 0) {
        $(".has-error").removeClass("has-error");
        $(".helper").addClass("no-error");
    }
    //add erros
    else if (caso == 1) {
        $(".helper").removeClass("no-error");
        $(".helper").addClass("has-error");
    }
    else {
        console.log("erro na chamada da funcao Helper");
    }
}

function clearErrors(msgPadrao){
	HelperErrors(0);
	$(".help-block").html(FA_INFORMACAO + msgPadrao);
}

function showErrors(error_list) {
    clearErrors(MENSAGEM_PADRAO);
	HelperErrors(1);

	$.each(error_list, function(id) {
        switch(id){
            case '#email':
                message = MENSAGEM_LOGIN_ERRO_USER;
                tipoErro(1, id);
                break;
            case '#senha':
                message = MENSAGEM_LOGIN_ERRO_PASSWORD;
                tipoErro(1, id);
                break;
            case '#botaoLogin':
                message = MENSAGEM_LOGIN_ERRO_VERIFICACAO;
                tipoErro(2, id);
                break;
            default:
                message = "erro";
                break
        }
        $(".help-block").html(FA_EXCLAMACAO + message);

	})
}

function loadingImg(message = "") {
	return FA_CARREGANDO + message
}

function tipoErro(tipo, id){
    if(tipo == 1){
        $(id).addClass("has-error");
        
    }else if(tipo == 2){
        $('#email').addClass("has-error");
        $('#senha').addClass("has-error");
    }
}
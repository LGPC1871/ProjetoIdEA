/*
-----------------------------------------
Declaração de Constantes
-----------------------------------------
*/
const MENSAGEM_LOGIN_ERRO_USER =        "Email Inválido";
const MENSAGEM_LOGIN_ERRO_PASSWORD =    "Senha Inválida";
const MENSAGEM_LOGIN_ERRO_VERIFICACAO=  "Email e/ou Senha incorretos";
const MENSAGEM_LOGIN_PADRAO =           "Insira suas Credenciais de Administrador";
const MENSAGEM_LOGIN_VERIFICANDO =      "Verificando...";
const MENSAGEM_LOGIN_SUCESSO =          "Entrando...";
const FA_INFORMACAO =                   "<i class='fas fa-info-circle fa-lg'></i>&nbsp";
const FA_EXCLAMACAO =                   "<i class='fas fa-exclamation-circle fa-lg'></i>&nbsp";
const FA_CARREGANDO =                   "<i class='fas fa-circle-notch fa-spin'></i>&nbsp;";
/*
-----------------------------------------
Funções JS e Jquery
-----------------------------------------
*/
function loginHelperErrors(caso){
	if(caso == 0){
		$(".has-error").removeClass("has-error");
		$(".login-helper").addClass("no-error");
	}else if(caso == 1){
		$(".login-helper").removeClass("no-error");
		$(".login-helper").addClass("has-error");
	}else{
		console.log("erro na chamada da funcao loginHelper");
	}
}
function clearErrors(){
	loginHelperErrors(0);
	$(".help-block").html(FA_INFORMACAO + MENSAGEM_LOGIN_PADRAO);
	$("#senha").val('').blur();
}
function tipoErro(tipo, id){
    if(tipo == 1){
        $(id).addClass("has-error");
        
    }else if(tipo == 2){
        $('#email').addClass("has-error");
        $('#senha').addClass("has-error");
    }
}
function showErrors(error_list) {
	clearErrors();
	loginHelperErrors(1);

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
/*
-----------------------------------------
Requisição Ajax
-----------------------------------------
*/
$(function (){
    $("#loginForm").submit(function(){
        $.ajax({
            type: "post",
            url: BASE_URL + "user/loginAjax",
            dataType: "json",
            data: $(this).serialize(),

            beforeSend: function(){
                clearErrors();
                $(".login-helper").children().html(loadingImg(MENSAGEM_LOGIN_VERIFICANDO));
            },

            success: function(json){
                if(json["status"] == 0){
                    $(".login-helper").children().html(loadingImg(MENSAGEM_LOGIN_SUCESSO));
                    window.location = BASE_URL + "user/profile";
                }else{
                    showErrors(json["error_list"]);
                }
            },

            error: function(response){
                console.log(response);
            }
            
        })
        return false;
    })
})
/*
-----------------------------------------
Declaração de Constantes
-----------------------------------------
*/
const MENSAGEM_LOGIN_ERRO_USER =        "Email Inválido";
const MENSAGEM_LOGIN_ERRO_PASSWORD =    "Senha Inválida";
const MENSAGEM_LOGIN_ERRO_VERIFICACAO=  "Email e/ou Senha incorretos";
/*
-----------------------------------------
Funções JS e Jquery
-----------------------------------------
*/
$(document).ready(function(){
    $(".help-block").html(FA_INFORMACAO + MENSAGEM_PADRAO);
});

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
                $("#botaoLoginGoogle").prop('disabled', true);
                $("#loginForm").attr('disabled', true);
                clearErrors(MENSAGEM_PADRAO);
                $(".helper").children().html(loadingImg(MENSAGEM_VERIFICANDO));
            },

            success: function(json){
                if(json["status"] == 0){
                    $(".helper").children().html(loadingImg(MENSAGEM_SUCESSO));
                    window.location = BASE_URL + "user/profile";
                }else{
                    showErrors(json["error_list"]);
                    $("#senha").val('').blur();
                    $("#botaoLoginGoogle").prop('disabled', false);
                    $("#loginForm").attr('disabled', false);
                }
            },

            error: function(response){
                console.log(response);
            }
            
        })
        return false;
    })
})
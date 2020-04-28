/*
|--------------------------------------------------------------------------
| Constantes
|--------------------------------------------------------------------------
| Todas as constantes de cadastro
*/
const TEXTO_BOTAO_GOOGLE =              "Entrar com Google";
const MENSAGEM_ERRO =                   "inválido";
const MENSAGEM_PADRAO =                 "Preencha os campos";
const MENSAGEM_VERIFICANDO =            "Verificando...";
const MENSAGEM_SUCESSO =                "Sucesso...";
const FA_INFORMACAO =                   "<i class='fas fa-info-circle fa-lg'></i>&nbsp";
const FA_EXCLAMACAO =                   "<i class='fas fa-exclamation-circle fa-lg'></i>&nbsp";
const FA_CARREGANDO =                   "<i class='fas fa-circle-notch fa-spin'></i>&nbsp;";

/*
|--------------------------------------------------------------------------
| Autoload
|--------------------------------------------------------------------------
| Todas funções que iniciam no load
*/
$(document).ready(function(){
    $(".help-block").html(FA_INFORMACAO + MENSAGEM_PADRAO);
});
/*
|--------------------------------------------------------------------------
| Funções
|--------------------------------------------------------------------------
| Todas as demais funções
*/

function showHelperErrors(caso){
    //show errors
    if(caso === true){
        $(".helper").removeClass("no-error");
        $(".helper").addClass("has-error");
    }
    //remove errors
    else if(caso === false){
        $(".has-error").removeClass("has-error");
        $(".helper").addClass("no-error");
    }
    else{
        console.log('invalid param for showErrors');
    }
}

function loadingRequest(caso){
    if(caso == 0){
        $(".help-block").html(FA_CARREGANDO + MENSAGEM_VERIFICANDO);
    }else if(caso == 1){
        $(".help-block").html(FA_CARREGANDO + MENSAGEM_SUCESSO);
    }
    else{
        console.log('invalid param for loadingRequest'); 
    }
}

function formAddErrors(error_list){
    $.each(error_list, function(id, value){
        $(value).addClass("has-error");
    })
}

function verifyFormInputs(error_list){
    var message = "";
    if(error_list.length > 0){
        message = "preencha todos os campos"
        $(".help-block").html(FA_EXCLAMACAO + message);
    }else{
        console.log("nenhum erro!");
    }
    message = "";
}

function invalidInfo(arrayCampos){
    var message = "";
    $.each(arrayCampos, function(indice, nome){
        if(indice < arrayCampos.length - 1){
            message += nome + "/";
        }else{
            message += nome + " ";
        }
    })
    $(".help-block").html(FA_EXCLAMACAO + message + MENSAGEM_ERRO);
}

function formStatus(caso){
    if(caso == 0){
        $("#form :input").prop("disabled", true);
        $("#botaoLoginGoogle").attr("style", "pointer-events:none");
    }else if(caso == 1){
        $("#form :input").prop("disabled", false);
        $("#botaoLoginGoogle").removeAttr("style", "pointer-events:none");
    }
    else{
        console.log('invalid param for formStatus');
    }
}
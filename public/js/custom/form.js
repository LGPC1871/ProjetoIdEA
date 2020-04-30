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
    function verifyFormInputs(response){
        showHelperErrors(true);
        formAddErrors(response["error_list"]);
        
        if(response["empty"] != 0){
            emptyFormInputs();
        }else{
            invalidInfo(response["error_list"]);
        }
    }

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

    function emptyFormInputs(){
        message = "preencha todos os campos"
        $(".help-block").html(FA_EXCLAMACAO + message);
    }

    function invalidInfo(error_list){
        var message = "";

        $.each(error_list, function(indice, nome){
            var text = $(nome).prev().text();
            if(error_list.length == 1){
                message += text + " ";
            }else if (indice == 0){
                message += text + "/";
            }else if (indice == 1){
                message += text + " ";
            }
        });

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


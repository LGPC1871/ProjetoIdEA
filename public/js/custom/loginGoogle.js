/*
|--------------------------------------------------------------------------
| Constantes
|--------------------------------------------------------------------------
| Todas as constantes google
*/

$(document).ready(function(){
    setTimeout(() => {
        changeBtnLanguage();
    }, 50);    
});

function onSignIn(googleUser) {
    var userToken = googleUser.getAuthResponse().id_token;
    var userData = {
        userToken: userToken
    }
    sendUserTokenToBackend(userData);
}

function sendUserTokenToBackend(userData){
    $.ajax({
        type: "POST",
        url: `${BASE_URL}user/ajax_googleSignIn`,
        dataType: "json",
        data: userData,

        beforeSend: function(){

            formStatus(0);
            showHelperErrors(false);
            loadingRequest(0);
            $("#botaoLogin").prop('disabled', true);

        },
        success: function(response){
            console.log(response);
            /*if(response["status"] == 0){
                loadingRequest(1);
                window.location = BASE_URL + "user/index";

            }else{
                genericError();
                formStatus(1)
                $("#botaoLogin").prop('disabled', false);

            }*/

        },
        error: function(response){
            console.log(response);
            genericError(1);
            formStatus(1);
            $("#botaoLogin").prop('disabled', false);
            
        }
    })
}

function changeBtnLanguage(){
    $(".abcRioButtonContents").first().html(TEXTO_BOTAO_GOOGLE);
}
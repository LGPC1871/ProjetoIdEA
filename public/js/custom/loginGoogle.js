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
        url: BASE_URL + 'user/googleAjaxLogin',
        data: userData,
        beforeSend: function(){
            formStatus(0);
            loadingRequest(0);
            $("#botaoLogin").prop('disabled', true);
        },
        success: function(){
            loadingRequest(1);
            window.location = BASE_URL + "user/profile";
        },
        error: function(){
            formStatus(1);
            $("#botaoLogin").prop('disabled', false);
        }
    })
}

function changeBtnLanguage(){
    $(".abcRioButtonContents").first().html(TEXTO_BOTAO_GOOGLE);
}
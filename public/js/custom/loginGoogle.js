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
            $("#botaoLogin").prop('disabled', true);
        },
        success: function(){
            window.location = BASE_URL + "user/profile";
        },
        error: function(){
            $("#botaoLogin").prop('disabled', false);
        }
    })
}
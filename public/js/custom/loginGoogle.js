function onSignIn(googleUser) {
    var userToken = googleUser.getAuthResponse().id_token;
    
    var userData = {
        userToken: userToken
    }

    sendUserTokenToBackend(userData);
}

function sendUserTokenToBackend(userData){
    $.ajax({
        'url': BASE_URL + 'user/googleAjaxLogin',
        'type': 'POST',
        'data': userData,
        'success': function(json){
            window.location = BASE_URL + "user/profile";
        },
        'error': function(){
            console.log('triste...')
        }
      })
}
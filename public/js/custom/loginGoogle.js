function onSignIn(googleUser) {
    var profile = googleUser.getBasicProfile();

    var userId = profile.getId();
    var userName = profile.getName();
    var userPicture = profile.getImageUrl();
    var userEmail = profile.getEmail();
    var userToken = googleUser.getAuthResponse().id_token;
    
    var userData = {
        userId: userId, 
        userName: userName,
        userPicture: userPicture,
        userEmail: userEmail,
        userToken: userToken
    }
    sendUserDataToBackend(userData);
}

function sendUserDataToBackend(userData){
    $.ajax({
        'url': BASE_URL + 'user/gLogin',
        'type': 'POST',
        'data': userData,
        'success': function(json){
            console.log(json)
        },
        'error': function(){
            console.log('triste...')
        }
      })
}
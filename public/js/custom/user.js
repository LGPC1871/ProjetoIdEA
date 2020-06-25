function onSignIn(googleUser) {
    var id_token = googleUser.getAuthResponse().id_token;
    
    /*
    var profile = googleUser.getBasicProfile();
        console.log("ID: " + profile.getId());
        console.log('Full Name: ' + profile.getName());
        console.log('Given Name: ' + profile.getGivenName());
        console.log('Family Name: ' + profile.getFamilyName());
        console.log("Image URL: " + profile.getImageUrl());
        console.log("Email: " + profile.getEmail());
    */
    var jsonInput = {
        token: id_token
    }

    let sendToBackEnd= function(jsonInput){
        $.ajax({
            type: "POST",
            url: `ajaxLoginGoogle`,
            dataType: "json",
            data: jsonInput,

            beforeSend: function(){
                console.log("enviando...");
            },
            success: function(response){
                console.log(response);
                //window.location = `profile`;
            },
            error: function(response){
                console.log(response);
            }
        })
    };

    sendToBackEnd(jsonInput);

    sendToBackEnd = undefined;
}
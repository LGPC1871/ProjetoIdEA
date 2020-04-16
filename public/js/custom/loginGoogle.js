function onSignIn(googleUser) {
    let profile = googleUser.getBasicProfile();
    let userId = profile.getId();
    let userToken = profile.getAuthResponse().id_token;
    let userName = profile.getName();
    let userEmail = profile.getName();
    let userPicture = profile.getImageUrl();


    console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
    console.log('Name: ' + profile.getName());
    console.log('Image URL: ' + profile.getImageUrl());
    console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
}
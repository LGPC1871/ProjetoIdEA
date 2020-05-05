$(function (){
    $("#form").submit(function(){
        $.ajax({
            type: "post",
            url: BASE_URL + "user/passwordRecovery",
            dataType: "json",
            data: $(this).serialize(),

            beforeSend: function(){
                formStatus(0);
                showHelperErrors(false);
                loadingRequest(0);
            },
            success: function(response){
                if(response["status"] == 0){
                    loadingRequest(1);
                }else{
                    formStatus(1);
                    verifyFormInputs(response);
                }
            },
            error: function(response){
                showHelperErrors(false);
                formStatus(1);
                console.log(response);
            } 
        })
        return false;
    })
})
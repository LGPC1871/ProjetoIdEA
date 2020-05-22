$(function (){
    $("#form").submit(function(){
        $.ajax({
            type: "post",
            url: `${BASE_URL}user/passwordRedefinirAjax`,
            dataType: "json",
            data: $(this).serialize(),

            beforeSend: function(){
                formStatus(0);
                showHelperErrors(false);
                loadingRequest(0);
            },
            success: function(response){
                console.log(response);
                if(response["status"] == 0){
                    loadingRequest(1);
                    $(".help-block").html(FA_INFORMACAO + "senha redefinida com sucesso!");
                    formStatus(0);
                }else{
                    showHelperErrors(true);
                    if(response["invalid_token"] == true){
                        $(".help-block").html(FA_EXCLAMACAO + "falha na validação");
                    }else if(response["generic_error"] == true){
                        genericError(1);
                    }else{
                        verifyFormInputs(response);
                    }
                    formStatus(1);
                }
            },
            error: function(response){
                genericError(1);
                formStatus(1);
                console.log(response);
            } 
        })
        return false;
    })
})
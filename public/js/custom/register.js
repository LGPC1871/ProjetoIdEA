/*
|--------------------------------------------------------------------------
| Requisição Ajax
|--------------------------------------------------------------------------
|
*/
$(function (){
    $("#form").submit(function(){
        $.ajax({
            type: "post",
            url: BASE_URL + "user/registerAjax",
            dataType: "json",
            data: $(this).serialize(),

            beforeSend: function (){
                formStatus(0);
                showHelperErrors(false);
                loadingRequest(0);
            },
            success: function (response){
                if(response["status"] == 0){

                    loadingRequest(1);
                    window.location = `${BASE_URL}user/index`

                }else{
                    formStatus(1);

                    if(response["generic_error"] == true){
                        genericError(1);
                    }else{
                        verifyFormInputs(response);
                    }

                }
            },
            error: function(response){
                genericError(1);
                formStatus(1);
            } 
        })
        return false;
    })
})
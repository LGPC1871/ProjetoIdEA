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
            url: BASE_URL + "user/loginAjax",
            dataType: "json",
            data: $(this).serialize(),

            beforeSend: function(){
                formStatus(0);
                showHelperErrors(false);
                loadingRequest(0);
            },
            success: function(json){
                if(json["status"] == 0){
                    console.log("foi");
                    loadingRequest(1);
                    window.location = BASE_URL + "user/profile"
                }else{
                    formStatus(1);
                    comboErrorLogin(json);
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

function comboErrorLogin(json){
    if(json["empty"] == 0){
        invalidInfo(["Email", "Senha"]);
    }else{
        verifyFormInputs(json["error_list"]);
    }
    showHelperErrors(true);
    formAddErrors(json["error_list"]);
}
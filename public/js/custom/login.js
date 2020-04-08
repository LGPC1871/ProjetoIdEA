$(function (){
    $("#loginForm").submit(function(){
        $.ajax({
            type: "post",
            url: BASE_URL + "admin/loginAjax",
            dataType: "json",
            data: $(this).serialize(),
            beforeSend: function(){
                clearErrors();
                $("#botaoLogin").parent().siblings().children().children(".help-block").html(loadingImg("Verificando..."));
            },
            success: function(json){
                if(json["status"] == 0){
                    $("#botaoLogin").parent().siblings().children().children(".help-block").html(loadingImg("Entrando..."));
                    window.location = BASE_URL + "admin/account";
                }else{
                    showErrors(json["error_list"]);
                }
            },
            error: function(response){
                console.log(response);
            }
        })
        return false;
    })
})
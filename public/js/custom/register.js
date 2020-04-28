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
                console.log("teste");
            },
            success: function (response){
                console.log("foi");
                console.log(response);
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
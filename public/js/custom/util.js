const BASE_URL = "http://localhost/";

function clearErrors(){
    $(".has-error").removeClass("has-error");
    $(".help-block").html("Insira suas Credenciais de Administrador");
}

function showErrors(error_list) {
	clearErrors();

	$.each(error_list, function(id, message) {
		$(id).parent().siblings().children().children(".help-block").html(message);
	})
}
function loadingImg(message="") {
	return "<i class='fas fa-circle-notch fa-spin'></i>&nbsp;" + message
}
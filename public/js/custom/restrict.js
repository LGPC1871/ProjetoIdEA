$(document).ready(loadProfileContent());


function loadProfileContent(){
    $('.tab-pane').html($('#tab-loading').html());
    $('.tab-pane').each(function(){requestTabContent(this.id)});
}

function requestTabContent(id){
    let data = {
        id: id
    }
    $(`#${id}`).load("profile/ajaxRequestTabContent", data, function(response){console.log(response)});
}
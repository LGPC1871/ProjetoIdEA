$(document).ready(loadProfileContent());

function loadProfileContent(){
    $('.tab-pane').html($('#tab-loading').html());

    $('.tab-pane').each(function(){requestTabContent(this.id)});
}

function requestTabContent(id){
    let data = {
        privilegio: id
    }
    $(`#${id}`).load(`${BASE_URL}profile/ajaxRequestTab`, data);
}
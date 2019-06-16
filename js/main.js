jQuery(function($) {

function renderErrors(errors) {
    var errorsElement = $('.errors');
    var markup = '';
    
    errorsElement.html('');
    $('.errorsWrapper').show();
    
    if (errors) {
        for (var i = 0; i < errors.length; i++) {
            markup += '<li>'+errors[i]+'</li>';
        }
    } else {
        markup = '<li>One or more errors have occurred.</li>';
    }
    
    errorsElement.append(markup);
}    
   
function renderTableMarkup(data) {
    if ( data.length == 0){
        $('.no-users').show();
        $('.all-users').hide();
        return;
    }
    
    $('.no-users').hide();
    $('.all-users').show();
    
    var table = $('.all-users');
    table.html('');
                
    for(var i = 0; i < data.length; i++) {
        var element = $('.table-entry-example').html();

        var markup = '<tr class="user">';
        markup += '<td>';
        markup += (data[i]['image_path']) ? ('<img class="user-image" src="'+data[i]['image_path']+'" />') : 'No image';
        markup += '</td>';
        markup += '<td>';
        markup += '<table class="user-data" cellpadding="5">';
        markup += '<tr>';
        markup += '<th>Id:</th>';
        markup += '<td class="id">'+data[i]['id']+'</td>';
        markup += '</tr>';
        markup += '<tr>';
        markup += '<th>Name:</th>';
        markup += '<td class="first-name">'+data[i]['first_name']+'</td>';
        markup += '</tr>';
        markup += '<tr>';
        markup += '<th>Surname:</th>';
        markup += '<td class="last-name">'+data[i]['last_name']+'</td>';
        markup += '</tr>';
        markup += '</table>';
        markup += '</td>';
        markup += '</tr>';
        table.append(markup);
    }
}    
    
$( document ).ready(function() {
    $.ajax({
        type: "POST",   
        url : '/allUsers.php',
        success: function( response ) {
            
            var response = JSON.parse(response);
            
            if (response['code'] == 200) {
                renderTableMarkup(response['data']);
            } else {
                if ( response['errors'].length > 0){
                    renderErrors(response['errors']);
                }
            }
        },
        error: function() {
            renderErrors(['An error has occurred. Please try again later.']);
        }
    });
});

$('.signup-form').on('submit', function(e) {
    e.preventDefault();
    
    $.ajax({
        type: "POST",
        data: new FormData(this),
        contentType: false,
        processData:false,    
        url : '/form-handler.php',
        success: function( response ) {
            response = JSON.parse(response);
            
            if (response['code'] == 200) {
                renderTableMarkup(response['data']);
                $('.errorsWrapper').hide();
            } else {
                if ( response['errors'].length > 0){
                    renderErrors(response['errors']);
                }
            }
        },
        error: function() {
            renderErrors(['An error has occurred. Please try again later.']);
        }
    });
});    
});

function csvFromUsersTable() {
    var csv = 'Id,Name,Surname\n';
    $('.all-users .user').each(function() {
        csv += $(this).find('.id').text() + ',';
        csv += $(this).find('.first-name').text() + ',';
        csv += $(this).find('.last-name').text() + ',\n';
    });
    return csv;
}

function download(filename, text) {
    var element = document.createElement('a');
    element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
    element.setAttribute('download', filename);

    element.style.display = 'none';
    document.body.appendChild(element);

    element.click();

    document.body.removeChild(element);
}

$('.dw').on('click', function() {
    download("users.csv",csvFromUsersTable());
});

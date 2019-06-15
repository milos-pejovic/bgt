jQuery(function($) {
    
function renderTableMarkup(data) {
    var table = $('.all-users');
    table.html('');
                
    for(var i = 0; i < data.length; i++) {
        var element = $('.table-entry-example').html();

        var markup = '<tr class="user">';
        markup += '<td><img class="user-image" src="'+data[i]['image_path']+'" /></td>';
        markup += '<td>';
        markup += '<table cellpadding="5">';
        markup += '<th>Name:</th>';
        markup += '<td>'+data[i]['first_name']+'</td>';
        markup += '</tr>';
        markup += '<tr>';
        markup += '<th>Surname:</th>';
        markup += '<td>'+data[i]['last_name']+'</td>';
        markup += '<tr>';
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
            }
        },
        error: function() {
            //TODO error
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

        },
        error: function() {

        }
    });
    
});    
    
    
});


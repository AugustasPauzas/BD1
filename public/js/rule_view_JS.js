$(document).ready(function() {
    $('#ajax_add_rule').on('submit', function(e) {
        e.preventDefault(); 
        var formData = $(this).serialize(); 
        $.ajax({
            url: '/ajax_create_rule', 
            type: 'POST',
            data: formData,
            success: function(response) {
                console.log(response);
                displayMessage(response.message, 1);
                reload_rule();
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                displayMessage("Error", 2);
            }
        });
    });
});

function reload_rule() {
    setTimeout(function() {
        $.ajax({
            url: '/Live_rule', 
            type: 'GET',
            success: function(response) {
                //alert('reload cart');
                $('#rule-container').html(response.view); 
            },
            error: function(xhr) {
                displayMessage("Error", 2);
                console.error('Error loading cart:', xhr.responseText); 
            }
        });
    }, 10);

}

$(document).on('click', '.delete_rule', function(event) {
    event.preventDefault(); 
    var ruleId = $(this).data('rule-id'); 
    $.ajax({
        url: '/ajax_delete_rule/' + ruleId, 
        type: 'GET',
        dataType: 'json', 
        success: function(response) {
            displayMessage(response.message, 1);
            reload_rule();
        },
        error: function(xhr) {
            displayMessage("Error", 2);
            console.error('Error removing item:', xhr.responseText); 
        }
    });
});
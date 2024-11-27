
$(document).on('click', '.reload_cart', function() {
    reload_cart();
});

$(document).on('click', '.add_quantity_item_cart', function(event) {
    event.preventDefault(); 
    var itemId = $(this).data('item-id'); 
    $.ajax({
        url: '/ajax_cart_increase_quantity/' + itemId, 
        type: 'GET',
        dataType: 'json', 
        success: function(response) {
            reload_cart();
        },
        error: function(xhr) {
            displayMessage("Error", 2);
            console.error('Error removing item:', xhr.responseText); 
        }
    });
});

$(document).on('click', '.decrease_quantity_item_cart', function(event) {
    event.preventDefault(); 
    var itemId = $(this).data('item-id'); 
    $.ajax({
        url: '/ajax_cart_decrease_quantity/' + itemId, 
        type: 'GET',
        dataType: 'json', 
        success: function(response) {
            reload_cart();
        },
        error: function(xhr) {
            displayMessage("Error", 2);
            console.error('Error removing item:', xhr.responseText); 
        }
    });
});

$(document).on('click', '.cart_remove_item', function(event) {
    event.preventDefault(); // Prevent the default anchor click behavior

    var itemId = $(this).data('item-id'); // Get the item ID from the clicked element

    $.ajax({
        url: '/remove_item_from_cart/' + itemId, // AJAX request URL
        type: 'GET',
        dataType: 'json', // Ensure you expect a JSON response
        success: function(response) {
            displayMessage(response.message, 1);
            reload_cart();
        },
        error: function(xhr) {
            console.error('Error removing item:', xhr.responseText); // Log any errors
            displayMessage("Error", 2);
        }
    });
});


function reload_cart() {
    setTimeout(function() {
        $.ajax({
            url: '/Live_cart', 
            type: 'GET',
            success: function(response) {
                $('#cart-container').html(response.view); 
            },
            error: function(xhr) {
                displayMessage("Error", 2);
                console.error('Error loading cart:', xhr.responseText); 
            }
        });
    }, 5); 

}


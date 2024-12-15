$(document).on('submit', '#add_new_category_form', function(event) {
    event.preventDefault(); 

    var formData = $(this).serialize(); 

    $.ajax({
        url: '/add_new_category', 
        type: 'POST',
        data: formData,
        dataType: 'json', 
        success: function(response) {
            displayMessage(response.message, 1); 
            reload_categories_list()
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                var errors = xhr.responseJSON.errors;
                var message = Object.values(errors).map(function(error) {
                    return error.join(', ');
                }).join('<br>');
                displayMessage(message, 2);
            } else {
                displayMessage("Error", 2);
            }
        }
    });
});




$(document).on('submit', '#update_category_name', function(event) {
    event.preventDefault(); // Prevent default form submission
    var formData = $(this).serialize(); // Serialize the form data
    $.ajax({
        url: '/update_category_name', // The route for form submission
        type: 'POST',
        data: formData,
        dataType: 'json', // Expect JSON response
        success: function(response) {
            displayMessage(response.message, 1); // Display a success message
            reload_categories_list();
        },
        error: function(xhr) {
            displayMessage(message, 2);
        }
    });
});

$(document).on('submit', '#update_category_name_full', function(event) {
    event.preventDefault(); // Prevent default form submission
    var formData = $(this).serialize(); // Serialize the form data
    $.ajax({
        url: '/update_category_name_full', // The route for form submission
        type: 'POST',
        data: formData,
        dataType: 'json', // Expect JSON response
        success: function(response) {
            displayMessage(response.message, 1); // Display a success message
            reload_categories_list();
        },
        error: function(xhr) {
            displayMessage(message, 2);
        }
    });
});

$(document).on('click', '#category_status_set_active', function(event) {
    event.preventDefault(); 
    var categoryId = $(this).data('category-id');
    var url = '/category_status_set_active/' + categoryId;

    var formData = $(this).serialize(); 
    $.ajax({
        url: url, 
        type: 'POST',
        data: formData,
        dataType: 'json', 
        success: function(response) {
            displayMessage(response.message, 1); 
            reload_categories_list();
        },
        error: function(xhr) {
            displayMessage(message, 2);
        }
    });
});

$(document).on('click', '#category_status_set_inactive', function(event) {
    event.preventDefault(); 
    var categoryId = $(this).data('category-id');
    var url = '/category_status_set_inactive/' + categoryId;

    var formData = $(this).serialize(); 
    $.ajax({
        url: url, 
        type: 'POST',
        data: formData,
        dataType: 'json', // Expect JSON response
        success: function(response) {
            displayMessage(response.message, 1); // Display a success message
            reload_categories_list();
        },
        error: function(xhr) {
            displayMessage(message, 2);
        }
    });
});

$(document).on('submit', '#category_image_upload', function(event) {
    event.preventDefault(); // Prevent default form submission

    var formData = new FormData(this); // Create FormData object to send the form data including files

    $.ajax({
        url: '/category_set_image', // The route for form submission
        type: 'POST',
        data: formData, // Send the form data with the image
        dataType: 'json', // Expect JSON response
        processData: false, // Prevent jQuery from processing the data
        contentType: false, // Set content type to false for file uploads
        success: function(response) {
            // Handle the success response
            displayMessage(response.message, 1); // Display success message
            reload_categories_list();
            if (response.image_path) {
                // Optionally, display the uploaded image or update the image source on the page
                $('#category_image_preview').attr('src', '/storage/' + response.image_path);
            }
        },
        error: function(xhr) {
            // Handle error response
            displayMessage("Error: " + xhr.responseJSON.message, 2);
        }
    });
});


$(document).on('click', '.reload_categories_list', function() {
    reload_categories_list()
});

function reload_categories_list() {
    setTimeout(function() {
        $.ajax({
            url: '/Live_categories', 
            type: 'GET',
            success: function(response) {
                $('#categories_list').html(response.view); 
            },
            error: function(xhr) {
                displayMessage("Error", 2);
                console.error('Error loading category list:', xhr.responseText); 
            }
        });
    }, 5); 

}
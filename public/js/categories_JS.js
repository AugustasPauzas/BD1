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
                }).join(' ');
                displayMessage(message, 2);
            } else {
                displayMessage("Error", 2);
            }
        }
    });
});




$(document).on('submit', '#update_category_name', function(event) {
    event.preventDefault();
    var formData = $(this).serialize(); 
    $.ajax({
        url: '/update_category_name', 
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

$(document).on('submit', '#update_category_name_full', function(event) {
    event.preventDefault(); 
    var formData = $(this).serialize(); 
    $.ajax({
        url: '/update_category_name_full', 
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

$(document).on('submit', '#category_image_upload', function(event) {
    event.preventDefault();

    var formData = new FormData(this); 

    $.ajax({
        url: '/category_set_image', 
        type: 'POST',
        data: formData, 
        dataType: 'json', 
        processData: false, 
        contentType: false,
        success: function(response) {
            displayMessage(response.message, 1); 
            reload_categories_list();
            if (response.image_path) {
                $('#category_image_preview').attr('src', '/storage/' + response.image_path);
            }
        },
        error: function(xhr) {
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
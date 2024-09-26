

$(document).ready(function() {
    console.log("Document Ready Loading js");
    
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    // Handle delete button click with event delegation for both PHP and AJAX-generated content
    $(document).on('click', '.item_update_delete_button', function(event) {
        console.log('Delete button Pressed');
        event.preventDefault();

        const itemId = $(this).data('item-id');
        const imageParseId = $(this).data('image-parse-id');
        const imageContainer = $(this).closest('.image-container');

        $.ajax({
            url: `/delete/item/image/${itemId}/${imageParseId}`, // Assuming you use this route
            type: 'GET', // You might want to use DELETE instead of GET for better RESTful design
            success: function(response) {
                if (response.success) {
                    // On success, remove the image container
                    imageContainer.remove();
                    // Optionally, reload the data or show a success message
                    console.log('Image deleted successfully');
                } else {
                    alert('Failed to delete the image.');
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText); // Handle errors
                alert('Error deleting the image.');
            }
        });
    });

    //view update  move image
// Move image to the left and reload images
    $(document).on('click', 'a.image_position_left', function(e) {
        e.preventDefault(); // Prevent default anchor click behavior
        const imageParseId = $(this).data('image-parse-id');
        const itemId = $(this).data('item-id'); // Get the item_id from the button's data attribute
        // AJAX call to move the image to the left
        $.ajax({
            url: `/ajax_move_image_to_left/${imageParseId}`, // Laravel route
            method: 'POST', // HTTP method
            data: {
                _token: $('meta[name="csrf-token"]').attr('content') // Get the CSRF token from the meta tag
            },
            success: function(response) {
                console.log('Function reached and image moved left.');

                // Now that the image is moved, reload the images
                $.ajax({
                    url: `/live_reload_all_images/${itemId}`, // Use the retrieved itemId
                    method: 'GET', // Use GET method
                    success: function(response) {
                        $('#data-container').html(response); // Replace the content of #data-container with the new data
                        console.log('Images reloaded successfully.');
                    },
                    error: function(xhr) {
                        console.error('Error reloading images:', xhr.responseText); // Log errors
                        //alert('An error occurred while reloading images: ' + xhr.responseText); // Show error message
                    }
                });
            },
            error: function(xhr) {
                console.error('Error occurred:', xhr.responseText); // Log errors
                //alert('An error occurred while moving the image left.'); // Optional alert
            }
        });
    });

    
    // Move image to the right
// Move image to the right and reload images
    $(document).on('click', 'a.image_position_right', function(e) {
        e.preventDefault(); // Prevent default link behavior

        const imageParseId = $(this).data('image-parse-id');
        const itemId = $(this).data('item-id'); // Get the item_id from the button's data attribute

        // AJAX call to move the image
        $.ajax({
            url: `/ajax_move_image_to_right/${imageParseId}`,
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content') // Get the CSRF token from the meta tag
            },
            success: function(response) {
                console.log('Function reached and image moved right.');

                // Now that the image is moved, reload the images
                $.ajax({
                    url: `/live_reload_all_images/${itemId}`, // Use the retrieved itemId
                    method: 'GET', // Use GET method
                    success: function(response) {
                        $('#data-container').html(response); // Replace the content of #data-container with the new data
                        console.log('Images reloaded successfully.');
                    },
                    error: function(xhr) {
                        console.error('Error reloading images:', xhr.responseText); // Log errors
                        //alert('An error occurred while reloading images: ' + xhr.responseText); // Show error message
                    }
                });
            },
            error: function(xhr) {
                console.error('Error occurred:', xhr.responseText);
                //alert('An error occurred while moving the image right.'); // Optional alert
            }
        });
    });



    $('.reload_all_images').click(function() {
        const itemId = $(this).data('item-id'); // Get the item_id from the button's data attribute
    
        $.ajax({
            url: `/live_reload_all_images/${itemId}`, // Use the retrieved itemId
            method: 'GET', // Use GET method
            success: function(response) {
                $('#data-container').html(response); // Replace the content of #data-container with the new data
                console.log('Images reloaded successfully.');
            },
            error: function(xhr) {
                console.error('Error reloading images:', xhr.responseText); // Log errors
                alert('An error occurred while reloading images: ' + xhr.responseText); // Show error message
            }
        });
    });

});//Dock ready end






$(document).ready(function() {
    $('#ajax_item_image_upload').on('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: "/ajax_item_image_upload", // Use the direct URL here
            type: 'POST',
            data: formData,
            contentType: false, // Prevent jQuery from processing the data
            processData: false, // Prevent jQuery from processing the formData
            success: function(response) {
                if (response.success) {
                    // Display success message
                    $('#message').html('<p>' + response.message + '</p>');

                    var newImage = `
                    <div class="image-container update_add_images_item full_height" data-image-id="${response.image.image_parse_id}">
                        <div class="image_svg_wrapper square_image">
                            <div class="position_div default_radius">
                                #${response.image.position}
                            </div>
                
                            <a href="#" class="image_position_left default_radius no_border" data-image-parse-id="${response.image.image_parse_id}" data-item-id="${response.image.item_id}">
                                <svg class="small_svg" viewBox="0 0 24.00 24.00" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="0.144"/>
                                    <g id="SVGRepo_iconCarrier">
                                        <path d="M5 12H19M5 12L11 6M5 12L11 18" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </g>
                                </svg>
                            </a>
                            
                            <a href="#" class="image_position_right default_radius no_border"   data-image-parse-id="${response.image.image_parse_id}" data-item-id="${response.image.item_id}">
                                <svg class="small_svg" viewBox="0 0 24.00 24.00" fill="none" xmlns="http://www.w3.org/2000/svg" transform="matrix(-1, 0, 0, 1, 0, 0)">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="0.144"/>
                                    <g id="SVGRepo_iconCarrier"> 
                                        <path d="M5 12H19M5 12L11 6M5 12L11 18" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> 
                                    </g>
                                </svg>
                            </a>

                
                            <img class="default_radius full_width_image transform_105 image_cover" src="/${response.image.image_location}" alt="Image">
                            <a class="item_update_delete_button" data-item-id="${response.image.item_id}" data-image-parse-id="${response.image.parse_id}">
                                <div class="delete_div default_radius">
                                    <svg class="small_svg delete_button_svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10 12V17" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M14 12V17" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M4 7H20" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M6 10V18C6 19.6569 7.34315 21 9 21H15C16.6569 21 18 19.6569 18 18V10" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                            </a>
                        </div>
                    </div>
                `;
                
                
                    $('#data-container').append(newImage); // Append the new image
                } else {
                    $('#message').html('<p>Error uploading image</p>');
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    });
});









// Add a click event listener to all images with id click_too_replace_main
document.querySelectorAll('#click_too_replace_main').forEach(image => {
    image.addEventListener('click', function() {
        // Find the target image by its ID (e.g., 'replace_image_item_view')
        let targetImage = document.getElementById('replace_image_item_view');
        
        // Replace the target image's src with the clicked image's src
        if (targetImage) {
            targetImage.src = this.src;
        }
    });
});

$(document).ready(function () {
    

    // Add a click event listener to all images with id click_too_replace_main
    document.querySelectorAll('#click_too_replace_main').forEach(image => {
        image.addEventListener('click', function() {
            // Find the target image by its ID (e.g., 'replace_image_item_view')
            let targetImage = document.getElementById('replace_image_item_view');
            
            // Replace the target image's src with the clicked image's src
            if (targetImage) {
                targetImage.src = this.src;
            }
        });
    });
});

// F. View Item 
function view_item_image_menu_scroll_left() {
    const container = document.getElementById('imageContainer');
    const scrollAmount = container.clientWidth * 0.65; // 80% 
    container.scrollBy({
        left: -scrollAmount,
        behavior: 'smooth'
    });
}

function view_item_image_menu_scroll_right() {
    const container = document.getElementById('imageContainer');
    const scrollAmount = container.clientWidth * 0.65; // 80%
    container.scrollBy({
        left: scrollAmount,
        behavior: 'smooth'
    });
}
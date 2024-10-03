

$(document).ready(function() {
    console.log("Document Ready Loading js");
    
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    document.addEventListener('DOMContentLoaded', function() {
        attachFormSubmitListeners(); 
        attachFormSubmitListeners2();
        reloadSpecificationsOnPageLoad(); 
    

        
        setInterval(function() {
            attachFormSubmitListeners();
            attachFormSubmitListeners2();
            reloadSpecificationsOnPageLoad(); 
        }, 100); 
        
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
                    //alert('Failed to delete the image.');
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText); // Handle errors
                //alert('Error deleting the image.');
            }
        });
    });

    //view update  move image
// Move image to the left and reload images
    $(document).on('click', 'a.image_position_left', function(event) {
        event.preventDefault(); // Prevent default anchor click behavior
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


    $(document).on('click', '.action_reload_b_pic', function() {
        var itemId = $(this).data('item-id'); // Assuming item_id is stored in a data attribute
        console.log($('meta[name="csrf-token"]').attr('content'));

        $.ajax({
            url: '/Live_view_update_big_pick/' + itemId,
            method: 'GET',
            success: function(response) {
                $('#big-pick-container').html(response);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });

    // AJAX delete parameter value
    $(document).on('click', '.delete_parameter_value_button', function(e) {
        e.preventDefault(); // Prevent the default anchor behavior
    
        var valueId = $(this).data('value-id'); // Get the value_id from data attribute
        var itemId = $(this).data('item-id'); 
        var specificationId = $(this).data('specification-id'); 
        
        $.ajax({
            url: '/ajax_update_view_delete_value',
            type: 'POST',
            data: {
                value_id: valueId,
                specification_id: specificationId,
                _token: $('meta[name="csrf-token"]').attr('content') // Correct way to pass CSRF token
            },
            success: function(response) {
                console.log('Success:', response);
                // Optionally reload specifications after success
                reloadSpecifications(itemId); // Reload after success
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText); // Log error details
            }
        });
    });

    // AJAX delete specification row
    $(document).on('click', '.delete_specification_row_button', function(e) {
        e.preventDefault(); // Prevent the default anchor behavior
    
        var parameterId = $(this).data('parameter-id'); // Get the value_id from data attribute
        var itemId = $(this).data('item-id'); 
        var specificationId = $(this).data('specification-id'); 
        
        $.ajax({
            url: '/ajax_delete_specification_row',
            type: 'POST',
            data: {
                parameter_id: parameterId,
                item_id: itemId,
                specification_id: specificationId,
                _token: $('meta[name="csrf-token"]').attr('content') // Correct way to pass CSRF token
            },
            success: function(response) {
                console.log('Success:', response);
                // Optionally reload specifications after success
                //reloadSpecifications(itemId); // Reload after success
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText); // Log error details
            }
        });
    });


    // Add item AJAX
    $(document).ready(function() {
        $('#add-item-form').on('submit', function(e) {
            e.preventDefault(); // Prevent page reload
            var form = $(this);
            // Get the URL from the data-ajax-url attribute
            var url = form.data('ajax-url');
    
            $.ajax({
                url: url, // Use the data-ajax-url attribute
                method: 'POST',
                data: form.serialize(), // Send form data
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token
                },
                success: function(response) {
                    //alert('Item added successfully!');
                    form.trigger('reset');
                    $('.text-danger').text(''); // Clear previous error messages
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors; // Get validation errors
    
                    // Clear previous errors
                    $('.text-danger').text('');
    
                    // Display validation errors dynamically
                    
                    if (errors.name) $('.error-name').text(errors.name[0]);
                    if (errors.ien_code) $('.error-ien_code').text(errors.ien_code[0]);
                    if (errors.price) $('.error-price').text(errors.price[0]);
                    if (errors.status) $('.error-status').text(errors.status[0]);
                    if (errors.description) $('.error-description').text(errors.description[0]);
                    if (errors.quantity) $('.error-quantity').text(errors.quantity[0]);
                    if (errors.category) $('.error-category').text(errors.category[0]);
                    // BAD not from controller
                    /*if (errors.name) $('.error-name').text("Item Name Field Is Required");
                    if (errors.ien_code) $('.error-ien_code').text("IEN Code Field Is Required");
                    if (errors.price) $('.error-price').text("Valid Price Is Required");
                    if (errors.status) $('.error-status').text("Status Must Be Selected");
                    if (errors.description) $('.error-description').text("Description Is Required");
                    if (errors.quantity) $('.error-quantity').text("Quantity Is Required");
                    if (errors.category) $('.error-category').text("Valid Caregory Is Required");*/
                }
            });
        });
        //Update Item Ajax
        $(document).ready(function() {
            $('#update-item-form').on('submit', function(e) {
                e.preventDefault(); // Prevent page reload
                var form = $(this);
                // Get the URL from the data-ajax-url attribute
                var url = form.data('ajax-url');
        
                $.ajax({
                    url: url, // Use the data-ajax-url attribute
                    method: 'POST',
                    data: form.serialize(), // Send form data
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token
                    },
                    success: function(response) {
                        //alert('Item Updated successfully!');
                        //form.trigger('reset');
                        //$('.text-danger').text(''); // Clear previous error messages
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors; // Get validation errors
        
                        // Clear previous errors
                        $('.text-danger').text('');
        
                        // Display validation errors dynamically
                        
                        if (errors.name) $('.error-name').text(errors.name[0]);
                        if (errors.ien_code) $('.error-ien_code').text(errors.ien_code[0]);
                        if (errors.price) $('.error-price').text(errors.price[0]);
                        if (errors.status) $('.error-status').text(errors.status[0]);
                        if (errors.description) $('.error-description').text(errors.description[0]);
                        if (errors.quantity) $('.error-quantity').text(errors.quantity[0]);
                        if (errors.category) $('.error-category').text(errors.category[0]);
                        // BAD not from controller
                        /*if (errors.name) $('.error-name').text("Item Name Field Is Required");
                        if (errors.ien_code) $('.error-ien_code').text("IEN Code Field Is Required");
                        if (errors.price) $('.error-price').text("Valid Price Is Required");
                        if (errors.status) $('.error-status').text("Status Must Be Selected");
                        if (errors.description) $('.error-description').text("Description Is Required");
                        if (errors.quantity) $('.error-quantity').text("Quantity Is Required");
                        if (errors.category) $('.error-category').text("Valid Caregory Is Required");*/
                    }
                });
            });
        });
        // create item price vald.
        document.getElementById('price').addEventListener('input', function (e) {
            // Replace commas with dots
            this.value = this.value.replace(/,/g, '.');
            // Remove all characters except digits and dots
            this.value = this.value.replace(/[^0-9.]/g, '');
            
            const parts = this.value.split('.');
            
            // Allow only one decimal point
            if (parts.length > 2) {
                this.value = parts[0] + '.' + parts.slice(1).join('');
            }
        
            // Limit decimal places to 2
            if (parts[1] && parts[1].length > 2) {
                this.value = parts[0] + '.' + parts[1].slice(0, 2);
            }
            
            // Check for maximum value of 999999.99
            const maxValue = 999999.99;
            if (parseFloat(this.value) > maxValue) {
                this.value = maxValue.toFixed(2); // Set to max value if exceeded
            }
        });
        // Create item quantity vald.
        document.getElementById('quantity').addEventListener('input', function (e) {
            // Get the current value
            const value = this.value;
    
            // Filter out non-numeric characters
            const filteredValue = value.replace(/[^0-9]/g, '');
    
            // Ensure the value does not exceed 6 digits
            if (filteredValue.length > 6) {
                this.value = filteredValue.slice(0, 6); // Trim to 6 digits
            } else {
                this.value = filteredValue; // Set the filtered value
            }
        });
    });
    

    //Add new specification from /view/update
    document.getElementById('ajax_add_specification').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission
    
        const formData = new FormData(this); // Collect form data
    
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value // Include CSRF token
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json(); // Parse JSON response
        })
        .then(data => {
            // Handle success
            document.getElementById('success_messageText').innerText = data.message; // Display success message
            const responseMessage = document.getElementById('responseMessage');
            responseMessage.style.display = 'block'; // Show the message
    
            // Hide the message after 5 seconds
            setTimeout(() => {
                responseMessage.style.display = 'none';
            }, 5000);
    
            // Add click event to close button
            document.getElementById('closeMessage').onclick = function() {
                responseMessage.style.display = 'none'; // Hide the message
            };
    
            // Optionally, clear the form fields
            document.getElementById('parameter_name').value = '';
            document.getElementById('value_name').value = '';
        })
        .catch(error => {
            // Handle error
            console.error('Error:', error);
            document.getElementById('responseMessage').innerHTML = 'An error occurred. Please try again.'; // Display error message
        });
    });
    
    //UPDATE parameter name from view update
    function attachFormSubmitListeners() {
        document.querySelectorAll('.ajax_parameter_update_form').forEach(form => {
            const existingListener = form.getAttribute('data-listener'); // Check if a listener exists
            if (existingListener) {
                form.removeEventListener('submit', existingListener); // Remove the existing listener
            }
    
            const listener = function(event) {
                event.preventDefault(); // Prevent the default form submission
    
                const formData = new FormData(this); // Collect form data
                const formAction = this.action; // Store form action URL
    
                fetch(formAction, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value // Include CSRF token
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok ' + response.statusText);
                    }
                    return response.json(); // Parse JSON response
                })
                .then(data => {
                    // Handle success
                    document.getElementById('success_messageText').innerText = data.message; // Display success message
                    const responseMessage = document.getElementById('responseMessage');
                    responseMessage.style.display = 'block'; // Show the message
    
                    // Hide the message after 5 seconds
                    setTimeout(() => {
                        responseMessage.style.display = 'none';
                    }, 5000);
    
                    // Add click event to close button
                    document.getElementById('closeMessage').onclick = function() {
                        responseMessage.style.display = 'none'; // Hide the message
                    };
    
                    // Optionally, clear the form fields if needed
                    //form.reset(); // DONT DO IT :(
                })
                .catch(error => {
                    // Handle error
                    console.error('Error:', error);
                    const responseMessage = document.getElementById('responseMessage');
                    if (responseMessage) {
                        responseMessage.innerHTML = 'An error occurred. Please try again.'; // Display error message
                    }
                });
            };
    
            form.setAttribute('data-listener', listener); // Store the listener reference
            form.addEventListener('submit', listener); // Attach the listener
        });
    }

    //ADD Value with no parameter input here
    function attachFormSubmitListeners2() {
        document.querySelectorAll('.ajax_add_only_value_form').forEach(form => {
            const existingListener = form.getAttribute('data-listener'); // Check if a listener exists
            if (existingListener) {
                form.removeEventListener('submit', existingListener); // Remove the existing listener
            }
            const listener = function(event) {
                event.preventDefault(); // Prevent the default form submission
                const formData = new FormData(this); // Collect form data
                const formAction = this.action; // Store form action URL
    
                fetch(formAction, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value // Include CSRF token
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok ' + response.statusText);
                    }
                    return response.json(); // Parse JSON response
                    
                    
                })
                .then(data => {
                    // Handle success
                    document.getElementById('success_messageText').innerText = data.message; // Display success message
                    const responseMessage = document.getElementById('responseMessage');
                    responseMessage.style.display = 'block'; // Show the message
    
                    // Hide the message after 5 seconds
                    setTimeout(() => {
                        responseMessage.style.display = 'none';
                    }, 5000);
    
                    // Add click event to close button
                    document.getElementById('closeMessage').onclick = function() {
                        responseMessage.style.display = 'none'; // Hide the message
                    };
    
                    // Optionally, clear the form fields if needed
                    form.reset(); // DONT DO IT :(
                })
                .catch(error => {
                    // Handle error
                    console.error('Error:', error);
                    const responseMessage = document.getElementById('responseMessage');
                    if (responseMessage) {
                        responseMessage.innerHTML = 'An error occurred. Please try again.'; // Display error message
                    }
                });
                
            };
    
            form.setAttribute('data-listener', listener); // Store the listener reference
            form.addEventListener('submit', listener); // Attach the listener
        });
    }
    

    //LIVE RELOAD OF update specification
    // Use event delegation with 'on' to attach the click event to dynamically loaded buttons
    $(document).on('click', '.ajax_reload_update_specification', function() {
        const itemId = $(this).data('item-id'); // Get the item_id from the button's data attribute
        reloadSpecifications(itemId); // Call the function with the itemId
        attachFormSubmitListeners();
        attachFormSubmitListeners2();
    });


    function reloadSpecifications(itemId) {
        setTimeout(function() {
            $.ajax({
                url: `/Live_reload_update_specification/${itemId}`, // Use the retrieved itemId
                method: 'GET', // Use GET method
                success: function(response) {
                    $('#specificationsContainer').html(response); // Replace the content of #data-container with the new data
                    console.log('Reloaded successfully.');
    
                    // Reattach form submit listeners after reloading the content
                    attachFormSubmitListeners();
                    attachFormSubmitListeners2();
                },
                error: function(xhr) {
                    console.error('Error reloading:', xhr.responseText); // Log errors
                    alert('An error occurred while reloading: ' + xhr.responseText); // Show error message
                }
            });
        }, 20);
    }





});//Dock ready end

// 
document.addEventListener('DOMContentLoaded', function() {
    // Function to adjust targetDiv's height based on sourceDiv
    function adjustHeight() {
        const screenWidth = window.innerWidth;

        // Check if both elements exist, if not, stop execution
        const sourceDiv = document.getElementById('sourceDiv');
        const targetDiv = document.getElementById('targetDiv');

        if (!sourceDiv || !targetDiv) {
            console.warn('sourceDiv or targetDiv not found. Stopping function.');
            window.removeEventListener('resize', adjustHeight); // Stop adjusting height if elements are not found
            return;
        }

        // Only execute if the screen width is 1200px or more
        if (screenWidth >= 1200) {
            // Get sourceDiv height and set it to targetDiv
            const sourceHeight = sourceDiv.getBoundingClientRect().height;
            targetDiv.style.height = sourceHeight + 'px';
        } else {
            targetDiv.style.height = 'auto';
        }
    }

    // Run the function once on page load
    adjustHeight();

    // Run the function when the window is resized
    window.addEventListener('resize', adjustHeight);
});



// Item Quantity in item view
document.addEventListener('DOMContentLoaded', function() {
    const maxQuantity = document.getElementById('view_item_add_quantity').max;
    const inputField = document.getElementById('view_item_add_quantity');
    const increaseButton = document.getElementById('view_item_add_quantity_increaseButton');
    const decreaseButton = document.getElementById('view_item_add_quantity_decreaseButton');

    increaseButton.addEventListener('click', function() {
        let currentValue = parseInt(inputField.value);
        if (currentValue < maxQuantity) {
            inputField.value = currentValue + 1;
        }
    });

    decreaseButton.addEventListener('click', function() {
        let currentValue = parseInt(inputField.value);
        if (currentValue > 1) {
            inputField.value = currentValue - 1;
        }
    });
});


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
                
                            <a href="#" class="image_position_left default_radius no_border action_reload_b_pic reload_all_images" data-image-parse-id="${response.image.image_parse_id}" data-item-id="${response.image.item_id}">
                                <svg class="small_svg" viewBox="0 0 24.00 24.00" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="0.144"/>
                                    <g id="SVGRepo_iconCarrier">
                                        <path d="M5 12H19M5 12L11 6M5 12L11 18" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </g>
                                </svg>
                            </a>
                            
                            <a href="#" class="image_position_right default_radius no_border action_reload_b_pic reload_all_images"   data-image-parse-id="${response.image.image_parse_id}" data-item-id="${response.image.item_id}">
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












// CREATE ITEM









// VIEW ITEM


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
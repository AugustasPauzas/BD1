

$(document).ready(function() {
    console.log("Document Ready");
    

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    document.addEventListener('DOMContentLoaded', function() {
        attachFormSubmitListeners(); 
        attachFormSubmitListeners2();
        attachFormSubmitListeners3()
        reloadSpecificationsOnPageLoad(); 
    

        
        setInterval(function() {
            attachFormSubmitListeners();
            attachFormSubmitListeners2();
            attachFormSubmitListeners3()
            reloadSpecificationsOnPageLoad(); 
        }, 100); 
        
    });

    



    
    // DELETE IMAGE HERE from Item update
    $(document).on('click', '.item_update_delete_button', function(event) {
        console.log('Delete button Pressed');
        event.preventDefault();

        const itemId = $(this).data('item-id');
        const imageParseId = $(this).data('image-parse-id');
        const imageContainer = $(this).closest('.image-container');

        $.ajax({
            url: `/delete/item/image/${itemId}/${imageParseId}`, 
            type: 'GET', 
            success: function(response) {
                if (response.success) {
                    // On success, remove the image container
                    imageContainer.remove();
                    
                    console.log('Image deleted successfully');
                } else {
                    //alert('Failed to delete the image.');
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText); 
                //alert('Error deleting the image.');
            }
        });
    });

    //view update  move image
    // Move image to the left and reload images
    $(document).on('click', 'a.image_position_left', function(event) {
        event.preventDefault(); 
        const imageParseId = $(this).data('image-parse-id');
        const itemId = $(this).data('item-id'); 
        // AJAX call to move the image to the left
        $.ajax({
            url: `/ajax_move_image_to_left/${imageParseId}`, 
            method: 'POST', 
            data: {
                _token: $('meta[name="csrf-token"]').attr('content') 
            },
            success: function(response) {
                console.log('Function reached and image moved left.');

                // reload the images
                $.ajax({
                    url: `/live_reload_all_images/${itemId}`, 
                    method: 'GET', 
                    success: function(response) {
                        $('#data-container').html(response); // Replace the content of #data-container with the new data
                        console.log('Images reloaded successfully.');
                    },
                    error: function(xhr) {
                        console.error('Error reloading images:', xhr.responseText); 
                        //alert('An error occurred while reloading images: ' + xhr.responseText); 
                    }
                });
            },
            error: function(xhr) {
                console.error('Error occurred:', xhr.responseText); 
                //alert('An error occurred while moving the image left.'); 
            }
        });
    });

    
    // Move image to the right
    // Move image to the right and reload images
    $(document).on('click', 'a.image_position_right', function(e) {
        e.preventDefault(); 

        const imageParseId = $(this).data('image-parse-id');
        const itemId = $(this).data('item-id'); 

        $.ajax({
            url: `/ajax_move_image_to_right/${imageParseId}`,
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content') 
            },
            success: function(response) {
                console.log('Function reached and image moved right.');

                // image moved, reload the images
                $.ajax({
                    url: `/live_reload_all_images/${itemId}`, 
                    method: 'GET', 
                    success: function(response) {
                        $('#data-container').html(response); // Replace the content of #data-container with the new data
                        console.log('Images reloaded successfully.');
                    },
                    error: function(xhr) {
                        console.error('Error reloading images:', xhr.responseText); 
                        //alert('An error occurred while reloading images: ' + xhr.responseText); 
                    }
                });
            },
            error: function(xhr) {
                console.error('Error occurred:', xhr.responseText);
                //alert('An error occurred while moving the image right.'); //  alert
            }
        });
    });



    $('.reload_all_images').click(function() {
        const itemId = $(this).data('item-id'); 
    
        $.ajax({
            url: `/live_reload_all_images/${itemId}`, 
            method: 'GET', 
            success: function(response) {
                $('#data-container').html(response); 
                console.log('Images reloaded successfully.');
            },
            error: function(xhr) {
                console.error('Error reloading images:', xhr.responseText); 
                alert('An error occurred while reloading images: ' + xhr.responseText); 
            }
        });
    });


    $(document).on('click', '.action_reload_b_pic', function() {
        var itemId = $(this).data('item-id'); 
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
        e.preventDefault(); 
    
        var valueId = $(this).data('value-id'); 
        var itemId = $(this).data('item-id'); 
        var specificationId = $(this).data('specification-id'); 
        
        $.ajax({
            url: '/ajax_update_view_delete_value',
            type: 'POST',
            data: {
                value_id: valueId,
                specification_id: specificationId,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log('Success:', response);
                reloadSpecifications(itemId); 
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText); 
            }
        });
    });

    // AJAX delete specification row
    $(document).on('click', '.delete_specification_row_button', function(e) {
        e.preventDefault(); 
    
        var parameterId = $(this).data('parameter-id'); 
        var itemId = $(this).data('item-id'); 
        var specificationId = $(this).data('specification-id'); 
        
        $.ajax({
            url: '/ajax_delete_specification_row',
            type: 'POST',
            data: {
                parameter_id: parameterId,
                item_id: itemId,
                specification_id: specificationId,
                _token: $('meta[name="csrf-token"]').attr('content') 
            },
            success: function(response) {
                console.log('Success:', response);
                //reloadSpecifications(itemId); // Reload after success
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText); 
            }
        });
    });


    // Add item AJAX
    $(document).ready(function() {
        $('#add-item-form').on('submit', function(e) {
            e.preventDefault(); 
            var form = $(this);
            var url = form.data('ajax-url');
    
            $.ajax({
                url: url, 
                method: 'POST',
                data: form.serialize(), 
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
                },
                success: function(response) {
                    //alert('Item added successfully!');
                    form.trigger('reset');
                    $('.text-danger').text(''); 
                    var itemId = response.item_id; // or response.id
                    window.location.href = '/view/' + itemId; // Redirect item's view page
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors; 
    
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
                e.preventDefault(); 
                var form = $(this);

                var url = form.data('ajax-url');
        
                $.ajax({
                    url: url, 
                    method: 'POST',
                    data: form.serialize(), 
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
                    },
                    success: function(response) {
                        //alert('Item Updated successfully!');
                        //form.trigger('reset');
                        //$('.text-danger').text(''); 
                        //var itemId = response.item_id; 
                        //window.location.href = '/view/' + itemId; 
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors; 
        
                        // Clear previous errors
                        $('.text-danger').text('');
        

                        
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
            
            // maximum value of 999999.99
            const maxValue = 999999.99;
            if (parseFloat(this.value) > maxValue) {
                this.value = maxValue.toFixed(2); // Set to max value if exceeded
            }
        });
        // Create item quantity vald.
        document.getElementById('quantity').addEventListener('input', function (e) {

            const value = this.value;
    
            const filteredValue = value.replace(/[^0-9]/g, '');

            if (filteredValue.length > 6) {
                this.value = filteredValue.slice(0, 6); // Trim to 6 digits
            } else {
                this.value = filteredValue; // Set the filtered value
            }
        });
    });
    

    //Add new specification from /view/update
    document.getElementById('ajax_add_specification').addEventListener('submit', function(event) {
        event.preventDefault(); 
    
        const formData = new FormData(this); // Collect form data
    
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value 
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json(); // Parse JSON
        })
        .then(data => {
            // Handle success
            document.getElementById('success_messageText').innerText = data.message; // Display success message
            const responseMessage = document.getElementById('responseMessage');
            responseMessage.style.display = 'block'; 
    
            // Hide the message after 5 seconds
            setTimeout(() => {
                responseMessage.style.display = 'none';
            }, 5000);
    
            // Add click event to close button
            document.getElementById('closeMessage').onclick = function() {
                responseMessage.style.display = 'none'; 
            };
    
            // clear the form fields
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
            const existingListener = form.getAttribute('data-listener'); 
            if (existingListener) {
                form.removeEventListener('submit', existingListener); 
            }
    
            const listener = function(event) {
                event.preventDefault(); 
    
                const formData = new FormData(this); 
                const formAction = this.action; 
    
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
                    return response.json(); // Parse JSON 
                })
                .then(data => {
                    // success
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
    
            form.setAttribute('data-listener', listener); 
            form.addEventListener('submit', listener); 
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
                event.preventDefault(); 
                const formData = new FormData(this); 
                const formAction = this.action; 
    
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
                    return response.json(); // Parse JSON
                    
                    
                })
                .then(data => {
                    //  success
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
    
                    // clear the form fields 
                    form.reset(); // DONT DO IT :(
                })
                .catch(error => {
                    // Handle error
                    console.error('Error:', error);
                    const responseMessage = document.getElementById('responseMessage');
                    if (responseMessage) {
                        responseMessage.innerHTML = 'An error occurred. Please try again.'; 
                    }
                });
                
            };
    
            form.setAttribute('data-listener', listener); 
            form.addEventListener('submit', listener); 
        });
    }
    

    //LIVE RELOAD OF update specification, too use add class="ajax_reload_update_specification" data-item-id="{{ $data_item->id }}"
    $(document).on('click', '.ajax_reload_update_specification', function() {
        const itemId = $(this).data('item-id'); 
        reloadSpecifications(itemId); 
        attachFormSubmitListeners();
        attachFormSubmitListeners2();
        attachFormSubmitListeners3();
    });


    function reloadSpecifications(itemId) {
        setTimeout(function() {
            $.ajax({
                url: `/Live_reload_update_specification/${itemId}`, 
                method: 'GET', 
                success: function(response) {
                    $('#specificationsContainer').html(response); 
                    console.log('Reloaded successfully.');

                },
                error: function(xhr) {
                    console.error('Error reloading:', xhr.responseText); 
                    alert('An error occurred while reloading: ' + xhr.responseText);
                }
            });
        }, 10);
    }


    //LIVE RELOAD OF add form for specification, too use add class="ajax_reload_specification_add_form" data-item-id="{{ $data_item->id }}"
    $(document).on('click', '.ajax_reload_specification_add_form', async function() {
        const itemId = $(this).data('item-id'); 
    
        try {
            // Wait for reload to finish before executing more logic
            await reload_specifications_form(itemId);
            console.log('Form reload complete.');
            // No need to reattach button click listener here as it's already delegated
        } catch (error) {
            console.error('Error during form reload:', error);
        }
    });
    function reload_specifications_form(itemId) {
        return new Promise((resolve, reject) => {
            setTimeout(function() {
                $.ajax({
                    url: `/Live_specification_add_form/${itemId}`,
                    method: 'GET',
                    success: function(response) {
                        $('#specifications_add_form_container').html(response);
                        console.log('Reloaded successfully.');
                        resolve(); // Resolve the promise when done
                    },
                    error: function(xhr) {
                        console.error('Error reloading:', xhr.responseText);
                        alert('An error occurred while reloading: ' + xhr.responseText);
                        reject(xhr.responseText); // Reject the promise on error
                    }
                });
            }, 5);
        });
    }
    // Keep the form submit listener attached
    function attachFormSubmitListeners3() {
        $('#specifications_add_form_container').off('submit', '#ajax_add_specification'); // Remove any previously bound handlers
        $('#specifications_add_form_container').on('submit', '#ajax_add_specification', function(e) {
            e.preventDefault(); // Prevent default form submission
            console.log('Form submitted!');
    
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    console.log('Form submitted successfully:', response);
                    // You can reload the form or clear fields if needed
                },
                error: function(xhr) {
                    console.error('Form submission error:', xhr.responseText);
                }
            });
        });
    }
    

    
    







});//Dock ready end

// 
    document.addEventListener('DOMContentLoaded', function() {

    setTimeout(adjustHeight, 10);
    function adjustHeight() {
        const screenWidth = window.innerWidth;

        const sourceDiv = document.getElementById('sourceDiv');
        const targetDiv = document.getElementById('targetDiv');

        if (!sourceDiv || !targetDiv) {
            console.warn('sourceDiv or targetDiv not found. Stopping function.');
            window.removeEventListener('resize', adjustHeight); 
            return;
        }
        if (screenWidth >= 1200) {
            const sourceHeight = sourceDiv.getBoundingClientRect().height;
            targetDiv.style.height = sourceHeight + 'px';
        } else {
            targetDiv.style.height = 'auto';
        }
    }
    adjustHeight();
    setTimeout(adjustHeight, 10);
    setTimeout(adjustHeight, 100);
    setTimeout(adjustHeight, 320);
    setTimeout(adjustHeight, 500);
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

// Uploading image for item, not reloading data, inserting new item only
$(document).ready(function() {
    $('#ajax_item_image_upload').on('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: "/ajax_item_image_upload", 
            type: 'POST',
            data: formData,
            contentType: false, 
            processData: false, 
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

document.querySelectorAll('#click_too_replace_main').forEach(image => {
    image.addEventListener('click', function() {
        let targetImage = document.getElementById('replace_image_item_view');

        if (targetImage) {
            targetImage.src = this.src;
        }
    });
});

$(document).ready(function () {
    
    document.querySelectorAll('#click_too_replace_main').forEach(image => {
        image.addEventListener('click', function() {

            let targetImage = document.getElementById('replace_image_item_view');

            if (targetImage) {
                targetImage.src = this.src;
            }
        });
    });
});

// F. View Item 
function view_item_image_menu_scroll_left() {
    const container = document.getElementById('imageContainer');
    const scrollAmount = container.clientWidth * 0.65; // 
    container.scrollBy({
        left: -scrollAmount,
        behavior: 'smooth'
    });
}

function view_item_image_menu_scroll_right() {
    const container = document.getElementById('imageContainer');
    const scrollAmount = container.clientWidth * 0.65; // 
    container.scrollBy({
        left: scrollAmount,
        behavior: 'smooth'
    });
}





// DROP DOWN S
function parameter_add_setParameter(value) {
    document.getElementById('parameter_name').value = value;
    parameter_add_closeDropdown();
}
function parameter_add_filterDropdown() {
    var input, filter, ul, li, i, txtValue;
    input = document.getElementById("parameter_name");
    filter = input.value.toUpperCase();
    ul = document.getElementById("parameter_add_dropdown_options");
    li = ul.getElementsByTagName("li");
    parameter_add_openDropdown();
    for (i = 0; i < li.length; i++) {
        txtValue = li[i].textContent || li[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}
function parameter_add_openDropdown() {
    var dropdown = document.getElementById("parameter_add_dropdown_options");
    dropdown.classList.add("show");
}
function parameter_add_closeDropdown() {
    var dropdown = document.getElementById("parameter_add_dropdown_options");
    dropdown.classList.remove("show");
}
document.addEventListener('click', function(event) {
    var isClickInside = document.getElementById("parameter_name").contains(event.target) ||
                        document.getElementById("parameter_add_dropdown_options").contains(event.target);

    if (!isClickInside) {
        parameter_add_closeDropdown();
    }
});
// drop down S end here







// Filter for Price

// Assuming you move this script to a separate file later
document.addEventListener('DOMContentLoaded', function() {
    var category_price_filter_slider = document.getElementById('category_price_filter_slider');

    if (!category_price_filter_slider) {
        console.error('Slider element not found');
        return;
    }

    var minPrice = parseFloat(category_price_filter_slider.getAttribute('data-min-price'));
    var maxPrice = parseFloat(category_price_filter_slider.getAttribute('data-max-price'));
    var set_minPrice = parseFloat(category_price_filter_slider.getAttribute('data-set-min-price'));
    var set_maxPrice = parseFloat(category_price_filter_slider.getAttribute('data-set-max-price'));

    // Initialize the slider with set_minPrice and set_maxPrice as starting values
    noUiSlider.create(category_price_filter_slider, {
        start: [set_minPrice, set_maxPrice], // Use set_minPrice and set_maxPrice here
        connect: true,
        range: {
            'min': minPrice,
            'max': maxPrice
        },
        step: 0.01,
        format: {
            to: function(value) {
                return value.toFixed(2);
            },
            from: function(value) {
                return parseFloat(value);
            }
        }
    });

    var category_price_filter_minPriceValue = document.getElementById('category_price_filter_minPriceValue');
    var category_price_filter_maxPriceValue = document.getElementById('category_price_filter_maxPriceValue');
    var categoryIdentifier = document.getElementById('category_identifier').value; // Accessing the hidden input value

    // Set the initial displayed values
    category_price_filter_minPriceValue.innerHTML = set_minPrice.toFixed(2);
    category_price_filter_maxPriceValue.innerHTML = set_maxPrice.toFixed(2);

    category_price_filter_slider.noUiSlider.on('update', function (values, handle) {
        if (handle === 0) {
            category_price_filter_minPriceValue.innerHTML = values[0];
        } else {
            category_price_filter_maxPriceValue.innerHTML = values[1];
        }
    });

    category_price_filter_slider.noUiSlider.on('change', function (values) {
        const minPrice = values[0];
        const maxPrice = values[1];

        // Get the current URL
        let currentUrl = window.location.href;

        // Create a base URL by removing the existing query parameters
        let baseUrl = currentUrl.split('?')[0];

        // Preserve existing filters (excluding price filters)
        let existingFilters = currentUrl.split('?')[1] ? currentUrl.split('?')[1].split('&').filter(param => !param.startsWith('minPrice') && !param.startsWith('maxPrice')).join('&') : '';

        // Construct the new URL
        if (existingFilters) {
            // If there are existing filters, append the price filters with '&'
            window.location.href = `${baseUrl}?${existingFilters}&minPrice=${minPrice}&maxPrice=${maxPrice}`;
        } else {
            // If no existing filters, just append the price filters with '?'
            window.location.href = `${baseUrl}?minPrice=${minPrice}&maxPrice=${maxPrice}`;
        }
    });
});



// FILTER the PARAMETERS values
function updateFilterUrl() {
    // Get the current URL
    let currentUrl = window.location.href;

    // Create a base URL by removing the existing query parameters
    let baseUrl = currentUrl.split('?')[0];

    // Initialize an array to hold selected filters
    let filters = [];

    // Select all checkboxes with the class .update_filter_button_url
    document.querySelectorAll('.update_filter_button_url').forEach(function(checkbox) {
        // Check if the checkbox is checked
        if (checkbox.checked) {
            // Get parameter ID and value ID
            let parameterId = checkbox.getAttribute('data-parameter-id');
            let valueId = checkbox.getAttribute('data-value-id');
            // Create a filter string and push to the filters array
            filters.push(`fa[]=${parameterId}:${valueId}`);
        }
    });

    // Join filters with '&'
    let filterString = filters.join('&');

    // Preserve existing price filters
    let priceFilters = currentUrl.split('?')[1] ? currentUrl.split('?')[1].split('&').filter(param => param.startsWith('minPrice') || param.startsWith('maxPrice')).join('&') : '';

    // Check if there are already query parameters in the current URL
    if (priceFilters) {
        // If there are existing parameters, append new filters with '&'
        if (filterString) {
            document.getElementById('apply_filter').href = `${baseUrl}?${priceFilters}&${filterString}`;
        } else {
            document.getElementById('apply_filter').href = `${baseUrl}?${priceFilters}`;
        }
    } else {
        // If no existing price parameters, append filters with '?'
        if (filterString) {
            document.getElementById('apply_filter').href = `${baseUrl}?${filterString}`;
        } else {
            document.getElementById('apply_filter').href = baseUrl; // No filters selected, just the base URL
        }
    }

    // Optional: Log the filters array to the console
    console.log(filters);
}





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
                displayMessage( response.message, 1);

                console.log('Success:', response);
                reloadSpecifications(itemId); 
            },
            error: function(xhr, status, error) {
                displayMessage("Error", 2);

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
                displayMessage( response.message, 1);

                //reloadSpecifications(itemId); // Reload after success
            },
            error: function(xhr, status, error) {
                displayMessage("Error", 2);
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
                    var itemId = response.item_id; 
                    window.location.href = '/view/' + itemId; 
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
                        displayMessage( response.message, 1);
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
            this.value = this.value.replace(/[^0-9.]/g, '');
            
            const parts = this.value.split('.');
            
            if (parts.length > 2) {
                this.value = parts[0] + '.' + parts.slice(1).join('');
            }
        
            if (parts[1] && parts[1].length > 2) {
                this.value = parts[0] + '.' + parts[1].slice(0, 2);
            }
            
            // maximum value of 999999.99
            const maxValue = 999999.99;
            if (parseFloat(this.value) > maxValue) {
                this.value = maxValue.toFixed(2); 
            }
        });
        // Create item quantity vald.
        document.getElementById('quantity').addEventListener('input', function (e) {

            const value = this.value;
    
            const filteredValue = value.replace(/[^0-9]/g, '');

            if (filteredValue.length > 6) {
                this.value = filteredValue.slice(0, 6); 
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
            displayMessage( data.message, 1);

            /*
            document.getElementById('success_messageText').innerText = data.message; 
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
                            */

        })
        .catch(error => {
            // Handle error
            console.error('Error:', error);
            document.getElementById('responseMessage').innerHTML = 'An error occurred. Please try again.';
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
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value 
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        displayMessage("Error", 2);

                        throw new Error('Network response was not ok ' + response.statusText);


                    }
                    return response.json(); 

                })
                .then(data => {
                    // success
                    displayMessage( data.message, 1);
                    /*
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
                    */
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
                    displayMessage("Error", 2);

                });
            };
    
            form.setAttribute('data-listener', listener); 
            form.addEventListener('submit', listener); 
        });
    }


    function attachFormSubmitListeners2() {
        document.querySelectorAll('.ajax_add_only_value_form').forEach(form => {
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
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value 
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok ' + response.statusText);
                    }
                    return response.json();
                    
                    
                })
                .then(data => {
                    //  success
                    document.getElementById('success_messageText').innerText = data.message; 
                    const responseMessage = document.getElementById('responseMessage');
                    responseMessage.style.display = 'block';

                    setTimeout(() => {
                        responseMessage.style.display = 'none';
                    }, 5000);

                    document.getElementById('closeMessage').onclick = function() {
                        responseMessage.style.display = 'none'; 
                    };

                    form.reset(); // DONT DO IT :(
                })
                .catch(error => {
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
                    displayMessage("Error", 2);
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
            await reload_specifications_form(itemId);
            console.log('Form reload complete.');
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
                        resolve(); 
                    },
                    error: function(xhr) {
                        console.error('Error reloading:', xhr.responseText);
                        alert('An error occurred while reloading: ' + xhr.responseText);
                        reject(xhr.responseText);
                    }
                });
            }, 5);
        });
    }

    function attachFormSubmitListeners3() {
        $('#specifications_add_form_container').off('submit', '#ajax_add_specification'); 
        $('#specifications_add_form_container').on('submit', '#ajax_add_specification', function(e) {
            e.preventDefault(); 
            console.log('Form submitted!');
    
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    console.log('Form submitted successfully:', response);

                },
                error: function(xhr) {
                    console.error('Form submission error:', xhr.responseText);
                }
            });
        });
    }


});//Dock ready end

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
                    displayMessage(response.message, 1);

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
                displayMessage("Error", 2);
                console.log(xhr.responseText);
            }
        });
    });
});


// CREATE ITEM





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



function displayMessage(message, type) {
    const messageContainer = document.getElementById('responseMessage');
    const messageText = document.getElementById('success_messageText');
    const closeButton = document.getElementById('closeMessage');
    messageContainer.classList.remove('the_success_message', 'the_error_message');

    if (type === 1) {
        messageContainer.classList.add('the_success_message');
    } else if (type === 2) {
        messageContainer.classList.add('the_error_message');
    }
    messageText.textContent = message;
    
    const timerSpan = document.createElement('span');
    timerSpan.style.marginLeft = '10px';
    messageText.appendChild(timerSpan);
    
    let timeRemaining = 6; // Time in seconds
    
    function updateTimer() {
        timerSpan.textContent = ` (${timeRemaining.toFixed(1)}s)`;
    }
    updateTimer();
    messageContainer.style.display = 'block';

    closeButton.addEventListener('click', function() {
        messageContainer.style.display = 'none';
        clearTimeout(closeTimer); 
        clearInterval(timerInterval); 
    });
    
    const closeTimer = setTimeout(function() {
        messageContainer.style.display = 'none';
    }, 6000);
    
    const timerInterval = setInterval(function() {
        timeRemaining -= 1; 
        updateTimer();
        
        if (timeRemaining <= 0) {
            clearInterval(timerInterval); 
        }
    }, 1000);
}

// REUSED
$(document).on('click', '#like_the_item', function(event) {
    event.preventDefault(); 

    var itemId = $(this).data('item-id');

    $.ajax({
        url: '/add/like/item/' + itemId, 
        type: 'GET',
        dataType: 'json', 
        success: function(response) {
            //displayMessage(response.message, 1);
            //event.preventDefault(); 
        },
        error: function(xhr) {
            console.error('Error removing item:', xhr.responseText); 
            //displayMessage("Error", 2);
            window.location.href = '/register'; 

        }
    });
});

$(document).on('click', '#liked_item_svg', function() {
    var $this = $(this);
    var $reaction = $this.find('.reaction');
    $this.toggleClass('liked_item_svg');
    $reaction.addClass('active');
    setTimeout(function() {
        $reaction.removeClass('active');
    }, 10); 
});

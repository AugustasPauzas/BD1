$(document).ready(function() {
    console.log("Document Ready");

    document.addEventListener('DOMContentLoaded', function() {


        
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
                    displayMessage(response.message, 1);

                    console.log('Image deleted successfully');
                } else {
                    displayMessage("Error", 1);
                    //alert('Failed to delete the image.');
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText); 
                //alert('Error deleting the image.');
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


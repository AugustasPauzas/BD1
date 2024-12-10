$(document).ready(function() {
    $('#placeorder').on('submit', function(e) {
        e.preventDefault(); // Prevent form submission
        var form = $(this);
        var url = form.attr('action'); // Get form's action URL

        $.ajax({
            url: url,
            method: 'POST',
            data: form.serialize(), 
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log(response); // Debugging line

                // Reset form and clear previous errors
                form.trigger('reset');
                $('.text-danger').text('');
                
                //alert(response.message); // Show success message

                // Redirect to the specified URL
                if (response.redirect_url) {
                    window.location.href = response.redirect_url;
                }
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    var errors = xhr.responseJSON.errors;
                    
                    // Clear previous errors
                    $('.text-danger').text('');

                    // Display validation errors dynamically
                    if (errors.name) $('.error-name').text(errors.name[0]);
                    if (errors.lastname) $('.error-lastname').text(errors.lastname[0]);
                    if (errors.email) $('.error-email').text(errors.email[0]);
                    if (errors.country) $('.error-country').text(errors.country[0]);
                    if (errors.phone) $('.error-phone').text(errors.phone[0]);
                    if (errors.postcode) $('.error-postcode').text(errors.postcode[0]);
                    if (errors.city) $('.error-city').text(errors.city[0]);
                    if (errors.address) $('.error-address').text(errors.address[0]);

                } else {
                    console.error('Error response is not in the expected format:', xhr.responseJSON);
                }
            }

        });
    });
});



    $(document).ready(function() {
        // When the country dropdown changes
        $('#country').on('change', function() {
            // Get the selected country's code
            var countryCode = $(this).val();
            
            // Update the country code display in the input group
            $('#country-code').text(countryCode);
            
            // Optionally clear the phone input field when country changes
            $('#phone').val('');
        });
    });


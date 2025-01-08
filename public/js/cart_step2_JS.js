$(document).ready(function() {
    $('#placeorder').on('submit', function(e) {
        e.preventDefault(); 
        var form = $(this);
        var url = form.attr('action'); 

        $.ajax({
            url: url,
            method: 'POST',
            data: form.serialize(), 
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log(response); 

                form.trigger('reset');
                $('.text-danger').text('');
                
                //alert(response.message); 

                if (response.redirect_url) {
                    window.location.href = response.redirect_url;
                }
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    var errors = xhr.responseJSON.errors;
                    
                    $('.text-danger').text('');

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
        $('#country').on('change', function() {
            var countryCode = $(this).val();
            
            $('#country-code').text(countryCode);
            
            $('#phone').val('');
        });
    });


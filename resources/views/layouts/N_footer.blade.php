

<?php
//meta
$VarWebsiteNameLong = "Computer Parts";
//kontaktiniai duomenys
$VarWebsitePhoneNumber = "+370 674 20469";
$VarWebsiteEmail = "Email@gmail.com";
$VarWebsiteLocation = "Pramonės pr. 20";
?>

<div class="default_top_margin under_shadow_top"></div>
<footer class="page-footer font-small blue pt-4 primary_background_color footer_fixed_bottom default_top_margin under_shadow_top">
<!-- Footer Links -->
    <div class="container-fluid text-center text-md-left">

    <!-- row -->
    <div class="row">

        <!-- Column -->
        <div class="col-md-6 mt-md-0 mt-3">

            <h5 class="text-uppercase ">{{ $VarWebsiteNameLong }}</h5>
            <p class="text_center_edges">Welcome to our e-commerce. We’re your go-to destination for top-quality PC parts and accessories. Whether you're building a custom rig or upgrading your current setup, we've got everything you need- from processors and GPUs to the latest peripherals. Enjoy fast shipping, competitive prices, and expert customer support. Happy building!</p>
        </div>




        <!-- Grid column -->
        <div class="col-md-3 mb-md-0 mb-3">

        <!-- Links -->
        <h5 class="text-uppercase"><!--Links--></h5>

        <ul class="list-unstyled">
            <li>
            <a href="#!"><!--Link 1--></a>
            </li>
            <li>
            <a href="#!"><!--Link 2--></a>
            </li>
            <li>
            <a href="#!"><!--Link 3--></a>
            </li>
            <li>
            <a href="#!"><!--Link 4--></a>
            </li>
        </ul>

        </div>
        <!-- Grid column -->

        <div class="col-md-3 mb-md-0 mb-3">

            <!-- kontaktai -->
            <h5 class="remain_center text-uppercase">Contact information</h5>
            
            <table class="remain_center">
            <tr class = "list-unstyled">
                <td class="footer_svg_outside_padding_right">
                    <img class="footer_svg" src="/svg/phone-svgrepo-com.svg" alt="">
                </td>
                <td class= "align_text_left">{{ $VarWebsitePhoneNumber }}</td>
            </tr>
            <tr>
                <td class="footer_svg_outside_padding_right">
                    <img class="footer_svg" src="/svg/mail-svgrepo-com.svg" alt="">
                </td>
                <td class= "align_text_left">{{ $VarWebsiteEmail }}</td>
            </tr>

            <tr>
                <td class="footer_svg_outside_padding_right">
                    <img class="footer_svg" src="/svg/location-pin-alt-svgrepo-com.svg" alt="">
                </td>
                <td class= "align_text_left">{{ $VarWebsiteLocation }}</td>
            </tr>
            </table>



        </div>
    </div>
    </div>


    <div id="privacy_banner" class="privacy_banner default_radius grey_border under_shadow_top under_shadow">
        <p>
            We use cookies to ensure you get the best experience on our website. 
            <a href="/privacy-policy" target="_blank">Learn more</a>
        </p>
        <button id="accept_btn" class="accept_btn">Accept</button>
    </div>
    <script>
    
// Function to set a cookie
function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + value + expires + "; path=/";
}

// Function to get a cookie by name
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

// Function to handle acceptance of the privacy banner
document.getElementById('accept_btn').addEventListener('click', function() {
    setCookie('privacyAccepted', 'true', 365);
    document.getElementById('privacy_banner').style.display = 'none';
});

// Check if the user has already accepted
window.onload = function() {
    // If the cookie 'privacyAccepted' is not set to 'true', show the banner
    if (getCookie('privacyAccepted') !== 'true') {
        document.getElementById('privacy_banner').style.display = 'flex';
    }
};


    </script>

    <!-- Copyright -->
    <div class="footer-copyright text-center py-3">© {{ now()->year }}  Copyright:
    <a href="/"> {{ $VarWebsiteNameLong }}</a>
    </div>
</footer>


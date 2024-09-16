<div class="default_top_margin"></div>
<footer class="page-footer font-small blue pt-4 primary_background_color footer_fixed_bottom default_top_margin">
<!-- Footer Links -->
    <div class="container-fluid text-center text-md-left">

    <!-- row -->
    <div class="row">

        <!-- Column -->
        <div class="col-md-6 mt-md-0 mt-3">

            <h5 class="text-uppercase ">{{ $VarWebsiteNameLong }}</h5>
            <p class="text_center_edges">Welcome to our e-commerce. We’re your go-to destination for top-quality PC parts and accessories. Whether you're building a custom rig or upgrading your current setup, we've got everything you need- from processors and GPUs to the latest peripherals. Enjoy fast shipping, competitive prices, and expert customer support. Happy building!</p>
        </div>


        <hr class="clearfix w-100 d-md-none pb-3">

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
    <!-- Copyright -->
    <div class="footer-copyright text-center py-3">© {{ now()->year }}  Copyright:
    <a href="/"> {{ $VarWebsiteNameLong }}</a>
    </div>
</footer>


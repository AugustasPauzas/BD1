
@extends ('layouts.default_body')
@section('content')
<script type="text/javascript" src="{{ asset('js/cart_step2_JS.js') }}"></script>

<div class="container default_container_margin primary_background_color default_padding default_margin default_radius under_shadow">

    <div class="row no_margin_sides ">
        <div class="col-md-4">
            <div class="row no_margin_sides default_radius">
                <div class="col-12 default_padding">
                    <a href="/cart">
                        <button type="button" class="btn btn-secondary btn">

                            <svg class="small_svg" viewBox="0 0 24.00 24.00" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="0.144"/>
                                <g id="SVGRepo_iconCarrier"> <path d="M5 12H19M5 12L11 6M5 12L11 18" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> </g>
                            </svg>                            
                            Previos Step


                        </button>                            
                    </a>
            
                </div>
                <div class="col-12 default_padding">
                    @include('partials.Live_cart_step2')  
                </div>
            </div>

        </div>
        <div class="col-md-8">
            <br>
            <p class="text_align_center font_120"> <strong>Delivery Information</strong></p>
            <form id="placeorder" method="POST" action="{{ route('ordersubmit') }}">
            @csrf
            <div class="row no_margin_sides default_radius">
                
                <div class="col-sm-6  default_large_margin">
                    
                    <div class="default_margin_sides default_padding secondary_background_color default_radius">
                        <div class="default_margin default_margin_sides">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input id="name" name="name" type="text" value="" class="form-control" placeholder="">
                                <span class="text-danger error-name"></span>
                            </div>
                            <div class="form-group">
                                <label for="lastname">Last Name</label>
                                <input id="lastname" name="lastname" type="text" value="" class="form-control" placeholder="">
                                <span class="text-danger error-lastname"></span>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" name="email" type="text" value="" class="form-control" placeholder="">
                                <span class="text-danger error-email"></span>
                            </div>

                            <div class="form-group">
                                <label for="country">Country</label>
                                <select id="country" name="country" class="form-control">
                                    <option value="+372">Estonia</option>    
                                    <option value="+371">Latvia </option>                                                                    
                                    <option value="+370" selected>Lithuania</option>
                                    <option value="+48">Poland </option>

                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="country-code">+370</span>
                                    <input id="phone" name="phone" type="text" class="form-control" placeholder="Enter your phone number">
                                </div>
                                <span class="text-danger error-phone"></span>
                            </div>
                            

                            
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 default_large_margin">
                    <div class="default_margin_sides default_padding secondary_background_color default_radius">
                        <div class="form-group">
                            <label for="postcode">Post Code</label>
                            <input id="postcode" name="postcode" type="text" value="" class="form-control" placeholder="">
                            <span class="text-danger error-postcode"></span>
                        </div>
                        <div class="form-group">
                            <label for="city">City</label>
                            <input id="city" name="city" type="text" value="" class="form-control" placeholder="">
                            <span class="text-danger error-city"></span>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input id="address" name="address" type="text" value="" class="form-control" placeholder="">
                            <span class="text-danger error-address"></span>
                        </div>
                    </div>
                    <div class="row no_margin_sides default_radius">
                        <div class="col-12 default_padding default_margin text-end">
                            <button  type="submit" class="btn btn-primary">     Submit Order</button>       
                        </div>
                    </div>
                </div>
            </div>
            </form>
            <script>



            </script>
        </div>
    </div>

</div>

@endsection
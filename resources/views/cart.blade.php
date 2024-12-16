@extends ('layouts.default_body')
@section('content')

<script type="text/javascript" src="{{ asset('js/cart_JS.js') }}"></script>


<div class="default_container_margin">

    {{-- 
    <div class="container primary_background_color">
        <p class="reload_cart">reload</p>

    </div>
    --}}


    {{-- 
    <br>
    @foreach ($data_rules as $i)
    <p> <strong>{{$i}}</strong></p>
        @php
        $value1=null;
        $value2=null;
        @endphp
        @foreach ($data_specifications as $ii)
        <p>{{$ii}}
            @if ($i->category_id_1 == $ii->category_id)
                <span style="color:red"><- HERE 1</span>
                @if ($i->parameter_id_1 == $ii->parameter_id)
                {{$value1=$ii}}
                <span style="color:blue"><- HERE 22</span>

            @endif
            @endif
            @if ($i->category_id_2 == $ii->category_id)
                <span style="color:red"><- HERE 2</span>
                @if ($i->parameter_id_2 == $ii->parameter_id)
                
                    {{$value2=$ii}}
                    <span style="color:blue"><- HERE 22</span>

                @endif
            @endif
        </p>    
        @endforeach
        @if ($value1 != null && $value2 != null)
            @if ($value1->value_id == $value2->value_id)
                <P style="color:green"> 
                    Items 
                    <strong>{{$value1->item_name}}</strong> 
                    & 
                    <strong>{{$value2->item_name}}</strong> 
                    Are  Comptable 
                </P>
            @else
                <P style="color:red"> 
                    Items 
                    <strong>{{$value1->item_name}}</strong> 
                    & 
                    <strong>{{$value2->item_name}}</strong> 
                    Are  Incomptable Via 
                    <strong>{{$value2->parameter_name}}: {{$value2->value_name}} </strong> 
                    &
                    <strong>{{$value1->parameter_name}}: {{$value1->value_name}} </strong> 

                </P>
            @endif
        @endif
    @endforeach
            --}}

    <div class="container">
        <div class="row">
            <div class="col-lg-3 default_large_margin_bottom hide_on_lg">
                <div class="primary_background_color default_padding default_margin default_radius under_shadow">
                    <p ><strong class="remain_center default_padding">You Might Also Like </strong>  </p>

                    <div class="screen_height_70 custom-scroll">
                        @foreach ($data_random_items as $ri)
                        
                        <div class="item_row_2"> 
                            <div class="small_padding ">

                                <div class="secondary_background_color default_radius">           
                                    <a class="no_anchor_decoration" href="/view/{{$ri->id}}">
                                        @php $imageFound = false; @endphp
                                        <div class="image_with_status_container">
                                            @foreach ($data_images as $img)
                                                @if ($ri->id == $img->item_id && !$imageFound)
                                                    <img id="replace_image_item_view square_image" 
                                                        class="default_radius full_width_image square_image tertiary_background_color" 
                                                        src="{{ asset($img->image_location) }}" 
                                                        onerror="this.onerror=null; this.src='{{ url('/images/missingPicture.png') }}';" 
                                                        alt="Image of {{$ri->name}}">
                                                    @php $imageFound = true; @endphp
                                                    @break
                                                @endif
                                            @endforeach
                                    
                                            @if (!$imageFound)
                                                <img id="replace_image_item_view" 
                                                    class="default_radius full_width_image image_cover" 
                                                    src="" 
                                                    onerror="this.onerror=null; this.src='{{ url('/images/missingPicture.png') }}';" 
                                                    alt="Default image">
                                            @endif
                                    
                                        </div>
                                    </a>

                                    <p class="one_line_clamp small_margin font_75">{{$ri->name}}</p>
                                    <p class="small_margin font_75" ><strong class="remain_center price_p">{{ number_format($ri->price, 2) }}<span class="Price_small_p"></span> €</strong>    </p>
                                
                                </div>


                            </div>                       
                        </div>
                
                        @endforeach
                    </div>

                    <!--
                    <div class="full_width_image secondary_background_color default_padding default_margin default_radius ">
                        <p class="text_align_center">
                            <svg class="extra_extra_large_svg grey_svg_stroke default_padding" viewBox="0 0 24 24" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                <g id="SVGRepo_iconCarrier">
                                <defs>
                                <style>.cls-1{fill:none;stroke-width:1.92px;}</style>
                                </defs>
                                <polygon class="cls-1" points="9.13 22.54 5.29 22.54 5.29 6.25 5.29 1.46 9.13 1.46 9.13 22.54"/>
                                <polygon class="cls-1" points="1.46 6.25 22.54 6.25 22.54 5.29 9.13 1.46 5.29 1.46 1.46 5.29 1.46 6.25"/>
                                <line class="cls-1" x1="23.5" y1="22.54" x2="0.5" y2="22.54"/>
                                <path class="cls-1" d="M20.62,6.25V9.64a1.82,1.82,0,0,0,.9,1.63A1.92,1.92,0,1,1,18.71,13"/>
                                <line class="cls-1" x1="9.13" y1="16.79" x2="5.29" y2="20.63"/>
                                <line class="cls-1" x1="5.29" y1="12" x2="9.13" y2="15.83"/>
                                <line class="cls-1" x1="9.13" y1="7.21" x2="5.29" y2="11.04"/>
                                </g>
                                </svg>                              
                        </p>
                        <p class="text_align_center font_120"> <strong>Under Construction</strong></p>
                        
                    </div>
                    -->
                </div>
            </div>

            <div class="col-lg-9">

                <div class=" primary_background_color default_padding default_margin default_radius under_shadow">
                    <p ><strong class="remain_center"></strong>  </p>
            
                    <div class="row no_margin_sides default_radius hide_on_lg">
                        <div class="col-lg-7">
                            <div class="row no_margin_sides">
                                <div class="col-3 no_padding_sides">
                                    <div class="col_cart_img remain_center ">
                                    </div>
                                </div>
                                <div class="col-9">
                                    <strong>Item Name</strong> 
                                </div>                            
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="row no_margin_sides">
                                <div class="col-6">
                                    <div class="col_cart_img remain_center ">
                                        <strong>Quantity</strong>
                                    </div>
                                </div>
                                <div class="col-4  ">
                                    <strong>Price</strong>
                                </div>   
                                <div class="col-2  ">
                                </div>                            
                            </div>
                        </div>
                    </div>
                     {{--
                    <p>cart_items</p>
                    <p>{{ json_encode($cart_items, JSON_PRETTY_PRINT) }}</p>
                                    
                    <p>cookie_data</p>
                     <p>{{ json_encode($cookie_data, JSON_PRETTY_PRINT) }}</p>
                   
                     --}}
                    
                    
                    
                <div id="cart-container">
                    {{-- CART View start here --}}
                    @include('partials.Live_cart')  
                    {{-- CART View end here --}}
                </div>
            </div>
        </div>
    
    </div>
</div>

</div>
 {{-- 

<div class="container">
    <p>COOKIES: </p>
    <div class="row">
        @if (count($cart_items) > 0)
                @foreach ($cart_items as $itemId => $quantity)
                        {{ $itemId }}
                       {{ $quantity }}
                @endforeach
        @else
            <p>dB quant.</p>
        @endif
    </div>
</div>

<div class="container">
    <p>COOKIES: </p>
    <div class="row">
        @if (count($cart_items) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Item ID</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cart_items as $itemId => $quantity)
                    <tr>
                        <td>{{ $itemId }}</td>
                        <td>{{ $quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <p>Your cart is empty.</p>
        @endif
    </div>
    
</div>
--}}


@endsection
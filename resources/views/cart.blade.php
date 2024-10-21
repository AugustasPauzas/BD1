@extends ('layouts.default_body')
@section('content')

<div class="default_container_margin">

    <div class="container primary_background_color">
        <p class="reload_cart">reload</p>

    </div>


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


    <div class="container">
        <div class="row">
            <div class="col-md-3 ">
                <div class="primary_background_color default_padding default_margin default_radius under_shadow">
                    <p ><strong class="remain_center">Compatibility</strong>  </p>
                    <div class="full_width_image secondary_background_color default_padding default_margin default_radius ">

                        @foreach ($data_rules as $i)
                        <p> </p>
                            @php
                            $value1=null;
                            $value2=null;
                            @endphp
                            @foreach ($data_specifications as $ii)
                                @if ($i->category_id_1 == $ii->category_id)
                                    @if ($i->parameter_id_1 == $ii->parameter_id)
                                    @php
                                        $value1=$ii
                                    @endphp
                                @endif
                                @endif
                                @if ($i->category_id_2 == $ii->category_id)
                                    @if ($i->parameter_id_2 == $ii->parameter_id)
                                    @php
                                        $value2=$ii
                                    @endphp
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
                                        Are  Compatible 
                                    </P>
                                @else
                                    <P style="color:red"> 
                                        Items 
                                        <strong>{{$value1->item_name}}</strong> 
                                        & 
                                        <strong>{{$value2->item_name}}</strong> 
                                        Are  Incompatible Via 
                                        <strong>{{$value2->parameter_name}}: {{$value2->value_name}} </strong> 
                                        &
                                        <strong>{{$value1->parameter_name}}: {{$value1->value_name}} </strong> 
                    
                                    </P>
                                @endif
                            
                            @endif
                        @endforeach

                        @if(true)         
                        <p class="text_align_center "> Found!</p>
                        @else
                        <p class="text_align_center "> Found!</p>     
                        @endif
                        
                    </div>
                </div>
            </div>

            <div class="col-md-9 ">

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


                <div id="cart-container">
                    {{--CART View start here--}}
                    @php
                    $total_price=0;
                    @endphp
                
                    @if (!empty($cookie_data))
                        @foreach ($cookie_data as $i) 
                        <div class="row no_margin_sides secondary_background_color cart_item_row default_radius">
                            <div class="col-lg-7">
                                <div class="row no_margin_sides">
                                    <div class="col-3 no_padding_sides">
                                        <div class="col_cart_img remain_center ">
                                            <a href="{{ url('view') }}/{{$i->item_id}}">
                                                {{$i->quantity}}
                                                @php
                                                $imageFound = false; // Flag to track if an image is found
                                                @endphp
                                                @foreach ($data_images as $img)
                                                    @if ($img->item_id == $i->item_id)
                                                        <img class="full_width_image default_radius square_image" 
                                                            src="{{ url($img->image_location) }}" 
                                                            onerror="this.onerror=null; this.src='{{ url('/images/missingPicture.png') }}';" 
                                                            alt="">
                                                        @php
                                                            $imageFound = true; // Set flag to true if image is found
                                                            break; // Exit the loop once the image is found
                                                        @endphp
                                                    @endif
                                                @endforeach    
                                                @if (!$imageFound)
                                                    <img class="full_width_image default_radius square_image" 
                                                        src="{{ url('/images/missingPicture.png') }}" 
                                                        alt="">
                                                @endif
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-9 default_padding default_margin two_line_clamp">
                                        {{$i->name}}

                                    </div>                            
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="row no_margin_sides">
                                    <div class="col-6">
                                        <div class="col_cart_img remain_center default_padding default_margin">
                                            @php
                                                $theQuantity=0;
                                            @endphp 
                                            <a class="decrease_quantity_item_cart" data-item-id="{{$i->item_id}}" href="#/{{$i->item_id}}">
                                            - 
                                            </a>
                                            @if (count($cart_items) > 0)
                                            @foreach ($cart_items as $itemId => $quantity)
                                                @if ($itemId == $i->item_id)
                                                     @php
                                                     $theQuantity=$quantity;
                                                     @endphp
                                                   {{ $theQuantity }}
                                                @endif
                                            @endforeach
                                            @else
                                                <p>dB quant.</p>
                                            @endif
                                            <a class="add_quantity_item_cart" data-item-id="{{$i->item_id}}" href="#/{{$i->item_id}}">
                                              +   
                                            </a>
                                            
                                        </div>
                                    </div>
                                    <div class="col-4 default_padding default_margin ">
                                        {{$i->price}}€
                                        @php
                                            $total_price=$total_price+ ($i->price*$theQuantity)
                                        @endphp
                                    </div>   
                                    <div class="col-2 default_padding default_margin ">
                                        <a class="cart_remove_item  " data-item-id="{{ $i->item_id }}" href="not/{{$i->item_id}}">
                                            <svg class="small_svg delete_button_svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10 12V17"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M14 12V17"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M4 7H20"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M6 10V18C6 19.6569 7.34315 21 9 21H15C16.6569 21 18 19.6569 18 18V10"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </a>
                                    </div> 
                                    <script>


                                    </script>                        
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <p>Your cart is empty.</p>
                    @endif

                    <div class="row no_margin_sides default_radius ">
                        <div class="col-lg-7"></div>
                        <div class="col-lg-5">
                            <p ><strong class="remain_center">Total:  {{$total_price}}€</strong>  </p>
                        </div>
                    </div>
    
                    <br>
    
                    <div class="row no_margin_sides default_radius">
                        <div class="col-12 text-end">
                            <a href="cart/continue">
                                <button type="button" class="btn btn-success btn">
                                    Next Step
                                    <?xml version="1.0" encoding="utf-8"?>
                                    <svg class="small_svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4 12L20 12M20 12L17 9M20 12L17 15" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>                            
                            </a>
    
                        </div>
                    </div>       

                {{--CART View end here--}}
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
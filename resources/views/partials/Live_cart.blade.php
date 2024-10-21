@php
$total_price=0;
@endphp

@if ($cookie_data->isNotEmpty())
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
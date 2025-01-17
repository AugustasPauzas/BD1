@php
$total_price=0;
@endphp

@if (!empty($cookie_data))
    @foreach ($cookie_data as $i) 
    <div class="row no_margin_sides secondary_background_color cart_item_row default_radius">
        <div class="col-lg-12">
            <div class="row no_margin_sides">
                <div class="col-3 no_padding_sides">
                    <div class="col_cart_img remain_center ">
                        <a href="{{ url('view') }}/{{$i->item_id}}">

                            @php
                            $imageFound = false; 
                            @endphp
                            @foreach ($data_images as $img)
                                @if ($img->item_id == $i->item_id)
                                    <img class="full_width_image default_radius square_image" 
                                        src="{{ url($img->image_location) }}" 
                                        onerror="this.onerror=null; this.src='{{ url('/images/missingPicture.png') }}';" 
                                        alt="">
                                    @php
                                        $imageFound = true; 
                                        break; 
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
                
                <div class="col-9 default_padding  ">
                    <p class=" default_margin_sides two_line_clamp">
                        {{$i->name}}
                    </p>
                    @php
                    $theQuantity=0;
                    @endphp 


                    <p class=" default_margin_sides two_line_clamp">
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
                            <p>{{translate("Invalid quant.")}}</p>
                        @endif
                         x
                        {{ number_format($i->price, 2) }}€
                        @php
                            $total_price=$total_price+ ($i->price*$theQuantity)
                        @endphp
                    </p>

                </div>                            
            </div>
        </div>
 

    </div>

    @endforeach
@else
<div>
<p class="text_align_center">
    <svg class="extra_extra_large_svg grey_svg_stroke" viewBox="0 0 24 24" fill="none">
    <circle cx="12" cy="12" r="10" stroke="#33363F" stroke-width="2" stroke-linecap="round"/>
    <path d="M7.88124 16.2441C8.37391 15.8174 9.02309 15.5091 9.72265 15.3072C10.4301 15.103 11.2142 15 12 15C12.7858 15 13.5699 15.103 14.2774 15.3072C14.9769 15.5091 15.6261 15.8174 16.1188 16.2441" stroke="#33363F" stroke-width="2" stroke-linecap="round"/>
    <circle cx="9" cy="10" r="1.25" fill="#33363F" stroke="#33363F" stroke-width="0.5" stroke-linecap="round"/>
    <circle cx="15" cy="10" r="1.25" fill="#33363F" stroke="#33363F" stroke-width="0.5" stroke-linecap="round"/>
    </svg>                                
</p>
<p class="text_align_center font_120"> <strong>{{translate("Your cart is empty.")}}</strong></p>

</div>
@endif



<div class="row no_margin_sides default_radius ">
    <div class="col-lg-12 text-end">
        <p ><strong class="font_120">{{translate("Total:")}} {{ number_format($total_price, 2) }}€</strong>  </p>
    </div>
</div>



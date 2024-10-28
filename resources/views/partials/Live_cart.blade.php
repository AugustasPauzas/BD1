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
                        {{--   <span>{{$i->quantity}}</span> TO DO fix the oversup  --}}
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
        {{-- compatability check here --}}
        <div class="col-12">
            @php  
            $EverythingOK = false;
            $count=0;
            @endphp
            <br>
            @foreach ($data_rules as $ii)
                {{-- 
                <p>c_i_1: {{$ii->category_id_1}}; c_i_2: {{$ii->category_id_2}}; p_i_1: {{$ii->parameter_id_1}}; p_i_2: {{$ii->parameter_id_2}}</p>
--}}
                @php $value=false; $value_name=false; $the_item_id=false; $category=false; $category_target=-1 @endphp
                @foreach ($data_specifications as $iii)
                    @if ($iii->item_id == $i->item_id)
                    {{-- 
                    <p style="color: rgb(0, 0, 0)"> <strong>item 1</strong> {{$iii}}</p>
                    --}}
                        @if ($ii->parameter_id_1 ==  $iii->parameter_id || $ii->parameter_id_2 ==  $iii->parameter_id)
                        {{-- <p style="color: red">HERE ^^^</p>--}}
                        @php $value=$iii->value_id; $value_name=$iii->value_name; $category=$iii->category_id; @endphp

                        @endif
                    @else
                    <p >{{--$iii--}}</p>
                    @endif
                @endforeach

                

                @if ($category && $category == $ii->category_id_2)
                    @php $category_target = $ii->category_id_1 @endphp
                @endif
                @if ($category && $category == $ii->category_id_1 )
                    @php $category_target = $ii->category_id_2 @endphp
                @endif
                
                
                @foreach ($data_specifications as $iii)
                    @if ( $value && $category && $iii->item_id != $i->item_id)
                        {{---
                        <p style="color: rgb(0, 0, 0)"> <strong>item 1.1</strong> {{$iii}}</p>

                            <p>{{$iii->category_id}} = {{$category_target}}</p>
                                    <p>category: {{$category}} ; item cat ID = {{$iii->category_id}} ; category id's {{$ii->category_id_1}} and {{$ii->category_id_2}}</p>

                        --}}
                        
                        @if ($ii->parameter_id_1 ==  $iii->parameter_id || $ii->parameter_id_2 ==  $iii->parameter_id)
                            @if($iii->category_id != $category 
                            && $iii->category_id == $ii->category_id_1  
                            || $iii->category_id == $ii->category_id_2  
                            )
                                @if ($category != $iii->category_id &&  ($category == $ii->category_id_1 || $category == $ii->category_id_2) )


                                <P>{{--$iii--}}</P>
                                @if ($value == $iii->value_id  )
                                    <strong style="color: green">
                                        Compatable With 
                                        <a href="view/{{$iii->item_id}}">
                                            <span style="color: rgb(18, 95, 18)">
                                                {{$iii->item_name}}

                                            </span>
                                        </a>    
                                        {{$iii->category_name}}

                                        
                                    </strong>
                                @else
                                    <strong style="color: red">Not Compatable With 
                                        <a href="view/{{$iii->item_id}}">
                                            <span style="color: rgb(196, 40, 40)">
                                                {{$iii->item_name}}
                                                {{$iii->category_name}}

                                            </span>
                                        </a>
                                        Try Looking For
                                        <a href="category/{{$iii->category_id}}?fa[]={{$iii->parameter_id}}:{{$value}}">
                                            {{$value_name}}
                                            {{$iii->category_name}}
                                        </a>
                                            
                                    
                                    </strong>


                                @endif

                                @endif


                            @endif
                        @endif
                    @endif
                @endforeach 

                {{-- 
                @foreach ($data_specifications as $iii)
                    @if ($value && $iii->item_id == $i->item_id)
                        @if($ii->category != $iii->category_id)
                            @if ($ii->parameter_id_1 ==  $iii->parameter_id || $ii->parameter_id_2 ==  $iii->parameter_id)
                            <p style="color: rgb(0, 0, 0)"> <strong>item 2</strong> {{$iii}}</p>
                            <p style="color: red">HERE ^^^</p>
                                @if ($iii->value_id==$value)
                                    <p style="color: green"> comp</p>
                                @endif
                            @endif                                            
                        @endif

                    @endif
                @endforeach
                --}}
            @endforeach
        </div>
        
        {{-- end --}}

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
<p class="text_align_center font_120"> <strong>Your cart is empty.</strong></p>

</div>
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
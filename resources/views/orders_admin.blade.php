@extends ('layouts.default_body')
@section('content')

<script type="text/javascript" src="{{ asset('js/.js') }}"></script>

<div class="default_container_margin">
<div class="container">


<div class= "row no_margin primary_background_color default_padding default_margin default_radius under_shadow default_large_margin_bottom">
    @foreach ($unique_groups as $order_group)
        <div class="col-12 default_padding secondary_background_color default_margin small_padding_top_bottom default_radius">
            <div class="row no_margin default_padding default_margin"> 
                <div class="col-md-9 default_padding  " >
                <a class="no_ancor_decoration " href="order/{{$order_group}}">
                <p class="large_padding_left font_110">



                    <span>
                        <svg class="small_svg" viewBox="0 0 512 512">
                            <title>{{translate("group")}}</title>
                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="icon" fill="#000000" transform="translate(64.000000, 64.000000)">
                                    <path d="M106.666667,1.42108547e-14 L106.666667,42.6666667 L42.6666667,42.6666667 L42.6666667,341.333333 L106.666667,341.333333 L106.666667,384 L1.42108547e-14,384 L1.42108547e-14,1.42108547e-14 L106.666667,1.42108547e-14 Z M384,1.42108547e-14 L384,384 L277.333333,384 L277.333333,341.333333 L341.333333,341.333333 L341.333333,42.6666667 L277.333333,42.6666667 L277.333333,1.42108547e-14 L384,1.42108547e-14 Z M298.666667,256 L298.666667,298.666667 L85.3333333,298.666667 L85.3333333,256 L298.666667,256 Z M298.666667,170.666667 L298.666667,213.333333 L85.3333333,213.333333 L85.3333333,170.666667 L298.666667,170.666667 Z M298.666667,85.3333333 L298.666667,128 L85.3333333,128 L85.3333333,85.3333333 L298.666667,85.3333333 Z" id="Combined-Shape">
                        
                        </path>
                        </svg>
                    </span>

                    {{translate("Order Group:")}}
                    <strong>{{$order_group}}</strong>
                    <span class="large_padding_left">
                    @php $order_status=0 @endphp
                    @foreach ($data_orders as $order)
                        @if ($order->group == $order_group)
                        @php
                            $order_status = $order->status;
                        @endphp
                        @endif
                    @endforeach

                    <svg class="small_svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">

                        <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                        
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                        
                        <g id="SVGRepo_iconCarrier"> <path d="M20 12C20 16.4183 16.4183 20 12 20C7.58172 20 4 16.4183 4 12C4 7.58172 7.58172 4 12 4C16.4183 4 20 7.58172 20 12Z" stroke="#000000" stroke-width="2"/> <path d="M12 8L12 12.5" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> <path d="M13 15.5C13 16.0523 12.5523 16.5 12 16.5C11.4477 16.5 11 16.0523 11 15.5C11 14.9477 11.4477 14.5 12 14.5C12.5523 14.5 13 14.9477 13 15.5Z" fill="#000000"/> </g>
                        
                    </svg>

                    @if ($order_status == "1")
                    {{translate("Awaiting Payment")}}
                    @endif
                    @if ($order_status == "2")
                    {{translate("Payment Received Delivery In Progress")}}
                    @endif
                    @if ($order_status == "3")
                    {{translate("Order Is Out For Delivery")}}
                    @endif
                    @if ($order_status == "4")
                    {{translate("Order Delivered")}}
                    @endif


                    </span>
                </p> 
                @php
                    $address=null;
                    $total=0;
                @endphp
                @foreach ($data_orders as $order)
                    @if ($order->group == $order_group)

                    <a class="no_ancor_decoration" href="view/{{$order->item_id}}">
                    <div class="orders_item_list   no_padding">
                        <div class="orders_item_base  default_radius">
                            @php
                            $imageFound = false; 
                            @endphp
                            @foreach ($data_images as $img)
                                @if ($img->item_id == $order->item_id)
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
                            <p>x {{$order->quantity}}</p>
                            @php $total=$total+ $order->quantity* $order->price @endphp
                        </div>
                    </div>
                    </a>
        
                    @endif
                @endforeach
                </a>
                </div>
                <div class="col-md-3 default_padding  " >
                    
                    <div class="d-flex flex-column justify-content-end align-items-end full_height" >
                        <p class="default_padding mb-2">
                            {{translate("Total:")}} <strong>{{ $total }} €</strong>
                        </p>
                        <a class="no_ancor_decoration" href="order/{{ $order_group }}">
                            <button type="button" class="btn btn-success default_margin">
                                <strong>{{translate("Review Order")}}</strong>
                            </button>
                        </a>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    @endforeach
</div>



</div>
</div>


@endsection
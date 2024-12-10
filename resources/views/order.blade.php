@extends ('layouts.default_body')
@section('content')

<script type="text/javascript" src="{{ asset('js/rule_view_JS.js') }}"></script>

<div class="default_container_margin">
<div class="container">
<div class= "row no_margin primary_background_color default_padding default_margin default_radius under_shadow default_large_margin_bottom">
    <p class="d-flex justify-content-between align-items-center">
        <a href="/orders">
            <button type="button" class="default_margin btn btn-secondary">
                <strong>Back</strong>
            </button>
        </a>
        <strong class="mx-auto">Order information</strong>
        

    </p>
    
    <div class="row">
        <hr>
    </div>
    <div class="col-md-6">
        

        <p class="text-center default_margin default_padding"><strong>Items </strong></p>

        @foreach ($orders as $order) 
            <div class="secondary_background_color default_margin default_radius">
            <div class="row">

                <div class="col-3">
                    <div class="default_padding">
                    @php $imageFound = false; @endphp
                    <a href="/view/{{$order->item_id}}">
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
                    </a>
                    </div>
                </div>
                <div class="col-9">
                    <div class="default_padding">

                    <p>
                        @foreach ($data_items as $item)
                            @if ($item->id == $order->item_id)
                            {{$item->name}}
                            @endif
                        @endforeach
                    </p>
                    <p>
                        
                    <p>Price: {{$order->quantity}} x {{ number_format($order->price, 2) }}€</p>
                    </p>
                    </div>
                </div>
            </div>
            </div>
        @endforeach
        @php $total= 0; @endphp
        @foreach ($orders as $order) 
        @php $total = $total + ($order->quantity* $order->price)@endphp
        @endforeach
        <p class="text-end secondary_background_color default_padding default_margin default_radius"><strong>Total: {{$total}} €</strong></p>
    </div>
    <div class="col-md-6">
        <p class="text-center default_margin default_padding"><strong>Reciever </strong></p>
        <div class="default_padding secondary_background_color default_radius"> 
        <p>First Name: {{$orderSingle->name}}</p>
        <p>Last Name: {{$orderSingle->lastname}}</p>
        <p>Phone Number: {{$orderSingle->contact_phone}}</p>
        <p>Email: {{$orderSingle->contact_email}}</p>
        </div>
        <p class="text-center default_margin default_padding"><strong>Delivery Details </strong></p>
        <div class="default_padding secondary_background_color default_radius"> 

        <p>Country : 
            @if ($orderSingle->deliver_country == "+370")
            Lithuania
            @endif
            @if ($orderSingle->deliver_country == "+371")
            Latvia
            @endif
            @if ($orderSingle->deliver_country == "+372")
            Estonia
            @endif
            @if ($orderSingle->deliver_country == "+48")
            Poland
            @endif
        </p>
        <p>Postal Code: {{$orderSingle->deliver_postcode}}</p>
        <p>City: {{$orderSingle->deliver_city}}</p>
        <p>Delivery Address: {{$orderSingle->deliver_address}}</p>
        </div>


        <p class="text-center default_margin default_padding"><strong>Status </strong></p>
        <div class="default_padding secondary_background_color default_radius"> 

        @if ($orderSingle->status == "1")
            <p> <strong>Order Reciever Awaiting Payment For The Total</strong> </p>
            
            <div class="text-end">
                <button type="button" class="btn btn-warning text-end"> <strong>Proceed To Payment</strong></button>
            </div>
        @endif
        @if ($orderSingle->status == "2")
        <p>Payment Reciever Delivery In Progress</p>
        @endif
        @if ($orderSingle->status == "3")
        <p>Order Is Out For Delivery</p>
        @endif
        @if ($orderSingle->status == "4")
        <p>Order Delivered</p>
        @endif
        </div>
        <br>
    </div>



</div>
</div>
</div>


@endsection
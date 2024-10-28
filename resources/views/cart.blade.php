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
            <div class="col-md-3 default_large_margin_bottom">
                <div class="primary_background_color default_padding default_margin default_radius under_shadow">
                    <p ><strong class="remain_center">You Might Also Like</strong>  </p>
                    <div class="full_width_image secondary_background_color default_padding default_margin default_radius ">

                        
                    </div>
                </div>
            </div>

            <div class="col-md-9">

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
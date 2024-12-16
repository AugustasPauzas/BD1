


@extends ('layouts.default_body')
@section('content')
<script type="text/javascript" src="{{ asset('js/category_JS.js') }}"></script>

<div class="default_container_margin">

    <div class="container">
        <div class="row">
    
            @php
            $minPrice = $data_item_all_category->min('price');
            $maxPrice = $data_item_all_category->max('price');
            
            try {
                $set_minPrice = request()->query('minPrice');
                if (is_null($set_minPrice)) {
                    $set_minPrice =$minPrice;
                }
            } catch (\Exception $e) {
                $set_minPrice = $minPrice; // Set to $minPrice if an error occurs
            }
            
            try {
                $set_maxPrice = request()->query('maxPrice');
                
                // Check if set_maxPrice is null, if so, set it to $maxPrice
                if (is_null($set_maxPrice)) {
                    $set_maxPrice = $maxPrice;
                }
            } catch (\Exception $e) {
                $set_maxPrice = $maxPrice; // Set to $maxPrice if an error occurs
            }
            /*
            @if(is_array($filter_array) && count($filter_array) > 0)
                @foreach ($filter_array as $iii)
                    <p>Parameter ID: {{$iii['parameter_id']}}</p>
                    <p>Value ID: {{$iii['value_id']}}</p>
                @endforeach
            @endif
            */
    
            @endphp
            {{--  
            <div class="col-12">
                <div class="default_padding default_margin ">

                    <div class="flex-container ">

                        <div class="default_radius primary_background_color  default_padding default_margin_sides under_shadow transform_105">
                            <p class="no_margin_bottom">               
                            @php
                            try {
                                echo $category;
                            } catch (\Exception $e) {
                                echo 'Category: ';  
                            }
                            @endphp
            
                            @php
                            try {
                                echo $specified_category_id_or_name  ;
                            } catch (\Exception $e) {
                                $specified_category_id_or_name = "all_items";
                            }
                            @endphp
                            </p>  
                        </div>

                        @if (request()->query('minPrice'))
                        <div class="default_radius primary_background_color  default_padding default_margin_sides under_shadow transform_105">
                            <p class="no_margin_bottom">Minimum Price: {{ request()->query('minPrice') }}</p>      
                        </div>
                        @endif
                        @if (request()->query('maxPrice'))
                        <div class="default_radius primary_background_color  default_padding default_margin_sides under_shadow transform_105">
                            <p class="no_margin_bottom">Maximum Price: {{ request()->query('maxPrice') }}</p>      
                        </div>
                        @endif
                        @if (request()->query('src'))
                        <div class="default_radius primary_background_color  default_padding default_margin_sides under_shadow transform_105">
                            <p class="no_margin_bottom">Search Term: {{ request()->query('src') }}</p>      
                        </div>
                        @endif






                    </div>
                    


                </div>
            </div>
            --}}
        </div>
        <div class="row">
        </div>
    </div>
    
    <div class="container">
        <div class="row  ">

            <div class="col-lg-2 ">
                <div class="primary_background_color default_padding default_large_margin default_radius under_shadow">
                    <p ><strong class="remain_center"></strong>  </p>
                    
                        <!-- Price Filter -->
                        <div class=" ">
                        <div class="parameter-item parameter-item-price-only">
                            <p><strong>Price Range</strong></p>
                            <div id="category_price_filter_slider" 
                                 data-min-price="{{ $minPrice }}" 
                                 data-max-price="{{ $maxPrice }}" 
                                 data-set-min-price="{{ $set_minPrice }}" 
                                 data-set-max-price="{{ $set_maxPrice }}" 
                                 class="range-slider large_margin_sides"></div>
                                 <div class="default_padding ">
                                    <div class="d-flex justify-content-between ">
                                        <span id="category_price_filter_minPriceValue">{{ $minPrice }}</span>
                                        <span id="category_price_filter_maxPriceValue">{{ $maxPrice }}</span>
                                    </div>                                
                                 </div>
                            <input type="hidden" id="category_identifier" value="{{ $specified_category_id_or_name }}">
                                <div class="d-flex">
                                    <a id="apply_filter" href="#" class="btn btn-outline-primary flex-fill">Apply</a>
                                </div>
                            </div>
                        <br>
                        <div class="screen_max_height_100_category_spec parameter-container">
                        
                        <!--  Parameter Filters-->
                        @php
                        $displayedParameters = []; 
                        @endphp
                        

                        @foreach ($item_filter_parameters as $i)
                            @if (!in_array($i->parameter_name, $displayedParameters))  
                                <div class="parameter-item">
                                    <p> <strong>{{$i->parameter_name}} </strong> </p>
                                    @php
                                    $displayedValues = []; 
                                    
                                    @endphp
                                    
                                    @foreach ($item_filter_parameters as $ii)
                                        @if ($i->parameter_name == $ii->parameter_name && !in_array($ii->value_name, $displayedValues))
                                            <div class="form-check">
                                                <input class="update_filter_button_url form-check-input" 
                                                    data-parameter-id="{{$i->parameter_id}}" 
                                                    data-value-id="{{$ii->value_id}}" 
                                                    type="checkbox" 
                                                    value="" 
                                                    @if(is_array($filter_array) && count($filter_array) > 0)
                                                        @foreach ($filter_array as $iii)
                                                            @if ($iii['parameter_id'] == $i->parameter_id && $iii['value_id'] == $ii->value_id)
                                                                checked
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    id="filter_{{$ii->value_id}}"
                                                    onchange="updateFilterUrl()">
                                                <label class="form-check-label" for="filter_{{$ii->value_id}}">
                                                    {{$ii->value_name}} 
                                                </label>
                                            </div>
                                    
                                            @php
                                                $displayedValues[] = $ii->value_name; 
                                            @endphp
                                        @endif
                                    @endforeach
                                </div>
                                @php
                                    $displayedParameters[] = $i->parameter_name; 
                                @endphp
                            @endif
                        @endforeach


                        </div>  
                    </div>
                </div>
            </div>
    
    
    
            <div class="col-lg-10  ">

                <div class="item_parent_container primary_background_color default_padding default_large_margin default_radius under_shadow">
                    
                    @if (true)


                    <div class="d-flex">
                        <div class="ms-auto">
                            <div class="row">
                                <div class="col">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle " type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            {{ request()->query('order') == 'AlphAcen' ? 'Alphabeticly A-Z.' : '' }}
                                            {{ request()->query('order') == 'AlphDesc' ? 'Alphabeticly Z-A' : '' }}
                                            {{ request()->query('order') == 'PriAcen' ? 'Price Acen.' : '' }}
                                            {{ request()->query('order') == 'PriDesc' ? 'Price Desc.' : '' }}
                                            {{ request()->query('order') == '' ? 'Alphabeticly A-Z' : '' }}
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['order' => 'AlphAcen']) }}">Alphabeticly A-Z</a></li>
                                            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['order' => 'AlphDesc']) }}">Alphabeticly Z-A</a></li>
                                            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['order' => 'PriAcen']) }}">Price Acen.</a></li>
                                            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['order' => 'PriDesc']) }}">Price Desc.</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle " type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            {{ request()->query('Icount') == '8' ? '8' : '' }}
                                            {{ request()->query('Icount') == '12' ? '12' : '' }}
                                            {{ request()->query('Icount') == '24' ? '24' : '' }}
                                            {{ request()->query('Icount') == '48' ? '48' : '' }}
                                            {{ request()->query('Icount') == '' ? '12' : '' }}
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['Icount' => '8']) }}">8</a></li>
                                            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['Icount' => '12']) }}">12</a></li>
                                            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['Icount' => '24']) }}">24</a></li>
                                            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['Icount' => '48']) }}">48</a></li>
                                        </ul>
                                    </div>
                                    
                                </div>
                            </div>

                           
                        </div>
                    </div>
                    
                    
                    @endif
                    


                    <div id="itemsContainer">
                    @php
                    $oneItemFound = false;
                    @endphp
                    @foreach ($data_item as $i)

                    <a class="no_ancor_decoration" href="/view/{{$i->id}}">
                        <div class="default_radius under_shadow item_list grey_border item_list_margin" data-price="{{ $i->price }}" >
                            <div class="image_svg_wrapper">

                                <div class="image_with_status_container">

                                @php $imageFound=false; @endphp
                                @foreach ($data_image as $img)
                                    @php 
                                    $imageFound=false;
                                    @endphp
                                    @if($i->id== $img->item_id && !$imageFound)
                                        <img id="replace_image_item_view square_image" class="default_radius full_width_image square_image tertiary_background_color " src="{{ asset($img->image_location) }}"   onerror="this.onerror=null; this.src='{{ url('/images/missingPicture.png') }}';"  alt="aaaaaa." >
                                        @php 
                                        $imageFound=true;
                                        @endphp
                                        @break
                                    @endif 
                                @endforeach  
                                @if (!$imageFound)
                                <img id="replace_image_item_view" class="default_radius full_width_image image_cover" src=""   onerror="this.onerror=null; this.src='{{ url('/images/missingPicture.png') }}';"  alt="." >
                                @endif
                                @if ($i->status==1)
                                <p class="status_text default_margin default_radius">Not Public</p>
                                @endif
                                </div>


                                @php
                                $oneItemFound = true;
                                @endphp
    
                                <a id="like_the_item" class="" href="{{ route('add.like', ['item_id' => $i->id]) }}" data-item-id="{{$i->id}}">
                                    <div class="heart_div default_radius">
                                        <svg id="liked_item_svg" 
                                        class=" heart_svg extra_small_svg 
                                        @foreach ($data_like as $like) @if($i->id == $like->item_id) liked_item_svg @endif @endforeach"
                                        viewBox="-0.96 -0.96 17.92 17.92" fill="none" 
                                        xmlns="http://www.w3.org/2000/svg" stroke="#000000">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path d="M1.24264 8.24264L8 15L14.7574 8.24264C15.553 7.44699 16 6.36786 16 5.24264V5.05234C16 2.8143 14.1857 1 11.9477 1C10.7166 1 9.55233 1.55959 8.78331 2.52086L8 3.5L7.21669 2.52086C6.44767 1.55959 5.28338 1 4.05234 1C1.8143 1 0 2.8143 0 5.05234V5.24264C0 6.36786 0.44699 7.44699 1.24264 8.24264Z"/>
                                            </g>
                                        </svg>
                                    </div>
                                </a>
                            </div>

                            <p class="one_line_clamp default_padding small_margin"><strong>{{$i->name}}</strong></p>
                            <p ><strong class="remain_center small_margin price_p">{{ number_format($i->price, 2) }}<span class="Price_small_p"></span> €</strong>    </p>
  
                            <a class="no_ancor_decoration" href="/add/item/cart/{{$i->id}}">
                            <div class="radius_bottom_5_px cart_button">
                                <strong>Add To <img class="extra_small_svg" src="{{ asset('svg/cart-shopping-svgrepo-com.svg') }}" alt=""></strong> 
                            </div>    
                            </a>
    
                        </div>                    
                    </a>
                    @endforeach

                    @if ($oneItemFound)
                    <nav>
                        <ul class="pagination justify-content-center extra_big_padding_top">

                            <li class="page-item {{ request()->query('page', 1) == 0 ? 'active' : '' }}">
                                <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => 1]) }}">
                                    <
                                </a>
                            </li>

                            @for ($countPage = 1; $countPage <= $max_page; $countPage++)
                                <li class="page-item {{ request()->query('page', 1) == $countPage ? 'active' : '' }}">
                                    <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $countPage]) }}">
                                        {{ $countPage }}
                                    </a>
                                </li>
                            @endfor
                            <li class="page-item {{ request()->query('page', 1) == 0 ? 'active' : '' }}">
                                <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $countPage-1]) }}">
                                    >
                                </a>
                            </li>
                        </ul>
                    </nav>
                    @endif
                    
                


                    @if (!$oneItemFound)
                    <br>
                    <p class="text_align_center">
                        <svg class="extra_extra_large_svg grey_svg_stroke" viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="10" stroke="#33363F" stroke-width="2" stroke-linecap="round"/>
                            <path d="M7.88124 16.2441C8.37391 15.8174 9.02309 15.5091 9.72265 15.3072C10.4301 15.103 11.2142 15 12 15C12.7858 15 13.5699 15.103 14.2774 15.3072C14.9769 15.5091 15.6261 15.8174 16.1188 16.2441" stroke="#33363F" stroke-width="2" stroke-linecap="round"/>
                            <circle cx="9" cy="10" r="1.25" fill="#33363F" stroke="#33363F" stroke-width="0.5" stroke-linecap="round"/>
                            <circle cx="15" cy="10" r="1.25" fill="#33363F" stroke="#33363F" stroke-width="0.5" stroke-linecap="round"/>
                        </svg>                     
                    </p>        

                    <p class="text_align_center font_120"> <strong>No Items Found </strong></p>
                    <br>
                    @endif
                    </div>
                    <div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
</div>
@endsection

@extends ('layouts.default_body')
@section('content')


<script type="text/javascript" src="{{ asset('js/view_JS.js') }}"></script>


<div class="default_container_margin">
    <div class="container primary_background_color default_padding default_margin default_radius under_shadow">

        <div class="row no_sides_margin">
            <div class="col-8">
                <p>Item ID: {{$data_item->id}}</p>
            </div>
            <div class="col-4">
    
                <div class="text-end">
                    <a href="/update/view/{{$data_item->id}}">
                        <button type="button" class="btn btn-primary btn">
                            <svg class="extra_small_svg edit_svg_color" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" >
    
                                <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                <g id="SVGRepo_iconCarrier"> <path d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </g>
                                
                                </svg>
                            Update
                        </button>                      
                    </a>
    
                </div>
                
            </div>
    
        </div>
    </div>
    <br>
    
    
    <div class="container">
    <p class="no_margin_bottom font_85 secondary_text"> <a class='no_ancor_decoration' href="{{ url('/') }}">Home</a> | 
        <a class='no_ancor_decoration' href="{{ url('/category/all_items') }}">Category</a> |
        <a class='no_ancor_decoration' href="{{ url('/category/'.$data_item->category_id.'') }}">{{$data_category->firstWhere('id', $data_item->category_id)->category}}
        </a> |
        <a class='no_ancor_decoration' href="{{ url('/view/'.$data_item->id.'') }}">{{$data_item->name}}</a></p>
    </div>
    
    <div class="container no_padding ">
        <div class="row no_margin_sides ">
            <div  class=" col-xl-10 other_item no_padding default_large_margin_bottom">
                <div class="default_padding default_margin default_margin_sides primary_background_color default_margin default_radius under_shadow">
                    <div class="row no_margin_sides">
                        <div id="sourceDiv" class="col-md-6">
                            <div  class=" image_svg_wrapper default_margin">
                                @if($data_image->isNotEmpty())
                                <div class="image-container big_square_image">
                                    <img id="replace_image_item_view" class="default_radius full_width_image big_square_image tertiary_background_color grey_border" src="{{ asset($data_image->first()->image_location) }}"   onerror="this.onerror=null; this.src='{{ url('/images/missingPicture.png') }}';"  alt="aaaaaa." >
                                </div>
                                @else
                                <div class="image-container">
                                    <img id="replace_image_item_view" class="default_radius full_width_image image_cover" src=""   onerror="this.onerror=null; this.src='{{ url('/images/missingPicture.png') }}';"  alt="." >
                                </div>
                                @endif
                            </div>
                            <div class="row ">
                                <div class="col-12 ">
                                    <div class="tertiary_background_color default_margin default_padding">
                                        <div  class="same_line_container custom-scroll default_padding" id="imageContainer">
                                            @foreach($data_image as $image)
                                            <div class="same_line_item small_pading_left_right  default_margin ">
                                                <img id="click_too_replace_main" class=" square_image default_radius full_width_image  transform_105 image_cover" src="/{{ $image->image_location }}"  onerror="this.onerror=null; this.src='{{ url('/images/missingPicture.png') }}';" alt="">
                                            </div>                                
                                            @endforeach
                                        </div>
                                        <button class="scroll_button left" onclick="view_item_image_menu_scroll_left()">←</button>
                                        <button class="scroll_button right" onclick="view_item_image_menu_scroll_right()">→</button>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <p class="no_margin_bottom font_110 extra_big_padding_top"><strong>{{$data_item->name}}    </strong></p> 
                            <p class="font_75 secondary_text">IEN Code: {{$data_item->ien_code}} </p>
                            <p class="no_margin_bottom" >About the {{$data_category->firstWhere('id', $data_item->category_id)->category}}:</p>
                            <p>{{$data_item->description}} </p>
                            <div class="row">
                                <div class="col-lg-6 default_margin">
                                    <p><svg class="extra_small_svg delivery_svg_color" version="1.1"  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                                        viewBox="0 0 512 512"  xml:space="preserve">
    
                                   <g>
                                       <path class="st0" d="M116.683,354.34c-26.836,0-48.607,21.764-48.607,48.6c0,26.85,21.771,48.614,48.607,48.614
                                           c26.844,0,48.608-21.764,48.608-48.614C165.29,376.104,143.526,354.34,116.683,354.34z M116.683,424.826
                                           c-12.08,0-21.872-9.799-21.872-21.886c0-12.073,9.792-21.865,21.872-21.865c12.08,0,21.872,9.792,21.872,21.865
                                           C138.554,415.027,128.762,424.826,116.683,424.826z"/>
                                       <path class="st0" d="M403.8,354.34c-26.836,0-48.6,21.764-48.6,48.6c0,26.85,21.764,48.614,48.6,48.614
                                           c26.843,0,48.606-21.764,48.606-48.614C452.406,376.104,430.643,354.34,403.8,354.34z M403.8,424.826
                                           c-12.073,0-21.865-9.799-21.865-21.886c0-12.073,9.792-21.865,21.865-21.865c12.079,0,21.871,9.792,21.871,21.865
                                           C425.671,415.027,415.879,424.826,403.8,424.826z"/>
                                       <path class="st0" d="M200.127,128.622H90.502c-3.561,0-6.957,1.582-9.23,4.331l-78.48,94.163C0.986,229.268,0,231.994,0,234.815
                                           v82.595v43.189c0,6.648,5.389,12.029,12.03,12.029h36.844c11.626-25.9,37.621-44.024,67.81-44.024
                                           c30.196,0,56.183,18.124,67.81,44.024h27.671V140.652C212.163,134.003,206.767,128.622,200.127,128.622z M43.931,236.052
                                           c0-2.849,0.978-5.612,2.777-7.82l50.103-61.694c2.36-2.907,5.9-4.59,9.633-4.59h49.083c6.848,0,12.404,5.554,12.404,12.411v70.011
                                           c0,6.849-5.555,12.404-12.404,12.404H56.334c-6.85,0-12.404-5.554-12.404-12.404V236.052z"/>
                                       <path class="st0" d="M243.532,338.792c-3.741,0-6.763,3.03-6.763,6.77v20.303c0,3.735,3.022,6.763,6.763,6.763h92.466
                                           c6.382-14.209,17.072-26.023,30.419-33.836H243.532z"/>
                                       <path class="st0" d="M504.381,338.792h-63.19c13.353,7.814,24.044,19.627,30.419,33.836h32.772c3.741,0,6.77-3.028,6.77-6.763
                                           v-20.303C511.151,341.822,508.122,338.792,504.381,338.792z"/>
                                       <path class="st0" d="M497.568,60.446H252.043c-7.964,0-14.425,6.46-14.425,14.432v226.703c0,7.972,6.461,14.432,14.425,14.432
                                           h245.525c7.971,0,14.432-6.46,14.432-14.432V74.878C512,66.906,505.539,60.446,497.568,60.446z M458.27,134.09H291.355
                                           c-3.741,0-6.771-3.036-6.771-6.763v-13.533c0-3.741,3.03-6.77,6.771-6.77H458.27c3.735,0,6.763,3.029,6.763,6.77v13.533
                                           C465.033,131.054,462.005,134.09,458.27,134.09z M291.355,174.697H458.27c3.735,0,6.763,3.021,6.763,6.763V195
                                           c0,3.727-3.028,6.763-6.763,6.763H291.355c-3.741,0-6.771-3.036-6.771-6.763v-13.54
                                           C284.584,177.718,287.614,174.697,291.355,174.697z M291.355,242.369H458.27c3.735,0,6.763,3.022,6.763,6.763v13.533
                                           c0,3.727-3.028,6.77-6.763,6.77H291.355c-3.741,0-6.771-3.044-6.771-6.77v-13.533C284.584,245.391,287.614,242.369,291.355,242.369
                                           z"/>
                                   </g>
                                   </svg>
                                        Delivery By <strong>{{ \Carbon\Carbon::now()->addDays(7)->format('m/d')}}</strong> 
                                    </p>
                                </div>
                                <div class="col-lg-6 default_margin">
                                  <p> 
                                    <svg class="extra_small_svg stock_svg_color" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7 21V11.6C7 11.0399 7 10.7599 7.10899 10.546C7.20487 10.3578 7.35785 10.2048 7.54601 10.109C7.75992 9.99996 8.03995 9.99996 8.6 9.99996H15.4C15.9601 9.99996 16.2401 9.99996 16.454 10.109C16.6422 10.2048 16.7951 10.3578 16.891 10.546C17 10.7599 17 11.0399 17 11.6V21M10 14H14M10 18H14M3 10.4881V19.4C3 19.96 3 20.24 3.10899 20.454C3.20487 20.6421 3.35785 20.7951 3.54601 20.891C3.75992 21 4.03995 21 4.6 21H19.4C19.9601 21 20.2401 21 20.454 20.891C20.6422 20.7951 20.7951 20.6421 20.891 20.454C21 20.24 21 19.96 21 19.4V10.4881C21 9.41436 21 8.87747 20.8368 8.40316C20.6925 7.98371 20.457 7.60148 20.1472 7.28399C19.797 6.92498 19.3174 6.68357 18.3583 6.20075L14.1583 4.08645C13.3671 3.68819 12.9716 3.48905 12.5564 3.41069C12.1887 3.34129 11.8113 3.34129 11.4436 3.41069C11.0284 3.48905 10.6329 3.68818 9.84171 4.08645L5.64171 6.20075C4.6826 6.68357 4.20304 6.92498 3.85275 7.28399C3.54298 7.60148 3.30746 7.98371 3.16317 8.40316C3 8.87747 3 9.41437 3 10.4881Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    
                                    <span class="{{ $data_item->quantity >= 1 ? ($data_item->quantity <= 3 ? 'low_stock' : 'in_stock') : 'out_of_stock' }}
                                    font_110"> <strong>{{ $data_item->quantity >= 1 ? ($data_item->quantity <= 3 ? 'Low Stock' : 'In Stock') : 'Out Of Stock' }} </span><span class="font_110">{{$data_item->quantity}}</span></strong><span class="font_75 secondary_text"> /pcs</span> </p> 
                                </div>
                            </div>
    
                            <div class="row ">
                                <div class="col-lg-6 default_margin">
                                    <p><strong>Price</strong>  <span class="price_p"><strong>{{$data_item->price}} €</strong></span> <span class="font_75 secondary_text">/pcs</span> </p>
    
                                    
    
                                </div>
                                <div class="col-lg-6 default_margin">
                                    <form action="{{ url('add_item_too_cart/' . $data_item->id) }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <div class="input-group ">
                                                <div class="input-group-prepend">
                                                    <button type="button" class="btn btn-outline-secondary" id="view_item_add_quantity_decreaseButton">-</button>
                                                </div>
                                                <input type="number" class="form-control" id="view_item_add_quantity" name="view_item_add_quantity" min="1" max="{{$data_item->quantity}}" value="{{ $data_item->quantity >= 1 ? '1' : '0' }}" readonly>
    
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-outline-secondary" id="view_item_add_quantity_increaseButton">+</button>
                                                </div>
                                            </div>
                                        </div>
                                    
                                    

                                    
                                </div>
                                
                            </div>
    
                            <div class="row no_margin_sides">
    
                                <button type="submit" class="btn btn-success btn large_padding ">
                                    
                                    <strong>Add To Cart </strong>
    
                                    <svg class="small_svg view_item_cart_svg_color" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" >
                                        <g id="SVGRepo_bgCarrier" />
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                        <g id="SVGRepo_iconCarrier">
                                          <path d="M6.29977 5H21L19 12H7.37671M20 16H8L6 3H3M9 20C9 20.5523 8.55228 21 8 21C7.44772 21 7 20.5523 7 20C7 19.4477 7.44772 19 8 19C8.55228 19 9 19.4477 9 20ZM20 20C20 20.5523 19.5523 21 19 21C18.4477 21 18 20.5523 18 20C18 19.4477 18.4477 19 19 19C19.5523 19 20 19.4477 20 20Z" stroke-linecap="round" stroke-linejoin="round"/>
                                        </g>
                                    </svg>
    
                                </button>  
                                </form>
       
    
                            </div>
                        </div>                    
                    </div>
     
    
                </div>
            </div>
            <div  class="col-xl-2 no_padding full_height default_large_margin_bottom">
                <div class="row no_margin_sides ">
                    <div class="col  default_padding  default_margin default_margin_sides primary_background_color default_margin default_radius under_shadow">
                        <div id="targetDiv" class="recomended_item_container custom-scroll">
                            @foreach ($data_all_item as $i)
                            <div class="recomended_item_item">
                                <a class="no_ancor_decoration" href="/view/{{$i->id}}">
                                    <div class="default_radius   grey_border ">
                                        
                                        <div class="image_svg_wrapper ">
                                            @php 
                                            $imageFound=false;
                                            @endphp
                                            @foreach ($data_all_image as $img)
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
                
                                            <a href="add/like/item/{{$i->id}}">
                                                <div class="heart_div no_radius">
                                                    <svg class="heart_svg extra_small_svg" viewBox="-0.96 -0.96 17.92 17.92" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000">
                                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                        <g id="SVGRepo_iconCarrier">
                                                            <path d="M1.24264 8.24264L8 15L14.7574 8.24264C15.553 7.44699 16 6.36786 16 5.24264V5.05234C16 2.8143 14.1857 1 11.9477 1C10.7166 1 9.55233 1.55959 8.78331 2.52086L8 3.5L7.21669 2.52086C6.44767 1.55959 5.28338 1 4.05234 1C1.8143 1 0 2.8143 0 5.05234V5.24264C0 6.36786 0.44699 7.44699 1.24264 8.24264Z"/>
                                                        </g>
                                                    </svg>
                                                </div>
                                                
                                            </a>
                                            <a class="no_ancor_decoration" href="/view/{{$i->id}}">
                                            <div class="reccom_text_over_image ">
                                                <p class="one_line_clamp text-center no_padding no_margin_bottom"><strong>{{$i->name}}</strong></p>
                                                <p class="no_margin_bottom" ><strong class="text-center remain_center price_p no_padding ">{{$i->price}}<span class="Price_small_p"></span> €</strong>    </p>
                                            </div>                                            
                                            </a>
    
                                        </div>
    
                                        <a class="no_ancor_decoration text-center" href="/add/item/cart/{{$i->id}}">
                                        <div class="radius_bottom_5_px cart_button">
                                            <strong>Add To <img class="extra_small_svg" src="{{ url('/svg/cart-shopping-svgrepo-com.svg') }}" alt=""></strong> 
                                        </div>    
                                        </a>
                
                                    </div>                    
                                </a>
                            </div>
                            @endforeach
    
                            
                        </div>
    
                        <div></div>
    
                    </div>                  
                </div>
            </div>
        </div>
    </div>
    
    
    <div class="container no_padding">
        <div class="row no_margin_sides">
    
            <div class="col-md-6 no_padding default_large_margin_bottom">
            <div class="default_padding  default_margin default_margin_sides primary_background_color default_margin default_radius under_shadow">
                <p class="text-center"> <strong>Full Specification</strong></p> 
                <div class="row no_margin_sides no_padding">
                    <table class="table-striped table-hover default_margin  ">
                        <thead>
                            <tr >
                                <th scope="col">
                                    <p class="no_margin_bottom default_padding ">Parameter</p>
                                </th>
                                <th  scope="col w-50">
                                    <p class="no_margin_bottom default_padding ">Values</p>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            
                @php
                // Group the specifications by parameter_name
                $grouped_specifications = [];
                foreach ($data_specifications_table as $item) {
                    $grouped_specifications[$item->parameter_name][] = $item->value_name;
                }
                @endphp
                @foreach ($grouped_specifications as $parameter_name => $value_names)
                
    
    
    
                    <tr class="default_pading_left_right">
                        <td class="default_margin">
                            <p class="no_margin_bottom default_padding ">
                                {{ $parameter_name }}
                            </p>
                            
                            
                        </td>
                        <td>
                            <p class="no_margin_bottom default_padding ">
                            @foreach (array_unique($value_names) as $value_name)
                            
                                {{ $value_name }};
                            
                                
                            @endforeach
                            </p>
                        </td>
                    </tr>
    
    
                @endforeach
                            
                        </tbody>
                    </table>    
                </div>           
            </div>
            </div>
    
            <div class="col-md-6 no_padding">
            <div class="default_padding  default_margin default_margin_sides primary_background_color default_margin default_radius under_shadow">
                <p class="text-center"> <strong>Costumer Reviews</strong></p>  
                <p class="text-center"> 
                    <svg xmlns="http://www.w3.org/2000/svg" class="large_svg grey_svg" viewBox="0 0 24 24">

                        <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                        
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                        
                        <g id="SVGRepo_iconCarrier">
                        
                        <path d="M12 6c0-.55-.45-1-1-1H5.82l.66-3.18.02-.23c0-.31-.13-.59-.33-.8L5.38 0 .44 4.94C.17 5.21 0 5.59 0 6v6.5c0 .83.67 1.5 1.5 1.5h6.75c.62 0 1.15-.38 1.38-.91l2.26-5.29c.07-.17.11-.36.11-.55V6zm10.5 4h-6.75c-.62 0-1.15.38-1.38.91l-2.26 5.29c-.07.17-.11.36-.11.55V18c0 .55.45 1 1 1h5.18l-.66 3.18-.02.24c0 .31.13.59.33.8l.79.78 4.94-4.94c.27-.27.44-.65.44-1.06v-6.5c0-.83-.67-1.5-1.5-1.5z"/>
                        
                        </g>
                        
                        </svg>    
                        <p></p>
                </p>  
                <p class="text-center"> Be The first Too Review This item</p>  
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
                <p class="text_align_center font_120"> <strong>Under Constructiuon</strong></p>



                
    
                
            </div>
    
            </div>
        </div>
    
    </div>

</div>


@endsection
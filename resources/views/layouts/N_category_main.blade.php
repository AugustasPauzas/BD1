


<div class="container">



    <div class="row">
        <div class="col-12">
            <div class="primary_background_color default_padding default_margin default_radius under_shadow">
                <p>Category:
                @php
                try {
                    echo $category;
                } catch (\Exception $e) {
                    echo 'Category not found';  
                }
                @endphp
                </p>
            </div>
        </div>


    </div>
    <div class="row">
    </div>

    
</div>


<div class="container">



    <div class="row  ">
        <div class="col-lg-2 ">
            <div class="primary_background_color default_padding default_large_margin default_radius under_shadow">
                <p ><strong class="remain_center"></strong>  </p>
                <div class="parameter-container">
                    @foreach ($data_parameter as $i)
                    <div class="parameter-item">
                        <p> <strong>{{$i->parameter_name}}</strong>  </p>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">option 1 (0)</label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">option 2 (0)</label>
                            
                          </div>
                    </div>
                    @endforeach  
                </div>
            </div>
        </div>
        <div class="col-lg-10  ">
            <div class="item_parent_container primary_background_color default_padding default_large_margin default_radius under_shadow">
                
                @foreach ($data_item as $i)
                <a class="no_ancor_decoration" href="/view/{{$i->id}}">
                    <div class="default_radius under_shadow item_list grey_border item_list_margin">
                        
                        <div class="image_svg_wrapper">

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

                            <a href="add/like/item/{{$i->id}}">
                                <div class="heart_div default_radius">
                                    <svg class="heart_svg extra_small_svg" viewBox="-0.96 -0.96 17.92 17.92" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path d="M1.24264 8.24264L8 15L14.7574 8.24264C15.553 7.44699 16 6.36786 16 5.24264V5.05234C16 2.8143 14.1857 1 11.9477 1C10.7166 1 9.55233 1.55959 8.78331 2.52086L8 3.5L7.21669 2.52086C6.44767 1.55959 5.28338 1 4.05234 1C1.8143 1 0 2.8143 0 5.05234V5.24264C0 6.36786 0.44699 7.44699 1.24264 8.24264Z"/>
                                        </g>
                                    </svg>
                                </div>
                            </a>

                        </div>
                        
                        <p class="two_line_clamp"><strong>{{$i->name}}</strong></p>
                        <p ><strong class="remain_center price_p">{{$i->price}}<span class="Price_small_p"></span> €</strong>    </p>
                        <a class="no_ancor_decoration" href="/add/cart/item/{{$i->id}}">
                        <div class="radius_bottom_5_px cart_button">
                            <strong>Add To <img class="small_svg" src="svg/cart-shopping-svgrepo-com.svg" alt=""></strong> 
                        </div>    
                        </a>

                    </div>                    
                </a>
                @endforeach

                <div>
                
                </div>
            </div>

        </div>

    </div>

    
</div>
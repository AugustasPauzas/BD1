
<div class="container">
    <div class="row">
        <div class="col-md-3 ">
            <div class="primary_background_color default_padding default_margin default_radius under_shadow">
                <p ><strong class="remain_center">Compatibility</strong>  </p>
                <div class="full_width_image secondary_background_color default_padding default_margin default_radius ">
                    @if(true)         
                    <p class="text_align_center ">Incomptabilities Found!</p>
                    @else
                    <p class="text_align_center ">No Incomptaibilities Found!</p>     
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
                
                @for ($i = 1; $i <= 3; $i++)
                <div class="row no_margin_sides secondary_background_color cart_item_row default_radius">
                    <div class="col-lg-7">
                        <div class="row no_margin_sides">
                            <div class="col-3 no_padding_sides">
                                <div class="col_cart_img remain_center ">
                                    <img class=" full_width_image default_radius" src="images/missingPicture.png" alt="">
                                </div>
                            </div>
                            <div class="col-9 default_padding default_margin two_line_clamp">
                                item Name Here item Name Here  item Name  item Name Heritem Name HerHere item Name Here item Name Here item Name
                            </div>                            
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="row no_margin_sides">
                            <div class="col-6">
                                <div class="col_cart_img remain_center default_padding default_margin">
                                    - 1 +
                                </div>
                            </div>
                            <div class="col-4 default_padding default_margin ">
                                499.00€
                            </div>   
                            <div class="col-2 default_padding default_margin ">
                                <a href="cart/delete/item/23">
                                    <svg class="small_svg delete_button_svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10 12V17"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M14 12V17"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M4 7H20"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M6 10V18C6 19.6569 7.34315 21 9 21H15C16.6569 21 18 19.6569 18 18V10"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                            </div>                            
                        </div>
                    </div>
                </div>
                @endfor

                <div class="row no_margin_sides default_radius ">
                    <div class="col-lg-7"></div>
                    <div class="col-lg-5">
                        <p ><strong class="remain_center">Total: ***.** €</strong>  </p>
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
                


            </div>
        </div>
    </div>

</div>
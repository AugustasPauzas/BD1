@foreach($data_image as $image)
<div class="image-container update_add_images_item full_height" data-image-id="{{ $image->image_parse_id }}">
    <div class="image_svg_wrapper square_image">
        <div class="position_div  default_radius">
            #{{ $image->position }}
        </div>


        <a href="#" class="image_position_left default_radius no_border action_reload_b_pic" data-image-parse-id="{{ $image->image_parse_id }}" data-item-id="{{ $data_item->id }}">
            <svg class="small_svg" viewBox="0 0 24.00 24.00" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="0.144"/>
                <g id="SVGRepo_iconCarrier">
                    <path d="M5 12H19M5 12L11 6M5 12L11 18" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </g>
            </svg>
        </a>
        
        
        <a href="#" class="image_position_right default_radius no_border action_reload_b_pic"   data-image-parse-id="{{ $image->image_parse_id }}" data-item-id="{{ $data_item->id }}">
            <svg class="small_svg" viewBox="0 0 24.00 24.00" fill="none" xmlns="http://www.w3.org/2000/svg" transform="matrix(-1, 0, 0, 1, 0, 0)">
                <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="0.144"/>
                <g id="SVGRepo_iconCarrier"> 
                    <path d="M5 12H19M5 12L11 6M5 12L11 18" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> 
                </g>
            </svg>
        </a>
        
        <img class=" default_radius default_radius full_width_image transform_105 image_cover" src="/{{ $image->image_location }}" alt="Image">
        <a class="item_update_delete_button" data-item-id="{{ $data_item->first()->id }}" data-image-parse-id="{{ $image->image_parse_id }}">
            <div class="delete_div default_radius">
                <svg class="small_svg delete_button_svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 12V17" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M14 12V17" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M4 7H20" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M6 10V18C6 19.6569 7.34315 21 9 21H15C16.6569 21 18 19.6569 18 18V10" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        </a>
    </div>

</div>
@endforeach
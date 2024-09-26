@foreach($data_image as $image)
<div class="image-container update_add_images_item" data-image-id="{{ $image->image_parse_id }}">
    <div class="image_svg_wrapper square_image">
        <img class="default_radius full_width_image transform_105 image_cover" src="/{{ $image->image_location }}" alt="Image">
        <a href="/delete/item/image/{{ $data_item->id }}/{{$image->image_parse_id}}" class="item_update_delete_button" data-item-id="{{ $data_item->id }}" data-image-parse-id="{{ $image->image_parse_id }}">
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
    <p>Position: {{ $image->position }}</p>
</div>

@endforeach


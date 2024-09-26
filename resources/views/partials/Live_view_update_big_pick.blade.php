@if($data_image->isNotEmpty())
    <div class="image-container big_square_image">
        <img class="default_radius full_width_image big_square_image tertiary_background_color grey_border" 
             src="{{ asset($data_image->first()->image_location) }}" 
             onerror="this.onerror=null; this.src='{{ url('/images/missingPicture.png') }}';" 
             alt="Image">
    </div>
@else
    <div class="image-container">
        <img class="default_radius full_width_image image_cover" 
             src="" 
             onerror="this.onerror=null; this.src='{{ url('/images/missingPicture.png') }}';" 
             alt="Image">
    </div>
@endif

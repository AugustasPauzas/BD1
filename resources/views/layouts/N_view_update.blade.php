


<div class="container primary_background_color default_padding default_margin default_radius under_shadow">

    a
</div>

<br>


<div class="container primary_background_color default_padding default_margin default_radius under_shadow">
    <div class="row no_margin_sides">
        <div class="col-4 hidden_lg">
            <div class="image_svg_wrapper default_margin">
            
            
            @if($data_image->isNotEmpty())
            <div class="image-container big_square_image">
                <img class="default_radius full_width_image big_square_image tertiary_background_color grey_border" src="{{ asset($data_image->first()->image_location) }}"   onerror="this.onerror=null; this.src='{{ url('/images/missingPicture.png') }}';"  alt="aaaaaa." >
            </div>
            @else
            <div class="image-container">
                <img class="default_radius full_width_image image_cover" src=""   onerror="this.onerror=null; this.src='{{ url('/images/missingPicture.png') }}';"  alt="." >
            </div>
            @endif
        
            </div>
        </div>
        <div class="col-lg-8">
            @php $position_target=1 @endphp
            @foreach($data_image as $image)
            @php $position_target++ @endphp
            <div class="image-container update_add_images_item">


                <div class="image_svg_wrapper  square_image">
                    <img class="default_radius full_width_image  transform_105 image_cover" src="/{{ $image->image_location }}"  alt="Image">
                    <a href="{{ url('/delete/item/image/' . $image->image_parse_id) }}">
                        <div class="delete_div default_radius">
                            <svg class="small_svg delete_button_svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 12V17"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M14 12V17"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M4 7H20"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M6 10V18C6 19.6569 7.34315 21 9 21H15C16.6569 21 18 19.6569 18 18V10"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </a>

                </div>


                <p>Position: {{ $image->position }}</p>
            </div>
            @endforeach 

            <div class="row">


                <div class=" default_radius update_add_images_item_input secondary_background_color">
                
                    <form action="{{ url('add_new_image') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label for="item_id">Item ID</label>
                            <input type="text" name="item_id" id="item_id" value="{{$data_item->id}}" required>
                        </div>
                        
                        <div>
                            <label for="image">Upload Image</label>
                            <input type="file" name="image" id="image" required>
                        </div>
                    
                        <div>
                            <label for="position">Position</label>
                            <input class="" type="number" name="position" id="position" value="{{ $position_target}}">
                        </div>
                    
                        <button type="submit">Upload Image</button>
                    </form>
                    
                </div>
    
    
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
    
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

            </div>

        </div>
    </div>
</div>
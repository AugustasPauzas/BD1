


<div class="container primary_background_color default_padding default_margin default_radius under_shadow">
    <div class="row ">
        <div class="col-6">
            <p>id: {{$data_item->first()->id}}</p>
        </div>
        <div class="col-6">
            <div class="text-end">
                <a href="/view/{{$data_item->id}}">
                    <button type="button" class="btn btn-primary btn">
                        <svg class="extra_small_svg edit_svg_color" viewBox="0 0 24 24" role="img" xmlns="http://www.w3.org/2000/svg" aria-labelledby="returnIconTitle" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none" > <title id="returnIconTitle"></title> <path d="M19,8 L19,11 C19,12.1045695 18.1045695,13 17,13 L6,13"/> <polyline points="8 16 5 13 8 10"/> </svg>                        
                        Return
                    </button>                      
                </a>

            </div>
        </div>
    </div>

    


</div>

<br>
{{$data_item->first()->id}}
<button class="reload_all_images" data-item-id="{{ $data_item->id }}">Reload All Images</button>

<div class="container primary_background_color default_padding default_margin default_radius under_shadow">
    <div class="row no_margin_sides">
        <div class="col-4 hidden_lg">
            <div class="image_svg_wrapper default_margin">
            
                <div class="live_replacement_big_pick" <div class="live_replacement_big_pick" id="big-pick-container">
                    @include('partials.Live_view_update_big_pick', ['data_image' => $data_image])
                </div>
                
                
 
        
            </div>
        </div>
        <div class="col-lg-8">
            <div class="default_margin" >
                <form id="ajax_item_image_upload" enctype="multipart/form-data" method="POST" class="mb-3">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="file" name="image" id="image" class="form-control" required>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                    <input type="hidden" name="item_id" value="{{$data_item->id}}">
                    
                    <input type="hidden" name="position" value="111">
                </form>

            </div >
            


            <div id="data-container">
                @foreach($data_image as $image)
                <div class="image-container update_add_images_item full_height" data-image-id="{{ $image->image_parse_id }}">
                    <div class="image_svg_wrapper square_image">
                        <div class="position_div  default_radius">
                            #{{ $image->position }}
                        </div>
                
                
                        <a href="#" class="image_position_left default_radius no_border" data-image-parse-id="{{ $image->image_parse_id }}" data-item-id="{{ $data_item->id }}">
                            <svg class="small_svg" viewBox="0 0 24.00 24.00" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="0.144"/>
                                <g id="SVGRepo_iconCarrier">
                                    <path d="M5 12H19M5 12L11 6M5 12L11 18" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </g>
                            </svg>
                        </a>
                        
                        
                        <a href="#" class="image_position_right default_radius no_border"   data-image-parse-id="{{ $image->image_parse_id }}" data-item-id="{{ $data_item->id }}">
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
            </div>
            <br>
            <div class="row">




                

                
                

    
    
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

<script>
    var csrfToken = '{{ csrf_token() }}'; // Get the CSRF token
</script>

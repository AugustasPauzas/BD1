
@extends ('layouts.default_body')
@section('content')
<div class="default_container_margin">
    <div class="container primary_background_color default_padding default_margin default_radius under_shadow">
        <div class="row ">
            <div class="col-6  ">
                <div class="default_margin default_margin_sides">
                    <p>id: {{$data_item->id}}</p>
                </div>
            </div>
            <div class="col-6">
                <div class="text-end default_margin default_margin_sides">
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
    
    <div class="container primary_background_color default_padding default_margin default_radius under_shadow">
        <div class="row no_sides_margin">
            <div class="col-12">
                <form id="update-item-form" method="POST" data-ajax-url="{{ url('ajax_update_item') }}">
                    @csrf
                    <input id="name" name="id"  type="text" value="{{$data_item->id}}" class="form-control" hidden placeholder="">
                    <div class="row">
                        <div class="col-md-6 ">
                        <div class="default_margin default_margin_sides">
                            <div class="form-group">
                                <label for="name">Item Name</label>
                                <input id="name" name="name" type="text" value="{{ $data_item->name }}" class="form-control" placeholder="">
                                <span class="text-danger error-name"></span>
                            </div>
                            
                            <div class="form-group">
                                <label for="ien_code">IEN Code</label>
                                <input id="ien_code" name="ien_code" value="{{ $data_item->ien_code }}"  type="text" value="" class="form-control" placeholder="">
                                <span class="text-danger error-ien_code"></span>
                            </div>
                            
                            <label for="price">Price</label>
                            <div class= "form-group">
                                <div class=" input-group">
                                    <input id="price"  name="price" value="{{ $data_item->price }}" type="text" class="form-control" pattern="^\d+([.,]\d{1,2})?$">
                                    <span class="input-group-text">€</span>
                                    
                                </div>
                                <span class="text-danger error-price"></span>                            
                            </div>
                            <label for="status">Status</label>
                            
                            <div class=" input-group">
                                <select class="form-group form-select" id="status" name="status">
                                    <option value="2" {{ $data_item->status == 2 ? 'selected' : '' }}>Not Public</option>
                                    <option value="1" {{ $data_item->status == 1 ? 'selected' : '' }}>Public</option> 
                                </select>
                                
                                <span class="text-danger error-status"></span>
                            </div>                        
                        </div>
    
                        </div>
                        <div class="col-md-6">
                        <div class="default_margin default_margin_sides">
                            <div class="form-group">
                            <label  for="description">Description</label>
                            <div class="input-group">
                                
                                <textarea  id="description"  rows="4" name="description" class="form-control">{{ $data_item->description }}</textarea>
                                
                            </div>       
                            <span class="text-danger error-description"></span>                
                            </div>
    
                            
                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input value="{{ $data_item->quantity }}" id="quantity" name="quantity" type="text" class="form-control" placeholder="">
    
    
                                <span class="text-danger error-quantity"></span>
                            </div>
                            
                            <label for="category">Category</label>
                            <div>
                                <div class="input-group">
                                    <select class="form-select" id="category" name="category">
                                        <option selected></option>
                                        @foreach ($data_category as $i)
                                            <option value="{{ $i->id }}" {{ $data_item->category_id == $i->id ? 'selected' : '' }}>{{ $i->category }}</option>
                                        @endforeach
                                    </select>
                                    
                                    <button class="btn btn-primary" type="submit">Update</button>
                                </div>        
                                <span class="text-danger error-category"></span>               
                            </div>
    
                        </div>                        
                        </div>
    
                    </div>
                </form>
                
                
                
                           
            </div>
          
        </div>
    </div>
    <br>
    
    
    <div class="container primary_background_color default_padding default_margin default_radius under_shadow">
        <div class="row no_margin_sides">
            <div class="col-4 hidden_lg">
                <div class="image_svg_wrapper default_margin">
                
                    <div id="big-pick-container">
                        @include('partials.Live_view_update_big_pick', ['data_image' => $data_image])
                    </div>
                    <div class="default_margin text-end">
                    <button class="reload_all_images action_reload_b_pic btn btn-primary" data-item-id="{{ $data_item->id }}">
                        <svg class="small_svg" viewBox="0 0 24.00 24.00" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                            <g id="SVGRepo_iconCarrier"> <path d="M4.39502 12.0014C4.39544 12.4156 4.73156 12.751 5.14577 12.7506C5.55998 12.7502 5.89544 12.4141 5.89502 11.9999L4.39502 12.0014ZM6.28902 8.1116L6.91916 8.51834L6.91952 8.51777L6.28902 8.1116ZM9.33502 5.5336L9.0396 4.84424L9.03866 4.84464L9.33502 5.5336ZM13.256 5.1336L13.4085 4.39927L13.4062 4.39878L13.256 5.1336ZM16.73 7.0506L16.1901 7.57114L16.1907 7.57175L16.73 7.0506ZM17.7142 10.2078C17.8286 10.6059 18.2441 10.8358 18.6422 10.7214C19.0403 10.607 19.2703 10.1915 19.1558 9.79342L17.7142 10.2078ZM17.7091 9.81196C17.6049 10.2129 17.8455 10.6223 18.2464 10.7265C18.6473 10.8307 19.0567 10.5901 19.1609 10.1892L17.7091 9.81196ZM19.8709 7.45725C19.9751 7.05635 19.7346 6.6469 19.3337 6.54272C18.9328 6.43853 18.5233 6.67906 18.4191 7.07996L19.8709 7.45725ZM18.2353 10.7235C18.6345 10.8338 19.0476 10.5996 19.1579 10.2004C19.2683 9.80111 19.034 9.38802 18.6348 9.2777L18.2353 10.7235ZM15.9858 8.5457C15.5865 8.43537 15.1734 8.66959 15.0631 9.06884C14.9528 9.46809 15.187 9.88119 15.5863 9.99151L15.9858 8.5457ZM19.895 11.9999C19.8946 11.5856 19.5585 11.2502 19.1443 11.2506C18.7301 11.251 18.3946 11.5871 18.395 12.0014L19.895 11.9999ZM18.001 15.8896L17.3709 15.4829L17.3705 15.4834L18.001 15.8896ZM14.955 18.4676L15.2505 19.157L15.2514 19.1566L14.955 18.4676ZM11.034 18.8676L10.8815 19.6019L10.8839 19.6024L11.034 18.8676ZM7.56002 16.9506L8.09997 16.4301L8.09938 16.4295L7.56002 16.9506ZM6.57584 13.7934C6.46141 13.3953 6.04593 13.1654 5.64784 13.2798C5.24974 13.3942 5.01978 13.8097 5.13421 14.2078L6.57584 13.7934ZM6.58091 14.1892C6.6851 13.7884 6.44457 13.3789 6.04367 13.2747C5.64277 13.1705 5.23332 13.4111 5.12914 13.812L6.58091 14.1892ZM4.41914 16.544C4.31495 16.9449 4.55548 17.3543 4.95638 17.4585C5.35727 17.5627 5.76672 17.3221 5.87091 16.9212L4.41914 16.544ZM6.05478 13.2777C5.65553 13.1674 5.24244 13.4016 5.13212 13.8008C5.02179 14.2001 5.25601 14.6132 5.65526 14.7235L6.05478 13.2777ZM8.30426 15.4555C8.70351 15.5658 9.11661 15.3316 9.22693 14.9324C9.33726 14.5331 9.10304 14.12 8.70378 14.0097L8.30426 15.4555ZM5.89502 11.9999C5.89379 10.7649 6.24943 9.55591 6.91916 8.51834L5.65889 7.70487C4.83239 8.98532 4.3935 10.4773 4.39502 12.0014L5.89502 11.9999ZM6.91952 8.51777C7.57513 7.50005 8.51931 6.70094 9.63139 6.22256L9.03866 4.84464C7.65253 5.4409 6.47568 6.43693 5.65852 7.70544L6.91952 8.51777ZM9.63045 6.22297C10.7258 5.75356 11.9383 5.62986 13.1059 5.86842L13.4062 4.39878C11.9392 4.09906 10.4158 4.25448 9.0396 4.84424L9.63045 6.22297ZM13.1035 5.86793C14.2803 6.11232 15.3559 6.7059 16.1901 7.57114L17.27 6.53006C16.2264 5.44761 14.8807 4.70502 13.4085 4.39927L13.1035 5.86793ZM16.1907 7.57175C16.9065 8.31258 17.4296 9.21772 17.7142 10.2078L19.1558 9.79342C18.8035 8.5675 18.1557 7.44675 17.2694 6.52945L16.1907 7.57175ZM19.1609 10.1892L19.8709 7.45725L18.4191 7.07996L17.7091 9.81196L19.1609 10.1892ZM18.6348 9.2777L15.9858 8.5457L15.5863 9.99151L18.2353 10.7235L18.6348 9.2777ZM18.395 12.0014C18.3963 13.2363 18.0406 14.4453 17.3709 15.4829L18.6312 16.2963C19.4577 15.0159 19.8965 13.5239 19.895 11.9999L18.395 12.0014ZM17.3705 15.4834C16.7149 16.5012 15.7707 17.3003 14.6587 17.7786L15.2514 19.1566C16.6375 18.5603 17.8144 17.5643 18.6315 16.2958L17.3705 15.4834ZM14.6596 17.7782C13.5643 18.2476 12.3517 18.3713 11.1842 18.1328L10.8839 19.6024C12.3508 19.9021 13.8743 19.7467 15.2505 19.157L14.6596 17.7782ZM11.1865 18.1333C10.0098 17.8889 8.93411 17.2953 8.09997 16.4301L7.02008 17.4711C8.06363 18.5536 9.40936 19.2962 10.8815 19.6019L11.1865 18.1333ZM8.09938 16.4295C7.38355 15.6886 6.86042 14.7835 6.57584 13.7934L5.13421 14.2078C5.48658 15.4337 6.13433 16.5545 7.02067 17.4718L8.09938 16.4295ZM5.12914 13.812L4.41914 16.544L5.87091 16.9212L6.58091 14.1892L5.12914 13.812ZM5.65526 14.7235L8.30426 15.4555L8.70378 14.0097L6.05478 13.2777L5.65526 14.7235Z" fill="#ffffff" data-darkreader-inline-fill="" style="--darkreader-inline-fill: #000000;"/> </g>
                        </svg>
                        Reload Images
                    </button>    
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
                <hr>
    
    
                <div id="data-container">
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
                            <a class="item_update_delete_button" data-item-id="{{ $data_item->id }}" data-image-parse-id="{{ $image->image_parse_id }}">
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
    
    <br>
    
    <br>
    
    <div class="container primary_background_color default_padding default_margin default_radius under_shadow">
    
        <div class="d-flex position-relative align-items-center">
            <span class="position-absolute start-50 translate-middle-x">
                <p><strong>Full Item Specification</strong></p></span>
            <span class="ms-auto">
                <button class="ajax_reload_update_specification btn btn-primary ajax_reload_specification_add_form" data-item-id="{{ $data_item->id }}">
                    <svg class="extra_small_svg" viewBox="0 0 24.00 24.00" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                        <g id="SVGRepo_iconCarrier"> <path d="M4.39502 12.0014C4.39544 12.4156 4.73156 12.751 5.14577 12.7506C5.55998 12.7502 5.89544 12.4141 5.89502 11.9999L4.39502 12.0014ZM6.28902 8.1116L6.91916 8.51834L6.91952 8.51777L6.28902 8.1116ZM9.33502 5.5336L9.0396 4.84424L9.03866 4.84464L9.33502 5.5336ZM13.256 5.1336L13.4085 4.39927L13.4062 4.39878L13.256 5.1336ZM16.73 7.0506L16.1901 7.57114L16.1907 7.57175L16.73 7.0506ZM17.7142 10.2078C17.8286 10.6059 18.2441 10.8358 18.6422 10.7214C19.0403 10.607 19.2703 10.1915 19.1558 9.79342L17.7142 10.2078ZM17.7091 9.81196C17.6049 10.2129 17.8455 10.6223 18.2464 10.7265C18.6473 10.8307 19.0567 10.5901 19.1609 10.1892L17.7091 9.81196ZM19.8709 7.45725C19.9751 7.05635 19.7346 6.6469 19.3337 6.54272C18.9328 6.43853 18.5233 6.67906 18.4191 7.07996L19.8709 7.45725ZM18.2353 10.7235C18.6345 10.8338 19.0476 10.5996 19.1579 10.2004C19.2683 9.80111 19.034 9.38802 18.6348 9.2777L18.2353 10.7235ZM15.9858 8.5457C15.5865 8.43537 15.1734 8.66959 15.0631 9.06884C14.9528 9.46809 15.187 9.88119 15.5863 9.99151L15.9858 8.5457ZM19.895 11.9999C19.8946 11.5856 19.5585 11.2502 19.1443 11.2506C18.7301 11.251 18.3946 11.5871 18.395 12.0014L19.895 11.9999ZM18.001 15.8896L17.3709 15.4829L17.3705 15.4834L18.001 15.8896ZM14.955 18.4676L15.2505 19.157L15.2514 19.1566L14.955 18.4676ZM11.034 18.8676L10.8815 19.6019L10.8839 19.6024L11.034 18.8676ZM7.56002 16.9506L8.09997 16.4301L8.09938 16.4295L7.56002 16.9506ZM6.57584 13.7934C6.46141 13.3953 6.04593 13.1654 5.64784 13.2798C5.24974 13.3942 5.01978 13.8097 5.13421 14.2078L6.57584 13.7934ZM6.58091 14.1892C6.6851 13.7884 6.44457 13.3789 6.04367 13.2747C5.64277 13.1705 5.23332 13.4111 5.12914 13.812L6.58091 14.1892ZM4.41914 16.544C4.31495 16.9449 4.55548 17.3543 4.95638 17.4585C5.35727 17.5627 5.76672 17.3221 5.87091 16.9212L4.41914 16.544ZM6.05478 13.2777C5.65553 13.1674 5.24244 13.4016 5.13212 13.8008C5.02179 14.2001 5.25601 14.6132 5.65526 14.7235L6.05478 13.2777ZM8.30426 15.4555C8.70351 15.5658 9.11661 15.3316 9.22693 14.9324C9.33726 14.5331 9.10304 14.12 8.70378 14.0097L8.30426 15.4555ZM5.89502 11.9999C5.89379 10.7649 6.24943 9.55591 6.91916 8.51834L5.65889 7.70487C4.83239 8.98532 4.3935 10.4773 4.39502 12.0014L5.89502 11.9999ZM6.91952 8.51777C7.57513 7.50005 8.51931 6.70094 9.63139 6.22256L9.03866 4.84464C7.65253 5.4409 6.47568 6.43693 5.65852 7.70544L6.91952 8.51777ZM9.63045 6.22297C10.7258 5.75356 11.9383 5.62986 13.1059 5.86842L13.4062 4.39878C11.9392 4.09906 10.4158 4.25448 9.0396 4.84424L9.63045 6.22297ZM13.1035 5.86793C14.2803 6.11232 15.3559 6.7059 16.1901 7.57114L17.27 6.53006C16.2264 5.44761 14.8807 4.70502 13.4085 4.39927L13.1035 5.86793ZM16.1907 7.57175C16.9065 8.31258 17.4296 9.21772 17.7142 10.2078L19.1558 9.79342C18.8035 8.5675 18.1557 7.44675 17.2694 6.52945L16.1907 7.57175ZM19.1609 10.1892L19.8709 7.45725L18.4191 7.07996L17.7091 9.81196L19.1609 10.1892ZM18.6348 9.2777L15.9858 8.5457L15.5863 9.99151L18.2353 10.7235L18.6348 9.2777ZM18.395 12.0014C18.3963 13.2363 18.0406 14.4453 17.3709 15.4829L18.6312 16.2963C19.4577 15.0159 19.8965 13.5239 19.895 11.9999L18.395 12.0014ZM17.3705 15.4834C16.7149 16.5012 15.7707 17.3003 14.6587 17.7786L15.2514 19.1566C16.6375 18.5603 17.8144 17.5643 18.6315 16.2958L17.3705 15.4834ZM14.6596 17.7782C13.5643 18.2476 12.3517 18.3713 11.1842 18.1328L10.8839 19.6024C12.3508 19.9021 13.8743 19.7467 15.2505 19.157L14.6596 17.7782ZM11.1865 18.1333C10.0098 17.8889 8.93411 17.2953 8.09997 16.4301L7.02008 17.4711C8.06363 18.5536 9.40936 19.2962 10.8815 19.6019L11.1865 18.1333ZM8.09938 16.4295C7.38355 15.6886 6.86042 14.7835 6.57584 13.7934L5.13421 14.2078C5.48658 15.4337 6.13433 16.5545 7.02067 17.4718L8.09938 16.4295ZM5.12914 13.812L4.41914 16.544L5.87091 16.9212L6.58091 14.1892L5.12914 13.812ZM5.65526 14.7235L8.30426 15.4555L8.70378 14.0097L6.05478 13.2777L5.65526 14.7235Z" fill="#ffffff" data-darkreader-inline-fill="" style="--darkreader-inline-fill: #000000;"/> </g>
                    </svg>
                </button>
            </span>
          </div>
          <hr>
          <div class="row no_margin_sides  default_padding default_radius default_margin">
            <div id="specifications_add_form_container">
                <form class="no_margin_bottom" id="ajax_add_specification" enctype="multipart/form-data" method="POST" action="{{ url('/ajax_add_specification') }}">
                    @csrf
                    <div class="row">
                        <div class="col-5">
                            <label for="parameter_name">Parameter</label>
                            <div class="input-group mb-3 no_margin_bottom" style="position: relative;">
                                <input type="text" name="parameter_name" id="parameter_name" class="form-control" value="{{$first_parameter_name = $data_specifications_table_all_items->first()->parameter_name ?? null}}" required onkeyup="parameter_add_filterDropdown()" onfocus="parameter_add_openDropdown()" autocomplete="off" placeholder="Enter Parameter">
                                <ul class="dropdown-menu dropdown-menu-end full_width" id="parameter_add_dropdown_options">
                                    @foreach ($data_specifications_table_all_items as $i)
                                        <li onclick="parameter_add_setParameter(' {{$i->parameter_name}}')"> {{$i->parameter_name}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-7">
                            <label for="value_name">Value</label>
                            <div class="input-group mb-3 no_margin_bottom">
                                <input id="clear_value_after_submit" type="text" placeholder="Enter Value" name="value_name" class="form-control" required>
                                <button type="submit" class="btn btn-success ajax_reload_update_specification ajax_reload_specification_add_form" data-item-id="{{ $data_item->id }}">Create Row</button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="item_id" value="{{ $data_item->id }}">
                </form>
                
            </div> <!--specifications_add_form_container END HERE -->
            <div id="responseMessage" class="the_success_message">
                <span id="success_messageText"></span>
                <button id="closeMessage" style="background: transparent; border: none; color: white; margin-left: 10px; cursor: pointer;">&times;</button>
            </div>
        </div>
        <hr>
        <div class="row no_margin_sides hide_on_md">
            <div class="update_view_parameter_col"><p><strong>Parameter</strong></p></div>
            <div class="update_view_value_col"><p><strong>Value</strong></p></div>
            <div class="update_view_spec_delete_col"></div>
        </div>
    
         
    <div id="specificationsContainer">
    
        @php
        $grouped_specifications = [];
        foreach ($data_specifications_table as $item) {
            $grouped_specifications[$item->parameter_name][] = [
                'value_name' => $item->value_name,
                'parameter_id' => $item->parameter_id,
                'specification_id' => $item->specification_id,
            ];
        }
        
        $equalrow = 1;
        
        @endphp
        <div class="row no_margin_sides ">
            
            @foreach ($grouped_specifications as $parameter_name => $value_names)
            <div class="row no_margin_sides  update_view_specification_hover default_radius {{ $equalrow == 1 ? ($equalrow=$equalrow - 1) . ' quaternary_background_color' : ($equalrow= $equalrow + 1) . '' }}">
                
            <div class="update_view_parameter_col default_radius ">
                @php $Parameter_ID=$value_names[0]['parameter_id']; @endphp
                <form class="ajax_parameter_update_form " data-item-id="{{ $data_item->id }}" action="/ajax_update_specification_parameter" method="POST">
                    
                    @csrf
                    <div class="input-group mb-3 no_margin_bottom">
                        <input type="text" name="name" class="form-control" value="{{ $parameter_name }}" required>
                        <button type="submit" class="btn btn-primary ajax_reload_update_specification" data-item-id="{{ $data_item->id }}">Update</button>
                    </div>
                    <input type="hidden" name="item_id" value="{{ $data_item->id }}">
                    
                    @if (!empty($value_names))
                        <input type="hidden" name="parameter_id" value="{{ $Parameter_ID }}">
                        <input type="hidden" name="specification_id" value="{{ $value_names[0]['specification_id'] }}">
                    @endif
                </form>                  
            </div>
            <div class="update_view_value_col">
                <div class="d-flex flex-wrap ">
                    @foreach ($value_names as $value_name) 
                        <div class="default_radius default_padding update_view_value_div me-2">
                            {{ $value_name['value_name'] }} 
    
                            <a class="no_ancor_decoration delete_parameter_value_button" data-specification-id="{{ $value_name['specification_id'] }}" data-item-id="{{ $data_item->id }}" data-value-id="{{ $value_name['parameter_id'] }}" href="#">
                                <svg class="small_svg delete_spec_button_svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 12V17"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M14 12V17"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M4 7H20"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M6 10V18C6 19.6569 7.34315 21 9 21H15C16.6569 21 18 19.6569 18 18V10" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        </div>
                    @endforeach
                    <div class="default_radius default_padding update_view_value_div me-2">
    
                        
                        <form class="ajax_add_only_value_form "  data-parameter-id="{{ $Parameter_ID }}" action="/ajax_add_only_value_form" method="POST">
                    
                            @csrf
                            <div class="input-group mb-3 no_margin_bottom">
                                <input type="text" name="name" class="form-control" placeholder="Value"  required>
                                <button type="submit" class="btn btn-success ajax_reload_update_specification" data-item-id="{{ $data_item->id }}" >Add</button>
                            </div>
                            <input type="hidden" name="item_id" value="{{ $data_item->id }}">
                            <input type="hidden" name="parameter_id" value="{{  $Parameter_ID }}">
                        </form>  
                    
                    </div>
                </div>    
            </div>
            <div class="update_view_spec_delete_col">
                <a   class="no_ancor_decoration delete_specification_row_button ajax_reload_update_specification" data-item-id="{{ $data_item->id }}" data-specification-id="{{ $value_name['specification_id'] }}"  data-parameter-id="{{ $Parameter_ID }}" href="#">
                <div class="default_radius default_padding update_view_spec_delete_div  me-2 text-center">
    
                    <svg class="small_svg delete_spec_button_svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 12V17"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M14 12V17"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M4 7H20"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M6 10V18C6 19.6569 7.34315 21 9 21H15C16.6569 21 18 19.6569 18 18V10"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                </a>
            </div>
            </div>
            @endforeach
        </div>
    
    </div>
    
    
    </div>
    
    
    
    
    
    
    
    <script>
        var csrfToken = '{{ csrf_token() }}'; // Get the CSRF token
    </script>
</div>
@endsection
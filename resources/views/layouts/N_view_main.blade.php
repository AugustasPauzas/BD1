

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

<div class="container primary_background_color default_padding default_margin default_radius under_shadow">

    <div class="row no_sides_margin">
        <div class="col-md-6">

            <div class="image_svg_wrapper default_margin">
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

                    
                        <div  class="same_line_container default_padding" id="imageContainer">
                            @foreach($data_image as $image)
                            <div class="same_line_item small_pading_left_right  default_margin">
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
        <div class="col-md-6 no_sides_margin ">
            <div class="default_margin">
            <p>aaa</p> 
            {{$data_item->name}}    
            {{$data_item}}              
            </div>

                       
        </div>
      
    </div>

</div>

<br>

<div class="container ">
    <div class="row no_sides_margin">
        
        <div class="col-6 primary_background_color default_padding default_margin default_radius under_shadow">
            <div class="row no_sides_margin">
            <table class="table-striped table-hover default_margin  default_margin_sides">
                <thead>
                    <tr>
                        <th scope="col">Parameter</th>
                        <th scope="col w-50">Values</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data_parameter as $p)
                        @php
                            $values = []; 
                        @endphp
            
                        @foreach ($data_specification as $spec)
                            @if ($data_item->id == $spec->item_id && $spec->parameter_id == $p->id)
                                @foreach ($data_value as $v)
                                    @if ($spec->value_id == $v->id)
                                        @php
                                            $values[] = $v->value_name; 
                                        @endphp
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
            
                        @if (count($values) > 0)
                            <tr>
                                <td>{{ $p->parameter_name }}</td>
                                <td>
                                    {{ implode(', ', $values) }} 
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>                
            </div>

            
            
            

        </div>
        <div class="col-6 primary_background_color default_padding default_margin default_radius under_shadow">
        aa
        </div>

    </div>
</div>
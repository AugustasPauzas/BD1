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
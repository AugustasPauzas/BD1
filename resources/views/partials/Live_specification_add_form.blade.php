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
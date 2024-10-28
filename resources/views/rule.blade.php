@extends ('layouts.default_body')
@section('content')

<script type="text/javascript" src="{{ asset('js/rule_view_JS.js') }}"></script>

<div class="default_container_margin">



<div class="container">
<div class= "row no_margin primary_background_color default_padding default_margin default_radius under_shadow default_large_margin_bottom">
    <p class="text-center"><strong>Create New Rule</strong></p>
<div class="col">
    
    <div class="">
        <form id="ajax_add_rule" action="ajax_add_rule_html" method="POST" class="row gx-2 align-items-center">
            @csrf
            <div class="col-md-2">
                <select class="form-select" name="category_id_1">
                    @foreach ($data_category as $i)
                        <option value="{{$i->id}}">{{$i->category}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" name="parameter_id_1">
                    @foreach ($data_parameter as $i)
                        <option value="{{$i->id}}">{{$i->parameter_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="status" name="operation">
                    <option value="1">=</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" name="category_id_2">
                    @foreach ($data_category as $i)
                        <option value="{{$i->id}}">{{$i->category}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" name="parameter_id_2">
                    @foreach ($data_parameter as $i)
                        <option value="{{$i->id}}">{{$i->parameter_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>

    
    
</div>
</div>

<div class="row default_padding primary_background_color default_padding default_margin default_radius under_shadow ">
<div class="col ">
<p><strong>Rule Set:</strong></p>


<div id="rule-container">
    @include('partials.Live_rule')  
</div>


</div>
</div>

</div>



</div>


@endsection
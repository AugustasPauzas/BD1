@extends ('layouts.default_body')
@section('content')

<div class="default_container_margin">



<div class="container">
<div class= "row no_margin">
<div class="col">
    

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

<div class="row">
<div class="col primary_background_color default_padding default_margin default_radius under_shadow">

<div id="rule-container">
    @php
        $rulecount=0;
    @endphp
    @foreach ($data_rule as $i)
    @php
    $rulecount++;
    @endphp
    <p>
        <strong>#{{$rulecount}}</strong>
        Where Category 
        <strong>
        @foreach ($data_category as $ii)
            @if ($ii->id == $i->category_id_1)
                {{$ii->category}}
                @break
            @endif
        @endforeach
        (ID: {{$i->category_id_1}}) 
        </strong> 
        And Parameter 
        <strong> 
        @foreach ($data_parameter as $ii)
            @if ($ii->id == $i->parameter_id_1)
                {{$ii->parameter_name}}
                @break
            @endif
        @endforeach 
        (ID: {{$i->parameter_id_1}})
        </strong> 
        = 
        Category 
        
        <strong>
        @foreach ($data_category as $ii)
            @if ($ii->id == $i->category_id_2)
                {{$ii->category}}
                @break
            @endif
        @endforeach 
        (ID: {{$i->category_id_2}})
        </strong> 
        And Parameter 
        <strong>
            @foreach ($data_parameter as $ii)
                @if ($ii->id == $i->parameter_id_2)
                    {{$ii->parameter_name}}
                    @break
                @endif
            @endforeach 
            (ID: {{$i->parameter_id_2}})
        </strong>
        <a class="delete_rule no_ancor_decoration" href="delete" data-rule-id="{{$i->id}}">
            delete
        </a>

    </p>
    @endforeach    
</div>

</div>
</div>

</div>



</div>


@endsection
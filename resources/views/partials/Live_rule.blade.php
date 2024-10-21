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
<a class="delete_rule" href="delete" data-rule-id="{{$i->id}}">
    delete
</a>

</p>
@endforeach  
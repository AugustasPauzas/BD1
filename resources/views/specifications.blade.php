@extends ('layouts.default_body')
@section('content')

<div class="default_container_margin">
    <div class="container  ">

        <div class="row no_margin_sides">
            <div class="col-12">
                <div class="row no_margin_sides  primary_background_color default_padding default_large_margin default_radius under_shadow">
                    <p ><strong class="remain_center">{{translate("Specification Table")}}</strong>  </p>
                    <table class="table-striped table-hover ">
                        <thead>
                            <tr>
                              <th scope="col">{{translate("ID")}}</th>
                              <th scope="col">{{translate("Item ID")}}</th>
                              <th scope="col">{{translate("Parameter ID")}}</th>
                              <th scope="col">{{translate("Value ID")}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($specification_data as $i)
                            <tr>
                              <th scope="row"> {{$i->id}}</th>
                              <td>{{$i->item_id}}</td>
                              <td>{{$i->parameter_id}}</td>
                              <td>{{$i->value_id}}</td>
                            </tr>
                            @endforeach
                        <tbody>
                    </table>
                </div>
                
            </div>
        </div>
    
        <div class="row no_margin_sides">
            <div class="col-md-6">
                <div class="row no_margin_sides primary_background_color default_padding default_large_margin default_radius under_shadow">
                    <p ><strong class="remain_center">{{translate("Parameter Table")}}</strong>  </p>
                    <table class="table-striped table-hover ">
                        <thead>
                            <tr>
                              <th scope="col">{{translate("ID")}}</th>
                              <th scope="col">{{translate("Parameter")}}</th>
                              <th scope="col">{{translate("Times Used")}}</th>
    
                            </tr>
                        </thead>
                        <tbody class=""> 
                            @foreach ($parameter_data as $i)
                            <tr>
                              <th scope="row"> {{$i->id}}</th>
                              <td>{{$i->parameter_name}}</td>
                              <td> 
                                    @php
                                    $count = 0;
                                    foreach ($specification_data as $ii) {
                                      if ($ii->value_id == $i->id) {
                                        $count++;  
                                      }
                                    }
                                  @endphp
                                  {{$count}} {{translate("times")}}
                              </td>
                            </tr>
                            @endforeach
                        <tbody>
                    </table>
                    <form action="add_new_parameter" method="post" class="row g-2">
                        @csrf
                        <div class="col-1">
                        </div>
                        <div class="col-8">
    
                          <input name="parameter_name" type="" class="form-control"  placeholder="Parameter">
                        </div>
                        <div class="col-3">
                          <button type="submit" class="btn btn-primary mb-3">{{translate("Add New")}}</button>
                        </div>
                    </form>
                </div>
                
            </div>
            <div class="col-md-6 ">
                <div class="row no_margin_sides primary_background_color default_padding default_large_margin default_radius under_shadow">
                    <p ><strong class="remain_center">{{translate("Value Table")}}</strong>  </p>
                    <table class="table-striped table-hover ">
                        <thead>
                            <tr>
                              <th scope="col">{{translate("ID")}}</th>
                              <th scope="col">{{translate("Value")}}</th>
                              <th scope="col">{{translate("Times Used")}}</th>
    
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($value_data as $i)
                            <tr>
                              <th scope="row"> {{$i->id}}</th>
                              <td>{{$i->value_name}}</td>
                              <td>
                                @php
                                  $count = 0;
                                  foreach ($specification_data as $ii) {
                                    if ($ii->value_id == $i->id) {
                                      $count++;  
                                    }
                                  }
                                @endphp
                                {{$count}} {{translate("times")}}
                              </td>
                            </tr>
                            @endforeach
                        <tbody>
                    </table>
    
    
                    <form action="add_new_value" method="post" class="row g-2">
                        @csrf
                        <div class="col-1">
                        </div>
                        <div class="col-8">
    
                          <input name="value_name" type="" class="form-control"  placeholder="Value">
                        </div>
                        <div class="col-3">
                          <button type="submit" class="btn btn-primary mb-3">{{translate("Add New")}}</button>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    
    </div>
</div>
@endsection
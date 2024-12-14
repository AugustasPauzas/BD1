@extends ('layouts.default_body')
@section('content')




<script type="text/javascript" src="{{ asset('js/categories_JS.js') }}"></script>



<div class="default_container_margin">

    <div class="container primary_background_color default_padding default_margin default_radius under_shadow">
        <p ><strong class="remain_center">Add New Category</strong>  </p>
        
        <form id="add_new_category_form" method="post">
            @csrf
            <div class="row align-items-end">
                <!-- Category Name Input -->
                <div class="form-group col-md-5">
                    <label for="category">Category Name</label>
                    <input id="category" name="category" type="text" value="{{ old('categoryname') }}" class="form-control" placeholder="Category Name">
                </div>
        
                <!-- Full Category Name Input -->
                <div class="form-group col-md-5">
                    <label for="category_full">Full Category Name</label>
                    <input id="category_full" name="category_full" type="text" value="{{ old('fullcategoryname') }}" class="form-control" placeholder="Full Category Name">
                </div>
        
                <!-- Submit Button -->
                <div class="form-group col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </div>
        </form>
        
        
        
        
    
    </div>
    <br>
    <div class="container primary_background_color default_padding default_margin default_radius under_shadow">

        <div id="categories_list">



            @include('partials.Live_categories')  

        </div>
    </div>

    <!--
    <br>

    <div class="container primary_background_color default_padding default_margin default_radius under_shadow">
    
            <p ><strong class="remain_center">Category Table</strong>  </p>
            <div class="row no_margin_sides">
    
                <table class="table-striped table-hover ">
                <thead>
                    <tr>
                      <th scope="col">ID</th>
                      <th scope="col">Category Name</th>
                      <th scope="col">Full Category Name</th>
                      <th scope="col">Created At</th>
                      <th scope="col">Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $i)
                    <tr>
                      <th scope="row"> {{$i->id}}</th>
                      <td>{{$i->category}}</td>
                      <td>{{$i->category_full}}</td>
                      <td>{{$i->created_at}}</td>
                      <td>{{$i->updated_at}}</td>
                    </tr>
                    @endforeach
                <tbody>
            </table> 
            </div>
    
    
        
    </div>
    -->


</div>
@endsection
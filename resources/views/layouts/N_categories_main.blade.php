
<div class="container primary_background_color default_padding default_margin default_radius under_shadow">
    <p ><strong class="remain_center">Add New Category</strong>  </p>

    <form action="add_new_category" method="post">
        @csrf
        <div class="row no_margin_sides">
            <div class="form-group col-5 ">
            <label for="exampleInputEmail1">Category Name</label>
            <input name="category" type="" value="{{ old('categoryname')}}" class="form-control" placeholder="Category Name">
            <p> @error('category'){{$message}}@enderror</p>
            </div>
            <div class="form-group col-5">
            <label for="exampleInputPassword1">Full Category Name</label>
            <input name="category_full" type="" value="{{ old('fullcategoryname')}}" class="form-control" placeholder="Full Category Name">
            <p > @error('category_full'){{$message}}@enderror</p>
            </div>  
            <div class="form-group col-2 ">
                <button type="submit" class="btn btn-primary">Add</button>
            </div>                                  
        </div>
    </form>

</div>
<br>
<div class="container primary_background_color default_padding default_margin default_radius under_shadow">

        <p ><strong class="remain_center">Category Table</strong>  </p>
        <div class="row no_margin_sides">

            <table>

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
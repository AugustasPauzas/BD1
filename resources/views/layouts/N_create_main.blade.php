<div class="container primary_background_color default_padding default_margin default_radius under_shadow">
    <p ><strong class="remain_center">Create New Item</strong>  </p>
    <div class="row no_sides_margin">
        <div class="col-12">
            <form action="{{ url('add_new_item') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">Item Name</label>
                            <input id="name" name="name" type="text" value="" class="form-control" placeholder="">
                        </div>
            
                        <div class="form-group">
                            <label for="ien_code">IEN Code</label>
                            <input id="ien_code" name="ien_code" type="text" value="" class="form-control" placeholder="">
                        </div>
            
                        <label for="price">Price</label>
                        <div class="input-group">
                            <input id="price" name="price" type="text" class="form-control">
                            <span class="input-group-text">€</span>
                        </div>
            
                        <label for="status">Status</label>
                        <div class="input-group">
                            <select class="form-select" id="status" name="status">
                                <option value="2" selected>Not Public</option>
                                <option value="1">Public</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="description">Description</label>
                        <div class="input-group">
                            <textarea id="description" name="description" class="form-control"></textarea>
                        </div>
            
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input id="quantity" name="quantity" type="text" value="" class="form-control" placeholder="">
                        </div>
            
                        <label for="category">Category</label>
                        <div class="input-group">
                            <select class="form-select" id="category" name="category">
                                <option selected>Choose</option>
                                @foreach ($data_category as $i)
                                    <option value="{{ $i->id }}">{{ $i->category }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-primary" type="submit">Create New Item</button>
                        </div>                        
                    </div>
                </div>
            </form>
            
                       
        </div>
      
    </div>
</div>
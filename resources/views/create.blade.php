@extends ('layouts.default_body')
@section('content')

<div class="default_container_margin">
    <div class="container primary_background_color default_padding default_margin default_radius under_shadow">
        <p ><strong class="remain_center">Create New Item</strong>  </p>
        <div class="row no_sides_margin">
            <div class="col-12">
                <form id="add-item-form" method="POST" data-ajax-url="{{ url('ajax_add_new_item') }}">
                    @csrf
                    <div class="row">
    
                        <div class="col-md-6 ">
                        <div class="default_margin default_margin_sides">
                            <div class="form-group">
                                <label for="name">Item Name</label>
                                <input id="name" name="name" type="text" value="" class="form-control" placeholder="">
                                <span class="text-danger error-name"></span>
                            </div>
                            
                            <div class="form-group">
                                <label for="ien_code">IEN Code</label>
                                <input id="ien_code" name="ien_code" type="text" value="" class="form-control" placeholder="">
                                <span class="text-danger error-ien_code"></span>
                            </div>
                            
                            <label for="price">Price</label>
                            <div class= "form-group">
                                <div class=" input-group">
                                    <input id="price"  name="price" type="text" class="form-control" pattern="^\d+([.,]\d{1,2})?$">
                                    <span class="input-group-text">€</span>
                                    
                                </div>
                                <span class="text-danger error-price"></span>                            
                            </div>
                            <label for="status">Status</label>
                            <div class=" input-group">
                                <select class="form-group form-select" id="status" name="status">
                                    <option value="1" >Not Public</option>
                                    <option value="2" selected>Public</option>
                                </select>
                                <span class="text-danger error-status"></span>
                            </div>                        
                        </div>
    
                        </div>
                        <div class="col-md-6">
                        <div class="default_margin default_margin_sides">
                            <div class="form-group">
                            <label for="description">Description</label>
                            <div class="input-group">
                                
                                <textarea id="description" rows="4" name="description" class="form-control"></textarea>
                                
                            </div>       
                            <span class="text-danger error-description"></span>                
                            </div>
    
                            
                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input id="quantity" name="quantity" type="text" class="form-control" placeholder="">
    
    
                                <span class="text-danger error-quantity"></span>
                            </div>
                            
                            <label for="category">Category</label>
                            <div>
                                <div class="input-group">
                                    <select class="form-select" id="category" name="category">
                                        <option selected></option>
                                        @foreach ($data_category as $i)
                                            <option value="{{ $i->id }}">{{ $i->category }}</option>
                                        @endforeach
                                    </select>
                                    
                                    <button class="btn btn-primary" type="submit">Create New Item</button>
                                </div>        
                                <span class="text-danger error-category"></span>               
                            </div>
    
                        </div>                        
                        </div>
    
                    </div>
                </form>
                
                
                
                           
            </div>
          
        </div>
    </div>
</div>
@endsection



<div class="row no_margin_sides ">

    @foreach ($data as $i)
    <div class="secondary_background_color categories_item_list no_padding text-start ">


        <div class="index_item_base default_radius ">




            <div class="
                        @if ($i->status == 0)
                            categories_status_bar_inactive 
                        @elseif ($i->status == 1)
                            categories_status_bar_active 
                        @endif

            default_radius_top default_padding">
                <div class="row">
                <div class="col-4">
                    <p class="font_110 no_padding   default_margin ">
                        @if ($i->status == 0)
                            Inactive
                        @elseif ($i->status == 1)
                            Active
                        @endif

                    </p>
                </div>
                <div class="col-8 ">
                    <div class="text-end">
                        @if ($i->status == 0)
                        <button id="category_status_set_active" class="btn btn-success" data-category-id="{{$i->id}}"> Set Active</button>   
                        @elseif ($i->status == 1)
                        <button id="category_status_set_inactive" class="btn btn-danger"  data-category-id="{{$i->id}}"> Set Inactive</button>   
                        @endif                      
                    </div>
                </div>
                </div> 

                

            </div>

            <div class="row ">
                <div class="col-xl-4 ">
                    <div class="remain_center default_padding">
                        @if ($i->image_location)
                        <img class="full_width_image default_radius square_image" 
                        src="{{ asset($i->image_location) }}"
                        alt="">
                        @else

                        <img class="full_width_image default_radius square_image" 
                        src="" onerror="this.onerror=null; this.src='{{ url('/images/missingPicture.png') }}';" alt="">
                        
                        @endif
                    </div>
                </div>
                <div class="col-xl-8">
                    <!--<p class=" default_padding"><strong>ID: </strong> {{$i->id}}</p> -->
                    <p class="no_padding_left default_padding default_margin large_padding_sides"><strong>Category Name <br> </strong></p>

                    <form id="update_category_name" method="POST">
                        @csrf
                        <div class="no_padding_left input-group mb-3 no_margin_bottom large_padding_sides">
                            <input type="text" name="category_name" class="form-control" value="{{ $i->category }}" required>
                            <button type="submit" class="btn btn-primary ">Update</button>
                        </div>
                        <input type="hidden" name="id" value="{{ $i->id }}">
                    </form>
                    
                    

                    <p class="no_padding_left default_padding default_margin large_padding_sides"><strong>Full Category Name: <br></strong></p>
                    
                    <form id="update_category_name_full"  method="POST">
                        @csrf
                        <div class="no_padding_left input-group mb-3 no_margin_bottom large_padding_sides">
                            <input type="text" name="category_name_full" class="form-control" value="{{$i->category_full}}" required>
                            <button type="submit" class="btn btn-primary ">Update</button>
                        </div>
                        <input type="hidden" name="id" value="{{ $i->id }}">
                    </form>   


                    <!--<p class=" default_padding default_margin"><strong>Created At: <br></strong>{{$i->created_at}}</p> -->
                    <p class="no_padding_left default_padding default_margin large_padding_sides"><strong>Updated At: <br></strong>{{$i->updated_at}}</p>                      
                </div>
                <div class="col-12">
                    <hr>
                    <form id="category_image_upload" enctype="multipart/form-data" method="POST" class="mb-3">
                        @csrf
                        <div class="large_padding_sides">
                            <p class=" default_padding default_margin"><strong>Upload a New Image File <br> </strong></p>
                            <div class="input-group mb-3">
                                <input type="file" name="image" id="image" class="form-control" required>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Update Image</button>

                            </div>
                            <input type="hidden" name="id" value="{{$i->id}}">
                        </div>

                    </form>
                </div>
                


            </div>   


        </div>
          
    </div>
    @endforeach

</div>
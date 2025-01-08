@extends ('layouts.default_body')
@section('content')

<script type="text/javascript" src="{{ asset('js/.js') }}"></script>





<div class="default_container_margin">
<div class="container">
<div class= "row no_margin primary_background_color default_padding default_margin default_radius under_shadow default_large_margin_bottom">

    <div class="col default_padding">
        <div id="user-list-container">
            @include('partials.Live_user_list')  
        </div>
        
        
    </div>
    
    
</div>
</div>
</div>




  
@endsection
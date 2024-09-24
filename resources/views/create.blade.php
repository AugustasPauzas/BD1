


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    @include('layouts.N_head')
    
    </head>

    <body class="">

        <div class="screen_height">
            @include('layouts.N_navigation')
            <br>
            <br>
            <br>

            @include('layouts.N_create_main')


            <br>
            <br>
            <br>

            @include('layouts.N_footer')
        </div>
        
    </body>
</html>


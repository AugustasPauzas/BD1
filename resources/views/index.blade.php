<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'PcParts') }}</title>

        <?php
        //meta
        $VarWebsiteNameLong = "Computer Parts";
        $VarWebsiteNameShort = "Pcparts";
        $VarWebsiteLogo = "/images/logo64.png";

        //kontaktiniai duomenys
        $VarWebsitePhoneNumber = "+370 674 20469";
        $VarWebsiteEmail = "Email@gmail.com";
        $VarWebsiteLocation = "Pramonės pr. 20";
        ?>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        


        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>




        <!-- Styles -->
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    </head>

    
    <body class="">
        
        <header>
        @include('layouts.header')
        </header>
        <div class="screen_height">
            @include('layouts.N_navigation')
            <br>
            <br>
            <br>
            <div class="container primary_background_color default_padding default_margin default_radius">
                
                <div class="row">
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-6">CPU</div>
                            <div class="col-6">GPU</div>      
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-6">RAM</div>
                            <div class="col-6">PSU</div>      
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-6">Mother Board</div>
                            <div class="col-6">SSD/HDD</div>      
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-6">Case</div>
                            <div class="col-6">Fan</div>      
                        </div>
                    </div>
                </div>
                
            </div>



            @include('layouts.N_footer',[
                'VarWebsiteNameLong' => $VarWebsiteNameLong,
                'VarWebsitePhoneNumber' => $VarWebsitePhoneNumber,
                'VarWebsiteEmail' => $VarWebsiteEmail,
                'VarWebsiteLocation' => $VarWebsiteLocation])
        </div>
        


    </body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

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

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />





        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

        <!-- Styles -->
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        

        <div class="min-h-screen bg-gray-100">
           
            



            <div class="screen_height">
                @include('layouts.N_navigation')
                
                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset
                @include('layouts.navigation')
    
                <!-- Page Content -->
                {{ $slot }}
    
                @include('layouts.N_footer',[
                    'VarWebsiteNameLong' => $VarWebsiteNameLong,
                    'VarWebsitePhoneNumber' => $VarWebsitePhoneNumber,
                    'VarWebsiteEmail' => $VarWebsiteEmail,
                    'VarWebsiteLocation' => $VarWebsiteLocation])
            </div>
        </div>
    </body>
</html>

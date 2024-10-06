

<?php

$VarWebsiteNameShort = "Pcparts";
$VarWebsiteLogo = "/images/logo64.png";
?>

<nav class="navbar navbar-expand-lg navbar-light primary_background_color under_shadow  ">
    <a class="navbar-brand" href="{{ url('/') }}">
      <img class="medium_svg" src="{{ $VarWebsiteLogo }}" width="auto" height="auto" class="navigation-responsive-image d-inline-block " alt="">
      {{ $VarWebsiteNameShort }}
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="{{ url('/') }}">Home </a>
        </li>
        <li class="nav-item">
          <a class="nav-link"  href="{{ url('/specifications') }}">Specifications</a>
         </li>
        <li class="nav-item">
          <a class="nav-link"  href="{{ url('/categories') }}">Categories</a>
         </li>
       <li class="nav-item">
          <a class="nav-link"  href="{{ url('/category/all_items') }}">Category</a>
         </li>
         <li class="nav-item">
          <a class="nav-link"  href="{{ url('/create') }}">Create</a>
         </li>
         <li class="nav-item">
          <a class="nav-link"  href="{{ url('/rule') }}">rule</a>
         </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ url('/FAQ') }}">F.A.Q.</a>
        </li>
 
      </ul>
  
  
      <ul class="navbar-nav ml-auto">




        <li class="nav-item">
          <a class="nav-link" href="{{ url('/cart') }}">
            <div class="cart_svg_div" style="position: relative;">
              <svg class="extra_small_svg svg_nav cart_svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="position: relative;">
                <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                <g id="SVGRepo_iconCarrier">
                  <path d="M6.29977 5H21L19 12H7.37671M20 16H8L6 3H3M9 20C9 20.5523 8.55228 21 8 21C7.44772 21 7 20.5523 7 20C7 19.4477 7.44772 19 8 19C8.55228 19 9 19.4477 9 20ZM20 20C20 20.5523 19.5523 21 19 21C18.4477 21 18 20.5523 18 20C18 19.4477 18.4477 19 19 19C19.5523 19 20 19.4477 20 20Z" stroke-linecap="round" stroke-linejoin="round"/>
                </g>

                <!-- Add the number 6 in the top right -->
                <text class="cart_number" x="10" y="9" fill="grey" font-size="11" stroke="none" font-weight="bold">0</text>
              </svg>
              cart
            </div>
          </a>
        </li>
        
        
      @auth
  

        @else
        @endauth

        
  
        @if (Route::has('login'))
                @auth


                    <li class="nav-item">
                      <a class="nav-link" href="{{ url('/dashboard') }}">Dashboard</a>
                      
                    </li>
                    <li class="nav-item">
                      <form action="{{ route('logout') }}" method="POST">
                          @csrf
                          <button type="" class="btn btn-link nav-link">Logout</button>
                      </form>
                    </li>
                @else
                  <li class="nav-item">
                    <a class="nav-link" href="{{ url('/login') }}">Log in</a>
                  </li>


                    @if (Route::has('register'))
                        <li class="nav-item">
                          <a class="nav-link" href="{{ url('/register') }}">Register</a>
                        </li>
                    @endif
                @endauth
          
        @endif
        
      </ul>
    </div>
  </nav>








<!-- SEARCH FORM -->
<div class="container primary_background_color default_padding radius_bottom_5_px under_shadow search_bar">
    <div class="row ">
            <div class="col">
            <form action="/Main/Search/" method="post">
                @csrf
                <div class="input-group">
                <input type="search" class="form-control rounded" name="searchTerm" placeholder="Search"  aria-describedby="search-addon" />
                <div class="input-group-append">
                    <button type="submit" class="btn btn-outline-primary" >search</button>
                </div>
                </div>
            </form>
        </div>
    </div>
</div>



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
          <a class="nav-link"  href="{{ url('/category') }}">Category</a>
         </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ url('/FAQ') }}">F.A.Q.</a>
        </li>
 
      </ul>
  
  
      <ul class="navbar-nav ml-auto">


      @auth
  

        @else
        @endauth
        <li class="nav-item">
          <a class="nav-link" href="{{ url('/Profile') }}"></a>
        </li>
        
  
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

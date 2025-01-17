

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
          <a class="nav-link" href="{{ url('/') }}">{{ translate('Home') }} </a>
        </li>
        {{-- 
        <li class="nav-item">
          <a class="nav-link"  href="{{ url('/specifications') }}">Specifications</a>
         </li>--}}



       <li class="nav-item">
          <a class="nav-link"  href="{{ url('/category/all_items') }}">{{ translate('All Items') }}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ url('/FAQ') }}">{{ translate('F.A.Q.') }}</a>
        </li>
        @auth
          @if(auth()->user()->level >= 2)
        <li class="nav-item">
          <a class="nav-link"  href="{{ url('/categories') }}">{{ translate('Categories') }}</a>
        </li>         
        <li class="nav-item">
          <a class="nav-link"  href="{{ url('/create') }}">{{ translate('Create Item') }}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link"  href="{{ url('/rule') }}">{{ translate('Create Rule') }}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link"  href="{{ url('/users') }}">{{ translate('Users') }}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link"  href="{{ url('/orders-admin') }}">{{ translate('Orders') }}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link"  href="{{ url('/language/LT') }}">{{ translate('Language') }}</a>
        </li>
          @endif
        @endauth
        





        
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

                {{-- 
                                <text class="cart_number" x="10" y="9" fill="grey" font-size="11" stroke="none" font-weight="bold">0</text>

                --}}
              </svg>
            </div>
          </a>
        </li>
        


        <li class="nav-item">
          <div class="btn-group">
            <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <svg class="extra_small_svg svg_nav" viewBox="0 0 24 24" role="img" xmlns="http://www.w3.org/2000/svg" aria-labelledby="languageIconTitle" stroke="#000000" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" fill="none" color="#000000">

                  <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                  
                  <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                  
                  <g id="SVGRepo_iconCarrier"> <title id="languageIconTitle">{{ translate('Language') }}</title> <circle cx="12" cy="12" r="10"/> <path stroke-linecap="round" d="M12,22 C14.6666667,19.5757576 16,16.2424242 16,12 C16,7.75757576 14.6666667,4.42424242 12,2 C9.33333333,4.42424242 8,7.75757576 8,12 C8,16.2424242 9.33333333,19.5757576 12,22 Z"/> <path stroke-linecap="round" d="M2.5 9L21.5 9M2.5 15L21.5 15"/> </g>
                  
                  </svg>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
              <li class="nav-item">
                <a class="nav-link" href="" onclick="setLanguageCookie('LT')">LT</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="" onclick="setLanguageCookie('EN')">EN</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="" onclick="setLanguageCookie('PL')">PL</a>
            </li>


            <script>
              function setLanguageCookie(lang) {
                  document.cookie = `lang=${lang}; path=/; max-age=${60 * 60 * 24 * 30}`; // 30 days
                  window.location.reload();
              }
            </script>


            </ul>
          </div>
          </li>  


        
      @auth
      @else
      @endauth

        
  
        @if (Route::has('login'))
          @auth



              {{-- 
              <li class="nav-item">
                <a class="nav-link" href="{{ url('/dashboard') }}">Dashboard</a>
              </li>              
              --}}



            <li class="nav-item">
            <div class="btn-group">
              <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <svg class="extra_small_svg svg_nav" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">

                  <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                  
                  <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                  
                  <g id="SVGRepo_iconCarrier"> <path d="M8 7C9.65685 7 11 5.65685 11 4C11 2.34315 9.65685 1 8 1C6.34315 1 5 2.34315 5 4C5 5.65685 6.34315 7 8 7Z" /> <path d="M14 12C14 10.3431 12.6569 9 11 9H5C3.34315 9 2 10.3431 2 12V15H14V12Z"/> </g>
                  
                  </svg>
              </button>
              <ul class="dropdown-menu dropdown-menu-end">
                <li class="nav-item">
                  <a class="nav-link" href="{{ url('/profile') }}">{{ translate('Profile') }}</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ url('/orders') }}">{{ translate('Orders') }}</a>
                </li>
                <li class="nav-item">
                  <form action="{{ route('logout') }}" method="POST">
                      @csrf
                      <button type="" class="btn btn-link nav-link">{{ translate('Logout') }}</button>
                  </form>
                </li>
              </ul>
            </div>
            </li>  
              
          @else
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/login') }}">{{ translate('Log in') }}</a>
            </li>


              @if (Route::has('register'))
                  <li class="nav-item">
                    <a class="nav-link" href="{{ url('/register') }}">{{ translate('Register') }}</a>
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
            {{--
            <form action="/Main/Search/" method="post">
                @csrf
                <div class="input-group">
                <input type="search" class="form-control rounded" name="searchTerm" placeholder="Search"  aria-describedby="search-addon" />
                <div class="input-group-append">
                    <button type="submit" class="btn btn-outline-primary" >search</button>
                </div>
                </div>
            </form>
            --}}

              <div class="input-group">
                <input id="search_input" type="search" class="form-control rounded" name="searchTerm" placeholder="{{ translate('Search') }}" autocomplete="off" aria-describedby="search_addon" value="@if (request()->query('src')){{ request()->query('src') }}@endif" />
                <div class="input-group-append">
                    <button type="button" class="btn btn-outline-primary" id="search_button"  data-url="{{ url('category/all_items') }}">{{ translate('Search') }}</button>
                </div>
              </div>              


          
            <script>
              document.getElementById('search_button').addEventListener('click', function() {
                  let searchTerm = document.querySelector('input[name="searchTerm"]').value;
                  let baseUrl = this.getAttribute('data-url');
                  window.location.href = `${baseUrl}?src=${encodeURIComponent(searchTerm)}`;
              });

              // Submit on Enter key press
              document.getElementById('search_input').addEventListener('keydown', function(event) {
                  if (event.key === 'Enter') {
                      event.preventDefault(); // Prevent the default form submission (if needed)
                      document.getElementById('search_button').click(); // Trigger button click
                  }
              });
            </script>
        </div>
    </div>
</div>

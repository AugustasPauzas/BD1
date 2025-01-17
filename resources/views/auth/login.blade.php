@extends ('layouts.default_body')
@section('content')

<div class="container default_container_margin">
    <div class="row  secondary_background_color">
        <div class="col-4">

        </div>
        <div class="col-md-4  primary_background_color default_padding default_margin default_radius under_shadow">
            <p class="remain_center extra_big_padding_top">
                <img class="large_svg" src="/images/logo256.png"   class="  " alt="">
            </p>
            

            <form class="default_padding " method="POST" action="{{ route('login') }}">
                @csrf
            
                <!-- Email Address -->
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __(translate("Email")) }}</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                    @error('email')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            
                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">{{ __(translate("Password")) }}</label>
                    <input type="password" class="form-control" id="password" name="password" required autocomplete="current-password">
                    @error('password')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            
                <!-- Remember Me -->
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                    <label class="form-check-label" for="remember_me">{{ __(translate("Remember me")) }}</label>
                </div>
            
                <!-- Login and Forgot Password Links -->
                <div class="d-flex justify-content-end mt-4">
                    @if (Route::has('password.request'))
                        {{-- 
                        <a href="{{ route('password.request') }}" class="text-decoration-none text-muted me-3">
                            {{ __({{translate("Forgot your password?")}}) }}
                        </a>
                        --}}
                    @endif
                    <button type="submit" class="btn btn-primary">
                        {{ __(translate("Log in")) }}
                    </button>
                </div>
            </form>
            
        </div>
        <div class="col-3">

        </div>
    </div>

</div>



@endsection


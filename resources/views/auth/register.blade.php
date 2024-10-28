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
            
            <form class="default_padding " method="POST" action="{{ route('register') }}">
                @csrf
            
                <!-- Name -->
                <div class="mb-3 extra_big_padding_top">
                    <label for="name" class="form-label">{{ __('Name') }}</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
                    @error('name')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            
                <!-- Email Address -->
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autocomplete="username">
                    @error('email')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            
                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input type="password" class="form-control" id="password" name="password" required autocomplete="new-password">
                    @error('password')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            
                <!-- Confirm Password -->
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
                    @error('password_confirmation')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('login') }}" class="text-decoration-none text-muted me-4">
                        {{ __('Already registered?') }}
                    </a>
                    <button type="submit" class="btn btn-primary">
                        {{ __('Register') }}
                    </button>
                </div>
            </form>
            
        </div>
        <div class="col-3">

        </div>
    </div>

</div>



@endsection
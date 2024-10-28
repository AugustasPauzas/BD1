
@extends ('layouts.default_body')
@section('content')

<div class="container default_container_margin">
    <div class="row   secondary_background_color">

        <div class="col-md-12  primary_background_color default_padding default_margin default_radius under_shadow">
            <div class="default_padding no_margin_sides ">
                <h2 class="">
                    {{ __('Profile') }}
                </h2>

            </div>

            <br>
                
            <div class="row">
                <div class="col-md-6 ">
                    <div class="default_margin_sides default_padding">
                        @include('profile.partials.update-profile-information-form')

                    </div>

                </div>
                <div class="col-md-6 ">
                    <div class="default_margin_sides default_padding">
                        @include('profile.partials.update-password-form')

                    </div>

                </div>
            </div>
            <br>
            <br>
            <div class="default_margin_sides default_padding">
                @include('profile.partials.delete-user-form')

            </div>



        </div>
    </div>
</div>


@endsection


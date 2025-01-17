
@extends ('layouts.default_body')
@section('content')

<div class="container default_container_margin">
    <div class="row  secondary_background_color">
        <div class="col-3">

        </div>
        <div class="col-md-6  primary_background_color default_padding default_margin default_radius under_shadow">
            <br><br>
            <p>{{-- __('Dashboard') --}}</p>
            <p class="remain_center">{{ __(translate("You're logged in!")) }}</p>
            <br><br>
        </div>
        <div class="col-3">

        </div>
    </div>

</div>
@endsection


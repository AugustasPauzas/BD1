@extends ('layouts.default_body')
@section('content')

<script type="text/javascript" src="{{ asset('js/.js') }}"></script>

<div class="default_container_margin">
<div class="container">


<div class= "row no_margin primary_background_color default_padding default_margin default_radius under_shadow default_large_margin_bottom">

    <div class="col"> 
        @foreach ($language_data as $language)
            @if ($language->language != "EN")
            <p class="d-inline"><a class="no_ancor_decoration" disable href="{{ url('/language/'.$language->language) }}"> <strong><span class="font_120">{{$language->language}}</span></strong> </a></p>
            @endif
        @endforeach

        
    </div>
    
</div>

<div class= "row no_margin primary_background_color default_padding default_margin default_radius under_shadow default_large_margin_bottom">

    <div class="col"> 
        <div class="d-flex justify-content-start mb-3">
            <!-- Button to create a new translation -->
            <a href="{{ route('language', ['lang' => $lang]) }}" class="btn btn-success mr-2">{{translate("Create Translation")}}</a>
        
            <!-- Button to update a translation (you may need to adjust this to match your structure) -->
            <a href="{{ route('language-update', ['lang' => $lang]) }}" class="btn btn-primary">{{translate("Update Translation")}}</a>
        </div>
        

    </div>
</div>


<div class= "row no_margin primary_background_color default_padding default_margin default_radius under_shadow default_large_margin_bottom">
    <div class="col-4"> 
        <strong>{{ translate('English Text') }}</strong>
        <br>
        <br>
    </div>
    <div class="col-4"> 
        <strong>
            {{ translate('Translation') }}
        </strong>

    </div>
    <div class="col-2"> 
        <strong>
            {{ translate('Status') }}
        </strong>

    </div>
    <div class="col-2"> 


    </div>

    @foreach ($translation_data as $lang)
    <div class="row">
        <div class="col-4"> 
            <p>
                {{$lang->original_text}}
            </p>
            
            
        </div>
        <div class="col-4"> 

            <form action="{{ route('update_translation', $lang->id) }}"  method="POST">
                @csrf
                <textarea name="translated_text" class="form-control" placeholder="{{translate("Enter translation")}}" rows="2">{{ $lang->translated_text }}</textarea>


            

        </div>
        <div class="col-2"> 
    
            <p>
                @switch($lang->status)
                    @case(0)
                    {{ translate('Waiting Translation') }}
                        @break
                    @case(1)
                    {{ translate('Translated') }}
                        @break
                    @default
                    {{ translate('Unknown Status') }}
                @endswitch
            </p>
            

        </div>
        <div class="col-2"> 

                <button type="submit" class="btn btn-primary mt-2">
                    {{ translate('Translate') }}
                </button>
            </form>
        </div>
        <hr>
    </div>

    
    @endforeach
    
</div>




</div>
</div>


@endsection
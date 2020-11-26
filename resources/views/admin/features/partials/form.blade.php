<features-component
    method="@if(isset($feature->id)) PUT @else POST @endif"
    url=" @if(isset($feature->id))
         {{route('admin.features.update', $feature)}}
        @else
         {{route('admin.features.store')}}
        @endif"
    values="{{$feature->values ?? ''}}"
    feature="{{$feature ?? ''}}"
></features-component>


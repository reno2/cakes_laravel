
@foreach($attrs as $attr_id => $value)
    @foreach($value as $d => $e)

        {{$e}}
    @endforeach

@endforeach
{{--@if($data)--}}
{{--    <div class="menu classic">--}}
{{--        <ul id="nav" class="menu">--}}
{{--            @foreach($data as $item)--}}
{{--           {{dd($item)}}--}}
{{--            @endforeach--}}
{{--        </ul>--}}
{{--    </div>--}}
{{--@endif--}}

@extends('layouts.profile')

@section('content')

@if(isset($ads))
    @include('profile.ads.edit')
@else
    @include('profile.ads.create')
@endif
@stop

{{--Тут подключаем нужные стили и скрипты для шаблонов форм--}}
@section('page-script')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/i18n/ru.js"></script>
  <script>
      $(document).ready(function () {
             let $select2 = $('#tags').select2({
                 language: "ru",
                 maximumSelectionLength: 2
             })
      })
      @isset($ads->id)
      $('#tags').select2().val({!! json_encode($ads->tags()->allRelatedIds()) !!}).trigger('change');
      @endisset
    </script>
  <script src="{{ asset('js/js_forms.js')}}"></script>
  <script src="{{ asset('js/validate.js')}}"></script>
  <link href="{{ asset('css/forms.css')}}" rel="stylesheet">
@stop
<style>
    .hide{
        display: none;
    }
</style>




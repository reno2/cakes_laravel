
@if (Auth::check())
    @include('forms.form_question')
@else
    @include('forms.form_offer')
@endif
@yield('forms')



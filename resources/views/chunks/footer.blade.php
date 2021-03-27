@if (Auth::check())
    @include('forms.form')
@else
    @include('forms.form_offer')
@endif

@if(Auth::id())
    @include('forms.form')
@else
    @include('forms.form_offer')
@endif

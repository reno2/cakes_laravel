@extends('layouts.profile')

@section('content')

        <h3 class="card-header_">Изменить пароль</h3>
        <div class="ui-card">
            <div class="ui-card__body">
                @include("forms.form_secure_profile")

        </div>
    </div>
@endsection

@section('page-script')
    <script src="{{asset('js/forms.js')}}"></script>
@endsection

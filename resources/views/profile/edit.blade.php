@extends('layouts.profile')
@section('content')
                <h3>Редактировать профиль</h3>
                <div class="card_ ui-card">
                    <div class="ui-card__body">
                        @include("forms.form_edit_profile")
                    </div>
                </div>

@endsection

@section('page-script')
    <script src="{{asset('js/forms.js')}}"></script>
@endsection

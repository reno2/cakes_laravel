@extends('layouts.profile')
@section('content')
                <h3>Редактировать профиль</h3>
                <div class="card_ ui-card">

                    <div class="ui-card__body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (session('danger'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('danger') }}
                            </div>
                        @endif

                        @include("forms.form_edit_profile")


                    </div>
                </div>

@endsection

@section('page-script')
    <script src="{{asset('js/forms.js')}}"></script>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Требуется подтверждение по почте
                </div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            Новая ссылка отправлена на Вашу почту
                        </div>
                    @endif

                        Для продолжения, перейтиде по ссылке которая отправлена на Вашу почту.<br><br>
                   Для повторной отправки ссылки<br><br>
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn-small btn-main btn-big">Отправить</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

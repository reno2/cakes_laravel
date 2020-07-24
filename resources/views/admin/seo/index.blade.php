@extends('admin.layouts.app_admin')


@section('content')


    @component('admin.components.breadcrumb')
        @slot('title') Список категорий @endslot
        @slot('parents') Главная @endslot
        @slot('active') Категории @endslot
    @endcomponent





@endsection




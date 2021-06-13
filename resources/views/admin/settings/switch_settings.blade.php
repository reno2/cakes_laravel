@extends('admin.layouts.app_admin')
@if($parameter)
    @include('admin.settings.edit')
@else
    @include('admin.settings.create')
@endif

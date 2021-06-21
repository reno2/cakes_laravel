@extends('admin.layouts.app_admin')
@if($user)
    @include('admin.users.edit')
@else
    @include('admin.users.create')
@endif
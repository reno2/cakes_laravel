@extends('admin.layouts.app_admin')


@section('content')

    @php $parents = [];
                $parents[] = ['link' => route('admin.index'), 'title' => 'Главная'];
                $parents[] = ['link' => route('admin.users.index'), 'title' => 'Пользователи'];
    @endphp

    @component('admin.components.breadcrumb', ['parents'=>$parents])
        @slot('title') Редактирование категории @endslot
        {{--            @slot('parent') Главная @endslot--}}
        @slot('active') Редактирование @endslot
    @endcomponent
    <div class="row">

        <div class="col-sm-9">
            <form сlass="form-horizontal" id="aform" action="{{route('admin.users.update', $user)}}" method="post">
                <input type="hidden" name="_method" value="put">
                {{csrf_field()}}
                <div class="form-group">
                    <div class="row mb-4">
                        <div class="col">
                            <label for="email">Дата создания</label>
                            <br>
                            <span>{{$user->created_at}}</span>
                        </div>
                        <div class="col">
                            <label for="email">Дата изменения</label>
                            <br>
                            <span>{{$user->updated_at}}</span>
                        </div>
                    </div>

                    <div class="form-group form-check">
                        <input name="is_admin" value="0" type="hidden">
                        <input value="1" type="checkbox" @if(isset($user->is_admin) && $user->is_admin == true) checked
                               @endif name="is_admin" class="form-check-input" id="is_admin">
                        <label class="form-check-label" for="is_admin">Администратор</label>
                    </div>

                    <div class="form-group">
                        @if($user->email_verified_at)
                            <div class="form-group__text">Пользователь подтверждён</div>
                        @else
                            <div class="form-group__text">Пользователь не подтверждён</div>
                            <label for="email_verified_at">Подтвердить</label>
                            <input name="email_verified_at" type="checkbox" value="{{\Carbon\Carbon::now()->format('Y-m-d H:i:m')}}">
                        @endif

                    </div>

                    <div class="form-group">
                        <label for="name">Имя</label>
                        <input type="text" name="name" class="form-control" id="name"
                               value="{{($user->name)??old('name')}}">
                        @if($errors->has('name'))
                            <span class="help-block text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="phone">Телефон</label>
                        <input type="text" name="phone" class="form-control" id="phone"
                               value="{{($user->phone)??old('phone')}}">
                        @if($errors->has('phone'))
                            <span class="help-block text-danger">{{ $errors->first('phone') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="address">Адрес</label>
                        <input type="text" name="address" class="form-control" id="address"
                               value="{{($user->address)??old('address')}}">
                        @if($errors->has('address'))
                            <span class="help-block text-danger">{{ $errors->first('address') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="address" class="form-control" id="email"
                               value="{{($user->email)??old('email')}}">
                        @if($errors->has('email'))
                            <span class="help-block text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="address">Пароль</label>
                        <input disabled type="text" name="password" class="form-control" id="password"
                               value="{{($user->password)??old('password')}}">
                    </div>
                    <input type="submit" class="btn btn-block btn-primary" value="Изменить пользователя">
            </form>
        </div>
    </div>




@endsection


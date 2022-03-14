@section('content')


    <div class="info-cards">
        <div class="info-cards__row">
            @php $parents = [];
                $parents[] = ['link' => route('admin.index'), 'title' => 'Главная'];
                $parents[] = ['link' => route('admin.users.index'), 'title' => 'Пользователи'];
            @endphp
            @component('admin.components.breadcrumb', ['parents'=>$parents])
                @slot('title') Редактирование пользователя @endslot
                @slot('active') редактирование @endslot
            @endcomponent
        </div>
    </div>

    <div class="info-cards">
        <div class="info-cards__row">
            <div class="info-cards__cards">
                <div class="info-cards__block info-card_half">
                    <form
                            сlass="dashboard-form create-form"
                            action="{{route('admin.users.update', $user)}}"
                            method="post"
                            enctype="multipart/form-data"
                    >
                        <input type="hidden" name="_method" value="put">
                        {{csrf_field()}}

                        <div class="form-group">
                            <label for="created_at" class="form-group__placeholder  @error('created_at') onError @enderror">Дата создания</label>
                            <div class="form-group__inputs">
                                <input readonly type="text" name="created_at" class="form-group__input" id="created_at" value="{{ old('created_at') ?? ($user->created_at) ?? '' }}">
                                @error('created_at')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="updated_at" class="form-group__placeholder  @error('updated_at') onError @enderror">Дата изменения</label>
                            <div class="form-group__inputs">
                                <input readonly type="text" name="title" class="form-group__input" id="updated_at" value="{{ (old('updated_at')) ?? ($user->updated_at) ?? '' }}">
                                @error('updated_at')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="active" class="form-group__placeholder  @error('active') onError @enderror">Активен</label>
                            <div class="form-group__inputs">
                                <input name="active" value="0" type="hidden">
                                <input value="1" type="checkbox" @if(isset($user->active) && $user->active == true) checked
                                       @endif name="active" class="form-check-input" id="active">
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="is_admin" class="form-group__placeholder  @error('is_admin') onError @enderror">Администратор</label>
                            <div class="form-group__inputs">
                                <input name="is_admin" value="0" type="hidden">
                                <input value="1" type="checkbox" @if(isset($user->is_admin) && $user->is_admin == true) checked
                                       @endif name="is_admin" class="form-check-input" id="is_admin">
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="email_verified_at" class="form-group__placeholder  @error('email_verified_at') onError @enderror">Активен</label>
                            <div class="form-group__inputs">
                                <input name="email_verified_at" value="0" type="hidden">
                                <input value="1" type="checkbox" @if($user->email_verified_at)  checked  @endif
                                name="email_verified_at" class="form-check-input" id="email_verified_at">
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="email" class="form-group__placeholder  @error('email') onError @enderror">Почта</label>
                            <div class="form-group__inputs">
                                <input type="text" name="email" class="form-group__input" id="email" value="{{ (old('email')) ?? ($user->email) ?? '' }}">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="password" class="form-group__placeholder  @error('password') onError @enderror">Текущий пароль</label>
                            <div class="form-group__inputs">
                                <input type="text" name="password" class="form-group__input" id="current_password" value="{{ (old('password')) ??  '' }}">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="new_password" class="form-group__placeholder  @error('new_password') onError @enderror">Новый пароль</label>
                            <div class="form-group__inputs">
                                <input type="text" name="new_password" class="form-group__input" id="new_password" value="{{ (old('new_password')) ?? ($user->new_password) ?? '' }}">
                                @error('new_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="confirm_password" class="form-group__placeholder  @error('confirm_password') onError @enderror">Повторите пароль</label>
                            <div class="form-group__inputs">
                                <input type="text" name="confirm_password" class="form-group__input" id="new_password" value="{{ (old('confirm_password')) ?? ($user->confirm_password) ?? '' }}">
                                @error('confirm_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <hr>
                        <div class="form-group__actions form-group__single">
                            <div class="offset-md-4 col-md-8">
                                <input type="submit" class="btn-main btn-middle half" value="Создать запись">
                            </div>
                        </div>

                        <input name="image" type="file" value=""
                               class="js_fileInput js_file-loader__input js_user-image file-loader__hidden">

                        <input type="hidden" name="created_by" value="{{Auth::id()}}">

                    </form>
                </div>

                <div class="info-cards__block">
                    <div class="info-block">
                        <div class="info-block__name">Изображение</div>
                        <div class="info-block__data">
                            <div class="file-loader_one js_file-loader file-loader @error('image') onError @enderror">
                                <div class="file-loader__wrap js_thumbs" data-hash="">
                                    <div class="js_images-preview images-preview">
                                        @if(isset($user->image))
                                            <div class="js_images-preview__item images-preview__item">
                                                <img class="images-preview__img" src="{{$user->image}}" alt="">
                                                <div class="images-preview__bottom">
                                                    <span class="images-preview__name">{{File::name($user->image)}}.{{File::extension($user->image)}}</span>
                                                    <svg onclick="fileLoader.removeFromArray(this)"
                                                         data-name="${file.name}"
                                                         data-del-input="js_tag__del"
                                                         data-file-id="{{$user->imageId}}"
                                                         class="images-preview__del js_file-loader__del js_old__file">
                                                        <use xlink:href="/images/icons.svg#icon-close"></use>
                                                    </svg>
                                                </div>
                                            </div>

                                        @endif
                                    </div>

                                    <button
                                            data-validate=""
                                            data-rules='{"limit": "1", "size": "100000", "type": "jpeg"}'
                                            data-proxy="js_user-image"
                                            type="button"
                                            class="js_file-loader__proxy file-loader__proxy btn-middle btn-grey wide">Загрузить
                                    </button>

                                    <div class="create-form__error js_file-loader__error file-loader__error"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@if(false)
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
@endif





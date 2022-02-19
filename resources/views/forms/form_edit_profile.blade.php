<form method="POST" id="post-image" action="{{ route('profile.update', $profile) }}" class="create-form profile-change"
      enctype="multipart/form-data">
    <input type="hidden" name="_method" value="put">
    @csrf

    <fileinput-component has-avatar="{{($profile->image) ? 1 : 0}}" token="{{ csrf_token() }}" profile-id="{{$profile->id}}" img="{{($profile->image) ?? '/storage/images/defaults/cake.svg'}}"></fileinput-component>

    <div class="form-cell onFocus">
        <input id="name" type="text"
               class="form-cell__input @error('name') is-invalid @enderror" name="name"
               value="{{old('name', $profile->name)}}" required autofocus>
        <label class="form-cell__placeholder" for="">Имя</label>

        @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>


    <div class="form-cell onFocus">
        <input id="contact1" type="text"
               class="form-cell__input @error('contact1') is-invalid @enderror" name="contact1"
               value="{{old('contact1', $profile->contact1)}}">
        <label class="form-cell__placeholder" for="">Контакт 1</label>
        @error('address')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>


    <div class="form-cell onFocus">
        <input id="contact2" type="text"
               class="form-cell__input @error('contact2') is-invalid @enderror" name="contact2"
               value="{{ old('contact2', $profile->contact2) }}">
        <label class="form-cell__placeholder" for="">Контакт 2</label>
        @error('contact2')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <fileautocomplite-component
            value="{{ old('address', $profile->address) }}"
            message="@error('address') {{$message}} @enderror">
    </fileautocomplite-component>


    <div class="form-group row">
        <label class="col-md-4 col-form-label text-md-right" for="type">Тип
            профиля
        </label>
        <div class="col-md-6">
            <select name="type" class="form-control" id="type">
                @foreach ($profileTypes as $code=>$type)
                    <option value="{{$code}}" {{ old('name', $profile->type) == $code ? 'selected' : ''}} >{{$type}}</option>
                @endforeach
            </select>
            @error('type')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $type }}</strong>
            </span>
            @enderror
        </div>
    </div>


    <div class="form-group row mb-0">
        <div class="col-md-8 offset-md-4">
            <button type="submit" class="btn btn-primary">
                Изменить профиль
            </button>
        </div>
    </div>
</form>
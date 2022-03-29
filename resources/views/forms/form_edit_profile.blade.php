<form method="POST" id="post-image" action="{{ route('profile.update', $profile) }}" class="create-form profile-change"
      enctype="multipart/form-data">
    <input type="hidden" name="_method" value="put">
    @csrf

    <fileinput-component has-avatar="{{($profile->image) ? 1 : 0}}" token="{{ csrf_token() }}" profile-id="{{$profile->id}}" img="{{($profile->image) ?? '/storage/images/defaults/cake.svg'}}"></fileinput-component>

    <div class="form-group onFocus @error('name') onError @enderror">

        <label class="form-group__placeholder" for="">Имя</label>

        <div class="form-group__inputs">
            <input id="name" type="text"
                   class="form-group__input" name="name"
                   value="{{old('name', $profile->name)}}" required autofocus>
            @error('name')
            <span class="invalid-feedback" role="alert">
                {{ $message }}
            </span>
            @enderror
        </div>
    </div>


    <div class="form-group onFocus @error('contact1') onError @enderror">
        <label class="form-group__placeholder" for="">Контактный телефон</label>
        <div class="form-group__inputs">
            <input id="contact1" type="text"
                   class="form-group__input @error('contact1') is-invalid @enderror" name="contact1"
                   value="{{old('contact1', $profile->contact1)}}">

            @error('address')
            <span class="invalid-feedback" role="alert">
                {{ $message }}
            </span>
            @enderror
        </div>
    </div>


{{--    <div class="form-group onFocus  @error('contact2') onError @enderror">--}}
{{--        <label class="form-group__placeholder" for="">Контакт 2</label>--}}
{{--        <div class="form-group__inputs">--}}
{{--            <input id="contact2" type="text"--}}
{{--                   class="form-group__input @error('contact2') is-invalid @enderror" name="contact2"--}}
{{--                   value="{{ old('contact2', $profile->contact2) }}">--}}

{{--            @error('contact2')--}}
{{--            <span class="invalid-feedback" role="alert">--}}
{{--                <strong>{{ $message }}</strong>--}}
{{--            </span>--}}
{{--            @enderror--}}
{{--        </div>--}}
{{--    </div>--}}

    <fileautocomplite-component
            value="{{ old('address', $profile->address) }}"
            message="@error('address') {{$message}} @enderror">
    </fileautocomplite-component>

    <input type="hidden" name="type" value="person">

    <div class="form-group__actions form-group__single">
        <button type="submit" class="btn-main btn-middle half">
            Изменить профиль
        </button>
    </div>

</form>
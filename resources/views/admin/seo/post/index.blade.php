@extends('admin.layouts.app_admin')


@section('content')


    <div class="info-cards">
        <div class="info-cards__row">
            @php $parents = [];
                $parents[] = ['link' => route('admin.index'), 'title' => 'Главная'];
            @endphp

            @component('admin.components.breadcrumb', ['parents'=>$parents])
                @slot('title') SEO @endslot
                @slot('active') Seo для объявления @endslot
            @endcomponent
        </div>
    </div>

    <div class="info-cards">
        <div class="info-cards__row">
            <div class="info-cards__cards">
                <div class="info-cards__block info-card_half">
                    <form id="seometa" action="{{route('seo.post.update')}}" method='POST' class="dashboard-form create-form">
                        {{csrf_field()}}
                        <input type="hidden" name="type" value="post">
                        <input type="hidden" name="id" value="{{$post->id ?? ''}}">


                        <div class="form-group">
                            <label for="title" class="form-group__placeholder  @error('title') onError @enderror">Тег title для категории</label>
                            <div class="form-group__inputs">
                                <input type="text" name="title" class="form-group__input" id=title" value="{{$post->title ?? ''}}">
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="h1" class="form-group__placeholder  @error('h1') onError @enderror">Тег h1 для категории</label>
                            <div class="form-group__inputs">
                                <input type="text" name="h1" class="form-group__input" id="h1" value="{{$post->h1 ?? ''}}">
                                @error('h1')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="description" class="form-group__placeholder  @error('description') onError @enderror">Тег meta-description для категории</label>
                            <div class="form-group__inputs">
                                <textarea type="text" name="description" class="form-group__textarea" id="description">
                                    {{$post->description ?? ''}}
                                </textarea>
                                @error('description')
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


                    </form>
                </div>

                <div class="info-cards__block">

                    <div class="info-block">
                        <div class="info-block__name"> Значение по умолчанию</div>
                        <div class="info-block__data">
                            <ul class="back-sidebar__ul">
                                @foreach(config('seo') as $key => $seo)
                                    <li class="back-sidebar__li">#{{$key}}# - {{$seo}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





@endsection




@php
$querySting = '/?';
if(isset($_GET['page']) && !empty($_GET['page']) ):
$querySting = "/?page={$_GET['page']}";
endif;
@endphp

<div class="sorts info-cards">
        <div class="info-cards__line sorts__items">
            <span class="sorts__item">Сортирорвка:</span>
            <a class="sorts__item btn btn-small btn-grey" href="{{url()->current()}}{{$querySting}}moderate=desc">Модерации</a>
            <a class="sorts__item btn btn-small btn-grey" href="{{url()->current()}}{{$querySting}}published=desc">Опубликованно</a>
            <a class="sorts__item btn btn-small btn-grey" href="{{url()->current()}}{{$querySting}}on_front=desc">На главной</a>
            <a class="sorts__item btn btn-small btn-grey" href="{{url()->current()}}{{$querySting}}updated_at=desc">Дате изменения</a>
            <a class="sorts__item btn btn-small btn-main" href="{{route('admin.article.index')}}">Сбросить</a>
        </div>
</div>
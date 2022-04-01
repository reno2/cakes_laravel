@php
if(request()->request->all())
$querySting = '/?' .http_build_query( request()->request->all()  );



function checkIsActive($name){
    if(key_exists($name, $_GET)) return true;
    return false;
}
if(isset($_GET['page']) && !empty($_GET['page']) ):
$querySting = "/?page={$_GET['page']}";
endif;
@endphp



<div class="sorts info-cards">
        <div class="info-cards__line sorts__items">
            <span class="sorts__item">Сортирорвка:</span>
            <a class="sorts__item btn btn-small btn-grey @if(checkIsActive('moderate')) btn-secondary @endif" href="{{url()->current()}}{{$querySting}}moderate=desc">Модерации</a>
            <a class="sorts__item btn btn-small btn-grey @if(checkIsActive('published')) btn-secondary @endif" href="{{url()->current()}}{{$querySting}}published=desc">Опубликованно</a>
            <a class="sorts__item btn btn-small btn-grey @if(checkIsActive('on_front')) btn-secondary @endif" href="{{url()->current()}}{{$querySting}}on_front=desc">На главной</a>
            <a class="sorts__item btn btn-small btn-grey @if(checkIsActive('updated_at')) btn-secondary @endif" href="{{url()->current()}}{{$querySting}}updated_at=desc">Дате изменения</a>
            <a class="sorts__item btn btn-small btn-red @if(checkIsActive('with_deleted')) btn-secondary @endif" href="{{url()->current()}}?with_deleted=desc">Удалённые</a>
            <a class="sorts__item btn btn-small btn-main" href="{{route('admin.article.index')}}">Сбросить</a>
        </div>
</div>
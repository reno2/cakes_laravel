@if($flash = session('message'))
<div class="info info_admin">
    {{$flash}}
</div>
@endif
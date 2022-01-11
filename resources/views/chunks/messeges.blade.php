@if($flash = session('info'))
<div class="info info_admin">
    {{$flash}}
</div>
@endif

@if($flash = session('notice'))
    <script>
        iziToast.success({
            position: 'topRight',
            // title: 'Уведомление',
            timeout: 1500,
            message: "{{$flash}}"
        });
    </script>
@endif
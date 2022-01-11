

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

@if($flash = session('warning'))
    <script>
        iziToast.warning({
            position: 'topRight',
            timeout: 1500,
            message: "{{$flash}}"
        });
    </script>
@endif
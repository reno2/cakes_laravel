<div class="widget-users scrollbar">
    <div class="widget-users__inner">
        <div class="widget-users__title"></div>
        @if(!empty($data))
            <div class="widget-users__header">
                <div class="widget-users__tab">Имя</div>
                <div class="widget-users__tab">Email</div>
                <div class="widget-users__tab">Время создания</div>
                <div class="widget-users__tab">Источник</div>
            </div>

            <div class="widget-users__data">

                @foreach($data as $value)
                    <div class="widget-users__line">
                        <div class="widget-users__val">{{$value->name}}</div>
                        <div class="widget-users__val">{{$value->email}}</div>
                        <div class="widget-users__val">{{$value->created_at}}</div>
                        <div class="widget-users__val">{{$value->provider}}</div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="widget-list__empty">Данные отсутствуют</div>
        @endif
    </div>
</div>
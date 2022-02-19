<div class="widget-ads scrollbar">
    <div class="widget-ads__inner">
        <div class="widget-ads__title"></div>
        @if(!empty($data))
            <div class="widget-ads__header">
                <div class="widget-ads__tab">Название</div>
                <div class="widget-ads__tab">Описание</div>
                <div class="widget-ads__tab">Время создания</div>
            </div>

            <div class="widget-ads__data">

                @foreach($data as $value)
                    <div class="widget-ads__line">
                        <div class="widget-ads__val">{{$value->title}}</div>
                        <div class="widget-ads__val">{{Str::limit($value->description, 50, $end='..')}}</div>
                        <div class="widget-ads__val">{{$value->created_at}}</div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="widget-list__empty">Данные отсутствуют</div>
        @endif
    </div>
</div>
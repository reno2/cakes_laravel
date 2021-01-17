


<div class="nav-tabs-custom filters-group" id="filters">
    <ul class="nav nav-tabs" role="tablist">
        @php $i =1; @endphp

        @foreach($groups as $group_id => $group_item)
            <li class="nav-item">
                <a href="#tab_@php echo $group_id @endphp" data-toggle="tab" aria-expanded="true"
                   class="nav-link @if($i == 1) active @endif">
                    @php echo $group_item; @endphp
                </a>
            </li>
            @php $i++; @endphp
        @endforeach
        <li class="pull-right ml-auto">
            <a href="#" id="reset-filter">Сброс</a>
        </li>
    </ul>
    <div class="tab-content filters-group__content">
        @if(!empty($attrs[$group_id]))
            @php $i =1; @endphp
            @foreach($groups as $group_id => $group_item)
                <div class="fade tab-pane @if($i == 1) active show @endif" id="tab_@php echo $group_id; @endphp"
                     role="tab-panel">
                    @foreach($attrs[$group_id] as $attr_id => $value)
                        @if(!empty($filter) && in_array($attr_id, $filter))
                            @php $checked = ' checked'; @endphp
                        @else
                            @php $checked = null; @endphp
                        @endif

                        <div class="form-group filters-group__item">
                                <input id="{{$attr_id}}"
                                       class="filters-group__input"
                                       type="radio"
                                       name="attrs[@php echo $group_id; @endphp]"
                                       value="@php echo $attr_id; @endphp"
                                    @php echo $checked; @endphp
                                >
                            <label for="{{$attr_id}}" class="filters-group__label">{{$value}}</label>
                        </div>
                        @php $i++; @endphp
                    @endforeach
                </div>
            @endforeach
        @endif
    </div>

</div>


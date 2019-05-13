<div class="c-menu">
    <div class="c-menu__wrap">
        <ul>
            @foreach(\App\Models\Menu::where('active',1)->where('parent_id',0)->get() as $menu)
                @php $subs = \App\Models\Menu::where('active',1)->where('parent_id',$menu->id)->get() @endphp
                @if(count($subs))
                    <li class="c-menu__drop-li"><a href="{{$menu->url ? $menu->url : '#'}}" class="c-menu__drop-ref">{{$menu->title}}</a>
                        <div class="c-menu__drop-container">
                            <ul>
                                @foreach($subs as $sub)
                                    <li><a href="{{$sub->url ? $sub->url : '#'}}" target="{{$sub->target}}">{{$sub->title}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                @else
                    <li class="c-menu__non-drop-li"><a href="{{$menu->url ? $menu->url : '#'}}" target="{{$menu->target}}">{{$menu->title}}</a></li>
                @endif
            @endforeach
        </ul>
    </div>
</div>
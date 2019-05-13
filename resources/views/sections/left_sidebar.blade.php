<div class="left-aside">
    <ul>
        @foreach(\App\Models\LeftMenu::where('active', 1)->get() as $menu)
        <li>
            <a href="{{$menu->url}}" target="{{$menu->target}}">
                <div class="left-aside__img">
                    <img src="{{$menu->img }}" />
                </div>
                <div class="left-aside__txt">
                    <span>{{$menu->title}}</span>
                </div>
            </a>
        </li>
        @endforeach
    </ul>
</div>
<div class="left-aside__small">
    <ul>
        @foreach(\App\Models\LeftMenu::where('active', 1)->get() as $menu)
            <li>
                <a href="{{$menu->url}}" target="{{$menu->target}}">
                    <div class="left-aside__img">
                        <img src="{{$menu->img }}" />
                    </div>
                </a>
            </li>
        @endforeach
    </ul>
</div>
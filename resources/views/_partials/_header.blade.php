<div class="c-menu">
    <div class="c-menu__wrap">
        <ul>
            @foreach($mainMenu as $menu)
                <li class="{{$menu->is_dropdown == 1?'c-menu__drop-li':'c-menu__non-drop-li'}}"><a
                            @if($menu->is_dropdown == 1) href="#" class="c-menu__drop-ref" @else href="{{$menu->url}}"
                            @endif href="{{$menu->is_dropdown == 1?'#':$menu->url}}">{{$menu['title_'.LaravelLocalization::getCurrentLocale()]}}</a>
                    @if($menu->is_dropdown == 1 && count($menu->subMenus))
                        <div class="c-menu__drop-container">
                            <ul>
                                @foreach($menu->subMenus as $item)
                                    <li><a href="{{$item->url}}">{{$item['title_'.LaravelLocalization::getCurrentLocale()]}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>

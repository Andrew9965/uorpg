<header class="c-header js-header">
    <div id="up" class="c-header__top">
        <div class="c-header__lang-panel">
            @php
                $segments = request()->segments();
                if(isset($segments[0]) && in_array($segments[0], config('app.locales'))) unset($segments[0]);
            @endphp
            <div class="c-header__lang-icon">
                <a href="{{asset(implode('/' ,array_merge(['en'], $segments)).(count(request()->all()) ? '?'.http_build_query(request()->all()) : ''))}}">
                    <span>english</span>
                    <div class="c-header__lang-img-en"></div>
                </a>
            </div>
            <div class="c-header__lang-icon">
                <a href="{{asset(implode('/' ,array_merge(['ru'], $segments)).(count(request()->all()) ? '?'.http_build_query(request()->all()) : ''))}}">
                    <div class="c-header__lang-img-ru"></div>
                    <span>русский</span>
                </a>
            </div>
        </div>
        <div class="c-header__social-panel">

            @foreach(\App\Models\Socials::where('active', 1)->where('show_header', 1)->get() as $soc)
            <div class="c-header__social-icon">
                <a href="{{$soc->url}}" target="{{$soc->target}}" title="{{$soc->title}}">
                    <div class="c-header__social-img">
                        <img src="{{asset($soc->img_header)}}" alt="{{$soc->title}}"/>
                    </div>
                </a>
            </div>
            @endforeach

        </div>
    </div><a href="/" class="c-header__logo"></a>
</header>
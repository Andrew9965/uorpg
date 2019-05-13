<header class="c-header js-header">
    <div id="up" class="c-header__top">
        <div class="c-header__lang-panel">
            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                <div class="c-header__lang-icon"><a
                            href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                            hreflang="{{ $localeCode }}"><span>{{ $properties['native'] }}</span>
                        <div class="c-header__lang-img-{{ $localeCode }}"></div>
                    </a></div>
            @endforeach

            {{--<div class="c-header__lang-icon"><a href="#">--}}
                    {{--<div class="c-header__lang-img-ru"></div>--}}
                    {{--<span>русский</span></a></div>--}}
        </div>
        <div class="c-header__social-panel">
            <div class="c-header__social-icon"><a href="#">
                    <div class="c-header__social-img-yt"></div>
                </a></div>
            <div class="c-header__social-icon"><a href="#">
                    <div class="c-header__social-img-tw"></div>
                </a></div>
            <div class="c-header__social-icon"><a href="#">
                    <div class="c-header__social-img-fb"></div>
                </a></div>
            <div class="c-header__social-icon"><a href="#">
                    <div class="c-header__social-img-vk"></div>
                </a></div>
            <div class="c-header__social-icon"><a href="#">
                    <div class="c-header__social-img-dc"></div>
                </a></div>
        </div>
    </div>
    <a href="#" class="c-header__logo"></a>
</header>
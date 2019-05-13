<div class="c-footer">
    <div class="c-footer__left">
        <div class="c-footer__logo"><img src="{{asset('s/images/useful/footer/copyright_logo.png')}}"/></div>
        <div class="c-footer__text">
            <h3>Copyright © 2008 - {{date('Y')}}  UORPG.NET</h3>
            <p>{{trans('footer.copyright')}}</p>
        </div>
    </div>

    <div class="c-footer__right">
        <div class="c-footer__social-panel">

            @foreach(\App\Models\Socials::where('active', 1)->where('show_footer', 1)->get() as $soc)
            <div class="c-footer__social-icon">
                <a href="{{$soc->url}}" target="{{$soc->target}}" title="{{$soc->title}}">
                    <div class="c-footer__social-icon-img">
                        <img src="{{asset($soc->img_footer)}}" alt="{{$soc->title}}"/>
                    </div>
                </a>
            </div>
            @endforeach

        </div>
    </div>

    <a href="#up" class="c-footer__up">
        <div class="c-footer__up-img"></div>
        <span>{{trans("footer.up")}}</span>
    </a>
</div>
<div class="right-aside">

    <div class="right-aside__services">
        <h3>{{trans('right-aside.services')}}</h3>
        <button type="button" data-toggle="modal" data-target="#modal-account">
            <div class="right-aside__services-item up-item">
                <div class="right-aside__services-item-img"><i class="ico ico-email"></i></div><span>{{trans('right-aside.email_bind')}}</span>
            </div>
        </button>
        <button type="button" data-toggle="modal" data-target="#modal-recovery">
            <div class="right-aside__services-item down-item">
                <div class="right-aside__services-item-img"><i class="ico ico-key"></i></div><span>{{trans('right-aside.vosstanovlenie_parolya')}}</span>
            </div>
        </button>
    </div>


    @foreach(\App\Models\RightMenu::where('active', 1)->get() as $menu)
        <a href="{{$menu->url}}" target="{{$menu->target}}" class="right-aside__download">
            <div class="right-aside__download-img">
                <img src="{{$menu->img}}" style="max-width: 64px" />
            </div>
            <span>{{$menu->title}}</span>
        </a>
    @endforeach

    {{--<a href="/files" class="right-aside__download">
        <div class="right-aside__download-img"><i class="ico ico-download"></i></div><span>{{trans('right-aside.download_file')}}</span>
    </a>

    <a href="#" class="right-aside__donat">
        <div class="right-aside__donat-img"><i class="ico ico-donat"></i></div><span>{{trans('right-aside.donat')}}</span>
    </a>--}}

    <div class="right-aside__forum">
        <h3>{{trans('right-aside.novye_temy')}}</h3>
{{--        {{dump(\App\Forum\Topics::orderBy('topic_last_post_time', 'desc')->take(7)->get())}}--}}
        {{--@foreach(\App\Models\ForumNewThemes::where('active', 1)->limit(7)->orderBy('created_at', 'desc')->get() as $new)--}}
        @foreach(\App\Forum\Topics::orderBy('topic_last_post_time', 'desc')->whereIn('forum_id', explode(',', config('show.forums.'.App::getLocale())))->take(7)->get() as $new)
            <a href="{{trim(config('default.forum.url'), '/')}}/viewtopic.php?t={{$new->topic_id}}" target="_blank">
                <div class="right-aside__forum-ttl"><span>{{$new->topic_title}}</span></div>
                <div class="right-aside__forum-info">
                    <time>{{\App\Libs\DateFormat::post(date('Y-m-d H:i:s', $new->topic_last_post_time))}}</time><span>{{$new->topic_first_poster_name}}</span>
                </div>
            </a>
            {{--<a href="{{$new->forum_link}}" target="_blank">--}}
                {{--<div class="right-aside__forum-ttl"><span>{{$new->title}}</span></div>--}}
                {{--<div class="right-aside__forum-info">--}}
                    {{--<time>{{\App\Libs\DateFormat::post($new->created_at)}}</time><span>{{$new->author}}</span>--}}
                {{--</div>--}}
            {{--</a>--}}
        @endforeach
    </div>

    <div class="right-aside__parnters">
        <div class="right-aside__parnters-container">
            <h3>{{trans('right-aside.partnery')}}</h3>
            <div class="right-aside__parnters-refs">
                @foreach(\App\Models\Partners::where('active',1)->get() as $p)
                <a @if($p->link) href="{{$p->link}}" target="{{$p->target}}" @endif >
                    <img src="{{$p->img}}" alt="{{$p->alt}}" title="{{$p->title}}" style="/*min-width: 106px*/"/>
                </a>
                @endforeach
            </div>
        </div>
    </div>
    @if(config('cabinet'))
    <div class="right-aside__personal-enter">
        <h3>{{trans('right-aside.personal_account')}}</h3>
        <div class="right-aside__personal-enter-login">
            <form class="form-container">
                <div class="form-group">
                    <div class="input-wrap">
                        <input type="text" value="" required="required" class="form-control my-form-custom"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-wrap">
                        <input type="password" value="" required="required" class="form-control my-form-custom"/>
                    </div>
                </div>
                <div class="right-aside__personal-enter-login-btn">
                    <button type="submit" class="enter">{{trans('right-aside.vkhod')}}</button>
                    <button type="button" class="password_rem">{{trans('right-aside.zabyli_parol')}}</button>
                </div>
            </form>
        </div>
        <div class="right-aside__personal-enter-reg">
            <button type="button">{{trans('right-aside.create_account')}}</button>
        </div>
    </div>
    @endif

    <div class="right-aside__empty"></div>
</div>
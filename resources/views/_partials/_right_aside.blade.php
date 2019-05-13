<div class="right-aside">
    <div class="right-aside__services">
        <h3>@lang('right-aside.services')</h3>
        <button type="button" data-toggle="modal" data-target="#modal-account">
            <div class="right-aside__services-item up-item">
                <div class="right-aside__services-item-img"><i class="ico ico-email"></i></div>
                <span>@lang('right-aside.email_bind')</span>
            </div>
        </button>
        <button type="button" data-toggle="modal" data-target="#modal-recovery">
            <div class="right-aside__services-item down-item">
                <div class="right-aside__services-item-img"><i class="ico ico-key"></i></div>
                <span>@lang('auth.reset_password ')</span>
            </div>
        </button>
    </div>
    <a href="#" class="right-aside__download">
        <div class="right-aside__download-img"><i class="ico ico-download"></i></div>
        <span>@lang('right-aside.download_file')</span></a><a href="#" class="right-aside__donat">
        <div class="right-aside__donat-img"><i class="ico ico-donat"></i></div>
        <span>@lang('right-aside.donat')</span></a>
    @include('_partials._block._theme')
    <div class="right-aside__personal-enter">
        <h3>@lang('right-aside.personal_account')</h3>
        @if(auth()->guest())
            <div class="right-aside__personal-enter-login">
                <form class="form-container" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <div class="input-wrap">
                            <input type="email" value="{{ old('email') }}" required="required" name="email"
                                   class="form-control my-form-custom{{ $errors->has('email') ? ' is-invalid' : '' }}"/>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-wrap">
                            <input type="password" name="password" required="required"
                                   class="form-control my-form-custom{{ $errors->has('password') ? ' is-invalid' : '' }}"/>
                            @if ($errors->has('password'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="right-aside__personal-enter-login-btn">
                        <button type="submit" class="enter">@lang('auth.enter')</button>
                        <a href="{{ route('password.request') }}">
                            <button type="button" class="password_rem">@lang('auth.lost_password')</button>
                        </a>
                    </div>
                </form>
            </div>
            <div class="right-aside__personal-enter-reg">
                <button type="button">@lang('right-aside.create_account')</button>
            </div>
        @else
            <div class="right-aside__personal-enter-login">
                <span>Hi, {{auth()->user()->name}}</span><br>
                <div class="right-aside__personal-enter-login-btn">
                    <button href="{{ route('logout') }}" type="submit" class="enter" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">@lang('auth.exit')</button>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                          style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
        @endif

    </div>
    <div class="right-aside__empty"></div>
</div>
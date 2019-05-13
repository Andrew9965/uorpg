@if (count($errors) > 0)
    <div id="modal-errors" tabindex="-1" role="dialog" class="modal fade modal-account modal_centered">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <form>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><i class="ico ico-modal-close"></i></button>
                    <h5>Error</h5>
                    <div class="modal-form-wrap">
                        <ul class="mark-list">
                            @foreach ($errors->all() as $error)
                                <li class="_error" style="color: #9c9273;">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        $(function(){
            var timer = setTimeout(function(){
                $('#modal-errors').modal('show');
                clearTimeout(timer);
            },800);
        });
    </script>
    @endpush
@endif
@if (session('status'))
    <div id="modal-messages" tabindex="-1" role="dialog" class="modal fade modal-account modal_centered">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <form>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><i class="ico ico-modal-close"></i></button>
                    <h5>{{session('status')}}</h5>
                    <div class="modal-form-wrap">
                        <ul class="mark-list">
                            @if(is_array(session('message')))
                                @foreach (session('message') as $mess)
                                    <li {{session('status')=='success' ? '' : 'class="_error"'}} style="color: #9c9273;">{{ $mess }}</li>
                                @endforeach
                            @else
                                <li {{session('status')=='success' ? '' : 'class="_error"'}} style="color: #9c9273;">{{session('message')}}</li>
                            @endif
                        </ul>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        $(function(){
            var timer = setTimeout(function(){
                $('#modal-messages').modal('show');
                clearTimeout(timer);
            },800);
        });
    </script>
    @endpush
@endif


<div id="modal-account" tabindex="-1" role="dialog" class="modal fade modal-account modal_centered">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('regmail')}}" method="POST">
                {{csrf_field()}}
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><i class="ico ico-modal-close"></i></button>
                <h5>{{trans("modal.privyazka_igrovogo_akkaunta_k_elektronnoy_pochte")}}</h5>
                <p>
                    {{trans("modal.att")}}
                </p>
                <div class="modal-form-wrap">
                    <div class="modal-form-left">
                        <div class="form-group">
                            <label for="modal-account-login">{{trans("modal.login")}}:</label>
                            <div class="input-wrap">
                                <input type="text" value="" name="login" required="required" id="modal-account-login" class="form-control my-form-custom"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="modal-account-password">{{trans("modal.parol")}}:</label>
                            <div class="input-wrap">
                                <input type="password" value="" name="password" required="required" id="modal-account-password" class="form-control my-form-custom"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="modal-account-email">Email:</label>
                            <div class="input-wrap">
                                <input type="email" value="" name="email" required="required" id="modal-account-email" class="form-control my-form-custom"/>
                            </div>
                        </div>
                    </div>
                    <div class="modal-form-right">
                        <div class="form-group">
                            <label for="modal-account-textarea">{{trans("modal.otkuda_vy_uznali_o_servere")}}</label>
                            <div class="input-wrap">
                                <textarea required="required" id="modal-account-textarea" name="from" class="form-control my-form-custom"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="smt-btn">{{trans("modal.privyazat")}}</button>
                <span class="decor-frame-left"></span><span class="decor-frame-right"></span>
            </form>
        </div>
    </div>
</div>

<div id="modal-recovery" tabindex="-1" role="dialog" class="modal fade modal-recovery modal_centered">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><i class="ico ico-modal-close"></i></button>
            <h5>{{trans("modal.vosstanovlenie_parolya")}}</h5>
            <p>
                {{trans("modal.att2")}}
            </p><span>{{trans("modal.ukazhite_svoy_login_na_servere")}}</span>
            <form method="post" action="{{route('re_password')}}">
                {{csrf_field()}}
                <div class="modal-form-wrap">
                    <div class="form-group">
                        <label for="modal-recovery-login">{{trans("modal.login")}}:</label>
                        <div class="input-wrap">
                            <input type="text" value="" name="login" required="required" id="modal-recovery-login" class="form-control my-form-custom"/>
                        </div>
                    </div>
                </div>
                <button type="submit" class="smt-btn">{{trans("modal.vosstanovit")}}</button>
            </form><span class="decor-frame-left"></span><span class="decor-frame-right"></span>
        </div>
    </div>
</div>
<div id="modal-account" tabindex="-1" role="dialog" class="modal fade modal-account modal_centered">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <form>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><i class="ico ico-modal-close"></i></button>
                <h5>Привязка игрового аккаунта к электронной почте</h5>
                <p>
                    Внимание! Для обеспечения максимальной безопасности аккаунтов, смена электронной почты,
                    к которой привязан аккаунт, НЕ предусмотрена. В спорных ситуациях аккаунт считается
                    принадлежащим тому, кому принадлежит электронная почта, к которой этот аккаунт привязан.
                </p>
                <div class="modal-form-wrap">
                    <div class="modal-form-left">
                        <div class="form-group">
                            <label for="modal-account-login">Логин:</label>
                            <div class="input-wrap">
                                <input type="text" value="" required="required" id="modal-account-login" class="form-control my-form-custom"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="modal-account-password">Пароль:</label>
                            <div class="input-wrap">
                                <input type="password" value="" required="required" id="modal-account-password" class="form-control my-form-custom"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="modal-account-email">Email:</label>
                            <div class="input-wrap">
                                <input type="email" value="" required="required" id="modal-account-email" class="form-control my-form-custom"/>
                            </div>
                        </div>
                    </div>
                    <div class="modal-form-right">
                        <div class="form-group">
                            <label for="modal-account-textarea">Откуда вы узнали о сервере?</label>
                            <div class="input-wrap">
                                <textarea required="required" id="modal-account-textarea" class="form-control my-form-custom"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" data-dismiss="modal" class="smt-btn">привязать</button><span class="decor-frame-left"></span><span class="decor-frame-right"></span>
            </form>
        </div>
    </div>
</div>

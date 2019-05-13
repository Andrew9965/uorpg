<?php

namespace Modules\Home\Http\Controllers\Traits;

use App\Accaunts;
use Carbon\Carbon;
use Illuminate\Http\Request;

trait RePassword {

    public function re_password(Request $request)
    {
        if(!$request->login)
            return back()->with(['status' => 'error', 'message' => 'Not found login field!']);

        $acc = Accaunts::where('LOGIN', $request->login)->where('EMAIL_ACTIVATED', 1)->first();
        if(!$acc)
            return back()->with(['status' => 'error', 'message' => trans("mail_re_password.user_not_found")]);

        $dt = (new Carbon($acc->NEW_PASSWORD_DATE))->addDay();

        if($acc->NEW_PASSWORD_DATE && $dt > now())
            return back()->with(['status' => 'error', 'message' => trans("mail_re_password.max_password_day")]);

        $newPassword = str_random(rand(8, 16));
        $this->setPassword($request, $acc, $newPassword);

        return back()->with(['status' => 'success', 'message' => trans("mail_re_password.confirm_mail")]);
    }

    public function setPassword(Request $request, $acc, $newPassword)
    {
        session(['newPassword' => $newPassword]);
        $acc->update([
            'NEED_PASS_UPDATE' => 1,
            'ACTIV_CODE' => str_random(rand(25, 32)),
        ]);
        $this->sendMailReset($acc);
    }

    public function sendMailReset($acc)
    {
        $message = config('mail.re_password.body.'.\App::getLocale());
        foreach (collect($acc)->toArray() as $key => $val) $message = str_replace('{'.$key.'}', $val, $message);
        $message = str_replace('{ACTIVE_LINK}', route('RESET.CODE', ['CODE' => $acc->ACTIV_CODE]), $message);

        $headers = 'MIME-Version: 1.0' . "\r\n" .
            'Content-type: text/html; charset=utf-8' . "\r\n" .
            'From: ' . config('mail.admin.from') . "\r\n" .
            'Reply-To: ' . config('mail.admin.reply_to') . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        return mail($acc->EMAIL, trans("mail_re_password.subject"), $message, $headers);
    }

    public function RESET($CODE, Request $request)
    {
        $newPassword = session('newPassword');
        $result = Accaunts::where('ACTIV_CODE', $CODE)->where('EMAIL_ACTIVATED', 1)->where('NEED_PASS_UPDATE', 1)->firstOrfail();
        $result->update([
            'NEW_PASSWORD' => $newPassword,
            'NEW_PASSWORD_DATE' => now(),
            'NEED_PASS_UPDATE' => 2
        ]);

        $message = config('mail.new_password.body.'.\App::getLocale());
        foreach (collect($result)->toArray() as $key => $val) $message = str_replace('{'.$key.'}', $val, $message);

        $headers = 'MIME-Version: 1.0' . "\r\n" .
            'Content-type: text/html; charset=utf-8' . "\r\n" .
            'From: ' . config('mail.admin.from') . "\r\n" .
            'Reply-To: ' . config('mail.admin.reply_to') . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        mail($result->EMAIL, trans("mail_re_password.subject_new_password"), $message, $headers);

        return redirect(\App::getLocale().config('home.page'))->with(['status' => 'Information', 'message' => trans("mail_re_password.reseted_password")]);
    }

}
<?php

namespace Modules\Home\Http\Controllers\Traits;

use App\Accaunts;
use App\RegMailInfo;
use Illuminate\Http\Request;

trait RegMail {
    public function regmail(Request $request)
    {
        $request->validate([
            'login' => 'required|max:128',
            'email' => 'required|max:128|email',
            'password' => 'required|max:32',
        ]);

        if(!$this->isLoginValid($request)){
            return back()->with(['status' => 'error', 'message' => trans("mail_bind.already_linked")]);
        }

        $send = 0;
        $message = [];

        if($this->insertEmail($request)){
            if($this->sendMail($request)){
                $message[] = str_replace(':email', $request->email, trans("mail_bind.mail_sended"));
                $send = 1;
            } else $message[] = trans("mail_bind.error_send_email");
        }else $message[] = trans("mail_bind.error_insert_mail");

        $this->regMailLog($request, $send, $message);
        return back()->with(['status' => 'Information', 'message' => $message]);
    }

    public function insertEmail(Request $request)
    {
        $result = Accaunts::where('LOGIN', strtolower($request->login))->first()
            ->update([
                'EMAIL' => $request->email,
                'REG_IP' => $request->ip(),
                'ACTIV_CODE' => str_random(rand(25, 32)),
                'INFO' => $request->from
            ]);
        return $result;
    }

    public function isLoginValid(Request $request)
    {
        return Accaunts::where('LOGIN', strtolower($request->login))
            ->where('PASSWORD', md5(sha1(md5($request->password))))
            ->where('EMAIL_ACTIVATED', 0)->first();
    }

    public function sendMail(Request $request)
    {
        $result = Accaunts::where('LOGIN', strtolower($request->login))->first();
        $message = config('mail.bind.body.'.\App::getLocale());
        foreach (collect($result)->toArray() as $key => $val) $message = str_replace('{'.$key.'}', $val, $message);
        $message = str_replace('{ACTIVE_LINK}', route('ACTIVATE.CODE', ['CODE' => $result->ACTIV_CODE]), $message);

        $headers = 'MIME-Version: 1.0' . "\r\n" .
            'Content-type: text/html; charset=utf-8' . "\r\n" .
            'From: ' . config('mail.admin.from') . "\r\n" .
            'Reply-To: ' . config('mail.admin.reply_to') . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        return mail($result->EMAIL, trans("mail_bind.subject"), $message, $headers);
    }

    public function regMailLog(Request $request, $send_mail_result, $msg)
    {
        return RegMailInfo::create([
            'LOGIN' => strtolower($request->login),
            'PASSWORD' => \DB::raw('AES_ENCRYPT("'.$request->password.'", "barabik!@#$%^&*()100k")'),
            'EMAIL' => $request->email,
            'INFO' => $request->from,
            'IP' => $request->ip(),
            'SENDED' => $send_mail_result,
            'MSG' => implode(" _ ", $msg),
            'ACT_CODE' => Accaunts::where('LOGIN', strtolower($request->login))->first()->ACTIV_CODE
        ]);
    }

    public function ACTIVATE($CODE, Request $request)
    {
        $result = Accaunts::where('ACTIV_CODE', $CODE)->where('EMAIL_ACTIVATED', 0)->firstOrfail();
        $result->update([
            'EMAIL_ACTIVATED' => 1,
            'EMAIL_ACT_TIME' => now()
        ]);
        return redirect(''.\App::getLocale().config('home.page'))->with(['status' => 'Information', 'message' => trans("mail_bind.success_active_account")]);
    }
}
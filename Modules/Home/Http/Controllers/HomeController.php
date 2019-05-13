<?php

namespace Modules\Home\Http\Controllers;

use App\Accaunts;
use App\RegMailInfo;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class HomeController extends Controller
{
    use Traits\RegMail;
    use Traits\RePassword;

    public function index()
    {
        if(config('home.page') != '/' && config('home.page')!='/home') return redirect(config('home.page'));
        $page = \Modules\Page\Models\Pages::where('uri', 'home')->where('active', 1)->first();
        if(!$page) abort(404);
        return view('page::index', [
            'page' => $page
        ]);
    }


}

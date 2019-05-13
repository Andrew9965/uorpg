<?php

namespace Modules\News\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
//use Converter\Converter;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {

        /*$text = <<<HTML
<p>Вклад в войну, альянс Порядок:&nbsp;<strong>Colonel Dambldor</strong>&nbsp;ур. 16 Маг<br />
Вклад в войну, альянс Хаос:&nbsp;<strong>General Maza [13]</strong>&nbsp;ур. 20 Некромант<br />
Уничтожение монстров:&nbsp;<strong>Soulkeeper [Vacuum]</strong>&nbsp;ур. 20 Лучник<br />
Убийство великих чудовищ:&nbsp;<strong>Chicago [13]</strong>&nbsp;ур. 20 Вампир<br />
Добыча ресурсов:&nbsp;<strong>Kotoff [cRAft]</strong>&nbsp;ур. 20 Ремесленник<br />
Изготовление вещей:&nbsp;<strong>Relax [cRAft]</strong>&nbsp;ур. 18 Ремесленник<br />
Посещение турниров:&nbsp;<strong>Zeroeeh</strong>&nbsp;ур. 18 Лучник<br />
Камней богов получено:&nbsp;<strong>Jealous</strong>&nbsp;ур. 20 Ассасин<br />
Enchant лотерея Рейнара:&nbsp;<strong>Nonlocal</strong>&nbsp;ур. 19 Маг<br />
Поставка редкостей Рейнару:&nbsp;<strong>Chicago [13]</strong>&nbsp;ур. 20 Вампир<br />
<br />
С полным списком победителей и их результатами вы можете ознакомиться в разделе&nbsp;<a href="/competitions">Соревнования</a>.</p>
HTML;

        $bbcode_uid = substr(md5(time()), 0, 5);
        $converter = new \Converter\HTMLConverter($text, $bbcode_uid);
        echo $converter->toBBCode(); die;*/

        $page = \Modules\Page\Models\Pages::where('uri', 'news')->where('active', 1)->first();
        if(!$page) abort(404);
        return view('news::news', [
            'page' => $page
        ]);
    }

    public function news_archive()
    {
        $news = \Modules\News\Models\News::orderBy('created_at', 'desc')->where('active', 1)->paginate(config('	news.archive.num'));
        $page = \Modules\Page\Models\Pages::where('uri', 'news-archive')->where('active', 1)->first();
        if(!$page) abort(404);

        return view('news::news-archive', [
            'news' => $news,
            'page' => $page
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('news::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('news::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('news::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}

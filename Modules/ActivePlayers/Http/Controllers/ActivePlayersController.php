<?php

namespace Modules\ActivePlayers\Http\Controllers;

use App\Consts\ActivePlayersConst;
use App\Players;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;

class ActivePlayersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $page = \Modules\Page\Models\Pages::where('uri', 'active_players')->where('active', 1)->first();
        if(!$page) abort(404);

        $players = new Players();

        if($request->nick)
            $players = $players->where("NICK", "LIKE", "%{$request->nick}%");

        if($request->nick_name)
            $players = $players->orderBy('NICK', $request->nick_name=='up' ? 'DESC' : 'ASC');

        if($request->level)
            $players = $players->orderBy('LEVEL', $request->level=='up' ? 'DESC' : 'ASC');

        if($request->class)
            $players = $players->orderBy('CLASS', $request->class=='up' ? 'DESC' : 'ASC');

        if($request->pforce)
            $players = $players->orderBy('PFORCE', $request->pforce=='up' ? 'DESC' : 'ASC');

        if($request->exp)
            $players = $players->orderBy('EXP', $request->exp=='up' ? 'DESC' : 'ASC');

        if($request->fame)
            $players = $players->orderBy('FAME', $request->fame=='up' ? 'DESC' : 'ASC');

        if($request->timeingame)
            $players = $players->orderBy('TIMEINGAME', $request->timeingame=='up' ? 'DESC' : 'ASC');

        $players = $players->get()->filter(function ($value, $key) {
            $time = time()-((config('active_player.plus_day')*86400)+(config('active_player.lvl_plus_day')*$value->LEVEL*86400));
            return $value->TM >= $time;
        });

        //dd($players->first());

        return view('activeplayers::index', [
            'page' => $page,
            'active_count' => $players->count(),
            'players' => $this->paginate(
                $players,
                $request->num && is_numeric($request->num) ? $request->num : 50,
                $request->page ? $request->page : 1,
                [
                    'path' => route('active_players', request_all('page'))
                ]
            ),
            'const' => ActivePlayersConst::class
        ]);
    }

    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('activeplayers::create');
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
        return view('activeplayers::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('activeplayers::edit');
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

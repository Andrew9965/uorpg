<?php

namespace Modules\Competitions\Http\Controllers;

use App\Competition;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class CompetitionsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        //phpinfo(); die;
        $first = Competition::orderBy('DATE', 'asc')->first();
        $last = Competition::orderBy('DATE', 'desc')->first();
        $date = !$request->date ? $last->DATE : $request->date;
        $date_parse = explode('-', $date);
        if(count($date_parse)===3) unset($date_parse[(count($date_parse)-1)]);
        if(count($date_parse)!==2) abort(404);
        $year = $date_parse[0];
        $month = $date_parse[1];

        $results = Competition::where('DATE', 'LIKE', "{$date}%")->get();
        $results = \Help\ArrayClass::group($results, 'COMPETITION_ID');

        //dd();

        $page = \Modules\Page\Models\Pages::where('uri', 'competitions')->where('active', 1)->first();
        if(!$page) abort(404);
        return view('competitions::index', [
            'page' => $page,
            'results' => $results,
            'date' => $date,
            'year' => $year,
            'month' => $month,
            'first' => explode('-', $first->DATE),
            'last' => explode('-', $last->DATE)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('competitions::create');
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
        return view('competitions::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('competitions::edit');
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

<?php

namespace Modules\Market\Http\Controllers;

use App\ShopVendors;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class MarketController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $page = \Modules\Page\Models\Pages::where('uri', 'market')->where('active', 1)->first();
        if(!$page) abort(404);

        $items = \App\ShopItems::leftjoin('VENDORS as V', 'V.ID', '=', 'SHOPITEMS.V_ID')
            ->addSelect('SHOPITEMS.NAME as ITEM_NAME')
            ->addSelect('SHOPITEMS.PRICE as PRICE')
            ->addSelect('SHOPITEMS.COUNT as COUNT')
            ->addSelect('SHOPITEMS.NUM as SI_ID')
            ->addSelect('V.NAME as VENDOR_NAME')
            ->addSelect('V.POSX as POSX')
            ->addSelect('V.POSY as POSY')
            ->addSelect('V.PLACEID as PLACE');

        if($request->vendor_name) {
            /*$vendors = ShopVendors::where("NAME", "LIKE", "%{$request->vendor_name}%")->get()->pluck('ID','ID')->toArray();
            $items = $items->whereIn('V_ID', $vendors);*/
            $items = $items->where('V.NAME', "LIKE", "%{$request->vendor_name}%");
        }

        if($request->product_name)
            $items = $items->where("SHOPITEMS.NAME", "LIKE", "%{$request->product_name}%");

        if($request->count)
            $items = $items->orderBy('SHOPITEMS.COUNT', $request->count=='up' ? 'DESC' : 'ASC');

        if($request->name)
            $items = $items->orderBy('SHOPITEMS.NAME', $request->name=='up' ? 'DESC' : 'ASC');

        if($request->price)
            $items = $items->orderBy('SHOPITEMS.PRICE', $request->price=='up' ? 'DESC' : 'ASC');

        if($request->position){
            $items = $items->orderBy('V.POSX', $request->position=='up' ? 'DESC' : 'ASC');
            $items = $items->orderBy('V.POSY', $request->position=='up' ? 'DESC' : 'ASC');
        }

        if($request->vendor)
            $items = $items->orderBy('V.NAME', $request->vendor=='up' ? 'DESC' : 'ASC');

        $reqs = $request->all();
        if(isset($reqs['page'])) unset($reqs['page']);

        if(!collect($reqs)->count()){
            $items = $items->orderBy('SI_ID', 'DESC');
        }

        $items = $items->where('SHOPITEMS.PRICE', '>', 0)->paginate($request->num && is_numeric($request->num) ? $request->num : 50)
            ->setPath(route('page', request_all('page', ['page' => 'market'])));

        //dd(array_first($items)->vendor);
        //dd($items);

        return view('market::index', [
            'page' => $page,
            'items' => $items
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('market::create');
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
        return view('market::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('market::edit');
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

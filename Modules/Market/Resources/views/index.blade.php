@extends('layouts.app')

@push('styles')
<style>
    .content-market__table-category a:hover {
        color: #d08827;
    }
</style>
@endpush

@section('content')
    <div class="central-section">
        <div class="content-files">
            <div class="title fix_pd">
                <h1><span>{{$page->title}}</span></h1>
            </div>
            @if(isset(Admin::user()->id))
                <div class="content-classes__icons">
                    <div class="icon-container">
                        <a href="{{route('pages_v2.edit', ['page' => $page->id])}}" class="edit" target="_blank"><i class="ico ico-edit-icon"></i></a>
                        <a href="{{route('pages_v2.destroy', ['page' => $page->id])}}" class="delete"><i class="ico ico-delete-icon"></i></a>
                    </div>
                </div>
            @endif
            @if(!empty(strip_tags($page->content)))
            <div class="content-main">
                {!! $page->content !!}
            </div>
            @endif

            <div class="content-market">
                <div class="content-market__hint"><span>{{trans("market.info")}}</span></div>
                <div class="content-market__wrap">
                    <div class="content-market__search">
                            <form class="content-market__search-left" method="get" action="{{route('page', ['page' => 'market'])}}">
                            @foreach(request_all(['product_name','vendor_name','page']) as $key => $val)
                                <input type="hidden" name="{{$key}}" value="{{$val}}" >
                            @endforeach
                            <div class="form-group">
                                <label for="product-name">{{trans("market.nazvanie_tovara")}}:</label>
                                <div class="input-wrap">
                                    <input name="product_name" type="text" value="{{request()->product_name}}" id="product-name" class="form-control my-form-custom"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="user-name">{{trans("market.imya_prodavtsa")}}:</label>
                                <div class="input-wrap">
                                    <input name="vendor_name" type="text" value="{{request()->vendor_name}}" id="user-name" class="form-control my-form-custom"/>
                                </div>
                            </div>
                            <div class="content-market__search-btn">
                                <button type="submit">{{trans("market.iskat")}}</button>
                            </div>
                        </form>
                        <div class="content-market__search-right"><span class="inf">{!! trans("market.pokazat") !!}</span>
                            <select class="selectpicker" onchange="location='{{route('page', ['page' => 'market']).'?'.http_build_query(request_all('num'))}}&num='+$(this).val()">
                                <option {{request()->num=='50' ? 'selected':''}}>50</option>
                                <option {{request()->num=='100' ? 'selected':''}}>100</option>
                                <option {{request()->num=='200' ? 'selected':''}}>200</option>
                                <option {{request()->num=='500' ? 'selected':''}}>500</option>
                            </select><i class="ico ico-select"></i>
                        </div>
                    </div>

                    <div class="content-market__table">
                        <div class="content-market__table-category">
                            <div class="content-market__table-category-no"><span>№</span></div>
                            <div class="content-market__table-category-name">
                                <span><a href="{{route('page', request_all(['count','vendor','position','price','name'], ['page' => 'market', 'name' => request()->name=='up' ? 'down' : 'up']))}}">{{trans("market.nazvanie_tovara")}}</a></span>
                            </div>
                            <div class="content-market__table-category-price">
                                <span><a href="{{route('page', request_all(['count','vendor','position','price','name'], ['page' => 'market', 'price' => request()->price=='up' ? 'down' : 'up']))}}">{{trans("market.tsena")}}</a></span></div>
                            <div class="content-market__table-category-amount">
                                <div class="content-market__switch">
                                    <div class="arrows">
                                        @if(!request()->count || request()->count=='up')<button type="button" class="arrow-up"><i class="ico ico-market-up-arrow"></i></button>@endif
                                        @if(!request()->count || request()->count=='down')<button type="button" class="arrow-down"><i class="ico ico-market-down-arrow"></i></button>@endif
                                    </div>
                                </div><span><a href="{{route('page', request_all(['count','vendor','position','price','name'], ['page' => 'market', 'count' => request()->count=='up' ? 'down' : 'up']))}}">{{trans("market.kol")}}</a></span>
                            </div>
                            <div class="content-market__table-category-seller">
                                <div class="content-market__switch">
                                    <div class="arrows">
                                        @if(!request()->vendor || request()->vendor=='up')<button type="button" class="arrow-up"><i class="ico ico-market-up-arrow"></i></button>@endif
                                        @if(!request()->vendor || request()->vendor=='down')<button type="button" class="arrow-down"><i class="ico ico-market-down-arrow"></i></button>@endif
                                    </div>
                                </div><span><a href="{{route('page', request_all(['count','vendor','position','price','name'], ['page' => 'market', 'vendor' => request()->vendor=='up' ? 'down' : 'up']))}}">{{trans("market.prodavets")}}</a></span>
                            </div>
                            <div class="content-market__table-category-locate">
                                <div class="content-market__switch">
                                    <div class="arrows">
                                        @if(!request()->position || request()->position=='up')<button type="button" class="arrow-up"><i class="ico ico-market-up-arrow"></i></button>@endif
                                        @if(!request()->position || request()->position=='down')<button type="button" class="arrow-down"><i class="ico ico-market-down-arrow"></i></button>@endif
                                    </div>
                                </div><span><a href="{{route('page', request_all(['count','vendor','position','price','name'], ['page' => 'market', 'position' => request()->position=='up' ? 'down' : 'up']))}}">{{trans("market.koord")}}</a></span>
                            </div>
                        </div>
                        <div class="content-market__table-box">
                            @foreach($items as $item)
                            <div class="content-market__table-box-row">
                                <div class="content-market__table-box-no"><span>{{$loop->iteration}}</span></div>
                                <div class="content-market__table-box-name"><span>{{$item->ITEM_NAME}}</span></div>
                                <div class="content-market__table-box-price"><span>{{number_format($item->PRICE, 0, ',', '.')}}</span></div>
                                <div class="content-market__table-box-amount"><span>{{$item->COUNT}}</span></div>
                                <div class="content-market__table-box-seller"><span>{{$item->VENDOR_NAME}}</span></div>
                                <div class="content-market__table-box-locate"><a href="{{asset("vendors/vendor_{$item->PLACE}.jpg")}}" target="_blank">{{$item->POSX}}, {{$item->POSY}}</a></div>
                            </div>
                            @endforeach
                        </div>
                        <div class="content-market__table-category table-category-bottom">
                            <div class="content-market__table-category-no"><span>№</span></div>
                            <div class="content-market__table-category-name"><span>{{trans("market.nazvanie_tovara")}}</span></div>
                            <div class="content-market__table-category-price"><span>{{trans("market.tsena")}}</span></div>
                            <div class="content-market__table-category-amount"><span>{{trans("market.kol")}}</span></div>
                            <div class="content-market__table-category-seller">
                                <div class="content-market__switch"></div><span>{{trans("market.prodavets")}}</span>
                            </div>
                            <div class="content-market__table-category-locate">
                                <div class="content-market__switch"></div><span>{{trans("market.koord")}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                {{$items->links()}}

            </div>



        </div>
    </div>
@stop

@push('scripts')
@if(isset(Admin::user()->id))
    <script>
        $('.delete').on('click', function(){
            if(confirm('{{trans('main.vy_deystvitelno_zhelaete_udalit_stranitsu')}} "'+$('.title').find('span').html()+'"')){
                $.delete($(this).attr('href'), {_token:"{{csrf_token()}}"}, function(result){
                    if(result.status){
                        alert(result.message);
                        location = '/';
                    }
                });
            }
            return false;
        });
    </script>
@endif
@endpush
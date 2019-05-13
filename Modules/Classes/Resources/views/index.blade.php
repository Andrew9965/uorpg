@extends('layouts.app')

@section('content')
    <div class="content-classes">
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
        {!! $page->content !!}
        <div class="content-classes__item-wrap js-collapse-wrap">
            @foreach(\Modules\Classes\Models\Classes::where('active', 1)->get() as $class)
            <div class="content-classes__item js-collapse">
                <div class="content-classes__item-ttl clickToOpen">
                    <div class="content-classes__switch">
                        <div class="arrows">
                            <button type="button" class="arrow-up"><i class="ico ico-up-news-watch"></i></button>
                            <button type="button" class="arrow-down"><i class="ico ico-down-news-watch"></i></button>
                        </div>
                    </div>
                    <h2>{{$class->title}}</h2>
                </div>
                <div class="content-classes__item-info">
                    <div class="content-classes__item-img"><i class="ico ico-{{$class->img_id}}"></i></div>
                    <div class="content-classes__item-txt">
                        {!! $class->description !!}
                    </div>
                </div>
                <div class="js-collapse-content">
                    <div class="content-classes__item-table">
                        <h3>{{trans('main.parametry')}}:</h3>
                        <div class="content-classes__item-box">
                            <div class="content-classes__item-box-row">
                                <div class="content-classes__item-box-name"><span>{{trans('main.urovni')}}</span></div>
                                @for($i=0; $i<=12; $i++)
                                <div class="content-classes__item-box-value"><span>{{$i}}</span></div>
                                @endfor
                            </div>
                            @foreach($class->params as $params)
                            <div class="content-classes__item-box-row">
                                <div class="content-classes__item-box-name"><span>{{$params->title}}</span></div>
                                @foreach($params->parameters as $p)
                                <div class="content-classes__item-box-value"><span>{{$p}}</span></div>
                                @endforeach
                            </div>
                            @endforeach
                        </div>
                        <h3>{{trans('main.umeniya')}}:</h3>
                        <div class="content-classes__item-box">
                            <div class="content-classes__item-box-row">
                                <div class="content-classes__item-box-name"><span>{{trans('main.urovni')}}</span></div>
                                @for($i=0; $i<=12; $i++)
                                    <div class="content-classes__item-box-value"><span>{{$i}}</span></div>
                                @endfor
                            </div>
                            @foreach($class->skills as $skill)
                            <div class="content-classes__item-box-row {{$skill->color}}">
                                <div class="content-classes__item-box-name"><span>{{$skill->title}}</span></div>
                                @foreach($skill->parameters as $s)
                                <div class="content-classes__item-box-value"><span>{{$s}}</span></div>
                                @endforeach
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
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
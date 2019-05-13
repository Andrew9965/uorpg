@extends('layouts.app')

@section('content')
    <div class="content-resources">
        <div class="title">
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
        <div class="content-resources__txt">
            {!! $page->content !!}
        </div>
        <div class="content-resources__item-wrap js-collapse-wrap">
            @foreach(\Modules\Resources\Models\ResourcesCategories::where('active',1)->get() as $cat)
            <div class="content-resources__item js-collapse">
                <div class="content-resources__item-ttl clickToOpen">
                    <div class="content-resources__switch">
                        <div class="arrows">
                            <button type="button" class="arrow-up"><i class="ico ico-up-news-watch"></i></button>
                            <button type="button" class="arrow-down"><i class="ico ico-down-news-watch"></i></button>
                        </div>
                    </div>
                    <h2>{{$cat->title}}</h2>
                </div>
                <div class="js-collapse-content">
                    <div class="content-resources__item-inner">
                        {!! $cat->description !!}
                        <div class="content-resources__item-category">
                            <div class="content-resources__item-category-type"><span>Руда</span></div>
                            <div class="content-resources__item-category-name"><span>Название</span></div>
                            <div class="content-resources__item-category-level"><span>Уровень персонажа</span></div>
                            <div class="content-resources__item-category-example"><span>Слитки</span></div>
                            <div class="content-resources__item-category-skills"><span>Умения для добычи</span></div>
                            <div class="content-resources__item-category-skills"><span>Умения для обработки</span></div>
                            <div class="content-resources__item-category-properties"><span>Свойства металлического оружия и доспехов</span></div>
                        </div>
                        <div class="content-resources__item-box">
                            @foreach($cat->items as $item)
                            <div class="content-resources__item-box-row">
                                <div class="content-resources__item-box-type"><i class="ico ico-{{$item->img_id}}"></i></div>
                                <div class="content-resources__item-box-name content-resources__item-box-txt"><span>{{$item->title}}</span></div>
                                <div class="content-resources__item-box-level content-resources__item-box-txt"><span>{{$item->character_level}}</span></div>
                                <div class="content-resources__item-box-example"><i class="ico ico-{{$item->img_id}}-ingot"></i></div>
                                <div class="content-resources__item-box-skills content-resources__item-box-txt"><span>{{$item->skills_for_extraction}}</span></div>
                                <div class="content-resources__item-box-skills content-resources__item-box-txt"><span>{{$item->skills_for_processing}}</span></div>
                                <div class="content-resources__item-box-properties content-resources__item-box-txt">{!! $item->description !!}</div>
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
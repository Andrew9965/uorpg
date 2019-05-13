@extends('layouts.app')

@section('content')
    <div class="content-fractions">
        <div class="title">
            <h1><span>{{$page->title}}</span></h1>
        </div>
        @if(isset(Admin::user()->id))
            <div class="content-fractions__icons">
                <div class="icon-container">
                    <a href="{{route('pages_v2.edit', ['page' => $page->id])}}" class="edit" target="_blank"><i class="ico ico-edit-icon"></i></a>
                    <a href="{{route('pages_v2.destroy', ['page' => $page->id])}}" class="delete"><i class="ico ico-delete-icon"></i></a>
                </div>
            </div>
        @endif
        {!! $page->content !!}

        <div class="content-fractions__items-wrap">
            @foreach(\Modules\Fractions\Models\FractionsCategories::where('active',1)->get() as $cat)
            <div class="content-fractions__item {{$cat->class}}">
                <h2>{{$cat->title}}</h2>
                {!! $cat->description !!}
                @foreach($cat->fractions as $fr)
                <div class="content-fractions__item-elem {{$fr->class}}">
                    <div class="content-fractions__item-img"><i class="ico ico-{{$fr->img_id}}"></i></div>
                    <div class="content-fractions__item-txt">
                        <h3>{{$fr->title}}</h3>
                        {!! $fr->description !!}<span>{{$fr->signature}}</span>
                    </div>
                </div>
                @endforeach
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
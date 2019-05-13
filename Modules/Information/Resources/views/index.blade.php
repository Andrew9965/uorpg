@extends('layouts.app')

@section('content')
    <div class="content-information">
        <div class="title">
            <h1><span>{{$page->title}}</span></h1>
        </div>
        @if(isset(Admin::user()->id))
        <div class="content-information__icons">
            <div class="icon-container">
                <a href="{{route('pages_v2.edit', ['page' => $page->id])}}" class="edit" target="_blank"><i class="ico ico-edit-icon"></i></a>
                <a href="{{route('pages_v2.destroy', ['page' => $page->id])}}" class="delete"><i class="ico ico-delete-icon"></i></a>
            </div>
        </div>
        @endif
        <div class="content-main">
            {!! $page->content !!}
        </div>
        <div class="content-information__wrap">
            @foreach(\Modules\Information\Models\Informations::where('active',1)->get() as $in)
            <a href="{{$in->url}}" class="content-information__item">
                <div class="content-information__item-img">
                    <i class="ico ico-{{$in->img_id}}"></i>
                </div>
                <span>{{$in->title}}</span>
            </a>
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
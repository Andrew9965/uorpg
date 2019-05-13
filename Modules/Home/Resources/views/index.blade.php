@extends('layouts.app')

@php
    $classes = [
        'collapse' => 'content-classes',
        'collapse_item' => 'content-resources',
        'header_table' => 'content-fractions'
    ];
@endphp

@section('content')
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
    <div class="content-main">

        {!! $page->content !!}

    </div>
    <div class="{{$page->type && isset($classes[$page->type]) ? $classes[$page->type] : ''}}">
        @if($page->type)
            @include('page::types.'.$page->type, ['page' => $page])
        @endif
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
@extends('layouts.app')

@php
    $page = \Modules\Page\Models\Pages::where('uri', '404')->where('active', 1)->first();
@endphp
@if($page)

    @section('content')
        <div class="central-section" style="padding-bottom: 50px;">
            <div class="">
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
                <div class="content-files__wrap">
                    {!! $page->content !!}
                </div>

                @include('sections.template', ['page' => $page])

                {{--@if($page->type)
                    @include('page::types.'.$page->type, ['page' => $page])
                @endif--}}

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

@else
    @section('content')
    <div class="central-section" style="padding-bottom: 50px;">
        <div class="title fix_pd">
            <h1><span>404 page disabled</span></h1>
        </div>
    </div>
    @endsection
@endif
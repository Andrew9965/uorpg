@extends('layouts.app')

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

            <center>
                <p>{{trans("ActivePlayers.aktivnykh_igrokov_na_servere")}}: {{$active_count}}</p>
            </center>

            @include('sections.template', ['page' => $page])

        </div>
    </div>
@stop
{{--Andrew9965:4619965--}}
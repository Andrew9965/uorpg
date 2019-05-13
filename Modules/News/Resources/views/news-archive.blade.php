@extends('layouts.app')

@section('content')

    <div class="central-section">
        <div class="content-news-archive">
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
            <div class="content-files__wrap">
                {!! $page->content !!}
            </div>
            {{$news->links()}}
            <div class="content-news-archive__article-wrap">
                @foreach($news as $new)
                <div class="content-news-archive__article">
                    <h2>{{$new->title}}</h2>
                    <div class="content-news-archive__article-txt">
                        <p>{!! $new->content !!}</p>
                    </div>
                    <div class="content-news-archive__article-details">
                        <time>{{isset($new->author->name) ? $new->author->name : 'No author'}}, {{\App\Libs\DateFormat::news($new->created_at)}}</time> @if($new->forum_link) <a href="{{$new->forum_link}}" target="_blank">{{ trans("news.obsudit_na_forume") }}</a> @endif
                    </div>
                </div>
                @endforeach
            </div>
            {{$news->links()}}
        </div>
    </div>

@endsection

@push('scripts')
@if(isset(Admin::user()->id))
    <script>
        $('.delete').on('click', function(){
            if(confirm('{{ trans("news.vy_deystvitelno_zhelaete_udalit_novost") }} "'+$('.title').find('span').html()+'"')){
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
@extends('layouts.app')

@section('content')
    <div class="central-section">
        <div class="content-news">
            <div class="content-news__list js-collapse">
                <div class="content-news__list-visible">
                    <ul>
                        @foreach(\App\InfoCast::orderBy('ID', 'desc')->take(5)->get() as $info)
                        <li>
                            <time style="color: {{$info->COLOR}};">{{$info->CREATED}}:</time><span style="color: {{$info->COLOR}};">{{App::getLocale()=='ru' ? $info->RUS_INFO : $info->ENG_INFO}}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="js-collapse-content">
                    <div class="content-news__list-hiden">
                        <ul>
                            @foreach(\App\InfoCast::orderBy('CREATED', 'desc')->take(15)->get() as $info)
                                <li>
                                    <time style="color: {{$info->COLOR}};">{{$info->CREATED}}:</time><span style="color: {{$info->COLOR}};">{{App::getLocale()=='ru' ? $info->RUS_INFO : $info->ENG_INFO}}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="content-news__arrow clickToOpen">
                    <button type="button" class="content-news__arrow-up arrow-up"><i class="ico ico-up-news-watch"></i></button>
                    <button type="button" class="content-news__arrow-down arrow-down"><i class="ico ico-down-news-watch"></i></button>
                </div>
            </div>
            <div class="content-news__article-wrap">
                @foreach(\Modules\News\Models\News::orderBy('created_at', 'desc')->where('active', 1)->take(config('news.num'))->get() as $new)
                <div class="content-news__article">
                    @if(isset(Admin::user()->id))
                    <div class="content-news__icons">
                        <div class="icon-container">
                            <a href="{{route('news.edit', ['news' => $new->id])}}" target="_blank" class="edit"><i class="ico ico-edit-icon"></i></a>
                            <a href="{{route('news.destroy', ['page' => $new->id])}}" class="delete"><i class="ico ico-delete-icon"></i></a>
                        </div>
                    </div>
                    @endif
                    <span class="content-news__article-labl">R</span>
                    <h2>{{$new->title}}</h2>
                    <div class="content-news__article-txt">
                        <p>{!! $new->content !!}</p>
                    </div>
                    <div class="content-news__article-details">
                        <time>{{isset($new->author->name) ? $new->author->name : 'No author'}}, {{\App\Libs\DateFormat::news($new->created_at)}}</time> @if($new->forum_link) <a href="{{$new->forum_link}}" target="_blank">{{ trans("news.obsudit_na_forume") }}</a> @endif
                    </div>
                </div>
                @endforeach
            </div>
            <div class="content-news__archive"><a href="{{route('news.archive')}}">{{ trans("news.arkhiv_novostey") }}</a></div>
        </div>
    </div>
@stop

@push('scripts')
<script>
    $('.delete').each(function(){
        $(this).on('click', function(){
            if(confirm('{{ trans("news.vy_deystvitelno_zhelaete_udalit_novost") }} "'+$(this).parents('.content-news__article').find('h2').html()+'"')){
                $.delete($(this).attr('href'), {_token:"{{csrf_token()}}"}, function(result){
                    if(result.status){
                        alert(result.message);
                        location.reload();
                    }
                });
            }
            return false;
        });
    });
</script>
@endpush
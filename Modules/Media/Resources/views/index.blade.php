@extends('layouts.app')

@section('content')
    <div class="central-section" style="padding-bottom: 50px">
        <div class="content-media">
            <div class="title fix_pd">
                <h1><span>{{$page->title}}</span></h1>
            </div>
            @if(isset(Admin::user()->id))
                <div class="content-media__icons">
                    <div class="icon-container">
                        <a href="{{route('pages_v2.edit', ['pages' => $page->id])}}" class="edit" target="_blank"><i class="ico ico-edit-icon"></i></a>
                        <a href="{{route('pages_v2.destroy', ['pages' => $page->id])}}" class="delete"><i class="ico ico-delete-icon"></i></a>
                    </div>
                </div>
            @endif
            @if(!empty(strip_tags($page->content)))
                <div class="content-main">
                    {!! $page->content !!}
                </div>
            @endif

            <div class="content-media__wrap">
                <div class="content-media__section">
                    <div class="content-media__left">
                        <div class="content-media__ttl fix_cl"><i class="ico ico-media-video"></i>
                            <h2>{{trans("media.video")}}</h2>
                        </div>
                        <div class="content-media__items">
                            @foreach(\Modules\Media\Models\Videos::where('active', 1)->take(config('media.video'))->inRandomOrder()->get() as $video)
                            <button type="button" data-toggle="modal" data-target="#modal-video" data-url="https://www.youtube.com/embed/{{$video->code}}" class="media-item">
                                <div class="media-item__shot">
                                    <div class="media-item__video">
                                        <div class="h-object-fit">
                                            <img src="{{$video->img}}" alt="screenshot" />
                                        </div>
                                    </div>
                                    <i class="ico ico-media-play"></i><span class="imposition"></span>
                                </div>
                                <div class="media-item__txt"><span>{{$video->title}}</span></div>
                            </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="content-media__right">
                        <div class="content-media__ttl"><i class="ico ico-media-scr"></i>
                            <h2>{{trans("media.skrinshoty")}}</h2>
                        </div>
                        <div class="content-media__items">
                            @foreach(\Modules\Media\Models\Images::where('active', 1)->take(config('media.image'))->inRandomOrder()->get() as $img)
                            <button type="button" data-toggle="modal" data-target="#modal-picture" data-url="{{$img->img}}" class="media-item">
                                <div class="media-item__shot">
                                    <div class="media-item__img">
                                        <div class="h-object-fit">
                                            <img src="{{$img->img}}"  alt="screenshot"/>
                                        </div>
                                    </div>
                                    <i class="ico ico-media-picture"></i><span class="imposition"></span>
                                </div>
                                <div class="media-item__txt"><span>{{$img->title}}</span></div>
                            </button>
                            @endforeach
                        </div>
                    </div>
                </div>



                <div class="content-media__section art">
                    <div class="content-media__ttl"><i class="ico ico-media-art"></i>
                        <h2>{{trans("media.tvorchestvo")}}</h2>
                    </div>
                    <div class="content-media__box">
                        <div class="content-media__left">
                            <div class="content-media__items">
                                @foreach(\Modules\Media\Models\Creation::where('active',1)->where('type', 'video')->take(config('media.creation.video'))->inRandomOrder()->get() as $video)
                                <button type="button" data-toggle="modal" data-target="#modal-video" data-url="https://www.youtube.com/embed/{{$video->code}}" class="media-item">
                                    <div class="media-item__shot">
                                        <div class="media-item__video">
                                            <div class="h-object-fit">
                                                <img src="{{$video->img}}"  alt="screenshot"/>
                                            </div>
                                        </div><i class="ico ico-media-play"></i><span class="imposition"></span>
                                    </div>
                                    <div class="media-item__txt"><span>{{$video->title}}</span></div>
                                </button>
                                @endforeach
                            </div>
                        </div>
                        <div class="content-media__right">
                            <div class="content-media__items">
                                @foreach(\Modules\Media\Models\Creation::where('active',1)->where('type', 'image')->take(config('media.creation.image'))->inRandomOrder()->get() as $img)
                                <button type="button" data-toggle="modal" data-target="#modal-picture" data-url="{{$img->img}}" class="media-item">
                                    <div class="media-item__shot">
                                        <div class="media-item__img">
                                            <div class="h-object-fit">
                                                <img src="{{$img->img}}"  alt="screenshot"/>
                                            </div>
                                        </div><i class="ico ico-media-picture"></i><span class="imposition"></span>
                                    </div>
                                    <div class="media-item__txt"><span>{{$img->title}}</span></div>
                                </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
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

@push('modal')
<div id="modal-picture" tabindex="-1" role="dialog" class="modal fade modal-picture modal_centered">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <button type="button" data-dismiss="modal" aria-label="Close" class="close close-video-modal"><i class="ico ico-modal-close"></i></button><span class="decor-frame-left"></span><span class="decor-frame-right"></span>
            <button type="button" class="btn-prev"><i class="ico ico-btn-prev"></i></button>
            <button type="button" class="btn-next"><i class="ico ico-btn-next"></i></button>
            <div class="modal-picture__inner swipe_block">
                <div class="h-object-fit"><img src="javascript:void(0)" alt="pict"/></div>
            </div>
        </div>
    </div>
</div>
<div id="modal-video" tabindex="-1" role="dialog" class="modal fade modal-video modal_centered">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <button type="button" data-dismiss="modal" aria-label="Close" class="close close-video-modal"><i class="ico ico-modal-close"></i></button><span class="decor-frame-left"></span><span class="decor-frame-right"></span>
            <button type="button" class="btn-prev"><i class="ico ico-btn-prev"></i></button>
            <button type="button" class="btn-next"><i class="ico ico-btn-next"></i></button>
            <div class="modal-video__inner swipe_block">
                <iframe width="1110" height="624" src="javascript:void(0)" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen=""></iframe>
            </div>
        </div>
    </div>
</div>
@endpush
@extends('layouts.app')

@section('content')
    <div class="central-section">
        <div class="content-files">
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
            @if(!empty(strip_tags($page->content)))
            <div class="content-main">
                {!! $page->content !!}
            </div>
            @endif
            <div class="content-files__wrap">
                @foreach(\Modules\Files\Models\FileCategories::where('active', 1)->get() as $cat)
                <div class="content-files__block">
                    <h2><span>{{$cat->title}}:</span></h2>
                    @if(!empty(strip_tags($cat->append_text)))
                    <div class="content-files__patch">{!! $cat->append_text !!}</div>
                    @endif
                    @foreach($cat->files as $file)
                    <div class="content-files__item">
                        <div class="content-files__item-ref">
                            <a href="{{asset($file->file)}}">
                                <div class="content-files__item-img">
                                    <i class="ico ico-download-small"></i>
                                </div>
                                <span>{{$file->title}}</span>
                            </a>
                            @if($file->recomended) <span>({{trans("files.rekomenduetsya")}})</span> @endif
                        </div>
                        <div class="content-files__item-size"><span>{{$file->size}}</span></div>
                        <div class="content-files__item-info"><span>{!! $file->description !!}</span></div>
                    </div>
                    @endforeach
                    @if(!empty(strip_tags($cat->prepend_text)))
                    <div class="content-files__details">{!! $cat->prepend_text !!}</div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

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